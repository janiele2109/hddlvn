<?php
/**
 *
 * @package Social Share Buttons
 * @subpackage Functions
 * @author  Victor Freitas
 * @version 2.1.1
 */

namespace JM\Share_Buttons;

// Avoid that files are directly loaded
if ( ! function_exists( 'add_action' ) )
	exit(0);

//Utils
App::uses( 'utils', 'Helper' );

//Controller
App::uses( 'ajax', 'Controller' );
App::uses( 'shares', 'Controller' );
App::uses( 'options', 'Controller' );
App::uses( 'sharing-reports', 'Controller' );
App::uses( 'settings', 'Controller' );

class Core
{
	/**
	 * Intance class share report controller
	 *
	 * @since 1.0
	 * @var Object
	 */
	private static $report;

	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @since 1.2
	 */
	public function __construct()
	{
		add_action( 'plugins_loaded', array( __CLASS__, 'sharing_report_update_db_check' ) );
		add_action( 'plugins_loaded', array( __CLASS__, 'load_text_domain' ) );
		add_action( 'admin_init', array( __CLASS__, 'settings_update' ) );
		static::_register_actions();
		static::_instantiate_controllers();
	}

	/**
	 * Delete transient in update lang
	 *
	 * @since 1.1
	 * @param Null
	 * @return Void
	 */
	public static function settings_update()
	{
		static::_deactivate_plugin();

		if ( isset( $_POST['WPLANG'] ) )
			delete_transient( Setting::TRANSIENT_SHARE_OBJECTS );
	}

	/**
	 * Registers actions activation, deactivation and uninstall plugin
	 *
	 * @since 1.0
	 * @param Null
	 * @return Void
	 */
	private static function _register_actions()
	{
		register_activation_hook( App::FILE, array( __CLASS__, 'activate' ) );
		register_deactivation_hook( App::FILE, array( __CLASS__, 'deactivate' ) );
		register_uninstall_hook( App::FILE, array( __CLASS__, 'uninstall' ) );
	}

	/**
	 * Instantiate controllers
	 *
	 * @since 1.0
	 * @param Null
	 * @return Void
	 */
	private static function _instantiate_controllers()
	{
		$settings       = new Settings_Controller();
		$share          = new Shares_Controller();
		$option         = new Options_Controller();
		$ajax           = new Ajax_Controller();
		static::$report = new Sharing_Reports_Controller();
	}

