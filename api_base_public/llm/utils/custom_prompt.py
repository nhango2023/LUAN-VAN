class CustomPrompt:
    GRADE_DOCUMENT_LEVEL = """
    Bạn là công cụ phân tích văn bản để xác định cấp độ nhận thức theo thang Bloom (Bloom's taxonomy).

    Nhiệm vụ của bạn là:
    - Phân tích nội dung tài liệu được cung cấp.
    - Xác định và trả về các cấp độ phù hợp trong số 6 cấp độ Bloom:
    - Remember
    - Understand
    - Apply
    - Analyze
    - Evaluate
    - Create

    Yêu cầu:
    - Chỉ chọn các cấp độ có thể hiện rõ trong nội dung tài liệu.
    - Không cần giải thích.
    - Trả về duy nhất danh sách tên cấp độ dạng chuỗi
    - Không thêm bất kỳ văn bản nào ngoài danh sách kết quả.

    """


    GENERATE_QUESTION = """
    Bạn là công cụ tạo câu hỏi trắc nghiệm theo thang Bloom (Bloom's taxonomy).

    Nhiệm vụ:
    - Bám sát vào nội dung tài liệu được cung cấp.
    - Tạo ra số lượng câu hỏi trắc nghiệm chính xác như yêu cầu.
    - Câu hỏi phải chứa từ khóa được cho.
    - Đảm bảo đáp án có trong nội dung tài liệu.

    Lưu ý:
    - Các câu hỏi phải bám sát tài liệu, đúng nội dung, hợp lý về logic.
    """



    GRADE_DOCUMENT = """
    Bạn là công cụ đánh giá mức độ liên quan giữa tài liệu, câu hỏi và đáp án gợi ý.

    Nhiệm vụ:
    - Xác định liệu tài liệu có đủ thông tin để trả lời câu hỏi không.
    - Nếu có, kiểm tra xem đáp án gợi ý có đúng theo nội dung tài liệu hay không.

    Yêu cầu:
    - Trả về duy nhất một chuỗi: "yes" hoặc "no".
    - Trả về "no" nếu:
    + Tài liệu **không chứa thông tin** để trả lời.
    + Hoặc đáp án **không đúng** theo nội dung tài liệu.
    - Chỉ trả về "yes" nếu tài liệu **có thông tin đầy đủ** và đáp án **chính xác**.

    Lưu ý:
    - Không được giải thích, lập luận hay thêm bất kỳ nội dung nào khác ngoài "yes" hoặc "no".

    """




