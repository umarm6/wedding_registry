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
function activate_registry() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-registry-activator.php';
	Registry_Activator::activate();

// Create Page  Wedding_gift_registry

     
global $wpdb;
$prefix= $wpdb->prefix;
$table = $prefix."wedding_registry_registry";

    if(!$table){

    $schema = "  CREATE TABLE  $table (
        reg_id INT(11) NOT NULL AUTO_INCREMENT , 
        bride_FirstName VARCHAR(255) NOT NULL , 
        bride_LastName VARCHAR(255) NOT NULL , 
        groom_FirstName VARCHAR(255) NOT NULL , 
        groom_LastName VARCHAR(255) NOT NULL , 
        date VARCHAR(255) NOT NULL , 
        Address VARCHAR(255) NOT NULL , 
        city VARCHAR(255) NOT NULL , 
        state VARCHAR(255) NOT NULL , 
        zip INT(255) NOT NULL ,
        backgroundimg VARCHAR(255) NOT NULL ,
        descriptions text,
        PRIMARY KEY (reg_id));";
            $wpdb->query($schema);
            
 
    if (!function_exists('wc_create_page'))  {
    include_once dirname ( __DIR__ ) . '/woocommerce/includes/admin/wc-admin-functions.php';
    }
    require_once plugin_dir_path( __FILE__ ) . 'public/index.php';

    $pages =  array (
    'giftregistry' => array (
        'name'    => _x ( 'wedding-giftregistry', 'Page slug', 'woocommerce' ),
        'title'   => _x ( 'Wedding Gift Registry', 'Page title', 'woocommerce' ),
        'content' => do_shortcode('[wedding_giftregistry]')
            )
    );


    foreach ( $pages as $key => $page ) {
    wc_create_page ( esc_sql ( $page ['name'] ), 'follow_up_email' . $key . '_page_id', $page ['title'], $page ['content'], ! empty ( $page ['parent'] ) ? wc_get_page_id ( $page ['parent'] ) : '' );
    }
            
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



 // Includess
 require plugin_dir_path( __FILE__ ) . 'admin/index.php';
 

