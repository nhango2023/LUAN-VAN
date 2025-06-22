from langchain_community.document_loaders import PyMuPDFLoader, UnstructuredWordDocumentLoader, TextLoader
from langchain_text_splitters import RecursiveCharacterTextSplitter
import tempfile
import os
from fastapi import HTTPException
from langchain.schema.document import Document

class SplitDocument:
    def __init__(self):
        self.chunk_size = 4000
        self.chunk_overlap = int(self.chunk_size * 0.1)
        

    def process_file(self, documents: list[Document]):
        text_splitter = RecursiveCharacterTextSplitter(
            chunk_size=self.chunk_size,
            chunk_overlap=self.chunk_overlap,
            separators=["\n\n", "\n", " ", ".", ",", "\u200b", "\uff0c", "\u3001", "\uff0e", "\u3002", ""],
        )

        
        splitted_docs = text_splitter.split_documents(documents)
        for i, doc in enumerate(splitted_docs):
                if "page" not in doc.metadata:
                    doc.metadata["page"] = "Unknown"

        return splitted_docs
    
    def write_log(self, content):
        with open(self.log_file_path, "a", encoding="utf-8") as f:
            f.write(content + "\n")