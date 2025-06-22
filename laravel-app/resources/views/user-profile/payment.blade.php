@extends('user-profile.layout')

@section('profile-right')
    <div class="container" style="max-width: 600px; margin-top: 50px;">
        <h2 class="text-center">Thanh Toán Mã QR</h2>
        <div class="card">
            <div class="card-body">
                <div class="text-center">
                    <h5>Chủ Tài Khoản: <strong>NGO QUAN THANH NHA</strong></h5>
                    <h5>Số Tài Khoản: <strong>9337405155</strong></h5>
                    <h5>Ngân Hàng: <strong>Vietcombank</strong></h5>
                    <h5>Gói Thanh Toán: <strong>{{ $planToPay->name }}-{{ $planToPay->price }}</strong></h5>
                    <h5>Câu hỏi mua thêm:
                        <strong>{{ $questions }}*{{ $additionalQuestion->price }}={{ $questions * $additionalQuestion->price }}</strong>
                    </h5>
                    <h5>Tổng tiền cần thanh toán:
                        <strong>{{ $planToPay->price + $questions * $additionalQuestion->price }}VND</strong>
                    </h5>
                    <p class="mt-4">Vui lòng ấn "Confrim" khi đã chuyển khoản</p>
                    <p class="mt-4">Chúng tôi sẽ xác nhận trong vòng 24 giờ.</p>

                    <!-- Thẻ img để hiển thị mã QR -->
                    <img id="qrcode-img" alt="QR Code" style="max-width: 100%; height: auto;" />
                    <div>
                        <a href="{{ route('profile.payment-confirm', ['id_plan' => $planToPay->id, 'questions' => $questions]) }}"
                            class="btn btn-secondary">Confirm</a>
                    </div>

                    <script src="https://cdn.jsdelivr.net/npm/qrcode@1.4.4/build/qrcode.min.js"></script> <!-- Đảm bảo thư viện QRCode.js được tải đúng -->
                    <script>
                        // Dữ liệu thanh toán
                        const additionalQuestion = @json($additionalQuestion); // Correct variable name
                        const questions = @json($questions); // Assuming questions is a number or array
                        const additionalplanToPayQuestion =
                            @json($planToPay); // Assuming planToPay is the plan the user will pay for
                        const user = @json(Auth::user()); // Get the logged-in user

                        const paymentData = {
                            amount: additionalplanToPayQuestion.price + (questions * additionalQuestion.price), // Số tiền (VND)
                            accountNumber: '9337405155', // Số tài khoản
                            bank: 'Vietcombank', // Ngân hàng
                            transactionInfo: `${user.id}-Thanh toán BloomAI`, // Mô tả giao dịch
                            returnUrl: 'https://example.com/return', // URL trả về sau thanh toán
                            ipAddress: '127.0.0.1' // Địa chỉ IP người dùng
                        };

                        // Tạo chuỗi URL cho VietQR (Dữ liệu cần thiết cho thanh toán)
                        const baseUrl = "https://pay.vietqr.vn/";
                        let qrData =
                            `${baseUrl}?amount=${paymentData.amount}&accountNumber=${paymentData.accountNumber}&bank=${paymentData.bank}&planName=${additionalplanToPayQuestion.name}&transactionInfo=${paymentData.transactionInfo}&returnUrl=${paymentData.returnUrl}&ipAddress=${paymentData.ipAddress}`;

                        // Tạo mã QR với QRCode.js và hiển thị trên thẻ img
                        QRCode.toDataURL(qrData, function(error, url) {
                            if (error) {
                                console.error(error);
                                return;
                            }
                            // Gán URL hình ảnh QR vào thẻ img
                            document.getElementById('qrcode-img').src = url;
                            console.log("QR code generated!");
                        });
                    </script>

                </div>
            </div>
        </div>
    </div>
@endsection
