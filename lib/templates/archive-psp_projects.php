<?php

/* Custom Single.php for project only view */
global $post, $doctype;

?>
<!DOCTYPE html>
<html <?php language_attributes( $doctype ); ?>>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php get_bloginfo('name'); ?></title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php if(get_field('hide_from_search_engines',$post->ID)): ?>
        <meta name="robots" content="noindex, nofollow">
    <?php endif; ?>

    <?php // wp_head(); Removed for visual consistency ?>

    <link rel="stylesheet" type="text/css" href="<?php echo plugins_url(); ?>/project-panorama/assets/css/psp-frontend.css?ver=1.2.5">
    <link rel="stylesheet" type="text/css" href="<?php echo plugins_url(); ?>/project-panorama/assets/css/psp-custom.css.php">

	<script src="<?php echo plugins_url(); ?>/project-panorama/assets/js/jquery.js?ver=1.2.5"></script>
    <script src="<?php echo plugins_url(); ?>/project-panorama/assets/js/psp-frontend-lib.min.js?ver=1.2.5"></script>
    <script src="<?php echo plugins_url(); ?>/project-panorama/assets/js/psp-frontend-behavior.js?ver=1.2.5"></script>

    <?php wp_localize_script( 'script_handle', 'MyAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php'))); ?>

    <!--[if lte IE 9]>
    <script src="<?php echo plugins_url(); ?>/project-panorama/assets/js/html5shiv.min.js"></script>
    <script src="<?php echo plugins_url(); ?>/project-panorama/assets/js/css3-mediaqueries.js"></script>
    <![endif]-->
    <!--[if IE]>
    <link rel="stylesheet" type="text/css" src="<?php echo plugins_url(); ?>/project-panorama/assets/css/ie.css">
    <![endif]-->

    <?php do_action('psp_head'); ?>

</head>
<body class="psp-standalone-page psp-dashboard-page">

		<div id="overview" class="psp-project-list-wrapper">
	<?php if(is_user_logged_in()): ?>
		
		<?php echo do_shortcode('[user-dashboard-widget]'); ?>
		
		<?php /* THIS WILL COME! 
		<div id="overview" class="psp-project-list-wrapper">
			<h2><?php _e('Your Active Projects','psp_projects'); ?></h2>
			
			<?php
			$args = array(
				'post_type'			=>		'psp_projects',
				'paged'				=>		'1',
				'posts_per_page'	=>		'-1',
				'meta_key'			=>		'start_date',
				'orderby'			=>		'menu_order',
				'order'				=>		'ASC'
			);
			
			
	        if(!current_user_can('manage_options')) {

	            $cuser = wp_get_current_user();
	            $cid = $cuser->ID;
			
	            $meta_args = array(
	                'meta_query' => array(
	                    'relation' => 'OR',
	                    array(
	                        'key' => 'allowed_users_%_user',
	                        'value' => $cid
	                    ),
	                    array(
	                        'key' => 'restrict_access_to_specific_users',
	                        'value' => ''
	                    )
	                )
	            );
			
			    $args = array_merge($args,$meta_args);
								
			}
			
			$projects = new WP_Query($args);
			
			if($projects->have_posts()): $i = 0; $c = 1; ?>
				
				<script>

					var chartOptions = {
						responsive: true
					}

            		var allCharts = [];

				</script>
				
				<div class="psp-grid-row cf">
					<?php while($projects->have_posts()): $projects->the_post(); 
						
						global $post;
						
						// Calculate variables
						$completed = psp_compute_progress($post->ID);
						$remaining = 100 - $completed; 
						
						
						// Figure out the color
						if($c == 1) {
							$color = 'blue';
							$chex = '#3299BB';
						} elseif ($c == 2) {
							$color = 'teal';
							$chex = '#4ECDC4';
						} elseif ($c == 3) {
							$color = 'green';
							$chex = '#CBE86B';
						} elseif ($c == 4) {
							$color = 'pink';
							$chex = '#FF6B6B';
						} elseif ($c == 5) {
							$color = 'maroon';
							$chex = '#C44D58';
							$c = 1;
						}
						
						?>
						<div class="psp-grid-col-md-4">
							
							
							<canvas class="phase-chart" id="chart-<?php echo $i; ?>" width="100%"></canvas>

							<script>

                                jQuery(document).ready(function() {

                                    var data = [
                                        {
                                            value: <?php echo $completed; ?>,
                                            color: '<?php echo $chex; ?>',
                                            label: "<?php _e('Completed','psp_projects'); ?>"
                                        },
                                        {
                                            value: <?php echo $remaining; ?>,
                                            color: "#efefef",
                                            label: "<?php _e('Remaining','psp_projects'); ?>"
                                        }
                                    ];


                                    var chart_<?php echo $i; ?> = document.getElementById("chart-<?php echo $i; ?>").getContext("2d");
    								// var phaseProgress_<?php echo $i; ?> = new Chart(chart_<?php echo $i; ?>).Doughnut(data,chartOptions);

                                    allCharts[<?php echo $i; ?>] = new Chart(chart_<?php echo $i; ?>).Doughnut(data,chartOptions);

                                });

							</script>
							
							<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
							
							
						</div>
					<?php $i++; $c++; endwhile; ?>
				</div>
			<?php else: ?>
				<p class="psp-notice-alert">You don't have any active projects at this time.</p>
			<?php endif; */ ?>
			
		    <?php if((get_option('psp_logo') != '') && (get_option('psp_logo') != 'http://')) { ?>

		        <section id="psp-branding" class="wrapper">
		            <div class="psp-branding-wrapper">
		                <a href="<?php echo site_url(); ?>"><img src="<?php echo get_option('psp_logo'); ?>"></a>
		            </div>
		        </section>

		    <?php } ?>
			
			<header id="psp-dashboard-header">
				<p class="psp-pull-right"><a href="<?php echo site_url(); ?>" class="pano-btn pano-btn-default">Home</a></p>
				<h2><?php _e('Your Active Projects','psp_projects'); ?></h2>
				
						
			<?php echo do_shortcode('[project_list count="9999"]'); ?>
			
			
			
		</div>
	<?php else: ?>
        <div id="overview" class="psp-comments-wrapper">
            <div id="psp-login">
            	<h2><?php _e('Account Login','psp_projects'); ?></h2>
                <?php echo panorama_login_form(); ?>
            </div>
        </div>
	<?php endif; ?>
	
</body>
</html>