<?php
/**
* Plugin Name:       WooCommerce Zoho Sync
* Description:       Sync WooCommerce products and orders with Zoho CRM.
* Version:           1.0.0
* Author:            Hamza Siddique
* Author URI:        https://www.upwork.com/freelancers/~01d452dc67bce01a15
* License:           GPL-2.0+
* License URI:       https://www.gnu.org/licenses/gpl-2.0.html
*/


defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


define( 'WZS_PREFIX', 'wzs_' );

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

require_once plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';


// Include necessary files
require_once plugin_dir_path( __FILE__ ) . 'wp/class/db-handler.php';
require_once plugin_dir_path( __FILE__ ) . 'wp/class/product-sync.php';
require_once plugin_dir_path( __FILE__ ) . 'wp/class/order-sync.php';
require_once plugin_dir_path( __FILE__ ) . 'zoho/api-handler.php';
require_once plugin_dir_path( __FILE__ ) . 'wp/class/cron-handler.php';

// Activation and Deactivation hooks
register_activation_hook( __FILE__, 'zoho_woocommerce_sync_activate' );
register_deactivation_hook( __FILE__, 'zoho_woocommerce_sync_deactivate' );


function wzs_zoho_woocommerce_sync_activate() {
	DB_Handler::create_tables();
	Cron_Handler::schedule_sync();
}


function zoho_woocommerce_sync_deactivate() {
	Cron_Handler::unschedule_sync();
}
