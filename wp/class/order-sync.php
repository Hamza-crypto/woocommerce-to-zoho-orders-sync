<?php


class Order_Sync
{
    public static function sync_orders_to_zoho()
    {
        // Fetch last synced order ID
        $last_order_id = DB_Handler::get_last_synced_order_id();

        // Fetch orders from WooCommerce that are greater than the last synced order ID
        $args = array(
            'limit' => -1,
            'orderby' => 'ID',
            'order' => 'ASC',
            'status' => 'completed',
            'meta_key' => '_order_id',
            'meta_value' => $last_order_id,
            'meta_compare' => '>'
        );
        $orders = wc_get_orders($args);

        foreach ($orders as $order) {
            // Check if customer exists in Zoho CRM
            $customer_id = $order->get_customer_id();
            $zoho_customer_id = DB_Handler::get_zoho_id_by_woocommerce_id($customer_id, 'customer');

            if (!$zoho_customer_id) {
                // Create customer in Zoho CRM
                $zoho_customer_id = API_Handler::create_customer_in_zoho($order->get_user());
                DB_Handler::insert_sync_record($customer_id, $zoho_customer_id, 'customer');
            }

            // Create the order in Zoho CRM
            $zoho_order_id = API_Handler::create_order_in_zoho($order, $zoho_customer_id);
            DB_Handler::insert_sync_record($order->get_id(), $zoho_order_id, 'order');
        }
    }
}