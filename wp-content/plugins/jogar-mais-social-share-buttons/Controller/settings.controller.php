<?php
/**
 *
 * @package Social Share Buttons
 * @author  Victor Freitas
 * @subpackage Settings Controller
 * @version 2.0.0
 */

namespace JM\Share_Buttons;

// Avoid that files are directly loaded
if ( ! function_exists( 'add_action' ) )
	exit(0);

//View
App::uses( 'settings', 'View' );
App::uses( 'settings-extra', 'View' );
App::uses( 'settings-faq', 'View' );

//Model
App::uses( 'setting', 'Model' );

class Settings_Controller
{
	/**
	* Initialize the plugin by setting localization, filters, and administration functions.
	*
	* @since 1.2
	*/
	public function __construct()
	{
		add_filter( 'plugin_action_links_' . Utils::base_name(), array( &$this, 'plugin_link' ) );
		add_action( 'wp_enqueue_scripts', array( &$this, 'scripts' ) );
		add_action( 'admin_enqueue_scripts', array( &$this, 'admin_scripts' ) );
		add_action( 'admin_menu', array( &$this, 'menu_page' ) );
		add_action( 'admin_notices', array( &$this, 'admin_notice' ) );
	}

	public function admin_notice()
	{
		Settings_View::admin_notice();
	}

/*
<a class="install-now button" data-slug="buddypress" href="http://localhost/wordpress/wp-admin/update.php?action=install-plugin&amp;plugin=buddypress&amp;_wpnonce=0da6f86003" aria-label="Install BuddyPress 2.5.1 now" data-name="BuddyPress 2.5.1">Install Now</a>
 */

	/**
	 * Adds links page plugin action
	 *
	 * @since 1.0
	 * @param Array $links
	 * @return Array links action plugins
	 */
	public function plugin_link( $links )
	{
		$page_link     = get_admin_url( null,  'admin.php?page=' . App::SLUG );
		$settings      = __( 'Settings', App::TEXTDOMAIN );
		$settings_link = "<a href=\"{$page_link}\">{$settings}</a>";
		array_unshift( $links, $settings_link );

		return $links;
	}

	/**
	 * Enqueue scripts and styles
	 *
	 * @since 1.0
	 * @param Null
	 * @return Void
	 */
	public function scripts()
	{
		if ( 'on' !== Utils::option( 'disable_js' ) ) :
			wp_enqueue_script(
				Setting::PREFIX . '-scripts',
				Utils::plugin_url( 'javascripts/built.front.js' ),
				array( 'jquery' ),
				App::VERSION,
				true
			);

			wp_localize_script(
				Setting::PREFIX . '-scripts',
				'SSBGlobalVars',
				array(
					'ajaxUrl' => admin_url( 'admin-ajax.php' ),
				)
			);
		endif;

		if ( 'on' !== Utils::option( 'disable_css' ) ) :
			wp_enqueue_style(
				Setting::PREFIX . '-style',
				Utils::plugin_url( 'stylesheets/style.css' ),
				array(),
				App::VERSION
			);
		endif;
	}

	/**
	 * Enqueue scripts and stylesheets on admin
	 *
	 * @since 1.2
	 * @param Null
	 * @return Void
	 */
	public function admin_scripts()
	{
		$page_settings = ( App::SLUG == Utils::get( 'page' ) );
		$deps          = ( $page_settings ) ? array( Setting::PREFIX . '-style' ) : array();

		wp_enqueue_script(
			Setting::PREFIX . '-admin-scripts',
			Utils::plugin_url( 'javascripts/built.admin.js' ),
			array( 'jquery', 'jquery-ui-sortable' ),
			App::VERSION,
			true
		);

		wp_localize_script(
			Setting::PREFIX . '-admin-scripts',
			'SSBGlobalVars',
			array(
				'ajaxUrl' => admin_url( 'admin-ajax.php' ),
				'WPLANG'  => get_locale(),
			)
		);

		wp_enqueue_style(
			Setting::PREFIX . '-admin-style',
			Utils::plugin_url( 'stylesheets/admin.css' ),
			$deps,
			App::VERSION
		);

		if ( $page_settings ) :
			wp_enqueue_style(
				Setting::PREFIX . '-style',
				Utils::plugin_url( 'stylesheets/style.css' ),
				array(),
				App::VERSION
			);
		endif;
	}

	/**
	 * Register menu page and submenus
	 *
	 * @since 1.0
	 * @param Null
	 * @return void
	 */
	public function menu_page()
	{
		add_menu_page(
			__( 'Social Share Buttons', App::TEXTDOMAIN ),
			__( 'Share Buttons', App::TEXTDOMAIN ),
			'manage_options',
			App::SLUG,
			array( 'JM\Share_Buttons\Settings_View', 'render_settings_page' ),
			'dashicons-share'
	  	);

	  	add_submenu_page(
	  		App::SLUG,
	  		__( 'Extra Settings | Social Share Buttons', App::TEXTDOMAIN ),
	  		__( 'Extra Settings', App::TEXTDOMAIN ),
	  		'manage_options',
	  		App::SLUG . '-extra-settings',
	  		array( 'JM\Share_Buttons\Settings_Extra_View', 'render_settings_extra' )
	  	);

	  	add_submenu_page(
	  		App::SLUG,
	  		__( 'Use options | Social Share Buttons', App::TEXTDOMAIN ),
	  		__( 'Use options', App::TEXTDOMAIN ),
	  		'manage_options',
	  		App::SLUG . '-faq',
	  		array( 'JM\Share_Buttons\Settings_Faq_View', 'render_page_faq' )
	  	);
	}
}
