<?php 

class SmPaymentsStripeHelper {
  public static $processor_name = 'stripe';
  public static $default_currency_iso_code = 'usd';

  public static $stripe = false;


	public static function get_publishable_key(){
		return SmSettingsHelper::get_settings_value('stripe_publishable_key', '');
	}

	public static function get_secret_key(){
		return SmSettingsHelper::get_settings_value('stripe_secret_key');
	}

	public static function set_api_key(){
		if(self::get_secret_key()){
      //error_log("key: ".self::get_secret_key());
	    self::$stripe = new \Stripe\StripeClient(self::get_secret_key());
		}
	}

  public static function get_customer($stripe_customer_id){
    $stripe_customer = self::$stripe->customers->retrieve($stripe_customer_id);
    return $stripe_customer;
  }

	public static function create_customer($customer){
      $stripe_customer = self::$stripe->customers->create([
          'email' => $customer->email,
          'name' => $customer->full_name
      ]);
      return $stripe_customer;
  }

  public static function load_countries_list(){
  	$country_codes = ['AU' => 'Australia',
                      'AT' => 'Austria',
                      'BE' => 'Belgium',
                      'BR' => 'Brazil',
                      'CA' => 'Canada',
                      'DK' => 'Denmark',
                      'EE' => 'Estonia',
                      'FI' => 'Finland',
                      'FR' => 'France',
                      'DE' => 'Germany',
                      'GR' => 'Greece',
                      'HK' => 'Hong Kong',
                      'IN' => 'India',
                      'IE' => 'Ireland',
                      'IT' => 'Italy',
                      'JP' => 'Japan',
                      'LV' => 'Latvia',
                      'LT' => 'Lithuania',
                      'LU' => 'Luxembourg',
                      'MY' => 'Malaysia',
                      'MX' => 'Mexico',
                      'NL' => 'Netherlands',
                      'NZ' => 'New Zealand',
                      'NO' => 'Norway',
                      'PL' => 'Poland',
                      'PT' => 'Portugal',
                      'RO' => 'Romania',
                      'SG' => 'Singapore',
                      'SK' => 'Slovakia',
                      'SI' => 'Slovenia',
                      'ES' => 'Spain',
                      'SE' => 'Sweden',
                      'CH' => 'Switzerland',
                      'GB' => 'United Kingdom',
                      'US' => 'United States'];
  	return $country_codes;
  }


  public static function load_payment_list( $customer_key, $type="card" )
  {
    $payments_customer = self::$stripe->paymentMethods->all([
      'customer' => $customer_key,
      'type' => $type,
    ]);

    return $payments_customer;    
  }
  
  public static function find_customer( $args = array() ) {
      $args = array_merge( 
        array(
            'email' =>""            
        ), 
        $args);
        $payments_customer = self::$stripe->customers->all($args);  
      
        return $payments_customer;   
  }

  public static function generate_portal_session( $customer )
  {
    
   $session =  self::$stripe->billingPortal->sessions->create([
      'customer' => $customer,
      'return_url' => 'https://sandbox.bilingualbirdies.com/my-account-2/',
    ]);
    
    return $session;
  }

  public static function create_card( $args = array(), $customer_id = ""  )
  {
    
    $args = array_merge( 
      array(

        'source[name]'=>'',        
        'source[object]' => "card",
        'source[number]' => 0,
        'source[exp_month]'=>0,
        'source[exp_year]'=>0,
        'source[cvc]'=>0,
        'source[currency]'=>"USD",
      ), 
      $args);

    $result = self::$stripe->customers->createSource(
      $customer_id,
      $args
    );

    return $result;

  }

  public static function define_default_payment_method( $args = array(), $customer_id = ""  )
  {
    
    $args = array_merge( 
      array(
        'invoice_settings[default_payment_method]'=>'',        
      ), 
      $args);

    $result = self::$stripe->customers->update(
      $customer_id,
      $args
    );

    return $result;

  }

  public static function findTrxFromStripe( $trxString ){    
    try {
      //code...
      $result =  self::$stripe->paymentIntents->retrieve(
         $trxString,
         []
       );
       return $result;
    } catch (Exception $th) {
      //throw $th;
      error_log("error:".wp_json_encode($th));
      return false;
    }
 
  }

  public static function findBalanceTransactions( $trxString ){
      
    try {
      
      $result =  self::$stripe->balanceTransactions->retrieve(
         $trxString,
         []
       );
       return $result;
    } catch (Exception $th) {      
      error_log("error:".wp_json_encode($th));
      return false;
    }
 
  }

  public static function getAllPayments($customer, $start_date, $end_date){
    try {
      
      $result =  self::$stripe->charges->all([
        'customer' => $customer,
        'created[gte]' => strtotime($start_date),
        'created[lte]' => strtotime($end_date)
      ]);
       return $result;
    } catch (Exception $th) {      
      error_log("error:".wp_json_encode($th));
      return false;
    }
  }


}
