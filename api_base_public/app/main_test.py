from llm.utils.split_document import SplitDocument

from llm.llm_level.llm import LLM_LEVEL
from llm.llm_level.grade_document_level_template import DocumentGrader

from llm.llm_generate_question.llm import LLM_GENERATE_QUESTION
from llm.llm_generate_question.generate_question_template import GenerateQuestion

import fitz  # PyMuPDF
from llm.utils.calculate_number_question_each_level import CalculateQuestion

#fake n_question from user
n_question = {
    "remember": 8,
    "understand": 8,
    "apply": 10,
    "analyze": 10,
    "evaluate": 8,
    "create": 8,
}

lst_keyword={
    "remember": "MÔ TẢ, ĐỊNH NGHĨA, LIỆT KÊ, ĐỌC, KỂ TÊN, GỌI TÊN, GHI LẠI, LẶP LẠI, ĐỌC LẠI, THUẬT LẠI, NGHE, HIỂU, TÌM RA, TÌM CÂU TRẢ LỜI, NHẮC LẠI, KỂ LẠI, NHẬN BIẾT, NHẬN DẠNG, NHẬN DIỆN, XÁC ĐỊNH, TÌM, NHẬN RA, CHỌN, NỐI KẾT ĐIỂM PHÙ HỢP, SAO CHÉP/LẶP LẠI CHÍNH XÁC, NÊU RÕ, LẬP BẢNG, CHÉP LẠI, MÔ PHỎNG, SAO CHÉP, SẮP XẾP, KỂ, SẮP XẾP THEO THỨ TỰ, LÀM THEO, TÓM TẮT LẠI, TƯỞNG TƯỢNG, HÌNH DUNG, TRÍCH DẪN, NÊU RA, LOẠI BỎ, TRÌNH BÀY ĐẠI Ý, XEM XÉT, KIỂM TRA CHI TIẾT, GHI NHỚ",
    "understand": "HỎI, ĐẶT VẤN ĐỀ, XÁC ĐỊNH, NHẬN DẠNG, LIÊN HỆ, CHỈ RA, TRÍCH DẪN, TÌM XUẤT XỨ, SUY RA, PHỎNG ĐOÁN, PHÂN LOẠI, ĐÁNH GIÁ, NHẬN ĐỊNH, TÍNH TOÁN, ƯỚC TÍNH, ĐỊNH VỊ, SO SÁNH, ĐỐI CHIẾU, SẮP XẾP THỨ TỰ, CHUYỂN ĐỔI, DIỄN GIẢI, MÔ TẢ, NHẬN DIỆN, TÌM RA, PHÂN BIỆT, BÁO CÁO, KHÁM PHÁ, PHÁT HIỆN, TRÌNH BÀY, THẢO LUẬN, NGHIÊN CỨU, TÌM, NHẬN BIẾT, TRÌNH BÀY LẠI, NHẮC LẠI, ƯỚC LƯỢNG, PHÁN ĐOÁN, DỰ ĐOÁN, XEM LẠI, THỂ HIỆN, DIỄN ĐẠT, VIẾT LẠI, MỞ RỘNG, LỰA CHỌN, KHÁI QUÁT HÓA, TỔNG HỢP, ĐƯA RA, TÓM",
    "apply": "ÁP DỤNG, VẬN DỤNG, ĐIỀU KHIỂN, XỬ LÍ, TÍNH TOÁN, THÊM VÀO, SỬA ĐỔI, ĐIỀU CHỈNH, THAY ĐỔI, VẬN HÀNH, CHỌN LỰA, CHỌN LỌC, LỰA CHỌN, THỰC HÀNH, PHÂN LOẠI, PHÂN LOẠI CHỦ ĐỀ, ƯỚC LƯỢNG, DỰ ĐOÁN, DỰ BÁO, HOÀN THÀNH, CHUẨN BỊ, TẠO RA, XÂY DỰNG, LIÊN HỆ KIẾN THỨC, THUYẾT MINH, CHỨNG MINH, GIẢI THÍCH, BIỂU DIỄN, LẬP KẾ HOẠCH, SOẠN, VIẾT THÀNH KỊCH BẢN, BIÊN KỊCH, CHỈ RA, NÊU RA, SỬ DỤNG, PHÁC HOẠ, GIẢI QUYẾT, KHÁI QUÁT HÓA, TỔNG QUÁT HÓA, LOẠI TRỪ, SƠ ĐỒ HOÁ, THỂ HIỆN ĐỒ THỊ, VẼ BIỂU ĐỒ, MINH HOẠ, VIẾT, THÊM THÔNG TIN, CHIA NHỎ, DIỄN GIẢI, LÀM SÁNG TỎ, DỊCH, LIỆT KÊ, ĐÁNH GIÁ, NHẬN ĐỊNH, MÔ TẢ",
    "analyze": "PHÂN TÍCH, PHÂN BIỆT, KHU BIỆT, ĐÁNH GIÁ, KHÁM PHÁ, TÌM RA, PHÁT HIỆN, SẮP XẾP, CHIA NHỎ, PHÂN NHỎ, TÁCH NHỎ RA, TÍNH TOÁN, SOẠN, VIẾT THÀNH KỊCH BẢN, PHÂN LOẠI, PHẠM TRÙ HOÁ, PHÂN NHÓM, XEM XÉT, KIỂM TRA, THAY ĐỔI, THỬ NGHIỆM, LỰA CHỌN, XÁC ĐỊNH, MINH HỌA, KẾT HỢP, SUY LUẬN, GIẢI THÍCH, ƯỚC TÍNH, ĐIỀU HÀNH, VẬN DỤNG, XỬ LÍ, SO SÁNH, ĐỐI CHIẾU, PHẢN BIỆN, PHÊ BÌNH, BÌNH LUẬN, CHỨNG MINH, VẬN HÀNH, THIẾT KẾ, LẬP DÀN Ý, NÊU ĐẠI Ý, PHÁC THẢO, NHẬN RA, CHỈ RA, PHÁT TRIỂN, THỰC HIỆN, THỰC HÀNH, THỂ HIỆN ĐỒ THỊ, SƠ ĐỒ HÓA, ƯỚC ĐOÁN, DỰ ĐOÁN, DỰ BÁO, ĐẶT CÂU HỎI, ĐẶT VẤN ĐỀ, TẠO RA, CHẾ TẠO, SẮP XẾP KẾ HOẠCH, LIÊN HỆ, TÁCH RA, KHẢO SÁT, PHÂN CHIA",
    "evaluate": "ĐÁNH GIÁ, THẨM ĐỊNH, TẠO RA, SUY RA, SẮP XẾP, ĐẶT VẤN ĐỀ, ĐẶT GIẢ THIẾT, THU THẬP, TẬP HỢP LẠI, PHỐI HỢP, NHẬN ĐỊNH, ĐIỀU CHỈNH, PHÂN LOẠI, PHÂN CHIA, CHUẨN BỊ, SẮP XẾP LẠI, KẾT NỐI, XÂY DỰNG LẠI, LẬP LẠI, SO SÁNH, LIÊN HỆ, KẾT HỢP, SÁNG TÁC, TÁI CẤU TRÚC, KẾT LUẬN, RÀ SOÁT, XEM XÉT LẠI, SỬA LẠI, XÂY DỰNG, VIẾT LẠI, THIẾT LẬP, LẬP, TRANH LUẬN, XÉT ĐOÁN, PHÊ BÌNH, TỔNG KẾT, TÓM TẮT, BẢO VỆ, BIỆN HỘ, CHỨNG MINH, CHO Ý KIẾN, PHÁT TRIỂN, ĐỊNH GIÁ, THIẾT KẾ, CÂN NHẮC, XEM XÉT CẨN THẬN, VIẾT, XÁC LẬP CÔNG THỨC, TỔ CHỨC, SẮP XẾP THEO HỆ THỐNG",
    "create": "TRANH LUẬN, BIỆN LUẬN, TÍCH HỢP, KẾT HỢP, DIỄN DỊCH, DIỄN GIẢI, SÁNG TÁC, SÁNG TẠO, TÌM RA, PHÁT MINH RA, XÂY DỰNG, LẬP, THIẾT LẬP, LÀM RA, ĐỐI CHIẾU, PHÁT MINH, SÁNG CHẾ, TẠO RA, PHÁT TRIỂN, LẬP KẾ HOẠCH, SÁNG TẠO RA, CHẾ TẠO, ĐƯA RA, ĐỀ XUẤT, ĐẶT RA, PHÊ BÌNH, BÌNH LUẬN, ĐỀ NGHỊ, THIẾT KẾ, TỔNG HỢP, ƯỚC LƯỢNG, BIẾN ĐỔI",
}

