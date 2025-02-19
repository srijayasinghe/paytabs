<?php
class CartModel{
    public $db;

    /*
        Type : Database results.
        Action : Return cart table data.
    */
    function getCartInfo(){
        $session_id = session_id();
        $stmt = $this->db->prepare("SELECT c.product_id, p.name, p.price, c.quantity, (p.price * c.quantity) AS subtotal 
        FROM cart c 
        JOIN products p ON c.product_id = p.id 
        WHERE c.session_id = '{$session_id}'");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    /*
        Type : Database results.
        Action : Return cart table data.
    */
    function checkCartWithProduct($productId){
        $session_id = session_id();
        $stmt = $this->db->prepare("SELECT id FROM cart WHERE session_id = '{$session_id}' AND product_id = '{$productId}'");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    /*
        Type : Update database.
        Action : update cart table.
    */
    function updateCartWithProduct($productId, $quantity){
        try{
            $session_id = session_id();
            $stmt = $this->db->prepare("UPDATE cart SET quantity = quantity + '{$quantity}'  WHERE session_id = '{$session_id}' AND product_id = '{$productId}'");
            $stmt->execute();
            return true;
        }catch(Exception $e) {
            return false;
        }
    }

    /*
        Type : Insert into database.
        Action : Insert new prodcut info to cart table.
    */
    function insertToCartWithProduct($productId, $quantity){
        try{
            $session_id = session_id();
            $stmt = $this->db->prepare("INSERT INTO cart (session_id, product_id, quantity) VALUES ('{$session_id}', '{$productId}', '{$quantity}')");
            $stmt->execute();
            return true;
        }catch(Exception $e) {
            return false;
        }
    }
}