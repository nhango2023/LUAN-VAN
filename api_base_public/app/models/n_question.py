from pydantic import BaseModel


class NQuestion(BaseModel):
    remember: int
    understand: int
    apply: int
    analyze: int
    evaluate: int
    create: int