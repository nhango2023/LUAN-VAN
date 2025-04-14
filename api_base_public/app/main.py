from fastapi import FastAPI
from app.models.n_question import NQuestion
from fastapi.middleware.cors import CORSMiddleware
from fastapi import FastAPI, UploadFile, File, Form, HTTPException, Body
import fitz  # PyMuPDF
import docx
from llm.utils.split_document import SplitDocument

from llm.llm_level.llm import LLM_LEVEL
from llm.llm_level.grade_document_level_template import DocumentGrader

from llm.llm_generate_question.llm import LLM_GENERATE_QUESTION
from llm.llm_generate_question.generate_question_template import GenerateQuestion

from llm.llm_grade_question.llm import LLM_GRADE_QUESTION
from llm.llm_grade_question.grade_question_template import GradeDocument

from llm.utils.calculate_number_question_each_level import CalculateQuestion

# Tạo instance của FastAPI
app = FastAPI()



# Cấu hình CORS
app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],  # Cho phép tất cả nguồn (hoặc chỉ định danh sách ["http://example.com"])
    allow_credentials=True,
    allow_methods=["*"],  # Cho phép tất cả phương thức (GET, POST, PUT, DELETE, v.v.)
    allow_headers=["*"],  # Cho phép tất cả headers
)

# Include các router vào ứng dụng chính
# app.include_router(base.router)
# app.include_router(file_upload.router)



lst_keyword={
    "remember": "mô tả, định nghĩa, liệt kê, đọc, kể tên, gọi tên, ghi lại, lặp lại, đọc lại, thuật lại, nghe, hiểu, tìm ra, tìm câu trả lời, nhắc lại, kể lại, nhận biết, nhận dạng, nhận diện, xác định, tìm, nhận ra, chọn, nối kết điểm phù hợp, sao chép/lặp lại chính xác, nêu rõ, lập bảng, chép lại, mô phỏng, sao chép, sắp xếp, kể, sắp xếp theo thứ tự, làm theo, tóm tắt lại, tưởng tượng, hình dung, trích dẫn, nêu ra, loại bỏ, trình bày đại ý, xem xét, kiểm tra chi tiết, ghi nhớ",
    "understand": "hỏi, đặt vấn đề, xác định, nhận dạng, liên hệ, chỉ ra, trích dẫn, tìm xuất xứ, suy ra, phỏng đoán, phân loại, đánh giá, nhận định, tính toán, ước tính, định vị, so sánh, đối chiếu, sắp xếp thứ tự, chuyển đổi, diễn giải, mô tả, nhận diện, tìm ra, phân biệt, báo cáo, khám phá, phát hiện, trình bày, thảo luận, nghiên cứu, tìm, nhận biết, trình bày lại, nhắc lại, ước lượng, phán đoán, dự đoán, xem lại, thể hiện, diễn đạt, viết lại, mở rộng, lựa chọn, khái quát hóa, tổng hợp, đưa ra, tóm",
    "apply": "áp dụng, vận dụng, điều khiển, xử lí, tính toán, thêm vào, sửa đổi, điều chỉnh, thay đổi, vận hành, chọn lựa, chọn lọc, lựa chọn, thực hành, phân loại, phân loại chủ đề, ước lượng, dự đoán, dự báo, hoàn thành, chuẩn bị, tạo ra, xây dựng, liên hệ kiến thức, thuyết minh, chứng minh, giải thích, biểu diễn, lập kế hoạch, soạn, viết thành kịch bản, biên kịch, chỉ ra, nêu ra, sử dụng, phác họa, giải quyết, khái quát hóa, tổng quát hóa, loại trừ, sơ đồ hoá, thể hiện đồ thị, vẽ biểu đồ, minh họa, viết, thêm thông tin, chia nhỏ, diễn giải, làm sáng tỏ, dịch, liệt kê, đánh giá, nhận định, mô tả",
    "analyze": "phân tích, phân biệt, khu biệt, đánh giá, khám phá, tìm ra, phát hiện, sắp xếp, chia nhỏ, phân nhỏ, tách nhỏ ra, tính toán, soạn, viết thành kịch bản, phân loại, phạm trù hoá, phân nhóm, xem xét, kiểm tra, thay đổi, thử nghiệm, lựa chọn, xác định, minh họa, kết hợp, suy luận, giải thích, ước tính, điều hành, vận dụng, xử lí, so sánh, đối chiếu, phản biện, phê bình, bình luận, chứng minh, vận hành, thiết kế, lập dàn ý, nêu đại ý, phác thảo, nhận ra, chỉ ra, phát triển, thực hiện, thực hành, thể hiện đồ thị, sơ đồ hóa, ước đoán, dự đoán, dự báo, đặt câu hỏi, đặt vấn đề, tạo ra, chế tạo, sắp xếp kế hoạch, liên hệ, tách ra, khảo sát, phân chia",
    "evaluate": "đánh giá, thẩm định, tạo ra, suy ra, sắp xếp, đặt vấn đề, đặt giả thiết, thu thập, tập hợp lại, phối hợp, nhận định, điều chỉnh, phân loại, phân chia, chuẩn bị, sắp xếp lại, kết nối, xây dựng lại, lập lại, so sánh, liên hệ, kết hợp, sáng tác, tái cấu trúc, kết luận, rà soát, xem xét lại, sửa lại, xây dựng, viết lại, thiết lập, lập, tranh luận, xét đoán, phê bình, tổng kết, tóm tắt, bảo vệ, biện hộ, chứng minh, cho ý kiến, phát triển, định giá, thiết kế, cân nhắc, xem xét cẩn thận, viết, xác lập công thức, tổ chức, sắp xếp theo hệ thống",
    "create": "tranh luận, biện luận, tích hợp, kết hợp, diễn dịch, diễn giải, sáng tác, sáng tạo, tìm ra, phát minh ra, xây dựng, lập, thiết lập, làm ra, đối chiếu, phát minh, sáng chế, tạo ra, phát triển, lập kế hoạch, sáng tạo ra, chế tạo, đưa ra, đề xuất, đặt ra, phê bình, bình luận, đề nghị, thiết kế, tổng hợp, ước lượng, biến đổi"
}

