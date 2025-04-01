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

# Settings.LLM_NAME = "openai"

@app.post("/question/create")
async def upload_file(
    file: UploadFile = File(...)
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
    print(splited_documents)
    
    return {"message": "thanh cong"}

# @app.post("/question/create/{level_1}/{level_2}/{level_3}/{level_4}/{level_5}/{level_6}/")
# async def upload_file(
#     level_1: int,``
#     level_2: int,
#     level_3: int,
#     level_4: int,
#     level_5: int,
#     level_6: int,
#     file: UploadFile = File(...)
# ):
#     if file.content_type not in ["application/pdf", "application/vnd.openxmlformats-officedocument.wordprocessingml.document"]:
#         raise HTTPException(status_code=400, detail="Unsupported file type.")

#     # Read file content into memory
#     contents = await file.read()

#     text = ""

#     if file.filename.endswith(".pdf"):
#         with fitz.open(stream=contents, filetype="pdf") as doc:
#             for page in doc:
#                 text += page.get_text()

#     elif file.filename.endswith(".docx"):
#         # Save contents temporarily to load with python-docx
#         import tempfile
#         with tempfile.NamedTemporaryFile(delete=False, suffix=".docx") as tmp:
#             tmp.write(contents)
#             tmp_path = tmp.name

#         doc = docx.Document(tmp_path)
#         text = "\n".join([para.text for para in doc.paragraphs])  

#     text_splitter = RecursiveCharacterTextSplitter(
#                     separators=[
#                         "\n\n",  # Split at double newlines
#                         "\n",  # Split at newlines
#                         " ",  # Split at spaces
#                         ".",  # Split at periods
#                         ",",  # Split at commas
#                         "\u200b",  # Zero-width space
#                         "\uff0c",  # Fullwidth comma
#                         "\u3001",  # Ideographic comma
#                         "\uff0e",  # Fullwidth full stop
#                         "\u3002",  # Ideographic full stop
#                         "",  # Empty string as a separator
#                     ],
#                     chunk_size=2000,
#                     chunk_overlap=400  # Overlap of 400 characters between chunks
#                 )  
#     extracted_texts = text_splitter.split_text(text)
#     print(extracted_texts)

#     for content in extracted_texts:
#         getLevel(content)
#     return {
#         "levels": [level_1, level_2, level_3, level_4, level_5, level_6],
#         "filename": file.filename
#     }

# def getLevel(text):
#     prompt = f"""
#         Bạn là người đánh giá cấp độ theo thang Bloom (Bloom's taxonomy) của một tài liệu.
#         Mục tiêu của bạn là xác định xem tài liệu thuộc những cấp độ nào (có thể nhiều hơn một).

#         Tài liệu:
#         {text}

#         Trả về tất cả các cấp độ phù hợp trong danh sách sau (nếu có): "Nhớ", "Hiểu", "Vận dụng", "Phân tích", "Đánh giá", "Sáng tạo".

#         ### Yêu cầu định dạng:
#         Trả về duy nhất một danh sách Python, ví dụ:
#         ["Nhớ", "Phân tích", "Đánh giá"]

#         Không cần giải thích thêm.
#         """

#     response = openai.ChatCompletion.create(
#                 model="gpt-4o-mini",
#                 messages=[{"role": "system", "content": prompt}]
#     )
#     response_text = response["choices"][0]["message"]["content"].strip()
#     print(response_text)
#     try:
#         levels = json.loads(response_text)
#         print("Các cấp độ Bloom:", levels)
#         print("=======")
#     except json.JSONDecodeError:
#         print("Lỗi: GPT không trả về đúng định dạng danh sách.")
#         print("=======")
    