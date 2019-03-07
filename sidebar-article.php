<?php
/**
 * Semne Bune 2018 theme - the sidebar to display on article pages
 *
 * @package semne-bune-2018
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 */

$sidebar_classes = apply_filters('islemag_sidebar_classes', array('col-md-3', 'sidebar', 'islemag-content-right')); ?>

<aside
	<?php
	if (! empty($sidebar_classes)) {
		echo 'class="'.implode(' ', $sidebar_classes).'"';
	}
	?>
		role="complementary">
	<?php

	if (is_active_sidebar('semnebune-2018-article-sidebar')) {
		dynamic_sidebar('semnebune-2018-article-sidebar');
	} else {
		dynamic_sidebar('islemag-sidebar');
	}
	?>
</aside><!-- #secondary -->
