from langchain_core.prompts import ChatPromptTemplate
from langchain_core.runnables import RunnableSequence
from pydantic import BaseModel,  Field
from typing import List
from llm.utils.custom_prompt import CustomPrompt


class QuestionItem(BaseModel):
    question: str = Field(..., description="Nội dung câu hỏi")
    options: List[str] = Field(..., description="Danh sách 4 phương án")
    answer: str = Field(..., description="Đáp án đúng")
    level: str = Field(..., description="Cấp độ Bloom's taxonomy")

class QuestionModel(BaseModel):
    Question: List[QuestionItem]

class GenerateQuestion:
    """
    Tạo ra câu hỏi trắc nghiệm trên thang Bloom bằng cách sử dụng mô hình ngôn ngữ.
    """

    def __init__(self, llm) -> None:
        structured_output = llm.with_structured_output(QuestionModel)

        prompt = ChatPromptTemplate.from_messages([
            ("system", CustomPrompt.GENERATE_QUESTION),
            ("human", "-Tài liệu:{document}\n\n-Danh sách từ khóa:{keyword}\n\n-Số lượng câu hỏi yêu cầu:{n_question}"),
        ])

        self.chain = prompt | structured_output

    def get_chain(self) -> RunnableSequence:
        """
        Trả về chuỗi xử lý tạo câu hỏi.

        Returns:
            RunnableSequence: Pipeline thực thi.
        """
        return self.chain
