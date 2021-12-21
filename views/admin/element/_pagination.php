<ul class="pagination">
    <li class="page-item disabled"><a href="#" class="page-link">Trang</a></li>
    <?php $url = explode("&page", $_SERVER["QUERY_STRING"]); ?>
    <?php for ($i = 1; $i <= $numPage; $i++): ?>
        <li class="page-item"><a href="index.php?<?php echo $url[0] ?>&page=<?php echo $i; ?>"
                                 class="page-link"><?php echo $i; ?></a></li>
    <?php endfor; ?>
</ul>