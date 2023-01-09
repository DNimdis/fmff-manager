<div class="fmffmanager-top-bar-w">
	<div class="fmffmanager-top-logo">
		<a href="<?php echo SmRouterHelper::build_link(SmRouterHelper::build_route_name('dashboard', 'index')); ?>"><img src="<?php echo FMFFManager::images_url().'logo-admin.png' ?>" alt=""></a>
	</div>
	<div class="fmffmanager-top-search-w">
		<div class="fmffmanager-top-search-input-w">
			<i class="fmffmanager-icon fmffmanager-icon-x fmffmanager-mobile-top-search-trigger-cancel"></i>
			<input type="text" data-route="<?php echo SmRouterHelper::build_route_name('search', 'query_results') ?>" class="fmffmanager-top-search" placeholder="<?php _e('Start typing to find customers, Teachers or Classes...', 'fmffmanager'); ?>">
		</div>
		<div class="fmffmanager-top-search-results-w"></div>
	</div>
	
	<a href="#" title="<?php _e('Settings', 'fmffmanager'); ?>" class="fmffmanager-top-iconed-link fmffmanager-mobile-top-menu-trigger"><i class="fmffmanager-icon fmffmanager-icon-menu"></i></a>
	<a href="#" title="<?php _e('Search', 'fmffmanager'); ?>" class="fmffmanager-top-iconed-link fmffmanager-mobile-top-search-trigger"><i class="fmffmanager-icon fmffmanager-icon-search"></i></a>
	<?php do_action('fmffmanager_top_bar_before_actions'); ?>
	
	<a href="<?php echo $settings_link; ?>" title="<?php _e('Settings', 'fmffmanager'); ?>" class="fmffmanager-top-iconed-link fmffmanager-top-settings-trigger"><i class="fmffmanager-icon fmffmanager-icon-settings"></i></a>
	<?php do_action('fmffmanager_top_bar_after_actions'); ?>

	<a href="#" class="fmffmanager-top-new-appointment-btn fmffmanager-btn fmffmanager-btn-primary"  hidden >
		<i class="fmffmanager-icon fmffmanager-icon-plus"></i>
		<span><?php _e('New Enrollment', 'fmffmanager'); ?></span>
	</a>

	<div class="fmffmanager-top-user-info-w">
		<?php 
    if ( in_array($logged_in_admin_user_type, [fmffmanager_WP_ADMIN_ROLE, fmffmanager_WP_AGENT_ROLE] )) { ?>
      <div class="avatar-w" style="background-image: url('<?php echo $logged_in_user_avatar_url; ?>');"></div>
	  	<div class="fmffmanager-user-info-dropdown">
	  		<div class="fmffmanager-uid-head">
					<div class="uid-avatar-w">
						<div class="uid-avatar" style="background-image: url('<?php echo $logged_in_user_avatar_url; ?>');"></div>
					</div>
					<div class="uid-info">
			  		<h4><?php echo $logged_in_user_displayname; ?></h4>
			  		<h5><?php echo $logged_in_user_role; ?></h5>
					</div>
				</div>
				<?php do_action('fmffmanager_top_bar_mobile_after_user'); ?>
	  		<ul>
	  			<li>
	  				<a href="<?php echo $settings_link; ?>">
		  				<i class="fmffmanager-icon fmffmanager-icon-ui-46"></i>
		  				<span><?php _e('Settings', 'fmffmanager'); ?></span>
		  			</a>
		  		</li>
	  			<li>
	  				<a href="<?php echo wp_logout_url(); ?>">
		  				<i class="fmffmanager-icon fmffmanager-icon-log-in"></i>
		  				<span><?php _e('Logout', 'fmffmanager'); ?></span>
	  				</a>
	  			</li>
	  		</ul>
	  	</div>
	  	<?php 
    } ?>
	</div>
</div>