from langchain_openai import ChatOpenAI
from llm.config import settings
from langchain_google_genai import ChatGoogleGenerativeAI  # Import API của Google Gemini
from langchain_xai import ChatXAI

class LLM_SUGGEST_NUMBER_QUESTION:
    """
    Lớp LLM hỗ trợ khởi tạo mô hình OpenAI với các tham số tùy chỉnh.
    """

    def __init__(self, temperature: float = 0.0, max_tokens: int = 4096, n_ctx: int = 4096,) -> None:
        self.temperature = temperature
        self.max_tokens = max_tokens
        self.n_ctx = n_ctx
        

    def grok_ai(self):
        """
        Khởi tạo mô hình Grok sử dụng API Key từ settings.

        Returns:
            ChatXAI: Đối tượng mô hình grok.
        """
        print('use grok to suggest question')
        # self.write_log('use grok to grade doc')
        llm = ChatXAI(
            model=settings.GROK_LLM_MODEL,
            temperature=self.temperature,
            max_tokens=self.max_tokens,
            api_key=settings.KEY_API_GROK
        )
        return llm

    def open_ai(self):
        """
        Khởi tạo mô hình OpenAI sử dụng API Key từ settings.

        Returns:
            ChatOpenAI: Đối tượng mô hình OpenAI.
        """
        # self.write_log('use gpt  to suggest question')
        print('use gpt  to suggest question')
        llm = ChatOpenAI(
            openai_api_key=settings.KEY_API_GPT,
            model=settings.OPENAI_LLM_MODEL,
            temperature=self.temperature,
            max_tokens=self.max_tokens,
        )
        return llm

    def gemini(self):
        """
        Khởi tạo mô hình Google Gemini sử dụng API Key từ settings.

        Returns:
            ChatGoogleGenerativeAI: Đối tượng mô hình Google Gemini.
        """
        # self.write_log('use gemini  to grade doc')
        print('use gemini  to suggest number question')
        llm = ChatGoogleGenerativeAI(
            google_api_key=settings.KEY_API_GEMINI,  
            model=settings.GEMINI_LLM_MODEL, 
            temperature=self.temperature,
            max_tokens=self.max_tokens,
        )
        return llm


    def get_llm(self, llm_name: str):
        """
        Trả về mô hình LLM tương ứng dựa trên tên được cung cấp.

        Args:
            llm_name (str): Tên mô hình ('openai' hoặc 'gemini' hoặc 'grok').

        Returns:
            ChatOpenAI hoặc ChatGoogleGenerativeAI hoặc ChatXAI: Đối tượng mô hình tương ứng.
        """
        
        if llm_name == "openai":
            return self.open_ai()
        elif llm_name == "gemini":
            return self.gemini()
        elif llm_name == "grok":
            return self.grok_ai()
        else:
            return self.open_ai()  # Mặc định sử dụng OpenAI nếu không có tên hợp lệ

    # def write_log(self, content):
    #     with open(self.log_file_path, "a", encoding="utf-8") as f:
    #         f.write(content + "\n")