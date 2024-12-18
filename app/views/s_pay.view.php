<?php if (!isset($_SESSION['success-pay'])): ?>
    <script type="text/javascript">
        window.location.href = "<?= $_ENV['BASEURL'] ?>";
    </script>
    <?php die(); ?>
<?php else: ?>
    <main id="success-pay-main">
        <div id="success-pay-modal-info">
            <i class="bi bi-check-circle-fill"></i>
            <h3>Thank you for your purchase!</h3>
            <div class="desc">
                <span>Your payment was successful, and we are carefully preparing your order.</span>
                <p>We will make sure your package arrives in perfect condition. If you have any questions or if an issue
                    arises, do not hesitate to contact us. We will be happy to assist you.</p>
                <ul>
                    <li>Total Amount: C$<?= $_SESSION['paypalAmount'] ?></li>
                    <li>Estimated Delivery Date:<br><?= $_SESSION['estimatedDate'] ?></li>
                </ul>

                <a class="COMPONENT--linkto" href="<?= $_ENV['BASEURL'] ?>">
                    <i class="bi bi-house-door-fill"></i>Return to Home</a>
            </div>

        </div>
    </main>
    <?php

    // Session cleanup when displaying the error message.
    unset($_SESSION['success-pay']);
    unset($_SESSION['paypalAmount']);
    unset($_SESSION['estimatedDate']);
endif;