<?php 

class SmMenuHelper {

  public static function get_menu_items_by_id($query){
    $menus = self::get_side_menu_items();
    foreach($menus as $menu_item){
      if(isset($menu_item['id']) && $menu_item['id'] == $query && isset($menu_item['children'])) return $menu_item['children'];
    }
    return false;
  }

  public static function get_side_menu_items() {

      // ---------------
      // ADMINISTRATOR MENU
      // ---------------
      $menus = array(
        array( 'id' => 'dashboard', 'label' => __( 'Dashboard', 'latepoint' ), 'icon' => 'latepoint-icon latepoint-icon-box', 'link' => SmRouterHelper::build_link(['home', 'index'])),
        array( 'id' => 'calendar', 'label' => __( 'Calendario', 'latepoint' ), 'icon' => 'latepoint-icon latepoint-icon-calendar', 'link' => SmRouterHelper::build_link(['calendars', 'daily_agents']),
          'children' => array(
            array('label' => __( 'Daily View', 'latepoint' ), 'icon' => '', 'link' => SmRouterHelper::build_link(['calendars', 'daily_agents'])),
            array('label' => __( 'Weekly Calendar', 'latepoint' ), 'icon' => '', 'link' => SmRouterHelper::build_link(['calendars', 'weekly_agent'])),
            array('label' => __( 'Monthly View', 'latepoint' ), 'icon' => '', 'link' => SmRouterHelper::build_link(['calendars', 'monthly_agents'])),
          )
        ),
        array('label' => '', 'small_label' => __('Records', 'latepoint'), 'menu_section' => 'records'),
        // array( 'label' => __( 'Appearance', 'latepoint' ), 'icon' => 'latepoint-icon latepoint-icon-sliders', 'link' => SmRouterHelper::build_link(['appearance', 'index'])),
        array(  'label' => __( 'Metricas', 'latepoint' ), 'icon' => 'latepoint-icon latepoint-icon-sliders', 'link' => SmRouterHelper::build_link(['schools', 'index'])),
      );

$menus = apply_filters('fmffmanager_side_menu', $menus);
return $menus;
}

}