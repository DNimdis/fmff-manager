<?php 

class SmSettingsHelper {
  
  public static $loaded_values;

  private static $encrypted_settings = [
                                        'stripe_publishable_key',
                                        'stripe_secret_key',
                                        ];

  public static function get_encrypted_settings(){
    $encrypted_settings = apply_filters('latepoint_encrypted_settings', self::$encrypted_settings);
    return $encrypted_settings;
  }


  public static function remove_setting_by_name($name){
    $settings_model = new SmSettingsModel();
    $settings_model = $settings_model->delete_where(array('name' => $name));
  }

  public static function save_setting_by_name($name, $value){
    $settings_model = new SmSettingsModel();
    $settings_model = $settings_model->where(array('name' => $name))->set_limit(1)->get_results_as_models();
    if($settings_model){
      $settings_model->value = self::prepare_value($name, $value);
    }else{
      $settings_model = new SmSettingsModel();
      $settings_model->name = $name;
      $settings_model->value = self::prepare_value($name, $value);
    }
    unset(self::$loaded_values[$name]);
    return $settings_model->save();
  }

  public static function prepare_value($name, $value){
    if(in_array($name, self::get_encrypted_settings())){
      $value = self::encrypt_value($value);
    }
    return $value;
  }

  public static function get_settings_value($name, $default = false){
    if(isset(self::$loaded_values[$name])) return self::$loaded_values[$name];
    $settings_model = new SmSettingsModel();
    $settings_model = $settings_model->where(array('name' => $name))->set_limit(1)->get_results_as_models();
    if($settings_model){
      if(in_array($name, self::get_encrypted_settings())){
        $value = self::decrypt_value($settings_model->value);
      }else{
        $value = $settings_model->value;
      }
    }else{
      $value = $default;
    }
    self::$loaded_values[$name] = $value;
    return self::$loaded_values[$name];
  }

  public static function encrypt_value($value){
    return openssl_encrypt($value, 'aes-256-ecb', FMFF_MANAGER_ENCRYPTION_KEY);
  }
  
  public static function decrypt_value($value){
    return openssl_decrypt($value, 'aes-256-ecb', FMFF_MANAGER_ENCRYPTION_KEY);
  }

  public static function is_env_dev(){
    return (FMFF_MANAGER_ENV == FMFF_MANAGER_ENV_DEV);
  }

}

?>