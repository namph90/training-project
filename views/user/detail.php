<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/vendor/bootstrap.min.css">
    <link rel="stylesheet" href="assets/vendor/font-awesome.css">
    <script src="assets/vendor/jquery.min.js"></script>
    <script src="assets/vendor/popper.min.js"></script>
    <script src="assets/vendor/bootstrap.min.js"></script>
</head>
<body>
<?php if (isset($_SESSION["LoginSuccess"])): ?>
    <?php echo $_SESSION["LoginSuccess"]; ?>
    <?php unset($_SESSION["LoginSuccess"]); ?>
<?php endif; ?>
<nav class="navbar bg-light navbar-light">

    <ul class="nav justify-content-end">
        <li class="nav-item">
            <a class="nav-link" href="index.php?controller=user&action=logout">Logout</a>
        </li>
    </ul>
</nav>
<br>

<div class="container">
    <table style="text-align: center; border-collapse: collapse;">
            <tr >
                <td>ID</td>
                <td><?php echo $data->id; ?></td>
            </tr>
            <tr>
                <td>Avatar</td>
                <td><img src="assets/upload/user/<?php echo $data->id; ?>/<?php echo $data->avatar; ?>"
                         style="width:120px;"/></td>
            </tr>
            <tr>
                <td>Name</td>
                <td><?php echo $data->name; ?></td>
            </tr>
            <tr>
                <td>Email</td>
                <td><?php echo $data->email; ?></td>
            </tr>
    </table>
</div>
<style>
    td{
        padding: 20px;
    }
</style>
</body>
</html>




