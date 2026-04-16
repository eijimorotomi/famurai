<?php
/**
 * Plugin Name: Famurai WC Product Block Editor
 * Description: product 投稿タイプで Gutenberg ブロックエディターを有効化
 * Version: 1.0.0
 *
 * WooCommerce (class-wc-post-types.php) が priority 10 で product を false に固定しているため、
 * priority 20 で両フィルターを上書きする。
 */

function famurai_activate_gutenberg_product( $can_edit, $post_type ) {
	if ( 'product' === $post_type ) {
		return true;
	}
	return $can_edit;
}
add_filter( 'use_block_editor_for_post_type', 'famurai_activate_gutenberg_product', 20, 2 );
add_filter( 'gutenberg_can_edit_post_type',   'famurai_activate_gutenberg_product', 20, 2 );