@app.get("/")
def read_root():
    return {"message": "Welcome to my FastAPI application"}

  

def generate_and_filter_questions(document, keyword, level, n_question, llm_generate, llm_grade_question):
    """
    Sinh và lọc các câu hỏi trắc nghiệm theo cấp độ Bloom's taxonomy có liên quan với tài liệu

    Parameters:
        document (str): Nội dung đoạn văn bản gốc dùng làm nguồn để tạo câu hỏi.
        keyword (str): Chuỗi các từ khóa liên quan đến cấp độ Bloom, cần được sử dụng trong nội dung câu hỏi.
        level (str): Cấp độ Bloom hiện tại (ví dụ: "remember", "understand", ...).
        n_question (int): Số lượng câu hỏi cần tạo ra cho đoạn tài liệu này.
        llm_generate (RunnableSequence): Pipeline của mô hình tạo câu hỏi (từ LangChain).
        llm_grade_question (RunnableSequence): Pipeline của mô hình đánh giá tính liên quan giữa câu hỏi, tài liệu và đáp án.
    Returns:
        List[QuestionItem]: Danh sách các câu hỏi đã được tạo và xác thực là liên quan đến nội dung tài liệu.
    
    Notes:
        - Hàm sẽ cố gắng tạo thêm câu hỏi nếu số lượng ban đầu chưa đủ.
        - Giới hạn số lần thử lại (max_attempts = 3) để tránh vòng lặp vô hạn nếu không thể tạo đủ câu hỏi phù hợp.
    """
    questions = []
    attempts = 0
    max_attempts = 3  # tránh lặp vô hạn nếu mãi không tạo được câu phù hợp

    while len(questions) < n_question:
        needed = n_question - len(questions)
        
        if (attempts==0):
            print(f"\ntao lai cau hoi level:{level}...\n")
        else:
            print(f"\ntao cau hoi level:{level}...\n")
        
        result = llm_generate.invoke({
            "document": document,
            "keyword": keyword,
            "n_question": needed
        })
        print("\ndanh gia cau hoi....\n")
        for q in result.Question:
            # print(f"question: {q.question}\nanswer: {q.answer}\ndocument: {document}\n")
            if (attempts<max_attempts):
                score = llm_grade_question.invoke({
                    "document": document,
                    "question": q.question,
                    "suggested_answer": q.answer
                })
                print(f"\nsore: {score.binary_score}\n")
                if score.binary_score == "yes":
                    q.level = level
                    # print(f"new question: {q}")
                    questions.append(q)
            else:
                print("\nattempt: ==max_attempt")
                q.level = level
                questions.append(q)
        
        attempts += 1
        print(f"\nattempts: {attempts}\n")

    return questions   


