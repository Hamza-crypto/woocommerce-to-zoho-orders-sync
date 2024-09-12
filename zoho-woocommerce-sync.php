<?php
/*
Plugin Name: WooCommerce Zoho Sync
Description: Sync WooCommerce products and orders with Zoho CRM.
Version: 1.0
Author: Hamza Siddique
*/

defined('ABSPATH') or die('No script kiddies please!');


use Monolog\Logger;
use Monolog\Handler\StreamHandler;

require_once plugin_dir_path(__FILE__) . 'vendor/autoload.php';


// Include necessary files
include_once plugin_dir_path(__FILE__) . 'wp/class/db-handler.php';
include_once plugin_dir_path(__FILE__) . 'wp/class/product-sync.php';
include_once plugin_dir_path(__FILE__) . 'wp/class/order-sync.php';
include_once plugin_dir_path(__FILE__) . 'zoho/api-handler.php';
include_once plugin_dir_path(__FILE__) . 'wp/class/cron-handler.php';

// Activation and Deactivation hooks
register_activation_hook(__FILE__, 'zoho_woocommerce_sync_activate');
register_deactivation_hook(__FILE__, 'zoho_woocommerce_sync_deactivate');

// Plugin activation function
function zoho_woocommerce_sync_activate()
{
    // Create necessary database tables
    DB_Handler::create_tables();

    // Schedule cron jobs
    Cron_Handler::schedule_sync();
}

// Plugin deactivation function
function zoho_woocommerce_sync_deactivate()
{
    // Remove scheduled cron jobs
    Cron_Handler::unschedule_sync();
}