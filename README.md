# Laravel Command Bus Design Pattern Codebase

## Giới thiệu

Dự án này sử dụng **Command Bus Design Pattern** để tổ chức mã nguồn một cách rõ ràng và dễ bảo trì. Cách tiếp cận này tách biệt logic nghiệp vụ ra khỏi các lớp Controller, đảm bảo khả năng mở rộng và bảo trì lâu dài.

Dự án được xây dựng trên **Laravel 11**, sử dụng các tính năng mới nhất của framework để cung cấp một nền tảng hiện đại, mạnh mẽ và hiệu quả cho phát triển ứng dụng.

## Yêu cầu hệ thống

- **PHP**: Phiên bản 8.2 trở lên.
- **Laravel**: Phiên bản 11.
- **Database**: MySQL, PostgreSQL hoặc bất kỳ hệ quản trị cơ sở dữ liệu nào được Laravel hỗ trợ.

## Hướng dẫn cài đặt

1. Clone dự án:
   ```bash
   git clone https://github.com/username/your-project.git
   cd your-project
   ```

2. Cài đặt các phụ thuộc:
   ```bash
   composer install
   ```

3. Tạo file `.env` và cấu hình:
   ```bash
   cp .env.example .env
   ```
   - Thiết lập thông tin kết nối cơ sở dữ liệu.

4. Tạo key ứng dụng:
   ```bash
   php artisan key:generate
   ```

5. Chạy migration và seed dữ liệu:
   ```bash
   php artisan migrate --seed
   ```

6. Khởi động server:
   ```bash
   php artisan serve
   ```

7. Truy cập ứng dụng tại `http://localhost:8000`.

## Cấu trúc thư mục

Dự án sử dụng cấu trúc thư mục sau để tổ chức mã nguồn:

- `app/Commands`: Chứa các lớp lệnh (Command).
- `app/Handlers`: Chứa các lớp xử lý lệnh (Handler).
- `app/Http/Controllers`: Chứa các lớp Controller.
- `app/Http/Requests`: Chứa các lớp yêu cầu (Request).
- `app/Http/Resources`: Chứa các lớp tài nguyên (Resource).

## Các tính năng chính

- **Tổ chức mã nguồn rõ ràng**: Mỗi tính năng được chia thành các lớp Command và Handler tương ứng.
- **Dễ dàng mở rộng**: Thêm tính năng mới chỉ cần tạo các lớp Command và Handler mới.
- **Đơn giản hóa Controller**: Chỉ chịu trách nhiệm gọi Command, không chứa logic nghiệp vụ.
- **Tái sử dụng logic nghiệp vụ**: Các Command có thể được sử dụng ở nhiều nơi khác nhau.

## Các tính năng tích hợp sẵn

### API đầy đủ tính năng User
- **GET**: Lấy thông tin người dùng.
- **POST**: Tạo người dùng mới.
- **PUT**: Cập nhật thông tin người dùng.
- **DELETE**: Xóa người dùng.

### Các tính năng Authentication
- **Đăng nhập**: Quản lý phiên người dùng.
- **Đăng ký**: Tạo tài khoản mới.
- **Quên mật khẩu**: Gửi email đặt lại mật khẩu.

### Các tính năng bổ sung
- **Cập nhật avatar**: Người dùng có thể tải lên và thay đổi avatar.
- **Phân quyền**: Hỗ trợ các vai trò khác nhau trong hệ thống.

### Migration
- Bao gồm một bảng thiết kế cơ sở dữ liệu cho một trang web Thương mại điện tử (TMĐT) cơ bản:
  - **Users**: Thông tin người dùng.
  - **Products**: Quản lý sản phẩm.
  - **Orders**: Quản lý đơn hàng.
  - **Order Items**: Chi tiết các sản phẩm trong đơn hàng.
  - **Categories**: Phân loại sản phẩm.
  - ...

## Hướng dẫn sử dụng

### Tạo Command và Handler

Sử dụng Artisan command để tạo Command và Handler mới:

1. Tạo Command:
   ```bash
   php artisan make:command-bus Auth/ResetPasswordCommand
   ```
   Lệnh trên sẽ tạo file `Auth/ResetPasswordCommand.php` trong thư mục `app/Commands/Auth`.

2. Tạo Handler:
   ```bash
   php artisan make:command-bus Auth/ResetPasswordHandler --type=handler
   ```
   Lệnh trên sẽ tạo file `Auth/ResetPasswordHandler.php` trong thư mục `app/Handlers/Auth`.

### Liên kết Command với Handler

1. Trong file Handler, định nghĩa logic xử lý lệnh:
   ```php
   namespace App\Handlers\Auth;

   use App\Commands\Auth\ResetPasswordCommand;

   class ResetPasswordHandler
   {
       public function handle(ResetPasswordCommand $command)
       {
           // Thực hiện logic reset mật khẩu tại đây.
       }
   }
   ```

2. Trong Command, định nghĩa các thuộc tính cần thiết:
   ```php
   namespace App\Commands\Auth;

   class ResetPasswordCommand
   {
       public function __construct(public string $email, public string $newPassword)
       {
       }
   }
   ```

3. Sử dụng Command trong Controller:
   ```php
   use App\Commands\Auth\ResetPasswordCommand;
   use App\Handlers\Auth\ResetPasswordHandler;

   class AuthController
   {
       public function resetPassword(Request $request, ResetPasswordHandler $handler)
       {
           $command = new ResetPasswordCommand($request->email, $request->new_password);
           $handler->handle($command);

           return response()->json(['message' => 'Password reset successfully.']);
       }
   }
   ```

## Thêm Command tự động

Sử dụng lệnh sau để khởi tạo nhanh toàn bộ các lớp cần thiết cho một tính năng mới:

```bash
php artisan make:feature {model}
```
Lệnh trên sẽ tự động tạo các file:
- Controller
- Requests (Create, Update, Filter)
- Resources (List, Detail)
- Command
- Handler

Ví dụ:
```bash
php artisan make:feature User
```

## Kết luận

Dự án Laravel với Command Bus Design Pattern giúp tăng tính rõ ràng, khả năng mở rộng và bảo trì cho mã nguồn. Hãy làm theo hướng dẫn trên để bắt đầu và phát triển dự án của bạn dễ dàng hơn.
