from fastapi import FastAPI, UploadFile, File, Form, HTTPException, BackgroundTasks
from fastapi.middleware.cors import CORSMiddleware
from fastapi.responses import JSONResponse

from app.models.n_question import NQuestion
from app.security.security import get_api_key
from .files_chat_agent import FilesChatAgent

from llm.llm_suggest_question.llm import LLM_SUGGEST_NUMBER_QUESTION
from llm.llm_suggest_question.suggest_number_question_template import SuggestNumberQuestion

from langchain_community.document_loaders import PyMuPDFLoader, UnstructuredWordDocumentLoader, TextLoader

from pathlib import Path
from datetime import datetime
import uuid
import time
import asyncio
import os

app = FastAPI()

# Cấu hình CORS
app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

# Dictionary lưu task_id
tasks: dict[str, dict] = {}

@app.get("/")
async def read_root():
    return {"message": "Welcome to my FastAPI application"}

@app.get("/question/result/{task_id}")
async def get_question_result(task_id: str):
    task_data = tasks.get(task_id)
    if not task_data:
        raise HTTPException(status_code=404, detail="Task ID không tồn tại.")

    response = {
        "status": task_data["status"],
        "result": task_data["result"],
        "current_number_question": task_data.get("current_number_question", 0)
    }

    if task_data["status"] == "done":
        del tasks[task_id]  # cleanup

    return response

@app.get("/question/suggest-number-question/{number_question}")
async def get_suggest_number_question(number_question: int):
    print(f"So luong cau hoi: {number_question}")
    llm_SuggestNumberQuestion = SuggestNumberQuestion(LLM_SUGGEST_NUMBER_QUESTION().get_llm('gpt')).get_chain()
    input_data = {
        "number_question": number_question 
    }
    result = llm_SuggestNumberQuestion.invoke(input_data)
    return result

@app.post("/question/create")
async def create_question(
    token: int = Form(...),
    model: str = Form(...),
    file: UploadFile = File(...),
    Nquestion_json: str = Form(...),
):
    try:
        print("[DEBUG] Start create_question")
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

        # Save uploaded file
        temp_folder = Path("temp_uploads")
        temp_folder.mkdir(exist_ok=True)
        temp_file_path = temp_folder / f"{uuid.uuid4()}_{file.filename}"
        file_content = await file.read()
        with open(temp_file_path, "wb") as f:
            f.write(file_content)
        await file.close()
        print(f"[DEBUG] File saved at: {temp_file_path}")

        # Load documents
        ext = temp_file_path.suffix.lower()[1:]
        if ext == "pdf":
            loader = PyMuPDFLoader(str(temp_file_path))
        elif ext == "docx":
            loader = UnstructuredWordDocumentLoader(str(temp_file_path))
        elif ext == "txt":
            loader = TextLoader(str(temp_file_path), encoding="utf-8")
        else:
            raise HTTPException(status_code=400, detail="Unsupported file extension")

        documents = loader.load()
        print(f"[DEBUG] Loaded {len(documents)} documents")

        log_file_path = save_log_file(file.filename)
        task_id = str(uuid.uuid4())
        tasks[task_id] = {"status": "processing", "result": None, "current_number_question": 0}
        task_ref = tasks[task_id]
    
        asyncio.create_task(
            handle_question_task(documents, task_id, model, n_question, token, log_file_path, start_time, temp_file_path, task_ref)
        )

        return {"task_id": task_id, "status": "processing",  "current_number_question": 0}

    except Exception as e:
        print("[ERROR] Exception occurred:", str(e))
        return JSONResponse(status_code=500, content={"error": str(e)})


async def handle_question_task(doc, task_id: str, model: str, nquestion_json: dict, token: int, log_file_path: str, start_time: float, temp_file_path, task):
    try:
        # agent = FilesChatAgent(doc, nquestion_json, model, log_file_path, token)
        # questions = agent.get_lst_question()
        def blocking():
            agent = FilesChatAgent(doc, nquestion_json, model, log_file_path, token, task)
            return agent.get_lst_question()

        loop = asyncio.get_event_loop()
        questions = await loop.run_in_executor(None, blocking)
        tasks[task_id]["status"] = "done"
        tasks[task_id]["result"] = questions
        print(f"Finish")
        end_time = time.time()
        duration = end_time - start_time
        write_log(log_file_path, f"Execution Time: {int(duration // 60)}m {duration % 60:.2f}s")
    except Exception as e:
        tasks[task_id]["status"] = "error"
        tasks[task_id]["result"] = str(e)
        write_log(log_file_path, f"[ERROR] {str(e)}")
    finally:
        try:
            os.remove(temp_file_path)
            print(f"[DEBUG] Deleted temp file: {temp_file_path}")
        except Exception as e:
            print(f"[WARN] Failed to delete temp file: {e}")

def save_log_file(file_name: str) -> str:
    log_dir = "log"
    os.makedirs(log_dir, exist_ok=True)
    timestamp = datetime.now().strftime("%Y%m%d_%H%M%S")
    base_filename = Path(file_name).stem
    log_filename = f"{base_filename}_{timestamp}.txt"
    log_path = os.path.join(log_dir, log_filename)

    with open(log_path, "w", encoding="utf-8") as f:
        f.write(f"Log created at {timestamp} for file: {file_name}\n")

    return log_path

def write_log(log_file_path: str, content: str):
    with open(log_file_path, "a", encoding="utf-8") as f:
        f.write(content + "\n")
