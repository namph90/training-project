<?php
$this->fileLayout = "layouts/home.php";
?>
<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success" style="text-align: center;">
        <strong><?php echo $_SESSION['success']; ?></strong>
    </div>
<?php endif; ?>
<?php unset($_SESSION['success']); ?>

<div class="panel panel-primary">
    <div class="panel-body">
        <form style="border: 1px solid black; padding: 20px;" method="get" action="<?php echo getImgUrl('management/user/search') ?>">
            <div class="form-horizontal">
                <div class="row" style="margin-top:15px;">
                    <div class="col-md-2">Name</div>
                    <div class="col-md-10">
                        <input type="text" class="form-control searchName" name="searchName"
                               value="<?php echo isset($_GET['searchName']) ? $_GET['searchName'] : '' ?>">
                    </div>
                </div>
                <div class="row" style="margin-top:15px;">
                    <div class="col-md-2">Email</div>
                    <div class="col-md-10">
                        <input type="text" class="form-control searchEmail" name="searchEmail"
                               value="<?php echo isset($_GET['searchEmail']) ? $_GET['searchEmail'] : '' ?>">
                    </div>
                </div>
                <div class="row" style="margin-top:15px;">
                    <div class="col-md-2"></div>
                    <div class="col-md-10">
                        <input type="submit" value="Search" class="btn btn-primary">
                        <input type="submit" value="Reset" class="btn btn-danger" onclick="Reset()">
                        <script>
                            function Reset() {
                                document.getElementsByClassName("searchName")[0].removeAttribute("value");
                                document.getElementsByClassName("searchEmail")[0].removeAttribute("value");
                            }
                        </script>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <br><br>
    <div class="panel-body">
        <table class="table table-bordered table-hover thead-light" style="text-align: center;">
            <tr>
                <th style="width: 50px;">
                    <a style="text-decoration: none; color:#34373a ;"
                       href="<?php echo getImgUrl('management/user/search'.$search.'column=id&order='.$asc_or_desc) ?>">
                        ID
                        <i class="fa fa-sort<?php echo $column == 'id' ? '-' . $sort_order : ''; ?>"
                           aria-hidden="true"></i>
                    </a>
                </th>
                <th style="width: 100px;">Avatar</th>
                <th style="width:150px;">
                    <a style="text-decoration: none; color:#34373a ;"
                       href="<?php echo getImgUrl('management/user/search'.$search.'column=name&order='.$asc_or_desc) ?>">
                        Name
                        <i class="fa fa-sort<?php echo $column == 'name' ? '-' . $sort_order : ''; ?>"
                           aria-hidden="true"></i>
                    </a>
                </th>
                <th style="width: 100px;">
                    <a style="text-decoration: none; color:#34373a ;"
                       href="<?php echo getImgUrl('management/user/search'.$search.'column=email&order='.$asc_or_desc) ?>">
                        Email
                        <i class="fa fa-sort<?php echo $column == 'email' ? '-' . $sort_order : ''; ?>"
                           aria-hidden="true"></i>
                    </a>
                </th>
                <th style="width: 80px;">
                    <a style="text-decoration: none; color:#34373a ;"
                       href="<?php echo getImgUrl('management/user/search'.$search.'column=status&order='.$asc_or_desc) ?>">
                        Status
                        <i class="fa fa-sort<?php echo $column == 'status' ? '-' . $sort_order : ''; ?>"
                           aria-hidden="true"></i>
                    </a>
                </th>
                <th style="width:70px;">Action</th>
            </tr>
            <?php if (!empty($data)): ?>
                <?php foreach ($data as $rows): ?>
                    <tr>
                        <td><?php echo $rows->id ?></td>
                        <td style="text-align: center;">
                            <?php if (file_exists(PATH_UPLOAD_USER . $rows->id . "/" . $rows->avatar)): ?>
                                <img src="<?php echo getImgUrl(PATH_UPLOAD_USER . $rows->id . "/" . $rows->avatar); ?>"
                                     style="width: 70px;">
                            <?php endif; ?>
                        </td>
                        <td class="highlight"><?php echo $rows->name ?></td>
                        <td><?php echo $rows->email ?></td>
                        <td><?php echo $rows->status ?></td>
                        <td style="text-align:center;">
                            <a href="<?php echo getImgUrl("management/user/edit/$rows->id") ?>"><i
                                        class="fa fa-pencil" aria-hidden="true"></i></a>&nbsp;&nbsp;&nbsp;
                            <a href="<?php echo getImgUrl("management/user/delete/$rows->id") ?>"
                               onclick="return window.confirm('Are you sure?');"><i class="fa fa-trash-o"
                                                                                    aria-hidden="true"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">No results found!</td>
                </tr>
            <?php endif; ?>
        </table>
        <style type="text/css">
            .pagination {
                padding: 0px;
                margin: 0px;
            }
        </style>
    </div>
</div>
