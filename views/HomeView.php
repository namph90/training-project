<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
<?php if(isset($_SESSION["LoginSuccess"])): ?>
    <?php echo $_SESSION["LoginSuccess"]; ?>
    <?php unset($_SESSION["LoginSuccess"]); ?>
<?php endif; ?>
<nav class="navbar bg-light navbar-light">

    <ul class="nav justify-content-end">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                Admin management
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="#">Search</a>
                <a class="dropdown-item" href="index.php?controller=admin&action=create">Create</a>
            </div>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                User management
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="#">Search</a>
                <a class="dropdown-item" href="#">Create</a>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="index.php?controller=admin&action=logout">Logout</a>
        </li>
    </ul>
</nav>
<br>

<div class="container">
    <?php echo $this->view; ?>
</div>

</body>
</html>

