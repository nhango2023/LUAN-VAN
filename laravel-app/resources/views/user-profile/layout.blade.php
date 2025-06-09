@extends('layout')
@section('content')
    <style>
        .main-container {
            padding: 0;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .profile-settings-root {
                display: none;
            }
        }

        @media (max-width: 480px) {
            .profile-settings-root {
                display: none;
            }
        }

        .main-container {
            height: auto;
            padding: 10px;
        }
    </style>
    <div class="d-flex mx-auto">
        <div class="profile-settings-root">
            <div class="profile-settings-sidebar">
                <div class="profile-header mx-4" style="padding: 10px 0">
                    <div class="profile-info">
                        <img src="{{ Auth::user()->avatar ? asset('storage/avatars/' . Auth::user()->avatar) : 'https://img.freepik.com/free-vector/add-new-user_78370-4710.jpg' }}"
                            alt="" class="avatar-placeholder">
                        <div class="user-details mr-3">
                            <div class="user-name">{{ Auth::user()->fullname }}</div>
                            <div class="user-email">{{ Auth::user()->email }}</div>
                        </div>
                        <button class="settings-btn">
                            <i class="fas fa-cog"></i> Settings
                        </button>
                    </div>
                </div>

                <div class="profile-status mx-4">
                    <div class="status-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Current plan</span>
                        <span class="status-badge yellow">Free</span>
                    </div>
                    <div class="status-item">
                        <i class="fas fa-star"></i>
                        <span>Available credits</span>
                        <span class="status-badge blue">{{ Auth::user()->credit }}</span>
                    </div>
                    <div class="status-item">
                        <i class="fas fa-lock"></i>
                        <span>Locked credits</span>
                        <span class="status-badge red">0</span>
                    </div>
                </div>
                <style>
                    .action-item {
                        padding: 8px 16px;
                        margin-bottom: 0.6rem;
                    }
                </style>
                <div class="profile-actions mx-3">
                    <a href="{{ route('profile.buy-credit') }}">
                        <div class="action-item {{ Route::is('profile.buy-credit') ? 'active' : '' }}">🛒 Buy
                            credits</div>
                    </a>
                    <div class="action-item">📄 Payment history</div>
                    <a href="{{ route('profile.account-infor') }}">
                        <div class="action-item {{ Route::is('profile.account-infor') ? 'active' : '' }}">👤
                            Account
                            Information</div>
                    </a>
                    <div class="action-item with-badge">
                        🔗 Service Integration <span class="new-badge">New</span>
                    </div>
                    <div class="dv1">
                        <div class="dv2"></div>
                    </div>
                    <div class="action-item">
                        🎁 Gift Card<br>
                        <span class="subtext">Redeem a gift card to get more credits</span>
                    </div>
                    <a class="action-item d-flex align-items-center" style="text-decoration: none;"
                        href="{{ route('logout') }}">
                        <i class="material-icons">logout</i>
                        <div>Log out</div>
                    </a>
                </div>
            </div>
            <div class="profile-settings-main">

            </div>
        </div>
        <div class="account-settings-root ml-3">
            @yield('profile-right')
        </div>
    </div>
@endsection
