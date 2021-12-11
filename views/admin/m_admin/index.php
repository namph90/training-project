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
        <form style="border: 1px solid black; padding: 20px;" method="get">
            <input type="hidden" class="form-control" name="controller" value="admin">
            <input type="hidden" class="form-control" name="action" value="index">
            <div class="form-horizontal">
                <div class="row" style="margin-top:15px;">
                    <div class="col-md-2">Name</div>
                    <div class="col-md-10">
                        <input type="text" class="form-control" name="searchName">
                    </div>
                </div>
                <div class="row" style="margin-top:15px;">
                    <div class="col-md-2">Email</div>
                    <div class="col-md-10">
                        <input type="text" class="form-control" name="searchEmail">
                    </div>
                </div>
                <div class="row" style="margin-top:15px;">
                    <div class="col-md-2"></div>
                    <div class="col-md-10">
                        <input type="submit" value="Search" class="btn btn-primary">
                    </div>
                </div>
            </div>
        </form>
    </div>
    <br><br>
    <div class="panel-body">
        <table class="table table-bordered table-hover thead-light" style="text-align: center;">
            <tr>
                <th style="width: 50px;">Id
                    <a href="index.php?controller=admin&action=index<?php echo isset($_GET['searchName']) ? "&searchName=" . $_GET['searchName'] : "" ?><?php echo isset($_GET['searchEmail']) ? "&searchEmail=" . $_GET['searchEmail'] : "" ?>&order=idAsc ">
                        <i
                                class="fa fa-sort" aria-hidden="true"></i></a></th>
                <th style="width: 100px;">Avatar</th>
                <th style="width:150px;">Name <a
                            href="index.php?controller=admin&action=index<?php echo isset($_GET['searchName']) ? "&searchName=" . $_GET['searchName'] : "" ?><?php echo isset($_GET['searchEmail']) ? "&searchEmail=" . $_GET['searchEmail'] : "" ?>&order=nameAsc"><i
                                class="fa fa-sort" aria-hidden="true"></i></a></th>
                <th style="width: 100px;">Email <a
                            href="index.php?controller=admin&action=index<?php echo isset($_GET['searchName']) ? "&searchName=" . $_GET['searchName'] : "" ?><?php echo isset($_GET['searchEmail']) ? "&searchEmail=" . $_GET['searchEmail'] : "" ?>&order=emailAsc"><i
                                class="fa fa-sort" aria-hidden="true"></i></a></th>
                <th style="width: 80px;">Role <a
                            href="index.php?controller=admin&action=index<?php echo isset($_GET['searchName']) ? "&searchName=" . $_GET['searchName'] : "" ?><?php echo isset($_GET['searchEmail']) ? "&searchEmail=" . $_GET['searchEmail'] : "" ?>&order=roleAsc"><i
                                class="fa fa-sort" aria-hidden="true"></i></a></th>
                <th style="width:70px;">Action</th>
            </tr>
            <?php if (!empty($data)): ?>
                <?php foreach ($data as $rows): ?>
                    <tr>
                        <td><?php echo $rows->id ?></td>
                        <td style="text-align: center;">
                            <?php if (file_exists("assets/upload/admin/" . $rows->id . "/" . $rows->avatar)): ?>
                                <img src="assets/upload/admin/<?php echo $rows->id; ?>/<?php echo $rows->avatar; ?>"
                                     style="width: 70px;">
                            <?php endif; ?>
                        </td>
                        <td><?php echo $rows->name ?></td>
                        <td><?php echo $rows->email ?></td>
                        <td><?php echo $rows->role ?></td>
                        <td style="text-align:center;">
                            <a href="index.php?controller=admin&action=update&id=<?php echo $rows->id; ?>"><i
                                        class="fa fa-pencil" aria-hidden="true"></i></a>&nbsp;&nbsp;&nbsp;
                            <a href="index.php?controller=admin&action=delete&id=<?php echo $rows->id; ?>"
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
        <ul class="pagination">
            <li class="page-item disabled"><a href="#" class="page-link">Trang</a></li>
            <?php for ($i = 1; $i <= $numPage; $i++): ?>
                <li class="page-item"><a href="index.php?<?php echo $_SERVER["QUERY_STRING"] ?>&page=<?php echo $i; ?>"
                                         class="page-link"><?php echo $i; ?></a></li>
            <?php endfor; ?>
        </ul>
    </div>
</div>
