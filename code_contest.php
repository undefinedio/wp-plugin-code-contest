<?php
/*
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

/**
 * TEMP
 */
ini_set( 'display_errors', 1 );
ini_set( 'display_startup_errors', 1 );
error_reporting( - 1 );

class CodeContest {

	/*--------------------------------------------*
	 * Constants
	 *--------------------------------------------*/
	const name = 'Code Contest';
	const slug = 'code_contest';

	private $adminPages = null;

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
		include_once( 'inc/admin-page.php' );
	}

	/**
	 * Initialise Admin classes
	 */
	public function initializeAdmin() {
		$this->adminPages = new Admin_Pages();
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
		// Setup localization
		load_plugin_textdomain( self::slug, false, dirname( plugin_basename( __FILE__ ) ) . '/lang' );
		// Load JavaScript and stylesheets
		$this->register_scripts_and_styles();

		// Register the shortcode [code_contest]
		add_shortcode( 'code_contest', array( &$this, 'render_shortcode' ) );

		if ( is_admin() ) {
			$this->initializeAdmin();
		} else {
			//this will run when on the frontend
		}

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
	 * Render shortcode
	 *
	 * @param $atts
	 */
	function render_shortcode( $atts ) {
		// Extract the attributes
		extract( shortcode_atts( array(
			'attr1' => 'foo', //foo is a default value
			'attr2' => 'bar'
		), $atts ) );
		// you can now access the attribute values using $attr1 and $attr2
	}

	/**
	 * Registers and enqueues stylesheets for the administration panel and the
	 * public facing site.
	 */
	private function register_scripts_and_styles() {
		if ( is_admin() ) {
			$this->load_file( self::slug . '-admin-script', '/assets/admin.js', true );
			$this->load_file( self::slug . '-admin-style', '/assets/admin.css' );
		} else {
			$this->load_file( self::slug . '-script', '/assets/widget.js', true );
			$this->load_file( self::slug . '-style', '/assets/widget.css' );
		} // end if/else
	} // end register_scripts_and_styles

	/**
	 * Helper function for registering and enqueueing scripts and styles.
	 *
	 * @name    The    ID to register with WordPress
	 * @file_path        The path to the actual file
	 * @is_script        Optional argument for if the incoming file_path is a JavaScript source file.
	 */
	private function load_file( $name, $file_path, $is_script = false ) {

		$url  = plugins_url( $file_path, __FILE__ );
		$file = plugin_dir_path( __FILE__ ) . $file_path;

		if ( file_exists( $file ) ) {
			if ( $is_script ) {
				wp_register_script( $name, $url, array( 'jquery' ) ); //depends on jquery
				wp_enqueue_script( $name );
			} else {
				wp_register_style( $name, $url );
				wp_enqueue_style( $name );
			} // end if
		} // end if

	} // end load_file

} // end class

new CodeContest();