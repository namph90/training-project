<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="assets/vendor/bootstrap.min.css">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<div class="container" style="width: 500px; margin-top: 200px;">
    <form method="post" action="index.php?controller=user&action=loginPost">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h2 class="text-center">Login Form</h2>
            </div>
            <div class="panel-body">
                <p class="form-group">
                    <label for="email">Email:</label>
                    <input type="text" class="form-control" id="email" name="email" placeholder="Enter Email"
                           value="<?php echo isset($_SESSION['email_create']) ? $_SESSION['email_create'] : '' ?>">
                    <?php if (isset($_SESSION['errorsEmail'])) : ?>
                <p style="color: #ff0000;">
                    <?php echo $_SESSION['errorsEmail'] ?>
                </p>
                <?php endif ?>
                <?php unset($_SESSION['errorsEmail']) ?>
                <?php unset($_SESSION['email_create']) ?>

            </div>
            <div class="form-group">
                <label for="pwd">Password:</label>
                <input type="password" class="form-control" id="pwd" name="password" placeholder="Enter Password">
                <?php if (isset($_SESSION['errorsPass'])) : ?>
                    <p style="color: #ff0000;">
                        <?php echo $_SESSION['errorsPass'] ?>
                    </p>
                <?php endif ?>
                <?php unset($_SESSION['errorsPass']) ?>
            </div>
            <div style="text-align: right;" class="form-group"><a href="">Login via Facebook</a></div>
            <button class="btn btn-success" type="submit" name="submit">Login</button>
        </div>
</div>
</form>
</div>
</body>
</html>