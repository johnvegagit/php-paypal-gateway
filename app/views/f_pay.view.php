<?php
if (!isset($_SESSION['failed-pay'])): ?>
    <script type="text/javascript">
        alert("There was an error processing your request. You will be redirected at the start.");
        window.location.href = "<?= $_ENV['BASEURL'] ?>";
    </script>
    <?php die(); ?>
<?php else: ?>
    <main id="failed-pay-main">
        <div id="failed-pay-modal-info">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <h3>Oops! There was a problem with your payment.</h3>
            <div class="desc">
                <?php if ($_SESSION['failed-pay'] <= 3001): ?>

                    <span>It seems the amount of your payment does not match the expected total. Don't worry, we are handling
                        it.</span>
                    <p>To protect your purchase, we have initiated an automatic refund process.</p>
                    <p>Please allow 3 to 5 business days for the refund to reflect in your account.</p>
                    <p>If you have any questions or need further assistance, we are here to help you.</p>
                <?php elseif ($_SESSION['failed-pay'] > 4500): ?>

                    <p>An error occurred while verifying your information. Please try again later.</p>
                <?php else: ?>

                    <span>There was a problem while trying to process your refund. Please contact our support team to resolve
                        this situation.</span>
                <?php endif; ?>

                <a class="COMPONENT--linkto" href="<?= $_ENV['BASEURL'] ?>support">
                    <i class="bi bi-question-circle-fill"></i>Contact Support</a>
                <a class="COMPONENT--linkto" href="<?= $_ENV['BASEURL'] ?>">
                    <i class="bi bi-house-door-fill"></i>Return to Home</a>
            </div>
        </div>

    </main>
    <?php

    // Session cleanup when displaying the error message.
    unset($_SESSION['failed-pay']);
endif;