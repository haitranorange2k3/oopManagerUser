# oopManagerUser
# Thực Hành Xây Dựng Chức Năng Quản Lý Người Dùng

## Phần 1: Xác Thực Truy Cập
- **Đăng Nhập:** Người dùng có thể đăng nhập vào hệ thống bằng tài khoản đã đăng ký.
- **Đăng Ký:** Cho phép người dùng tạo tài khoản mới để truy cập vào hệ thống.
- **Đăng Xuất:** Cho phép người dùng đăng xuất khỏi tài khoản hiện tại.
- **Quên Mật Khẩu:** Cung cấp tính năng cho phép người dùng khôi phục mật khẩu khi quên mật khẩu hiện tại.
- **Kích Hoạt Tài Khoản:** Người dùng cần kích hoạt tài khoản qua email để sử dụng đầy đủ chức năng của hệ thống.

## Phần 2: Quản Lý Người Dùng
- **Kiểm Tra Người Dùng Đăng Nhập:** Xác định người dùng nào đang đăng nhập vào hệ thống.
- **Thêm Người Dùng:** Cho phép quản trị viên thêm người dùng mới vào hệ thống.
- **Sửa và Xóa Người Dùng:** Cung cấp chức năng sửa đổi thông tin và xóa người dùng khỏi hệ thống.
- **Hiển Thị Số User:** Hiển thị số lượng người dùng hiện có trong hệ thống.
- **Phân Trang:** Phân trang kết quả khi hiển thị danh sách người dùng.
- **Tìm Kiếm và Lọc Dữ Liệu:** Cho phép tìm kiếm và lọc dữ liệu người dùng dựa trên các tiêu chí nhất định.

## Thiết Kế Database
### Bảng Users:
- **id:** Khóa chính (int)
- **fullname:** Tên đầy đủ của người dùng (varchar(100))
- **email:** Địa chỉ email của người dùng (varchar(100))
- **phone:** Số điện thoại của người dùng (varchar(10))
- **password:** Mật khẩu của người dùng (varchar(50))
- **forgotToken:** Mã token cho tính năng quên mật khẩu (varchar(100))
- **activeToken:** Mã token cho tính năng kích hoạt tài khoản (varchar(100))
- **create_at:** Thời gian tạo tài khoản (datetime)
- **update_at:** Thời gian cập nhật tài khoản (datetime)

### Bảng loginToken:
- **id:** Khóa chính (int)
- **user_id:** Khóa ngoại liên kết với bảng Users (int)
- **token:** Mã token cho phiên đăng nhập (varchar(100))
- **create_at:** Thời gian tạo token (datetime)

## Mã Nguồn Chức Năng Đăng Ký Tài Khoản
- **Đăng Ký:** Kiểm tra thông tin và thêm dữ liệu vào bảng Users.
- **Gửi Email Kích Hoạt:** Gửi email kích hoạt tài khoản cho người dùng.
- **Kích Hoạt Tài Khoản:** Người dùng nhấn vào liên kết trong email để kích hoạt tài khoản (OTP).

## Mã Nguồn Chức Năng Quên Mật Khẩu
- **Tạo ForgotToken:** Tạo mã token để khôi phục mật khẩu.
- **Gửi Email Reset Mật Khẩu:** Gửi email chứa liên kết đến trang reset mật khẩu.
- **Xác Thực Token:** Hiển thị form để đặt lại mật khẩu sau khi xác thực mã token.
- **Submit Reset Password:** Xử lý yêu cầu và cập nhật lại mật khẩu mới.
