# Student Manager – WordPress Plugin

> Plugin quản lý sinh viên cho WordPress với Custom Post Type, Meta Boxes và Shortcode.

---

## 📁 Cấu trúc thư mục

```
student-manager/
├── student-manager.php          # File chính – Plugin header & loader
├── includes/
│   ├── cpt-student.php          # Đăng ký Custom Post Type "Sinh viên"
│   ├── meta-box.php             # Custom Meta Boxes (MSSV, Lớp, Ngày sinh)
│   └── shortcode.php            # Shortcode [danh_sach_sinh_vien]
├── assets/
│   └── style.css                # CSS bảng hiển thị frontend
└── README.md
```

---

## ⚙️ Yêu cầu hệ thống

| Yêu cầu | Phiên bản tối thiểu |
|---|---|
| WordPress | 5.8+ |
| PHP | 7.4+ |

---

## 🚀 Hướng dẫn cài đặt

1. Tải file `.zip` về máy.
2. Vào **WordPress Admin → Plugins → Add New → Upload Plugin**.
3. Chọn file `student-manager.zip` và nhấn **Install Now**.
4. Nhấn **Activate Plugin**.

Hoặc giải nén và copy thư mục `student-manager/` vào:
```
wp-content/plugins/student-manager/
```

---

## 📌 Hướng dẫn sử dụng

### 1. Thêm sinh viên mới
- Vào **WordPress Admin → Sinh viên → Thêm mới**.
- Nhập **Họ tên** (Title) và **Tiểu sử/Ghi chú** (Editor).
- Điền thông tin trong ô **Thông tin sinh viên**:
  - Mã số sinh viên (MSSV)
  - Lớp / Chuyên ngành (dropdown)
  - Ngày sinh (date picker)
- Nhấn **Publish** để lưu.

### 2. Hiển thị danh sách sinh viên

Chèn shortcode sau vào bất kỳ trang (Page) hoặc bài viết nào:

```
[danh_sach_sinh_vien]
```

Kết quả hiển thị bảng với các cột: **STT | MSSV | Họ tên | Lớp | Ngày sinh**.

#### Tùy chọn shortcode

| Thuộc tính | Mô tả | Mặc định |
|---|---|---|
| `so_luong` | Giới hạn số sinh viên hiển thị | `-1` (tất cả) |

**Ví dụ:**
```
[danh_sach_sinh_vien so_luong="10"]
```

---

## 🔒 Bảo mật

- Sử dụng **WordPress Nonce** để xác thực form Meta Box.
- Toàn bộ dữ liệu đầu vào được **Sanitize** trước khi lưu vào DB.
- Kiểm tra **quyền truy cập** (`current_user_can`) trước khi lưu.
- Validate định dạng ngày sinh (`YYYY-MM-DD`).
- Whitelist giá trị hợp lệ cho trường Lớp/Chuyên ngành.

---

## 📷 Ảnh chụp kết quả

### Admin – Danh sách sinh viên
<img width="1920" height="923" alt="{B818D4BE-2664-41ED-AC74-44B02E644F2A}-1" src="https://github.com/user-attachments/assets/6c1697aa-a974-49a5-8107-0c9acf491cf1" />


### Admin – Form nhập liệu Meta Box
<img width="1907" height="919" alt="{76A7BF6D-ACC2-455B-A5C4-198FC044179B}" src="https://github.com/user-attachments/assets/270c412c-5d5e-4971-8051-a742221cbc1e" />


### Frontend – Shortcode hiển thị bảng
<img width="1920" height="901" alt="{5334F203-4952-4FBE-89A4-0E026C3E5BEF}" src="https://github.com/user-attachments/assets/2f3b4a4a-f271-45f7-8989-cde54addf485" />


---

## 🗄️ Dữ liệu lưu trữ

Dữ liệu meta được lưu trong bảng `wp_postmeta` với các key:

| Meta Key | Mô tả |
|---|---|
| `_sm_mssv` | Mã số sinh viên |
| `_sm_lop` | Lớp / Chuyên ngành |
| `_sm_ngay_sinh` | Ngày sinh (định dạng `YYYY-MM-DD`) |

---

## 📝 Changelog

### v1.0.0
- Khởi tạo plugin.
- Đăng ký Custom Post Type `sinh_vien`.
- Thêm Meta Boxes: MSSV, Lớp, Ngày sinh.
- Shortcode `[danh_sach_sinh_vien]` với bảng responsive.
- CSS tùy chỉnh cho bảng frontend.

---

## 👤 Tác giả

- **Tên:** Your Name  
- **Email:** your@email.com  
- **GitHub:** https://github.com/your-username/student-manager

---

## 📄 Giấy phép

Plugin được phân phối theo giấy phép **GPL-2.0+**.
