import streamlit as st
import openai
import fitz  # PyMuPDF for PDFs
from docx import Document  # For Word documents
import re  # Regular expressions for chapter splitting

# Set your OpenAI API key
with open("apikey.txt", "r") as f:
    openai.api_key = f.readline().strip()

def read_pdf(file):
    """Read PDF content using PyMuPDF."""
    doc = fitz.open(stream=file.read(), filetype="pdf")
    content = ""
    for page in doc:
        content += page.get_text()
    return content

def read_word(file):
    """Read Word document content using python-docx."""
    doc = Document(file)
    content = "\n".join([para.text for para in doc.paragraphs])
    return content

def split_into_chapters(content):
    """Split the content into chapters based on the keyword 'Chương '."""
    chapters = re.split(r'(Chương \d+[\s\S]*?)(?=Chương \d+|$)', content)
    # Remove empty strings and ensure each element is a full chapter
    chapters = [chap.strip() for chap in chapters if chap.strip() and "Chương" in chap]
    return chapters

def get_chapter_title(chapter):
    """Extract the title of the chapter (first line containing 'Chương')."""
    match = re.search(r'(Chương \d+.*?)(\n|$)', chapter)
    return match.group(1) if match else "Unnamed Chapter"

# Streamlit UI
st.title("MCQ Generator for Each Chapter")
st.write("Upload a Word or PDF file to generate 10 multiple-choice questions for each chapter in the document.")

uploaded_file = st.file_uploader("Upload a Word or PDF file", type=["pdf", "docx"])

if uploaded_file:
    # Determine file type and read content
    if uploaded_file.name.endswith(".pdf"):
        file_content = read_pdf(uploaded_file)
    elif uploaded_file.name.endswith(".docx"):
        file_content = read_word(uploaded_file)
    else:
        st.error("Unsupported file format.")
        file_content = ""

    st.subheader("File Content Preview:")
    st.text_area("Preview", file_content[:2000], height=200)  # Show only the first 2000 characters for preview

    chapters = split_into_chapters(file_content)
    st.write(f"Detected {len(chapters)} chapters.")

    chapter_previews = []
    for i, chapter in enumerate(chapters):
        chapter_title = get_chapter_title(chapter)
        chapter_preview = chapter[:200] + "..." if len(chapter) > 200 else chapter
        chapter_previews.append((chapter_title, chapter_preview))

    for chapter_title, chapter_preview in chapter_previews:
        st.markdown(f"### {chapter_title}")
        st.text_area("Preview", chapter_preview, height=100, key=chapter_title)

    if st.button("Generate MCQs"):
        all_mcqs = ""
        with st.spinner("Generating MCQs..."):
            for i, chapter in enumerate(chapters):
                chapter_title = get_chapter_title(chapter)
                prompt = (
                    f"Hãy tạo 10 câu hỏi trắc nghiệm cho nội dung của {chapter_title}. "
                    "Mỗi câu hỏi nên có 4 đáp án lựa chọn (A, B, C, D) và làm nổi bật đáp án đúng. "
                    "Đảm bảo các câu hỏi được phân bổ đều và bao quát các khái niệm chính của chương.\n\n"
                    f"Nội dung chương:\n{chapter}"
                )
                response = openai.ChatCompletion.create(
                    model="gpt-4o-mini",
                    messages=[{"role": "user", "content": prompt}],
                    temperature=0.7
                )
                mcq_response = response['choices'][0]['message']['content']
                all_mcqs += f"### MCQs for {chapter_title}\n{mcq_response}\n\n"

        st.subheader("Generated MCQs for All Chapters:")
        st.markdown(all_mcqs)
