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
            <h2>My Orders</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Order Date</th>
                        <th>Status</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody id="orders-list"></tbody>
            </table>
        </div>

        <script>
            $(document).ready(function () {
                loadOrders();

                function loadOrders() {
                    $.get("/ajaxdetails", function (data) {
                        let ordersHtml = "";
                        data.orders.forEach(order => {
                            ordersHtml += `
                                <tr>
                                    <td>${order.order_id}</td>
                                    <td>${order.order_date}</td>
                                    <td>${order.status}</td>
                                    <td>${order.product_name}</td>
                                    <td>${order.quantity}</td>
                                    <td>${order.price} LKR</td>
                                    <td>${order.total_price} LKR</td>
                                </tr>
                            `;
                        });
                        $("#orders-list").html(ordersHtml);
                    }, "json");
                }
            });
        </script>
    </div>
    <?php include_once('template/footer.php'); ?>
</body>
</html>