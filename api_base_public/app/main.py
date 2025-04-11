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
    "remember": "MÔ TẢ, ĐỊNH NGHĨA, LIỆT KÊ, ĐỌC, KỂ TÊN, GỌI TÊN, GHI LẠI, LẶP LẠI, ĐỌC LẠI, THUẬT LẠI, NGHE, HIỂU, TÌM RA, TÌM CÂU TRẢ LỜI, NHẮC LẠI, KỂ LẠI, NHẬN BIẾT, NHẬN DẠNG, NHẬN DIỆN, XÁC ĐỊNH, TÌM, NHẬN RA, CHỌN, NỐI KẾT ĐIỂM PHÙ HỢP, SAO CHÉP/LẶP LẠI CHÍNH XÁC, NÊU RÕ, LẬP BẢNG, CHÉP LẠI, MÔ PHỎNG, SAO CHÉP, SẮP XẾP, KỂ, SẮP XẾP THEO THỨ TỰ, LÀM THEO, TÓM TẮT LẠI, TƯỞNG TƯỢNG, HÌNH DUNG, TRÍCH DẪN, NÊU RA, LOẠI BỎ, TRÌNH BÀY ĐẠI Ý, XEM XÉT, KIỂM TRA CHI TIẾT, GHI NHỚ",
    "understand": "HỎI, ĐẶT VẤN ĐỀ, XÁC ĐỊNH, NHẬN DẠNG, LIÊN HỆ, CHỈ RA, TRÍCH DẪN, TÌM XUẤT XỨ, SUY RA, PHỎNG ĐOÁN, PHÂN LOẠI, ĐÁNH GIÁ, NHẬN ĐỊNH, TÍNH TOÁN, ƯỚC TÍNH, ĐỊNH VỊ, SO SÁNH, ĐỐI CHIẾU, SẮP XẾP THỨ TỰ, CHUYỂN ĐỔI, DIỄN GIẢI, MÔ TẢ, NHẬN DIỆN, TÌM RA, PHÂN BIỆT, BÁO CÁO, KHÁM PHÁ, PHÁT HIỆN, TRÌNH BÀY, THẢO LUẬN, NGHIÊN CỨU, TÌM, NHẬN BIẾT, TRÌNH BÀY LẠI, NHẮC LẠI, ƯỚC LƯỢNG, PHÁN ĐOÁN, DỰ ĐOÁN, XEM LẠI, THỂ HIỆN, DIỄN ĐẠT, VIẾT LẠI, MỞ RỘNG, LỰA CHỌN, KHÁI QUÁT HÓA, TỔNG HỢP, ĐƯA RA, TÓM",
    "apply": "ÁP DỤNG, VẬN DỤNG, ĐIỀU KHIỂN, XỬ LÍ, TÍNH TOÁN, THÊM VÀO, SỬA ĐỔI, ĐIỀU CHỈNH, THAY ĐỔI, VẬN HÀNH, CHỌN LỰA, CHỌN LỌC, LỰA CHỌN, THỰC HÀNH, PHÂN LOẠI, PHÂN LOẠI CHỦ ĐỀ, ƯỚC LƯỢNG, DỰ ĐOÁN, DỰ BÁO, HOÀN THÀNH, CHUẨN BỊ, TẠO RA, XÂY DỰNG, LIÊN HỆ KIẾN THỨC, THUYẾT MINH, CHỨNG MINH, GIẢI THÍCH, BIỂU DIỄN, LẬP KẾ HOẠCH, SOẠN, VIẾT THÀNH KỊCH BẢN, BIÊN KỊCH, CHỈ RA, NÊU RA, SỬ DỤNG, PHÁC HOẠ, GIẢI QUYẾT, KHÁI QUÁT HÓA, TỔNG QUÁT HÓA, LOẠI TRỪ, SƠ ĐỒ HOÁ, THỂ HIỆN ĐỒ THỊ, VẼ BIỂU ĐỒ, MINH HOẠ, VIẾT, THÊM THÔNG TIN, CHIA NHỎ, DIỄN GIẢI, LÀM SÁNG TỎ, DỊCH, LIỆT KÊ, ĐÁNH GIÁ, NHẬN ĐỊNH, MÔ TẢ",
    "analyze": "PHÂN TÍCH, PHÂN BIỆT, KHU BIỆT, ĐÁNH GIÁ, KHÁM PHÁ, TÌM RA, PHÁT HIỆN, SẮP XẾP, CHIA NHỎ, PHÂN NHỎ, TÁCH NHỎ RA, TÍNH TOÁN, SOẠN, VIẾT THÀNH KỊCH BẢN, PHÂN LOẠI, PHẠM TRÙ HOÁ, PHÂN NHÓM, XEM XÉT, KIỂM TRA, THAY ĐỔI, THỬ NGHIỆM, LỰA CHỌN, XÁC ĐỊNH, MINH HỌA, KẾT HỢP, SUY LUẬN, GIẢI THÍCH, ƯỚC TÍNH, ĐIỀU HÀNH, VẬN DỤNG, XỬ LÍ, SO SÁNH, ĐỐI CHIẾU, PHẢN BIỆN, PHÊ BÌNH, BÌNH LUẬN, CHỨNG MINH, VẬN HÀNH, THIẾT KẾ, LẬP DÀN Ý, NÊU ĐẠI Ý, PHÁC THẢO, NHẬN RA, CHỈ RA, PHÁT TRIỂN, THỰC HIỆN, THỰC HÀNH, THỂ HIỆN ĐỒ THỊ, SƠ ĐỒ HÓA, ƯỚC ĐOÁN, DỰ ĐOÁN, DỰ BÁO, ĐẶT CÂU HỎI, ĐẶT VẤN ĐỀ, TẠO RA, CHẾ TẠO, SẮP XẾP KẾ HOẠCH, LIÊN HỆ, TÁCH RA, KHẢO SÁT, PHÂN CHIA",
    "evaluate": "ĐÁNH GIÁ, THẨM ĐỊNH, TẠO RA, SUY RA, SẮP XẾP, ĐẶT VẤN ĐỀ, ĐẶT GIẢ THIẾT, THU THẬP, TẬP HỢP LẠI, PHỐI HỢP, NHẬN ĐỊNH, ĐIỀU CHỈNH, PHÂN LOẠI, PHÂN CHIA, CHUẨN BỊ, SẮP XẾP LẠI, KẾT NỐI, XÂY DỰNG LẠI, LẬP LẠI, SO SÁNH, LIÊN HỆ, KẾT HỢP, SÁNG TÁC, TÁI CẤU TRÚC, KẾT LUẬN, RÀ SOÁT, XEM XÉT LẠI, SỬA LẠI, XÂY DỰNG, VIẾT LẠI, THIẾT LẬP, LẬP, TRANH LUẬN, XÉT ĐOÁN, PHÊ BÌNH, TỔNG KẾT, TÓM TẮT, BẢO VỆ, BIỆN HỘ, CHỨNG MINH, CHO Ý KIẾN, PHÁT TRIỂN, ĐỊNH GIÁ, THIẾT KẾ, CÂN NHẮC, XEM XÉT CẨN THẬN, VIẾT, XÁC LẬP CÔNG THỨC, TỔ CHỨC, SẮP XẾP THEO HỆ THỐNG",
    "create": "TRANH LUẬN, BIỆN LUẬN, TÍCH HỢP, KẾT HỢP, DIỄN DỊCH, DIỄN GIẢI, SÁNG TÁC, SÁNG TẠO, TÌM RA, PHÁT MINH RA, XÂY DỰNG, LẬP, THIẾT LẬP, LÀM RA, ĐỐI CHIẾU, PHÁT MINH, SÁNG CHẾ, TẠO RA, PHÁT TRIỂN, LẬP KẾ HOẠCH, SÁNG TẠO RA, CHẾ TẠO, ĐƯA RA, ĐỀ XUẤT, ĐẶT RA, PHÊ BÌNH, BÌNH LUẬN, ĐỀ NGHỊ, THIẾT KẾ, TỔNG HỢP, ƯỚC LƯỢNG, BIẾN ĐỔI",
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
                # print(filtered_questions)
                #them cau hoi da thoa man o tren vao mang
                questions.extend(filtered_questions)

                # #tao cau hoi
                # result = llm_generate.invoke({
                #     "document":document,
                #     "keyword": keyword,
                #     "n_question": n_question
                # })
                # n_question_not_relative = 0
                # #duyet qua tung cau hoi vua moi duoc tao ra 
                # for q in result.Question:        
                #     #danh gia tai lieu co lien quan den cau hoi va cau tra loi goi y =>(yes/no)
                #     score = llm_grade_question.invoke({
                #     "document":document,
                #     "question": q.question,
                #     "suggested_answer": q.answer
                # })
                #     print("\n")
                #     print(score)
                #     print("\n")
                #     if (score=="yes"):
                #         q.level=level
                #         questions.append(q)
                #     else:
                #         n_question_not_relative+=1


                # result = llm_generate.invoke({
                #         "document":document,
                #         "keyword": keyword,
                #         "n_question": n_question_not_relative
                # })

                # #so luong cau hoi khong lien quan trong tai lieu(document)
                # n_question_not_relative=0

                # #tao lai cau hoi khong lien quan den tai lieu
                # for q in result.Question:        
                #     #danh gia tai lieu co lien quan den cau hoi va cau tra loi goi y =>(yes/no)
                #     score = llm_grade_question.invoke({
                #     "document":document,
                #     "question": q.question,
                #     "suggested_answer": q.answer
                # })
                #     print("\n")
                #     print(score)
                #     print("\n")
                #     if (score=="yes"):
                #         q.level=level
                #         questions.append(q)
                #     else:
                #         n_question_not_relative+=1                    

                        

                # questions.extend(result.Question)
    print("\n====finish!====\n")
    return {"questions": questions}

