from langchain_community.document_loaders import PyMuPDFLoader, UnstructuredWordDocumentLoader, TextLoader
from langchain_text_splitters import RecursiveCharacterTextSplitter
import tempfile
import os
from fastapi import HTTPException

class SplitDocument:
    def __init__(self, log_file_path):
        self.chunk_size = 4000
        self.chunk_overlap = int(self.chunk_size * 0.1)
        self.log_file_path= log_file_path

    async def process_file(self, file_path, user_token):
        """
        Load file, split text, and attach page numbers to each chunk.
        """
        
        ext = file_path.suffix.lower().replace(".", "")

        try:
            if ext == "pdf":
                loader = PyMuPDFLoader(str(file_path))
            elif ext == "docx":
                loader = UnstructuredWordDocumentLoader(str(file_path))
            elif ext == "txt":
                loader = TextLoader(str(file_path), encoding="utf-8")
            else:
                raise ValueError("Unsupported file type")

            documents = loader.load()
            total_characters = sum(len(doc.page_content) for doc in documents)

            if user_token < 5000:
                raise HTTPException(status_code=402, detail="Not enough token")

            self.write_log(f"Total number of characters in the file: {total_characters}")

            text_splitter = RecursiveCharacterTextSplitter(
                separators=["\n\n", "\n", " ", ".", ",", "\u200b", "\uff0c", "\u3001", "\uff0e", "\u3002", ""],
                chunk_size=self.chunk_size,
                chunk_overlap=self.chunk_overlap,
            )

            splitted_docs = text_splitter.split_documents(documents)

            for i, doc in enumerate(splitted_docs):
                if "page" not in doc.metadata:
                    doc.metadata["page"] = "Unknown"

            return splitted_docs

        finally:
            try:
                file_path.unlink(missing_ok=True)
                self.write_log(f"Temporary file {file_path.name} deleted.")
            except Exception as e:
                print(f"Loi xoa file:\n{e}")

    def write_log(self, content):
        with open(self.log_file_path, "a", encoding="utf-8") as f:
            f.write(content + "\n")