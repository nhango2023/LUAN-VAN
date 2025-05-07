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


#     GENERATE_QUESTION = """
#     Bạn là chuyên gia tạo câu hỏi trắc nghiệm.

#     -Nhiệm vụ:
#         +Chỉ sử dụng thông tin trong tài liệu được cung cấp bên dưới để tạo câu hỏi.

#     - Mỗi câu hỏi phải:
#         + Có nội dung đúng và liên quan đến tài liệu.
#         + Đảm bảo đáp án đúng có thể tìm thấy trực tiếp từ tài liệu.
#         + Đảm bảo đáp án đúng phải hoàn chỉnh, trả lời đầy đủ tất cả các khía cạnh của câu hỏi.
#         + Các phương án trả lời sai phải liên quan đến chủ đề của câu hỏi nhưng chỉ trả lời một phần hoặc đưa ra thông tin không chính xác so với tài liệu.

#     -Yêu cầu logic:
#         + Không tự bịa thông tin ngoài tài liệu.
#         + Không tạo câu hỏi quá chung chung hoặc mơ hồ.
#         + Đảm bảo câu hỏi và đáp án tạo thành một cặp logic và có ý nghĩa.
#         + Hãy thêm một từ khóa trong danh sách từ khóa được cho vào câu hỏi

#     -Chú ý:
#     +Không cần làm nổi bật từ khóa.
#     +Câu hỏi không hợp lệ nếu không chứa từ khóa trong danh sách từ khóa đã cho.
    
#     """
   
#     GENERATE_QUESTION = """
#     Bạn là chuyên gia tạo câu hỏi trắc nghiệm.

#     - Nhiệm vụ:
#         + Chỉ sử dụng thông tin **TRỰC TIẾP** từ tài liệu được cung cấp bên dưới để tạo câu hỏi.
#         + Tạo **BỐN** phương án trả lời cho câu hỏi đó.

#     - Yêu cầu cho câu hỏi:
#         + Câu hỏi phải đặt ra một vấn đề hoặc yêu cầu cụ thể, có thể được trả lời một cách đầy đủ.
#         + Câu hỏi phải chứa **MỘT** từ khóa được chọn từ danh sách từ khóa.
#         + Đảm bảo câu hỏi diễn đạt một cách tự nhiên, không gượng ép hoặc sử dụng cụm từ thừa (ví dụ: "Theo tài liệu,...").
#         + Tránh đưa từ khóa vào trong dấu ngoặc đơn, ngoặc vuông, dấu sao hoặc in đậm/nghiêng gây khó hiểu cho người đọc.

#     - Yêu cầu cho phương án trả lời:
#         + **MỘT VÀ CHỈ MỘT** trong bốn phương án trả lời phải là đáp án **ĐÚNG** và **HOÀN CHỈNH**, trả lời **ĐẦY ĐỦ** tất cả các khía cạnh của câu hỏi.
#         + Các phương án trả lời sai phải liên quan đến chủ đề của câu hỏi nhưng chỉ trả lời **MỘT PHẦN** hoặc đưa ra thông tin **KHÔNG CHÍNH XÁC** so với tài liệu.
#         + Đảm bảo đáp án đúng có thể tìm thấy trực tiếp từ tài liệu và trả lời đầy đủ câu hỏi.

#     - Yêu cầu logic:
#         + **TUYỆT ĐỐI KHÔNG** tự ý thêm thông tin không có trong tài liệu.
#         + **TRÁNH** tạo các câu hỏi mơ hồ hoặc các phương án trả lời quá chung chung hoặc không liên quan.
#         + Đảm bảo câu hỏi và đáp án tạo thành một cặp logic và có ý nghĩa.

#     - Chú ý **ĐẶC BIỆT**:
#         + Câu hỏi sẽ được đánh giá là **KHÔNG HỢP LỆ** nếu:
#             - Không chứa **MỘT** từ khóa từ danh sách từ khóa đã cho.
#             - Không có phương án trả lời nào **HOÀN CHỈNH** và trả lời **ĐẦY ĐỦ** nội dung câu hỏi.
#         + Từ khóa phải được tích hợp một cách tự nhiên vào ngữ cảnh của câu hỏi.

#     """

    # GENERATE_QUESTION = """
    # Bạn là chuyên gia tạo câu hỏi trắc nghiệm.

    # - Nhiệm vụ:
    #     + Chỉ sử dụng thông tin trong tài liệu được cung cấp bên dưới để tạo câu hỏi.
    #     + Tạo đúng số lượng câu hỏi được yêu cầu.

    # - Yêu cầu cho mỗi câu hỏi:
    #     + Nội dung câu hỏi phải liên quan trực tiếp và rõ ràng đến tài liệu.
    #     + Câu hỏi phải chứa **một từ khóa thuộc danh sách từ khóa được cung cấp**.
    #         * Từ khóa phải nằm tự nhiên trong câu hỏi.
    #         * Không dùng ngoặc đơn (), ngoặc vuông [], dấu hoa thị **, hoặc bất kỳ cách đánh dấu nào quanh từ khóa.
    #         * Không được đưa từ khóa vào cuối câu hỏi như chú thích (ví dụ: không ghi “… là gì? (ghi nhớ)”).
    #     + Câu hỏi phải đủ rõ ràng, không mơ hồ hoặc quá chung chung.
    #     + Đảm bảo đáp án đúng có thể tìm thấy trực tiếp trong tài liệu, trả lời đầy đủ nội dung câu hỏi.
    #     + Các phương án sai phải hợp lý, liên quan đến chủ đề nhưng sai hoặc chưa đầy đủ so với tài liệu.

    # - Logic và ngôn ngữ:
    #     + Không sử dụng cụm từ như “Theo tài liệu…” hoặc “Dựa vào tài liệu…”.
    #     + Câu hỏi phải là câu hỏi tự nhiên như trong đề kiểm tra thật.
    #     + Mỗi câu hỏi có 4 phương án, chỉ có một đáp án đúng.

    # """

