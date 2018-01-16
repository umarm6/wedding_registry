<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              mohamedumar.com
 * @since             1.0.0
 * @package           Registry
 *
 * @wordpress-plugin
 * Plugin Name:       Registry
 * Plugin URI:        mohamedumar.com/Registry
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Mohamed Umar
 * Author URI:        mohamedumar.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       registry
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently pligin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PLUGIN_NAME_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-registry-activator.php
 */


     // Includes

    require_once plugin_dir_path( __FILE__ ) . 'index.php';      
    require_once plugin_dir_path( __FILE__ ) . 'admin/index.php';
    require_once plugin_dir_path( __FILE__ ) . 'public/index.php';
    

    function run(){

        MetaQueries::search_Query();

    } 
    function activate_registry() {
        require_once plugin_dir_path( __FILE__ ) . 'includes/class-registry-activator.php';
        Registry_Activator::activate();

    // Create Page  Wedding_gift_registry
    
        
    global $wpdb;
    $prefix= $wpdb->prefix;
    $table = $prefix."wedding_registry_wishlists";

    
    
    $query2 = "CREATE TABLE IF NOT EXISTS `{$prefix}wedding_registry_item` (
            `id` INT(11) NOT NULL AUTO_INCREMENT , 
            `wish_id` VARCHAR(255) NOT NULL , 
            `product` VARCHAR(255) NOT NULL , 
            `product_id` VARCHAR(255) NOT NULL ,
             `order_id` VARCHAR(255) NOT NULL , 
             `quantity` INT(11) NOT NULL , 
             `received_qty` INT(11) NOT NULL ,
              `received_order` VARCHAR(255) NOT NULL , 
              `variation_id` VARCHAR(255) NOT NULL , 
              `variation` INT(11) NOT NULL , 
              `cart_item_data` TEXT NOT NULL ,
               `description` VARCHAR(255) NOT NULL ,
                `info_request` TEXT NOT NULL ,
                 `added_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
                 PRIMARY KEY (`id`)
                 ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

$wpdb->query($query2);


    $query = "CREATE TABLE IF NOT EXISTS `{$prefix}wedding_registry_wishlists` (
        `id` int(11) unsigned NOT NULL auto_increment,
        `wpuser_id` varchar (255)  NOT NULL,  
        `title` VARCHAR(250)  NULL,
        `goorm_firstname` VARCHAR(250)  NULL,
        `goorm_lastname` VARCHAR(250)  NULL,
        `goorm_email` VARCHAR(250)  NULL,
        `goorm_mobile` VARCHAR(250)  NULL,
        `goorm_image` INT(11) NULL,
        `goorm_desscription` TEXT NULL,
        
        `bride_firstname` VARCHAR(250)  NULL,
        `bride_lastname` VARCHAR(250)  NULL,
        `bride_email` VARCHAR(250)  NULL,
        `bride_mobile` VARCHAR(250)  NULL, 
        `bride_image` INT(11) NULL,
        `bride_desscription` TEXT NULL,
        
        `event_date_time` DATETIME  NULL,
        `event_location` VARCHAR(250)  NULL,
        `message` text null,
        `background_image` varchar (255)   NULL, 
        `sharing_code` varchar (255)  NOT NULL,
        `shared` tinyint  NOT NULL,
        `status` VARCHAR(50) NOT NULL,
        `created_at` timestamp NULL,
        `update_at` timestamp NULL, 
        PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

        $wpdb->query($query);
  
        // $schema = "CREATE TABLE IF NOT EXISTS  $table (
        //     reg_id INT(11) NOT NULL AUTO_INCREMENT , 
        //     bride_FirstName VARCHAR(255) NOT NULL , 
        //     bride_LastName VARCHAR(255) NOT NULL , 
        //     groom_FirstName VARCHAR(255) NOT NULL , 
        //     groom_LastName VARCHAR(255) NOT NULL , 
        //     date VARCHAR(255) NOT NULL , 
        //     Address VARCHAR(255) NOT NULL , 
        //     city VARCHAR(255) NOT NULL , 
        //     state VARCHAR(255) NOT NULL , 
        //     zip INT(255) NOT NULL ,
        //     backgroundimg VARCHAR(255) NOT NULL ,
        //     descriptions text,
        //     PRIMARY KEY (reg_id));";
        //         $wpdb->query($schema);
                
    
        if (!function_exists('wc_create_page'))  {
        include_once dirname ( __DIR__ ) . '/woocommerce/includes/admin/wc-admin-functions.php';
        }
        
        
        $pages =  array (
        'giftregistry' => array (
            'name'    => _x ( 'wedding-giftregistry', 'Page slug', 'woocommerce' ),
            'title'   => _x ( 'Wedding Gift Registry', 'Page title', 'woocommerce' ),
            'content' =>'[wedding_giftregistry]'
                )
        );


        foreach ( $pages as $key => $page ) {
        wc_create_page ( esc_sql ( $page ['name'] ), 'follow_up_email' . $key . '_page_id', $page ['title'], $page ['content'], ! empty ( $page ['parent'] ) ? wc_get_page_id ( $page ['parent'] ) : '' );
        }
                
    
    }

    /**
     * The code that runs during plugin deactivation.
     * This action is documented in includes/class-registry-deactivator.php
     */
    function deactivate_registry() {
        require_once plugin_dir_path( __FILE__ ) . 'includes/class-registry-deactivator.php';
        Registry_Deactivator::deactivate();
    }

    register_activation_hook( __FILE__, 'activate_registry' );
    register_deactivation_hook( __FILE__, 'deactivate_registry' );

    /**
     * The core plugin class that is used to define internationalization,
     * admin-specific hooks, and public-facing site hooks.
     */
    require plugin_dir_path( __FILE__ ) . 'includes/class-registry.php';

    /**
     * Begins execution of the plugin.
     *
     * Since everything within the plugin is registered via hooks,
     * then kicking off the plugin from this point in the file does
     * not affect the page life cycle.
     *
     * @since    1.0.0
     */
    


    

 