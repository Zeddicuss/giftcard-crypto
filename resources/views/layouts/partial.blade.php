<!DOCTYPE html>
<html lang="en">

<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
	<!-- Title -->
	<title>JT Cards| Giftcard</title>

	<!-- Meta -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="author" content="DexignZone">
	<meta name="robots" content="index, follow">
	<meta name="keywords" content="">   
	<meta name="description" content="">
	<meta property="og:title" content="">
	<meta property="og:description" content="">
	<meta property="og:image" content="">
	<meta name="format-detection" content="">
	<meta name="twitter:title" content="">
	<meta name="twitter:description" content="">
	<meta name="twitter:image" content="../../social-image.png">
	<meta name="twitter:card" content="summary_large_image">
	<!-- Mobile Specific -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, minimal-ui, viewport-fit=cover">
    <!-- Favicon icon -->
	<link href="{{asset('images/favicon.png')}}" type="" rel="icon">
	<link href="{{asset('images/favicon.png')}}" type="" rel="shortcut icon">
	<link rel="stylesheet" href="{{asset('vendor/jquery-nice-select/css/nice-select.css')}}">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Icons">		
	<link rel="stylesheet" href="{{asset('vendor/swiper/css/swiper-bundle.min.css')}}">
	<link rel="stylesheet" href="{{asset('vendor/sweetalert2/dist/sweetalert2.min.css')}}">	
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">			
	<link rel="stylesheet" href="{{asset('css/style.css')}}" class="main-css">
	<link rel="stylesheet" href="{{asset('vendor/datatables/css/jquery.dataTables.min.css')}}">	
	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    
</head>
<body>

    <!--*******************
        Preloader start
    ********************-->
    <div id="loader">
	</div>    
	<!--*******************
        Preloader end
    ********************-->
    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

   	 
<div class="nav-header" style="background-color: #19066B;">
	@if(auth()->check() && auth()->user()->role !== 'admin')
	<a href="{{route('admin.dashboard')}}" class="brand-logo">
        <img src="{{asset('images/logo/logo-text.png')}}" class="brand-title" alt="" width="100" height="50">
        <img src="{{asset('images/logo/logo-color.png')}}" class="logo-color" alt="" width="100" height="50">
        <img src="{{asset('images/logo/logo-text-color.png')}}" class="brand-title color-title" alt="" width="100" height="50">
    </a>
	@endif
	@if(auth()->check() && auth()->user()->role == 'admin')
    <a href="{{route('admin.dashboard')}}" class="brand-logo">
		<img src="{{asset('images/logo/logo-text.png')}}" class="brand-title" alt="" width="100" height="50">
        <img src="{{asset('images/logo/logo-color.png')}}" class="logo-color" alt="" width="100" height="50">
        <img src="{{asset('images/logo/logo-text-color.png')}}" class="brand-title color-title" alt="" width="100" height="50">
    </a>
	@endif
    <div class="nav-control">
        <div class="hamburger">
            <span class="line"></span><span class="line"></span><span class="line"></span>
            <svg width="16" height="16" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect x="22" y="11" width="4" height="4" rx="2" fill="#2A353A" />
                <rect x="11" width="4" height="4" rx="2" fill="#2A353A" />
                <rect x="22" width="4" height="4" rx="2" fill="#2A353A" />
                <rect x="11" y="11" width="4" height="4" rx="2" fill="#2A353A" />
                <rect x="11" y="22" width="4" height="4" rx="2" fill="#2A353A" />
                <rect width="4" height="4" rx="2" fill="#2A353A" />
                <rect y="11" width="4" height="4" rx="2" fill="#2A353A" />
                <rect x="22" y="22" width="4" height="4" rx="2" fill="#2A353A" />
                <rect y="22" width="4" height="4" rx="2" fill="#2A353A" />
            </svg>
        </div>
    </div>