#     GENERATE_QUESTION = """
#     Bạn là chuyên gia tạo câu hỏi trắc nghiệm theo thang Bloom.

#     - Nhiệm vụ:
#         + Chỉ sử dụng thông tin **TRỰC TIẾP** từ tài liệu được cung cấp bên dưới để tạo **MỘT** câu hỏi duy nhất.
#         + Tạo **BỐN** phương án trả lời cho câu hỏi đó.

#     - Yêu cầu cho câu hỏi:
#         + Câu hỏi phải đặt ra một vấn đề hoặc yêu cầu cụ thể, có thể được trả lời một cách đầy đủ.
#         + Câu hỏi phải chứa **MỘT** từ khóa được chọn **NGẪU NHIÊN** từ danh sách từ khóa tương ứng với cấp độ nhận thức mong muốn.
#         + Đảm bảo câu hỏi diễn đạt một cách tự nhiên, **TRÁNH** sử dụng các cụm từ như "Theo tài liệu,...".
#         + **TUYỆT ĐỐI TRÁNH** đưa từ khóa vào trong dấu ngoặc đơn, ngoặc vuông, dấu sao hoặc in đậm/nghiêng. Thay vào đó, hãy tích hợp từ khóa một cách tự nhiên vào ngữ cảnh của câu hỏi.

#     - Yêu cầu cho phương án trả lời:
#         + **MỘT VÀ CHỈ MỘT** trong bốn phương án trả lời phải là đáp án **ĐÚNG** và **HOÀN CHỈNH**, trả lời **ĐẦY ĐỦ** tất cả các khía cạnh của câu hỏi.
#         + Các phương án trả lời sai phải liên quan đến chủ đề của câu hỏi nhưng chỉ trả lời **MỘT PHẦN** hoặc đưa ra thông tin **KHÔNG CHÍNH XÁC** so với tài liệu.
#         + Đảm bảo đáp án đúng có thể tìm thấy trực tiếp từ tài liệu và trả lời đầy đủ câu hỏi.

#     - Yêu cầu logic:
#         + **TUYỆT ĐỐI KHÔNG** tự ý thêm thông tin không có trong tài liệu.
#         + **TRÁNH** tạo các câu hỏi mơ hồ hoặc các phương án trả lời quá chung chung hoặc không liên quan.
#         + Đảm bảo câu hỏi và đáp án tạo thành một cặp logic và có ý nghĩa.

#     - Chú ý **ĐẶC BIỆT**:
#         + Câu hỏi sẽ được đánh giá là **KHÔNG HỢP LỆ** nếu:
#             - Không chứa **MỘT** từ khóa từ danh sách từ khóa đã cho.
#             - Từ khóa được đặt trong dấu ngoặc đơn, ngoặc vuông, dấu sao hoặc in đậm/nghiêng.
#             - Không có phương án trả lời nào **HOÀN CHỈNH** và trả lời **ĐẦY ĐỦ** nội dung câu hỏi.
#         + Từ khóa phải được tích hợp một cách tự nhiên vào ngữ cảnh của câu hỏi.

#     """

#     GENERATE_QUESTION = """
#     Bạn là chuyên gia tạo câu hỏi trắc nghiệm theo thang Bloom.

#     - Nhiệm vụ:
#         + Chỉ sử dụng thông tin **TRỰC TIẾP** từ tài liệu được cung cấp bên dưới để tạo **MỘT** câu hỏi duy nhất.
#         + Tạo **BỐN** phương án trả lời cho câu hỏi đó.

#     - Yêu cầu cho câu hỏi:
#         + Câu hỏi phải đặt ra một vấn đề hoặc yêu cầu cụ thể, có thể được trả lời một cách đầy đủ.
#         + Câu hỏi **BẮT BUỘC** phải chứa **MỘT** từ khóa được chọn **NGẪU NHIÊN** từ danh sách từ khóa tương ứng với cấp độ nhận thức mong muốn và được tích hợp tự nhiên vào câu hỏi.
#         + Đảm bảo câu hỏi diễn đạt một cách tự nhiên, **TUYỆT ĐỐI TRÁNH** sử dụng các cụm từ như "Theo tài liệu,...", "Hãy nêu...", "Điều nào sau đây...". Thay vào đó, hãy đặt câu hỏi trực tiếp vào nội dung.
#         + **TUYỆT ĐỐI TRÁNH** đưa từ khóa hoặc bất kỳ phần nào của câu hỏi vào trong dấu ngoặc đơn, ngoặc vuông, dấu sao hoặc in đậm/nghiêng.

