<?php
class OrderModel{
    public $db;

  
    /*
        Type : Return database data.
        Action : Return all orders in orders table.
    */
    function getOrders() {
        $stmt = $this->db->query("SELECT * FROM orders");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /*
        Type : Return database data.
        Action : Return all orders in orders table.
    */
    function getOrderDetails(){
        $stmt = $this->db->query("SELECT o.id AS order_id, o.order_date, o.status, 
                p.name AS product_name, p.price, c.quantity, 
                (p.price * c.quantity) AS total_price
                FROM orders o
                JOIN cart c ON o.id = c.product_id
                JOIN products p ON c.product_id = p.id
                ORDER BY o.order_date DESC");
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $orders;
    }

    /*
        Type : Return database data.
        Action : Return all orders in orders table.
    */
    function getOrderDetailsById($order_id){
        $sql = $this->db->prepare("SELECT 
            o.id AS order_id, o.order_date, o.status AS order_status,
            p.request_payload AS payment_request_payload,
            p.response_payload AS payment_response_payload,
            p.status AS payment_status
        FROM orders o
        LEFT JOIN payments p ON o.id = p.order_id
        WHERE o.id = {$order_id}");
        $sql->execute();
        return $sql->fetch(PDO::FETCH_ASSOC);
    }

    /*
        Type : Return database data.
        Action : Return refunds in refunds table.
    */
    function getRefundOrderDetails($order_id){
        $sql = $this->db->prepare("SELECT request_payload, response_payload, status 
                            FROM refunds WHERE order_id = {$order_id}");
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    /*
        Type : Return database data.
        Action : Return all product info from products table.
    */
    function getProductInfo(){
        $stmt = $this->db->query("SELECT * FROM products");
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $products;
    }

    /*
        Type : Return database data.
        Action : Return cart total.
    */
    function getCartTotal(){
        $session_id = session_id();
        $sql = $this->db->prepare("SELECT SUM(p.price * c.quantity) AS total FROM cart c JOIN products p ON c.product_id = p.id WHERE c.session_id = '{$session_id}'");
        $sql->execute();
        $total_row =  $sql->fetch(PDO::FETCH_ASSOC);
        return $total_row['total'] ?? 0;
    }

    /*
        Type : Insert data.
        Action : Create new order.
    */
    function createOrder(){
        try{
            $stmt = $this->db->prepare("INSERT INTO orders (order_date, status) VALUES (NOW(), 'pending')");
            $stmt->execute();
            $order_id = $this->db->lastInsertId();
            return $order_id;
        }catch(Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }
}