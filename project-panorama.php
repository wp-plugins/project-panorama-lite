<?php

/**
 * Plugin Name: Project Panorama Lite
 * Plugin URI: http://www.projectpanorama.com
 * Description: Give your team and your clients a 360 degree view of your projects
 * Version: 1.2.5.3
 * Author: 37 MEDIA
 * Author URI: http://www.projectpanorama.com
 * License: GPL2
 * Text Domain: psp_projects
 */

// Initiallize the plugin

include_once('lib/psp-init.php');
include_once('psp-license.php');

// Important Definitions
if (! defined('PROJECT_PANARAMA_URI')) {
  define('PROJECT_PANARAMA_URI', plugins_url('', __FILE__));
}

if (! defined('PROJECT_PANARAMA_DIR')) {
  define('PROJECT_PANARAMA_DIR', __DIR__);
}

if(! defined('PROJECT_PANORAMA_STORE_URL')) { 
	define( 'PROJECT_PANORAMA_STORE_URL', 'http://www.projectpanorama.com' );
}

if(! defined('EDD_PROJECT_PANORAMA')) { 
	define( 'EDD_PROJECT_PANORAMA', 'Project Panorama Single' );
}

if(! defined('PSP_VER')) {
	define('PSP_VER','1.2.5.2.1');
}

// ================
// = Localization =
// ================

add_action('plugins_loaded', 'psp_localize_init');
function psp_localize_init() {
    load_plugin_textdomain('psp_projects', false, dirname(plugin_basename(__FILE__)) . '/languages');
}


// ============================
// = Plugin Update Management =
// ============================


if( !class_exists( 'EDD_SL_Plugin_Updater' ) ) {
	// load our custom updater
	include( dirname( __FILE__ ) . '/EDD_SL_Plugin_Updater.php' );
}

function edd_project_panorama_plugin_updater() {

	// retrieve our license key from the DB
	$license_key = trim( get_option( 'edd_panorama_license_key' ) );

	// setup the updater
	$edd_updater = new EDD_SL_Plugin_Updater( PROJECT_PANORAMA_STORE_URL, __FILE__, array(
			'version' 	=> PSP_VER, 				// current version number
			'license' 	=> $license_key, 		// license key (used get_option above to retrieve from DB)
			'item_name' => EDD_PROJECT_PANORAMA, 	// name of this plugin
			'author' 	=> '3.7 Media',  // author of this plugin
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

/**
 * Add a row after the Panorama plugin row, reminding users to activate their license
 *
 *
 * @param
 * @return NULL
 **/

function add_license_after_row() {

	$license_key = trim( get_option ('edd_panorama_license_key'));
	if(!$license_key) {

		echo '</tr><tr class="plugin-update-tr"><td colspan="3"><div class="update-message"><a href="'.site_url().'/wp-admin/edit.php?post_type=psp_projects&page=panorama-license">'.__('Activate your license','psp_projects').'</a> '.__('for automatic upgrades. Need a license?','psp_projects').' <a href="http://www.projectpanorama.com" target="_new">'.__('Purchase one','psp_projects').'</a></div></td>';

	}


}

$plugin = plugin_basename(__FILE__);

add_filter("plugin_action_links_$plugin", 'add_license_link');
add_action('after_plugin_row_project-panorama/project-panorama.php', 'add_license_after_row');

/* When activated, call the post types, add necissary capabilities and flush the rewrite rules */

register_activation_hook(__FILE__,'psp_projects');
register_activation_hook(__FILE__, 'flush_rewrite_rules' );

/**
 * Check to see what Panorama Database version the user is running. If none, call the display function
 *
 *
 * @param
 * @return NULL
 **/

function psp_check_database() {

    $psp_database_version = get_option('psp_database_version');

    if($psp_database_version != '2') {
        psp_database_notice();
    }

}

/**
 * Gives the user a notice to update their database if they haven't done so.
 *
 *
 * @param
 * @return NULL
 **/

add_action('admin_notices', 'psp_database_notice');
function psp_database_notice() {
	
    $projects = new WP_Query(array('post_type' => 'psp_projects', 'posts_per_page' => -1));

    if((get_option('psp_database_version') < 3) && ($projects->found_posts > 0)) {
        ?>
            <div class="updated">

                <p>Project Panorama needs to update your database. <strong>IMPORTANT: Backup your site before continuing.</strong> <a href="<?php echo site_url(); ?>/wp-admin/index.php?psp_upgrade_db=0">Click here to upgrade</a>.</p>

            </div>
    <?php
    } else { 
		
		// No projects found, new installation. Set the DB version.
		
        update_option('psp_database_version', 3);		
	}

}

add_action('admin_init','panorama_ignore_db');
function panorama_ignore_db() {
    global $current_user;
    $user_id = $current_user->ID;
    /* If user clicks to ignore the notice, add that to their user meta */

    if ( isset($_GET['panorama_ignore_db']) && '0' == $_GET['panorama_ignore_db'] ) {
        add_user_meta($user_id, 'panorama_ignore_db', 'true', true);
    }

}

add_action('admin_init','psp_upgrade_db');
function psp_upgrade_db() {

    if(isset($_GET['psp_upgrade_db']) && '0' == $_GET['psp_upgrade_db']) {

        $projects = new WP_Query(array('post_type' => 'psp_projects', 'posts_per_page' => -1));

        while ($projects->have_posts()): $projects->the_post();

            global $post;
            $auto_progress = 0;

            while (have_rows('phases')): the_row();


                if (get_sub_field('auto_progress')) {
                    $auto_progress = 1;
                }

            endwhile;

            if ($auto_progress == 1) {
                update_field('field_5436e7f4e06b4', 'Yes',$post->ID);
            }

			if(psp_compute_progress($post->ID) == 100) {

				wp_set_post_terms($post->ID,'completed','psp_status');

			}

        endwhile;

        ?>
        <div class="updated">

            <p>Panorama has successfully updated your WordPress database.</p>

        </div>

        <?php

        update_option('psp_database_version', 3);

    }

} ?>