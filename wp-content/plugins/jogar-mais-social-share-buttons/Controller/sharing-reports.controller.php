<?php
/**
 *
 * @package Social Share Buttons
 * @author  Victor Freitas
 * @subpackage Controller Sharing Report
 * @version 2.3.0
 */

namespace JM\Share_Buttons;

// Avoid that files are directly loaded
if ( ! function_exists( 'add_action' ) )
	exit(0);

//View
App::uses( 'sharing-report', 'View' );

if ( ! class_exists( 'WP_List_Table' ) )
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );

if ( ! class_exists( 'WP_Screen' ) )
	Utils::include_file_screen();

if ( ! class_exists( 'Walker_Category_Checklist' ) )
	require_once(ABSPATH . 'wp-admin/includes/template.php' );

class Sharing_Reports_Controller extends \WP_List_Table
{
	/**
	 * Number for posts per page
	 *
	 * @since 1.1
	 * @var Integer
	 */
	const POSTS_PER_PAGE = 15;

	/**
	 * Number for cache time
	 *
	 * @since 1.2
	 * @var Integer
	 */
	private $cache_time;

	/**
	 * Search in list table
	 *
	 * @since 1.2
	 * @var string
	 */
	private $search;

	public function __construct()
	{
		add_action( 'admin_menu', array( &$this, 'menu' ) );

		$this->cache_time = Utils::option( 'report_cache_time', 10, 'intval' );
		$this->search     = Utils::get( 's', false );

		parent::__construct(
			array(
				'singular' => 'social-share-report',
				'plural'   => 'social-sharing-reports',
				'screen'   => 'interval-list',
				'ajax'     => false,
			)
		);
	}

	/**
	 * Search in database results relative share posts
	 *
	 * @since 1.4
	 * @global $wpdb
	 * @param Int $page
	 * @param String $orderby
	 * @param String $order
	 * @return Object
	 */
	private function _get_sharing_report( $posts_per_page, $current_page, $orderby, $order )
	{
		global $wpdb;

		$offset = ( ( $current_page - 1 ) * self::POSTS_PER_PAGE );
		$cache  = get_transient( Setting::TRANSIENT );
		$table  = $wpdb->prefix . Setting::TABLE_NAME;
		$where  = ( $this->search ) ? "WHERE `post_title` LIKE '%%{$this->search}%%'" : null;

		if ( ! Utils::table_exists( Setting::TABLE_NAME ) )
			return;

		if ( ! $this->search && false !== $cache && isset( $cache[$current_page][$orderby][$order] ) )
			return $cache[$current_page][$orderby][$order];

		$query = $wpdb->prepare(
			"SELECT * FROM `{$table}`
			 {$where}
			 ORDER BY {$orderby} {$order}
			 LIMIT %d OFFSET {$offset}
			",
			$posts_per_page
		);

		$cache[$current_page][$orderby][$order] = $wpdb->get_results( $query );

		if ( ! $this->search )
			set_transient( Setting::TRANSIENT, $cache, $this->cache_time * MINUTE_IN_SECONDS );

		return $cache[$current_page][$orderby][$order];
	}

	/**
	 * Get total results in wp list table for records
	 *
	 * @since 1.0
	 * @global $wpdb
	 * @param Null
	 * @return Integer
	 */
	private function _total_items()
	{
		global $wpdb;

		$cache = get_transient( Setting::TRANSIENT_SELECT_COUNT );
		$table = $wpdb->prefix . Setting::TABLE_NAME;

		if ( ! Utils::table_exists( Setting::TABLE_NAME ) )
			return 0;

		if ( ! $this->search && false !== $cache )
			return $cache;

		$where       = ( $this->search ) ? " WHERE `post_title` LIKE '%%{$this->search}%%'" : null;
		$query       = "SELECT COUNT(*) FROM {$table}{$where}";
		$row_count   = $wpdb->get_var( $query );
		$total_items = intval( $row_count );

		$this->_set_cache_caunter( $total_items );

		return $total_items;
	}

	/**
	 * Verify table exists in database
	 *
	 * @since 1.0
	 * @param Object $wpdb
	 * @param String $table
	 * @return Boolean
	 */
	private function _table_exists( $wpdb, $table )
	{
		return $wpdb->query( "SHOW TABLES LIKE '{$table}'" );
	}

	/**
	 * Set transient cache items counter
	 *
	 * @since 1.0
	 * @param Integer $total_items
	 * @return Void
	 */
	private function _set_cache_caunter( $total_items )
	{
		if ( ! $this->search ) :
			set_transient(
				Setting::TRANSIENT_SELECT_COUNT,
				$total_items,
				$this->cache_time * MINUTE_IN_SECONDS
			);
		endif;
	}

	/**
	 * Insert results in column wp list table
	 *
	 * @since 1.0
	 * @param Null
	 * @return Mixed String/Integer
	 */
	public function column_default( $items, $column )
	{
		$column = strtolower( $column );

		switch ( $column ) :

			case 'title' :
				return Sharing_Report_View::add_permalink_title( $items->post_id, $items->post_title );
				break;

			case 'facebook'  :
			case 'twitter'   :
			case 'google'    :
			case 'linkedin'  :
			case 'pinterest' :
			case 'total'     :
				return Utils::number_format( $items->$column );
				break;

		endswitch;
	}

