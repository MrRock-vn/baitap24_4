<?php
/**
 * Đăng ký Custom Post Type: Sinh Viên
 *
 * @package StudentManager
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function sm_register_student_cpt() {
    $labels = array(
        'name'               => __( 'Sinh viên', 'student-manager' ),
        'singular_name'      => __( 'Sinh viên', 'student-manager' ),
        'menu_name'          => __( 'Sinh viên', 'student-manager' ),
        'name_admin_bar'     => __( 'Sinh viên', 'student-manager' ),
        'add_new'            => __( 'Thêm mới', 'student-manager' ),
        'add_new_item'       => __( 'Thêm sinh viên mới', 'student-manager' ),
        'new_item'           => __( 'Sinh viên mới', 'student-manager' ),
        'edit_item'          => __( 'Chỉnh sửa sinh viên', 'student-manager' ),
        'view_item'          => __( 'Xem sinh viên', 'student-manager' ),
        'all_items'          => __( 'Tất cả sinh viên', 'student-manager' ),
        'search_items'       => __( 'Tìm kiếm sinh viên', 'student-manager' ),
        'not_found'          => __( 'Không tìm thấy sinh viên nào.', 'student-manager' ),
        'not_found_in_trash' => __( 'Không có sinh viên nào trong thùng rác.', 'student-manager' ),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'sinh-vien' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-welcome-learn-more',
        'supports'           => array( 'title', 'editor' ),
    );

    register_post_type( 'sinh_vien', $args );
}
add_action( 'init', 'sm_register_student_cpt' );
