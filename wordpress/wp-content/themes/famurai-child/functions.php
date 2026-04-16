<?php
/**
 * Famurai Child Theme Functions
 */

// 親テーマのスタイルを読み込む
add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style(
		'greenshift-parent-style',
		get_template_directory_uri() . '/style.css'
	);
} );

// WooCommerce: Single Product ページでブロックエディターを有効化
add_filter( 'woocommerce_admin_get_feature_config', function ( $features ) {
	$features['product-block-editor'] = true;
	return $features;
} );
