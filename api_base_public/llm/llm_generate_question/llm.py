from langchain_openai import ChatOpenAI
from llm.config import settings
from langchain_google_genai import ChatGoogleGenerativeAI  # Import API của Google Gemini

class LLM_GENERATE_QUESTION:
    """
    Lớp LLM hỗ trợ khởi tạo mô hình OpenAI với các tham số tùy chỉnh.
    """

    def __init__(self, temperature: float = 0.3, max_tokens: int = 4096, n_ctx: int = 4096) -> None:
        self.temperature = temperature
        self.max_tokens = max_tokens
        self.n_ctx = n_ctx
        self.model = ""

    def open_ai(self):
        """
        Khởi tạo mô hình ChatOpenAI với cấu hình từ settings.

        Returns:
            ChatOpenAI: Mô hình ngôn ngữ của OpenAI.
        """
        # return ChatOpenAI(
        #     openai_api_key=settings.KEY_API_GPT,
        #     model=settings.OPENAI_LLM,
        #     temperature=self.temperature,
        #     max_tokens=self.max_tokens,
        # )

        return ChatGoogleGenerativeAI(
            google_api_key='AIzaSyA5EDfPHRWQi1a-mVVAqiWqIDYp3dGO_7A',  # API Key Google Gemini
            model="gemini-2.0-flash",  # Mô hình Google Gemini (ví dụ: 'gemini-pro')
            temperature=self.temperature,
        )

    def get_llm(self):
        """
        Lấy mô hình LLM (hiện tại mặc định là OpenAI).

        Returns:
            ChatOpenAI: Mô hình được khởi tạo.
        """
        return self.open_ai()
