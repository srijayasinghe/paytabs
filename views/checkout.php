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
            <h2>Checkout</h2>

            <form id="checkout-form">
                <div class="mb-3">
                    <label>Full Name:</label>
                    <input type="text" class="form-control" id="name" required>
                </div>
                <div class="mb-3">
                    <label>Email:</label>
                    <input type="email" class="form-control" id="email" required>
                </div>
                <div class="mb-3">
                    <label>Phone:</label>
                    <input type="text" class="form-control" id="phone" required>
                </div>
                <div class="mb-3">
                    <label>Choose Delivery Method:</label>
                    <select class="form-control" id="delivery">
                        <option value="ship">Ship to Address</option>
                        <option value="pickup">Pick-up from Store</option>
                    </select>
                </div>
                <div class="mb-3 shipping-address">
                    <label>Shipping Address:</label>
                    <textarea class="form-control" id="address" placeholder="Enter your address"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Proceed to Payment</button>
            </form>

            <div id="payment-section" class="mt-5" style="display:none;">
                <h3>Complete Your Payment</h3>
                <iframe id="paytabs-frame" width="100%" height="500px" frameborder="0"></iframe>
            </div>
        </div>

        <script>
        $(document).ready(function () {
            $("#delivery").change(function () {
                if ($(this).val() === "ship") {
                    $(".shipping-address").show();
                } else {
                    $(".shipping-address").hide();
                }
            });

            $("#checkout-form").submit(function (e) {
                e.preventDefault();

                let orderData = {
                    name: $("#name").val(),
                    email: $("#email").val(),
                    phone: $("#phone").val(),
                    delivery: $("#delivery").val(),
                    address: $("#delivery").val() === "ship" ? $("#address").val() : "Pick-up"
                };

                $.ajax({
                    url: "/ajaxcreateorder",
                    method: "POST",
                    contentType: "application/json",
                    data: JSON.stringify(orderData),
                    success: function (response) { 
                        if (response.success) {
                            $("#paytabs-frame").attr("src", response.payment_url  + "&framed=true&output=embed");
                            $("#payment-section").show();
                        } else {
                            alert("Error: " + response.message);
                        }
                    }
                });
            });
        });
        </script>
    </div>
    <?php include_once('template/footer.php'); ?>
</body>
</html>