with fitz.open("D:/HOC/LUAN VAN/LUAN VAN/api_base_public/app/TLHĐC-pages-1.pdf") as doc:
    content = ""
    for page in doc:
        content += page.get_text()

splitter=SplitDocument()
splited_documents = splitter.process_text(content)


# Khởi tạo llm grader xac dinh level
llm_grader_level = DocumentGrader(LLM_LEVEL().get_llm()).get_chain()

#khoi tao lop tinh toan moi cap do co bao nhieu doan
calculate_question=CalculateQuestion()

#goi api xac dinh cap do
for idx, text in enumerate(splited_documents):
    result = llm_grader_level.invoke({"document": splited_documents[idx].page_content})
    print(result)
    calculate_question.calculate_level(idx, result.level)


for level, count in n_question.items():
    #tinh so luong cau hoi cho moi cap do va cho moi doan van ban
    calculate_question.calculate_number_question_for_each_level(count, level)

for level, questions in calculate_question.idx_doc_by_level.items():
    print(f"{level}: {questions}")

for level, questions in calculate_question.n_question_for_each_paragraph.items():
    print(f"{level}: {questions}")

#mang cau hoi
questions=[]

# Khởi tạo llm tao cau hoi
llm_generate = GenerateQuestion(LLM_GENERATE_QUESTION().get_llm()).get_chain()

