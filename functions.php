<?php
/**
 * Customization for semnebune.ro
 *
 * @see Semne Bune 2018
 */


/**
 * After theme setup, remove the banners from the list of image sizes
 */
function sb_action_after_setup_theme() {
	// Use SemneBune 2018 translation; it also disables the Lato font
	load_theme_textdomain( 'islemag', get_theme_file_path('/languages' ));

	// Remove the "no_crop" image sizes
	remove_image_size( 'islemag_sections_small_thumbnail_no_crop' );
	remove_image_size( 'islemag_section4_big_thumbnail_no_crop' );
	remove_image_size( 'islemag_blog_post_no_crop' );

	// Remove banner sizes from the list of image sizes
	remove_image_size( 'islemag_leaderboard' );
	remove_image_size( 'islemag_3_1_rectangle' );
	remove_image_size( 'islemag_medium_rectangle' );
	remove_image_size( 'islemag_half_page' );
	remove_image_size( 'islemag_square_pop_up' );
	remove_image_size( 'islemag_vertical_rectangle' );
	remove_image_size( 'islemag_ad_125' );
}
add_action( 'after_setup_theme', 'sb_action_after_setup_theme', 15 );



/**
 * Add separate sidebars for categories and articles
 */
function sb_action_widgets_init() {
	// Register two additional sidebars for semnebune.ro
	register_sidebar(
		array(
			'name'          => esc_html__( 'Category Sidebar', 'islemag' ),
			'id'            => 'semnebune-sidebar-category',
			'description'   => 'This sidebar appears on category pages, when it is not empty. When empty, the default sidebar is used instead.',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="title-border dkgreen title-bg-line"><span>',
			'after_title'   => '</span></h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Article Sidebar', 'islemag' ),
			'id'            => 'semnebune-sidebar-article',
			'description'   => 'This sidebar appears on article pages, when it is not empty. When empty, the default sidebar is used instead.',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="title-border dkgreen title-bg-line"><span>',
			'after_title'   => '</span></h3>',
		)
	);
}
add_action( 'widgets_init', 'sb_action_widgets_init' );



/**
 * Substitute the "no_crop" image sizes with the corresponding square sizes (cropped)
 * @param string $size
 * @return string
 */
function sb_filter_post_thumbnail_size( $size ) {
	switch ($size) {
	case 'islemag_sections_small_thumbnail_no_crop':
		return 'islemag_sections_small_thumbnail';

	case 'islemag_section4_big_thumbnail_no_crop':
		return 'islemag_section4_big_thumbnail';

	case 'islemag_blog_post_no_crop':
		return 'islemag_blog_post';

	default:
		return $size;
	}
}
add_filter( 'post_thumbnail_size', 'sb_filter_post_thumbnail_size' );


function sb_filter_image_downsize( $downsize, $id = null, $size = null ) {
	switch ($size) {
	case 'islemag_sections_small_thumbnail_no_crop':
		return image_downsize( $id, 'islemag_sections_small_thumbnail' );

	case 'islemag_section4_big_thumbnail_no_crop':
		return image_downsize( $id, 'islemag_section4_big_thumbnail' );

	case 'islemag_blog_post_no_crop':
		return image_downsize( $id, 'islemag_blog_post' );

	default:
		return false;
	}
}
add_filter( 'image_downsize', 'sb_filter_image_downsize', 10, 3 );


/**
 * Remove the banner sizes from the list of image sizes in image_size_names_choose for media uploader
 */
function sb_filter_media_uploader_custom_sizes( array $sizes ) {
	unset(
		$sizes['islemag_leaderboard'],
		$sizes['islemag_3_1_rectangle'],
		$sizes['islemag_medium_rectangle'],
		$sizes['islemag_half_page'],
		$sizes['islemag_square_pop_up'],
		$sizes['islemag_vertical_rectangle'],
		$sizes['islemag_ad_125']
	);

	return $sizes;
}
add_filter( 'image_size_names_choose', 'sb_filter_media_uploader_custom_sizes', 15 );


/**
 * Add the style adjustments (transparent content area, many small fixes)
 */
function sb_action_enqueue_scripts() {
	$parent_style = 'islemag-style';
	// The parent theme have already registered its style
	// Need to de-queue and de-register it in order to put a different URL instead
	// The parent theme uses get_stylesheet_uri() as the URI of its stylesheet
	// but it provides the wrong URI in a child theme (the style of this theme).
	wp_dequeue_style($parent_style);
	wp_deregister_style($parent_style);
	// Enqueue the style of the parent theme with its correct URI
	wp_enqueue_style($parent_style, get_template_directory_uri() . '/style.css' );
	// Then enqueue the style of this theme and make it depend on the parent theme's style
	wp_enqueue_style('sb-style', get_stylesheet_uri(), array( $parent_style ), wp_get_theme()->get( 'Version' ) );
}
// This is really hackish: hook the enqueuing of the styles after the parent enqueues its styles
add_action( 'wp_head', 'sb_action_enqueue_scripts', 5 );

/**
 * Shortcode [year] for automatic updates of the copyright years.
 */
function sb_shortcode_year(){
	return date('Y');
}
add_shortcode( 'year', 'sb_shortcode_year' );



// This is the end of file; no closing PHP tag