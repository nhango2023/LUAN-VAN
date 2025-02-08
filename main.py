import streamlit as st
import openai
import fitz  # PyMuPDF for PDFs
from docx import Document  # For Word documents
import re  # Regular expressions for chapter splitting
import json  # Import the json module

# Set your OpenAI API key
with open("apikey.txt", "r") as f:
    openai.api_key = f.readline().strip()

# Đọc nội dung PDF
def read_pdf(file):
    doc = fitz.open(stream=file.read(), filetype="pdf")
    return "\n".join([page.get_text() for page in doc])

# Đọc nội dung Word
def read_word(file):
    doc = Document(file)
    return "\n".join([para.text for para in doc.paragraphs])

# Gọi OpenAI API để lấy danh sách chương
def split_into_chapters_with_api(content):
    prompt = f"""
        Dưới đây là nội dung một tài liệu. Hãy trích xuất tất cả các chương có trong tài liệu.
        Trả về danh sách JSON hợp lệ, trong đó mỗi chương là một phần tử:
        [
            "Chương 1: Tiêu đề",
            "Chương 2: Tiêu đề",
            ...
        ]
        Chỉ trả về JSON hợp lệ, không thêm nội dung khác.

        Nội dung tài liệu:
        {content}  
    """
    response = openai.ChatCompletion.create(
        model="gpt-4o-mini",
        messages=[{"role": "user", "content": prompt}],
        temperature=0.5,
        max_tokens=4000
    )

    response_text = response['choices'][0]['message']['content'].strip()
    json_match = re.search(r'\[\s*("Chương.*?")\s*\]', response_text, re.DOTALL)

    if json_match:
        json_text = json_match.group(0)
        try:
            return json.loads(json_text)
        except json.JSONDecodeError:
            st.error("Lỗi phân tích JSON từ OpenAI API.")
            return []
    else:
        st.error("Không tìm thấy danh sách chương hợp lệ trong phản hồi API.")
        return []

# **STREAMLIT UI**
st.title("📚 Tạo Câu Hỏi Trắc Nghiệm Theo Chương")

# Tải file lên
uploaded_file = st.file_uploader("📂 Tải lên file PDF hoặc Word", type=["pdf", "docx"])

if uploaded_file:
    # Lưu nội dung file vào Session State để tránh đọc lại khi reload
    if "file_content" not in st.session_state:
        if uploaded_file.name.endswith(".pdf"):
            st.session_state.file_content = read_pdf(uploaded_file)
        elif uploaded_file.name.endswith(".docx"):
            st.session_state.file_content = read_word(uploaded_file)
        else:
            st.error("⚠️ Định dạng file không được hỗ trợ.")
            st.session_state.file_content = ""

    # Gọi API OpenAI để lấy danh sách chương nếu chưa có
    if "chapters" not in st.session_state:
        with st.spinner("🔍 Đang phân tích tài liệu..."):
            st.session_state.chapters = split_into_chapters_with_api(st.session_state.file_content)

    chapters = st.session_state.chapters
    st.write(f"📖 Đã phát hiện **{len(chapters)} chương**.")

    # Lưu số lượng câu hỏi vào Session State để tránh mất khi giao diện cập nhật
    if "question_counts" not in st.session_state:
        st.session_state.question_counts = {chapter: 10 for chapter in chapters}  # Giá trị mặc định

    for i, chapter in enumerate(chapters):
        st.markdown(f"### 📖 {chapter}")
        st.session_state.question_counts[chapter] = st.number_input(
            f"Số lượng câu hỏi cho {chapter}",
            min_value=1, max_value=50,
            value=st.session_state.question_counts[chapter],
            key=f"num_questions_{i}"
        )

    # Khi nhấn nút, tạo câu hỏi trắc nghiệm
    if st.button("📝 Tạo Câu Hỏi Trắc Nghiệm"):
        with st.spinner("⏳ Đang tạo câu hỏi..."):

            # Tạo danh sách chương và số lượng câu hỏi mong muốn
            chapter_questions = []
            for chapter in chapters:
                num_questions = st.session_state.question_counts[chapter]
                chapter_questions.append(f"- {chapter}: {num_questions} câu hỏi")

            # Tạo prompt duy nhất cho toàn bộ chương
            prompt = f"""
            Dưới đây là danh sách các chương và số lượng câu hỏi mong muốn:
            {chr(10).join(chapter_questions)}

            Hãy tạo câu hỏi trắc nghiệm dưới dạng JSON, với định dạng như sau:
            [
                {{
                    "chapter": "Chương 1: Tên chương",
                    "questions": [
                        {{
                            "question": "Câu hỏi 1?",
                            "options": {{
                                "A": "Lựa chọn A",
                                "B": "Lựa chọn B",
                                "C": "Lựa chọn C",
                                "D": "Lựa chọn D"
                            }},
                            "correct_answer": "B"
                        }}
                    ]
                }}
            ]
            ⚠ **Chú ý quan trọng:** 
            - Trả về JSON hợp lệ, không thêm văn bản ngoài JSON.
            - Nội dung chương được lấy từ tài liệu dưới đây.
            - Trả về số lượng câu hỏi theo danh sách yêu cầu.

            Nội dung toàn bộ tài liệu:
            {st.session_state.file_content}
            """

            # st.subheader("📜 Debug: Nội dung Prompt Gửi OpenAI")
            # st.text_area("Nội dung Prompt", prompt, height=300)

            response = openai.ChatCompletion.create(
                model="gpt-4o-mini",
                messages=[{"role": "user", "content": prompt}],
                temperature=0.7
            )

            response_text = response['choices'][0]['message']['content'].strip()
            
            # Kiểm tra xem response có phải JSON hợp lệ không
            json_match = re.search(r'\[\s*{.*}\s*\]', response_text, re.DOTALL)
            
            if json_match:
                json_text = json_match.group(0)  # Lấy phần JSON hợp lệ
                try:
                    mcq_data=json.loads(json_text)  # Chuyển thành danh sách Python
                except json.JSONDecodeError as e:
                    print(f"Lỗi khi phân tích JSON: {e}")
                    mcq_data= []
            else:
                print("Không tìm thấy JSON hợp lệ trong phản hồi API.")
                mcq_data= []
            
            
            # Hiển thị danh sách câu hỏi trên giao diện
            if mcq_data:
                for chapter_data in mcq_data:
                    st.markdown(f"## 📖 {chapter_data['chapter']}")
                    for idx, question in enumerate(chapter_data['questions']):
                        st.markdown(f"**Câu {idx+1}: {question['question']}**")
                        for key, value in question['options'].items():
                            st.write(f"- {key}: {value}")
                        st.markdown(f"✅ **Đáp án đúng: {question['correct_answer']}**")
                        st.markdown("---")
            else:
                st.warning("⚠ Không có câu hỏi nào được tạo.")

