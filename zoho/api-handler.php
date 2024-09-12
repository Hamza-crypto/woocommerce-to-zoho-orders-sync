<?php

class API_Handler
{
    public static function create_product_in_zoho($product)
    {
        // API call to create a product in Zoho CRM
        // Return the Zoho CRM product ID
    }

    public static function create_customer_in_zoho($customer)
    {
        // API call to create a customer in Zoho CRM
        // Return the Zoho CRM customer ID
    }

    public static function create_order_in_zoho($order, $zoho_customer_id)
    {
        // API call to create an order in Zoho CRM linked to the customer
        // Return the Zoho CRM order ID
    }
}