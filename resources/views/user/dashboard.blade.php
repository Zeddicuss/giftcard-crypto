@extends('layouts.partial')

@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<!--**********************************
            Content body start
        ***********************************-->
<div class="content-body default-height ">
	<div class="container-fluid">
	<div class="row">
		<div class="col-xl-12">
			<div class="row main-card">
				<!-- column -->
				<div class="col-xxl-9 col-lg-12">
					<div class="swiper crypto-Swiper position-relative overflow-hidden">
						<div class="swiper-wrapper ">
							<div class="swiper-slide">
								<div class="card coin-card bg-secondary">
									<div class="back-image">
										<svg width="121" height="221" viewBox="0 0 121 221" fill="none"
											xmlns="http://www.w3.org/2000/svg">
											<circle cx="135.5" cy="84.5" r="40" stroke="#BE7CFF" />
											<circle cx="136" cy="85" r="135.5" stroke="#BE7CFF" />
											<circle cx="136" cy="85" r="109.5" stroke="#BE7CFF" />
											<circle cx="136" cy="85" r="86.5" stroke="#BE7CFF" />
											<circle cx="136" cy="85" r="64.5" stroke="#BE7CFF" />
										</svg>
									</div>
									<div class="card-body p-4 ">
										<div class="title">
											<h4>Payouts</h4>
											<i class="material-icons" style="color: white;" width="57" height="93" >account_balance_wallet</i>
										</div>
										<div class="chart-num">
											@php
											$user = Auth::user();
											$totalAmount = App\Models\Order::
												where('seller', $user->id)
												->where('status', 'completed')
												->sum('amount_in_naira');
											@endphp
											@if($totalAmount > 0)
											<br>
												<h2>Payouts: ₦{{ number_format($totalAmount, 2) }}</h2>
											@else
											<br>
												<h2>No Payouts yet.</h2>
											@endif
										</div>
										
									</div>
								</div>
							</div>
							<div class="swiper-slide">
								<div class="card coin-card bg-success">
									<div class="back-image">
										<svg width="121" height="221" viewBox="0 0 121 221" fill="none"
											xmlns="http://www.w3.org/2000/svg">
											<circle cx="135.5" cy="84.5" r="40" stroke="#1ABAFF" />
											<circle cx="136" cy="85" r="135.5" stroke="#1ABAFF" />
											<circle cx="136" cy="85" r="109.5" stroke="#1ABAFF" />
											<circle cx="136" cy="85" r="86.5" stroke="#1ABAFF" />
											<circle cx="136" cy="85" r="64.5" stroke="#1ABAFF" />
										</svg>
									</div>
									<div class="card-body p-4  ">
										<div class="title">
											<h4>Giftcards Sold</h4>
											<i class="material-icons" style="color: white;" width="57" height="93" >credit_card</i>
										</div>
										<div class="chart-num">
											@php
											$user = Auth::user();
											$totalGiftCardsSold = \App\Models\Order::where('seller', $user->id)
																					->where('order_type', 'giftcard')
																					->where('status', 'completed')
																					->count();
											@endphp
											@if($totalGiftCardsSold > 0)
											<br>
												<h2>{{ $totalGiftCardsSold }} Giftcards Sold</h2>
											@else
											<br>
												<h2>No Giftcards sold yet.</h2>
											@endif
										</div>
									</div>
								</div>
							</div>
							<div class="swiper-slide">
								<div class="card coin-card bg-warning">
									<div class="back-image">
										<svg width="121" height="221" viewBox="0 0 121 221" fill="none"
											xmlns="http://www.w3.org/2000/svg">
											<circle cx="135.5" cy="84.5" r="40" stroke="#40CD68" />
											<circle cx="136" cy="85" r="135.5" stroke="#40CD68" />
											<circle cx="136" cy="85" r="109.5" stroke="#40CD68" />
											<circle cx="136" cy="85" r="86.5" stroke="#40CD68" />
											<circle cx="136" cy="85" r="64.5" stroke="#40CD68" />
										</svg>
									</div>
									<div class="card-body p-4 ">
										<div class="title">
											<h4>Cryptos Sold</h4>
											<i class="material-icons" style="color: white;" width="57" height="93" >currency_bitcoin</i>
										</div>
										<div class="chart-num">
											@php
											$user = Auth::user();
											$totalCryptoSold = \App\Models\Order::where('seller', $user->id)
																				->where('order_type', 'crypto')
																				->where('status', 'completed')
																				->count();
											@endphp
											@if($totalCryptoSold > 0)
											<br>
											<h2>{{ $totalCryptoSold }} Crypto sold</h2>
											@else
											<br>
												<h2>No Cryptos sold yet.</h2>
											@endif
										</div>
									</div>
								</div>
							</div>
							{{-- <div class="swiper-slide">
								<div class="card coin-card bg-pink">
									<div class="back-image">
										<svg width="121" height="221" viewBox="0 0 121 221" fill="none"
											xmlns="http://www.w3.org/2000/svg">
											<circle cx="135.5" cy="84.5" r="40" stroke="#F272FD" />
											<circle cx="136" cy="85" r="135.5" stroke="#F272FD" />
											<circle cx="136" cy="85" r="109.5" stroke="#F272FD" />
											<circle cx="136" cy="85" r="86.5" stroke="#F272FD" />
											<circle cx="136" cy="85" r="64.5" stroke="#F272FD" />
										</svg>
									</div>
									<div class="card-body p-4">
										<div class="title">
											<h4>Ethereum Sold</h4>
											<i class="fa-brands fa-ethereum" style="color: white; font-size:30px;" width="57" height="93"></i>
										</div>
										<div class="chart-num">
											@php
											$user = Auth::user();
											$totalCompletedOrderAmount = \App\Models\Order::where('seller', $user->id)
																						->where('status', 'completed')
																						->sum('amount_in_naira');
											@endphp
											@if($totalCompletedOrderAmount > 0)
											<br>
											<h2>Total Payouts: {{ $totalCompletedOrderAmount }}</h2>
											@else
											<br>
												<h2>No Etherum sold yet.</h2>
											@endif
										</div>
									</div>
								</div>
							</div> --}}
						</div>
					</div>
					
					<div class="row">
						<div class="col-sm-6">
							<div class="card exchange">
								<div class="card-header d-block border-0 pb-0">
									<h2 class="heading"> </h2>
								</div>
								<div class="card-body pt-0">
									<div class="balance">
										<div class="header-content">
											<h6 class="text-muted"></h6>
										</div>
										<div class="d-flex justify-content-between align-items-baseline">
											<h4 class="count-num"><a href="{{route('crypto.buy')}}">Buy CryptoCurrency</a></h4>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="card exchange">
								<div class="card-header d-block border-0 pb-0">
									<h2 class="heading"> </h2>
								</div>
								<div class="card-body pt-0">
									<div class="balance">
										<div class="header-content">
											<h6 class="text-muted"></h6>
										</div>
										<div class="d-flex justify-content-between align-items-baseline">
											<h4 class="count-num"><a href="{{route('crypto.sell')}}">Sell CryptoCurrency</a></h4>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="card exchange">
								<div class="card-header d-block border-0 pb-0">
									<h2 class="heading"> </h2>
								</div>
								<div class="card-body pt-0">
									<div class="balance">
										<div class="header-content">
											<h6 class="text-muted"></h6>
										</div>
										<div class="d-flex justify-content-between align-items-baseline">
											<h4 class="count-num"><a href="{{route('giftcard.sell')}}">Sell GiftCard</a></h4>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- /column -->
					</div>
					<!-- /row -->
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-body p-4">
									<h4 class="card-intro-title"></h4>
									<div class="bootstrap-carousel">
										<div class="carousel slide" data-bs-ride="carousel">
											<div class="carousel-inner">
												<div class="carousel-item active">
													<img class="d-block w-100" src="../images/big/img3.jpg" alt="First slide">
												</div>
												<div class="carousel-item">
													<img class="d-block w-100" src="../images/big/img4.jpg" alt="Second slide">
												</div>
												<div class="carousel-item">
													<img class="d-block w-100" src="../images/big/img5.jpg" alt="Third slide">
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- /column -->
					</div>
					<!-- /row -->
				</div>
				<!-- /column -->
				<!-- column -->
				<div class="col-xxl-3 col-lg-12">
					<!-- row -->
					<div class="row">
						<!-- column -->
						<div class="col-xxl-12 col-lg-6">
							<div class="card market-previews-2">
								<div class="card-header border-0 pb-0">
									<div>
										<h2 class="heading">Market Previews</h2>
									</div>
								</div>
								<div class="card-body pt-0 px-0">
									<div class="previews-info-list">
										<div class="pre-icon">
											<span class="icon-box icon-box-sm bg-success">
												<svg width="17" height="16" viewBox="0 0 17 16" fill="none"
													xmlns="http://www.w3.org/2000/svg">
													<path
														d="M15.5 13.7222H7.72226C7.44585 13.7236 7.17885 13.6219 6.9734 13.437C6.76794 13.2521 6.63878 12.9972 6.61115 12.7222L6.9667 9.05553L10.2445 8.16664C10.5392 8.08707 10.7902 7.8937 10.9423 7.62907C11.0944 7.36443 11.1352 7.05021 11.0556 6.75553C10.976 6.46084 10.7827 6.20983 10.518 6.05772C10.2534 5.90561 9.93916 5.86485 9.64448 5.94442L7.21115 6.6333L7.72226 1.61108C7.75173 1.3164 7.66292 1.02208 7.47539 0.792865C7.28785 0.563654 7.01694 0.418329 6.72226 0.38886C6.42757 0.359392 6.13325 0.448194 5.90404 0.63573C5.67483 0.823266 5.5295 1.09418 5.50004 1.38886L4.91115 7.3333L1.8667 8.16664C1.57202 8.20642 1.30521 8.36164 1.12496 8.59814C0.944719 8.83464 0.865809 9.13306 0.905592 9.42775C0.945374 9.72243 1.10059 9.98925 1.33709 10.1695C1.5736 10.3497 1.87202 10.4286 2.1667 10.3889C2.26605 10.405 2.36736 10.405 2.4667 10.3889L4.68893 9.75553L4.38892 12.6111C4.38892 13.4951 4.74011 14.343 5.36523 14.9681C5.99036 15.5932 6.8382 15.9444 7.72226 15.9444H15.5C15.7947 15.9444 16.0773 15.8274 16.2857 15.619C16.4941 15.4106 16.6111 15.128 16.6111 14.8333C16.6111 14.5386 16.4941 14.256 16.2857 14.0476C16.0773 13.8393 15.7947 13.7222 15.5 13.7222Z"
														fill="#FCFCFC"></path>
												</svg>
											</span>
											<div class="ms-2">
												<h6>LTC/Year</h6>
												<span>March</span>
											</div>
										</div>
										<div class="count">
											<h6>120.45</h6>
											<span class="text-success">1,24%</span>
										</div>
									</div>
									<div class="previews-info-list">
										<div class="pre-icon">
											<span class="icon-box icon-box-sm bg-warning">
												<svg width="17" height="21" viewBox="0 0 17 21" fill="none"
													xmlns="http://www.w3.org/2000/svg">
													<path
														d="M13.2472 9.15687C13.6996 8.48871 13.9615 7.70994 14.0047 6.90419C14.0479 6.09844 13.8707 5.29615 13.4924 4.58346C13.114 3.87078 12.5486 3.27462 11.857 2.85901C11.1653 2.4434 10.3735 2.22404 9.56662 2.22448V1.11337C9.56662 0.818684 9.44956 0.536069 9.24119 0.327695C9.03281 0.119321 8.7502 0.0022583 8.45551 0.0022583C8.16083 0.0022583 7.87821 0.119321 7.66984 0.327695C7.46146 0.536069 7.3444 0.818684 7.3444 1.11337V2.22448H5.12218V1.11337C5.12218 0.818684 5.00512 0.536069 4.79674 0.327695C4.58837 0.119321 4.30575 0.0022583 4.01107 0.0022583C3.71638 0.0022583 3.43377 0.119321 3.22539 0.327695C3.01702 0.536069 2.89996 0.818684 2.89996 1.11337V2.22448H1.78885C1.49416 2.22448 1.21154 2.34154 1.00317 2.54992C0.794797 2.75829 0.677734 3.04091 0.677734 3.33559C0.677734 3.63028 0.794797 3.91289 1.00317 4.12127C1.21154 4.32964 1.49416 4.4467 1.78885 4.4467H2.89996V15.5578H1.78885C1.49416 15.5578 1.21154 15.6749 1.00317 15.8833C0.794797 16.0916 0.677734 16.3742 0.677734 16.6689C0.677734 16.9636 0.794797 17.2462 1.00317 17.4546C1.21154 17.663 1.49416 17.78 1.78885 17.78H2.89996V18.8911C2.89996 19.1858 3.01702 19.4684 3.22539 19.6768C3.43377 19.8852 3.71638 20.0023 4.01107 20.0023C4.30575 20.0023 4.58837 19.8852 4.79674 19.6768C5.00512 19.4684 5.12218 19.1858 5.12218 18.8911V17.78H7.3444V18.8911C7.3444 19.1858 7.46146 19.4684 7.66984 19.6768C7.87821 19.8852 8.16083 20.0023 8.45551 20.0023C8.7502 20.0023 9.03281 19.8852 9.24119 19.6768C9.44956 19.4684 9.56662 19.1858 9.56662 18.8911V17.78H11.7888C12.8383 17.7828 13.8548 17.413 14.6572 16.7367C15.4597 16.0603 15.9962 15.1211 16.1712 14.0863C16.3462 13.0515 16.1484 11.9882 15.613 11.0855C15.0776 10.1829 14.2393 9.49948 13.2472 9.15693V9.15687ZM5.12218 4.4467H9.56662C10.156 4.4467 10.7212 4.68083 11.138 5.09758C11.5547 5.51432 11.7888 6.07956 11.7888 6.66893C11.7888 7.2583 11.5547 7.82353 11.138 8.24027C10.7212 8.65702 10.156 8.89115 9.56662 8.89115H5.12218V4.4467ZM11.7888 15.5578H5.12218V11.1134H11.7888C12.3782 11.1134 12.9434 11.3475 13.3602 11.7642C13.7769 12.181 14.0111 12.7462 14.0111 13.3356C14.0111 13.925 13.7769 14.4902 13.3602 14.9069C12.9434 15.3237 12.3782 15.5578 11.7888 15.5578Z"
														fill="#FCFCFC"></path>
												</svg>
											</span>
											<div class="ms-2">
												<h6>BTC/Year</h6>
												<span class="text-gray">January</span>
											</div>
										</div>
										<div class="count">
											<h6>120.45</h6>
											<span>1,24%</span>
										</div>
									</div>
									<div class="previews-info-list">
										<div class="pre-icon">
											<span class="icon-box icon-box-sm bg-pink">
												<svg width="21" height="22" viewBox="0 0 21 22" fill="none"
													xmlns="http://www.w3.org/2000/svg">
													<path
														d="M15.8893 12.6666C15.4127 12.6738 14.9402 12.7563 14.4893 12.9111L12.8893 11L14.4893 9.08887C14.9402 9.24363 15.4127 9.32613 15.8893 9.33331C16.9087 9.33828 17.8988 8.99266 18.6937 8.35439C19.4886 7.71613 20.0399 6.82401 20.2552 5.8276C20.4705 4.83118 20.3367 3.79104 19.8763 2.88154C19.4158 1.97203 18.6567 1.24845 17.7262 0.832085C16.7957 0.415724 15.7504 0.331894 14.7654 0.594648C13.7804 0.857402 12.9157 1.45077 12.3163 2.27528C11.7168 3.09978 11.4189 4.10531 11.4727 5.12331C11.5265 6.1413 11.9285 7.10987 12.6115 7.86665L10.9226 9.88887H9.06709C8.79666 8.84147 8.15351 7.92866 7.2582 7.32153C6.36289 6.71441 5.27689 6.45465 4.20376 6.59096C3.13063 6.72726 2.14406 7.25027 1.42896 8.06194C0.713861 8.87362 0.319336 9.91823 0.319336 11C0.319336 12.0817 0.713861 13.1263 1.42896 13.938C2.14406 14.7497 3.13063 15.2727 4.20376 15.409C5.27689 15.5453 6.36289 15.2856 7.2582 14.6784C8.15351 14.0713 8.79666 13.1585 9.06709 12.1111H10.9226L12.6115 14.1333C11.9285 14.8901 11.5265 15.8587 11.4727 16.8767C11.4189 17.8946 11.7168 18.9002 12.3163 19.7247C12.9157 20.5492 13.7804 21.1426 14.7654 21.4053C15.7504 21.6681 16.7957 21.5842 17.7262 21.1679C18.6567 20.7515 19.4158 20.0279 19.8763 19.1184C20.3367 18.2089 20.4705 17.1688 20.2552 16.1724C20.0399 15.1759 19.4886 14.2838 18.6937 13.6456C17.8988 13.0073 16.9087 12.6617 15.8893 12.6666ZM4.77821 13.2222C4.33869 13.2222 3.90905 13.0919 3.54361 12.8477C3.17816 12.6035 2.89334 12.2564 2.72514 11.8504C2.55695 11.4443 2.51294 10.9975 2.59868 10.5664C2.68443 10.1354 2.89607 9.73942 3.20686 9.42863C3.51764 9.11785 3.9136 8.9062 4.34467 8.82046C4.77574 8.73471 5.22256 8.77872 5.62861 8.94691C6.03467 9.11511 6.38174 9.39994 6.62592 9.76538C6.8701 10.1308 7.00043 10.5605 7.00043 11C7.00043 11.5893 6.7663 12.1546 6.34955 12.5713C5.93281 12.9881 5.36758 13.2222 4.77821 13.2222ZM15.8893 2.66665C16.3288 2.66665 16.7585 2.79698 17.1239 3.04116C17.4894 3.28534 17.7742 3.6324 17.9424 4.03846C18.1106 4.44452 18.1546 4.89133 18.0688 5.3224C17.9831 5.75347 17.7714 6.14943 17.4607 6.46022C17.1499 6.771 16.7539 6.98265 16.3229 7.06839C15.8918 7.15414 15.445 7.11013 15.0389 6.94193C14.6329 6.77374 14.2858 6.48891 14.0416 6.12347C13.7974 5.75803 13.6671 5.32838 13.6671 4.88887C13.6671 4.2995 13.9012 3.73427 14.318 3.31752C14.7347 2.90077 15.2999 2.66665 15.8893 2.66665ZM15.8893 19.3333C15.4498 19.3333 15.0202 19.203 14.6547 18.9588C14.2893 18.7146 14.0044 18.3676 13.8363 17.9615C13.6681 17.5554 13.624 17.1086 13.7098 16.6776C13.7955 16.2465 14.0072 15.8505 14.318 15.5397C14.6288 15.229 15.0247 15.0173 15.4558 14.9316C15.8869 14.8458 16.3337 14.8898 16.7397 15.058C17.1458 15.2262 17.4928 15.511 17.737 15.8765C17.9812 16.2419 18.1115 16.6716 18.1115 17.1111C18.1115 17.7005 17.8774 18.2657 17.4607 18.6824C17.0439 19.0992 16.4787 19.3333 15.8893 19.3333Z"
														fill="#FCFCFC"></path>
												</svg>
											</span>
											<div class="ms-2">
												<h6>LTC/Year</h6>
												<span class="text-gray">January</span>
											</div>
										</div>
										<div class="count">
											<h6>120.45</h6>
											<span>-2,24%</span>
										</div>
									</div>
									<div class="previews-info-list">
										<div class="pre-icon">
											<span class="icon-box icon-box-sm bg-primary">
												<svg width="16" height="24" viewBox="0 0 16 24" fill="none"
													xmlns="http://www.w3.org/2000/svg">
													<path
														d="M15.1119 12.24C15.1219 12.1603 15.1219 12.0797 15.1119 12C15.1212 11.9233 15.1212 11.8457 15.1119 11.7689C15.1134 11.7393 15.1134 11.7096 15.1119 11.68C15.0979 11.6399 15.08 11.6012 15.0586 11.5645L8.83639 0.897799C8.81109 0.846041 8.77467 0.800512 8.72973 0.764466C8.64641 0.672805 8.54486 0.599569 8.43159 0.549453C8.31831 0.499338 8.19582 0.47345 8.07195 0.47345C7.94808 0.47345 7.82559 0.499338 7.71231 0.549453C7.59904 0.599569 7.49749 0.672805 7.41417 0.764466C7.36923 0.800512 7.33281 0.846041 7.30751 0.897799L1.08528 11.5645C1.06386 11.6012 1.046 11.6399 1.03195 11.68C1.03047 11.7096 1.03047 11.7393 1.03195 11.7689C0.973936 11.8389 0.926059 11.9167 0.889728 12C0.880507 12.0768 0.880507 12.1544 0.889728 12.2311C0.888246 12.2607 0.888246 12.2904 0.889728 12.32C0.90378 12.3602 0.921639 12.3988 0.943061 12.4356L7.16528 23.1022C7.24399 23.2349 7.35585 23.3448 7.48988 23.4211C7.62391 23.4974 7.77549 23.5375 7.92973 23.5375C8.08396 23.5375 8.23554 23.4974 8.36957 23.4211C8.5036 23.3448 8.61547 23.2349 8.69417 23.1022L14.9164 12.4356C14.9378 12.3988 14.9557 12.3602 14.9697 12.32C15.0195 12.2978 15.0671 12.271 15.1119 12.24ZM4.03639 12L7.11195 10.6845V13.3511L4.03639 12ZM7.11195 8.74669L3.90306 10.1245L7.11195 4.62224V8.74669ZM8.88973 10.6845L11.9653 12L8.88973 13.3156V10.6845ZM8.88973 8.74669V4.62224L12.0986 10.1245L8.88973 8.74669ZM8.00084 20.8889L3.90306 13.8578L7.65417 15.4667C7.76384 15.5131 7.88173 15.5371 8.00084 15.5371C8.11994 15.5371 8.23783 15.5131 8.34751 15.4667L12.0986 13.8578L8.00084 20.8889Z"
														fill="#FCFCFC"></path>
												</svg>
											</span>
											<div class="ms-2">
												<h6>LTC/Year</h6>
												<span class="text-gray">January</span>
											</div>
										</div>
										<div class="count">
											<h6>120.45</h6>
											<span>-2,24%</span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- /column -->
						<!-- column -->
						<div class="col-xxl-12 col-lg-6">
							<div class="card">
								<div class="card-header border-0">
									<h4 class="fs-20 font-w600 m-0">Market Overview</h4>
								</div>
								<div class="card-body pt-0">
									<div class="d-flex justify-content-between align-items-center market-preview-3">
										<div class="d-flex align-items-center">
											<span>
												<svg width="42" height="42" viewBox="0 0 42 42" fill="none"
													xmlns="http://www.w3.org/2000/svg">
													<path
														d="M21.6654 24.2783C21.2382 24.4206 20.7623 24.4206 20.3351 24.2783L15.7502 22.75L21.0002 31.5L26.2502 22.75L21.6654 24.2783Z"
														fill="#00ADA3" />
													<path
														d="M21.0002 21L26.2502 18.9001L21.0002 10.5L15.7502 18.9001L21.0002 21Z"
														fill="#00ADA3" />
													<path
														d="M21.0001 0C9.40216 0 0.00012207 9.40204 0.00012207 21C0.00012207 32.5979 9.40216 41.9999 21.0001 41.9999C32.598 41.9999 42.0001 32.5979 42.0001 21C41.9873 9.40753 32.5925 0.0128174 21.0001 0ZM29.8418 20.171L22.3418 35.171C21.9715 35.9121 21.0701 36.2124 20.3295 35.8421C20.0388 35.697 19.8035 35.4617 19.6584 35.171L12.1584 20.171C11.9254 19.7031 11.9519 19.1479 12.2284 18.7043L19.7284 6.70443C20.2269 6.00222 21.1997 5.8365 21.9019 6.33501C22.0452 6.43664 22.1701 6.56115 22.2718 6.70443L29.7713 18.7043C30.0483 19.1479 30.0748 19.7031 29.8418 20.171Z"
														fill="#00ADA3" />
												</svg>
											</span>
											<div class="ms-3">
												<a href="javascript:void(0);">
													<h5 class="fs-14 font-w600 mb-0">ETH/USD</h5>
												</a>
												<span class="fs-12 font-w400">January</span>
											</div>
										</div>
										<div class="d-flex align-items-center">
											<span class="peity-line" data-width="100%">8,3,8,6,5,3,5,7,5</span>
										</div>
									</div>
									<div class="d-flex justify-content-between align-items-center market-preview-3">
										<div class="d-flex align-items-center">
											<span>
												<svg width="42" height="42" viewBox="0 0 56 56" fill="none"
													xmlns="http://www.w3.org/2000/svg">
													<path
														d="M37.3334 22.167C37.3318 20.2347 35.7654 18.6688 33.8336 18.6667H23.3334V25.6667H33.8336C35.7654 25.6651 37.3318 24.0987 37.3334 22.167Z"
														fill="#FFAB2D" />
													<path
														d="M23.3334 37.3333H33.8336C35.7664 37.3333 37.3334 35.7664 37.3334 33.8336C37.3334 31.9003 35.7664 30.3333 33.8336 30.3333H23.3334V37.3333Z"
														fill="#FFAB2D" />
													<path
														d="M28 0C12.5361 0 0 12.5361 0 28C0 43.4639 12.5361 56 28 56C43.4639 56 56 43.4639 56 28C55.9823 12.5434 43.4566 0.0177002 28 0ZM42.0003 33.9998C41.9948 38.4163 38.4163 41.9948 34.0004 41.9997V43.9998C34.0004 45.1046 33.1044 46 32.0003 46C30.8955 46 30.0001 45.1046 30.0001 43.9998V41.9997H26.0005V43.9998C26.0005 45.1046 25.1045 46 24.0003 46C22.8956 46 22.0002 45.1046 22.0002 43.9998V41.9997H16.0004C14.8957 41.9997 14.0003 41.1043 14.0003 40.0002C14.0003 38.8954 14.8957 38 16.0004 38H18V18H16.0004C14.8957 18 14.0003 17.1046 14.0003 15.9998C14.0003 14.8951 14.8957 13.9997 16.0004 13.9997H22.0002V12.0002C22.0002 10.8954 22.8956 10 24.0003 10C25.1051 10 26.0005 10.8954 26.0005 12.0002V13.9997H30.0001V12.0002C30.0001 10.8954 30.8955 10 32.0003 10C33.105 10 34.0004 10.8954 34.0004 12.0002V13.9997C38.3998 13.9814 41.9814 17.5324 42.0003 21.9319C42.0101 24.2616 40.9999 26.479 39.2354 28C40.9835 29.5039 41.9924 31.6933 42.0003 33.9998Z"
														fill="#FFAB2D" />
												</svg>
											</span>
											<div class="ms-3">
												<a href="javascript:void(0);">
													<h5 class="fs-14 font-w600 mb-0">BTC/USD</h5>
												</a>
												<span class="fs-12 font-w400">January</span>
											</div>
										</div>
										<div class="d-flex align-items-center">
											<span class="peity-line" data-width="100%">8,3,8,6,5,3,5,7,5</span>
										</div>
									</div>
									<div class="d-flex justify-content-between align-items-center market-preview-3">
										<div class="d-flex align-items-center">
											<span>
												<svg width="42" height="42" viewBox="0 0 42 42" fill="none"
													xmlns="http://www.w3.org/2000/svg">
													<path
														d="M21.6654 24.2783C21.2382 24.4206 20.7623 24.4206 20.3351 24.2783L15.7502 22.75L21.0002 31.5L26.2502 22.75L21.6654 24.2783Z"
														fill="#00ADA3" />
													<path
														d="M21.0002 21L26.2502 18.9001L21.0002 10.5L15.7502 18.9001L21.0002 21Z"
														fill="#00ADA3" />
													<path
														d="M21.0001 0C9.40216 0 0.00012207 9.40204 0.00012207 21C0.00012207 32.5979 9.40216 41.9999 21.0001 41.9999C32.598 41.9999 42.0001 32.5979 42.0001 21C41.9873 9.40753 32.5925 0.0128174 21.0001 0ZM29.8418 20.171L22.3418 35.171C21.9715 35.9121 21.0701 36.2124 20.3295 35.8421C20.0388 35.697 19.8035 35.4617 19.6584 35.171L12.1584 20.171C11.9254 19.7031 11.9519 19.1479 12.2284 18.7043L19.7284 6.70443C20.2269 6.00222 21.1997 5.8365 21.9019 6.33501C22.0452 6.43664 22.1701 6.56115 22.2718 6.70443L29.7713 18.7043C30.0483 19.1479 30.0748 19.7031 29.8418 20.171Z"
														fill="#00ADA3" />
												</svg>
											</span>
											<div class="ms-3">
												<a href="javascript:void(0);">
													<h5 class="fs-14 font-w600 mb-0">LTC/USD</h5>
												</a>
												<span class="fs-12 font-w400">January</span>
											</div>
										</div>
										<div class="d-flex align-items-center">
											<span class="peity-line" data-width="100%">8,3,8,6,5,3,5,7,5</span>
										</div>
									</div>
									<div class="d-flex justify-content-between align-items-center market-preview-3">
										<div class="d-flex align-items-center">
											<span>
												<svg width="42" height="42" viewBox="0 0 42 42" fill="none"
													xmlns="http://www.w3.org/2000/svg">
													<path
														d="M21 42C25.1534 42 29.2135 40.7685 32.667 38.4607C36.1204 36.1533 38.8121 32.8736 40.4014 29.0363C41.991 25.1991 42.4069 20.9767 41.5965 16.9031C40.7861 12.8295 38.7862 9.08765 35.8492 6.15073C32.9123 3.21383 29.1705 1.21378 25.0969 0.403488C21.0233 -0.406801 16.8009 0.00906789 12.9636 1.59851C9.12641 3.18795 5.84666 5.87957 3.53914 9.33302C1.23163 12.7864 0 16.8465 0 21C0 26.5695 2.21249 31.9109 6.15075 35.8492C10.089 39.7875 15.4305 42 21 42Z"
														fill="var(--primary)" />
													<path
														d="M28.6839 12.0562H31.8414L25.2751 18.6075C24.1339 19.7474 22.5869 20.3877 20.9739 20.3877C19.3608 20.3877 17.8138 19.7474 16.6726 18.6075L10.1251 12.0562H13.2789L18.2664 17.0325C18.9892 17.7545 19.9691 18.1601 20.9907 18.1601C22.0124 18.1601 22.9923 17.7545 23.7151 17.0325L28.6839 12.0562Z"
														fill="white" />
													<path
														d="M13.2639 30.2775H10.1251L16.7139 23.685C17.8551 22.5451 19.4021 21.9048 21.0151 21.9048C22.6281 21.9048 24.1752 22.5451 25.3164 23.685L31.9201 30.2775H28.7664L23.7414 25.26C23.0186 24.538 22.0386 24.1324 21.017 24.1324C19.9953 24.1324 19.0154 24.538 18.2926 25.26L13.2639 30.2775Z"
														fill="white" />
												</svg>
											</span>
											<div class="ms-3">
												<a href="javascript:void(0);">
													<h5 class="fs-14 font-w600 mb-0">XRP/USD</h5>
												</a>
												<span class="fs-12 font-w400">January</span>
											</div>
										</div>
										<div class="d-flex align-items-center">
											<span class="peity-line" data-width="100%">8,3,8,6,5,3,5,7,5</span>
										</div>
									</div>
									<div class="d-flex justify-content-between align-items-center market-preview-3">
										<div class="d-flex align-items-center">
											<span>
												<svg width="42" height="42" viewBox="0 0 42 42" fill="none"
													xmlns="http://www.w3.org/2000/svg">
													<path
														d="M21 0C9.40205 0 0 9.40205 0 21C0 32.5979 9.40205 42 21 42C32.5979 42 42 32.5979 42 21C41.9867 9.40754 32.5925 0.0132752 21 0ZM28.5 31.5002H16.5002C15.6716 31.5002 15.0001 30.8287 15.0001 30.0001C15.0001 29.9292 15.0051 29.8582 15.0152 29.7877L16.144 21.8844L13.8639 22.4548C13.7449 22.485 13.6226 22.5001 13.5 22.5001C12.6714 22.4992 12.0008 21.8272 12.0012 20.9986C12.0022 20.3111 12.47 19.7123 13.137 19.5448L16.6018 18.6787L18.0149 8.78727C18.1321 7.96695 18.892 7.39749 19.7123 7.51468C20.5326 7.63187 21.1021 8.39176 20.9849 9.21208L19.7443 17.8931L25.1364 16.545C25.9388 16.3404 26.755 16.8252 26.9592 17.6276C27.1638 18.4301 26.679 19.2463 25.8766 19.4509C25.872 19.4518 25.8674 19.4532 25.8628 19.4541L19.2857 21.0984L18.2287 28.5H28.5C29.3286 28.5 30.0001 29.1716 30.0001 30.0001C30.0001 30.8282 29.3286 31.5002 28.5 31.5002Z"
														fill="#374C98" />
												</svg>
											</span>
											<div class="ms-3">
												<a href="javascript:void(0);">
													<h5 class="fs-14 font-w600 mb-0">LTC/USD</h5>
												</a>
												<span class="fs-12 font-w400">March</span>
											</div>
										</div>
										<div class="d-flex align-items-center">
											<span class="peity-line2" data-width="100%">8,4,5,9,5,3,5,7,5</span>
										</div>
									</div>
									<div class="d-flex justify-content-between align-items-center market-preview-3">
										<div class="d-flex align-items-center">
											<span>
												<svg width="42" height="42" viewBox="0 0 42 42" fill="none"
													xmlns="http://www.w3.org/2000/svg">
													<path
														d="M21 42C25.1534 42 29.2135 40.7685 32.667 38.4607C36.1204 36.1533 38.8121 32.8736 40.4014 29.0363C41.991 25.1991 42.4069 20.9767 41.5965 16.9031C40.7861 12.8295 38.7862 9.08765 35.8492 6.15073C32.9123 3.21383 29.1705 1.21378 25.0969 0.403488C21.0233 -0.406801 16.8009 0.00906789 12.9636 1.59851C9.12641 3.18795 5.84666 5.87957 3.53914 9.33302C1.23163 12.7864 0 16.8465 0 21C0 26.5695 2.21249 31.9109 6.15075 35.8492C10.089 39.7875 15.4305 42 21 42Z"
														fill="#23292F" />
													<path
														d="M28.6839 12.0562H31.8414L25.2751 18.6075C24.1339 19.7474 22.5869 20.3877 20.9739 20.3877C19.3608 20.3877 17.8138 19.7474 16.6726 18.6075L10.1251 12.0562H13.2789L18.2664 17.0325C18.9892 17.7545 19.9691 18.1601 20.9907 18.1601C22.0124 18.1601 22.9923 17.7545 23.7151 17.0325L28.6839 12.0562Z"
														fill="white" />
													<path
														d="M13.2639 30.2775H10.1251L16.7139 23.685C17.8551 22.5451 19.4021 21.9048 21.0151 21.9048C22.6281 21.9048 24.1752 22.5451 25.3164 23.685L31.9201 30.2775H28.7664L23.7414 25.26C23.0186 24.538 22.0386 24.1324 21.017 24.1324C19.9953 24.1324 19.0154 24.538 18.2926 25.26L13.2639 30.2775Z"
														fill="white" />
												</svg>
											</span>
											<div class="ms-3">
												<a href="javascript:void(0);">
													<h5 class="fs-14 font-w600 mb-0">XRP/USD</h5>
												</a>
												<span class="fs-12 font-w400">January</span>
											</div>
										</div>
										<div class="d-flex align-items-center">
											<span class="peity-line" data-width="100%">8,3,8,6,5,3,5,7,5</span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- /column -->
					</div>
					<!-- /row -->
				</div>
				<!-- /column -->
			</div>
		</div>
	</div>
</div>	
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: '<span style="color: white;">Success</span>',
                html: '<span style="color: white;">{{ session('success') }}</span>',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 4000,
                background: '#28a745', // Green background
                iconColor: '#ffffff', // White icon
            });
        @endif
        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: '<span style="color: white;">Error</span>',
                html: '<span style="color: white;">{{ session('error') }}</span>',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 4000,
                background: '#dc3545', // Red background
                iconColor: '#ffffff', // White icon
            });
        @endif
    });
</script>	
</div>    
<!--**********************************
    	Content body end
***********************************-->
@endsection