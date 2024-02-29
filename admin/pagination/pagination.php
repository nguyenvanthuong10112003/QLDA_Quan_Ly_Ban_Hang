<?php 
if ($totalPage > 0) {
?>
<nav aria-label="...">
  <ul class="pagination" style="float: right;">
    <li class="page-item" disabled>
      <a class="page-link text-white" style="background-color: #212529;" href="?per_page=<?= $item_per_page ?>&page=1&input_value=<?= $search ? $search : '' ?>">
        <span aria-hidden="true">First</span>
      </a>
    </li>
    <?php if ($current_page > 1){ ?>
      <li class="page-item" disabled>
        <span style="cursor:default;" class="page-link d-flex justify-content-center align-items-center">
          <span aria-hidden="true">...</span>
        </span>
      </li>
    <?php } ?>

    <?php for ($num = 1; $num <= $totalPage; $num++){ ?>
      <?php if ($num > $current_page - 3 && $num < $current_page + 3){?>
        <li class="page-item <?= $num == $current_page ? 'active' : '' ?>" >
            <a class="page-link" href="?per_page=<?= $item_per_page ?>&page=<?= $num ?>&input_value=<?= $search ? $search : '' ?>"><?= $num ?></a>
        </li>
        <?php }?>  
    <?php } ?>
        
    <?php if ($current_page < $totalPage){ ?>
      <li class="page-item">
        <span style="cursor:default;" class="page-link d-flex justify-content-center align-items-center">
          <span aria-hidden="true">...</span>
        </span>
      </li>
    <?php } ?>
    <li class="page-item" disabled>
      <a class="page-link text-white" style="background-color: #212529;" href="?per_page=<?= $item_per_page ?>&page=<?= $totalPage ?>&input_value=<?= $search ? $search : '' ?>">
        <span aria-hidden="true">Last</span>
      </a>
    </li>
    </ul>
</nav>
<?php
}
?>
