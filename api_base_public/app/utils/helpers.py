import os
from datetime import datetime
from fastapi import UploadFile
import string




def save_log_file(file: UploadFile, model):
    # Tạo thư mục log nếu chưa có
    log_dir = "log"
    os.makedirs(log_dir, exist_ok=True)

    # Lấy tên file gốc và loại bỏ phần mở rộng
    base_filename = os.path.splitext(file.filename)[0]

    # Lấy thời gian hiện tại định dạng YYYYMMDD_HHMMSS
    timestamp = datetime.now().strftime("%Y%m%d_%H%M%S")

    # Tạo tên file log
    log_filename = f"{base_filename}_{timestamp}_{model}.txt"

    # Đường dẫn đầy đủ
    log_path = os.path.join(log_dir, log_filename)

    # Ghi một nội dung mẫu (bạn có thể thay thế bằng nội dung thực tế)
    with open(log_path, "w", encoding="utf-8") as f:
        f.write(f"Log created at {timestamp} for file: {file.filename}\n")

    return log_path

def normalize(text: str) -> str:
    # Strip, lowercase, and remove punctuation
        return text.strip().lower().translate(str.maketrans('', '', string.punctuation))

def is_question_in_list(question: str, question_list: list) -> bool:
    created_question = normalize(question)      
    for item in question_list:
        existed_question=normalize(item.question)           
        if created_question == existed_question:
            write_log(f"Cau hoi da co trong ds tong: {item.question}")
            return True
    return False
        

def check_keyword_in_question(self, question: str, level: str, lst_keyword: dict):
    """
    Kiểm tra xem câu hỏi có chứa từ khóa thuộc cấp độ Bloom đã cho hay không.

    Args:
        question (str): Nội dung câu hỏi
        level (str): Tên cấp độ Bloom (remember, understand, ...)
        lst_keyword (dict): Dictionary chứa từ khóa cho từng cấp độ Bloom

    Returns:
        boolean: True nếu có từ khóa phù hợp, False nếu không
    """
    question_lower = question.lower()

    # Lấy từ khóa của cấp độ hiện tại từ lst_keyword
    keyword_str = lst_keyword.get(level)
    if not keyword_str:
        self.write_log("keyword rong !!!")
        return False

    # Kiểm tra từ khóa trong câu hỏi
    for keyword in keyword_str.split(", "):
        if keyword in question_lower:
            self.write_log(f"[{keyword}]")
            return True

    return False


def write_log(self, content):
    with open(self.log_file_path, "a", encoding="utf-8") as f:
        f.write(content + "\n")