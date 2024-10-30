<?php
/*
Plugin Name: bpCKEditor
Plugin URI: http://www.williamscastillo.com/code/plugins/bpckeditor/
Description: This plugin replaces the plain multiline text field on BP forums by a CKEditor.
Version: 1.1
Requires at least: WordPress 2.9.1 / BuddyPress 1.2
Tested up to: WordPress 3.0.1 / BuddyPress 1.2
License: GNU/GPL 2
Author: Williams Castillo
Author URI: http://www.williamscastillo.com/
Site Wide Only: true
Text Domain: bpckeditor
*/?>
<?php
/*  Copyright 2010  BPCKEditor  (email : eduven@gmail.com)

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
?>
<?php
/* Make sure BuddyPress is loaded before we do anything. */
if ( !function_exists( 'bp_core_install' ) ) {
	
	require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
	
	if ( is_plugin_active( 'buddypress/bp-loader.php' ) ) {
		require_once ( WP_PLUGIN_DIR . '/buddypress/bp-loader.php' );
	} else {
		add_action( 'admin_notices', 'bpckeditor_install_buddypress_notice' );
		return;
	}
}
/* The notice we show when the plugin is installed. */
define('BPCKEDITOR_URL'	, WP_CONTENT_URL.'/plugins/'.plugin_basename(dirname(__FILE__)));
define('BPCKEDITOR_PATH'	, WP_CONTENT_DIR.'/plugins/'.plugin_basename(dirname(__FILE__)));

define('BPCKEDITOR_VERSION'		, '1.1');
define('BPCKEDITOR_DB_VERSION'	, 1);
define('BPCKEDITOR_NAME'		, 'bpCKEditor');


function bpckeditor_textdomain() {
	load_plugin_textdomain( 'bpckeditor', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );	
}
add_action( 'init', 'bpckeditor_textdomain' );

function bpckeditor_install_buddypress_notice() {

	echo '<div id="message" class="error fade"><p style="line-height: 150%">';
	_e('<strong>bpCKEditor</strong></a> requires the BuddyPress plugin to work. Please <a href="http://buddypress.org">install BuddyPress</a> first, or <a href="plugins.php">deactivate bpCKEditor</a>.', 'bpckeditor');
	echo '</p></div>';

}

function bpckeditor_include() {
	if ( !is_admin() ) {
    	require( dirname( __FILE__ ) . '/frontend.php' );
	}
}
add_action( 'bp_include', 'bpckeditor_include' );

if ( is_admin() ) {
	require( dirname( __FILE__ ) . '/backend.php' );
}

?>
