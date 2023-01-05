<?php
if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly.
}


if ( ! class_exists( 'SmSettingsController' ) ) :


  class SmSettingsController extends SmController {
    
    function __construct(){
      parent::__construct();
      $this->views_folder = FMFF_MANAGER_VIEWS_ABSPATH . 'settings/';    
    }


    public function save_variables(){

      

      error_log(  wp_json_encode( $this->params['settings'] ) );

      if($this->params['settings']){
        foreach($this->params['settings'] as $setting_name => $setting_value){

          /*$setting = new OsSettingsModel();
          $setting = $setting->load_by_name($setting_name);
          $setting->name = $setting_name;
          $setting->value = OsSettingsHelper::prepare_value($setting_name, $setting_value);*/

          $setting = SmSettingsHelper::save_setting_by_name( $setting_name , $setting_value );


          /*if($setting ){
            $settings_saved = true;
          }else{
            $settings_saved = false;
            $errors[] = $setting->get_error_messages();
          }*/

        }
      }

      //$bookingAttendies->set_data($attendie_params);

      $response_html = __('Settings Updated', 'latepoint');
      $status = LATEPOINT_STATUS_SUCCESS;

      if($this->get_return_format() == 'json'){
        $this->send_json(array('status' => $status, 'message' => $response_html));
      }
    }

   


    public function update(){
      
      $args = $this->params['settings'];
      $args = array_merge( 
        array(
            'name'=>"",
            'number'=>"",
            'exp_month'=>"",
            'exp_year'=>"",
            'cvc'=>"",
            'currency'=>"USD"
        ), 
        $args);
        
        $params_to_card =  array(
            'source[name]'=> $args['name'],                    
            'source[number]' => $args['number'],
            'source[exp_month]'=> $args['exp_month'],
            'source[exp_year]'=> $args['exp_year'],
            'source[cvc]'=> $args['cvc'],
            'source[currency]'=> $args['currency'],
        );

        
        $customer = array_merge(
            array(
                'customer_id'=>''
            ),
            $this->params['customer']
        );

        try {

            
            $card = SmPaymentsStripeHelper::create_card( $params_to_card,  $customer['customer_id'] );
            
            SmPaymentsStripeHelper::define_default_payment_method( 
                array(  'invoice_settings[default_payment_method]' => $card->id), 
                $customer['customer_id']
            );
            
            $response_html = __('The card has been successfully registered', 'latepoint');
            $status = FMFF_MANAGER_STATUS_SUCCESS;

        } catch (\Stripe\Exception\CardException $e ) {
            
            error_log("Error --->");
            error_log( wp_json_encode( $e->getError()->message  )  );
            $response_html = $e->getError()->message;
            $status = FMFF_MANAGER_STATUS_ERROR;
        }

      if($this->get_return_format() == 'json'){
        $this->send_json(array('status' => $status, 'message' => $response_html));
      }

    }
    

  }


endif;