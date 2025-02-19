# PayTabs Payment Integration

This project integrates **PayTabs' Hosted Payment Page (HPP) with iFrame Mode** into a **PHP-based shopping cart system**. It allows users to add products to a cart, create orders, and securely process payments through PayTabs.

## 🚀 Features

- **Add Products to Cart** (AJAX-based for smooth experience)
- **Create Orders**
- **Process Payments using PayTabs Hosted Payment Page**
- **Load Payment Page Inside an iFrame**
- **Handle Payment Responses (Success & Error)**
- **Logs Transaction Data for Debugging**

---

## 📂 Project Structure



---

## 🔧 Installation & Setup

### 1️⃣ **Clone the Repository**
```sh
git clone https://github.com/YOUR_GITHUB_USERNAME/paytabs-integration.git
cd paytabs-integration

2️⃣ Set Up Your Database
Create a database and import the necessary SQL tables.
Ensure your config.php file contains the correct database credentials.

3️⃣ Configure PayTabs API
Edit config.php with your PayTabs credentials:
'paytab' => [
    'profile_id' => 'YOUR_PROFILE_ID',
    'server_key' => 'YOUR_SERVER_KEY',
    'return' => 'http://localhost/payment_success.php',
    'callback' => 'http://localhost/payment_callback.php'
]
4️⃣ Run the Project


