<div id="layoutSidenav">
	<div id="layoutSidenav_nav">
		<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
			<div class="sb-sidenav-menu">
				<div class="nav">
					<div class="sb-sidenav-menu-heading">Core</div>
					<a class="nav-link" href="../home/index.php">
						<div class="sb-nav-link-icon"><i class="fa-solid fa-house"></i></div>
						Trang chủ
					</a>
					<?php if(isset($_SESSION[KeySession::permission->value])
						&& $_SESSION[KeySession::permission->value] === 'admin') { ?>
					<a class="nav-link" href="../user/user_list.php">
						<div class="sb-nav-link-icon"><i class="fa-solid fa-user-group"></i></div>
						Quản lý nhân viên
					</a>
					<a class="nav-link" href="#">
						<div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
						Quản lý khách hàng
					</a>
					<a class="nav-link" href="#">
						<div class="sb-nav-link-icon"><i class="fa-solid fa-chart-column"></i></div>
						Thống kê
					</a>
					<?php } else if(isset($_SESSION[KeySession::permission->value])
						&& $_SESSION[KeySession::permission->value] === 'personnel') { ?>
					<a class="nav-link" href="../product/product_list.php">
						<div class="sb-nav-link-icon"><i class="fas fa-shirt"></i></div>
						Quản lý sản phẩm
					</a>
					<a class="nav-link" href="#">
						<div class="sb-nav-link-icon"><i class="fas fa-shopping-cart"></i></div>
						Quản lý đơn hàng
					</a>
					<?php } ?>
				</div>
			</div>
		</nav>
	</div>
</div>