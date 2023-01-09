<div class="fmffmanager-side-menu-w">
	<div class="side-menu-top-part-w">
		<div >
			<a href="<?php echo SmRouterHelper::build_link(['dashboard', 'index']); ?>" >
				<img src="https://fmff.mx/wp-content/uploads/2020/10/cropped-fmff.png" alt="logo" style="height: 6em; padding:4px; margin-top:0px; margin-left:35px;" >
			</a>
		</div>
	</div>
	
	<!--<div class="back-to-wp-link-w">
		<a class="back-to-wp-link" href="<?php echo get_admin_url(); ?>">
			<i class="fmffmanager-icon fmffmanager-icon-arrow-left"></i>
			<span><?php _e('To WordPress', 'fmffmanager'); ?></span>
		</a>
	</div>-->
	
	<ul class="side-menu">
    <?php 
		foreach(SmMenuHelper::get_side_menu_items() as $menu_item){
			if(empty($menu_item['label'])){
				if(isset($menu_item['small_label'])){
					echo '<li class="menu-spacer with-label"><span>'.$menu_item['small_label'].'<span></li>';
				}else{
					echo '<li class="menu-spacer"></li>';
				}
				continue;
			} 
			$sub_menu_html = '';
			$is_active = SmRouterHelper::link_has_route($route_name, $menu_item['link']);


			if(isset($menu_item['children'])){ 
				$sub_menu_html.= '<ul class="side-sub-menu">';
				$sub_menu_html.= '<li class="side-sub-menu-header">'.$menu_item['label'].'</li>';
				foreach($menu_item['children'] as $child_menu_item){
					if(SmRouterHelper::link_has_route($route_name, $child_menu_item['link'])){
						$is_active = true;
						$sub_item_active_class = 'sub-item-is-active';
					}else{
						$sub_item_active_class = '';
					}
					$highlight_class = (isset($child_menu_item['show_notice']) && $child_menu_item['show_notice']) ? ' fmffmanager-show-notice ' : '';
					$sub_menu_html.= '<li class="'.$highlight_class.$sub_item_active_class.'"><a href="'.$child_menu_item['link'].'"><span>'.$child_menu_item['label'].'</span></a></li>';
				}
				$sub_menu_html.= '</ul>';
			}else{
				$sub_menu_html.= '<ul class="side-sub-menu only-menu-header">';
				$sub_menu_html.= '<li class="side-sub-menu-header">'.$menu_item['label'].'</li>';
				$sub_menu_html.= '</ul>';
			}
			?>
			<li class="<?php if(isset($menu_item['show_notice']) && $menu_item['show_notice']) echo ' fmffmanager-show-notice ' ;?><?php if(isset($menu_item['children'])) echo ' has-children'; ?><?php if($is_active) echo ' menu-item-is-active'; ?>">
				<a href="<?php echo $menu_item['link']; ?>">
					<i class="<?php echo $menu_item['icon']; ?>"></i>
					<span><?php echo $menu_item['label']; ?></span>
				</a>
				<?php echo $sub_menu_html; ?>
			</li>
		<?php } ?>
	</ul>
</div>
