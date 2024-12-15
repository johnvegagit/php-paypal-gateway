// Remove modal msg.
const closeModalMsg = document.getElementById('modalMessageContainer');
if (closeModalMsg != null) {
    closeModalMsg.addEventListener('click', (e)=> {
        e.preventDefault();
        if (e.target.matches('#closeModalMsgBtn')) {
            document.getElementById('modalMessageContainer').style.display='none';
            const scsMsg = document.getElementById('--modal-scss-msg');
            if (scsMsg) {
                document.getElementById('--modal-scss-msg').remove();
            } else {
                document.getElementById('--modal-error-msg').remove();
            }
        }
    });
}

const URLPATH = "http://localhost/public_html/php-paypal-gateway/app/controllers/CheckoutController.php";
const creatOrderBtn = document.getElementById('creatOrder');
const alertInputMsg = document.getElementById('alertInputMsg');

const checkoutForm = document.getElementById('checkoutForm');
if (checkoutForm != null) {
    checkoutForm.addEventListener('click', (e)=>{
        e.preventDefault();
        if (e.target.id === 'creatOrder' && e.target.tagName === 'BUTTON') {
            
            // Add style when button is clicked.
            creatOrderBtn.disabled = true;
            creatOrderBtn.innerHTML = 'Loading... <i class="fa fa-circle-o-notch fa-spin"></i>';
            creatOrderBtn.style.cursor = 'not-allowed';
            
            const formElement = e.target.closest('form');
            if (formElement) {

                checkoutFunc(formElement);    
            } else {

                // Reset style for button.
                creatOrderBtn.disabled = false;
                creatOrderBtn.innerHTML = 'Place order -->';
                creatOrderBtn.style.cursor = 'pointer';
            }
        }
    });  
}

function checkoutFunc(formElement) {
    const xhr = new XMLHttpRequest;
    const formData = new FormData;

    formData.append('name', formElement.querySelector('.FORM-INPUT-name').value);
    formData.append('surname', formElement.querySelector('.FORM-INPUT-surname').value);
    formData.append('email', formElement.querySelector('.FORM-INPUT-email').value);

    formData.append('number', formElement.querySelector('.FORM-INPUT-number').value);
    formData.append('country', formElement.querySelector('.FORM-INPUT-country').value);
    formData.append('city', formElement.querySelector('.FORM-INPUT-city').value);

    formData.append('address', formElement.querySelector('.FORM-INPUT-address').value);
    formData.append('state', formElement.querySelector('.FORM-INPUT-state').value);
    formData.append('zipcode', formElement.querySelector('.FORM-INPUT-zipcode').value);

    formData.append('note', formElement.querySelector('.FORM-INPUT-note').value);
    formData.append('action', 'checkout');

    xhr.open('POST', `${URLPATH}`, true);
    xhr.setRequestHeader("X-Requested-with", "XMLHttpRequest");

    xhr.onload = function () {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);

            const errFields = ['name','surname','email','number','country','city','address','state','zipcode','note'];
            errFields.forEach(field => {
                const errMsgElement = document.getElementById(`inputMsg--${field}`);
                if (errMsgElement) {
                    errMsgElement.innerHTML = '';
                    const inputErr = errMsgElement.previousElementSibling;
                    inputErr.removeAttribute('style');

                }
            });

            if (!response.success) {
                
                // Reset style for button.
                creatOrderBtn.disabled = false;
                creatOrderBtn.innerHTML = 'Place order -->';
                creatOrderBtn.style.cursor = 'pointer';

                alertInputMsg.innerHTML = response.error || '';

                if (response.errors) {
                    
                    for (const field in response.errors) {

                        const errMsgElement = document.getElementById(`inputMsg--${field}`);
                        if (errMsgElement) {
                            errMsgElement.innerHTML = response.errors[field];
                            const inputErr = errMsgElement.previousElementSibling;

                            inputErr.style.border = '2px solid #ff0000';
                            inputErr.style.outline = '3px solid #ff000015';
                            inputErr.style.borderRadius = '5px';
                        }
                    }
                }

                if (response.modal_msg) {
                    document.getElementById('modalMessageContainer').style.display = 'flex';
                    document.getElementById('modalMessageContainer').innerHTML = response.modal_msg;
                }

            }else{

                alertInputMsg.innerHTML = '';

                // Success.
                if (response.html) {
                    document.getElementById('checkoutMain').style.height = '100vh';
                    document.getElementById('checkoutMain').style.display = 'flex';
                    document.getElementById('checkoutMain').style.justifyContent = 'center';
                    document.getElementById('checkoutMain').style.alignItems = 'center';
                    document.getElementById('checkoutMain').innerHTML = response.html;
                }
            }

        } else {
            console.error('Error: '+this.status);
            
            // Reset style for button.
            creatOrderBtn.disabled = false;
            creatOrderBtn.innerHTML = 'Place order -->';
            creatOrderBtn.style.cursor = 'pointer';
        }
    }
    
    xhr.send(formData);
}