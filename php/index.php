<?php

error_reporting(0);

function load_json($path) {

    $file = json_decode(file_get_contents(__DIR__.'/'.$path), true);
    if ($file) {
        return $file;
    } else throw new Exception("Error Processing Request", 1);
}

// Schema
$total = [
    'orders_number'           => 0,
    'free_orders_number'      => 0,
    'orders_gbp_number'       => 0,
    'orders_gbp_sum'          => 0,
    'orders_over_100_gbp_sum' => 0,
    'orders_to_essex_number'  => 0,
    'orders_to_essex_gbp_sum' => 0
];


try {
    $orders = load_json('orders.json')['orders'];
}
catch(Exception $e) {
    exit($e);
}

foreach ($orders as $order) {
    $total['orders_number'] += 1;

    if( $order['price'] == 0 ) $total['free_orders_number'] += 1;

    if( strtoupper($order['currency']) === 'GBP' ) {
        $total['orders_gbp_number'] += 1;
        $total['orders_gbp_sum'] += $order['price'];

        if( $order['price'] > 100 ) {
            $total['orders_over_100_gbp_sum'] += $order['price'];
        }
    }

    if ( strtolower($order['customer']['shipping_address']['county']) == 'essex' ) {
        $total['orders_to_essex_number'] += 1;

        if( strtoupper($order['currency']) === 'GBP' ) {
            $total['orders_to_essex_gbp_sum'] += $order['price'];
        }
    }
}

print_r('Total number of orders: '. $total['orders_number']. "<br>");
print_r('Number of orders that were free: '. $total['free_orders_number']. "<br>");
print_r('Number of orders placed in GBP: '. $total['orders_gbp_number']. "<br>");
print_r('Sum of orders placed in GBP: '. $total['orders_gbp_sum']. "<br>");
print_r('Sum of orders over £100 placed in GBP: '. $total['orders_over_100_gbp_sum']. "<br>");
print_r('Number of orders shipped to Essex: '. $total['orders_to_essex_number']. "<br>");
print_r('Sum of orders placed in GBP that were shipped to Essex: '. $total['orders_to_essex_gbp_sum']. "<br>");