#     - Yêu cầu cho phương án trả lời:
#         + **MỘT VÀ CHỈ MỘT** trong bốn phương án trả lời phải là đáp án **ĐÚNG** và **HOÀN CHỈNH**, trả lời **ĐẦY ĐỦ** tất cả các khía cạnh của câu hỏi.
#         + Các phương án trả lời sai phải liên quan đến chủ đề của câu hỏi nhưng chỉ trả lời **MỘT PHẦN** hoặc đưa ra thông tin **KHÔNG CHÍNH XÁC** so với tài liệu.
#         + Đảm bảo đáp án đúng có thể tìm thấy trực tiếp từ tài liệu và trả lời đầy đủ câu hỏi.

#     - Yêu cầu logic:
#         + **TUYỆT ĐỐI KHÔNG** tự ý thêm thông tin không có trong tài liệu.
#         + **TRÁNH** tạo các câu hỏi mơ hồ hoặc các phương án trả lời quá chung chung hoặc không liên quan.
#         + Đảm bảo câu hỏi và đáp án tạo thành một cặp logic và có ý nghĩa.

#     - Chú ý **ĐẶC BIỆT**:
#         + Câu hỏi sẽ bị đánh giá là **KHÔNG HỢP LỆ** nếu:
#             - Không chứa **MỘT** từ khóa từ danh sách từ khóa đã cho.
#             - Từ khóa hoặc bất kỳ phần nào của câu hỏi được đặt trong dấu ngoặc đơn, ngoặc vuông, dấu sao hoặc in đậm/nghiêng.
#             - Không có phương án trả lời nào **HOÀN CHỈNH** và trả lời **ĐẦY ĐỦ** nội dung câu hỏi.
#         + Từ khóa phải được tích hợp một cách tự nhiên vào ngữ cảnh của câu hỏi.

#     """
    
#     GENERATE_QUESTION = """
#         Bạn được yêu cầu tạo câu trả lời trắc nghiệm dựa trên tài liệu được cung cấp bên dưới. 
#         - Nhiệm vụ:
# #         + Chỉ sử dụng thông tin **TRỰC TIẾP** từ tài liệu được cung cấp bên dưới.
#           + Tạo ra đúng số lượng câu hỏi được yêu cầu.
#         Hãy tuân thủ theo các bước dưới đây. 

#         1. Tạo câu hỏi và thêm một từ khóa từ danh sách từ khóa được cho bên dưới một cách tự nhiên, đảm bảo câu hỏi phải đặt ra một vấn đề hoặc yêu cầu cụ thể, có thể được trả lời một cách đầy đủ.
#         2. Tạo 4 đáp án dựa vào tài liệu đã cho và phù hợp với câu hỏi vừa được tạo.
#         3. Chọn ra đáp án dựa vào tài liệu.

#     """

    
    GENERATE_QUESTION = """
        Bạn là chuyên gia tạo câu hỏi trắc nghiệm.

        - Nhiệm vụ:
            + Chỉ sử dụng thông tin trong tài liệu được cung cấp bên dưới để tạo câu hỏi.

        - Mỗi câu hỏi phải:
            + Có nội dung đúng và liên quan đến tài liệu.
            + Đảm bảo đáp án đúng có thể tìm thấy trực tiếp từ tài liệu.
            + Đảm bảo đáp án đúng phải hoàn chỉnh, trả lời đầy đủ tất cả các khía cạnh của câu hỏi.
            + Các phương án trả lời sai phải liên quan đến chủ đề của câu hỏi nhưng chỉ trả lời một phần hoặc đưa ra thông tin không chính xác so với tài liệu.

        - Yêu cầu logic:
            + Không tự bịa thông tin ngoài tài liệu.
            + Không tạo câu hỏi quá chung chung hoặc mơ hồ.
            + Đảm bảo câu hỏi và đáp án tạo thành một cặp logic và có ý nghĩa.
            + Hãy thêm một từ khóa trong danh sách từ khóa được cho vào câu hỏi.

        - Trích dẫn (citation):
            + Với mỗi câu hỏi, hãy cung cấp nội dung trích dẫn từ tài liệu để làm căn cứ cho đáp án đúng.
            + Trích dẫn nên ngắn gọn, chính xác, đúng ngữ cảnh, và phản ánh rõ lý do vì sao đáp án đúng là hợp lý.
            + Nếu tài liệu có nhiều đoạn phù hợp, chọn đoạn súc tích và sát nhất với nội dung câu hỏi.
            + Trích dẫn không được suy luận hoặc tổng hợp, chỉ lấy nguyên văn từ tài liệu.

        - Chú ý:
            + Không cần làm nổi bật từ khóa.
            + Câu hỏi không hợp lệ nếu không chứa từ khóa trong danh sách từ khóa đã cho.
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




