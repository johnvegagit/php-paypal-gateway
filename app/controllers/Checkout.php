<?php
declare(strict_types=1);
defined('ROOTPATH') or exit('Access Denied!');

class Checkout
{
    use Controller;

    public function index()
    {

        $data = [
            'title' => 'Checkout page',
        ];

        $this->header($data);
        $this->view('checkout', $data);
        $this->footer();
    }
}