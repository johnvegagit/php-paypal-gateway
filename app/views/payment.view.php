<?php if (!isset($_SESSION['token']) || $_SESSION['token'] != $_GET['token']): ?>
    <script type="text/javascript">
        window.location.href = "<?= $_ENV['BASEURL'] ?>";
    </script>
    <?php die(); ?>
<?php else: ?>
    <main id="paymentCheckoutMain">
        <div id="paymentMethodContainer">
            <div class="header">
                <i class="bi bi-check-circle-fill"></i>
                <span>Your order has been successfully placed and is now pending.</span>
                <p>Please complete the payment with PayPal to finalize your order and begin preparing the shipment.</p>
            </div>
            <ul class="order-info">
                <li>
                    <span>Order Number:</span>
                    <span>#<?= $data['orderInfo']->order_id ?></span>
                </li>
                <li>
                    <span>Email:</span>
                    <span><?= $data['orderInfo']->email ?></span>
                </li>
                <li>
                    <span>Total Amount:</span>
                    <span>$<?= $data['orderInfo']->total_amount ?></span>
                </li>
                <li>
                    <span>Payment Method:</span>
                    <span><?= $data['orderInfo']->payment_method ?></span>
                </li>
                <li>
                    <span>Status:</span>
                    <span><?= $data['orderInfo']->status ?></span>
                </li>
            </ul>

            <div id="paypal-button-container"></div>

            <div id="ORLine">
                <hr> or
                <hr>
            </div>

            <a id="keepExploringLink" href="<?= $_ENV['BASEURL'] ?>">Keep Exploring --></a>
        </div>

    </main>

    <form id="formPayment" action="<?= $_ENV['BASEURL'] ?>checkout/submit_purchase" method="post">
        <input type="hidden" name="paypalOrderID" id="paypalOrderID">
        <input type="hidden" name="paypalAmount" id="paypalAmount">
        <input type="hidden" name="capture_id" id="capture_id">
    </form>

    <script
        src="https://sandbox.paypal.com/sdk/js?client-id=AXt5JDFLfkbY4fJfGpODJ_BFuL5f-jVTMIwQd7M182ViUYjnTAolCccS-1WgeZ2VVDQoV0xFaJ_k34BT&currency=USD&intent=capture&commit=true&debug=true&components=buttons"></script>
    <script>
        paypal.Buttons({
            createOrder: function (data, actions) {
                return actions.order.create({
                    purchase_units: [
                        {
                            amount: {
                                value: '<?= htmlspecialchars($data['totalPay']) + htmlspecialchars($data['shippingPay']) + htmlspecialchars($data['tax']) ?>'
                            }
                        }
                    ]
                });
            },
            onApprove: function (data, actions) {
                return actions.order.capture().then(function (details) {
                    const captureId = details.purchase_units[0].payments.captures[0].id;

                    document.getElementById('paypalOrderID').value = data.orderID;
                    document.getElementById('paypalAmount').value = details.purchase_units[0].amount.value;
                    document.getElementById('capture_id').value = captureId;
                    document.getElementById('formPayment').submit();
                });
            },
            onError: function (err) {
                console.log('Error en el pago:', err);
            }
        }).render('#paypal-button-container');
    </script>


<?php endif;