</div>        
<!--**********************************
            Nav header end
        ***********************************-->
		
		<!--**********************************
            Header start
        ***********************************-->
		<div class="header">
			<div class="header-content">
				<nav class="navbar navbar-expand">
					<div class="collapse navbar-collapse justify-content-between">
						<div class="header-left">
							<div class="dashboard_bar">
								{{ $title ?? 'Default Title' }}                    
							</div>
						</div>
						<div class="navbar-nav header-right">
							<div class="nav-item d-flex align-items-center">
								<div class="input-group search-area">
									<span class="input-group-text"><a href="javascript:void(0)"><svg width="24" height="24"
												viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path
													d="M20.5605 18.4395L16.7527 14.6317C17.5395 13.446 18 12.0262 18 10.5C18 6.3645 14.6355 3 10.5 3C6.3645 3 3 6.3645 3 10.5C3 14.6355 6.3645 18 10.5 18C12.0262 18 13.446 17.5395 14.6317 16.7527L18.4395 20.5605C19.0245 21.1462 19.9755 21.1462 20.5605 20.5605C21.1462 19.9747 21.1462 19.0252 20.5605 18.4395V18.4395ZM5.25 10.5C5.25 7.605 7.605 5.25 10.5 5.25C13.395 5.25 15.75 7.605 15.75 10.5C15.75 13.395 13.395 15.75 10.5 15.75C7.605 15.75 5.25 13.395 5.25 10.5V10.5Z"
													fill="var(--primary)" />
											</svg>

										</a></span>
									<input type="text" class="form-control" placeholder="Search here...">
								</div>
							</div>
							<div class="dz-side-menu">
								<div class="search-coundry d-flex align-items-center">
									<img src="../images/United.png" alt="">
									<select class="default-select dashboard-select image-select">
										<option data-display="Eng">Eng</option>
										<option value="2">Af</option>
										<option value="2">Al</option>
									</select>
								</div>
								
								<ul>
									<li class="nav-item dropdown header-profile">
										<a class="nav-link" href="javascript:void(0);" role="button" data-bs-toggle="dropdown">
											<img src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : '../images/profile/pic1.png' }}" alt="">
										</a>
										<div class="dropdown-menu dropdown-menu-end" style="">
											<a href="{{route('profile.show')}}" class="dropdown-item ai-icon ">
												<svg xmlns="http://www.w3.org/2000/svg"
													xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
													viewBox="0 0 24 24" version="1.1" class="svg-main-icon">
													<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
														<polygon points="0 0 24 0 24 24 0 24" />
														<path
															d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z"
															fill="#000000" fill-rule="nonzero" opacity="0.3" />
														<path
															d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z"
															fill="var(--primary)" fill-rule="nonzero" />
													</g>
												</svg>
												<span class="ms-2">Profile </span>
											</a>
											
											
											<a href="" class="dropdown-item ai-icon" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
												<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
													viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2"
													stroke-linecap="round" stroke-linejoin="round">
													<path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
													<polyline points="16 17 21 12 16 7"></polyline>
													<line x1="21" y1="12" x2="9" y2="12"></line>
												</svg>
												<span class="ms-2">Logout </span>
												<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
													@csrf
												</form>
											</a>
										</div>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</nav>
			</div>
		</div>        
		<!--**********************************
            Header end ti-comment-alt
        ***********************************-->

		@include('layouts.nav')

		@yield('content')

		 <!--**********************************
            Footer start
        ***********************************-->
<div class="footer out-footer">
    <div class="copyright">
        <p>Copyright © Developed by <a href="#" target="_blank">Zeddicus Zul</a> 2024</p>
    </div>
</div>        <!--**********************************
            Footer end
        ***********************************-->

    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    	<script src="{{asset('vendor/global/global.min.js')}}"></script>
		<script src="{{asset('vendor/jquery-nice-select/js/jquery.nice-select.min.js')}}"></script>		
		<script src="{{asset('vendor/chart.js/Chart.bundle.min.js')}}"></script>
		<script src="{{asset('vendor/apexchart/apexchart.js')}}"></script>
		<script src="{{asset('js/dashboard/dashboard-2.js')}}"></script>
		<script src="{{asset('vendor/peity/jquery.peity.min.js')}}"></script>
		<script src="{{asset('vendor/swiper/js/swiper-bundle.min.js')}}"></script>		
		<script src="{{asset('js/custom.min.js')}}"></script>
		<script src="{{asset('js/deznav-init.js')}}"></script>
		<script src="{{asset('js/demo.js')}}"></script>
		<script src="{{asset('js/styleSwitcher.js')}}"></script>  
		<script src="{{asset('vendor/masonry/masonry-4.2.2.js')}}"></script>
        <script src="{{asset('vendor/masonry/isotope.pkgd.min.js')}}"></script> 
		<script src="{{asset('vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
        <script src="{{asset('js/plugins-init/datatables.init.js')}}"></script>   
		<script src="{{asset('vendor/sweetalert2/dist/sweetalert2.min.js')}}"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>	
		<script src="../vendor/jquery-nice-select/js/jquery.nice-select.min.js"></script>		<!-- Page level js :form-wizard  -->
		<script src="../vendor/jquery-steps/build/jquery.steps.min.js"></script>
		<script src="../vendor/toastr/js/toastr.min.js"></script>
		<script src="../js/plugins-init/toastr-init.js"></script>	
		<!-- Bootstrap JS (including Popper.js) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        
</script>   
</body>
</html>
