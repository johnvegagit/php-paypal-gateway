<?php
declare(strict_types=1);
defined('ROOTPATH') or exit('Access Denied!');

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
        $data = [
            'title' => 'Checkout payment page',
            'totalPay' => 99.99,
            'shippingPay' => 10.00,
            'tax' => 12.00,

        ];

        $this->header($data);
        $this->view('payment', $data);
        $this->footer();
    }
}