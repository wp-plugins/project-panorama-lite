<?php

    $absolute_path = explode('wp-content', $_SERVER['SCRIPT_FILENAME']);
    $wp_load = $absolute_path[0] . 'wp-load.php';
    require_once($wp_load);

    header("Content-type: text/css; charset: UTF-8");
    header('Cache-control: must-revalidate');
    ?>

/* Custom styling dynamically generated by WordPress */

#psp-title {
    background: <?php echo get_option('psp_header_background'); ?>;
    color: <?php echo get_option('psp_header_text'); ?>;
}

#psp-title h1 {
    color: <?php echo get_option('psp_header_text'); ?>;
}

#psp-phases h3, .psp-phase h3 {
    background: <?php echo get_option('psp_accent_color_1'); ?>;
    color: <?php echo get_option('psp_accent_color_text_1'); ?>;
}

#psp-main-nav ul,
#psp-main-nav ul ul {
    background: <?php echo get_option('psp_menu_background'); ?>;
}

#psp-main-nav li#nav-menu.active {
    background: rgba(0,0,0.5) !important;
}

#psp-main-nav ul li li a {
    color: <?php echo get_option('psp_menu_text'); ?>;
}

#psp-title span {
    color: <?php echo get_option('psp_header_accent'); ?>;
}

body.psp-standalone-page {
    background-color: <?php echo get_option('psp_body_background'); ?>;
}

.psp-phase,
#psp-phases {
    border-color: <?php echo get_option('psp_body_background'); ?>;
}

#project-documents {
    color: <?php echo get_option('psp_body_text'); ?>;
}

#project-documents ul li a {
    color: <?php echo get_option('psp_body_link'); ?>;
}

#project-documents h3 {
    color: <?php echo get_option('psp_body_heading'); ?>;
}

#psp-discussion {
    background-color: <?php echo get_option('psp_footer_background'); ?>;
}

<?php echo get_option('psp_open_css'); ?>