	/**
	 * Generate object all social icons
	 *
	 * @since 2.3
	 * @param String $title
	 * @param String $url
	 * @param String $tracking
	 * @param String $thumbnail
	 * @param String $body_mail
	 * @param String $twitter_username
	 * @return Object all data links
	 */
	private static function _set_elements( $title, $url, $tracking, $thumbnail, $body_mail, $twitter_username )
	{
		$action         = 'data-action="open-popup"';
		$url            = static::_generate_short_url( $url, $tracking );
		$prefix         = Setting::PREFIX;
		$item           = "{$prefix}-item";
		$class_button   = "{$prefix}-button";
		$twitter_text_a = apply_filters( App::SLUG . '-twitter-after', __( 'I just saw', App::TEXTDOMAIN ) );
		$twitter_text_b = apply_filters( App::SLUG . '-twitter-before', __( 'Click to see also', App::TEXTDOMAIN ) );
		$caracter       = rawurlencode( apply_filters( App::SLUG . '-caracter', html_entity_decode( ' &#x261B; ' ) ) );
		$share_items    = array(
			'facebook'  => array(
				'name'        => 'Facebook',
				'element'     => 'facebook',
				'link'        => "https://www.facebook.com/sharer/sharer.php?u={$url}",
				'title'       => __( 'Share on Facebook', App::TEXTDOMAIN ),
				'class'       => "{$prefix}-facebook",
				'class_item'  => $item,
				'class_link'  => $class_button,
				'class_icon'  => "{$prefix}-icon-facebook",
 				'popup'       => $action,
				'inside'      => __( 'Share', App::TEXTDOMAIN ),
				'has_counter' => true,
			),
			'twitter'   => array(
				'name'        => 'Twitter',
				'element'     => 'twitter',
				'link'        => "https://twitter.com/share?url={$url}&text={$twitter_text_a}%20{$title}%20-%20{$twitter_text_b}{$caracter}&via={$twitter_username}",
				'title'       => __( 'Tweet', App::TEXTDOMAIN ),
				'class'       => "{$prefix}-twitter",
				'class_item'  => $item,
				'class_link'  => $class_button,
				'class_icon'  => "{$prefix}-icon-twitter",
				'popup'       => $action,
				'inside'      => __( 'Tweet', App::TEXTDOMAIN ),
				'has_counter' => false,
			),
			'google'    => array(
				'name'        => 'Google Plus',
				'element'     => 'google-plus',
				'link'        => "https://plus.google.com/share?url={$url}",
				'title'       => __( 'Share on Google+', App::TEXTDOMAIN ),
				'class'       => "{$prefix}-google-plus",
				'class_item'  => $item,
				'class_link'  => $class_button,
				'class_icon'  => "{$prefix}-icon-google-plus",
				'popup'       => $action,
				'inside'      => __( 'Share', App::TEXTDOMAIN ),
				'has_counter' => true,
			),
			'whatsapp'  => array(
				'name'        => 'WhatsApp',
				'element'     => 'whatsapp',
				'link'        => "whatsapp://send?text={$title}{$caracter}{$url}",
				'title'       => __( 'Share on WhatsApp', App::TEXTDOMAIN ),
				'class'       => "{$prefix}-whatsapp",
				'class_item'  => $item,
				'class_link'  => $class_button,
				'class_icon'  => "{$prefix}-icon-whatsapp",
				'popup'       => $action,
				'inside'      => __( 'Share', App::TEXTDOMAIN ),
				'has_counter' => false,
			),
			'pinterest' => array(
				'name'        => 'Pinterest',
				'element'     => 'pinterest',
				'link'        => "https://pinterest.com/pin/create/button/?url={$url}&media={$thumbnail}&description={$title}",
				'title'       => __( 'Share on Pinterest', App::TEXTDOMAIN ),
				'class'       => "{$prefix}-pinterest",
				'class_item'  => $item,
				'class_link'  => $class_button,
				'class_icon'  => "{$prefix}-icon-pinterest",
				'popup'       => $action,
				'inside'      => __( 'Share', App::TEXTDOMAIN ),
				'has_counter' => true,
			),
			'linkedin'  => array(
				'name'        => 'Linkedin',
				'element'     => 'linkedin',
				'link'        => "https://www.linkedin.com/shareArticle?mini=true&url={$url}&title={$title}",
				'title'       => __( 'Share on Linkedin', App::TEXTDOMAIN ),
				'class'       => "{$prefix}-linkedin",
				'class_item'  => $item,
				'class_link'  => $class_button,
				'class_icon'  => "{$prefix}-icon-linkedin",
				'popup'       => $action,
				'inside'      => __( 'Share', App::TEXTDOMAIN ),
				'has_counter' => true,
			),
			'tumblr'    => array(
				'name'        => 'Tumblr',
				'element'     => 'tumblr',
				'link'        => 'http://www.tumblr.com/share',
				'title'       => __( 'Share on Tumblr', App::TEXTDOMAIN ),
				'class'       => "{$prefix}-tumblr",
				'class_item'  => $item,
				'class_link'  => $class_button,
				'class_icon'  => "{$prefix}-icon-tumblr",
				'popup'       => $action,
				'inside'      => __( 'Share', App::TEXTDOMAIN ),
				'has_counter' => false,
			),
			'email'     => array(
				'name'        => 'Email',
				'element'     => 'email',
				'link'        => "mailto:?subject={$title}&body={$url}{$body_mail}",
				'title'       => __( 'Send by email', App::TEXTDOMAIN ),
				'class'       => "{$prefix}-email",
				'class_item'  => $item,
				'class_link'  => $class_button,
				'class_icon'  => "{$prefix}-icon-email",
				'popup'       => $action,
				'inside'      => 'Email',
				'has_counter' => false,
			),
			'printer'   => array(
				'name'        => 'PrintFriendly',
				'element'     => 'printer',
				'link'        => "http://www.printfriendly.com/print?url={$url}&partner=whatsapp",
				'title'       => __( 'Print via PrintFriendly', App::TEXTDOMAIN ),
				'class'       => "{$prefix}-printer",
				'class_item'  => $item,
				'class_link'  => $class_button,
				'class_icon'  => "{$prefix}-icon-printer",
				'popup'       => $action,
				'inside'      => __( 'Print', App::TEXTDOMAIN ),
				'has_counter' => false,
			),
		);

		$share_items = static::_ksort( $share_items );

		return Utils::array_to_object( $share_items );
	}

	private static function _ksort( $elements )
	{
		$order = Utils::option( 'order', false );
		$sort  = array();

		if ( $order ) :
			$order = json_decode( $order );

			foreach ( $order as $key => $item ) {
				$sort[$item] = apply_filters( App::SLUG . "-{$item}-items", $elements[$item] );
			}
			$elements = $sort;
		endif;

		return apply_filters( App::SLUG . '-elements-args', $elements );
	}

	/**
	 * Encode all items from data services
	 *
	 * @since 1.2
	 * @param Null
	 * @return Object
	 */
	private static function _get_elements_encode()
	{
		$arguments = self::_get_arguments();
		$tracking  = Utils::option( 'tracking' );
		$tracking  = Utils::html_decode( $tracking );
		$elements  = self::_set_elements(
			rawurlencode( $arguments['title'] ),
			rawurlencode( $arguments['link'] ),
			rawurlencode( $tracking ),
			rawurlencode( $arguments['thumbnail'] ),
			rawurlencode( $arguments['body_mail'] ),
			Utils::option( 'twitter_username' )
		);

		return apply_filters( App::SLUG . 'elements-econded', $elements );
	}

