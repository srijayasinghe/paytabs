<?php
class OrderController {
    public $model;
    public $config;

    /*
        Type : View
        Action : Show view layer
    */
    public function myorderAction(){
        return require_once('../views/my_orders.php');
    }

    /*
        Type : View
        Action : Show order details layer
    */
    public function orderDetailsAction(){
        return require_once('../views/order_details.php');
    }

    /*
        Type : View.
        Action : Show order create layer.
    */
    public function createOrderAction(){
        return require_once('../views/create_order.php');
    }

    /*
        Type : View.
        Action : Show payment success layer.
    */
    public function paymentSuccessAction(){
        return require_once('../views/payment_success.php');
    }

    /*
        Type : Ajax.
        Action : Return orders info as json.
    */
    public function ajaxDetailsAction(){
        header('Content-Type: application/json');
        $orders = $this->model->getOrderDetails();
        echo json_encode(["orders" => $orders]);
        exit;
    }

    /*
        Type : Ajax.
        Action : Return orders details as json.
    */
    public function ajaxOrderDetailsAction(){
        header('Content-Type: application/json');
        if (!isset($_GET['order_id'])) {
            echo json_encode(["success" => false, "message" => "Order ID is required"]);
            exit;
        }
        $order_id = intval($_GET['order_id']);
        $order_details  = $this->model->getOrderDetailsById($order_id);

        // Fetch refund details if the order is refunded.
        $refunds = [];
        if ($order_details && $order_details['order_status'] == 'refunded') {
             $refunds = $this->model->getRefundOrderDetails($order_id);
        }

        // Combine data.
        $response = [
            "success" => true,
            "order" => $order_details,
            "refunds" => $refunds
        ];
        echo json_encode($response);
        exit;
    }

    /*
        Type : Ajax.
        Action : Return product info as json.
    */
    public function ajaxProductInfoAction(){
        header('Content-Type: application/json');
        $products = $this->model->getProductInfo();
        echo json_encode( $products);
        exit;
    }

    /*
        Type : Ajax.
        Action : Return PayTabs API response.
    */
    public function ajaxCreateOrderAction(){
        header('Content-Type: application/json');

        $data = json_decode(file_get_contents("php://input"), true);

        $name = $data['name'];
        $email = $data['email'];
        $phone = $data['phone'];
        $delivery = $data['delivery'];
        $address = $data['address'];

        $order_id  = $this->model->createOrder();

        // PayTabs API Details
        $paytabs_url = $this->config['paytab'] ['paytabs_url'];
        $profile_id = $this->config['paytab'] ['profile_id'];
        $integration_key = $this->config['paytab'] ['integration_key'];
        $total_amount = $this->model->getCartTotal();

        // Prepare payment request
        $payment_data = [
            "profile_id" => $profile_id,
            "tran_type" => "sale",
            "tran_class" => "ecom",
            "cart_id" => (string) $order_id,
            "cart_description" => "Order #$order_id Payment",
            "cart_currency" => "EGP",  
            "cart_amount" => round($total_amount, 2),
            "framed" => true,
            "hide_shipping" => true, 
            "payment_page" => "iframe",
            "payment_methods" => ["card"],
            "customer_details" => [
                "name" => $name,
                "email" => $email,
                "phone" => $phone,
                "street1" => $address,
                "city" => "Cairo",
                "state" => "Cairo",
                "country" => "EG",
                "zip" => "10000"
            ],
            "shipping_details" => [
            "name" => $name,
            "email" => $email,
            "phone" => $phone,
            "street1" => $address,
            "city" => "Cairo",
            "state" => "Cairo",
            "country" => "EG",
            "zip" => "10000"
        ],
            "return" => $this->config['paytab'] ['return'],
            "callback" => $this->config['paytab'] ['callback']
        ];

        // Call PayTabs API.
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $paytabs_url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: $integration_key",
            "Content-Type: application/json"
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payment_data));
        $response = curl_exec($ch);
        curl_close($ch);
        
        $response_data = json_decode($response, true);

        // **Debugging: Log PayTabs Response for Errors**
        file_put_contents("paytabs_debug.log", json_encode($response_data));

        if (isset($response_data['redirect_url'])) {
            echo json_encode(["success" => true, "payment_url" => $response_data['redirect_url']]);
        } else {
            echo json_encode(["success" => false, "message" => "PayTabs Error: " . json_encode($response_data)]);
        }
    }
}
