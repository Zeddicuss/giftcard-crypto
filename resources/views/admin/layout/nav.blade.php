<!--**********************************
            Sidebar start
        ***********************************-->
        <div class="deznav">
            <div class="deznav-scroll">
                <ul class="metismenu" id="menu">
                    <li><a class = "" href ="{{route('admin.dashboard')}}" aria-expanded="false">
                            <i class="material-icons">house</i>
                            <span>Dashboard</span>
                        </a>
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
                            {{-- <li><a href="">Sell Crypto</a></li> --}}
                            <li><a href="{{route('crypto.index')}}">See Available Crypto</a></li>
                            <li><a href="exchange.html">Exchange Prices</a></li>
                            <li><a href="banking.html">Transactions</a></li>
                        </ul>
                    </li>
                        {{-- <li><a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
                                <i class="material-icons">credit_card</i>
                                <span class="nav-text">Gift Card</span>
                            </a>
                            <ul aria-expanded="false">
                                <li><a href="history.html">History</a></li>
                                <li><a href="orders.html">Orders</a></li>
                                <li><a href="reports.html">Report</a></li>
                                <li><a href="user.html">User</a></li> 
                                <li><a href="contact.html">Contacts</a></li> 
                                <li><a href="activity.html">Activity</a></li>
                            </ul>
                        </li> --}}
                    <li><a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
                        <i class="material-icons">credit_card</i>
                        <span class="nav-text">Gift Card</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{route('giftcards')}}">See Giftcard Listing</a></li>
                        {{-- <li><a href="">Sell Giftcard</a></li> --}}
                        <li><a href="contact.html">Transactions</a></li> 
                        <li><a href="activity.html">Orders</a></li>
                    </ul>
                    </li>
                    <li><a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
                        <i class="material-icons">credit_card</i>
                        <span class="nav-text">Set Rates</span>
                    </a>
                    <ul aria-expanded="false">
                        {{-- <li><a href="">Set Rates</a></li> --}}
                        {{-- <li><a href="">Sell Giftcard</a></li> --}}
                        <li><a href="contact.html">Currency Exchange</a></li> 
                        <li><a href="activity.html">Crypto Exchange</a></li>
                    </ul>
                    </li>
                    <li><a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
                            <i class="material-icons">person</i>
                            <span class="nav-text">Users</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="{{route('profile.show')}}">Add User</a></li>
                            <li><a href="{{route('profile.show')}}">See Users</a></li>
                        </ul>
                    </li>
                    <li><a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
                            <i class="material-icons">contact_phone</i>
                            <span class="nav-text">Support</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="chart-flot.html">See Support Tickets</a></li>
                            <li><a href="chart-morris.html">FAQ</a></li>                        </ul>
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
                            <li><a href="{{route('settings.payment-method')}}">See Payment Methods</a></li>
                            {{-- <li><a href="uc-nestable.html">Notifications</a></li> --}}
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