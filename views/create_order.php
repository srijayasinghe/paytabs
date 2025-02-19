<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once('template/header.php'); ?>
    <title>Document</title>
</head>
<body>
<?php include_once('template/navigation.php'); ?>
    <div class="container">
        <div class="container mt-5">
            <div class="row">
                <!-- Left Side: Product Listing -->
                <div class="col-md-7">
                    <h2>Available Products</h2>
                    <div id="products-list" class="row"></div>
                </div>

                <!-- Right Side: Shopping Cart -->
                <div class="col-md-5">
                    <div class="cart-box">
                        <h2>Shopping Cart</h2>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Qty</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody id="cart-items"></tbody>
                        </table>
                        <h4>Total: <span id="cart-total">0.00</span> LKR</h4>
                        <a href="/checkout" class="btn btn-success w-100">Proceed to Checkout</a>
                    </div>
                </div>
            </div>
        </div>

        <script>
        $(document).ready(function () {
            loadProducts();
            loadCart();

            function loadProducts() {
                $.get("/ajaxproductinfo", function (data) {
                    let productsHtml = "";
                    data.forEach(product => {
                        productsHtml += `
                            <div class="col-md-6">
                                <div class="card p-3 mb-3">
                                    <h4>${product.name}</h4>
                                    <p>Price: ${product.price} LKR</p>
                                    <input type="number" class="form-control mb-2 qty" id="qty_${product.id}" value="1" min="1">
                                    <button class="btn btn-primary add-to-cart w-100" data-id="${product.id}">Add to Cart</button>
                                </div>
                            </div>
                        `;
                    });
                    $("#products-list").html(productsHtml);
                }, "json");
            }

            $(document).on("click", ".add-to-cart", function () {
                let product_id = $(this).data("id");
                let quantity = parseInt($("#qty_" + product_id).val());

                $.ajax({
                    url: "/ajaxaddtocart",
                    method: "POST",
                    contentType: "application/json",
                    data: JSON.stringify({ product_id, quantity }),
                    success: function (response) {
                        alert(response.message);
                        loadCart();
                    }
                });
            });

            function loadCart() {
                $.get("/ajaxcartinfo", function (data) {
                    let cartHtml = "";
                    data.cart.forEach(item => {
                        cartHtml += `
                            <tr>
                                <td>${item.name}</td>
                                <td>${item.quantity}</td>
                                <td>${item.subtotal} LKR</td>
                            </tr>
                        `;
                    });
                    $("#cart-items").html(cartHtml);
                    $("#cart-total").text(data.total_price.toFixed(2));
                }, "json");
            }
        });
        </script>
    </div>
    <?php include_once('template/footer.php'); ?>
</body>
</html>