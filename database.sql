-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 04, 2025 at 03:57 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `luanvan`
--

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `id_file` int(11) NOT NULL,
  `content` varchar(1000) NOT NULL,
  `option_1` varchar(255) NOT NULL,
  `option_2` varchar(255) NOT NULL,
  `option_3` varchar(255) NOT NULL,
  `option_4` varchar(255) NOT NULL,
  `answer` varchar(255) NOT NULL,
  `level` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `id_file`, `content`, `option_1`, `option_2`, `option_3`, `option_4`, `answer`, `level`, `created_at`, `updated_at`) VALUES
(1, 4, 'Mô tả đối tượng nghiên cứu của tâm lý học là gì?', 'Các hiện tượng tâm lý do thế giới khách quan tác động vào não con người', 'Các hoạt động thể chất của con người', 'Các hiện tượng tự nhiên xung quanh con người', 'Các quy luật xã hội', 'Các hiện tượng tâm lý do thế giới khách quan tác động vào não con người', 'remember', '2025-04-03 08:16:14', '2025-04-03 08:16:14'),
(2, 4, 'Định nghĩa tâm lý học theo tài liệu là gì?', 'Khoa học nghiên cứu về các hiện tượng tâm lý của con người', 'Khoa học nghiên cứu về hành vi của động vật', 'Khoa học nghiên cứu về các hiện tượng tự nhiên', 'Khoa học nghiên cứu về lịch sử nhân loại', 'Khoa học nghiên cứu về các hiện tượng tâm lý của con người', 'remember', '2025-04-03 08:16:14', '2025-04-03 08:16:14'),
(3, 4, 'Mô tả bản chất của tâm lí theo chủ nghĩa duy vật biện chứng?', 'Tâm lí là sự phản ánh hiện thực khách quan vào não người', 'Tâm lí là một hiện tượng xã hội', 'Tâm lí không có tính lịch sử', 'Tâm lí chỉ là sự phản ánh cơ học', 'Tâm lí là sự phản ánh hiện thực khách quan vào não người', 'remember', '2025-04-03 08:16:14', '2025-04-03 08:16:14'),
(4, 4, 'Mô tả bản chất của tâm lý theo chủ nghĩa duy vật biện chứng?', 'Tâm lý là sự phản ánh hiện thực khách quan vào não người', 'Tâm lý chỉ là sự phản ánh của các hiện tượng tự nhiên', 'Tâm lý không có tính xã hội và lịch sử', 'Tâm lý là một hiện tượng sinh học đơn giản', 'Tâm lý là sự phản ánh hiện thực khách quan vào não người', 'remember', '2025-04-03 08:16:14', '2025-04-03 08:16:14'),
(5, 4, 'Mô tả các loại quá trình tâm lý theo tài liệu đã cung cấp.', 'Quá trình nhận thức, xúc cảm, ý chí', 'Quá trình nhận thức, trạng thái tâm lý, thuộc tính tâm lý', 'Quá trình nhận thức, thuộc tính tâm lý, hành vi', 'Quá trình xúc cảm, trạng thái tâm lý, hành vi', 'Quá trình nhận thức, xúc cảm, ý chí', 'remember', '2025-04-03 08:16:14', '2025-04-03 08:16:14'),
(6, 4, 'Liệt kê các hình thức quan sát trong phương pháp nghiên cứu tâm lý học.', 'Quan sát khách quan, tự quan sát', 'Quan sát chủ quan, tự quan sát', 'Quan sát định tính, định lượng', 'Quan sát trực tiếp, gián tiếp', 'Quan sát khách quan, tự quan sát', 'remember', '2025-04-03 08:16:14', '2025-04-03 08:16:14'),
(7, 4, 'Mô tả quá trình thực nghiệm trong tâm lý học là gì?', 'Là quá trình tác động vào đối tượng một cách thụ động', 'Là quá trình tác động vào đối tượng một cách chủ động', 'Là quá trình nghiên cứu mà không cần khống chế điều kiện', 'Là quá trình thu thập ý kiến chủ quan của đối tượng', 'Là quá trình tác động vào đối tượng một cách chủ động', 'remember', '2025-04-03 08:16:14', '2025-04-03 08:16:14'),
(8, 4, 'Liệt kê các phương pháp nghiên cứu tâm lý được nêu trong tài liệu.', 'Thực nghiệm, trắc nghiệm, điều tra, đàm thoại, phân tích sản phẩm hoạt động, nghiên cứu tiểu sử cá nhân', 'Thực nghiệm, khảo sát, phỏng vấn, phân tích, nghiên cứu tiểu sử', 'Trắc nghiệm, điều tra, phỏng vấn, quan sát, phân tích', 'Thực nghiệm, trắc nghiệm, phỏng vấn, điều tra, khảo sát', 'Thực nghiệm, trắc nghiệm, điều tra, đàm thoại, phân tích sản phẩm hoạt động, nghiên cứu tiểu sử cá nhân', 'remember', '2025-04-03 08:16:14', '2025-04-03 08:16:14'),
(9, 4, 'Hãy xác định đối tượng nghiên cứu của tâm lý học?', 'Các hiện tượng tâm lý do thế giới khách quan tác động vào não con người', 'Các hoạt động thể chất của con người', 'Các quy luật tự nhiên', 'Các hiện tượng xã hội', 'Các hiện tượng tâm lý do thế giới khách quan tác động vào não con người', 'understand', '2025-04-03 08:16:14', '2025-04-03 08:16:14'),
(10, 4, 'Mô tả ý nghĩa của tâm lý học trong việc giải thích các hiện tượng tâm lý của con người?', 'Góp phần phát triển công nghệ', 'Giải thích một cách khoa học các hiện tượng tâm lý của con người', 'Tăng cường sức khỏe thể chất', 'Cải thiện kỹ năng giao tiếp', 'Giải thích một cách khoa học các hiện tượng tâm lý của con người', 'understand', '2025-04-03 08:16:14', '2025-04-03 08:16:14'),
(11, 4, 'Hãy xác định bản chất của tâm lý theo chủ nghĩa duy vật biện chứng?', 'Tâm lý là sự phản ánh hiện thực khách quan vào não người', 'Tâm lý là một hiện tượng xã hội đơn giản', 'Tâm lý không có tính lịch sử', 'Tâm lý chỉ phản ánh những gì con người thấy được', 'Tâm lý là sự phản ánh hiện thực khách quan vào não người', 'understand', '2025-04-03 08:16:14', '2025-04-03 08:16:14'),
(12, 4, 'Hình ảnh tâm lý (TL) có tính chất gì theo tài liệu?', 'Mang tính chủ thể', 'Chỉ phản ánh hiện thực khách quan', 'Không phụ thuộc vào chủ thể', 'Là hình ảnh cố định', 'Mang tính chủ thể', 'understand', '2025-04-03 08:16:14', '2025-04-03 08:16:14'),
(13, 4, 'Hãy xác định bản chất của TL người theo tài liệu đã cung cấp.', 'TL người là sản phẩm của hoạt động giao tiếp trong các mối quan hệ XH', 'TL người là kết quả của quá trình học tập cá nhân', 'TL người không chịu ảnh hưởng bởi môi trường xã hội', 'TL người chỉ hình thành trong gia đình', 'TL người là sản phẩm của hoạt động giao tiếp trong các mối quan hệ XH', 'understand', '2025-04-03 08:16:14', '2025-04-03 08:16:14'),
(14, 4, 'Phân loại các hiện tượng tâm lý có thể được chia thành những loại nào?', 'Quá trình nhận thức, quá trình xúc cảm, quá trình ý chí', 'Trạng thái tâm lý, thuộc tính tâm lý, quá trình tâm lý', 'Quá trình tâm lý, trạng thái tâm lý, thuộc tính tâm lý', 'Tâm lý cá nhân, tâm lý xã hội, tâm lý vô thức', 'Quá trình tâm lý, trạng thái tâm lý, thuộc tính tâm lý', 'understand', '2025-04-03 08:16:14', '2025-04-03 08:16:14'),
(15, 4, 'Thực nghiệm là gì và có những loại nào?', 'Thực nghiệm là quá trình tác động vào đối tượng một cách chủ động', 'Thực nghiệm chỉ có một loại là thực nghiệm trong phòng thí nghiệm', 'Thực nghiệm không thể lặp lại nhiều lần', 'Thực nghiệm là phương pháp nghiên cứu tiểu sử cá nhân', 'Thực nghiệm là quá trình tác động vào đối tượng một cách chủ động', 'understand', '2025-04-03 08:16:14', '2025-04-03 08:16:14'),
(16, 4, 'Phương pháp phân tích sản phẩm hoạt động là gì và nó có vai trò như thế nào trong nghiên cứu tâm lý?', 'Là phương pháp dựa vào kết quả vật chất để nghiên cứu gián tiếp các quá trình tâm lý', 'Là phương pháp chỉ dựa vào tài liệu lịch sử', 'Là phương pháp nghiên cứu chỉ tập trung vào cá nhân mà không xem xét sản phẩm', 'Là phương pháp chỉ sử dụng trong nghiên cứu tiểu sử', 'Là phương pháp dựa vào kết quả vật chất để nghiên cứu gián tiếp các quá trình tâm lý', 'understand', '2025-04-03 08:16:14', '2025-04-03 08:16:14'),
(17, 4, 'Tâm lý học nghiên cứu các hiện tượng tâm lý với tư cách là gì?', 'Các hiện tượng vật lý', 'Các hiện tượng tinh thần', 'Các hiện tượng xã hội', 'Các hiện tượng tự nhiên', 'Các hiện tượng tinh thần', 'apply', '2025-04-03 08:16:14', '2025-04-03 08:16:14'),
(18, 4, 'Nhiệm vụ của tâm lý học bao gồm việc phát hiện các quy luật hình thành và phát triển tâm lý. Điều này có thể được áp dụng trong lĩnh vực nào?', 'Giáo dục', 'Khoa học tự nhiên', 'Kinh tế', 'Khoa học kỹ thuật', 'Giáo dục', 'apply', '2025-04-03 08:16:14', '2025-04-03 08:16:14'),
(19, 4, 'Bản chất của tâm lý người theo chủ nghĩa duy vật biện chứng khẳng định rằng tâm lý người là sự phản ánh của điều gì?', 'Thế giới tự nhiên', 'Hiện thực khách quan', 'Xã hội loài người', 'Tâm lý xã hội', 'Hiện thực khách quan', 'apply', '2025-04-03 08:16:14', '2025-04-03 08:16:14'),
(20, 4, 'Tâm lý học có chức năng gì trong việc điều khiển hoạt động của con người?', 'Định hướng cho hoạt động, về động cơ, mục đích.', 'Tạo ra các mối quan hệ xã hội.', 'Sửa đổi hành vi của con người.', 'Phân loại các hiện tượng tâm lý.', 'Định hướng cho hoạt động, về động cơ, mục đích.', 'apply', '2025-04-03 08:16:14', '2025-04-03 08:16:14'),
(21, 4, 'Quá trình tâm lý nào giúp ta nhận biết sự vật hiện tượng?', 'Quá trình xúc cảm.', 'Quá trình nhận thức.', 'Quá trình giao tiếp.', 'Quá trình phát triển.', 'Quá trình nhận thức.', 'apply', '2025-04-03 08:16:14', '2025-04-03 08:16:14'),
(22, 4, 'Tại sao cần phải nghiên cứu môi trường xã hội trong việc hình thành và phát triển tâm lý con người?', 'Vì nó quyết định tính cách của mỗi cá nhân.', 'Vì nó ảnh hưởng đến hoạt động giao tiếp.', 'Vì nó tạo ra các mối quan hệ xã hội.', 'Vì nó là nguồn gốc của tâm lý con người.', 'Vì nó là nguồn gốc của tâm lý con người.', 'apply', '2025-04-03 08:16:14', '2025-04-03 08:16:14'),
(23, 4, 'Phân loại các hiện tượng tâm lý có thể được chia thành những loại nào?', 'Quá trình nhận thức, quá trình xúc cảm, quá trình ý chí', 'Trạng thái tâm lý, thuộc tính tâm lý, quá trình tâm lý', 'Quá trình nhận thức, trạng thái tâm lý, thuộc tính tâm lý', 'Quá trình tâm lý, trạng thái tâm lý, hiện tượng tâm lý', 'Quá trình nhận thức, trạng thái tâm lý, thuộc tính tâm lý', 'apply', '2025-04-03 08:16:14', '2025-04-03 08:16:14'),
(24, 4, 'Phương pháp nào trong tâm lý học cho phép chúng ta thu thập tài liệu cụ thể và khách quan trong điều kiện tự nhiên?', 'Phương pháp thực nghiệm', 'Phương pháp quan sát', 'Phương pháp điều chỉnh', 'Phương pháp xử lý', 'Phương pháp quan sát', 'apply', '2025-04-03 08:16:14', '2025-04-03 08:16:14'),
(25, 4, 'Phương pháp trắc nghiệm có ưu điểm gì trong việc đo lường tâm lý?', 'Có khả năng tiến hành nhanh và đơn giản', 'Khó soạn thảo một bộ test đảm bảo tính chuẩn hoá', 'Chủ yếu cho ta kết quả mà không bộc lộ quá trình suy nghĩ', 'Cần sử dụng như một trong các cách chẩn đoán tâm lý con người', 'Có khả năng tiến hành nhanh và đơn giản', 'apply', '2025-04-03 08:16:14', '2025-04-03 08:16:14'),
(26, 4, 'Phương pháp nào trong tâm lý học được sử dụng để thu thập ý kiến chủ quan của đối tượng nghiên cứu thông qua một số câu hỏi?', 'Thực nghiệm', 'Trắc nghiệm', 'Điều tra', 'Phân tích sản phẩm hoạt động', 'Điều tra', 'apply', '2025-04-03 08:16:14', '2025-04-03 08:16:14'),
(27, 4, 'Phân tích nhiệm vụ của tâm lý học trong việc nghiên cứu bản chất của hoạt động tâm lý.', 'Nghiên cứu sự hình thành nhân cách', 'Phát hiện các quy luật tư duy', 'Nghiên cứu bản chất của hoạt động tâm lý', 'Tìm ra cơ chế của các hiện tượng tâm lý', 'Nghiên cứu bản chất của hoạt động tâm lý', 'analyze', '2025-04-03 08:16:14', '2025-04-03 08:16:14'),
(28, 4, 'Tâm lý học có nhiệm vụ gì trong việc phát hiện các quy luật hình thành và phát triển tâm lý?', 'Nghiên cứu bản chất của hoạt động tâm lý', 'Phát hiện các quy luật hình thành, phát triển tâm lý', 'Tìm ra cơ chế của các hiện tượng tâm lý', 'Giải thích các hiện tượng tâm lý một cách khoa học', 'Phát hiện các quy luật hình thành, phát triển tâm lý', 'analyze', '2025-04-03 08:16:14', '2025-04-03 08:16:14'),
(29, 4, 'Phân tích bản chất của tâm lý theo chủ nghĩa duy vật biện chứng?', 'Tâm lý là sự phản ánh hiện thực khách quan vào não người', 'Tâm lý không có tính xã hội', 'Tâm lý chỉ phản ánh hiện thực một cách đơn giản', 'Tâm lý không liên quan đến lịch sử', 'Tâm lý là sự phản ánh hiện thực khách quan vào não người', 'analyze', '2025-04-03 08:16:14', '2025-04-03 08:16:14'),
(30, 4, 'So sánh hình ảnh tâm lý với hình ảnh vật lý, điểm khác biệt chính là gì?', 'Hình ảnh tâm lý mang tính sinh động và sáng tạo', 'Hình ảnh vật lý luôn chính xác hơn', 'Hình ảnh tâm lý không phụ thuộc vào chủ thể', 'Hình ảnh vật lý có thể thay đổi theo thời gian', 'Hình ảnh tâm lý mang tính sinh động và sáng tạo', 'analyze', '2025-04-03 08:16:14', '2025-04-03 08:16:14'),
(31, 4, 'Phân tích tính chủ thể của tâm lý người trong việc phản ánh thế giới khách quan.', 'Tính chủ thể không ảnh hưởng đến tâm lý người', 'Tính chủ thể chỉ phản ánh một cách máy móc', 'Tính chủ thể chịu ảnh hưởng của hoàn cảnh và trạng thái của con người', 'Tính chủ thể không liên quan đến các mối quan hệ xã hội', 'Tính chủ thể chịu ảnh hưởng của hoàn cảnh và trạng thái của con người', 'analyze', '2025-04-03 08:16:14', '2025-04-03 08:16:14'),
(32, 4, 'So sánh bản chất xã hội và lịch sử của tâm lý người với tâm lý của các loài động vật cao cấp.', 'Tâm lý người không có tính xã hội', 'Tâm lý người mang tính xã hội và lịch sử, khác với động vật', 'Tâm lý động vật cao cấp có bản chất xã hội', 'Tâm lý người và động vật cao cấp hoàn toàn giống nhau', 'Tâm lý người mang tính xã hội và lịch sử, khác với động vật', 'analyze', '2025-04-03 08:16:14', '2025-04-03 08:16:14'),
(33, 4, 'Phân tích vai trò của các mối quan hệ xã hội trong việc hình thành và phát triển tính cách con người?', 'Các mối quan hệ xã hội không ảnh hưởng đến tính cách con người.', 'Các mối quan hệ xã hội quyết định hoàn toàn tính cách con người.', 'Các mối quan hệ xã hội chỉ ảnh hưởng đến một phần tính cách con người.', 'Các mối quan hệ xã hội là yếu tố quan trọng trong việc hình thành và phát triển tính cách con người.', 'Các mối quan hệ xã hội là yếu tố quan trọng trong việc hình thành và phát triển tính cách con người.', 'analyze', '2025-04-03 08:16:14', '2025-04-03 08:16:14'),
(34, 4, 'Hãy phân loại các hiện tượng tâm lý theo các tiêu chí đã nêu trong tài liệu.', 'Quá trình tâm lý, trạng thái tâm lý, thuộc tính tâm lý', 'Cảm xúc, nhận thức, ý chí', 'Tâm lý cá nhân, tâm lý xã hội', 'Tâm lý ý thức, tâm lý vô thức', 'Quá trình tâm lý, trạng thái tâm lý, thuộc tính tâm lý', 'analyze', '2025-04-03 08:16:14', '2025-04-03 08:16:14'),
(35, 4, 'Phương pháp nào trong nghiên cứu tâm lý được sử dụng để thu thập ý kiến chủ quan của đối tượng nghiên cứu thông qua một số câu hỏi nhất loạt?', 'Phương pháp thực nghiệm', 'Phương pháp trắc nghiệm', 'Phương pháp điều tra', 'Phương pháp đàm thoại', 'Phương pháp điều tra', 'analyze', '2025-04-03 08:16:14', '2025-04-03 08:16:14'),
(36, 4, 'Phương pháp nào dựa vào kết quả vật chất để nghiên cứu gián tiếp các quá trình tâm lý của cá nhân?', 'Phương pháp phân tích sản phẩm hoạt động', 'Phương pháp nghiên cứu tiểu sử cá nhân', 'Phương pháp khảo sát', 'Phương pháp phân loại', 'Phương pháp phân tích sản phẩm hoạt động', 'analyze', '2025-04-03 08:16:14', '2025-04-03 08:16:14'),
(37, 4, 'Thẩm định mối quan hệ giữa tâm lý người và các mối quan hệ xã hội như thế nào?', 'Tâm lý người không liên quan đến mối quan hệ xã hội', 'Tâm lý người được hình thành hoàn toàn từ các mối quan hệ xã hội', 'Tâm lý người là sự tổng hòa của các mối quan hệ xã hội', 'Tâm lý người chỉ phụ thuộc vào yếu tố sinh học', 'Tâm lý người là sự tổng hòa của các mối quan hệ xã hội', 'evaluate', '2025-04-03 08:16:14', '2025-04-03 08:16:14'),
(38, 4, 'Suy ra điều gì từ việc nghiên cứu hoàn cảnh sống của con người trong việc hình thành tâm lý?', 'Hoàn cảnh sống không ảnh hưởng đến tâm lý', 'Hoàn cảnh sống là yếu tố quyết định trong việc hình thành tâm lý', 'Hoàn cảnh sống chỉ ảnh hưởng đến một số người', 'Hoàn cảnh sống không liên quan đến tâm lý', 'Hoàn cảnh sống là yếu tố quyết định trong việc hình thành tâm lý', 'evaluate', '2025-04-03 08:16:14', '2025-04-03 08:16:14'),
(39, 4, 'Sắp xếp các yếu tố ảnh hưởng đến tâm lý người theo thứ tự từ yếu tố xã hội đến yếu tố cá nhân.', 'Yếu tố cá nhân, yếu tố xã hội', 'Yếu tố xã hội, yếu tố cá nhân', 'Yếu tố tâm lý, yếu tố xã hội', 'Yếu tố xã hội, yếu tố tâm lý', 'Yếu tố xã hội, yếu tố cá nhân', 'evaluate', '2025-04-03 08:16:14', '2025-04-03 08:16:14'),
(40, 4, 'Đặt vấn đề về sự khác biệt giữa tâm lý người và tâm lý của các loài động vật cao cấp.', 'Tâm lý người không có bản chất xã hội', 'Tâm lý người có bản chất xã hội và lịch sử', 'Tâm lý động vật cao cấp cũng có bản chất xã hội', 'Tâm lý người và động vật cao cấp hoàn toàn giống nhau', 'Tâm lý người có bản chất xã hội và lịch sử', 'evaluate', '2025-04-03 08:16:14', '2025-04-03 08:16:14'),
(41, 4, 'Điều chỉnh cách tiếp cận nghiên cứu tâm lý người dựa trên các mối quan hệ xã hội như thế nào?', 'Chỉ nghiên cứu cá nhân mà không quan tâm đến xã hội', 'Tập trung vào các mối quan hệ xã hội và cá nhân', 'Không cần điều chỉnh cách tiếp cận', 'Chỉ nghiên cứu mối quan hệ gia đình', 'Tập trung vào các mối quan hệ xã hội và cá nhân', 'evaluate', '2025-04-03 08:16:14', '2025-04-03 08:16:14'),
(42, 4, 'Phân loại các yếu tố tạo nên tâm lý người theo quan điểm xã hội và lịch sử.', 'Yếu tố sinh học và yếu tố xã hội', 'Yếu tố cá nhân và yếu tố môi trường', 'Yếu tố xã hội và yếu tố lịch sử', 'Yếu tố tâm lý và yếu tố vật lý', 'Yếu tố xã hội và yếu tố lịch sử', 'evaluate', '2025-04-03 08:16:14', '2025-04-03 08:16:14'),
(43, 4, 'Tâm lý người có bản chất xã hội và lịch sử thể hiện như thế nào trong các mối quan hệ xã hội?', 'Tâm lý người hoàn toàn độc lập với xã hội', 'Tâm lý người là sự phản ánh của các mối quan hệ xã hội', 'Tâm lý người không bị ảnh hưởng bởi hoàn cảnh', 'Tâm lý người chỉ phụ thuộc vào cá nhân', 'Tâm lý người là sự phản ánh của các mối quan hệ xã hội', 'evaluate', '2025-04-03 08:16:14', '2025-04-03 08:16:14'),
(44, 5, 'Kể tên các quy luật hoạt động thần kinh cao cấp được nêu trong tài liệu?', 'Quy luật cảm ứng qua lại', 'Quy luật lan tỏa và tập trung', 'Quy luật hoạt động theo hệ thống', 'Tất cả các quy luật trên', 'Tất cả các quy luật trên', 'remember', '2025-04-03 08:24:06', '2025-04-03 08:24:06'),
(45, 5, 'Mô tả cơ sở tự nhiên của tâm lý người theo tài liệu tâm lý học đại cương.', 'Não bộ và chức năng của nó', 'Hệ thống tín hiệu thứ nhất', 'Phản xạ có điều kiện', 'Quy luật hoạt động thần kinh cao cấp', 'Não bộ và chức năng của nó', 'remember', '2025-04-03 08:24:06', '2025-04-03 08:24:06'),
(46, 5, 'Mô tả quy luật lan tỏa và tập trung trong vỏ não.', 'Quá trình hưng phấn dừng lại ở một điểm', 'Quá trình hưng phấn lan tỏa ra xung quanh', 'Quá trình ức chế không ảnh hưởng đến các điểm khác', 'Quá trình hưng phấn chỉ xảy ra ở một điểm', 'Quá trình hưng phấn lan tỏa ra xung quanh', 'remember', '2025-04-03 08:24:06', '2025-04-03 08:24:06'),
(47, 5, 'Kể tên hai quá trình diễn ra đồng thời trong hoạt động của con người.', 'Đối tượng hoá và chủ thể hoá', 'Hưng phấn và ức chế', 'Kích thích và phản ứng', 'Tiêu hao năng lượng và thoả mãn nhu cầu', 'Đối tượng hoá và chủ thể hoá', 'remember', '2025-04-03 08:24:06', '2025-04-03 08:24:06'),
(48, 5, 'Mô tả các thành tố của đối tượng trong hoạt động theo tài liệu?', 'Động cơ, Mục đích, Phương tiện', 'Chủ thể, Đối tượng, Hoạt động', 'Sản phẩm, Hành động, Thao tác', 'Động cơ, Hành động, Sản phẩm', 'Động cơ, Mục đích, Phương tiện', 'remember', '2025-04-03 08:24:06', '2025-04-03 08:24:06'),
(49, 5, 'Mô tả các hình thức giao tiếp giữa con người với con người.', 'Giao tiếp giữa cá nhân với cá nhân', 'Giao tiếp giữa cá nhân với nhóm', 'Giao tiếp giữa nhóm với nhóm', 'Tất cả các hình thức trên', 'Tất cả các hình thức trên', 'remember', '2025-04-03 08:24:06', '2025-04-03 08:24:06'),
(50, 5, 'Mô tả hai loại giao tiếp được chia theo quy cách giao tiếp.', 'Giao tiếp chính thức và giao tiếp không chính thức', 'Giao tiếp cá nhân và giao tiếp tập thể', 'Giao tiếp ngôn ngữ và giao tiếp phi ngôn ngữ', 'Giao tiếp trực tiếp và giao tiếp gián tiếp', 'Giao tiếp chính thức và giao tiếp không chính thức', 'remember', '2025-04-03 08:24:06', '2025-04-03 08:24:06'),
(51, 5, 'Định nghĩa Tâm lý (TL) theo tài liệu là gì?', 'Sản phẩm của HĐ và GT', 'Kết quả của quá trình học tập', 'Chỉ là cảm xúc của con người', 'Là một phần của nhân cách', 'Sản phẩm của HĐ và GT', 'remember', '2025-04-03 08:24:06', '2025-04-03 08:24:06'),
(52, 5, 'Hãy chỉ ra cơ sở sinh lý của hoạt động cảm tính, trực quan và tư duy cụ thể trong tâm lý người.', 'Hệ thống tín hiệu thứ nhất', 'Hệ thống tín hiệu thứ hai', 'Phản xạ có điều kiện', 'Quy luật hoạt động thần kinh cao cấp', 'Hệ thống tín hiệu thứ nhất', 'understand', '2025-04-03 08:24:06', '2025-04-03 08:24:06'),
(53, 5, 'So sánh quy luật hoạt động theo hệ thống và quy luật lan tỏa trong hoạt động thần kinh cao cấp.', 'Quy luật hoạt động theo hệ thống tập hợp kích thích, quy luật lan tỏa không tập hợp', 'Quy luật hoạt động theo hệ thống giúp tiết kiệm năng lượng, quy luật lan tỏa không tiết kiệm năng lượng', 'Quy luật hoạt động theo hệ thống liên quan đến nhiều trung khu, quy luật lan tỏa liên quan đến một điểm', 'Quy luật hoạt động theo hệ thống chỉ có ở người, quy luật lan tỏa có ở cả động vật', 'Quy luật hoạt động theo hệ thống liên quan đến nhiều trung khu, quy luật lan tỏa liên quan đến một điểm', 'understand', '2025-04-03 08:24:06', '2025-04-03 08:24:06'),
(54, 5, 'Hãy chỉ ra quy luật nào mô tả quá trình hưng phấn hay ức chế lan tỏa ra xung quanh trên vỏ não?', 'Quy luật cảm ứng qua lại', 'Quy luật lan tỏa và tập trung', 'Quy luật phụ thuộc vào cường độ kích thích', 'Quy luật hưng phấn', 'Quy luật lan tỏa và tập trung', 'understand', '2025-04-03 08:24:06', '2025-04-03 08:24:06'),
(55, 5, 'Hãy chỉ ra các thành tố của cấu trúc hoạt động theo tài liệu đã cung cấp.', 'Hoạt động, Hành động, Thao tác, Động cơ, Mục đích, Phương tiện', 'Chủ thể, Đối tượng, Sản phẩm, Công cụ, Ngôn ngữ, Tâm lý', 'Hoạt động, Động cơ, Sản phẩm, Hành động, Thao tác, Mục đích', 'Chủ thể, Hành động, Đối tượng, Thao tác, Mục đích, Phương tiện', 'Hoạt động, Hành động, Thao tác, Động cơ, Mục đích, Phương tiện', 'understand', '2025-04-03 08:24:06', '2025-04-03 08:24:06'),
(56, 5, 'Phân loại hoạt động được chia thành mấy loại dựa trên phương diện phát triển cá thể?', '2 loại', '3 loại', '4 loại', '5 loại', '4 loại', 'understand', '2025-04-03 08:24:06', '2025-04-03 08:24:06'),
(57, 5, 'Hãy chỉ ra các chức năng của giao tiếp giữa con người với con người.', 'Chức năng thông tin, chức năng cảm xúc, chức năng nhận thức và đánh giá lẫn nhau, chức năng điều chỉnh hành vi', 'Chức năng giải trí, chức năng giáo dục, chức năng truyền thông, chức năng xã hội', 'Chức năng kinh tế, chức năng chính trị, chức năng văn hóa, chức năng nghệ thuật', 'Chức năng cá nhân, chức năng nhóm, chức năng cộng đồng, chức năng xã hội', 'Chức năng thông tin, chức năng cảm xúc, chức năng nhận thức và đánh giá lẫn nhau, chức năng điều chỉnh hành vi', 'understand', '2025-04-03 08:24:06', '2025-04-03 08:24:06'),
(58, 5, 'Hãy xác định các loại giao tiếp được phân loại theo quy cách giao tiếp trong tài liệu?', 'Giao tiếp chính thức và giao tiếp không chính thức', 'Giao tiếp trực tiếp và giao tiếp gián tiếp', 'Giao tiếp bằng lời và giao tiếp phi ngôn ngữ', 'Giao tiếp cá nhân và giao tiếp tập thể', 'Giao tiếp chính thức và giao tiếp không chính thức', 'understand', '2025-04-03 08:24:06', '2025-04-03 08:24:06'),
(59, 5, 'HĐ và GT có vai trò gì trong việc hình thành và phát triển tâm lý con người?', 'Chỉ ra nguồn gốc của tâm lý', 'Là sản phẩm của hoạt động và giao tiếp', 'Đánh giá nhân cách con người', 'Khám phá các quan hệ xã hội', 'Là sản phẩm của hoạt động và giao tiếp', 'understand', '2025-04-03 08:24:06', '2025-04-03 08:24:06'),
(60, 5, 'Vận dụng hệ thống tín hiệu thứ hai có thể giúp con người trong hoạt động nào dưới đây?', 'Tư duy ngôn ngữ', 'Phản xạ có điều kiện', 'Cảm xúc cơ thể', 'Tư duy cụ thể', 'Tư duy ngôn ngữ', 'apply', '2025-04-03 08:24:06', '2025-04-03 08:24:06'),
(61, 5, 'Hệ thống tín hiệu thứ hai trong tâm lý học người có vai trò gì trong việc điều khiển và xử lý thông tin?', 'Là cơ sở sinh lý của tư duy ngôn ngữ và ý thức', 'Chỉ có ở động vật', 'Giúp não bộ hoạt động theo quy luật thần kinh', 'Là yếu tố không quan trọng trong tâm lý học', 'Là cơ sở sinh lý của tư duy ngôn ngữ và ý thức', 'apply', '2025-04-03 08:24:06', '2025-04-03 08:24:06'),
(62, 5, 'Khi hưng phấn nảy sinh ở một điểm trong bán cầu đại não, điều gì sẽ xảy ra với các điểm lân cận?', 'Tạo ra ức chế ở các điểm khác', 'Không có ảnh hưởng gì', 'Tạo ra hưng phấn ở các điểm khác', 'Làm giảm hưng phấn ở các điểm khác', 'Tạo ra ức chế ở các điểm khác', 'apply', '2025-04-03 08:24:06', '2025-04-03 08:24:06'),
(63, 5, 'Quy luật nào trong tâm lý học cho phép chúng ta điều chỉnh phản ứng của vỏ não theo cường độ kích thích?', 'Quy luật lan tỏa và tập trung', 'Quy luật cảm ứng qua lại', 'Quy luật phụ thuộc vào cường độ kích thích', 'Quy luật hưng phấn và ức chế', 'Quy luật phụ thuộc vào cường độ kích thích', 'apply', '2025-04-03 08:24:06', '2025-04-03 08:24:06'),
(64, 5, 'Chức năng nào trong giao tiếp cho phép con người trao đổi tri thức và kinh nghiệm với nhau?', 'Chức năng cảm xúc', 'Chức năng thông tin', 'Chức năng điều chỉnh hành vi', 'Chức năng nhận thức và đánh giá lẫn nhau', 'Chức năng thông tin', 'apply', '2025-04-03 08:24:06', '2025-04-03 08:24:06'),
(65, 5, 'Khi phân loại giao tiếp căn cứ vào phương tiện, loại giao tiếp nào được đặc trưng bởi việc sử dụng tín hiệu chung của ngôn ngữ?', 'Giao tiếp bằng tín hiệu phi ngôn ngữ', 'Giao tiếp bằng ngôn ngữ', 'Giao tiếp vật chất', 'Giao tiếp trực tiếp', 'Giao tiếp bằng ngôn ngữ', 'apply', '2025-04-03 08:24:06', '2025-04-03 08:24:06'),
(66, 5, 'Giao tiếp chính thức được định nghĩa như thế nào trong tài liệu?', 'Là giao tiếp không bị ràng buộc bởi nghi thức', 'Là giao tiếp diễn ra theo quy định, thể chế, chức trách', 'Là giao tiếp giữa các cá nhân trên một chuyến xe', 'Là giao tiếp tự nguyện, tự giác giữa các cá nhân', 'Là giao tiếp diễn ra theo quy định, thể chế, chức trách', 'apply', '2025-04-03 08:24:06', '2025-04-03 08:24:06'),
(67, 5, 'Giao tiếp chính thức được định nghĩa như thế nào trong tài liệu?', 'Là giao tiếp không bị ràng buộc bởi các nghi thức', 'Là giao tiếp diễn ra theo quy định, thể chế, chức trách', 'Là giao tiếp giữa các cá nhân trên một chuyến xe', 'Là giao tiếp giữa các diễn viên múa và khán giả', 'Là giao tiếp diễn ra theo quy định, thể chế, chức trách', 'apply', '2025-04-03 08:24:06', '2025-04-03 08:24:06'),
(68, 5, 'Theo tài liệu, tâm lý con người có nguồn gốc từ đâu?', 'Từ bên ngoài', 'Từ bên trong', 'Từ kinh nghiệm cá nhân', 'Từ di truyền', 'Từ bên ngoài', 'apply', '2025-04-03 08:24:06', '2025-04-03 08:24:06'),
(69, 5, 'Vai trò của hoạt động và giao tiếp trong việc hình thành và phát triển tâm lý con người là gì?', 'Chỉ là yếu tố phụ', 'Có vai trò quan trọng', 'Không ảnh hưởng đến tâm lý', 'Chỉ ảnh hưởng đến nhân cách', 'Có vai trò quan trọng', 'apply', '2025-04-03 08:24:06', '2025-04-03 08:24:06'),
(70, 5, 'Phân tích vai trò của não bộ trong việc hình thành các hiện tượng tâm lý theo cơ chế phản xạ.', 'Não bộ không có vai trò gì trong tâm lý', 'Não bộ chỉ tiếp nhận thông tin mà không xử lý', 'Não bộ có vai trò quan trọng trong việc tạo ra hiện tượng tâm lý', 'Não bộ chỉ hoạt động theo cách đơn giản', 'Não bộ có vai trò quan trọng trong việc tạo ra hiện tượng tâm lý', 'analyze', '2025-04-03 08:24:06', '2025-04-03 08:24:06'),
(71, 5, 'So sánh hệ thống tín hiệu thứ nhất và thứ hai trong tâm lý học.', 'Hệ thống tín hiệu thứ nhất chỉ có ở người', 'Hệ thống tín hiệu thứ hai không liên quan đến ngôn ngữ', 'Hệ thống tín hiệu thứ nhất liên quan đến cảm tính, còn hệ thống thứ hai liên quan đến tư duy ngôn ngữ', 'Cả hai hệ thống đều giống nhau', 'Hệ thống tín hiệu thứ nhất liên quan đến cảm tính, còn hệ thống thứ hai liên quan đến tư duy ngôn ngữ', 'analyze', '2025-04-03 08:24:06', '2025-04-03 08:24:06'),
(72, 5, 'Đánh giá cơ chế chủ yếu của sự phát triển tâm lý con người là gì?', 'Cơ chế lĩnh hội nền văn hóa xã hội', 'Cơ chế phản ứng với kích thích', 'Cơ chế phát triển năng lực cá nhân', 'Cơ chế tương tác xã hội', 'Cơ chế lĩnh hội nền văn hóa xã hội', 'analyze', '2025-04-03 08:24:06', '2025-04-03 08:24:06'),
(73, 5, 'Phân tích quy luật lan tỏa và tập trung trong hoạt động của vỏ não có ý nghĩa gì đối với phản ứng của con người với ngoại giới?', 'Giúp vỏ não tiết kiệm năng lượng', 'Tăng cường độ lớn của phản ứng', 'Giúp phản ứng linh hoạt và chính xác hơn', 'Giảm thiểu sự hưng phấn trong não', 'Giúp phản ứng linh hoạt và chính xác hơn', 'analyze', '2025-04-03 08:24:06', '2025-04-03 08:24:06'),
(74, 5, 'Phân loại hoạt động của con người theo phương diện phát triển cá thể bao gồm những loại nào?', 'Vui chơi và học tập', 'Làm việc và nghỉ ngơi', 'Chơi thể thao và học tập', 'Nghỉ ngơi và thư giãn', 'Vui chơi và học tập', 'analyze', '2025-04-03 08:24:06', '2025-04-03 08:24:06'),
(75, 5, 'Hãy phân tích cấu trúc của hoạt động theo tài liệu đã cung cấp.', 'Hoạt động, Hành động, Thao tác', 'Động cơ, Mục đích, Phương tiện', 'Chủ thể, Đối tượng, Sản phẩm', 'Tất cả các thành tố trên', 'Tất cả các thành tố trên', 'analyze', '2025-04-03 08:24:06', '2025-04-03 08:24:06'),
(76, 5, 'Phân loại hoạt động được chia thành những loại nào theo phương diện phát triển cá thể?', 'Vui chơi, học tập, lao động, hoạt động xã hội', 'HĐ thực tiễn, HĐ lý luận, HĐ biến đổi, HĐ nhận thức', 'HĐ giao tiếp, HĐ định hướng giá trị, HĐ thực tiễn, HĐ lý luận', 'HĐ biến đổi, HĐ nhận thức, HĐ giao lưu, HĐ thực tiễn', 'Vui chơi, học tập, lao động, hoạt động xã hội', 'analyze', '2025-04-03 08:24:06', '2025-04-03 08:24:06'),
(77, 5, 'Phân loại giao tiếp có thể được chia thành những loại nào dựa vào phương tiện giao tiếp?', 'Giao tiếp bằng ngôn ngữ, giao tiếp bằng tín hiệu phi ngôn ngữ, giao tiếp vật chất', 'Giao tiếp trực tiếp, giao tiếp gián tiếp, giao tiếp chính thức, giao tiếp không chính thức', 'Giao tiếp bằng hình ảnh, giao tiếp bằng âm thanh, giao tiếp bằng chữ viết', 'Giao tiếp cá nhân, giao tiếp nhóm, giao tiếp cộng đồng', 'Giao tiếp bằng ngôn ngữ, giao tiếp bằng tín hiệu phi ngôn ngữ, giao tiếp vật chất', 'analyze', '2025-04-03 08:24:06', '2025-04-03 08:24:06'),
(78, 5, 'Phân tích sự khác biệt giữa giao tiếp chính thức và giao tiếp không chính thức?', 'Giao tiếp chính thức tuân thủ quy định, giao tiếp không chính thức tự nguyện', 'Giao tiếp chính thức chỉ diễn ra giữa người có chức trách, giao tiếp không chính thức không có quy định', 'Giao tiếp chính thức không có cảm xúc, giao tiếp không chính thức có cảm xúc', 'Giao tiếp chính thức chỉ diễn ra trong môi trường học tập, giao tiếp không chính thức diễn ra mọi lúc', 'Giao tiếp chính thức tuân thủ quy định, giao tiếp không chính thức tự nguyện', 'analyze', '2025-04-03 08:24:06', '2025-04-03 08:24:06'),
(79, 5, 'Phân tích vai trò của hoạt động và giao tiếp trong việc hình thành tâm lý con người?', 'Hoạt động và giao tiếp không ảnh hưởng đến tâm lý con người', 'Hoạt động và giao tiếp chỉ là yếu tố phụ trong sự phát triển tâm lý', 'Hoạt động và giao tiếp là yếu tố quyết định hình thành tâm lý và nhân cách', 'Hoạt động và giao tiếp chỉ ảnh hưởng đến một số người nhất định', 'Hoạt động và giao tiếp là yếu tố quyết định hình thành tâm lý và nhân cách', 'analyze', '2025-04-03 08:24:06', '2025-04-03 08:24:06');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext DEFAULT NULL,
  `last_activity` int(10) UNSIGNED DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('Rts4VmCgQZYTuCVGAXiz0ePk6frUDiGdEsHRThmh', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMEgyQTNGTDZPd283WlUyMW1BbFFTTUZZNzJjVVZHcHBGY0NVbjJqWiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMSI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==', 1743693846);

-- --------------------------------------------------------

--
-- Table structure for table `uploaded_files`
--

CREATE TABLE `uploaded_files` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `original_name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `uploaded_files`
--

INSERT INTO `uploaded_files` (`id`, `id_user`, `file_path`, `original_name`, `created_at`, `updated_at`) VALUES
(4, 2, 'uploads/1743693208_TLHĐC-pages-1.pdf', 'TLHĐC-pages-1.pdf', '2025-04-03 08:13:28', '2025-04-03 08:13:28'),
(5, 2, 'uploads/1743693671_TLHĐC-pages-2.pdf', 'TLHĐC-pages-2.pdf', '2025-04-03 08:21:11', '2025-04-03 08:21:11');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `level` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `sdt` varchar(11) DEFAULT NULL,
  `dia_chi` longtext DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT '1',
  `password` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `remember_token` varchar(255) DEFAULT NULL,
  `credit` int(11) NOT NULL DEFAULT 5000
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `level`, `username`, `sdt`, `dia_chi`, `status`, `password`, `fullname`, `email`, `avatar`, `created_at`, `updated_at`, `remember_token`, `credit`) VALUES
(1, 'admin', 'Nha Ngo', '0337405155', 'Soc Trang', '1', '$2y$12$hXh6oAjjEoRX2HljQuEHy.fb4I9xfTy1tDaS71Pcy1JBUaWSGqQDm', 'Nha Ngo', 'admin@gmail.com', NULL, '2025-04-03 14:17:43', NULL, NULL, 5000),
(2, 'user', 'nha1@gmail.com', '0337405155', 'An Binh, Ninh Kieu, Can Tho', '1', '$2y$12$UTMsjLqbGp10aSXJcls9dux53BmlsFp9GIGnYJdD7nvsSPHKQIjG.', 'Nha Ngô', 'nha1@gmail.com', '1743176056_1.jpg', '2025-04-03 07:22:59', '2025-04-03 15:03:42', NULL, 5000),
(3, 'user', 'nha2000@gmail.com', '0333335155', 'Phuong an binh, ninh kieu, can tho', '1', '$2y$12$oiDykvR1OtKhN4aLQF6QQuIkfaSNpT2nBVdadePdSsuLoI8UQCMEC', 'Nha 5', 'nha2000@gmail.com', '1743176192_2.jpg', '2025-04-03 07:23:27', '2025-04-03 15:04:03', NULL, 5000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_file` (`id_file`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id_index` (`user_id`),
  ADD KEY `last_activity_index` (`last_activity`);

--
-- Indexes for table `uploaded_files`
--
ALTER TABLE `uploaded_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `uploaded_files`
--
ALTER TABLE `uploaded_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`id_file`) REFERENCES `uploaded_files` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `uploaded_files`
--
ALTER TABLE `uploaded_files`
  ADD CONSTRAINT `uploaded_files_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
