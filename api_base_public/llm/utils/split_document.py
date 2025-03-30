from langchain_text_splitters import RecursiveCharacterTextSplitter

class SplitDocument:
    def __init__(self):
        """
        Khởi tạo SplitDocument
        """
        self.chunk_size = 2000  # Kích thước đoạn văn bản tối đa khi chia nhỏ
        self.chunk_overlap = int(self.chunk_size * 0.2)  # Độ chồng chéo giữa các đoạn văn bản

    def process_text(self, text: str):
        """
        Xử lý văn bản đầu vào, chia thành các đoạn nhỏ để phù hợp với embedding.

        Args:
            text (str): Văn bản cần chia nhỏ.

        Returns:
            List[Document]: Danh sách các Document đã được chia nhỏ.
        """
        text_splitter = RecursiveCharacterTextSplitter(
            separators=[
                "\n\n", "\n", " ", ".", ",",
                "\u200b", "\uff0c", "\u3001", "\uff0e", "\u3002", ""
            ],
            chunk_size=self.chunk_size,
            chunk_overlap=self.chunk_overlap,
        )

        docs = text_splitter.create_documents([text])
        return docs
