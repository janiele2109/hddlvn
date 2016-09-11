<?php
/**
 *
 * @package Social Share Buttons
 * @author  Victor Freitas
 * @subpackage Options Admin Page
 * @since 1.0.3
 */

namespace JM\Share_Buttons;

// Avoid that files are directly loaded
if ( ! function_exists( 'add_action' ) )
	exit(0);

class Options_Controller
{
	/**
	 * Adds needed actions initialize class
	 *
	 * @since 1.0
	 * @return void
	 */
	public function __construct()
	{
		add_action( 'admin_init', array( &$this, 'register_options_settings' ) );
		add_action( 'admin_init', array( &$this, 'register_options_social_media' ) );
		add_action( 'admin_init', array( &$this, 'register_options_extra_settings' ) );
	}

	/**
	 * Register options plugin
	 *
	 * @since 1.0
	 * @param Null
	 * @return void
	 */
	public function register_options_settings()
	{
		$prefix_underscore = Setting::PREFIX_UNDERSCORE;
		$option_name       = "{$prefix_underscore}_settings";
		$option_group      = "{$option_name}_group";

		register_setting( $option_group, $option_name );

		$value = array(
			'single'  => 'on',
			'before'  => 'on',
			'after'   => 'off',
			'pages'   => 'off',
			'home'    => 'off',
			'class'   => '',
			'layout'  => 'default',
		);
		$value = apply_filters( App::SLUG . 'options-settings', $value );

		add_option( $option_name, $value );
	}

	/**
	 * Register options social media plugin
	 *
	 * @since 1.0
	 * @param Null
	 * @return void
	 */
	public function register_options_social_media()
	{
		$prefix_underscore = Setting::PREFIX_UNDERSCORE;
		$option_group      = "{$prefix_underscore}_settings_group";
		$option_name       = "{$prefix_underscore}_social_media";

		register_setting( $option_group, $option_name );

		$value = array(
			'facebook'  => 'facebook',
			'twitter'   => 'twitter',
			'google'    => 'google',
			'whatsapp'  => 'whatsapp',
			'pinterest' => 'pinterest',
			'linkedin'  => 'linkedin',
			'tumblr'    => 'tumblr',
			'email'     => 'email',
			'printer'   => 'printer',
		);
		$value = apply_filters( App::SLUG . 'options-social-media', $value );

		add_option( $option_name, $value );
	}

	/**
	 * Register options plugin extra configurations
	 *
	 * @since 1.1
	 * @param Null
	 * @return void
	 */
	public function register_options_extra_settings()
	{
		$prefix_underscore = Setting::PREFIX_UNDERSCORE;
		$option_name       = "{$prefix_underscore}_extra_settings";
		$option_group      = "{$option_name}_group";

		register_setting( $option_group, $option_name );

		$value = array(
			'disable_css'       => 'off',
			'disable_js'        => 'off',
			'twitter_username'  => '',
			'bitly_token'       => '',
			'remove_count'      => 0,
			'remove_inside'     => 0,
			'tracking'          => '',
			'report_cache_time' => 10,
		);
		$value = apply_filters( App::SLUG . 'options-extra-settings', $value );

		add_option( $option_name, $value );
	}
}
