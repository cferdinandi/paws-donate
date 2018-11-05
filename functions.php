<?php

/**
 * functions.php
 * For modifying and expanding core WordPress functionality.
 */


	// @todo disable RSS



	/**
	 * Deregister and Dequeue Give Scripts
	 */
	function keel_dequeue_styles() {
		wp_deregister_style('give-styles');
		wp_dequeue_style('give-styles');
	}
	// add_action( 'wp_print_styles', 'keel_dequeue_styles', 100 );


	/**
	 * Load inline header content
	 */
	function keel_load_inline_header() {
		echo file_get_contents(realpath(ABSPATH . DIRECTORY_SEPARATOR . '..') . '/partials/header.html');
		if (strtolower(get_bloginfo('description')) === 'store') : ?>
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
		<?php endif;
	}
	add_action('wp_head', 'keel_load_inline_header', 30);



	/**
	 * Load inline footer content
	 */
	function keel_load_inline_footer() {
		echo file_get_contents(realpath(ABSPATH . DIRECTORY_SEPARATOR . '..') . '/partials/footer.html');
	}
	add_action('wp_footer', 'keel_load_inline_footer', 30);



	/**
	 * Customize the `wp_title` method
	 * @param  string $title The page title
	 * @param  string $sep   The separator between title and description
	 * @return string        The new page title
	 */
	function keel_pretty_wp_title( $title, $sep ) {

		global $paged, $page;

		if ( is_feed() )
			return $title;

		if ( is_front_page() ) {
		 	$title = get_bloginfo('description') . ' ' . $sep . ' ';
		}

		// Add the site name
		$title .= get_bloginfo( 'name' );

		// Add a page number if necessary.
		if ( $paged >= 2 || $page >= 2 )
			$title = "$title $sep " . sprintf( __( 'Page %s', 'keel' ), max( $paged, $page ) );

		return $title;
	}
	add_filter( 'wp_title', 'keel_pretty_wp_title', 10, 2 );



	/**
	 * Declare WooCommerce support
	 */
	function keel_woocommerce_support() {
		if (strtolower(get_bloginfo('description')) !== 'store') return;
	    add_theme_support( 'woocommerce' );
	}
	add_action( 'after_setup_theme', 'keel_woocommerce_support' );



	/**
	 * Sets max allowed content width
	 * Deliberately large to prevent pixelation from content stretching
	 * @link http://codex.wordpress.org/Content_Width
	 */
	if ( !isset( $content_width ) ) {
		$content_width = 720;
	}



	/**
	 * Unlink images by default
	 */
	function keel_update_image_default_link_type() {
		update_option( 'image_default_link_type', 'none' );
	}
	add_action( 'admin_init', 'keel_update_image_default_link_type' );



	/**
	 * Check if more than one page of content exists
	 * @return boolean True if content is paginated
	 */
	function keel_is_paginated() {
		global $wp_query;

		if ( $wp_query->max_num_pages > 1 ) {
			return true;
		} else {
			return false;
		}
	}



	/**
	 * Check if post is the last in a set
	 * @param  object  $wp_query WPQuery object
	 * @return boolean           True if is last post
	 */
	function keel_is_last_post($wp_query) {
		$post_current = $wp_query->current_post + 1;
		$post_count = $wp_query->post_count;
		if ( $post_current == $post_count ) {
			return true;
		} else {
			return false;
		}
	}



	/**
	 * Print a pre formatted array to the browser - useful for debugging
	 * @param array $array Array to print
	 * @author 	Keir Whitaker
	 * @link https://github.com/viewportindustries/starkers/
	 */
	function keel_print_a( $a ) {
		print( '<pre>' );
		print_r( $a );
		print( '</pre>' );
	}



	/**
	 * Disable the admin bar for all users
	 */
	function keel_disable_admin_bar() {
		if ( current_user_can( 'edit_themes' ) ) return;
		show_admin_bar( false );
	}
	add_filter( 'init' , 'keel_disable_admin_bar');



	/**
	 * Includes
	 */
	// require_once( dirname( __FILE__) . '/includes/theme-options.php' ); // Theme options
	// require_once( dirname( __FILE__) . '/includes/edd-overrides.php' ); // Override default Easy Digital Downloads behaviors