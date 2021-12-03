<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div class="container" style="width: 500px; margin-top: 200px;">
        <form method="post" action="index.php?controller=Admin&action=loginPost">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h2 class="text-center">Login Form</h2>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="text" class="form-control" id="email" name="email" placeholder="Enter Email">
                        <?php if (isset($_SESSION['errorsEmail'])) : ?>
                            <?php foreach ($_SESSION['errorsEmail'] as $key => $value) : ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo $value; ?>
                                </div>
                            <?php endforeach ?>
                        <?php endif ?>
                        <?php unset($_SESSION['errorsEmail']) ?>

                    </div>
                    <div class="form-group">
                        <label for="pwd">Password:</label>
                        <input type="password" class="form-control" id="pwd" name="password" placeholder="Enter Password">
                        <?php if(isset($_SESSION['errorsPass'])): ?>
                            <?php foreach ($_SESSION['errorsPass'] as $key => $value) : ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo $value; ?>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <?php unset($_SESSION['errorsPass']); ?>
                    </div>
                    <button class="btn btn-success" type="submit" name="submit">Login</button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>