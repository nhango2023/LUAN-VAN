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
    + TUYỆT ĐỐI KHÔNG tạo ra câu hỏi đã có trong danh sách câu hỏi đã có.
    + TUYỆT ĐỐI KHÔNG tạo ra câu hỏi đã có trong danh sách câu hỏi không có động từ.
    + Câu hỏi phải được tạo dựa trên thông tin trong tài liệu được cung cấp.
    + Câu hỏi phải liên quan chặt chẽ đến nội dung tài liệu, không được mơ hồ hay quá chung chung.
    + Mỗi câu hỏi bắt buộc phải chứa động từ nằm trong danh sách động từ được yêu cầu thêm vào câu hỏi.
    + Đảm bảo động từ được yêu cầu thêm vào câu hỏi một cách tự nhiên, đúng với ngôn ngữ tự nhiên.
    + Đảm bảo tạo đúng số lượng câu hỏi được yêu cầu.
    + Cố gắn thêm động từ được cho vào danh sách câu hỏi chưa có tài khóa một cách tự nhiên, đúng với ngôn ngữ tự nhiên.
    + Không được đưa thêm thông tin không có trong tài liệu.       

- Yêu cầu đáp án:
    + Mỗi câu hỏi có bốn phương án trả lời (một đúng, ba sai).
    + Tất cả phương án phải liên quan đến câu hỏi.

- Yêu cầu đáp án sai:
    + Các phương án sai phải liên quan đến câu hỏi.
    + Các phương án sai có thể đúng một phần, mơ hồ, không đầy đủ hoặc chứa thông tin sai lệch so với tài liệu.
    + Không được đưa ra các đáp án sai vô nghĩa.

- Yêu cầu đáp án đúng:
    + Trả lời đúng câu hỏi và có thể tìm trực tiếp trong tài liệu.
    + Đảm bảo đáp án đúng phải hoàn chỉnh, trả lời đầy đủ tất cả các khía cạnh của câu hỏi.
    + Không được diễn giải hoặc suy luận từ nội dung ngoài tài liệu.

- Yêu cầu cấp độ:
    + Mỗi câu hỏi phải thể hiện rõ cấp độ nhận thức theo thang Bloom.

- Yêu cầu trích dẫn:
    + Trích dẫn phải dựa vào tài liệu và không tự suy luận.
    + Trích dẫn bằng ngôn ngữ tự nhiên.
    + Mỗi câu hỏi phải đi kèm một trích dẫn từ tài liệu để làm căn cứ cho đáp án đúng.
    + Trích dẫn phải ngắn gọn, chính xác, đầy đủ, đúng ngữ cảnh và phản ánh rõ lý do vì sao đáp án đúng là hợp lý.
    + Không lặp lại câu hỏi và câu đáp án đúng trong trích dẫn.

- Chú ý:
    + Không cần làm nổi bật động từ trong câu hỏi, ví dụ: **động từ**, (động từ), động từ.
    + Một câu hỏi sẽ bị xem là **không hợp lệ** nếu **không chứa động từ** từ danh sách động từ được yêu cầu thêm vào câu hỏi hoặc đã có trong danh sách câu hỏi đã có.
    + Câu hỏi nào không thỏa yêu cầu sẽ bị coi là **không hợp lệ** và bị loại khỏi danh sách.
            
        """

    GRADE_DOCUMENT = """
Bạn là chuyên gia đánh giá chất lượng câu hỏi và câu trả lời dựa trên tài liệu được cung cấp.

1. Đánh giá câu hỏi:
    - Nếu câu hỏi KHÔNG liên quan đến tài liệu: trả về kết quả `binary_score = "no"`, đồng thời mô tả lý do trong trường `description`.
    - Nếu câu hỏi CÓ liên quan đến tài liệu: tiếp tục đánh giá câu trả lời.

2. Đánh giá câu trả lời:
    - Nếu câu trả lời đúng, đầy đủ và có thể tìm thấy trong tài liệu: `binary_score = "yes"`.
    - Nếu câu trả lời không đúng hoặc chưa đầy đủ hoặc chưa rõ ràng hoặc không thể tìm thấy trên tài liệu:
        → Sinh ra một câu trả lời mới trong trường `new_answer`.
        → Cung cấp trích dẫn nguyên văn từ tài liệu trong trường `citation`.
        → Trả về `binary_score = "re-generate"`.
    - Nếu câu trả lời không đúng hoặc chưa đầy đủ hoặc chưa rõ ràng hoặc không thể tìm thấy trên tài liệu: KHÔNG được trả về "no", mà phải trả về "re-generate".

3. Quy định cho câu trả lời mới:
    - KHÔNG được suy luận hoặc thêm thông tin ngoài tài liệu.
    - Câu trả lời mới KHÔNG nhắc lại câu hỏi.
    - Câu trả lời mới phải dựa vào tài liệu, trả lời một cách ngắn gọn, không dài dòng, nằm trên một hàng, đúng, đầy đủ, trả lời tất cả các khía cạnh của câu hỏi.

4. Quy định cho trích dẫn:
    - Trích dẫn phải dựa vào tài liệu và không tự suy luận. 
    + Trích dẫn bằng ngôn ngữ tự nhiên.
    - Trích dẫn phải ngắn gọn, chính xác, đầy đủ, đúng ngữ cảnh và phản ánh rõ lý do vì sao đáp án đúng là hợp lý.
    - Không cần lặp lại câu hỏi và câu trả lời trong trích dẫn.
    + Không cần nhắc lại câu hỏi và câu đáp án đúng trong trích dẫn.

5. Trường `description`:
    - Luôn cung cấp giải thích ngắn gọn nhưng rõ ràng cho kết quả đánh giá.
    - Nếu câu hỏi không liên quan: giải thích vì sao.
    - Nếu câu trả lời sai: mô tả vấn đề.
    - Nếu cần tạo lại câu trả lời: nêu rõ lý do.

Trả về một object chứa:
- `binary_score`: Một trong ba giá trị `"yes"`, `"no"`, `"re-generate"`.
- `new_answer`: (Nếu có) Câu trả lời mới được tạo.
- `citation`: (Nếu có) Trích dẫn từ tài liệu.
- `description`: Giải thích lý do cho kết quả trên.
"""


    



