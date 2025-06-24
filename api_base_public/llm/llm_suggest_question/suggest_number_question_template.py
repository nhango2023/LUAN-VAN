from langchain_core.prompts import ChatPromptTemplate
from langchain_core.runnables import RunnableSequence
from pydantic import BaseModel, field_validator, Field
from llm.utils.custom_prompt import CustomPrompt
from typing import List

class SuggestNumberQuestionModel(BaseModel):
    """
    Mô hình chia số lượng câu hỏi cho từng cấp độ Bloom.
    """
    counts: List[int] = Field(description="Mảng chứa số lượng câu hỏi cho từng cấp độ")
    


class SuggestNumberQuestion:
    """
    Chia số lượng câu hỏi cho từng cấp độ Bloom.
    """

    def __init__(self, llm) -> None:
        self.structured_output = llm.with_structured_output(SuggestNumberQuestionModel)

        self.prompt = ChatPromptTemplate.from_messages([
            ("system", CustomPrompt.SUGGEST_NUMBER_QUESTION),
            ("human", "Tổng số lượng câu hỏi:\n\n{number_question}"),
        ])

        self.chain = self.prompt | self.structured_output

    def get_chain(self) -> RunnableSequence:
        """
        Trả về chuỗi xử lý đánh giá tài liệu.

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