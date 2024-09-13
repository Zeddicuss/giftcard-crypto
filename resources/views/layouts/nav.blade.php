<!--**********************************
            Sidebar start
        ***********************************-->
        <div class="deznav" style="background-color: #19066B;>
            <div class="deznav-scroll">
                <ul class="metismenu" id="menu">
                    <li>
                        @if(auth()->check() && auth()->user()->role !== 'admin')
                        <a class="" href="{{route('dashboard')}}" aria-expanded="false">
                            <i class="material-icons">house</i>
                            <span class="nav-text">Dashboard</span>
                        </a>
                        @endif
                        @if(auth()->check() && auth()->user()->role == 'admin')
                        <a class="" href="{{route('admin.dashboard')}}" aria-expanded="false">
                            <i class="material-icons">house</i>
                            <span class="nav-text">Dashboard</span>
                        </a>
                        @endif
                    </li>
                    {{-- <li><a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
                            <i class="material-icons">trending_up</i>
                            <span class="nav-text">Trading </span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="market.html">Market</a></li>    
                            <li><a href="ico-listing.html">ICO Listing</a></li>    
                            <li><a href="p2p.html">P2P</a></li>    
                            <li><a href="future.html">Future</a></li>    
                            <li><a href="intraday-trading.html">Intraday Trading</a></li>  
                        </ul>
                    </li> --}}
                    <li><a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
                            <i class="material-icons">currency_bitcoin</i>
                            <span class="nav-text">Crypto</span>
                        </a>
                        <ul aria-expanded="false">
                            {{-- @if(auth()->check() && auth()->user()->role == 'admin')
                            <li><a href="{{route('admin.sell')}}">Sell Crypto</a></li>
                            @endif --}}
                            @if(auth()->check() && auth()->user()->role == 'admin')
                            <li><a href="{{route('crypto.index')}}">Pending Crypto Transactions</a></li>
                            @endif
                            @if(auth()->check() && auth()->user()->role !== 'admin')
                            <li><a href="{{route('crypto.sell')}}">Sell Crypto</a></li>
                            @endif
                            @if(auth()->check() && auth()->user()->role !== 'admin')
                            <li><a href="{{route('crypto.buy')}}">Buy Crypto</a></li>
                            @endif
                            @if(auth()->check() && auth()->user()->role == 'admin')
                            {{-- <li><a href="{{route('admin.buyform')}}">Buy Crypto</a></li> --}}
                            <li><a href="{{route('active.crypto')}}">See Active Cryptos</a></li>
                            @endif
                            <li><a href="{{route('order.view')}}">Orders</a></li>
                            {{-- <li><a href="exchange.html">Exchange Prices</a></li> --}}
                            <li><a href="{{route('transactions')}}">Transactions</a></li>
                        </ul>
                    </li>
                    <li><a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
                        <i class="material-icons">credit_card</i>
                        <span class="nav-text">Gift Card</span>
                    </a>
                    <ul aria-expanded="false">
                        @if(auth()->check() && auth()->user()->role == 'admin')
                        <li><a href="{{route('giftcards')}}">Available Giftcards</a></li>
                        <li><a href="{{route('category.show')}}">Giftcard Categories</a></li>
                        <li><a href="{{route('active.giftcard')}}">Active Giftcard</a></li>
                        @endif
                        @if(auth()->check() && auth()->user()->role !== 'admin')
                        <li><a href="{{route('giftcard.sell')}}">Sell Giftcard</a></li> 
                        @endif
                        <li><a href="{{route('transactions')}}">Transactions</a></li> 
                        <li><a href="{{route('order.view')}}">Orders</a></li>
                    </ul>
                    </li>
                    @if(auth()->check() && auth()->user()->role == 'admin')
                    <li><a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
                        <i class="material-icons">credit_card</i>
                        <span class="nav-text">Exchange Rates</span>
                    </a>
                    <ul aria-expanded="false">
                        {{-- <li><a href="">Set Rates</a></li> --}}
                        {{-- <li><a href="">Sell Giftcard</a></li> --}}
                        <li><a href="{{route('exchange.rate')}}">Currency Exchange</a></li> 
                        <li><a href="{{route('crypto.exchange')}}">Crypto Exchange</a></li>
                    </ul>
                    </li>
                    @endif
                    @if(auth()->check() && auth()->user()->role == 'admin')
                    <li><a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
                        <i class="material-icons">person</i>
                        <span class="nav-text">Users</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{route('admin.users')}}">Users List</a></li>
                    </ul>
                    </li>
                    @endif
                    <li><a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
                            <i class="material-icons">person</i>
                            <span class="nav-text">Profile</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="{{route('profile.show')}}">Personal Information</a></li>
                        </ul>
                    </li>
                    <li><a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
                        <i class="material-icons">contact_phone</i>
                        <span class="nav-text">Support</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{route('support.tickets')}}">See Support Tickets</a></li>
                    </ul>
                    </li>
                    {{-- <li><a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
        
                            <i class="material-icons referral-icon">group_add</i>
                            <span class="nav-text">Referral</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="ui-alert.html">Referral Link</a></li>
                            <li><a href="ui-badge.html">History</a></li>
                            <li><a href="ui-button.html">Earnings</a></li>
                        </ul>
                    </li> --}}
                   
                    <li><a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
                        <i class="material-icons settings-icon">settings </i>
                        <span class="nav-text">Settings</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{route('settings.payment-method')}}">Set Payment Method</a></li>
                        @if(auth()->check() && auth()->user()->role == 'admin')
                        <li><a href="{{route('setting')}}">Site Settings</a></li>
                        @endif
                    </ul>
                    </li>
                    
                    <li><a href="#" class="" aria-expanded="false" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="material-icons logout-icon">logout</i>
                            <span class="nav-text">Logout</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>        <!--**********************************
                    Sidebar end
                ***********************************-->