<style>
	.account_img{
	width: 30px;
	height: 30px;
	border-radius: 50%;
	margin-bottom: -3px;
	margin-right: 10px;
}
.navbar-expand .navbar-nav .dropdown-menu {
    margin-top: 8px !important;
}
</style>
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
	
	<!-- Sidebar Toggle-->
	<button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" style="padding: 0;" id="sidebarToggle" href="#!"><i class="fas fa-bars" style="font-size: 20px; margin-left: 18px;"></i></button>
	<!-- Navbar Brand-->
	<?php
		include_once('../define/KeySession.php');
		if(isset($_SESSION[KeySession::logged->value]) && $_SESSION[KeySession::logged->value] === true){
		?>
			<a href="#" class="navbar-brand ps-3" style="display: flex; flex-direction: row; align-items: center;">
			<?php
				$currentUser = json_decode($_SESSION[KeySession::userLogin->value]);
				if($currentUser && $currentUser->urlAvatar){
					?>
						<img alt="avatar" class="account_img" src="<?= $currentUser->urlAvatar?>">
					<?php
				} else {
					?>
						<img class="account_img bg-white" src="../../images/userDefaultAvatar.png">
					<?php
				}
			?>
				<?=$currentUser ? $currentUser->name : 'user'?>
			</a>
		<?php } else { 
			header('Location: ../account/login.php');
		}
	?>
	<!-- Navbar Search-->
	<form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
	</form>
	<!-- Navbar-->
	<ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
		<li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i style="margin-right: 10px;" class="fas fa-user"></i><?= $currentUser->username ?></a>
			<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
				<li><a class="dropdown-item" href="#">Thông tin cá nhân</a></li>
				<li><hr class="dropdown-divider" /></li>
				<li>
					<form action="../account/logout_action.php" method="POST">
						<button type="submit" name="logout_btn" class="dropdown-item">Đăng xuất</button>
					</form>
				</li>
			</ul>
		</li>
	</ul>
</nav>