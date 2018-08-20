<?php

/**
 * header.php
 * Template for header content.
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?> <?php echo post_class(); ?>>

	<head>
		<meta charset="<?php bloginfo('charset'); ?>">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title><?php wp_title( '|', true, 'right' ); ?></title>
		<?php if ( is_home () ) : ?><meta name="description" content="<?php bloginfo('description'); ?>"><?php endif; ?>

		<!-- Mobile Screen Resizing -->
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<?php wp_head(); ?>

	</head>

	<?php
		// Get page layout options
		global $post;
		$page_navs = get_post_meta( $post->ID, 'keel_page_navs', true );
	?>

	<body <?php body_class(); ?>>

		<?php echo file_get_contents(realpath(ABSPATH . DIRECTORY_SEPARATOR . '..') . '/partials/nav.html'); ?>

		<main class="tabindex" id="main" tabindex="-1">

			<div class="container">