@app.post("/question/create")
async def create_question(
    file: UploadFile = File(...),
    Nquestion_json: str = Form(...)
):
    Nquestion = NQuestion.model_validate_json(Nquestion_json)
    
    n_question = {
    "remember": Nquestion.remember,
    "understand": Nquestion.understand,
    "apply": Nquestion.apply,
    "analyze": Nquestion.analyze,
    "evaluate": Nquestion.evaluate,
    "create": Nquestion.create,
    }
    # Check file type
    if file.content_type not in ["application/pdf", "application/vnd.openxmlformats-officedocument.wordprocessingml.document"]:
        raise HTTPException(status_code=400, detail="Unsupported file type.")

    # Read file content into memory
    contents = await file.read()

    text = ""

    if file.filename.endswith(".pdf"):
        with fitz.open(stream=contents, filetype="pdf") as doc:
            for page in doc:
                text += page.get_text()

    elif file.filename.endswith(".docx"):
        # Save contents temporarily to load with python-docx
        import tempfile
        with tempfile.NamedTemporaryFile(delete=False, suffix=".docx") as tmp:
            tmp.write(contents)
            tmp_path = tmp.name

        doc = docx.Document(tmp_path)
        text = "\n".join([para.text for para in doc.paragraphs])
    
    ##chia tai lieu thanh cac doan nho
    splitter=SplitDocument()
    splited_documents = splitter.process_text(text)
    
    print(f"\n the number of paragraphs: {len(splited_documents)}\n")

    # Khởi tạo llm grader xac dinh level
    llm_grader_level = DocumentGrader(LLM_LEVEL().get_llm()).get_chain()

    #khoi tao lop tinh toan moi cap do co bao nhieu cau hoi
    calculate_question=CalculateQuestion()

    print("\nDetect levels of each paragraph....\n")
    #goi api xac dinh cap do
    for idx, text in enumerate(splited_documents):
        result = llm_grader_level.invoke({"document": splited_documents[idx].page_content})
        print(result)
        calculate_question.calculate_level(idx, result.level)

    print("\n check there are levels not detected in paragraphs\n")
    calculate_question.fallback_if_empty_level()


    print("\nindex of paragraph following its level\n")    
    for level, questions in calculate_question.idx_doc_by_level.items():
        print(f"{level}: {questions}")

    
    for level, count in n_question.items():
        #tinh so luong cau hoi cho moi cap do va cho moi doan van ban
        calculate_question.calculate_number_question_for_each_level(count, level)


    print("\nnumber of questions for each paragraph arranged in order of paragraph's index \n")
    for level, questions in calculate_question.n_question_for_each_paragraph.items():
        print(f"{level}: {questions}")

    #mang cau hoi
    questions=[]

    # Khởi tạo llm tao cau hoi
    llm_generate = GenerateQuestion(LLM_GENERATE_QUESTION().get_llm()).get_chain()

    # Khởi tạo llm danh gia muc do lien quan cua tai lieu voi cau hoi va cau tra loi goi y
    llm_grade = GradeDocument(LLM_GRADE_QUESTION().get_llm()).get_chain()

    #duyet qua tung level va so luong cau hoi tung level
    for level, count in n_question.items():
        #so luong paragraph thuoc level hien tai
        n_paragraph=len(calculate_question.idx_doc_by_level[level])
        if (n_paragraph>0):
            #duyet qua index cua paragraph
            for idx, idx_para in enumerate(calculate_question.idx_doc_by_level[level]):
                #tai lieu
                document = splited_documents[idx_para].page_content
                #so luong cau hoi cho tai lieu
                n_q = calculate_question.n_question_for_each_paragraph[level][idx]
                #tu khoa cua cap do
                keyword=lst_keyword[level]
                print(f'\n{level}-keyword: {keyword}\n')
                #goi ham tao cau hoi va danh gia do lien quan cua tai lieu
                filtered_questions = generate_and_filter_questions(
                document=document,
                keyword=keyword,
                level=level,
                n_question=n_q,
                llm_generate=llm_generate,
                llm_grade_question=llm_grade
                )
                print(f'\n{filtered_questions}\n')
                #them cau hoi da thoa man o tren vao mang
                questions.extend(filtered_questions)

                
    print("\n====finish!====\n")
    return {"questions": questions}

