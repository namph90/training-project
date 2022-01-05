<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="/assets/vendor/bootstrap.min.css">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<div class="container" style="width: 500px; margin-top: 200px;">
    <form method="post" action="<?php echo getImgUrl('login') ?>">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h2 class="text-center">Login Form</h2>
            </div>
            <div class="panel-body">
                <?php if (isset($_SESSION['errLogin']['err'])) : ?>
                    <p style="color: #ff0000;">
                        <?php echo $_SESSION['errLogin']['err']; ?>
                    </p>
                <?php endif; ?>
                <?php unset($_SESSION['errLogin']) ?>
                <p class="form-group">
                    <label for="email">Email:</label>
                    <input type="text" class="form-control" id="email" name="email" placeholder="Enter Email"
                           value="<?php echo isset($_SESSION['email_create']) ? $_SESSION['email_create'] : '' ?>">
            </div>
            <div class="form-group">
                <label for="pwd">Password:</label>
                <input type="password" class="form-control" id="pwd" name="password" placeholder="Enter Password">
            </div>
            <div style="text-align: right;" class="form-group"><a href="<?= $loginUrl ?>">Login via Facebook</a></div>
            <button class="btn btn-success" type="submit" name="submit">Login</button>
        </div>
</div>
</form>
</div>
</body>
</html>