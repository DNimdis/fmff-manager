<?php 
class SmSettingsModel extends SmModel
{

    var $id,
        $name,
        $value,
        $created_at,
        $updated_at;


  function __construct($id = false){
    parent::__construct();
    $this->table_name = FMFF_MANAGER_TABLE_SETTINGS;
    $this->nice_names = array();

    if($id){
      $this->load_by_id($id);
    }
  }


  public function load_by_name($name){
    $setting = $this->where(array('name' => $name))->set_limit(1)->get_results_as_models();
    
    return $setting;
  }


  protected function allowed_params($role = 'admin'){
    $allowed_params = array('name',
                            'value');
    return $allowed_params;
  }
  
  protected function params_to_save($role = 'admin'){
    $params_to_save = array('name',
                            'value');
    return $params_to_save;
  }

  protected function properties_to_validate(){
    $validations = array(
      'name' => array('presence'),
    );
    return $validations;
  }

    
}
