<?php

class Cron_Handler {

	/**
	 * Schedule the cron job to sync WooCommerce with Zoho CRM
	 */
	public static function schedule_sync() {
		if ( ! wp_next_scheduled( 'zoho_woocommerce_sync_event' ) ) {
			wp_schedule_event( time(), 'hourly', 'zoho_woocommerce_sync_event' );
		}
	}

	/**
	 * Unschedule the cron job when the plugin is deactivated
	 */
	public static function unschedule_sync() {
		$timestamp = wp_next_scheduled( 'zoho_woocommerce_sync_event' );
		if ( $timestamp ) {
			wp_unschedule_event( $timestamp, 'zoho_woocommerce_sync_event' );
		}
	}

	/**
	 * The function that will be hooked to the cron event
	 */
	public static function perform_sync() {
		// Sync Products
		Product_Sync::sync_products_to_zoho();

		// Sync Orders
		Order_Sync::sync_orders_to_zoho();
	}
}

// Schedule the sync when plugin is activated
register_activation_hook( __FILE__, array( 'Cron_Handler', 'schedule_sync' ) );

// Unschedule the sync when plugin is deactivated
register_deactivation_hook( __FILE__, array( 'Cron_Handler', 'unschedule_sync' ) );

// Hook the sync function to the cron event
add_action( 'zoho_woocommerce_sync_event', array( 'Cron_Handler', 'perform_sync' ) );
