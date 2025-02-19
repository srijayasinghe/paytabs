<?php
class CartController {
    public $model;
    public $config;

    /*
        Return : View.
        Action : Show checkout page.
    */
    public function checkoutAction(){
        return require_once('../views/checkout.php');
    }

    /*
        Type : Ajax.
        Action : Return cart details as ajax.
    */
    public function ajaxCartInfoAction(){
        header('Content-Type: application/json');
        $items  = $this->model->getCartInfo();
        $cart_details = [];
        $total_price = 0;
        foreach($items as $item){
            $cart_details[] = $item;
            $total_price += $item['subtotal'];
        }
        echo json_encode(["cart" => $cart_details, "total_price" => $total_price]);
        exit;
    }


    /*
        Type : Ajax.
        Action : Return status of item adding to cart.
    */
    public function ajaxAddItemsToCartAction(){
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents("php://input"), true);
        $product_id = intval($data['product_id']);
        $quantity = intval($data['quantity']);
        $items  = $this->model->checkCartWithProduct($product_id);

        if (count($items) > 0) {
            $item_update  = $this->model->updateCartWithProduct($product_id, $quantity);
            if($item_update==false){
                echo json_encode(["success" => false, "message" => "Invalid data"]);
                exit;
            }
        }else{
            $insert_cart  = $this->model->insertToCartWithProduct($product_id, $quantity);
            if($insert_cart==false){
                echo json_encode(["success" => false, "message" => "Invalid data"]);
                exit;
            }
        }
        echo json_encode(["success" => true, "message" => "Product added to cart"]);
        exit;
    }

}