for level, count in n_question.items():
    n_paragraph=len(calculate_question.idx_doc_by_level[level])
    if (n_paragraph>0):
        for idx, idx_para in enumerate(calculate_question.idx_doc_by_level[level]):
            document = splited_documents[idx_para].page_content
            n_question = calculate_question.n_question_for_each_paragraph[level][idx]
            keyword=lst_keyword[level]
            # with open("prompt.txt", "a", encoding="utf-8") as file:
            #     file.write("\n==================\n")
            #     file.write(f"Document:\n{document}\n")
            #     file.write(f"Number of Questions: {n_question}\n")
            #     file.write(f"Keywords: {keyword}\n")
            #     file.flush() 
            result = llm_generate.invoke({
                "document":document,
                "keyword": keyword,
                "n_question": n_question
            })
            for q in result.Question:
                q.level = level
                q.idx_paragraph = idx_para
            questions.extend(result.Question)

for q in questions:
    print("Câu hỏi:", q.question)
    print("Đáp án:", q.options)
    print("Đáp án đúng:", q.answer)
    print("Cấp độ:", q.level)
    print("Đoạn văn số:", q.idx_paragraph)
    print("=" * 50)



# result = llm_generate.invoke({
#     "document": splited_documents[0].page_content,
#     "keyword": "MÔ TẢ, ĐỊNH NGHĨA, LIỆT KÊ, ĐỌC, KỂ TÊN, GỌI TÊN, GHI LẠI, LẶP LẠI, ĐỌC LẠI, THUẬT LẠI, NGHE, HIỂU, TÌM RA, TÌM CÂU TRẢ LỜI, NHẮC LẠI, KỂ LẠI, NHẬN BIẾT, NHẬN DẠNG, NHẬN DIỆN, XÁC ĐỊNH, TÌM, NHẬN RA, CHỌN, NỐI KẾT ĐIỂM PHÙ HỢP, SAO CHÉP/LẶP LẠI CHÍNH XÁC, NÊU RÕ, LẬP BẢNG, CHÉP LẠI, MÔ PHỎNG, SAO CHÉP, SẮP XẾP, KỂ, SẮP XẾP THEO THỨ TỰ, LÀM THEO, TÓM TẮT LẠI, TƯỞNG TƯỢNG, HÌNH DUNG, TRÍCH DẪN, NÊU RA, LOẠI BỎ, TRÌNH BÀY ĐẠI Ý, XEM XÉT, KIỂM TRA CHI TIẾT, GHI NHỚ",
#     "n_question": 5
# })
# from pprint import pprint
# pprint(result)
# print("Số lượng câu hỏi:", len(result.Question))

    