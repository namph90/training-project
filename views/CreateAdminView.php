<?php
$this->fileLayout = "HomeView.php";
?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <section class="content">
                <div class="col-md-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading" style="margin-bottom: 50px;"><h4>Admin Create</h4></div>
                        <div class="panel-body">
                            <form action="" method="post" style="border: 1px solid black; padding: 10px;">
                                <div class="form-horizontal">
                                    <div class="row" style="margin-top:15px;">
                                        <div class="col-md-2">Avatar</div>
                                        <div class="col-md-10">
                                            <img id="output" class="img-rounded" alt="Ảnh" width="100" src="~/wwwroot/Images/no-image-news.png" />
                                            <p><label for="ufile" style="cursor:  pointer;">Chọn  file  ảnh</label></p>
                                            <input name="ImageFile" id="ufile" type="file" style="display:  none;" onchange="loadFile(event)" />
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top:15px;">
                                        <div class="col-md-2">Name</div>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top:15px;">
                                        <div class="col-md-2">Email</div>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top:15px;">
                                        <div class="col-md-2">Password</div>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top:15px;">
                                        <div class="col-md-2">Password Verify</div>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top:15px;">
                                        <div class="col-md-2">Role</div>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top:15px;">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-10">
                                            <input type="submit" value="Create" class="btn btn-primary">
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
        var image = document.getElementById('output'); image.src = URL.createObjectURL(event.target.files[0]);
    };
</script>