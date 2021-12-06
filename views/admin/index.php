<?php
$this->fileLayout = "layouts/home.php";
?>
<div class="panel panel-primary">
    <div class="panel-body">
        <table class="table table-bordered table-hover thead-light" style="text-align: center;">
            <tr>
                <th style="width: 50px;">Id</th>
                <th style="width: 100px;">Avatar</th>
                <th style="width:150px;">Name <a href=""><i class="fa fa-sort" aria-hidden="true"></i></a></th>
                <th style="width: 100px;">Email <a href=""><i class="fa fa-sort" aria-hidden="true"></i></a></th>
                <th style="width: 80px;">Role <a href=""><i class="fa fa-sort" aria-hidden="true"></i></a></th>
                <th style="width:70px;">Action</th>
            </tr>
            <?php foreach($data as $rows): ?>
                <tr>
                    <td><?php echo $rows->id ?></td>
                    <td style="text-align: center;">
                        <?php if(file_exists("assets/upload/".$rows->avatar)): ?>
                            <img src="assets/upload/<?php echo $rows->avatar; ?>" style="width: 70px;">
                        <?php endif; ?>
                    </td>
                    <td><?php echo $rows->name ?></td>
                    <td><?php echo $rows->email ?></td>
                    <td><?php echo $rows->role ?></td>
                    <td style="text-align:center;">
                        <a href="index.php?controller=admin&action=update&id=<?php echo $rows->id; ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>&nbsp;&nbsp;&nbsp;
                        <a href="index.php?controller=admin&action=delete&id=<?php echo $rows->id; ?>" onclick="return window.confirm('Are you sure?');"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <style type="text/css">
            .pagination{padding:0px; margin:0px;}
        </style>
    </div>
</div>
