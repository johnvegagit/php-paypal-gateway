
# PHP PayPal Gateway - Simple Payment System

Welcome to the PHP PayPal Gateway! This project is a lightweight payment system using PayPal Smart Buttons, built with **PHP (OOP)**, **JavaScript (AJAX)**, and a basic **MVC structure**. The system allows users to create orders, process payments, and handle errors seamlessly.

---

## 📜 Features

- **Order Creation:** Collect user data through a form and validate it with AJAX before creating an order.
- **PayPal Integration:** Includes PayPal Smart Buttons for payment via PayPal account or credit/debit card.
- **Error Handling:** Returns JSON responses for validation errors or payment issues.
- **Environment Configuration:** Stores sensitive data (like PayPal credentials) securely in a `.env` file.
- **Customizable:** Free to modify and extend as needed.

---

## 📦 Requirements

Before using the project, ensure the following tools are installed:

- **PHP >= 8.2.12**
- **Apache Web Server** (with `.htaccess` enabled)
- **Composer** (for managing dependencies)

---

## 🚀 Installation

### Clone the Repository

```bash
git clone https://github.com/johnvegagit/php-paypal-gateway.git
```

### Install Dependencies

Use Composer to install the required packages:

```bash
composer require vlucas/phpdotenv
```

---

## ⚙️ Environment Configuration

Create a `.env` file in the root directory and configure the following variables:

```env
BASEURL="http://localhost/public_html/php-paypal-gateway/"
BASEPTH="/opt/lampp/htdocs/public_html/php-paypal-gateway/"

DBHOST="localhost"
DBNAME="dbname"
DBUSER="root"
DBPASS="yourpassword"

CLIENTID="your-paypal-client-id"
SECRETKEY="your-paypal-secret-key"
```

---

## 🔧 Usage

1. **Place the project** in your Apache root directory (e.g., `/opt/lampp/htdocs`).
2. **Access the checkout page:**
   - Navigate to `http://localhost/public_html/php-paypal-gateway/checkout`.
   - Fill out the form and submit to create an order. Errors are handled via JSON responses.
3. **Complete payment:**
   - Redirects to `http://localhost/public_html/php-paypal-gateway/checkout/payment?token=1234`.
   - Use PayPal Smart Buttons to complete payment via PayPal or credit/debit card.
4. **Payment result:**
   - Successful payments redirect to a success page.
   - Failed payments redirect to an error page with detailed messages.

---

## 📈 Future Improvements

This is the first version of the system. Planned updates include:

- Remove the product from the cart after payment is completed.
- Cancel the order and change its status from 'Pending' to 'Cancelled'.

Feel free to contribute or fork the project to make it better!

---

## 🤝 License & Disclaimer

This project is **free to use and modify**. You can:

- Use it in personal or commercial projects.
- Fork and extend it as needed.

**Disclaimer:** Use this project at your own risk. It is provided "as is" with no guarantees.

---

Happy coding! 🚀 If you encounter any issues or have suggestions, feel free to open an issue on the repository.