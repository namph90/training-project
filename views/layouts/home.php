<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/assets/vendor/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/vendor/font-awesome.css">
    <script src="/assets/vendor/jquery.min.js"></script>
    <script src="/assets/vendor/popper.min.js"></script>
    <script src="/assets/vendor/bootstrap.min.js"></script>
</head>
<body>
<?php if (isset($_SESSION["mess"])): ?>
    <script type='text/javascript'>alert("<?php echo LOGIN_SUCCESSFUL ?>");</script>
    <?php unset($_SESSION["mess"]); ?>
<?php endif; ?>

<nav class="navbar bg-light navbar-light">
    <ul class="nav justify-content-end">
        <?php if (isset($_SESSION['admin']) && $_SESSION['admin']['role'] == "Super Admin"): ?>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="index.php" id="navbardrop" data-toggle="dropdown">
                    Admin management
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="<?php echo getImgUrl('management/admin/search') ?>">Search</a>
                    <a class="dropdown-item" href="<?php echo getImgUrl('management/admin/create') ?>">Create</a>
                </div>
            </li>
        <?php endif; ?>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                User management
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="<?php echo getImgUrl('management/user/search') ?>">Search</a>
                <a class="dropdown-item" href="<?php echo getImgUrl('index.php?controller=mUser&action=create') ?>">Create</a>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="<?php echo getImgUrl('management/logout') ?>" >Logout</a>
        </li>
    </ul>
</nav>
<br>

<div class="container">
    <?php echo $this->view ?>
</div>

</body>
</html>



