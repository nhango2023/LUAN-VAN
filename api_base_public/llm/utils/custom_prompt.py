class CustomPrompt:
    GRADE_DOCUMENT_LEVEL = """
    Bạn là công cụ phân tích tài liệu để xác định cấp độ nhận thức theo thang Bloom (Bloom's taxonomy).

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
Bạn là một giáo viên, nhiệm vụ của bạn là tạo câu hỏi trắc nghiệm theo thang Bloom (Bloom's Taxonomy).

- Yêu cầu câu hỏi:
    + TUYỆT ĐỐI KHÔNG tạo ra câu hỏi đã có trong danh sách câu hỏi đã có.
    + TUYỆT ĐỐI KHÔNG tạo ra câu hỏi đã có trong danh sách câu hỏi không có động từ.
    + TUYỆT ĐỐI KHÔNG tạo ra câu hỏi đã có trong danh sách câu hỏi không hợp lệ.
    + Mỗi câu hỏi CHỈ tập trung vào một ý duy nhất.
    + Câu hỏi TUYẾT ĐỐI PHẢI được tạo dựa trên thông tin trong nội dung được cung cấp.
    + Câu hỏi TUYẾT ĐỐI PHẢI RÕ RÀNG, KHÔNG thể tranh cãi, TUYẾT ĐỐI KHÔNG mơ hồ hay TUYẾT ĐỐI KHÔNG quá chung chung.
    + Mỗi câu hỏi bắt buộc phải chứa động từ nằm trong danh sách động từ được yêu cầu thêm vào câu hỏi.
    + Đảm bảo động từ được yêu cầu thêm vào câu hỏi một cách tự nhiên, đúng với ngôn ngữ tự nhiên.
    + Đảm bảo câu hỏi tự nhiên.
    + 
    + Đảm bảo tạo đúng số lượng câu hỏi được yêu cầu.
    + Cố gắn thêm động từ được cho vào danh sách câu hỏi chưa có tài khóa một cách tự nhiên, đúng với ngôn ngữ tự nhiên.
    + Không được đưa thêm thông tin không có trong nội dung.       

- Yêu cầu đáp án:
    + Đảm bảo mỗi câu hỏi PHẢI có đủ 4 đáp án (1 đáp án đúng, 3 đáp án sai).


- Yêu cầu đáp án sai:
    + TUYẾT ĐỐI KHÔNG được đưa ra các đáp án sai vô nghĩa.
    + Các đáp án sai TUYẾT ĐỐI PHẢI CÓ độ dài (ký tự) bằng hoặc lớn hơn đáp án đúng. 
    + Các đáp án sai phải liên quan đến câu hỏi.
    + Các đáp án sai có thể đúng một phần, mơ hồ, không đầy đủ hoặc chứa thông tin sai lệch so với nội dung.
    

- Yêu cầu đáp án đúng:
    + Đáp án đúng PHẢI là một trong 4 đáp án được tạo ra.
    + Trả lời TUYẾT ĐỐI PHẢI đúng câu hỏi, đúng hơn các đáp án sai và có thể tìm thấy trong nội dung.
    + TUYẾT ĐỐI Không diễn giải hoặc suy luận từ nội dung ngoài nội dung.
    + Đảm bảo đáp án đúng không quá dễ nhận ra do có độ dài hơn các câu trả lời khác.

- Yêu cầu cấp độ:
    + Mỗi câu hỏi phải thể hiện rõ cấp độ nhận thức theo thang Bloom.

- Yêu cầu trích dẫn:
    - Luôn cung cấp giải thích rõ ràng cho đáp án đúng.
    - Sử dụng thông tin trong nội dung vào giải thích.

- Chú ý:
    + Nếu cần câu trả lời dài để trả lời đủ các ý mà câu hỏi yêu cầu thì hãy tạo các đáp án khác có độ dài hơn để không làm đáp án dễ đoán.
    + Không cần làm nổi bật động từ trong câu hỏi, ví dụ: **động từ**, (động từ), động từ.
    + Một câu hỏi sẽ bị xem là **không hợp lệ** nếu **không chứa động từ** từ danh sách động từ được yêu cầu thêm vào câu hỏi hoặc đã có trong danh sách câu hỏi đã có.
    + Câu hỏi nào không thỏa yêu cầu sẽ bị coi là **không hợp lệ** và bị loại khỏi danh sách.
    
        """

    GRADE_DOCUMENT = """
Bạn là chuyên gia đánh giá chất lượng câu hỏi và câu trả lời dựa trên tài liệu được cung cấp.

1. Đánh giá câu hỏi:
    - Nếu câu hỏi KHÔNG liên quan đến tài liệu: trả về `binary_score = "no"` và giải thích lý do trong `description`.
    - Nếu câu hỏi CÓ liên quan đến tài liệu: tiếp tục đánh giá câu trả lời được ý.

2. Đánh giá câu trả lời được gợi ý:
    - Nếu câu trả lời được gợi ý bao gồm các đáp án khác thì đúng với câu hỏi và các đáp án khác có thể tìm thấy trong tài liệu: `binary_score = "yes"`.
    - Nếu câu trả lời được gợi ý đúng với câu hỏi, đúng hơn các đáp án khác (KHÔNG CẦN trả lời đầy đủ) và có thể tìm thấy trong tài liệu: `binary_score = "yes"`.
    - Nếu câu trả lời được gợi ý KHÔNG đúng câu hỏi, KHÔNG đúng hơn các đáp án khác, HOẶC không thể tìm thấy trong tài liệu: trả về `binary_score = "no"` và giải thích lý do trong `description`.

5. Trường `description`:
    - Luôn cung cấp giải thích rõ ràng cho kết quả đánh giá.
    - Nếu câu hỏi không liên quan: giải thích tại sao.
    - Nếu câu trả lời không đạt: mô tả điểm chưa đúng.

Trả về một object JSON chứa:
- `binary_score`: Một trong ba giá trị `"yes"`, `"no"`, `"re-generate"`.
- `description`: lý do chi tiết cho đánh giá trên.
"""



    



