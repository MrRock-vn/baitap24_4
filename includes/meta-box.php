<?php
/**
 * Custom Meta Boxes cho Sinh viên
 * Thêm các trường: MSSV, Lớp/Chuyên ngành, Ngày sinh
 *
 * @package StudentManager
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Đăng ký Meta Box
 */
function sm_add_student_meta_box() {
    add_meta_box(
        'sm_student_info',
        __( 'Thông tin sinh viên', 'student-manager' ),
        'sm_render_student_meta_box',
        'sinh_vien',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'sm_add_student_meta_box' );

/**
 * Render nội dung Meta Box
 *
 * @param WP_Post $post Post hiện tại.
 */
function sm_render_student_meta_box( $post ) {
    // Tạo nonce để bảo mật
    wp_nonce_field( 'sm_save_student_meta', 'sm_student_nonce' );

    // Lấy dữ liệu đã lưu
    $mssv      = get_post_meta( $post->ID, '_sm_mssv', true );
    $lop       = get_post_meta( $post->ID, '_sm_lop', true );
    $ngay_sinh = get_post_meta( $post->ID, '_sm_ngay_sinh', true );

    // Danh sách lớp/chuyên ngành
    $chuyen_nganh = array(
        ''          => '-- Chọn chuyên ngành --',
        'CNTT'      => 'Công nghệ thông tin',
        'Kinh_te'   => 'Kinh tế',
        'Marketing' => 'Marketing',
        'Ke_toan'   => 'Kế toán',
        'Luat'      => 'Luật',
        'Y_khoa'    => 'Y khoa',
    );
    ?>
    <style>
        .sm-meta-box-table { width: 100%; border-collapse: collapse; }
        .sm-meta-box-table th { text-align: left; padding: 8px 10px; width: 160px; font-weight: 600; color: #333; }
        .sm-meta-box-table td { padding: 8px 10px; }
        .sm-meta-box-table input[type="text"],
        .sm-meta-box-table input[type="date"],
        .sm-meta-box-table select { width: 100%; max-width: 400px; padding: 6px 8px; border: 1px solid #ddd; border-radius: 4px; }
    </style>

    <table class="sm-meta-box-table">
        <tr>
            <th>
                <label for="sm_mssv"><?php esc_html_e( 'Mã số sinh viên (MSSV)', 'student-manager' ); ?></label>
            </th>
            <td>
                <input
                    type="text"
                    id="sm_mssv"
                    name="sm_mssv"
                    value="<?php echo esc_attr( $mssv ); ?>"
                    placeholder="Ví dụ: SV2024001"
                />
            </td>
        </tr>
        <tr>
            <th>
                <label for="sm_lop"><?php esc_html_e( 'Lớp / Chuyên ngành', 'student-manager' ); ?></label>
            </th>
            <td>
                <select id="sm_lop" name="sm_lop">
                    <?php foreach ( $chuyen_nganh as $value => $label ) : ?>
                        <option value="<?php echo esc_attr( $value ); ?>" <?php selected( $lop, $value ); ?>>
                            <?php echo esc_html( $label ); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
        <tr>
            <th>
                <label for="sm_ngay_sinh"><?php esc_html_e( 'Ngày sinh', 'student-manager' ); ?></label>
            </th>
            <td>
                <input
                    type="date"
                    id="sm_ngay_sinh"
                    name="sm_ngay_sinh"
                    value="<?php echo esc_attr( $ngay_sinh ); ?>"
                />
            </td>
        </tr>
    </table>
    <?php
}

/**
 * Lưu dữ liệu Meta Box
 *
 * @param int $post_id ID của post.
 */
function sm_save_student_meta( $post_id ) {
    // Kiểm tra nonce
    if ( ! isset( $_POST['sm_student_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['sm_student_nonce'] ) ), 'sm_save_student_meta' ) ) {
        return;
    }

    // Không lưu khi autosave
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Kiểm tra quyền
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    // Kiểm tra đúng post type
    if ( get_post_type( $post_id ) !== 'sinh_vien' ) {
        return;
    }

    // Sanitize và lưu MSSV
    if ( isset( $_POST['sm_mssv'] ) ) {
        update_post_meta( $post_id, '_sm_mssv', sanitize_text_field( wp_unslash( $_POST['sm_mssv'] ) ) );
    }

    // Sanitize và lưu Lớp
    if ( isset( $_POST['sm_lop'] ) ) {
        $allowed_lop = array( '', 'CNTT', 'Kinh_te', 'Marketing', 'Ke_toan', 'Luat', 'Y_khoa' );
        $lop_value   = sanitize_text_field( wp_unslash( $_POST['sm_lop'] ) );
        if ( in_array( $lop_value, $allowed_lop, true ) ) {
            update_post_meta( $post_id, '_sm_lop', $lop_value );
        }
    }

    // Sanitize và lưu Ngày sinh
    if ( isset( $_POST['sm_ngay_sinh'] ) ) {
        $ngay_sinh = sanitize_text_field( wp_unslash( $_POST['sm_ngay_sinh'] ) );
        // Validate định dạng ngày YYYY-MM-DD
        if ( preg_match( '/^\d{4}-\d{2}-\d{2}$/', $ngay_sinh ) || '' === $ngay_sinh ) {
            update_post_meta( $post_id, '_sm_ngay_sinh', $ngay_sinh );
        }
    }
}
add_action( 'save_post', 'sm_save_student_meta' );
