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

    async def process_file(self, file, user_token):
        """
        Load file, split text, and attach page numbers to each chunk.
        """
        
        ext = file.filename.split('.')[-1].lower()
        with tempfile.NamedTemporaryFile(delete=False, suffix=f".{ext}") as tmp:
            tmp.write(await file.read())
            tmp_path = tmp.name

        try:
            if ext == "pdf":
                loader = PyMuPDFLoader(tmp_path)
            elif ext == "docx":
                loader = UnstructuredWordDocumentLoader(tmp_path)
            elif ext == "txt":
                loader = TextLoader(tmp_path, encoding="utf-8")
            else:
                raise ValueError("Unsupported file type")

            documents = loader.load()
            total_characters=0
            # Add page number metadata
            for i, doc in enumerate(documents):
                doc.metadata["page"] = i + 1
                total_characters += len(doc.page_content)

            #tra ve loi 402 neu user khong du token    
            if user_token < 5000:
                raise HTTPException(status_code=402, detail="Not enough token") 
            
            
            self.write_log(f"Total number of characters in the file: {total_characters}")

            text_splitter = RecursiveCharacterTextSplitter(
                separators=["\n\n", "\n", " ", ".", ",", "\u200b", "\uff0c", "\u3001", "\uff0e", "\u3002", ""],
                chunk_size=self.chunk_size,
                chunk_overlap=self.chunk_overlap,
            )

            # Split with metadata preserved
            splitted_docs = text_splitter.split_documents(documents)

            # Ensure each split retains its page number
            for doc in splitted_docs:
                if "page" not in doc.metadata:
                    doc.metadata["page"] = "Unknown"

            return splitted_docs

        finally:
            os.remove(tmp_path)

    def write_log(self, content):
        with open(self.log_file_path, "a", encoding="utf-8") as f:
            f.write(content + "\n")