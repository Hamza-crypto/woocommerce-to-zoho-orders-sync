<?php



class DB_Handler {

	public static function create_tables() {
		global $wpdb;
		$table_name      = $wpdb->prefix . 'zoho_sync';
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            woocommerce_id bigint(20) NOT NULL,
            zoho_id bigint(20) NOT NULL,
            type varchar(20) NOT NULL, /* 'product' or 'order' */
            PRIMARY KEY  (id)
        ) $charset_collate;";

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $sql );
	}

	public static function insert_sync_record( $woocommerce_id, $zoho_id, $type ) {
		global $wpdb;
		$table_name = $wpdb->prefix . 'zoho_sync';

		$wpdb->insert(
			$table_name,
			array(
				'woocommerce_id' => $woocommerce_id,
				'zoho_id'        => $zoho_id,
				'type'           => $type,
			),
			array( '%d', '%d', '%s' )
		);
	}

	public static function get_last_synced_order_id() {
		global $wpdb;
		$table_name = $wpdb->prefix . 'zoho_sync';

		$last_id = $wpdb->get_var( "SELECT MAX(woocommerce_id) FROM $table_name WHERE type = 'order'" );
		return $last_id ? $last_id : 0;
	}
}
