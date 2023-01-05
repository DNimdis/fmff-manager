<?php
if (!defined('ABSPATH')) {
  exit; // Exit if accessed directly.
}


class SmHomeController extends SmController
{

  
  function __construct(){
    parent::__construct();
    
    $this->views_folder = FMFF_MANAGER_VIEWS_ABSPATH . 'home/';
  }


    public function index()
    {
        # code...
        $this->vars['breadcrumbs'][] = array('label' => __('Test', 'stripe_manager'), 'link' => false);

        error_log("Si llego ***");



        $this->format_render(__FUNCTION__);
    }

}