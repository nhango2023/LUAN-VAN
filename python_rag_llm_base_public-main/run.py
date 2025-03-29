# chuẩn bị dữ liệu

# chatbot
from chatbot.services.files_chat_agent import FilesChatAgent  # noqa: E402
from app.config import settings

settings.LLM_NAME = "openai"

_question = "tạo câu hỏi trắc nghiệm"
chat = FilesChatAgent("demo\data_vector").get_workflow().compile().invoke(
    input={
        "question": _question,
    }
)

print(chat)

print("generation", chat["generation"])