	/**
	 * Set column wp list table
	 *
	 * @since 1.0
	 * @param Null
	 * @return Array
	 */
	public function get_columns()
	{
		$columns = array(
			'Title'     => __( 'Title', App::TEXTDOMAIN ),
			'Facebook'  => __( 'Facebook', App::TEXTDOMAIN ),
			'Google'    => __( 'Google+', App::TEXTDOMAIN ),
			'Twitter'   => __( 'Twitter', App::TEXTDOMAIN ),
			'Linkedin'  => __( 'Linkedin', App::TEXTDOMAIN ),
			'Pinterest' => __( 'Pinterest', App::TEXTDOMAIN ),
			'Total'     => __( 'Total', App::TEXTDOMAIN ),
		);

		return $columns;
	}

	/**
	 * Set orderby in column wp list table
	 *
	 * @since 1.0
	 * @param Null
	 * @return Array
	 */
	public function get_sortable_columns()
	{
		$sortable_columns = array(
			'Title'     => array( 'post_title', true ),
			'Facebook'  => array( 'facebook', true ),
			'Google'    => array( 'google', true ),
			'Twitter'   => array( 'twitter', true ),
			'Linkedin'  => array( 'linkedin', true ),
			'Pinterest' => array( 'pinterest', true ),
			'Total'     => array( 'total', true ),
		);

		return $sortable_columns;
	}

	/**
	 * Prepare item for record add in wp list table
	 *
	 * @since 1.1
	 * @param Null
	 * @return Array
	 */
	public function prepare_items()
	{
		$orderby               = Utils::get( 'orderby', 'total', 'sanitize_sql_orderby' );
		$order_type            = Utils::get( 'order', 'desc', 'sanitize_sql_orderby' );
		$reference             = $this->_verify_sql_orderby( $orderby, 'total' );
		$order                 = $this->_verify_sql_order( $order_type, 'desc' );
		$posts_per_page        = $this->get_items_per_page( 'ssb_posts_per_page', self::POSTS_PER_PAGE );
		$current_page          = $this->get_pagenum();
		$total_items           = self::_total_items();
		$this->_column_headers = $this->get_column_info();

		$this->set_pagination_args(
			array(
				'total_items' => $total_items,
				'total_pages' => ceil( $total_items / $posts_per_page ),
				'per_page'    => $posts_per_page,
			)
		);

		$this->items = self::_get_sharing_report( $posts_per_page, $current_page, $reference, $order );
	}

	/**
	 * Return message in wp list table case empty records
	 *
	 * @since 1.0
	 * @param Null
	 * @return String
	 */
	public function no_items()
	{
		_e( 'There is no record available at the moment!', App::TEXTDOMAIN );
	}

	/**
	 * Create submenu page
	 *
	 * @since 1.0
	 * @param null
	 * @return Void
	 */
	public function menu()
	{
	  	add_submenu_page(
	  		App::SLUG,
	  		__( 'Sharing Report | Social Share Buttons', App::TEXTDOMAIN ),
	  		__( 'Sharing Report', App::TEXTDOMAIN ),
	  		'manage_options',
	  		App::SLUG . '-sharing-report',
	  		array( &$this, 'report' )
	  	);
	}

	/**
	 * Set report page view
	 *
	 * @since 1.3
	 * @param null
	 * @return Void
	 */
	public function report()
	{
		Sharing_Report_View::render_sharing_report( $this );
	}

	/**
	 * Verify sql orderby param
	 *
	 * @since 1.2
	 * @param String $orderby
	 * @param String $default
	 * @return String
	 */
	private function _verify_sql_orderby( $orderby, $default = '' )
	{
		$permissions = array(
			'post_title',
			'facebook',
			'twitter',
			'google',
			'linkedin',
			'pinterest',
			'total',
		);

		if ( in_array( $orderby, $permissions ) )
				return $orderby;

		return $default;
	}

	/**
	 * Verify sql order param
	 *
	 * @since 1.0
	 * @param String $order
	 * @param String $default
	 * @return String
	 */
	private function _verify_sql_order( $order, $default = '' )
	{
		if ( $order === 'desc' || $order === 'asc' )
			return strtoupper( $order );

		return $default;
	}

	/**
	 * Create table sharing reports.
	 *
	 * @since 1.1
	 * @global $wpdb
	 * @param Null
	 * @global $wpdb
	 * @return Void
	 */
	public function create_table()
	{
		global $wpdb;

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		$charset    = $wpdb->get_charset_collate();
		$table_name = $wpdb->prefix . Setting::TABLE_NAME;
		$sql        = "CREATE TABLE IF NOT EXISTS {$table_name} (
			id         BIGINT(20) NOT NULL AUTO_INCREMENT,
			post_id    BIGINT(20) UNSIGNED NOT NULL,
			post_title TEXT       NOT NULL,
			facebook   BIGINT(20) UNSIGNED NOT NULL,
			twitter    BIGINT(20) UNSIGNED NOT NULL,
			google     BIGINT(20) UNSIGNED NOT NULL,
			linkedin   BIGINT(20) UNSIGNED NOT NULL,
			pinterest  BIGINT(20) UNSIGNED NOT NULL,
			total      BIGINT(20) UNSIGNED NOT NULL,
			PRIMARY KEY id ( id ),
			UNIQUE( post_id )
		) {$charset};
		";

		dbDelta( $sql );
		Utils::add_update_option( Setting::DB_VERSION_OPTION_NAME );
	}
}