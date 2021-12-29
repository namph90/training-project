<?php
$this->fileLayout = "layouts/home.php";
?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <section class="content">
                <div class="col-md-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading" style="margin-bottom: 50px;"><h4><?php echo $_GET['action']=='create' ? "User Create" : "User Edit"?></h4></div>
                        <div class="panel-body">
                            <form action="<?php echo getImgUrl($action) ?>" method="post"
                                  style="border: 1px solid black; padding: 20px;" enctype="multipart/form-data">
                                <div class="form-horizontal">
                                    <div class="row" style="margin-top:15px;">
                                        <div class="col-md-2">Avatar</div>
                                        <div class="col-md-10">
                                            <img id="output" class="img-rounded" alt="Ảnh" width="100"
                                                 src="<?php echo isset($data->avatar) ? PATH_UPLOAD_USER.$data->id.'/'.$data->avatar : ""?>"/>
                                            <p><label for="ufile" style="cursor: pointer;">Chọn file ảnh</label></p>
                                            <input name="avatar" id="ufile" type="file" style="display:  none;"
                                                   onchange="loadFile(event)"/>
                                        </div>
                                        <?php if (isset($_SESSION['errCreate']['image'])) : ?>
                                            <?php foreach ($_SESSION['errCreate']['image'] as $key => $value) : ?>
                                                <p style="color: #ff0000;">
                                                    <?php echo $value; ?>
                                                </p>
                                            <?php endforeach ?>
                                        <?php endif ?>
                                    </div>
                                    <div class="row" style="margin-top:15px;">
                                        <div class="col-md-2">Name</div>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control" name="name"
                                                   value="<?php echo isset($data->name) ? $data->name : (isset($_SESSION['dl']['name']) ? $_SESSION['dl']['name'] : "") ?>">
                                            <?php if (isset($_SESSION['errCreate']['name'])) : ?>
                                                <?php foreach ($_SESSION['errCreate']['name'] as $key => $value) : ?>
                                                    <p style="color: #ff0000;">
                                                        <?php echo $value; ?>
                                                    </p>
                                                <?php endforeach ?>
                                            <?php endif ?>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top:15px;">
                                        <div class="col-md-2">Email</div>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control" name="email"
                                                   value="<?php echo isset($data->email) ? $data->email : (isset($_SESSION['dl']['email']) ? $_SESSION['dl']['email'] : "") ?>" <?php if(isset($data->email)): ?> disabled <?php endif; ?>>
                                            <?php if (isset($_SESSION['errCreate']['email'])) : ?>
                                                <?php foreach ($_SESSION['errCreate']['email'] as $key => $value) : ?>
                                                    <p style="color: #ff0000;">
                                                        <?php echo $value; ?>
                                                    </p>
                                                <?php endforeach ?>
                                            <?php endif ?>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top:15px;">
                                        <div class="col-md-2">Password</div>
                                        <div class="col-md-10">
                                            <input type="password" class="form-control" name="password"
                                                   value="<?php echo isset($_SESSION['dl']['password']) ? $_SESSION['dl']['password'] : "" ?>" <?php echo isset($data->password) ? " placeholder = 'Enter this field if you change your password'" : "" ?>>
                                            <?php if (isset($_SESSION['errCreate']['password'])) : ?>
                                                <?php foreach ($_SESSION['errCreate']['password'] as $key => $value) : ?>
                                                    <p style="color: #ff0000;">
                                                        <?php echo $value; ?>
                                                    </p>
                                                <?php endforeach ?>
                                            <?php endif ?>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top:15px;">
                                        <div class="col-md-2">Password Verify</div>
                                        <div class="col-md-10">
                                            <input type="password" class="form-control" name="password_confirm"
                                                   value="<?php echo isset($_SESSION['dl']['password_confirm']) ? $_SESSION['dl']['password_confirm'] : "" ?>">
                                            <?php if (isset($_SESSION['errCreate']['confirmation_pwd'])) : ?>
                                                <?php foreach ($_SESSION['errCreate']['confirmation_pwd'] as $key => $value) : ?>
                                                    <p style="color: #ff0000;">
                                                        <?php echo $value; ?>
                                                    </p>
                                                <?php endforeach ?>
                                            <?php endif ?>
                                            <?php unset($_SESSION['errCreate']) ?>
                                            <?php unset($_SESSION['dl']) ?>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top:15px;">
                                        <div class="col-md-2">Status</div>
                                        <div class="col-md-10">
                                            <input type="radio" name="status"
                                                   value="Active" <?php echo isset($data->status) && $data->status == "Active" ? "checked" : "" ?>>Active
                                            <input type="radio" name="status"
                                                   style="margin-left: 50px;" <?php echo isset($data->status) && $data->status == "Banned" ? "checked" : "" ?>
                                                   value="Banned" <?php if(!isset($data->status)): ?> checked <?php endif; ?>>Banned
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top:15px;">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-10">
                                            <input type="submit" name="submit" value="Create" class="btn btn-primary">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
</div>
<script>
    var loadFile = function (event) {
        var image = document.getElementById('output');
        image.src = URL.createObjectURL(event.target.files[0]);
    };
</script>