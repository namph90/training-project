<ul class="pagination">
    <li class="page-item disabled"><a href="#" class="page-link">Trang</a></li>
    <?php $url = explode("&page", $_SERVER["REQUEST_URI"]); ?>
    <?php $url1 = explode("?page", $_SERVER["REQUEST_URI"]); ?>
    <?php if($url1[0] == '/management/admin/search'): ?>
        <?php for ($i = 1; $i <= $numPage; $i++): ?>
        <li class="page-item"><a href="<?php echo $url1[0] ?>?page=<?php echo $i; ?>"
                                 class="page-link"><?php echo $i; ?></a></li>
        <?php endfor; ?>
    <?php else:?>
        <?php for ($i = 1; $i <= $numPage; $i++): ?>
            <li class="page-item"><a href="<?php echo $url[0] ?>&page=<?php echo $i; ?>"
                                     class="page-link"><?php echo $i; ?></a></li>
        <?php endfor; ?>
    <?php endif;?>

</ul>