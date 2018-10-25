<?php

add_action( 'init', function () {
	if ( is_admin() ) {
		return;
	}
	global $wp_scripts;
	$jquery     = $wp_scripts->registered['jquery-core'];
	$jquery_ver = $jquery->ver;
	$jquery_src = $jquery->src;
	wp_deregister_script( 'jquery' );
	wp_deregister_script( 'jquery-core' );
	wp_register_script( 'jquery', false, [ 'jquery-core' ], $jquery_ver, true );
	wp_register_script( 'jquery-core', $jquery_src, [], $jquery_ver, true );
} );

//for debug
function aetherium_add_filter_remove_origin_from_uri( $hook ) {
	add_filter( $hook, 'wp_make_link_relative' );
}

if ( ! is_admin() and $GLOBALS['pagenow'] !== 'wp-login.php' and WP_DEBUG ) {
	array_map( 'aetherium_add_filter_remove_origin_from_uri', [
		"home_url",
		"site_url",
		"rest_url",
		"stylesheet_directory_uri",
		"template_directory_uri",
		//"plugins_url",
		"wp_get_attachment_url",
		"style_loader_src",
		"script_loader_src",
		"theme_file_uri"
	] );

}
