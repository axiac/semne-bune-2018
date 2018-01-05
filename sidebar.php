<?php
/**
 * Display different sidebars for articles and categories
 */

if ( is_category() || is_archive() ) {
	get_sidebar('category' );
} elseif ( is_single() ) {
	get_sidebar( 'article' );
} else {
	// Default: use the sidebar of the parent theme
	include get_template_directory().'/sidebar.php';
}

