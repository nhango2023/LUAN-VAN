import os
from dotenv import load_dotenv

# Load biến môi trường từ file .env ở thư mục gốc
dotenv_path = os.path.join(os.path.dirname(os.path.dirname(__file__)), ".env")
load_dotenv(dotenv_path)


class Settings:
    DIR_ROOT = os.path.dirname(os.path.abspath(dotenv_path))
    API_KEY = os.getenv("API_KEY")
    KEY_API_GPT = os.getenv("KEY_API_GPT")
    KEY_API_GEMINI = os.getenv("KEY_API_GEMINI")
    # NUM_DOC = int(os.getenv("NUM_DOC", "3"))
    # LLM_NAME = os.getenv("LLM_NAME")
    OPENAI_LLM_MODEL = os.getenv("OPENAI_LLM_MODEL")
    GEMINI_LLM_MODEL = os.getenv("GEMINI_LLM_MODEL")
    KEY_API_GROK = os.getenv("KEY_API_GROK")
    GROK_LLM_MODEL = os.getenv("GROK_LLM_MODEL")


settings = Settings()

