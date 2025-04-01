from langchain_core.prompts import ChatPromptTemplate
from langchain_core.runnables import RunnableSequence
from pydantic import BaseModel, field_validator
from llm.utils.custom_prompt import CustomPrompt
from typing import List

class GradeDocumentModel(BaseModel):
    """
    Mô hình kết quả đầu ra có cấu trúc cho việc đánh giá cấp độ tài liệu theo thang Bloom.
    """
    level: List[str]
    @field_validator("level")
    @classmethod
    def normalize_levels(cls, values: List[str]) -> List[str]:
        mapping = {
            "understanding": "Understand",
            "understand": "Understand",
            "applying": "Apply",
            "apply": "Apply",
            "analyzing": "Analyze",
            "analyze": "Analyze",
            "evaluating": "Evaluate",
            "evaluate": "Evaluate",
            "creating": "Create",
            "create": "Create",
            "remembering": "Remember",
            "remember": "Remember",
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
