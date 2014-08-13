<?php

	/* Custom Single.php for project only view */
	global $post;	
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
	"http://www.w3.org/TR/html4/loose.dtd">
	<head>
		<?php $client = get_field('client'); ?>
		<title><?php the_title(); ?> | <?php echo $client; ?></title>
		
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<?php if(get_field('hide_from_search_engines',$post->ID)): ?>
			<meta name="robots" content="noindex, nofollow">
		<?php endif; ?>
				
		<?php // wp_head(); Removed for visual consistency ?>
		
		<link rel="stylesheet" type="text/css" href="<?php echo plugins_url(); ?>/project-panorama-lite/assets/css/psp-frontend.css">
		
		<script type="text/javascript" src="<?php echo plugins_url(); ?>/project-panorama-lite/assets/js/jquery.js"></script>
		<script type="text/javascript" src="<?php echo plugins_url(); ?>/project-panorama-lite/assets/js/snap.svg-min.js"></script>
		<script type="text/javascript" src="<?php echo plugins_url(); ?>/project-panorama-lite/assets/js/pizza.js"></script>
		<script type="text/javascript" src="<?php echo plugins_url(); ?>/project-panorama-lite/assets/js/jquery.smooth-scroll.min.js"></script>
		<script type="text/javascript" src="<?php echo plugins_url(); ?>/project-panorama-lite/assets/js/psp-frontend-behavior.js"></script>
		
		
		<!--[if lte IE 9]>
			<script type="text/javascript" src="<?php echo plugins_url(); ?>/project-panorama-lite/assets/js/css3-mediaqueries.js"></script>
		<![endif]-->
		<!--[if IE]>
			<link rel="stylesheet" type="text/css" src="<?php echo plugins_url(); ?>/project-panorama-lite/assets/css/ie.css">
		<![endif]-->
			
		<?php do_action('psp_head'); ?>
				
	</head>
	<body class="psp-standalone-page">
		
		<?php $panorama_access = panorama_check_access($post->ID); ?>
		
		<div id="psp-project">
			<?php while(have_posts()): the_post(); ?>
				<div id="psp-title" class="cf">
					<div class="wrapper">
						<h1><?php the_title(); ?> <span><?php echo $client; ?></span></h1>
						<?php if($panorama_access == 1): ?>
						<div class="nav" id="psp-main-nav">
							<ul>
								<li id="nav-menu"><a href="#">Menu</a>
									<ul>
										<li id="nav-over"><a href="#overview"><?php _e('Overview','psp_projects'); ?></a></li>
										<li id="nav-complete"><a href="#psp-progress"><?php _e('% Complete','psp_projects'); ?></a></li>
										<li id="nav-talk"><a href="#psp-discussion"><?php _e('Discussion','psp_projects'); ?></a></li>
										<?php if(is_user_logged_in()): ?>
											<li id="nav-logout"><a href="<?php echo wp_logout_url($_SERVER["REQUEST_URI"]); ?>"><?php _e('Logout','psp_projects'); ?></a></li>
										<?php endif; ?>
									</ul>
								</li>
							</ul>
						</div>
					<?php endif; ?>
					</div>
				</div>
				
				<?php 
												
				if ($panorama_access == 1) : ?>
				
				<div id="overview" class="wrapper">
					
					<?php if((get_option('psp_logo') != '') && (get_option('psp_logo') != 'http://')) { ?>
						
						<div id="psp-branding">
							<div class="psp-branding-wrapper">
								<img src="<?php echo get_option('psp_logo'); ?>">
							</div>
						</div>
						
					<?php } ?>
					
					<?php 
					
					do_action('psp_before_essentials');
						echo psp_essentials($post->ID); 
					do_action('psp_after_essentials');
		
					?>
				</div> <!--/#overview-->

                <?php do_action('psp_between_overview_progress'); ?>
			
				<div id="psp-progress" class="cf">
					<?php 
					
						do_action('psp_before_progress');
							echo psp_total_progress($post->ID);
						do_action('psp_after_progress'); 
						
					?>
				</div> <!--/#progress-->

                <?php do_action('psp_between_phases_discussion'); ?>

                    <!-- Discussion -->
			<div id="psp-discussion">
				<div class="wrapper">
					
					<div class="discussion-content">
						<h2><?php _e('Project Discussion','psp_projects'); ?></h2>
							
							<?php $commentPath = getcwd().'/comments.php'; ?>
							<?php comments_template($commentPath,true); ?>

					</div>
					
				</div>
			</div>
			<?php endif; ?>
				
				<?php if($panorama_access == 0): ?>
				<div id="overview" class="wrapper">
					<div id="psp-login">
						<?php if(($access_granted == 0) && (get_field('restrict_access_to_specific_users'))): ?>
							<h2><?php _e('This Project Requires a Login','psp_projects'); ?></h2>
							<?php if(!is_user_logged_in()) { 
								echo panorama_login_form(); 
							} else { 
								echo "<p>".__('You don\'t have permission to access this project','psp_projects')."</p>";
							}	
							?>
						<?php endif; ?>
						<?php if((post_password_required()) && (!current_user_can('manage_options'))): ?>
							<h2><?php _e('This Project is Password Protected','psp_projects'); ?></h2>
							<?php echo get_the_password_form(); ?>
						<?php endif; ?>
					</div>
				</div>			
			<?php endif; ?>
	
			
			<?php endwhile; // ends the loop ?>
			
		</div>
		<?php wp_footer(); ?>
	</body>
</html>
