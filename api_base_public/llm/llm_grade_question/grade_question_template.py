from langchain_core.prompts import ChatPromptTemplate
from langchain_core.runnables import RunnableSequence
from pydantic import BaseModel,  Field
from typing import Optional, List
from llm.utils.custom_prompt import CustomPrompt


class GradeDocumentModel(BaseModel):
    """
    Mô hình dữ liệu để đánh giá mức độ liên quan của tài liệu.

    Attributes:
        binary_score (str): Giá trị điểm nhị phân xác định tài liệu có liên quan hay không ('yes' hoặc 'no').
    """

    binary_score: str = Field(description="Giá trị 'yes' hoặc 'no' hoặc 're-generate'")
    description: str = Field(description="Giải thích chi tiết lý do tại sao câu hỏi trắc nghiệm hoặc câu trả lời không liên quan đến tài liệu")


class GradeDocument:
    """
    Đánh gía sự liên quan giữa câu hỏi, câu trả lời và tài liệu 
    """

    def __init__(self, llm) -> None:
        """
        llm: large model language
        """
        self.structured_output = llm.with_structured_output(GradeDocumentModel)

        self.prompt = ChatPromptTemplate.from_messages([
            ("system", CustomPrompt.GRADE_DOCUMENT),
            ("human", "-Tài liệu:\n{document}\n\n-Câu hỏi:\n{question}\n\n-Câu trả lời được gợi ý:\n{suggested_answer}\n\n-Các đáp án khác: \n{other_questions}"),
        ])

        self.chain = self.prompt | self.structured_output

    def get_chain(self) -> RunnableSequence:
        """
        Trả về chuỗi xử lý tạo câu hỏi.

        Returns:
            RunnableSequence: Pipeline thực thi.
        """
        return self.chain
    
    def render_prompt(self, input_dict: dict) -> str:
        """
        Trả về nội dung prompt đã được render (dành cho debug).
        """
        messages = self.prompt.format_messages(**input_dict)
        return "\n\n".join([f"[{msg.type.upper()}] {msg.content}" for msg in messages])