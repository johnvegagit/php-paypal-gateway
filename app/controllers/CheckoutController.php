<?php
declare(strict_types=1);

$currentDirectory = __DIR__;
$newDirectory = dirname($currentDirectory, 2);
require $newDirectory . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../..');
$dotenv->safeLoad();

class CheckoutController
{

    public function checkoutContrFunc(
        string $name,
        string $surname,
        string $email,
        string $number,
        string $city,
        string $country,
        string $address,
        string $state,
        string $zipcode,
        string $note
    ) {
        function validate_empty($value)
        {
            return empty(trim($value));
        }

        function validate_inputs($value)
        {
            return preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/", $value);
        }

        function validate_email($email)
        {
            return filter_var($email, FILTER_VALIDATE_EMAIL);
        }

        function validate_address($value)
        {
            return preg_match("/^[a-zA-Z0-9-ZáéíóúÁÉÍÓÚñÑ\s.,'-]*$/", $value);
        }

        function validate_email_char(string $email): bool
        {
            $pattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
            if (preg_match($pattern, $email)) {
                return true;
            }
            return false;
        }

        function validate_phone($phone)
        {
            return preg_match("/^\d{7,15}$/", $phone);
        }

        function validate_zipcode($zipcode)
        {
            return preg_match("/^\d{4,10}$/", $zipcode);
        }

        function validate_notes($value)
        {
            return preg_match("/^[a-zA-Z0-9-ZáéíóúÁÉÍÓÚñÑ\s.,'-]*$/", $value);
        }

        $errors = [];

        if (validate_empty($name)) {
            $errors['name'] = '<span class="input-msg-err"><i class="bi bi-exclamation-triangle-fill"></i> Please enter your name.</span>';
        } elseif (!validate_inputs($name)) {
            $errors['name'] = '<span class="input-msg-err"><i class="bi bi-exclamation-triangle-fill"></i> Invalid characters detected.</span>';
        }

        if (validate_empty($surname)) {
            $errors['surname'] = '<span class="input-msg-err"><i class="bi bi-exclamation-triangle-fill"></i> Please enter your surname.</span>';
        } elseif (!validate_inputs($surname)) {
            $errors['surname'] = '<span class="input-msg-err"><i class="bi bi-exclamation-triangle-fill"></i> Invalid characters detected.</span>';
        }

        if (validate_empty($email)) {
            $errors['email'] = '<span class="input-msg-err"><i class="bi bi-exclamation-triangle-fill"></i> Please enter your email address.</span>';
        } elseif (!validate_email($email)) {
            $errors['email'] = '<span class="input-msg-err"><i class="bi bi-exclamation-triangle-fill"></i> The entered email is not valid.</span>';
        } elseif (!validate_email_char($email)) {
            $errors['email'] = '<span class="input-msg-err"><i class="bi bi-exclamation-triangle-fill"></i> The email contains invalid characters.</span>';
        }

        if (validate_empty($number)) {
            $errors['number'] = '<span class="input-msg-err"><i class="bi bi-exclamation-triangle-fill"></i> Please enter your phone number.</span>';
        } elseif (!validate_phone($number)) {
            $errors['number'] = '<span class="input-msg-err"><i class="bi bi-exclamation-triangle-fill"></i> The phone number is not valid.</span>';
        }

        if (validate_empty($country)) {
            $errors['country'] = '<span class="input-msg-err"><i class="bi bi-exclamation-triangle-fill"></i> Please enter your country.</span>';
        } elseif (!validate_inputs($country)) {
            $errors['country'] = '<span class="input-msg-err"><i class="bi bi-exclamation-triangle-fill"></i> Invalid characters detected.</span>';
        }

        if (validate_empty($city)) {
            $errors['city'] = '<span class="input-msg-err"><i class="bi bi-exclamation-triangle-fill"></i> Please enter your city.</span>';
        } elseif (!validate_inputs($city)) {
            $errors['city'] = '<span class="input-msg-err"><i class="bi bi-exclamation-triangle-fill"></i> Invalid characters detected.</span>';
        }

        if (validate_empty($address)) {
            $errors['address'] = '<span class="input-msg-err"><i class="bi bi-exclamation-triangle-fill"></i> Please enter your address.</span>';
        } elseif (!validate_address($address)) {
            $errors['address'] = '<span class="input-msg-err"><i class="bi bi-exclamation-triangle-fill"></i> Invalid characters detected.</span>';
        }

        if (validate_empty($state)) {
            $errors['state'] = '<span class="input-msg-err"><i class="bi bi-exclamation-triangle-fill"></i> Please enter your state.</span>';
        } elseif (!validate_inputs($state)) {
            $errors['state'] = '<span class="input-msg-err"><i class="bi bi-exclamation-triangle-fill"></i> Invalid characters detected.</span>';
        }

        if (validate_empty($zipcode)) {
            $errors['zipcode'] = '<span class="input-msg-err"><i class="bi bi-exclamation-triangle-fill"></i> Please enter your zip code.</span>';
        } elseif (!validate_zipcode($zipcode)) {
            $errors['zipcode'] = '<span class="input-msg-err"><i class="bi bi-exclamation-triangle-fill"></i> zip code are not valid.</span>';
        }

        if (validate_empty($note)) {
            $errors['note'] = '<span class="input-msg-err"><i class="bi bi-exclamation-triangle-fill"></i> Please enter your note.</span>';
        } elseif (!validate_notes($note)) {
            $errors['note'] = '<span class="input-msg-err"><i class="bi bi-exclamation-triangle-fill"></i> Invalid characters detected.</span>';
        }

        if (!empty($errors)) {

            echo json_encode([
                'success' => false,
                'errors' => $errors,
                'error' => '<span style="display:block;width:340;" class="input-msg-err"><i class="bi bi-exclamation-triangle-fill"></i> Some fields has errors.</span>',
            ]);
            die();
        }

        if (!$errors) {

            echo json_encode(value: [
                'success' => true,
                'html' => $_ENV['BASEURL'] . 'checkout/payment?true=954758',
            ]);
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Sanitize inputs.
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $surname = isset($_POST['surname']) ? trim($_POST['surname']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';

    $number = isset($_POST['number']) ? trim($_POST['number']) : '';
    $country = isset($_POST['country']) ? trim($_POST['country']) : '';
    $city = isset($_POST['city']) ? trim($_POST['city']) : '';

    $address = isset($_POST['address']) ? trim($_POST['address']) : '';
    $state = isset($_POST['state']) ? trim($_POST['state']) : '';
    $zipcode = isset($_POST['zipcode']) ? trim($_POST['zipcode']) : '';

    $note = isset($_POST['note']) ? trim($_POST['note']) : '';
    $action = isset($_POST['action']) ? trim($_POST['action']) : '';

    $checkout = new CheckoutController;

    switch ($action) {
        case 'checkout':
            $checkout->checkoutContrFunc(
                $name,
                $surname,
                $email,
                $number,
                $city,
                $country,
                $address,
                $state,
                $zipcode,
                $note
            );
            break;

        default:
            // This error will display if the case: in switch statement fails.
            echo json_encode(value: [
                'success' => false,
                'modal_msg' => '<div id="--modal-error-msg" class="--modal-error-msg">
                                    <span><i class="bi bi-exclamation-triangle-fill"></i> Error</span>
                                    <p>An internal error has occurred. Please try again later.</p>
                                    <button id="closeModalMsgBtn" class="--action-button" type="button" title="close modal">Close</button>
                                </div>',
            ]);
            break;
    }
}