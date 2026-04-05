<?php
/**
 * Famurai Child Theme — functions.php
 * 親テーマ: Twenty Twenty-Five
 */

// 親テーマのスタイルシートを読み込む
add_action( 'wp_enqueue_scripts', function () {
    wp_enqueue_style(
        'famurai-parent-style',
        get_template_directory_uri() . '/style.css'
    );
    wp_enqueue_style(
        'famurai-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        [ 'famurai-parent-style' ],
        wp_get_theme()->get( 'Version' )
    );
} );