	/**
	 * Get arguments for social url elements
	 *
	 * @since 1.0
	 * @param Null
	 * @return Array
	 */
	private static function _get_arguments()
	{
		$title     = Utils::get_title();
		$body_mail = Utils::body_mail();
		$arguments = array(
			'title'     => "\"{$title} \"",
			'link'      => Utils::get_permalink(),
			'thumbnail' => Utils::get_image(),
			'body_mail' => "\n\n{$title}\n\n{$body_mail}\n",
		);

		return apply_filters( App::SLUG . 'arguments', $arguments );
	}

	/**
	 * Generate short url by bitly
	 *
	 * @since 1.0
	 * @param string $url
	 * @param string $tracking
	 * @return String
	 */
	private static function _generate_short_url( $url, $tracking )
	{
		$bitly_token = Utils::option( 'bitly_token', false );

		if ( ! $bitly_token )
			return static::_url_clean( "{$url}{$tracking}" );

		return Utils::bitly_short_url_cache( $bitly_token, "{$url}{$tracking}" );
	}

	/**
	 * Return clean url and add implements filter
	 *
	 * @since 1.0
	 * @param string $url
	 * @return String
	 */
	private static function _url_clean( $url )
	{
		$name = App::SLUG . '-url-share';
		return apply_filters( $name, $url );
	}

	/**
	 * Implements [] to facilitate replace shorturl bitly
	 *
	 * @since 1.0
	 * @param string $url
	 * @return String
	 */
	private static function _url_facilitate_replace( $url )
	{
		$name = App::SLUG . '-url-share';
		return apply_filters( $name, "[{$url}]" );
	}

	/**
	 * Encode all items from data services
	 *
	 * @since 1.2
	 * @param Null
	 * @return Object
	 */
	public static function social_media_objects()
	{
		return self::_get_elements_encode();
	}

	/**
	 * Register Activation Hook
	 *
	 * @since 1.1
	 * @param Null
	 * @return Void
	 */
	public static function activate()
	{
		self::$report->create_table();
	}

	/**
	 * Register Deactivation Hook
	 *
	 * @since 1.0
	 * @param Null
	 * @return Void
	 */
	public static function deactivate()
	{

	}

	/**
	 * Register Uninstall Hook
	 *
	 * @since 1.3
	 * @param Null
	 * @return Void
	 */
	public static function uninstall()
	{
		$prefix = Setting::PREFIX_UNDERSCORE;
		static::_delete_options( $prefix );
		static::_delete_site_options( $prefix );
		static::_delete_transients();
	}

	private static function _delete_options( $prefix )
	{
		// Options
		delete_option( $prefix );
		delete_option( "{$prefix}_settings" );
		delete_option( "{$prefix}_style_settings" );
	}

	/**
	 * Delete site option on plugin uninstallation
	 *
	 * @since 1.0
	 * @param Null
	 * @return Void
	 */
	private static function _delete_site_options( $prefix )
	{
		//Options multisite
		if ( is_multisite() ) :
			delete_site_option( $prefix );
			delete_site_option( "{$prefix}_settings" );
			delete_site_option( "{$prefix}_style_settings" );
		endif;
	}

	/**
	 * Delete transient on plugin uninstallation
	 *
	 * @since 1.0
	 * @param Null
	 * @return Void
	 */
	private static function _delete_transients()
	{
		// Transients
		delete_transient( Setting::TRANSIENT );
		delete_transient( Setting::TRANSIENT_SELECT_COUNT );
		delete_transient( Setting::TRANSIENT_GOOGLE_PLUS );
	}

	/**
	 * Rename Table
	 *
	 * @since 1.0
	 * @param Null
	 * @return Void
	 */
	private static function _rename_table()
	{
		global $wpdb;

		if ( Utils::table_exists( 'sharing_report' ) ) :
			$table = $wpdb->prefix . Setting::TABLE_NAME;
			$sql   = "RENAME TABLE `{$wpdb->prefix}sharing_report` TO `{$table}`";

			$wpdb->query( $sql );
		endif;
	}

	/**
	 * Verify database version and update database
	 *
	 * @since 1.0
	 * @param Null
	 * @return Void
	 */
	public static function sharing_report_update_db_check()
	{
		$db_version = get_site_option( Setting::DB_VERSION_OPTION_NAME );

	    if ( $db_version !== Setting::DB_VERSION ) :
	    	static::_rename_table();
	        self::activate();
	    endif;
	}

	private static function _deactivate_plugin()
	{
		if ( ! class_exists( 'WPUSB_App' ) )
			return;

		$plugin = plugin_basename( App::FILE );

		deactivate_plugins( $plugin, true );
		wp_redirect( admin_url( 'plugins.php' ), 301 );
		exit(1);
	}

	/**
	 * Initialize text domain hook, plugin translate
	 *
	 * @since 1.0
	 * @param Null
	 * @return Void
	 */
	public static function load_text_domain()
	{
		$plugin_dir = basename( dirname( App::FILE ) );
		load_plugin_textdomain( App::TEXTDOMAIN, false, "{$plugin_dir}/languages/" );
	}
}