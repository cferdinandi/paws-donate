<?php

/**
 * Theme Options v1.1.0
 * Adjust theme settings from the admin dashboard.
 * Find and replace `keel` with your own namepspacing.
 *
 * Created by Michael Fields.
 * https://gist.github.com/mfields/4678999
 *
 * Forked by Chris Ferdinandi
 * http://gomakethings.com
 *
 * Free to use under the MIT License.
 * http://gomakethings.com/mit/
 */


	/**
	 * Theme Options Fields
	 * Each option field requires its own uniquely named function. Select options and radio buttons also require an additional uniquely named function with an array of option choices.
	 */

	function keel_settings_field_home_url() {
		$options = keel_get_theme_options();
		?>
		<input type="text" class="large-text" name="keel_theme_options[home_url]" id="home_url" value="<?php echo stripslashes( esc_attr( $options['home_url'] ) ); ?>">
		<label class="description" for="home_url"><?php _e( 'Site home url', 'keel' ); ?></label>
		<?php
	}

	function keel_settings_field_rss_url() {
		$options = keel_get_theme_options();
		?>
		<input type="text" class="large-text" name="keel_theme_options[rss_url]" id="rss_url" value="<?php echo stripslashes( esc_attr( $options['rss_url'] ) ); ?>">
		<label class="description" for="rss_url"><?php _e( 'RSS url', 'keel' ); ?></label>
		<?php
	}

	function keel_settings_field_404_url() {
		$options = keel_get_theme_options();
		?>
		<input type="text" class="large-text" name="keel_theme_options[404_url]" id="404_url" value="<?php echo stripslashes( esc_attr( $options['404_url'] ) ); ?>">
		<label class="description" for="404_url"><?php _e( '404 redirect url', 'keel' ); ?></label>
		<?php
	}


	/**
	 * Theme Option Defaults & Sanitization
	 * Each option field requires a default value under keel_get_theme_options(), and an if statement under keel_theme_options_validate();
	 */

	// Get the current options from the database.
	// If none are specified, use these defaults.
	function keel_get_theme_options() {
		$saved = (array) get_option( 'keel_theme_options' );
		$defaults = array(
			'home_url' => site_url(),
			'rss_url' => site_url(),
			'404_url' => '',
		);

		$defaults = apply_filters( 'keel_default_theme_options', $defaults );

		$options = wp_parse_args( $saved, $defaults );
		$options = array_intersect_key( $options, $defaults );

		return $options;
	}

	// Sanitize and validate updated theme options
	function keel_theme_options_validate( $input ) {
		$output = array();

		if ( isset( $input['home_url'] ) && ! empty( $input['home_url'] ) )
			$output['home_url'] = wp_filter_nohtml_kses( $input['home_url'] );

		if ( isset( $input['rss_url'] ) && ! empty( $input['rss_url'] ) )
			$output['rss_url'] = wp_filter_nohtml_kses( $input['rss_url'] );

		if ( isset( $input['404_url'] ) && ! empty( $input['404_url'] ) )
			$output['404_url'] = wp_filter_nohtml_kses( $input['404_url'] );

		return apply_filters( 'keel_theme_options_validate', $output, $input );
	}



	/**
	 * Theme Options Menu
	 * Each option field requires its own add_settings_field function.
	 */

	// Create theme options menu
	// The content that's rendered on the menu page.
	function keel_theme_options_render_page() {
		?>
		<div class="wrap">
			<h2><?php _e( 'Theme Options', 'keel' ); ?></h2>
			<?php settings_errors(); ?>

			<form method="post" action="options.php">
				<?php
					settings_fields( 'keel_options' );
					do_settings_sections( 'keel_theme_options' );
					submit_button();
				?>
			</form>
		</div>
		<?php
	}

	// Register the theme options page and its fields
	function keel_theme_options_init() {

		// Register a setting and its sanitization callback
		// register_setting( $option_group, $option_name, $sanitize_callback );
		// $option_group - A settings group name.
		// $option_name - The name of an option to sanitize and save.
		// $sanitize_callback - A callback function that sanitizes the option's value.
		register_setting( 'keel_options', 'keel_theme_options', 'keel_theme_options_validate' );


		// Register our settings field group
		// add_settings_section( $id, $title, $callback, $page );
		// $id - Unique identifier for the settings section
		// $title - Section title
		// $callback - // Section callback (we don't want anything)
		// $page - // Menu slug, used to uniquely identify the page. See keel_theme_options_add_page().
		add_settings_section( 'general', __( '', 'keel' ),  '__return_false', 'keel_theme_options' );


		// Register our individual settings fields
		// add_settings_field( $id, $title, $callback, $page, $section );
		// $id - Unique identifier for the field.
		// $title - Setting field title.
		// $callback - Function that creates the field (from the Theme Option Fields section).
		// $page - The menu page on which to display this field.
		// $section - The section of the settings page in which to show the field.
		add_settings_field( 'home_url', __( 'Homepage URL', 'keel' ), 'keel_settings_field_home_url', 'keel_theme_options', 'general' );
		add_settings_field( 'rss_url', __( 'RSS Feed URL', 'keel' ), 'keel_settings_field_rss_url', 'keel_theme_options', 'general' );
		add_settings_field( '404_url', __( '404 Page URL', 'keel' ), 'keel_settings_field_404_url', 'keel_theme_options', 'general' );
	}
	add_action( 'admin_init', 'keel_theme_options_init' );

	// Add the theme options page to the admin menu
	// Use add_theme_page() to add under Appearance tab (default).
	// Use add_menu_page() to add as it's own tab.
	// Use add_submenu_page() to add to another tab.
	function keel_theme_options_add_page() {

		// add_theme_page( $page_title, $menu_title, $capability, $menu_slug, $function );
		// add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function );
		// add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function );
		// $page_title - Name of page
		// $menu_title - Label in menu
		// $capability - Capability required
		// $menu_slug - Used to uniquely identify the page
		// $function - Function that renders the options page
		$theme_page = add_theme_page( __( 'Theme Options', 'keel' ), __( 'Theme Options', 'keel' ), 'edit_theme_options', 'keel_theme_options', 'keel_theme_options_render_page' );

		// $theme_page = add_menu_page( __( 'Theme Options', 'keel' ), __( 'Theme Options', 'keel' ), 'edit_theme_options', 'keel_theme_options', 'keel_theme_options_render_page' );
		// $theme_page = add_submenu_page( 'tools.php', __( 'Theme Options', 'keel' ), __( 'Theme Options', 'keel' ), 'edit_theme_options', 'keel_theme_options', 'keel_theme_options_render_page' );
	}
	add_action( 'admin_menu', 'keel_theme_options_add_page' );



	// Restrict access to the theme options page to admins
	function keel_option_page_capability( $capability ) {
		return 'edit_theme_options';
	}
	add_filter( 'option_page_capability_keel_options', 'keel_option_page_capability' );
