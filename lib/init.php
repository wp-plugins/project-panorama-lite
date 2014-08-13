<?php

	/* Init.php 
	
	Master file, builds everything.
	
	*/
	
	
	// Include Advanced Custom Fields - NOTE: Premium "Repeater Field" Add-on is NOT to be used or distributed outside of this plugin per original copyright information from ACF - http://www.advancedcustomfields.com/resources/getting-started/including-lite-mode-in-a-plugin-theme/
		 
	global $acf;
	
	if(!$acf) { 
		define( 'ACF_LITE' , true );
		include_once('acf/master/acf.php' );
	}

    if(file_exists(dirname(__FILE__).'/pro/init.php')) {

        require_once('pro/init.php');

        if(!class_exists('acf_field_repeater')) {
            include_once('acf/repeater/acf-repeater.php');
        }

        define('PSP_PLUGIN_TYPE','professional');
        define('PSP_PLUGIN_DIR','project-panorama');

    } else {

        require_once('lite/init.php');
        define('PSP_PLUGIN_TYPE','lite');
        define('PSP_PLUGIN_DIR','project-panorama-lite');

    }

    if(!function_exists('duplicate_post_is_current_user_allowed_to_copy')) {
        include_once('clone/duplicate-post.php');
    }

    include_once('acf/slider/acf-slider.php');
    require_once('data_model.php');
    require_once('custom_templates.php');
    require_once('view.php');
    require_once('front_end.php');
    require_once('custom_comments.php');
    require_once('helper.php');
    require_once('shortcodes.php');

?>