<?php

	/* Init.php 
	
	Master file, builds everything.
	
	NOTE: Premium "Repeater Field" Add-on is NOT to be used or distributed outside of this plugin per original copyright information from ACF 
	http://www.advancedcustomfields.com/resources/getting-started/including-lite-mode-in-a-plugin-theme/
	
	*/
		 
add_action('plugins_loaded','psp_global_init');
function psp_global_init() { 
		 
	global $acf;
	
	if(!$acf) {  define( 'ACF_LITE' , true ); include_once('acf/master/acf.php' ); }

    if(file_exists(dirname(__FILE__).'/pro/psp-pro-init.php')) {
		
		// This is a professional version, define constants and load libraries
		
        define('PSP_PLUGIN_TYPE','professional');
        define('PSP_PLUGIN_DIR','project-panorama');

        include_once('pro/psp-pro-init.php');

        if((!class_exists('acf_field_repeater')) && (!file_exists(ABSPATH.'/wp-content/plugins/acf-repeater/acf-repeater.php'))) { include_once('acf/repeater/acf-repeater.php'); }

        if(!function_exists('acf_repeater_collapser_assets')) { include_once('acf/collapse/acf_repeater_collapser.php'); }

    } else {
		
		// This is a free version, load the stripped down libraries
		
        define('PSP_PLUGIN_TYPE','lite');
        define('PSP_PLUGIN_DIR','project-panorama-lite');

        include_once('lite/psp-lite-init.php');
    }

	// Load duplicate post regardless
	
    if(!function_exists('duplicate_post_is_current_user_allowed_to_copy')) { include_once('clone/duplicate-post.php'); }
	
    $standard_includes = array(
        'acf/slider/acf-slider',
        'psp-data-model',
        'psp-templates',
        'psp-view',
        'psp-assets',
        'psp-comments',
        'psp-helpers',
        'psp-base-shortcodes',
        'psp-widgets',
        'psp-timing'
    );
	

    foreach ($standard_includes as $include) {
        include_once($include.'.php');
    }
	
	

}


?>