<?php
/**
 * @package Social Share Buttons
 */
/*
	Plugin Name: Social Share Buttons
	Plugin URI:  https://github.com/victorfreitas
	Version:     2.4.0
	Author:      Victor Freitas
	Author URI:  https://github.com/victorfreitas
	License:     GPL2
	Text Domain: jogar-mais-social-share-buttons
	Domain Path: /languages
	Description: Insert share buttons of social networks. The buttons are inserted automatically or can be called via shortcode or php method.
*/

/*
 *      Copyright 2016 Victor Freitas <dev@jogarmais.com.br>
 *
 *      This program is free software; you can redistribute it and/or modify
 *      it under the terms of the GNU General Public License as published by
 *      the Free Software Foundation; either version 3 of the License, or
 *      (at your option) any later version.
 *
 *      This program is distributed in the hope that it will be useful,
 *      but WITHOUT ANY WARRANTY; without even the implied warranty of
 *      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *      GNU General Public License for more details.
 *
 *      You should have received a copy of the GNU General Public License
 *      along with this program; if not, write to the Free Software
 *      Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 *      MA 02110-1301, USA.
 */

namespace JM\Share_Buttons;

// Avoid that files are directly loaded
if ( ! function_exists( 'add_action' ) )
	exit(0);

class App
{
    /**
     * The short slug
     *
     * @var String
     */
	const SLUG = 'jm-ssb';

    /**
     * Text domain real dir name
     *
     * @var String
     */
	const TEXTDOMAIN = 'jogar-mais-social-share-buttons';

    /**
     * Initial file path
     *
     * @var String
     */
	const FILE = __FILE__;

    /**
     * Version
     *
     * @var String
     */
	const VERSION = '2.4.0';

	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @since 2.0
	 * @return Void
	 */
	public static function uses( $class, $location )
	{
		$extension = 'php';
		$sep       = DIRECTORY_SEPARATOR;
		$dirname   = dirname( __FILE__ );

		if ( in_array( $location, array( 'View', 'Controller', ) ) )
			$extension = strtolower( $location ) . ".{$extension}";

		require_once( "{$dirname}{$sep}{$location}{$sep}{$class}.{$extension}" );
	}
}

App::uses( 'core', 'Config' );

$core = new Core();