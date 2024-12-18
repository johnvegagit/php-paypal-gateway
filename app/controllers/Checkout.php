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
        $order_id = $_SESSION['orderID'];
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

    public function submit_purchase()
    {
        $paypalAmount = $_POST['paypalAmount'];
        $expectedAmount = 121.9;

        $originalDate = date("Y-m-d H:i:s", strtotime("+3 days"));
        $date = new DateTime($originalDate);
        $estimatedDate = $date->format('d \d\e F Y');

        try {

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                $clientId = $_ENV['CLIENTID'];
                $clientSecret = $_ENV['SECRETKEY'];

                $_SESSION['estimatedDate'] = $estimatedDate;
                $_SESSION['paypalAmount'] = $paypalAmount;

                $captureId = $_POST['capture_id'];
                $paypalOrderID = $_POST['paypalOrderID'];
                $paypalAmount = $_POST['paypalAmount'];

                $order_id = $_SESSION['orderID'];
                $customer_id = '646';

                // Payment amount not coinside. Attempt to refund.
                if ($paypalAmount != $expectedAmount) {

                    $accessToken = getAccessToken($clientId, $clientSecret);
                    $refundResponse = refundPayment($captureId, $accessToken);

                    if (isset($refundResponse->status) && $refundResponse->status == 'COMPLETED') {

                        // Redirect to the error page with a refund message initiated.
                        $_SESSION['failed-pay'] = rand(1500, 3000);
                        $failedPay = $_SESSION['failed-pay'];
                        header('Location: ' . $_ENV['BASEURL'] . "checkout/e?error=#$failedPay");
                        die();
                    } else {

                        // Redirect to the error page with a problem message on the refund.
                        $_SESSION['failed-pay'] = rand(3001, 4500);
                        $failedPay = $_SESSION['failed-pay'];
                        header('Location: ' . $_ENV['BASEURL'] . "checkout/e?error=#$failedPay");
                        die();
                    }
                }

                // Validate payment status on PayPal.
                $accessToken = getAccessToken($clientId, $clientSecret);
                $captureDetails = getCaptureDetails($captureId, $accessToken);

                if (isset($captureDetails->status) && $captureDetails->status === 'COMPLETED') {

                    // Payment correct, update order.
                    $orderStatus = new customer_order;
                    $orderStatus->updateOrderSatus($order_id, $customer_id);
                } else {

                    // If it is not COMPLETED, handle the error.
                    $_SESSION['failed-pay'] = rand(3001, 4500);
                    $failedPay = $_SESSION['failed-pay'];
                    header('Location: ' . $_ENV['BASEURL'] . "checkout/e?error=#$failedPay");
                    die();
                }
            } else {
                header('Location: ' . $_ENV['BASEURL']);
                die();
            }
        } catch (PDOException $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    public function e()
    {
        $data = [
            'title' => "failed Pay",
        ];

        $this->header($data);
        $this->view('f_pay', $data);
        $this->footer();
    }

    public function s()
    {
        $data = [
            'title' => "Succes Pay",
        ];

        $this->header($data);
        $this->view('s_pay', $data);
        $this->footer();
    }
}

// Function to obtain the access token from PayPal.
function getAccessToken($clientId, $clientSecret)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.sandbox.paypal.com/v1/oauth2/token");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_USERPWD, $clientId . ":" . $clientSecret);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");

    $result = curl_exec($ch);
    curl_close($ch);

    $response = json_decode($result);
    return $response->access_token;
}

// Refund function.
function refundPayment($captureId, $accessToken)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.sandbox.paypal.com/v2/payments/captures/{$captureId}/refund");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);

    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "Authorization: Bearer " . $accessToken
    ]);

    $result = curl_exec($ch);
    curl_close($ch);

    return json_decode($result);
}

// Function to get the status of the payment capture.
function getCaptureDetails($captureId, $accessToken)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.sandbox.paypal.com/v2/payments/captures/{$captureId}");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "Authorization: Bearer " . $accessToken
    ]);

    $result = curl_exec($ch);
    curl_close($ch);

    return json_decode($result);
}
