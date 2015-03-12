<?php namespace Undefined\CodeContest;

/* Made with anger and beer by.....

██╗   ██╗███╗   ██╗██████╗ ███████╗███████╗██╗███╗   ██╗███████╗██████╗
██║   ██║████╗  ██║██╔══██╗██╔════╝██╔════╝██║████╗  ██║██╔════╝██╔══██╗
██║   ██║██╔██╗ ██║██║  ██║█████╗  █████╗  ██║██╔██╗ ██║█████╗  ██║  ██║
██║   ██║██║╚██╗██║██║  ██║██╔══╝  ██╔══╝  ██║██║╚██╗██║██╔══╝  ██║  ██║
╚██████╔╝██║ ╚████║██████╔╝███████╗██║     ██║██║ ╚████║███████╗██████╔╝
 ╚═════╝ ╚═╝  ╚═══╝╚═════╝ ╚══════╝╚═╝     ╚═╝╚═╝  ╚═══╝╚══════╝╚═════╝

Plugin Name: Code Contest
Plugin URI: http://unde.fined.io
Version: 0.1
Author: Vincent Peters
Author Email: vincent@unde.fined.io
License:

  Copyright 2011 Vincent Peters (vincent@unde.fined.io)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

*/

require 'vendor/autoload.php';

/**
 * TEMP solution for php errors
 */
if ( gethostname() == "Vincents-MBP.telenet.be" ) {
	ini_set( 'display_errors', 1 );
	ini_set( 'display_startup_errors', 1 );
	error_reporting( - 1 );
}

class CodeContest {

	/*--------------------------------------------*
	 * Constants
	 *--------------------------------------------*/
	const name = 'Code Contest';
	const slug = 'code_contest';

	/**
	 * Constructor
	 */
	function __construct() {
		$new_version = '1.0.1';

		if ( get_option( 'CODE_CONTEST_VERSION_KEY' ) != $new_version ) {
			$this->update_database_table();
			update_option( 'CODE_CONTEST_VERSION_KEY', $new_version );
		}
		//register an activation hook for the plugin
		register_activation_hook( __FILE__, array( &$this, 'install_code_contest' ) );
		//Hook up to the init action
		add_action( 'init', array( &$this, 'init_code_contest' ) );
	}

	/**
	 * Update database
	 */
	function update_database_table() {
		global $wpdb;
		$table_name      = $wpdb->prefix . "code_contest";
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $table_name (
  id mediumint(9) NOT NULL AUTO_INCREMENT,
  code varchar(55) DEFAULT '' NOT NULL,
  email varchar(55) DEFAULT '' NOT NULL,
  name varchar(55) DEFAULT '' NOT NULL,
  UNIQUE KEY id (id)
) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}

	/**
	 * Include classes
	 */
	public function includes() {
		include_once( 'inc/codeTrait.php' );
		include_once( 'inc/shortcode-ajax.php' );
		include_once( 'inc/admin-page.php' );
		include_once( 'inc/admin-ajax.php' );
		include_once( 'inc/codeValidator.php' );
		include_once( 'inc/codeGenerator.php' );
		include_once( 'inc/entries.php' );
		include_once( 'inc/shortcode.php' );
		include_once( 'inc/mailchimp.php' );
	}

	/**
	 * Initialise Admin classes
	 */
	public function initializeAdmin() {
		new Admin_Pages();
		new Admin_Ajax();
	}

	/**
	 * Initialise Shortcode classes
	 */
	public function initializeShortcode() {
		new Shortcode_Ajax();
		new Shortcode();
	}

	/**
	 * Initialise classes
	 */
	public function initialize() {

	}

	/**
	 * Runs when the plugin is activated
	 */
	function install_code_contest() {

	}

	/**
	 * Runs when the plugin is initialized
	 */
	function init_code_contest() {

		$this->includes();

		if ( is_admin() ) {
			$this->initializeAdmin();
		}
		$this->initializeShortcode();

		// Setup localization
		load_plugin_textdomain( self::slug, false, dirname( plugin_basename( __FILE__ ) ) . '/lang' );
		// Load JavaScript and stylesheets
		$this->register_scripts_and_styles();

		/*
		 * TODO: Define custom functionality for your plugin here
		 *
		 * For more information:
		 * http://codex.wordpress.org/Plugin_API#Hooks.2C_Actions_and_Filters
		 */
		add_action( 'your_action_here', array( &$this, 'action_callback_method_name' ) );
		add_filter( 'your_filter_here', array( &$this, 'filter_callback_method_name' ) );
	}

	function action_callback_method_name() {
		// TODO define your action method here
	}

	function filter_callback_method_name() {
		// TODO define your filter method here
	}


	/**
	 * Registers and enqueues stylesheets for the administration panel and the
	 * public facing site.
	 */
	private function register_scripts_and_styles() {
		if ( is_admin() ) {
			wp_enqueue_media();
			wp_enqueue_style( self::slug . '-admin-style', plugins_url( '/assets/admin.css', __FILE__ ), array(), '1.0.0', 'all' );
			wp_enqueue_script( self::slug . '-admin-script', plugins_url( '/assets/admin.js', __FILE__ ), array( 'jquery' ), '1.0.0', 'all' );
			wp_enqueue_script( self::slug . '-datatables', plugins_url( '/assets/jquery.dataTables.min.js', __FILE__ ), array( 'jquery' ), '1.0.0', 'all' );
		} else {
			wp_enqueue_style( self::slug . '-shortcode-style', plugins_url( '/assets/shortcode.css', __FILE__ ), array(), '1.0.0', 'all' );
			wp_enqueue_script( self::slug . '-shortcode-script', plugins_url( '/assets/shortcode.js', __FILE__ ), array( 'jquery' ), '1.0.0', 'all' );
		} // end if/else
	} // end register_scripts_and_styles

} // end class

new CodeContest();