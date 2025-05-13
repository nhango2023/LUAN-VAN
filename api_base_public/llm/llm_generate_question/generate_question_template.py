from langchain_core.prompts import ChatPromptTemplate
from langchain_core.runnables import RunnableSequence
from pydantic import BaseModel,  Field
from typing import List, Optional
from llm.utils.custom_prompt import CustomPrompt

class QuestionItem(BaseModel):
    question: str = Field(..., description="Nội dung câu hỏi")
    options: List[str] = Field(..., description="Danh sách 4 đáp án")
    answer: str = Field(..., description="Đáp án đúng")
    citation: str = Field(..., description="Giải thích chi tiết lý do tại sao chọn câu trả lời đó là câu trả lời")
    level: Optional[str] = Field(None,description="Cấp độ Bloom của câu hỏi")
    page: Optional[int] = Field(None,description="0")
    idx_doc: Optional[int] = Field(None, description="0")
    class Config:
        extra = "forbid"

class QuestionModel(BaseModel):
    Question: List[QuestionItem]

class GenerateQuestion:
    def __init__(self, llm) -> None:
        self.structured_output = llm.with_structured_output(QuestionModel)

        self.prompt = ChatPromptTemplate.from_messages([
            ("system", CustomPrompt.GENERATE_QUESTION),
            ("human", "-Tài liệu:\n{document}\n\n-Danh sách động từ được yêu cầu thêm vào câu hỏi:\n{keyword}\n\n-Số lượng câu hỏi yêu cầu: {n_question}\n\n-Danh sách câu hỏi đã có:\n{existing_questions}\n\n-Danh sách câu hỏi chưa có động từ được yêu cầu:\n{questions_without_keywords}\n\nDanh sách câu hỏi không hợp lệ:\n{invalid_questions}"),
        ])

        self.chain = self.prompt | self.structured_output

    def get_chain(self) -> RunnableSequence:
        return self.chain

    def render_prompt(self, input_dict: dict) -> str:
        """
        Trả về nội dung prompt đã được render (dành cho debug).
        """
        messages = self.prompt.format_messages(**input_dict)
        return "\n\n".join([f"[{msg.type.upper()}] {msg.content}" for msg in messages])
