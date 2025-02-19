<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once('template/header.php'); ?>
    <title>Document</title>
</head>
<body>
<?php include_once('template/navigation.php'); ?>
    <div class="container">
    <h1>Orders Information</h1>
    <table class="table table-light">
        <tbody>
            <td><a class="btn btn-primary" href="/myorder">My Orders</a></td>
            <td><a class="btn btn-primary" href="/orderdetails">Order Page Details</a></td>
            <td><a class="btn btn-primary" href="/createorder">Create Order</a></td>
        </tbody>
    </table>
    </div>
    <?php include_once('template/footer.php'); ?>
</body>
</html>