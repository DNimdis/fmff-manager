<?php

/**
 * Plugin Name: FMFF Manager
 * Description: Plugin administrativo a medida para la federacion
 * Version: 1.0.0
 * Author: Dalvik   
 */


if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}


class FMFFManager 
{

    public $version = '1.0.0';
    public $db_version = '1.0.0';

    public function __construct() {

        $this->define_constants();
        $this->includes();
        $this->init_hooks();
        SmDatabaseHelper::check_db_version();

    }


    /**
     * Define constant if not already set.
     *
     */
    public function define( $name, $value ) {
        if ( ! defined( $name ) ) {
        define( $name, $value );
        }
    }

    public static function public_javascripts() {
        return plugin_dir_url( __FILE__ ) . 'public/javascripts/';
    }

    public static function public_stylesheets() {
        return plugin_dir_url( __FILE__ ) . 'public/stylesheets/';
    }


    public function define_constants(){
        
        $this->define( 'FMFF_MANAGER_ENCRYPTION_KEY', 'catalyst(*Ufdsoh2ie7QEy,R@6(I9H/VoX^r4}SHC_7W-<$S!,/kd)OSw?.Y9lcd105cu$' );
        $this->define( 'FMFF_MANAGER_ABSPATH', dirname( __FILE__ ) . '/' );
        $this->define( 'FMFF_MANAGER_LIB_ABSPATH', FMFF_MANAGER_ABSPATH . 'lib/' );
        $this->define( 'FMFF_MANAGER_VIEWS_ABSPATH', FMFF_MANAGER_LIB_ABSPATH . 'views/' );
        $this->define( 'FMFF_MANAGER_VIEWS_ABSPATH_SHARED', FMFF_MANAGER_LIB_ABSPATH . 'views/shared/' );
        $this->define( 'FMFF_MANAGER_VIEWS_LAYOUTS_ABSPATH', FMFF_MANAGER_VIEWS_ABSPATH . 'layouts/' );

        $this->define( 'FMFF_MANAGER_STATUS_ERROR', 'error' );
        $this->define( 'FMFF_MANAGER_STATUS_SUCCESS', 'success' );
        $this->define( 'FMFF_MANAGER_DB_VERSION', $this->db_version );        
      
        global $wpdb;
        $this->define( 'FMFF_MANAGER_TABLE_SETTINGS', $wpdb->prefix . 'fmff_manager_settings');
        
    }


    public function includes() {

        // COMPOSER AUTOLOAD
        require (dirname( __FILE__ ) . '/vendor/autoload.php');

        // MODELS
        include_once( FMFF_MANAGER_ABSPATH . 'lib/models/model.php' );
        include_once( FMFF_MANAGER_ABSPATH . 'lib/models/settings_model.php' );

        // HELPERS
        include_once( FMFF_MANAGER_ABSPATH . 'lib/helpers/router_helper.php' );
        include_once( FMFF_MANAGER_ABSPATH . 'lib/helpers/database_helper.php' );
        include_once( FMFF_MANAGER_ABSPATH . 'lib/helpers/params_helper.php' );
        include_once( FMFF_MANAGER_ABSPATH . 'lib/helpers/shortcodes_helper.php' );
        include_once( FMFF_MANAGER_ABSPATH . '/lib/helpers/payments_stripe_helper.php' );
        include_once( FMFF_MANAGER_ABSPATH . 'lib/helpers/settings_helper.php' );

        // CONTROLLERS
        include_once( FMFF_MANAGER_ABSPATH . 'lib/controllers/controller.php' );
        include_once( FMFF_MANAGER_ABSPATH . 'lib/controllers/home_controller.php' );
        include_once( FMFF_MANAGER_ABSPATH . 'lib/controllers/settings_controller.php' );

    }


    public function init_hooks() {

        register_activation_hook( __FILE__, array($this, 'create_required_tables' ));
        register_activation_hook(__FILE__, array( $this, 'on_activate' ));
        register_deactivation_hook(__FILE__, [$this, 'on_deactivate']);

        add_action( 'init', array( $this, 'init' ), 0 );
        add_action( 'admin_menu', array( $this, 'init_menus' ) );

        add_action( 'wp_enqueue_scripts', array( $this, 'load_front_scripts_and_styles' ));
        add_action( 'admin_enqueue_scripts',  array( $this, 'load_admin_scripts_and_styles' ));

        // Create router action
        // ajax
        add_action( 'wp_ajax_fmff_manager_route_call', array( $this, 'route_call') );
        add_action( 'wp_ajax_nopriv_fmff_manager_route_call', array( $this, 'route_call') );       

        // admin custom post/get
        add_action( 'admin_post_fmff_manager_route_call', array( $this, 'route_call') );
        add_action( 'admin_post_nopriv_fmff_manager_route_call', array( $this, 'route_call') );

    }

    public function on_deactivate(){
        /*wp_clear_scheduled_hook('latepoint_send_reminders');
        wp_clear_scheduled_hook('latepoint_check_plugin_version');*/
    }

    function on_activate() {    
        //add_option('',  $this->db_version );
    }


    public function create_required_tables() {
        SmDatabaseHelper::run_setup();
    }


    public function init() {
        //if(SmPaymentsHelper::is_payment_processor_enabled($this->processor_code)) 
        SmPaymentsStripeHelper::set_api_key();
        $this->register_shortcodes();
    }
    


    function init_menus() {


        $capabilities="manage_options";
        $route_call_func = array( $this, 'route_call');

        // link for admins
        add_menu_page(
            __( ' ', 'fmffmanager' ),
            __( 'FMFFmanager', 'fmffmanager' ),
            $capabilities,
            'fmffmanager',
            $route_call_func,
            'none'
        );


    }


    /**
   * Register shortcodes
   */
    public function register_shortcodes() {
        add_shortcode( 'catalyst_fmff_manager_form', array('SmShortcodesHelper', 'shortcode_fmff_manager_form' ));
                    
    }


    public function route_call(){

        $route_name = SmRouterHelper::get_request_param('route_name', SmRouterHelper::build_route_name('home', 'index'));
        SmRouterHelper::call_by_route_name($route_name, SmRouterHelper::get_request_param('return_format', 'html'));
    }

    public function load_front_scripts_and_styles() {
        $localized_vars = array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) );   
        
        // Stylesheets
        wp_enqueue_style( 'stripe-manager-main',   $this->public_stylesheets() . 'main_font_end.css', false, $this->version );

        wp_enqueue_script( 'stripe-manager-main',  $this->public_javascripts() . 'fmff_manager_front.js', array('jquery'), $this->version );
                    
        wp_localize_script( 'stripe-manager-main', 'fmff_manager_helper', $localized_vars );
        //wp_enqueue_script( 'stripe-manager-main-front' );
    }

    public function load_admin_scripts_and_styles() {
    
        $localized_vars = array( 'ajaxurl' => admin_url( 'admin-ajax.php' ));   
        wp_enqueue_script( 'stripe-manager-main-back',     $this->public_javascripts() . 'main_back.js', ['jquery'], $this->version );         
        
        wp_localize_script('stripe-manager-main-back','fmff_manager_helper', $localized_vars );        
        
    }

}

$FMFF_MANAGER = new FMFFManager();
