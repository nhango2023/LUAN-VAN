from fastapi import FastAPI
from app.models.n_question import NQuestion
from fastapi.middleware.cors import CORSMiddleware
from fastapi import FastAPI, UploadFile, File, Form, HTTPException, Body
import fitz  # PyMuPDF
import docx
from app.security.security import get_api_key

from .files_chat_agent import FilesChatAgent

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


@app.get("/")
def read_root():    
    return {"message": "Welcome to my FastAPI application"}   


@app.post("/question/create", summary="Create a new question with an uploaded file and JSON data", response_description="Successfully created question")
async def create_question(
    file: UploadFile = File(..., description="Tài liệu giáo trình (The instructional material file) to be uploaded."),
    Nquestion_json: str = Form(..., description="Dữ liệu câu hỏi dưới dạng JSON (JSON string containing the question data)."),
    api_key: str = (get_api_key)
):
    """
    Endpoint to create a new question by uploading a file and providing the question data as a JSON string.
    
    - **file**: The file associated with the question (e.g., an instructional material or other related document).
    - **Nquestion_json**: A JSON string containing the question details (e.g., question text, options, etc.).
    - **api_key**: A valid API key required for authorization to access the endpoint.

    **Returns:**
    - A success message confirming that the question has been created.
    
    The response will include a confirmation message indicating the status of the operation.
    """
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
    if file.content_type not in ["application/pdf", "application/vnd.openxmlformats-officedocument.wordprocessingml.document"]:
        raise HTTPException(status_code=400, detail="Unsupported file type.")

    # Read file content into memory
    contents = await file.read()

    text = ""

    if file.filename.endswith(".pdf"):
        with fitz.open(stream=contents, filetype="pdf") as doc:
            for page in doc:
                text += page.get_text()

    elif file.filename.endswith(".docx"):
        # Save contents temporarily to load with python-docx
        import tempfile
        with tempfile.NamedTemporaryFile(delete=False, suffix=".docx") as tmp:
            tmp.write(contents)
            tmp_path = tmp.name

        doc = docx.Document(tmp_path)
        text = "\n".join([para.text for para in doc.paragraphs])
    
    return FilesChatAgent(text, n_question).get_lst_question()
    

