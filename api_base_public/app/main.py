from fastapi import FastAPI
from app.routers import base, file_upload
from fastapi.middleware.cors import CORSMiddleware
from fastapi import FastAPI, UploadFile, File, Form, HTTPException
from typing import Literal
import fitz  # PyMuPDF
import docx
from llm.utils.split_document import SplitDocument
from langchain.text_splitter import RecursiveCharacterTextSplitter
import openai
import json
from llm.llm_level.llm import LLM_LEVEL
from llm.llm_level.grade_document_level import DocumentGrader
# Tạo instance của FastAPI
app = FastAPI()

with open("../apikey.txt", "r") as f:
    openai.api_key = f.readline().strip()

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

@app.get("/test-call-api")
def read_root():
    return {"message": "thành công rồi"}

# Settings.LLM_NAME = "openai"

@app.post("/question/create")
async def upload_file(
    file: UploadFile = File(...),
    user_question: str = Form(...)
):
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
    print("dff")
    ##chia tai lieu thanh cac doan nho
    splitter=SplitDocument()
    splited_documents = splitter.process_text(text)

    #llm xac dinh level
    llm_instance = LLM_LEVEL()
    openai_llm = llm_instance.get_llm()
    # Khởi tạo grader
    grader = DocumentGrader(openai_llm).get_chain()

    #goi api xac dinh cap do
    for idx, text in enumerate(splited_documents):
        result = grader.invoke({"document": splited_documents[idx]})
        print(result)
        print("====")
    
        
    
    return {"message": "thanh cong"}
