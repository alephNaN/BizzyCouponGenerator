<?php

require 'shopify.php';

$shopify_storename = 'bizzycoupon';
$shopify_username = 'automatwon@gmail.com';
$shopify_password = 'porunga';

$shopify_admin_url = "https://{$shopify_storename}.myshopify.com/admin";

$api = new \Shopify\PrivateAPI($shopify_username, $shopify_password, $shopify_admin_url);

if (!$api->isLoggedIn() && !$api->login()) {
    echo 'invalid credentials';
} else {

    echo 'Logged in';

    # Create a 5% discount coupon
    $new_discount = ['discount' => [
        'applies_to_id' => '',
        'code' => 'automatic_coupon',
        'discount_type' => 'percentage',
        'value' => 5,
        'usage_limit' => 1,
        'starts_at' => date('Y-m-d\TH:i:sO', mktime(0, 0, 0)),
        'ends_at' => null,
        'applies_once' => false
    ]];

    # Set the CSRF token for the POST request
    $discountUrl = $shopify_admin_url . '/discounts/new';
    try { $api->setToken('https://bizzycoupon.myshopify.com/admin/discounts/new'); } 
    catch (\Exception $ex) { }

    $do_discount = $api->doRequest('POST', 'discounts.json', $new_discount);

    print_r($do_discount);

    # List coupons
    $params = [
        'limit' => 50, 
        'order' => 'id+DESC', 
        'direction' => 'next'
    ];

    $discounts = $api->doRequest('GET', 'discounts.json', $params);
    if (isset($discounts->discounts)) {
        $coupons = $discounts->discounts;
        foreach ($coupons as $coupon) {
            print_r($coupon);
        }
    }

    $params = [
        'reportcenter' => true,
        'start_date' => '2013-02-22',
        'end_date' => '2013-03-01',
        'timezone' => 'Pacific+Time+(US+%26+Canada)'
    ];

    $referrals = $api->doRequest('GET', 'referrals.json', $params);
    print_r($referrals);

    $facts = $api->doRequest('GET', 'facts.json', $params);
    print_r($facts);

    $periodical_facts = $api->doRequest('GET', 'periodical_facts.json', $params);
    print_r($periodical_facts);
}