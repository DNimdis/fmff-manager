<?php
if (!defined('ABSPATH')) {
  exit; // Exit if accessed directly.
}


class SmHomeController extends SmController
{

  
  function __construct(){
    parent::__construct();
    
    $this->views_folder = FMFF_MANAGER_VIEWS_ABSPATH . 'home/';
    $this->vars['page_header'] = __('Dashboard', 'latepoint');

  }


    public function index()
    {
        # code...
        //$this->vars['breadcrumbs'][] = array('label' => __('Test', 'fmffmanager'), 'link' => false);

        $this->vars['page_header'] = false;


        $this->vars['widget_stats']="";
        $this->set_layout('admin');

        $this->format_render(__FUNCTION__);
    }


    public function ruf_prueba()
    {
      # code...

      error_log(  wp_json_encode( $this->params ) );

      $response_html = __('Settings Updated', 'latepoint');
      $status = FMFF_MANAGER_STATUS_SUCCESS;

      if($this->get_return_format() == 'json'){
        $this->send_json(array('status' => $status, 'message' => $response_html));
      }

    }

}