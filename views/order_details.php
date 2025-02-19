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
            <h2>Order Details</h2>
            <label for="order_id">Enter Order ID:</label>
            <input type="number" id="order_id" class="form-control w-25 mb-3" placeholder="Enter Order ID">
            <button class="btn btn-primary" id="fetchOrderDetails">Get Order Details</button>

            <div id="order-details" class="mt-4"></div>
        </div>

        <script>
        $(document).ready(function () {
            $("#fetchOrderDetails").click(function () {
                let orderId = $("#order_id").val();
                if (!orderId) {
                    alert("Please enter a valid Order ID.");
                    return;
                }

                $.get("/ajaxorderinfo", { order_id: orderId }, function (response) {
                    if (!response.success) {
                        alert("No order found!");
                        return;
                    }
                    let orderHtml = `
                        <h4>Order #${response.order.order_id}</h4>
                        <p><strong>Order Date:</strong> ${response.order.order_date}</p>
                        <p><strong>Status:</strong> ${response.order.order_status}</p>
                        <h5>Payment Details</h5>
                        <p><strong>Request Payload:</strong> <pre>${JSON.stringify(JSON.parse(response.order.payment_request_payload), null, 2)}</pre></p>
                        <p><strong>Response Payload:</strong> <pre>${JSON.stringify(JSON.parse(response.order.payment_response_payload), null, 2)}</pre></p>
                        <p><strong>Payment Status:</strong> ${response.order.payment_status}</p>
                    `;
                    if (response.order.order_status === "refunded" && response.refunds.length > 0) {
                        orderHtml += `<h5>Refund History</h5>`;
                        response.refunds.forEach(refund => {
                            orderHtml += `
                                <p><strong>Refund Request Payload:</strong> <pre>${JSON.stringify(JSON.parse(refund.request_payload), null, 2)}</pre></p>
                                <p><strong>Refund Response Payload:</strong> <pre>${JSON.stringify(JSON.parse(refund.response_payload), null, 2)}</pre></p>
                                <p><strong>Refund Status:</strong> ${refund.status}</p>
                                <hr>
                            `;
                        });
                    }

                    $("#order-details").html(orderHtml);
                }, "json");
            });
        });
        </script>

    </div>
    <?php include_once('template/footer.php'); ?>
</body>
</html>