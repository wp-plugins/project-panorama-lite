<?php

/**
 * Plugin Name: Project Panorama Lite
 * Plugin URI: http://www.projectpanorama.com
 * Description: Give your team and your clients a 360 degree view of your projects
 * Version: 1.2.1.8
 * Author: 37 MEDIA
 * Author URI: http://www.projectpanorama.com
 * License: GPL2
 * Text Domain: psp_projects
 */

// Initiallize the plugin
require_once('lib/init.php');
include_once('license.php');

// ================
// = Localization =
// ================

function psp_localize_init() { load_plugin_textdomain('psp_projects', false, dirname(plugin_basename(__FILE__)) . '/languages'); }

// Add actions
add_action('plugins_loaded', 'psp_localize_init');

// ============================
// = Plugin Update Management =
// ============================
	

define( 'PROJECT_PANORAMA_STORE_URL', 'http://www.projectpanorama.com' ); 

define( 'EDD_PROJECT_PANORAMA', 'Project Panorama Premium' );

if( !class_exists( 'EDD_SL_Plugin_Updater' ) ) {
	// load our custom updater
	include( dirname( __FILE__ ) . '/EDD_SL_Plugin_Updater.php' );
}

function edd_project_panorama_plugin_updater() {

	// retrieve our license key from the DB
	$license_key = trim( get_option( 'edd_panorama_license_key' ) );

	// setup the updater
	$edd_updater = new EDD_SL_Plugin_Updater( PROJECT_PANORAMA_STORE_URL, __FILE__, array( 
			'version' 	=> '1.2.1.7.2', 				// current version number
			'license' 	=> $license_key, 		// license key (used get_option above to retrieve from DB)
			'item_name' => EDD_PROJECT_PANORAMA, 	// name of this plugin
			'author' 	=> '37 Media',  // author of this plugin
			'url'           => home_url()
		)
	);

}

add_action( 'admin_init', 'edd_project_panorama_plugin_updater' );

function add_license_link($links) { 
	
	$license_key = trim( get_option ('edd_panorama_license_key')); 
	if(!$license_key) { 
		
		$settings_link = '<a href="'.site_url().'/wp-admin/edit.php?post_type=psp_projects&page=panorama-license">Register License</a>';
			
	} else { 
		
		$settings_link = '<a href="'.site_url().'/wp-admin/edit.php?post_type=psp_projects&page=panorama-license">Settings</a>';
		
	}
		
	array_unshift($links, $settings_link);
	return $links;
	
}
	
function add_license_after_row() {
		
	$license_key = trim( get_option ('edd_panorama_license_key')); 
	if(!$license_key) { 
		
		echo '</tr><tr class="plugin-update-tr"><td colspan="3"><div class="update-message"><a href="'.site_url().'/wp-admin/edit.php?post_type=psp_projects&page=panorama-license">'.__('Activate your license','psp_projects').'</a> '.__('for automatic upgrades. Need a license?','psp_projects').' <a href="http://www.projectpanorama.com" target="_new">'.__('Purchase one','psp_projects').'</a></div></td>';
			
	}
		
		
}
	
$plugin = plugin_basename(__FILE__);

add_filter("plugin_action_links_$plugin", 'add_license_link');
add_action('after_plugin_row_project-panorama/project-panorama.php', 'add_license_after_row');

/* When activated, call the post types and flush the rewrite rules */

register_activation_hook(__FILE__,'psp_projects');
register_activation_hook( __FILE__, 'flush_rewrite_rules' );

?>