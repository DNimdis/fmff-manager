<?php

class SmDatabaseHelper {

  public static function run_setup(){
		self::run_version_specific_updates();
		self::install_database();
	}


    public static function check_db_version(){
        $current_db_version = get_option('fmff_manager_db_version');  
        if(!$current_db_version) return false;
        if(version_compare(FMFF_MANAGER_DB_VERSION, $current_db_version)){
          self::install_database();
        }
    }

    public static function install_database(){
        $sqls = self::get_initial_table_queries();
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        foreach($sqls as $sql){
          error_log(print_r(dbDelta( $sql ), true));
        }
        
        //self::run_version_specific_updates();
        update_option( 'fmff_manager_db_version', FMFF_MANAGER_DB_VERSION );
    }


    public static function get_initial_table_queries(){

        global $wpdb;
    
        $charset_collate = $wpdb->get_charset_collate();
    
        $sqls = [];

        $sqls[] = "CREATE TABLE ".FMFF_MANAGER_TABLE_SETTINGS." (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            name varchar(110) NOT NULL,
            value text,
            created_at datetime,
            updated_at datetime,
            KEY name_index (name),
            PRIMARY KEY  (id)            
          ) $charset_collate;";

          return $sqls;
        
    }

   
    public static function run_version_specific_updates(){
      $current_db_version = get_option('latepoint_db_version');
      if(!$current_db_version) return false;
      
      return true;
    }
  
    public static function run_queries($sqls){
      global $wpdb;
      if($sqls && is_array($sqls)){
        foreach($sqls as $sql){
          $wpdb->query($sql);
          OsDebugHelper::log($sql);
        }
      }
    }



}

