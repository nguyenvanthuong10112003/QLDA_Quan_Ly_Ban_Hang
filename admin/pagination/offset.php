<?php
       $item_per_page =!empty($_GET['per_page'])?$_GET['per_page']:10;
       $current_page = !empty($_GET['page'])?$_GET['page']:1;
       // offset  = (page - 1) * per_page
       $offset = ($current_page - 1) * $item_per_page;