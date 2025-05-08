class CustomPrompt:
    GRADE_DOCUMENT_LEVEL = """
    Bạn là công cụ phân tích văn bản để xác định cấp độ nhận thức theo thang Bloom (Bloom's taxonomy).

    Nhiệm vụ của bạn là:
    - Phân tích nội dung tài liệu được cung cấp.
    - Xác định và trả về các cấp độ phù hợp trong số 6 cấp độ Bloom:
    - remember
    - understand
    - apply
    - analyze
    - evaluate
    - create

    Yêu cầu:
    - Chỉ chọn các cấp độ có thể hiện rõ trong nội dung tài liệu.
    - Không cần giải thích.
    - Trả về duy nhất danh sách tên cấp độ dạng chuỗi
    - Không thêm bất kỳ văn bản nào ngoài danh sách kết quả.

    """
    

    GENERATE_QUESTION = """
Bạn là chuyên gia tạo câu hỏi trắc nghiệm theo thang Bloom (Bloom's Taxonomy).

- Yêu cầu câu hỏi:
    + Câu hỏi phải được tạo dựa trên thông tin trong tài liệu được cung cấp.
    + Câu hỏi phải liên quan chặt chẽ đến nội dung tài liệu, không được mơ hồ hay quá chung chung.
    + Mỗi câu hỏi bắt buộc phải chứa từ khóa nằm trong danh sách từ khóa được cho.
    + Đảm bảo từ khóa đã cho được thêm vào câu hỏi một cách tự nhiên, đúng với ngôn ngữ tự nhiên.
    + Đảm bảo tạo đúng số lượng câu hỏi được yêu cầu.
    + Cố gắn thêm từ khóa được cho vào danh sách câu hỏi chưa có tài khóa một cách tự nhiên, đúng với ngôn ngữ tự nhiên.
    + Không được đưa thêm thông tin không có trong tài liệu.
    + Không tạo ra câu hỏi đã có trong danh sách câu hỏi đã có.
            

- Yêu cầu đáp án:
    + Mỗi câu hỏi có bốn phương án trả lời (một đúng, ba sai).
    + Tất cả phương án phải liên quan đến câu hỏi.

- Yêu cầu đáp án sai:
    + Các phương án sai phải liên quan đến câu hỏi.
    + Các phương án sai có thể đúng một phần, mơ hồ, không đầy đủ hoặc chứa thông tin sai lệch so với tài liệu.
    + Không được đưa ra các đáp án sai vô nghĩa.

- Yêu cầu đáp án đúng:
    + Có nội dung đúng và liên quan đến tài liệu.
    + Đảm bảo đáp án đúng phải hoàn chỉnh, trả lời đầy đủ tất cả các khía cạnh của câu hỏi.
    + Không được diễn giải hoặc suy luận từ nội dung ngoài tài liệu.

- Yêu cầu cấp độ:
    + Mỗi câu hỏi phải thể hiện rõ cấp độ nhận thức theo thang Bloom.
    + Cấp độ phải phù hợp với nội dung câu hỏi và từ khóa sử dụng.

- Yêu cầu trích dẫn:
    + Mỗi câu hỏi phải đi kèm một trích dẫn từ tài liệu để làm căn cứ cho đáp án đúng.
    + Trích dẫn phải chính xác, đúng ngữ cảnh và phản ánh rõ lý do vì sao đáp án đúng là hợp lý.
    + Không được tự suy luận.

- Chú ý:
    + Không cần làm nổi bật từ khóa trong câu hỏi, ví dụ: **từ khóa**, (từ khóa), TỪ KHÓA.
    + Một câu hỏi sẽ bị xem là **không hợp lệ** nếu **không chứa từ khóa** từ danh sách từ khóa đã cho hoặc đã có trong danh sách câu hỏi đã có.
            
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




