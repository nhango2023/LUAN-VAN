from langchain_core.prompts import ChatPromptTemplate
from langchain_core.runnables import RunnableSequence
from pydantic import BaseModel
from llm.utils.custom_prompt import CustomPrompt


class GradeDocumentModel(BaseModel):
    """
    Mô hình kết quả đầu ra có cấu trúc cho việc đánh giá cấp độ tài liệu theo thang Bloom.
    """
    level: list[str]


class DocumentGrader:
    """
    Đánh giá tài liệu dựa trên thang Bloom bằng cách sử dụng mô hình ngôn ngữ.
    """

    def __init__(self, llm) -> None:
        structured_output = llm.with_structured_output(GradeDocumentModel)

        prompt = ChatPromptTemplate.from_messages([
            ("system", CustomPrompt.GRADE_DOCUMENT_LEVEL),
            ("human", "Document:\n\n{document}"),
        ])

        self.chain = prompt | structured_output

    def get_chain(self) -> RunnableSequence:
        """
        Trả về chuỗi xử lý đánh giá tài liệu.

        Returns:
            RunnableSequence: Pipeline thực thi.
        """
        return self.chain
