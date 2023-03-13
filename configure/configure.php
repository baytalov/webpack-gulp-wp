<?php

// МЕНЮ
function _custom_theme_register_menu() {
    register_nav_menus(
        array(
            'menu-main' => __( 'Menu principal' ),
            //'menu-footer' => __( 'Menu footer' ),
        )
    );
}
add_action( 'init', '_custom_theme_register_menu' );

function custom_setup() {
    // Images
    add_theme_support( 'post-thumbnails' );

    // Title tags
    add_theme_support('title-tag');

    // Languages
    load_theme_textdomain('textdomaintomodify', get_template_directory() . '/languages');

    // HTML 5 — пример: удаляет type="*" в скриптах и тегах стилей
    add_theme_support( 'html5', [ 'script', 'style' ] );

    // Удалить SVG и глобальные стили
    remove_action('wp_enqueue_scripts', 'wp_enqueue_global_styles');
    remove_action('wp_body_open', 'wp_global_styles_render_svg_filters' );

    // Удалите действия wp_footer, которые добавляют глобальные встроенные стили.
    remove_action('wp_footer', 'wp_enqueue_global_styles', 1);

    // Удалите фильтры render_block, которые добавляют ненужные вещи.
    remove_filter('render_block', 'wp_render_duotone_support');
    remove_filter('render_block', 'wp_restore_group_inner_container');
    remove_filter('render_block', 'wp_render_layout_support_flag');

	// Удаляем бесполезные размеры изображений WP
	remove_image_size( '1536x1536' );
	remove_image_size( '2048x2048' );

	// Пользовательские размеры изображений
	// add_image_size( '424x424', 424, 424, true );
	// add_image_size( '1920', 1920, 9999 );
}
add_action('after_setup_theme', 'custom_setup');

// удалите размеры изображений по умолчанию, чтобы избежать перегрузки сервера - строка комментария, если вам нужен размер
function remove_default_image_sizes( $sizes) {
	unset( $sizes['large']);
	unset( $sizes['medium']);
	unset( $sizes['medium_large']);
	return $sizes;
}
add_filter('intermediate_image_sizes_advanced', 'remove_default_image_sizes');

// отключение масштабирования больших изображений
add_filter( 'big_image_size_threshold', '__return_false' );

// Предоставление кредитов
function remove_footer_admin () {
	echo 'Сайт разработал <a href="#!" target="_blank">Baytalov Karen</a>';
}
add_filter('admin_footer_text', 'remove_footer_admin');

// Переместить Yoast вниз
function yoasttobottom() {
	return 'low';
}
add_filter( 'wpseo_metabox_prio', 'yoasttobottom');

// Удалить эмодзи WP
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );

// удалить wp-embed.js из нижнего колонтитула
function my_deregister_scripts() {
	wp_deregister_script( 'wp-embed' );
}
add_action( 'wp_footer', 'my_deregister_scripts' );

// удаляем миграцию jquery
function dequeue_jquery_migrate( &$scripts){
	if(!is_admin()){
		$scripts->remove( 'jquery');
		$scripts->add('jquery', 'https://code.jquery.com/jquery-3.6.1.min.js', null, null, true );
	}
}
add_filter( 'wp_default_scripts', 'dequeue_jquery_migrate' );

// добавить SVG к разрешенным загрузкам файлов
function add_file_types_to_uploads($mime_types) {
	$mime_types['svg'] = 'image/svg+xml';

	return $mime_types;
}
add_action('upload_mimes', 'add_file_types_to_uploads', 1, 1);

//отключаем обновления по электронной почте
add_filter( 'auto_plugin_update_send_email', '__return_false' );
add_filter( 'auto_theme_update_send_email', '__return_false' );
