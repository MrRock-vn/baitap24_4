<?php
/**
 * Shortcode [danh_sach_sinh_vien]
 * Hiển thị danh sách sinh viên dưới dạng bảng HTML
 *
 * @package StudentManager
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Map giá trị lớp sang nhãn hiển thị
 *
 * @param string $value Giá trị lưu trong DB.
 * @return string Nhãn hiển thị.
 */
function sm_get_lop_label( $value ) {
    $map = array(
        'CNTT'      => 'Công nghệ thông tin',
        'Kinh_te'   => 'Kinh tế',
        'Marketing' => 'Marketing',
        'Ke_toan'   => 'Kế toán',
        'Luat'      => 'Luật',
        'Y_khoa'    => 'Y khoa',
    );
    return isset( $map[ $value ] ) ? $map[ $value ] : esc_html( $value );
}

/**
 * Callback cho shortcode [danh_sach_sinh_vien]
 *
 * @param array $atts Các thuộc tính shortcode.
 * @return string HTML bảng danh sách sinh viên.
 */
function sm_danh_sach_sinh_vien_shortcode( $atts ) {
    $atts = shortcode_atts(
        array(
            'so_luong' => -1, // -1 = tất cả
        ),
        $atts,
        'danh_sach_sinh_vien'
    );

    $args = array(
        'post_type'      => 'sinh_vien',
        'post_status'    => 'publish',
        'posts_per_page' => intval( $atts['so_luong'] ),
        'orderby'        => 'date',
        'order'          => 'ASC',
    );

    $query = new WP_Query( $args );

    if ( ! $query->have_posts() ) {
        return '<p class="sm-no-students">' . esc_html__( 'Chưa có sinh viên nào được thêm.', 'student-manager' ) . '</p>';
    }

    ob_start();
    ?>
    <div class="sm-student-list-wrapper">
        <h2 class="sm-table-title">Danh sách sinh viên</h2>
        <div class="sm-table-responsive">
            <table class="sm-student-table">
                <thead>
                    <tr>
                        <th class="sm-col-stt">STT</th>
                        <th class="sm-col-mssv">MSSV</th>
                        <th class="sm-col-hoten">Họ tên</th>
                        <th class="sm-col-lop">Lớp / Chuyên ngành</th>
                        <th class="sm-col-ngaysinh">Ngày sinh</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stt = 1;
                    while ( $query->have_posts() ) :
                        $query->the_post();
                        $post_id   = get_the_ID();
                        $mssv      = get_post_meta( $post_id, '_sm_mssv', true );
                        $lop       = get_post_meta( $post_id, '_sm_lop', true );
                        $ngay_sinh = get_post_meta( $post_id, '_sm_ngay_sinh', true );

                        // Format ngày sinh sang dd/mm/yyyy
                        $ngay_hien_thi = '';
                        if ( ! empty( $ngay_sinh ) ) {
                            $date_obj      = DateTime::createFromFormat( 'Y-m-d', $ngay_sinh );
                            $ngay_hien_thi = $date_obj ? $date_obj->format( 'd/m/Y' ) : esc_html( $ngay_sinh );
                        }
                        ?>
                        <tr class="<?php echo ( 0 === $stt % 2 ) ? 'sm-row-even' : 'sm-row-odd'; ?>">
                            <td class="sm-col-stt"><?php echo esc_html( $stt ); ?></td>
                            <td class="sm-col-mssv"><?php echo esc_html( $mssv ? $mssv : '—' ); ?></td>
                            <td class="sm-col-hoten"><?php the_title(); ?></td>
                            <td class="sm-col-lop"><?php echo esc_html( $lop ? sm_get_lop_label( $lop ) : '—' ); ?></td>
                            <td class="sm-col-ngaysinh"><?php echo esc_html( $ngay_hien_thi ? $ngay_hien_thi : '—' ); ?></td>
                        </tr>
                        <?php
                        $stt++;
                    endwhile;
                    wp_reset_postdata();
                    ?>
                </tbody>
            </table>
        </div>
        <p class="sm-total-count">Tổng số sinh viên: <strong><?php echo esc_html( $query->found_posts ); ?></strong></p>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'danh_sach_sinh_vien', 'sm_danh_sach_sinh_vien_shortcode' );
