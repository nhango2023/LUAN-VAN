from langchain_core.prompts import ChatPromptTemplate
from langchain_core.runnables import RunnableSequence
from pydantic import BaseModel, field_validator, Field
from llm.utils.custom_prompt import CustomPrompt
from typing import List

class GradeDocumentModel(BaseModel):
    """
    Mô hình kết quả đầu ra có cấu trúc cho việc đánh giá cấp độ tài liệu theo thang Bloom.
    """
    level: List[str] = Field(description="Các cấp độ: remember, understand, apply, analyze, evaluate, create")
    @field_validator("level")
    @classmethod
    def normalize_levels(cls, values: List[str]) -> List[str]:
        mapping = {
            "understanding": "understand",
            "understand": "understand",
            "applying": "apply",
            "apply": "apply",
            "analyzing": "analyze",
            "analyze": "analyze",
            "evaluating": "evaluate",
            "evaluate": "evaluate",
            "creating": "create",
            "create": "create",
            "remembering": "remember",
            "remember": "remember",
        }

        normalized = []
        for val in values:
            key = val.strip().lower()
            if key in mapping:
                normalized.append(mapping[key])
            else:
                # Optional: ignore or keep original
                normalized.append(val)
        return list(set(normalized))  # remove duplicates if needed


class DocumentGraderLevel:
    """
    Đánh giá tài liệu dựa trên thang Bloom bằng cách sử dụng mô hình ngôn ngữ.
    """

    def __init__(self, llm) -> None:
        self.structured_output = llm.with_structured_output(GradeDocumentModel)

        self.prompt = ChatPromptTemplate.from_messages([
            ("system", CustomPrompt.GRADE_DOCUMENT_LEVEL),
            ("human", "Tài liệu:\n\n{document}"),
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