from langchain_core.prompts import ChatPromptTemplate
from langchain_core.runnables import RunnableSequence
from pydantic import BaseModel,  Field
from typing import Optional
from llm.utils.custom_prompt import CustomPrompt


class GradeDocumentModel(BaseModel):
    """
    Mô hình dữ liệu để đánh giá mức độ liên quan của tài liệu.

    Attributes:
        binary_score (str): Giá trị điểm nhị phân xác định tài liệu có liên quan hay không ('yes' hoặc 'no').
    """

    binary_score: str = Field(description="Giá trị 'yes' hoặc 'no' hoặc 're-generate'")
    new_answer: Optional[str]=Field(description="Câu trả lời mới")
    citation: Optional[str]=Field(description="Trích dẫn cho câu trả lời mới")
    description: str = Field(description="Giải thích chi tiết lý do tại sao câu hỏi trắc nghiệm không liên quan đến tài liệu")


class GradeDocument:
    """
    Đánh gía sự liên quan giữa câu hỏi, câu trả lời và tài liệu 
    """

    def __init__(self, llm) -> None:
        """
        llm: large model language
        """
        structured_output = llm.with_structured_output(GradeDocumentModel)

        prompt = ChatPromptTemplate.from_messages([
            ("system", CustomPrompt.GRADE_DOCUMENT),
            ("human", "Tài liệu:\n\n{document}\n\n\nCâu hỏi trắc nghiệm:\n\n{question}\n\n\nCâu trả lời:\n\n{suggested_answer}"),
        ])

        self.chain = prompt | structured_output

    def get_chain(self) -> RunnableSequence:
        """
        Trả về chuỗi xử lý tạo câu hỏi.

        Returns:
            RunnableSequence: Pipeline thực thi.
        """
        return self.chain
