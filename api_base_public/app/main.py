from fastapi import FastAPI
from app.models.n_question import NQuestion
from fastapi.middleware.cors import CORSMiddleware
from fastapi import FastAPI, UploadFile, File, Form, HTTPException, BackgroundTasks, Request
from app.security.security import get_api_key
from fastapi.responses import JSONResponse
from .files_chat_agent import FilesChatAgent
import os
from datetime import datetime
import time
import uuid
import asyncio
from typing import Dict
from pathlib import Path
import shutil
# Tạo instance của FastAPI
app = FastAPI()

# Cấu hình CORS
app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],  # Cho phép tất cả nguồn (hoặc chỉ định danh sách ["http://example.com"])
    allow_credentials=True,
    allow_methods=["*"],  # Cho phép tất cả phương thức (GET, POST, PUT, DELETE, v.v.)
    allow_headers=["*"],  # Cho phép tất cả headers
)

# Include các router vào ứng dụng chính
# app.include_router(base.router)
# app.include_router(file_upload.router)

tasks: Dict[str, Dict] = {}

@app.get("/")
def read_root():    
    return {"message": "Welcome to my FastAPI application"}   


@app.exception_handler(422)
async def validation_exception_handler(request: Request, exc):
    print(exc.errors())
    return JSONResponse(
        status_code=422,
        content={"message": "Validation error", "errors": exc.errors()}
    )

async def handle_question_task(temp_file_path, task_id: str, file: UploadFile, model: str, nquestion_json: str, token: int, log_file_path, start_time):
    try:
        
        agent = FilesChatAgent(temp_file_path, nquestion_json, model, log_file_path, token)
        questions = await agent.get_lst_question()
        tasks[task_id]["status"] = "done"
        end_time = time.time()
        execution_time_seconds = end_time - start_time
        minutes = execution_time_seconds // 60  # Get the whole minutes
        seconds = execution_time_seconds % 60  # Get the remaining seconds

        write_log(log_file_path,f"Execution Time: {int(minutes)} minutes and {seconds:.2f} seconds")
        tasks[task_id]["result"] = questions
    except Exception as e:
        tasks[task_id]["status"] = "error"
        tasks[task_id]["result"] = str(e)


@app.get("/question/result/{task_id}")
def get_question_result(task_id: str):  
    if task_id not in tasks:
        raise HTTPException(status_code=404, detail="Task ID không tồn tại.")
    return tasks[task_id]


@app.post("/question/create", summary="Route này dùng để tạo câu hỏi")
async def create_question(
    token: int = Form(...),
    model: str = Form(...),
    file: UploadFile = File(...),
    Nquestion_json: str = Form(...),
    api_key: str = (get_api_key),
):
    """
    Route này dùng để tạo câu hỏi\n
    **Parameters**
    - **file**: File giáo trình để ai dựa vào tạo câu hỏi
    - **Nquestion_json**: Số lượng câu hỏi cho từng cấp độ
    - **api_key**: key xác thực 
    - **model**: tên model ai tạo câu hỏi
    - **token**: số token hiện tại của user

    **Returns:**
    - Danh sách câu hỏi:
    [{question:Nội dung câu hỏi,
    options: Danh sách 4 đáp án,
    answer: Đáp án đúng,
    level: Cấp độ Bloom's taxonomy},
    {},
    ....
    ]
    """
    start_time = time.time()
    Nquestion = NQuestion.model_validate_json(Nquestion_json)
    
    n_question = {
    "remember": Nquestion.remember,
    "understand": Nquestion.understand,
    "apply": Nquestion.apply,
    "analyze": Nquestion.analyze,
    "evaluate": Nquestion.evaluate,
    "create": Nquestion.create,
    }
    # Check file type
    if file.content_type not in [
    "application/pdf",
    "application/vnd.openxmlformats-officedocument.wordprocessingml.document",  # .docx
    "text/plain"  # .txt
    ]:
        raise HTTPException(status_code=400, detail="Unsupported file type.")

    log_file_path=save_log_file(file)
    # agent = FilesChatAgent(file, n_question, model, log_file_path, token)
    # questions = await agent.get_lst_question()


     # 🔽 Lưu file ngay lập tức để dùng lại sau
    temp_folder = Path("temp_uploads")
    temp_folder.mkdir(exist_ok=True)
    temp_file_path = temp_folder / f"{uuid.uuid4()}_{file.filename}"

    with temp_file_path.open("wb") as buffer:
        shutil.copyfileobj(file.file, buffer)
    task_id = str(uuid.uuid4())
    tasks[task_id] = {"status": "processing", "result": None}

    asyncio.create_task(handle_question_task(temp_file_path,task_id, file, model, n_question, token, log_file_path, start_time))
    # end_time = time.time()
    # execution_time_seconds = end_time - start_time
    # minutes = execution_time_seconds // 60  # Get the whole minutes
    # seconds = execution_time_seconds % 60  # Get the remaining seconds

    #write_log(log_file_path,f"Execution Time: {int(minutes)} minutes and {seconds:.2f} seconds")
    return {"task_id": task_id}
    

@app.put("/update-api-key", summary="Route này dùng để thay đổi key api")
async def update_api_key(
    model_name: str, 
    api_key: str
):
    """
   Route này dùng để thay đổi api key của các model ai\n
    **Parameters**
    - **model_name**: tên công ty cung cấp ai model ('openai', 'google' hoặc 'xai')
    - **api_key**: api key được thay đổi cho model bên trên

    **Returns:**
    {status_code: trạng thái code,
    message: tin nhắn}s
    """
    model_name=model_name.lower()
    key = ""
    
    if model_name == 'openai':
        key = "KEY_API_GPT"
    elif model_name == 'google':
        key = "KEY_API_GEMINI"
    elif model_name == 'xai':
        key = "KEY_API_GROK"
    else:
        return JSONResponse(
            status_code=400,
            content={"message": "model_name không hợp lệ!"}
        )

    lines = []
    found = False
    try:
        with open('.env', 'r', encoding='utf-8') as file:
            for line in file:
                # So sánh tên biến đã strip, bỏ qua dấu cách
                if line.strip().split('=')[0] == key:
                    lines.append(f'{key}={api_key}\n')
                    found = True
                else:
                    lines.append(line)
    except FileNotFoundError:
        pass

    if not found:
        lines.append(f'{key}={api_key}\n')
    with open('.env', 'w', encoding='utf-8') as file:
        file.writelines(lines)

    return JSONResponse(
        status_code=200,
        content={"message": "Đổi api key thành công"}
    )

def save_log_file(file: UploadFile):
    # Tạo thư mục log nếu chưa có
    log_dir = "log"
    os.makedirs(log_dir, exist_ok=True)

    # Lấy tên file gốc và loại bỏ phần mở rộng
    base_filename = os.path.splitext(file.filename)[0]

    # Lấy thời gian hiện tại định dạng YYYYMMDD_HHMMSS
    timestamp = datetime.now().strftime("%Y%m%d_%H%M%S")

    # Tạo tên file log
    log_filename = f"{base_filename}_{timestamp}.txt"

    # Đường dẫn đầy đủ
    log_path = os.path.join(log_dir, log_filename)

    # Ghi một nội dung mẫu (bạn có thể thay thế bằng nội dung thực tế)
    with open(log_path, "w", encoding="utf-8") as f:
        f.write(f"Log created at {timestamp} for file: {file.filename}\n")

    return log_path

def write_log(log_file_path, content):
        with open(log_file_path, "a", encoding="utf-8") as f:
            f.write(content + "\n")