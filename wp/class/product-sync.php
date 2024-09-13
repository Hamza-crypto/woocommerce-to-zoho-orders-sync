<?php


class Product_Sync {

	public static function sync_products_to_zoho() {
		// Fetch products from WooCommerce
		$args     = array(
			'status' => 'publish',
			'limit'  => -1,
		);
		$products = wc_get_products( $args );

		foreach ( $products as $product ) {
			$zoho_product_id = DB_Handler::get_zoho_id_by_woocommerce_id( $product->get_id(), 'product' );

			if ( ! $zoho_product_id ) {
				// Product not synced yet, create in Zoho CRM
				$zoho_product_id = API_Handler::create_product_in_zoho( $product );

				// Store the sync record in DB
				DB_Handler::insert_sync_record( $product->get_id(), $zoho_product_id, 'product' );
			}
		}
	}
}
