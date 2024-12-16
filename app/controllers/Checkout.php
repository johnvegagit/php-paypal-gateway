<?php
declare(strict_types=1);
session_start();
defined('ROOTPATH') or exit('Access Denied!');

use models\Checkout as customer_order;

class Checkout
{
    use Controller;

    public function index()
    {

        $data = [
            'title' => 'Checkout order page',
            'totalPay' => 99.99,
            'shippingPay' => 10.00,
            'tax' => 12.00,
        ];

        $this->header($data);
        $this->view('checkout', $data);
        $this->footer();
    }

    public function payment()
    {
        $order_id = '7';
        $customer_id = '646';

        $getOrder = new customer_order;
        $orderInfo = $getOrder->selectOrder($order_id, $customer_id);

        $data = [
            'title' => 'Checkout payment page',
            'totalPay' => 99.99,
            'shippingPay' => 10.00,
            'tax' => 12.00,
            'orderInfo' => $orderInfo
        ];

        $this->header($data);
        $this->view('payment', $data);
        $this->footer();
    }
}