<?php
class SmController {

  protected $params,
  $layout = 'admin',
  $views_folder = FMFF_MANAGER_VIEWS_ABSPATH,
  $return_format = 'html',
  $extra_css_classes = array('fmffmanager');

  public $action_access = [
                          'customer' => [], 
                          'public' => [], 
                          'agent' => []
                        ];

  public $vars;

  public $route_name;

  public function can_user_type_view_route($action, $user_type){
    $allow_access = false;
    switch($user_type){
      case 'admin':
        $allow_access = true;
      break;
      case 'agent':
        $allow_access = true;
      break;
      case 'customer':
        $allow_access = (in_array($action, $this->action_access['customer']) || in_array($action, $this->action_access['public']));
      break;
      default:
        $allow_access = in_array($action, $this->action_access['public']);
      break;
    }
    return $allow_access;
  }

  function generate_css_class($view_name){
    $class_name_filtered = strtolower(preg_replace('/^Sm(\w+)Controller/i', '$1', static::class));
    return "stripe-manager-view-{$class_name_filtered}-{$view_name}";
  }

  function __construct(){
    $this->params = $this->get_params();
    $this->set_layout($this->layout);
    $this->vars['page_header'] = __('Enrollments', 'fmffmanager');
    $this->vars['breadcrumbs'][] = array('label' => __('Dashboard', 'latepoint'), 'link' => SmRouterHelper::build_link(SmRouterHelper::build_route_name('home', 'index') ));

  }

  public function access_not_allowed(){
    $this->format_render(__FUNCTION__, [], [], true);
    exit();
  }

  function format_render($view_name, $extra_vars = array(), $json_return_vars = array(), $from_shared_folder = false){
    
    echo $this->format_render_return($view_name, $extra_vars, $json_return_vars, $from_shared_folder);
  }

  // You can pass array to $view_name, ['json_view_name' => ..., 'html_view_name' => ...]
  function format_render_return($view_name, $extra_vars = array(), $json_return_vars = array(), $from_shared_folder = false){
    error_log($this->get_layout());

    $html = '';
    if($this->get_return_format() == 'json'){
      if(is_array($view_name)) $view_name = $view_name['json_view_name'];
      $response_html = $this->render($this->get_view_uri($view_name, $from_shared_folder), 'none', $extra_vars);
      $this->send_json(array_merge(array('status' => FMFF_MANAGER_STATUS_SUCCESS, 'message' => $response_html), $json_return_vars));
    }else{
      if(is_array($view_name)) $view_name = $view_name['html_view_name'];
      $this->extra_css_classes[] = $this->generate_css_class($view_name);
      $this->vars['extra_css_classes'] = $this->extra_css_classes;
      $html = $this->render($this->get_view_uri($view_name, $from_shared_folder), $this->get_layout(), $extra_vars);
    }
    return $html;
  }

  function set_layout($layout = 'admin'){
    if(isset($this->params['layout'])){
      $this->layout = $this->params['layout'];
    }else{
      $this->layout = $layout;
    }
  }

  function get_layout(){
    return $this->layout;
  }

  function set_return_format($format = 'html'){
    $this->return_format = $format;
  }

  function get_return_format(){
    return $this->return_format;
  }

  protected function send_json($data, $status_code = null){
    wp_send_json($data, $status_code);
  }

  function get_view_uri($view_name, $from_shared_folder = false){
    if($from_shared_folder){
        error_log("Hooooooooooo!!!!");
      $view_uri = FMFF_MANAGER_VIEWS_ABSPATH_SHARED.$view_name.'.php';
    }else{
      $view_uri = $this->views_folder.$view_name.'.php';
      error_log("Uri de salida =>".$view_uri);
    }
    return $view_uri;
  }

  // render view and if needed layout, when layout is rendered - view variable is passed to a layout file
  function render($view, $layout = 'none', $extra_vars = array()){
    error_log("Veamos el layout ==>".$layout);
    $this->vars['route_name'] = $this->route_name;
    extract($extra_vars);
    extract($this->vars);
    ob_start();
    if($layout != 'none'){

      // rendering layout, view variable will be passed and used in layout file
      include FMFF_MANAGER_VIEWS_LAYOUTS_ABSPATH . $this->add_extension($layout, '.php');
    }else{
      include $this->add_extension($view, '.php');
    }
    $response_html = ob_get_clean();
    return $response_html;
  }

  /*
    Adds extension to a file string if its missing
  */
  function add_extension($string = '', $extension = '.php'){
    if(substr($string, -strlen($extension))===$extension) return $string;
    else return $string.$extension;
  }

  function get_params(){
    return SmParamsHelper::get_params();
  }
}