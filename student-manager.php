<?php
/**
 * Plugin Name: Student Manager
 * Plugin URI:  https://github.com/your-username/student-manager
 * Description: Quản lý sinh viên với Custom Post Type, Meta Boxes và Shortcode hiển thị danh sách.
 * Version:     1.0.0
 * Author:      Your Name
 * Author URI:  https://yourwebsite.com
 * License:     GPL-2.0+
 * Text Domain: student-manager
 */

// Ngăn chặn truy cập trực tiếp
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Định nghĩa hằng số
define( 'SM_VERSION', '1.0.0' );
define( 'SM_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'SM_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// Include các file chức năng
require_once SM_PLUGIN_DIR . 'includes/cpt-student.php';
require_once SM_PLUGIN_DIR . 'includes/meta-box.php';
require_once SM_PLUGIN_DIR . 'includes/shortcode.php';

// Enqueue CSS ở frontend
function sm_enqueue_styles() {
    if ( ! is_admin() ) {
        wp_enqueue_style(
            'student-manager-style',
            SM_PLUGIN_URL . 'assets/style.css',
            array(),
            SM_VERSION
        );
    }
}
add_action( 'wp_enqueue_scripts', 'sm_enqueue_styles' );
