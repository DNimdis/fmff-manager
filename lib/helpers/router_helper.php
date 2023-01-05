<?php 



class SmRouterHelper {

    public static function call_by_route_name($route_name, $return_format = 'html'){
        list($controller_name, $action) = explode('__', $route_name);
        $controller_name = str_replace('_', '', ucwords($controller_name, '_'));
        $controller_class_name = 'Sm'.$controller_name.'Controller';

        error_log(wp_json_encode( $controller_class_name ) );    
        error_log(wp_json_encode( $action ));
        
        if(class_exists($controller_class_name)){
            $controller_obj = new $controller_class_name();
            if($return_format) $controller_obj->set_return_format($return_format);
            if(method_exists($controller_obj, $action)){
                                    
                $controller_obj->route_name = $route_name;
                $controller_obj->$action();
            
            }else{
            _e('Page Not Found', 'latepoint');
            }
        }else{
            _e('Page Not Found', 'latepoint');
        }
    }

    public static function build_link($route, $params = array()){
        $params_query = '';
        if($params){
          $params_query = '&'.http_build_query($params);
        }
        if(is_array($route) && (count($route) == 2)) $route = SmRouterHelper::build_route_name($route[0], $route[1]);
        return admin_url('admin.php?page=stripe_manager&route_name='.$route.$params_query);
    }

    public static function build_route_name($controller, $action){
        return $controller.'__'.$action;
    }
    
    public static function get_request_param($name, $default = false){
        if(isset($_GET[$name])){
            $param = stripslashes_deep($_GET[$name]);
        }elseif(isset($_POST[$name])){
            $param = stripslashes_deep($_POST[$name]);
        }else{
            $param = $default;
        }
        return $param;
    }

      
}
