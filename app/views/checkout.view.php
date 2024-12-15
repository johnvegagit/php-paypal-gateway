<main id="checkoutMain">

    <form id="checkoutForm">
        <section>
            <div class="form-header">
                <h3>Final Review</h3>
                <p class="checkout-info-p">
                    <i class="bi bi-info-circle-fill"></i>
                    Please carefully review all your personal information before proceeding with the payment. Make sure the information provided is correct, as you will not be able to modify it after completing the order.
                </p>
            </div>

            <!-- name surname -->
            <div class="form-input-names-cont">
                <div class="form-input-cont">
                    <label for="name">name</label>
                    <input class="FORM-INPUT-name" required type="text" placeholder="name" minlength="3" autocomplete="off">
                    <div id="inputMsg--name" class="input-msg-cont"></div>
                </div>
                <div class="form-input-cont">
                    <label for="surname">surname</label>
                    <input class="FORM-INPUT-surname" required type="text" placeholder="surname" minlength="3" autocomplete="off">
                    <div id="inputMsg--surname" class="input-msg-cont"></div>
                </div>
            </div>

            <!-- email -->
            <div class="form-input-cont">
                <label for="email">email</label>
                <input class="FORM-INPUT-email" required type="email" placeholder="email" minlength="10" autocomplete="off">
                <div id="inputMsg--email" class="input-msg-cont"></div>
            </div>

            <!-- number -->
            <div class="form-input-cont">
                <label for="number">number</label>
                <input class="FORM-INPUT-number" required type="number" placeholder="number" minlength="10" autocomplete="off">
                <div id="inputMsg--number" class="input-msg-cont"></div>
            </div>


            <!-- country city -->
            <div class="form-duoble-input-cont">
                <div class="form-input-cont">
                    <label for="country">country</label>
                    <input class="FORM-INPUT-country" required type="text" placeholder="country" minlength="3" autocomplete="off">
                    <div id="inputMsg--country" class="input-msg-cont"></div>
                </div>
                <div class="form-input-cont">
                    <label for="city">city</label>
                    <input class="FORM-INPUT-city" required type="text" placeholder="city" minlength="3" autocomplete="off">
                    <div id="inputMsg--city" class="input-msg-cont"></div>
                </div>
            </div>

            <!-- address -->
            <div class="form-input-cont">
                <label for="address">address</label>
                <input class="FORM-INPUT-address" required type="text" placeholder="address" minlength="10" autocomplete="off">
                <div id="inputMsg--address" class="input-msg-cont"></div>
            </div>

            <!-- state zipcode -->
            <div class="form-duoble-input-cont">
                <div class="form-input-cont">
                    <label for="state">state</label>
                    <input class="FORM-INPUT-state" required type="text" placeholder="state" minlength="3" autocomplete="off">
                    <div id="inputMsg--state" class="input-msg-cont"></div>
                </div>
                <div class="form-input-cont">
                    <label for="zipcode">zipcode</label>
                    <input class="FORM-INPUT-zipcode" required type="text" placeholder="zipcode" minlength="3" autocomplete="off">
                    <div id="inputMsg--zipcode" class="input-msg-cont"></div>
                </div>
            </div>

            <!-- note -->
            <div class="form-input-cont">
                <label for="note">note</label>
                <textarea class="FORM-INPUT-note" cols="20" rows="5" placeholder="write a note (optional)"></textarea>
                <div id="inputMsg--note" class="input-msg-cont"></div>
            </div>

            <input type="hidden" name="paypalOrderID" id="paypalOrderID">
            <input type="hidden" name="paypalAmount" id="paypalAmount">
            <input type="hidden" name="capture_id" id="capture_id">

        </section>

        <section>
            <div class="cart-list-container">
                <span>Cart List items 3</span>
                <div class="cart-item">
                    <div class="cart-item-img-name"><img src="https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Ftse2.mm.bing.net%2Fth%3Fid%3DOIP.ed6Dq5i5r8GMBEnRGyK-xQHaHa%26pid%3DApi&f=1&ipt=2a80fc568b930398a4ce4b2c48d7a6c4cd013d67ee1f053b62abe829dc1df0f0&ipo=images">
                        <span>Shirt</span>
                    </div>
                    <span>152.00</span>
                </div>
                <div class="cart-item">
                    <div class="cart-item-img-name"><img src="https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Ftse3.mm.bing.net%2Fth%3Fid%3DOIP.O05w8k2uQJUxlLjUBTfF_QAAAA%26pid%3DApi&f=1&ipt=f1304e41e629a29afbc610657c074de87e829594f799662d83296463ca880dbb&ipo=images">
                        <span>Pants</span>
                    </div>
                    <span>350.00</span>
                </div>
                <div class="cart-item">
                    <div class="cart-item-img-name"><img src="https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Ftse4.mm.bing.net%2Fth%3Fid%3DOIP.d-7UFbAaPsT2y3dYpaKm1AHaFb%26pid%3DApi&f=1&ipt=1189eead6fa6268271006713bf206bcd8bd82a715f537d2e85b5f141f2dd8292&ipo=images">
                        <span>Sheos</span>
                    </div>
                    <span>100.00</span>
                </div>
            </div>

            <div class="resume-payment-container">
                <span>Resume payment</span>
                <ul>
                    <li>
                        <span>Subtotal:</span>
                        <?php $sub = 152.00 + 350.00 + 100.00 ?>
                        <span><?= $sub ?></span>
                    </li>
                    <li>
                        <span>Shipping:</span>
                        <span>10.00</span>
                    </li>
                    <li>
                        <span>Tax:</span>
                        <span>12.00</span>
                    </li>
                </ul>
                <span class="resume-payment-total">
                    <span>total:</span>
                    <span><?= $sub + 10.00 + 12.00 ?></span>
                </span>
            </div>

            <div class="btn-cont">
                <div id="alertInputMsg" class="input-msg-cont"></div>
                <button id="creatOrder">Place order --></button>
            </div>
        </section>
    </form>

</main>

