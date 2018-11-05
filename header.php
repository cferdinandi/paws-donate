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

	<body <?php body_class($class = 'pne-' . strtolower(get_bloginfo('description'))); ?>>

		<?php echo file_get_contents(realpath(ABSPATH . DIRECTORY_SEPARATOR . '..') . '/partials/nav.html'); ?>

		<?php
			/**
			 * If a store, add cart icon
			 */
			if (strtolower(get_bloginfo('description')) === 'store') :
		?>
			<?php
				// Get number of items in cart
				$cart_count = class_exists( 'WooCommerce' ) ? WC()->cart->get_cart_contents_count() : 0;
			?>
			<div class="bg-muted padding-top-small padding-bottom-small">
				<div class="container container-large nav-menu-subnav text-right" id="nav-menu-subnav">
					<a class="float-right" href="<?php echo wc_get_cart_url(); ?>">
						<svg xmlns="http://www.w3.org/2000/svg" style="height:1em;width:1em;" viewBox="0 0 17 17"><title>Your Cart</title><path fill="currentColor" d="M6.375 15.406c0 .88-.714 1.594-1.594 1.594s-1.593-.714-1.593-1.594c0-.88.714-1.594 1.594-1.594s1.595.714 1.595 1.594zM17 15.406c0 .88-.714 1.594-1.594 1.594s-1.594-.714-1.594-1.594c0-.88.714-1.594 1.594-1.594S17 14.526 17 15.406zM17 8.5V2.125H4.25c0-.587-.476-1.063-1.063-1.063H0v1.063h2.124l.798 6.84c-.486.39-.798.99-.798 1.66 0 1.174.95 2.125 2.125 2.125H17v-1.063H4.25c-.588 0-1.064-.476-1.064-1.063v-.01l13.812-2.115z"/></svg>
						Cart (<?php echo $cart_count; ?>)
					</a>
				</div>
			</div>
		<?php endif; ?>

		<main class="tabindex" id="main" tabindex="-1">

			<div class="container">
