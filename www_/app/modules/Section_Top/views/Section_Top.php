<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<?php
	//print_r($this->GP['nv'][LOC_TYPE]);

	$logout_url = "/sec/logout/?type=" . LOC_TYPE;

	if(LOC_TYPE == "school") {
		$u_name = $_SESSION['schoolnm'];
	}else if(LOC_TYPE == "teacher") {
		$u_name = $_SESSION['teachernm'];
	}else if(LOC_TYPE == "student") {
		$u_name = $_SESSION['studentnm'];
	}else{
		$u_name = $_SESSION['sess_id'];
	}
?>
	<nav class="navbar top-navbar navbar-expand-md navbar-dark">
<!-- ============================================================== -->
		<!-- Logo -->
		<!-- ============================================================== -->
		<div class="navbar-header">
			<a class="navbar-brand" href="/">
				<b>
					<img src="<?=IMG_RES?>logo-icon.png" alt="homepage" class="dark-logo" />
					<img src="<?=IMG_RES?>logo-light-icon.png" alt="homepage" class="light-logo" />
				</b>
			</a>
		</div>
		<!-- ============================================================== -->
		<!-- End Logo -->
		<!-- ============================================================== -->
		<div class="navbar-collapse">
			<!-- ============================================================== -->
			<!-- toggle and nav items -->
			<!-- ============================================================== -->
			<ul class="navbar-nav mr-auto">
				<li class="d-none d-md-block d-lg-block">
					<a href="javascript:void(0)" class="p-l-15" style="font-size:21px">
						<!--This is logo text-->
                            <span class="hidden-xs" style="font-size:21px !important; color:#fff !important;">
                                <span class="font-bold">i</span>ENTER
                            </span>
					</a>
				</li>
			</ul>
			<!-- ============================================================== -->
			<!-- User profile and search -->
			<!-- ============================================================== -->
			<ul class="navbar-nav my-lg-0">
				<li class="nav-item dropdown u-pro">
					<a class="nav-link dropdown-toggle waves-effect waves-dark profile-pic" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="<?=IMG_RES?>users/user.jpg" alt="user" class=""> <span class="hidden-md-down"><?=$u_name;?> &nbsp;<i class="fa fa-angle-down"></i></span> </a>
					<div class="dropdown-menu dropdown-menu-right animated flipInY">
						<a href="<?=$logout_url?>" class="dropdown-item"><i class="fa fa-power-off"></i> Logout</a>
					</div>
				</li>
				<!-- ============================================================== -->
				<!-- End User Profile -->
				<!-- ============================================================== -->
				<li class="nav-item right-side-toggle"> <a class="nav-link  waves-effect waves-light" href="javascript:void(0)"><i class="ti-arrow-right ti-arrow-left"></i></a></li>
			</ul>
		</div>
	</nav>