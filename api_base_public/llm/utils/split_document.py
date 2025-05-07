from langchain_community.document_loaders import PyMuPDFLoader, UnstructuredWordDocumentLoader
from langchain_text_splitters import RecursiveCharacterTextSplitter
import tempfile
import os

class SplitDocument:
    def __init__(self):
        self.chunk_size = 4000
        self.chunk_overlap = int(self.chunk_size * 0.1)

    async def process_file(self, file):
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
            else:
                raise ValueError("Unsupported file type")

            documents = loader.load()

            # Add page number metadata
            for i, doc in enumerate(documents):
                doc.metadata["page"] = i + 1

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
