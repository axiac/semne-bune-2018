<?php
/**
 * Semne Bune 2018 theme - sidebar setup
 *
 * Display different sidebars for articles and categories
 *
 * @package semne-bune-2018
 */

if (is_category() || is_archive()) {
	get_sidebar('category');
} elseif (is_single()) {
	get_sidebar('article');
} else {
	// Default: use the sidebar of the parent theme
	include get_template_directory().'/sidebar.php';
}

