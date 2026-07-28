@extends('frontend.dashboard')
@section('frontend_title', 'My Account')
@section('frontend_content')

    {{-- Breadcrumb --}}
    <div class="breadcrumb__section breadcrumb__bg" style="background-image: url('{{ asset('upload/static_images/breadcrumb.jpg') }}');">
        <div class="breadcrumb__overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb__content text-center">
                        <h1 class="breadcrumb__title text-white mb-3">My Account</h1>
                        <ul class="breadcrumb__content--menu d-flex justify-content-center align-items-center">
                            <li class="breadcrumb__content--menu__items">
                                <a class="text-white" href="{{ url('/') }}">Home</a>
                            </li>
                            <li class="breadcrumb__content--menu__items">
                                <span class="text-white">My Account</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="cd-section">
        <div class="cd-container">

            <!-- ═══════ SIDEBAR ═══════ -->
            <aside class="cd-sidebar">
                <div class="cd-profile-card">
                    <div class="cd-avatar-wrap">
                        <img src="{{ $customer->photo && $customer->photo !== 'avatar.png' ? asset('upload/customer_images/' . $customer->photo) : asset('frontend/assets/img/avatar.png') }}" alt="{{ $customer->name }}" class="cd-avatar" id="avatarPreview">
                        <div class="cd-avatar-badge">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none">
                                <path d="M20 6L9 17l-5-5" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                    </div>
                    <h4 class="cd-profile-name">{{ $customer->name }}</h4>
                    <p class="cd-profile-email">{{ $customer->email }}</p>
                    <div class="cd-profile-badge">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" style="margin-top:-5px;">
                            <path d="M12 2L4 6v6c0 5.25 3.5 10.15 8 11.35C16.5 22.15 20 17.25 20 12V6l-8-4z" stroke="currentColor" stroke-width="2" stroke-linejoin="round" />
                        </svg> Verified Customer
                    </div>
                </div>

                <nav class="cd-nav">
                    <button class="cd-nav-item active" data-tab="overview">
                        <span class="cd-nav-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                                <rect x="3" y="3" width="7" height="7" rx="1.5" stroke="currentColor" stroke-width="1.8" />
                                <rect x="14" y="3" width="7" height="7" rx="1.5" stroke="currentColor" stroke-width="1.8" />
                                <rect x="3" y="14" width="7" height="7" rx="1.5" stroke="currentColor" stroke-width="1.8" />
                                <rect x="14" y="14" width="7" height="7" rx="1.5" stroke="currentColor" stroke-width="1.8" />
                            </svg>
                        </span>Overview
                    </button>
                    <button class="cd-nav-item" data-tab="orders">
                        <span class="cd-nav-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                                <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                                <rect x="9" y="3" width="6" height="4" rx="1" stroke="currentColor" stroke-width="1.8" />
                                <path d="M9 12h6M9 16h4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                            </svg>
                        </span>My Orders
                    </button>
                    <button class="cd-nav-item" data-tab="tracking">
                        <span class="cd-nav-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                                <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.8" />
                                <path d="M12 2v3M12 19v3M2 12h3M19 12h3" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                                <path d="M4.93 4.93l2.12 2.12M16.95 16.95l2.12 2.12M4.93 19.07l2.12-2.12M16.95 7.05l2.12-2.12" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                            </svg>
                        </span>Track Order
                    </button>
                    <button class="cd-nav-item" data-tab="myblogs">
                        <span class="cd-nav-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                                <path d="M12 20h9M16.5 3.5a2.121 2.121 0 013 3L7 19l-4 1 1-4L16.5 3.5z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                            </svg>
                        </span>My Blogs
                    </button>
                    <button class="cd-nav-item" data-tab="profile">
                        <span class="cd-nav-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                                <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                                <circle cx="12" cy="7" r="4" stroke="currentColor" stroke-width="1.8" />
                            </svg>
                        </span>Edit Profile
                    </button>
                    <button class="cd-nav-item" data-tab="password">
                        <span class="cd-nav-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                                <rect x="3" y="11" width="18" height="11" rx="2" stroke="currentColor" stroke-width="1.8" />
                                <path d="M7 11V7a5 5 0 0110 0v4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                            </svg>
                        </span>Change Password
                    </button>
                    <a href="{{ route('customer.logout') }}" class="cd-nav-item logout-item" id="logoutBtn">
                        <span class="cd-nav-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                                <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                                <polyline points="16 17 21 12 16 7" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                                <line x1="21" y1="12" x2="9" y2="12" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                            </svg>
                        </span>Logout
                    </a>
                </nav>
            </aside>

            <!-- ═══════ MAIN CONTENT ═══════ -->
            <main class="cd-main">

                @if (session('message') || session('success') || session('error'))
                    <div class="cd-flash {{ session('alert-type') === 'error' || session('error') ? 'error' : 'success' }}">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                            @if (session('alert-type') === 'error' || session('error'))
                                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" />
                                <path d="M12 8v4M12 16h.01" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                            @else
                                <path d="M9 12l2 2 4-4M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            @endif
                        </svg>
                        {{ session('message') ?? (session('success') ?? session('error')) }}
                    </div>
                @endif

                <!-- ══ TAB: OVERVIEW ══ -->
                <div class="cd-tab active" id="tab-overview">
                    <div class="cd-tab-header">
                        <h2>Welcome back, {{ explode(' ', $customer->name)[0] }}! 👋</h2>
                        <p>Here's a summary of your account activity</p>
                    </div>
                    <div class="cd-stats">
                        <div class="cd-stat-card">
                            <div class="cd-stat-icon pink">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                                    <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                    <rect x="9" y="3" width="6" height="4" rx="1" stroke="currentColor" stroke-width="2" />
                                </svg>
                            </div>
                            <div class="cd-stat-info">
                                <span class="cd-stat-num" id="stat-total">—</span>
                                <span class="cd-stat-label">Total Orders</span>
                            </div>
                        </div>
                        <div class="cd-stat-card">
                            <div class="cd-stat-icon green">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                                    <path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>
                            <div class="cd-stat-info">
                                <span class="cd-stat-num" id="stat-delivered">—</span>
                                <span class="cd-stat-label">Completed</span>
                            </div>
                        </div>
                        <div class="cd-stat-card">
                            <div class="cd-stat-icon orange">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                                    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" />
                                    <polyline points="12 6 12 12 16 14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>
                            <div class="cd-stat-info">
                                <span class="cd-stat-num" id="stat-pending">—</span>
                                <span class="cd-stat-label">Pending</span>
                            </div>
                        </div>
                        <div class="cd-stat-card">
                            <div class="cd-stat-icon blue">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                                    <line x1="12" y1="1" x2="12" y2="23" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                    <path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                </svg>
                            </div>
                            <div class="cd-stat-info">
                                <span class="cd-stat-num" id="stat-spent">—</span>
                                <span class="cd-stat-label">Total Spent</span>
                            </div>
                        </div>
                        <div class="cd-stat-card">
                            <div class="cd-stat-icon" style="background:#f3e8ff;">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                                    <path d="M12 20h9M16.5 3.5a2.121 2.121 0 013 3L7 19l-4 1 1-4L16.5 3.5z" stroke="#7c3aed" stroke-width="2" stroke-linecap="round" />
                                </svg>
                            </div>
                            <div class="cd-stat-info">
                                <span class="cd-stat-num" id="stat-blogs">—</span>
                                <span class="cd-stat-label">Blogs Submitted</span>
                            </div>
                        </div>
                    </div>
                    <div class="cd-overview-grid">
                        <div class="cd-info-card">
                            <div class="cd-info-card-title">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                    <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                    <circle cx="12" cy="7" r="4" stroke="currentColor" stroke-width="2" />
                                </svg> Account Info
                            </div>
                            <div class="cd-info-rows">
                                <div class="cd-info-row"><span class="cd-info-key">Name</span><span class="cd-info-val">{{ $customer->name }}</span></div>
                                <div class="cd-info-row"><span class="cd-info-key">Email</span><span class="cd-info-val">{{ $customer->email }}</span></div>
                                <div class="cd-info-row"><span class="cd-info-key">Phone</span><span class="cd-info-val">{{ $customer->phone ?? '—' }}</span></div>
                                <div class="cd-info-row"><span class="cd-info-key">Address</span><span class="cd-info-val">{{ $customer->address ?? '—' }}</span></div>
                            </div>
                            <button class="cd-overview-btn" data-tab="profile">Edit Profile →</button>
                        </div>
                        <div class="cd-info-card">
                            <div class="cd-info-card-title">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                    <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                    <rect x="9" y="3" width="6" height="4" rx="1" stroke="currentColor" stroke-width="2" />
                                </svg> Recent Orders
                            </div>
                            <div id="overview-recent-orders">
                                <div class="cd-empty-state">
                                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none">
                                        <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2" stroke="#ddd" stroke-width="1.5" />
                                        <rect x="9" y="3" width="6" height="4" rx="1" stroke="#ddd" stroke-width="1.5" />
                                    </svg>
                                    <p>Loading orders…</p>
                                </div>
                            </div>
                            <button class="cd-overview-btn" data-tab="orders">View All Orders →</button>
                        </div>
                    </div>
                </div>

                <!-- ══ TAB: MY ORDERS ══ -->
                <div class="cd-tab" id="tab-orders">
                    <div class="cd-tab-header">
                        <h2>My Orders</h2>
                        <p>Track and manage all your purchases</p>
                    </div>
                    <div id="orders-container">
                        <div style="text-align:center;padding:40px;color:#aaa;">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" style="animation:spin 1s linear infinite;display:inline-block">
                                <path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4" stroke="#ccc" stroke-width="2" stroke-linecap="round" />
                            </svg>
                            <p style="margin-top:10px;">Loading your orders…</p>
                        </div>
                    </div>
                </div>

                <!-- ══ TAB: TRACK ORDER ══ -->
                <div class="cd-tab" id="tab-tracking">
                    <div class="cd-tab-header">
                        <h2>Track Your Order</h2>
                        <p>Select an order below or enter your order number</p>
                    </div>
                    <div class="cd-track-box">
                        <div class="cd-track-search">
                            <div class="cd-track-input-wrap">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                                    <circle cx="11" cy="11" r="8" stroke="#aaa" stroke-width="1.8" />
                                    <path d="m21 21-4.35-4.35" stroke="#aaa" stroke-width="1.8" stroke-linecap="round" />
                                </svg>
                                <input type="text" id="trackOrderId" placeholder="e.g. ORD-20260505-0001" class="cd-track-input">
                            </div>
                            <button class="cd-track-btn" onclick="trackOrder()">Track Now</button>
                        </div>
                        <div id="track-quick-pick" style="margin-bottom:20px;display:none;">
                            <p style="font-size:12.5px;color:#9ca3af;margin-bottom:8px;">Or pick from your recent orders:</p>
                            <div id="track-order-chips" style="display:flex;gap:8px;flex-wrap:wrap;"></div>
                        </div>
                        <div class="cd-track-result" id="trackResult" style="display:none;">
                            <div class="track-order-meta" id="track-order-meta"></div>
                            <div class="cd-track-steps" id="track-steps-wrap"></div>
                        </div>
                        <div id="track-not-found" style="display:none;text-align:center;padding:30px;color:#ef4444;font-size:14px;">
                            Order not found. Please check the order number and try again.
                        </div>
                    </div>
                </div>

                <!-- ══ TAB: MY BLOGS ══ -->
                <div class="cd-tab" id="tab-myblogs">
                    <div class="cd-tab-header">
                        <h2>My Blog Submissions</h2>
                        <p>Track the status of your submitted blogs</p>
                    </div>

                    <div style="margin-bottom:20px;">
                        <a href="{{ route('blog.submit') }}" style="display:inline-flex;align-items:center;gap:8px;background:#1a1a1a;color:#fff;padding:10px 22px 6px;border-radius:9px;font-size:13.5px;font-weight:600;text-decoration:none;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
                                <path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" />
                            </svg>
                            Write a Blog
                        </a>
                    </div>

                    <div id="myblogs-container">
                        <div style="text-align:center;padding:40px;color:#aaa;">Loading…</div>
                    </div>
                </div>

                <!-- ══ TAB: EDIT PROFILE ══ -->
                <div class="cd-tab" id="tab-profile">
                    <div class="cd-tab-header">
                        <h2>Edit Profile</h2>
                        <p>Update your personal information</p>
                    </div>
                    <form action="{{ route('customer.profile.update') }}" method="POST" enctype="multipart/form-data" class="cd-form">
                        @csrf
                        <div class="cd-photo-upload">
                            <img src="{{ $customer->photo && $customer->photo !== 'avatar.png' ? asset('upload/customer_images/' . $customer->photo) : asset('frontend/assets/img/avatar.png') }}" alt="Profile" class="cd-photo-preview" id="photoPreview">
                            <div class="cd-photo-info">
                                <h4>Profile Photo</h4>
                                <p>JPG, PNG — Max 2MB</p>
                                <label class="cd-photo-btn" for="photoInput">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" style="margin-top:-5px;">
                                        <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                        <polyline points="17 8 12 3 7 8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        <line x1="12" y1="3" x2="12" y2="15" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                    </svg>
                                    Upload Photo
                                </label>
                                <input type="file" name="photo" id="photoInput" accept="image/*" style="display:none;" onchange="previewPhoto(this)">
                            </div>
                        </div>
                        <div class="cd-form-grid">
                            <div class="cd-form-group">
                                <label class="cd-label">Full Name <span class="req">*</span></label>
                                <div class="cd-input-wrap">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                        <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" stroke="#aaa" stroke-width="1.8" stroke-linecap="round" />
                                        <circle cx="12" cy="7" r="4" stroke="#aaa" stroke-width="1.8" />
                                    </svg>
                                    <input type="text" name="name" class="cd-input" value="{{ $customer->name }}" required>
                                </div>
                            </div>
                            <div class="cd-form-group">
                                <label class="cd-label">Email Address <span class="req">*</span></label>
                                <div class="cd-input-wrap">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" stroke="#aaa" stroke-width="1.8" />
                                        <polyline points="22,6 12,13 2,6" stroke="#aaa" stroke-width="1.8" />
                                    </svg>
                                    <input type="email" name="email" class="cd-input" value="{{ $customer->email }}" required>
                                </div>
                            </div>
                            <div class="cd-form-group">
                                <label class="cd-label">Phone Number</label>
                                <div class="cd-input-wrap">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                        <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.8a19.79 19.79 0 01-3.07-8.68A2 2 0 012 1h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 8.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z" stroke="#aaa" stroke-width="1.8" />
                                    </svg>
                                    <input type="text" name="phone" class="cd-input" value="{{ $customer->phone ?? '' }}" placeholder="Your phone number">
                                </div>
                            </div>
                            <div class="cd-form-group cd-form-group-full">
                                <label class="cd-label">Address</label>
                                <div class="cd-input-wrap">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z" stroke="#aaa" stroke-width="1.8" />
                                        <circle cx="12" cy="10" r="3" stroke="#aaa" stroke-width="1.8" />
                                    </svg>
                                    <input type="text" name="address" class="cd-input" value="{{ $customer->address ?? '' }}" placeholder="Your full address">
                                </div>
                            </div>
                        </div>
                        <div class="cd-form-actions">
                            <button type="submit" class="cd-submit-btn">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" style="margin-top:-5px;">
                                    <path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                    <polyline points="17 21 17 13 7 13 7 21" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                    <polyline points="7 3 7 8 15 8" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                </svg>
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>

                <!-- ══ TAB: CHANGE PASSWORD ══ -->
                <div class="cd-tab" id="tab-password">
                    <div class="cd-tab-header">
                        <h2>Change Password</h2>
                        <p>Keep your account secure with a strong password</p>
                    </div>
                    <div class="cd-password-wrap">
                        <div class="cd-security-tips">
                            <div class="cd-tip-title">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" style="margin-top:-5px;">
                                    <path d="M12 2L4 6v6c0 5.25 3.5 10.15 8 11.35C16.5 22.15 20 17.25 20 12V6l-8-4z" stroke="#B8860B" stroke-width="2" stroke-linejoin="round" />
                                </svg>
                                Security Tips
                            </div>
                            <ul class="cd-tips-list">
                                <li>Use at least 8 characters</li>
                                <li>Mix uppercase &amp; lowercase letters</li>
                                <li>Include numbers &amp; symbols</li>
                                <li>Don't reuse old passwords</li>
                            </ul>
                        </div>
                        <form action="{{ route('customer.password.change') }}" method="POST" class="cd-form-card">
                            @csrf
                            <div class="cd-form-group">
                                <label class="cd-label">Current Password <span class="req">*</span></label>
                                <div class="cd-input-wrap">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                        <rect x="3" y="11" width="18" height="11" rx="2" stroke="#aaa" stroke-width="1.8" />
                                        <path d="M7 11V7a5 5 0 0110 0v4" stroke="#aaa" stroke-width="1.8" stroke-linecap="round" />
                                    </svg>
                                    <input type="password" name="old_password" id="oldPass" class="cd-input" placeholder="Current password" required>
                                </div>
                            </div>
                            <div class="cd-form-group">
                                <label class="cd-label">New Password <span class="req">*</span></label>
                                <div class="cd-input-wrap">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                        <rect x="3" y="11" width="18" height="11" rx="2" stroke="#aaa" stroke-width="1.8" />
                                        <path d="M7 11V7a5 5 0 0110 0v4" stroke="#aaa" stroke-width="1.8" stroke-linecap="round" />
                                    </svg>
                                    <input type="password" name="new_password" id="newPass" class="cd-input" placeholder="New password (min. 6 chars)" required oninput="checkPassStrength(this.value)">
                                </div>
                                <div class="cd-strength-wrap" id="passStrengthWrap" style="display:none;">
                                    <div class="cd-strength-bar">
                                        <div class="cd-strength-fill" id="passStrengthFill"></div>
                                    </div>
                                    <span class="cd-strength-label" id="passStrengthLabel"></span>
                                </div>
                            </div>
                            <div class="cd-form-group">
                                <label class="cd-label">Confirm New Password <span class="req">*</span></label>
                                <div class="cd-input-wrap">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                        <rect x="3" y="11" width="18" height="11" rx="2" stroke="#aaa" stroke-width="1.8" />
                                        <path d="M7 11V7a5 5 0 0110 0v4" stroke="#aaa" stroke-width="1.8" stroke-linecap="round" />
                                    </svg>
                                    <input type="password" name="new_password_confirmation" id="confirmPass" class="cd-input" placeholder="Re-enter new password" required>
                                </div>
                            </div>
                            <div class="cd-form-actions">
                                <button type="submit" class="cd-submit-btn">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" style="margin-top:0px;">
                                        <path d="M12 2L4 6v6c0 5.25 3.5 10.15 8 11.35C16.5 22.15 20 17.25 20 12V6l-8-4z" stroke="currentColor" stroke-width="2" stroke-linejoin="round" />
                                    </svg>
                                    Update Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </main>
        </div>
    </section>

    <!-- ORDER DETAIL MODAL -->
    <div class="od-overlay" id="orderDetailOverlay" onclick="closeOrderDetail(event)">
        <div class="od-modal">
            <div class="od-modal-header">
                <div>
                    <h3 class="od-modal-title" id="od-title">Order Details</h3>
                    <p class="od-modal-sub" id="od-sub"></p>
                </div>
                <div style="display:flex;gap:10px;align-items:center;">
                    {{-- ✅ CHANGED: button → <a> tag, href set by JS --}}
                    <a class="od-invoice-btn" id="od-invoice-btn" href="#" target="_blank" style="text-decoration:none;">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" style="margin-top:-5px;">
                            <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <polyline points="14 2 14 8 20 8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        Download Invoice
                    </a>
                    <button class="od-close-btn" onclick="closeOrderDetailBtn()">✕</button>
                </div>
            </div>
            <div class="od-modal-body" id="od-body"></div>
        </div>
    </div>

    <!-- Logout Modal -->
    <div class="logout-modal-overlay" id="logoutModal">
        <div class="logout-modal-box">
            <div class="logout-modal-icon" id="logoutModalIcon"></div>
            <h4 class="logout-modal-title">Are you sure?</h4>
            <p class="logout-modal-desc">You will be logged out of your account.</p>
            <div class="logout-modal-actions">
                <button class="logout-modal-cancel" id="logoutModalCancel">Cancel</button>
                <button class="logout-modal-confirm" id="logoutModalConfirm">Logout</button>
            </div>
        </div>
    </div>

    <style>
        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        /* ── Status Badges ── */
        .ord-status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px 0;
            border-radius: 20px;
            font-size: 11.5px;
            font-weight: 600;
        }

        .ord-status-badge.warning {
            background: #fef3c7;
            color: #92400e;
        }

        .ord-status-badge.success {
            background: #d1fae5;
            color: #065f46;
        }

        .ord-status-badge.primary {
            background: #dbeafe;
            color: #1e40af;
        }

        .ord-status-badge.info {
            background: #e0f2fe;
            color: #075985;
        }

        .ord-status-badge.danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .ord-status-badge.secondary {
            background: #f3f4f6;
            color: #4b5563;
        }

        /* ── Order Buttons ── */
        .ord-view-btn {
            background: #1A1A1A;
            color: #fff;
            border: none;
            border-radius: 7px;
            padding: 6px 14px 2px;
            font-size: 12.5px;
            font-weight: 600;
            cursor: pointer;
            transition: background .2s;
        }

        .ord-view-btn:hover {
            background: #374151;
        }

        .ord-track-btn {
            background: transparent;
            color: #B8860B;
            border: 1.5px solid #B8860B;
            border-radius: 7px;
            padding: 5px 12px 1px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            margin-left: 6px;
            transition: all .2s;
        }

        .ord-track-btn:hover {
            background: #B8860B;
            color: #fff;
        }

        /* ── ✅ NEW: Invoice button ── */
        .ord-invoice-btn {
            background: transparent;
            color: #1a1a2e;
            border: 1.5px solid #1a1a2e;
            border-radius: 7px;
            padding: 5px 10px 1px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            margin-left: 6px;
            transition: all .2s;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            text-decoration: none;
        }

        .ord-invoice-btn:hover {
            background: #1a1a2e;
            color: #fff;
        }

        /* ── Desktop Orders Table ── */
        .orders-table-wrap {
            overflow-x: auto;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
        }

        .orders-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13.5px;
        }

        .orders-table th {
            background: #f9fafb;
            padding: 11px 14px;
            text-align: left;
            font-size: 11.5px;
            text-transform: uppercase;
            letter-spacing: .5px;
            color: #6b7280;
            border-bottom: 2px solid #e5e7eb;
            border-right: 1px solid #e5e7eb;
        }

        .orders-table th:last-child {
            border-right: none;
        }

        .orders-table td {
            padding: 13px 14px;
            border-bottom: 1px solid #e5e7eb;
            border-right: 1px solid #e5e7eb;
            color: #374151;
            vertical-align: middle;
        }

        .orders-table td:last-child {
            border-right: none;
        }

        .orders-table tr:last-child td {
            border-bottom: none;
        }

        .orders-table tr:hover td {
            background: #fafafa;
        }

        /* ── Order Detail Modal ── */
        .od-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .45);
            z-index: 9999;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .od-overlay.active {
            display: flex;
        }

        .od-modal {
            background: #fff;
            border-radius: 16px;
            width: 100%;
            max-width: 680px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 20px 60px rgba(0, 0, 0, .2);
        }

        .od-modal-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 22px 24px 16px;
            border-bottom: 1px solid #f3f4f6;
        }

        .od-modal-title {
            font-size: 18px;
            font-weight: 700;
            color: #1A1A1A;
            margin: 0 0 3px;
        }

        .od-modal-sub {
            font-size: 12.5px;
            color: #6b7280;
            margin: 0;
        }

        .od-close-btn {
            background: #f3f4f6;
            border: none;
            border-radius: 8px;
            width: 34px;
            height: 34px;
            font-size: 16px;
            cursor: pointer;
            color: #6b7280;
            transition: background .2s;
            padding-top: 5px;
        }

        .od-close-btn:hover {
            background: #e5e7eb;
        }

        .od-invoice-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #1A1A1A;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 8px 16px 4px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: background .2s;
            text-decoration: none;
        }

        .od-invoice-btn:hover {
            background: #374151;
            color: #fff;
        }

        .od-modal-body {
            padding: 22px 24px;
        }

        .od-section {
            margin-bottom: 22px;
        }

        .od-section-title {
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .6px;
            color: #9ca3af;
            margin-bottom: 12px;
        }

        .od-meta-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }

        .od-meta-item {
            background: #f9fafb;
            border-radius: 8px;
            padding: 12px 14px;
        }

        .od-meta-label {
            font-size: 11px;
            color: #9ca3af;
            margin-bottom: 3px;
        }

        .od-meta-value {
            font-size: 14px;
            font-weight: 600;
            color: #1A1A1A;
        }

        .od-items-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13.5px;
        }

        .od-items-table th {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .5px;
            color: #9ca3af;
            padding: 8px 0;
            border-bottom: 1px solid #e5e7eb;
        }

        .od-items-table td {
            padding: 12px 0;
            border-bottom: 1px solid #f3f4f6;
        }

        .od-items-table tr:last-child td {
            border-bottom: none;
        }

        .od-item-img {
            width: 42px;
            height: 42px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
        }

        .od-totals {
            border-top: 1px solid #e5e7eb;
            padding-top: 14px;
        }

        .od-total-row {
            display: flex;
            justify-content: space-between;
            font-size: 13.5px;
            color: #374151;
            padding: 4px 0;
        }

        .od-total-row.grand {
            font-size: 16px;
            font-weight: 700;
            color: #1A1A1A;
            border-top: 1px solid #e5e7eb;
            margin-top: 8px;
            padding-top: 10px;
        }

        .od-addr {
            font-size: 13.5px;
            color: #374151;
            line-height: 1.7;
            background: #f9fafb;
            border-radius: 8px;
            padding: 14px 16px;
        }

        /* ── Track Steps ── */
        .cd-track-steps {
            display: flex;
            flex-direction: column;
            gap: 0;
            margin-top: 24px;
        }

        .cd-track-step {
            display: flex;
            align-items: flex-start;
            gap: 14px;
        }

        .cd-track-dot {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: background .3s;
        }

        .cd-track-step.done .cd-track-dot {
            background: #10b981;
        }

        .cd-track-step.active .cd-track-dot {
            background: #B8860B;
        }

        .cd-track-line {
            width: 2px;
            height: 32px;
            margin-left: 17px;
            background: #e5e7eb;
        }

        .cd-track-line.done {
            background: #10b981;
        }

        .cd-track-line.active {
            background: linear-gradient(#10b981, #B8860B);
        }

        .cd-track-info strong {
            display: block;
            font-size: 14px;
            color: #1A1A1A;
            margin-bottom: 2px;
        }

        .cd-track-info span {
            font-size: 12.5px;
            color: #6b7280;
        }

        .track-order-meta {
            background: #f9fafb;
            border-radius: 10px;
            padding: 14px 16px;
            margin-bottom: 16px;
            font-size: 13.5px;
            display: flex;
            gap: 24px;
            flex-wrap: wrap;
        }

        .track-order-meta strong {
            display: block;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .5px;
            color: #9ca3af;
            margin-bottom: 3px;
        }

        /* ── Track Chips ── */
        .track-chip {
            background: #f3f4f6;
            border: 1.5px solid #e5e7eb;
            border-radius: 20px;
            padding: 5px 14px 1px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            color: #374151;
            transition: all .2s;
        }

        .track-chip:hover,
        .track-chip.active {
            background: #1A1A1A;
            color: #fff;
            border-color: #1A1A1A;
        }

        /* ── Overview recent rows ── */
        .ov-order-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #f3f4f6;
            font-size: 13px;
        }

        .ov-order-row:last-child {
            border-bottom: none;
        }

        /* ── Security Tips ── */
        .cd-security-tips {
            width: 210px;
            flex-shrink: 0;
            background: #fff;
            border-radius: 16px;
            padding: 20px 18px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, .05);
            border: 1px solid var(--border-color);
        }

        .cd-tip-title {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            font-weight: 700;
            color: var(--secondary-color);
            margin-bottom: 14px;
            padding-bottom: 12px;
            border-bottom: 1px solid #f0e9d0;
        }

        .cd-tips-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .cd-tips-list li {
            font-size: 12.5px;
            color: var(--body-text-color);
            padding: 8px 0 6px 18px;
            border-bottom: 1px solid #f9f6ee;
            position: relative;
        }

        .cd-tips-list li::before {
            content: '✓';
            position: absolute;
            left: 0;
            color: var(--secondary-color);
            font-weight: 700;
        }

        .cd-tips-list li:last-child {
            border-bottom: none;
        }

        /* ── Form Card (password) ── */
        .cd-form-card {
            background: #fff;
            border-radius: 16px;
            padding: 22px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, .05);
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        /* ── Forms full width ── */
        .cd-form {
            width: 100%;
            box-sizing: border-box;
        }

        .cd-form-grid {
            width: 100%;
            box-sizing: border-box;
        }

        .cd-form-group {
            width: 100%;
            min-width: 0;
        }

        .cd-input-wrap {
            width: 100%;
            position: relative;
            display: flex;
            align-items: center;
        }

        .cd-input-wrap svg {
            position: absolute;
            left: 13px;
            pointer-events: none;
        }

        .cd-input-wrap .cd-input {
            width: 100%;
            box-sizing: border-box;
            min-width: 0;
        }

        .cd-form-actions {
            width: 100%;
            box-sizing: border-box;
        }

        /* ── Logout Modal ── */
        .logout-modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, .6);
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .logout-modal-overlay.active {
            display: flex;
        }

        .logout-modal-box {
            background: #fff;
            border-radius: 12px;
            padding: 24px;
            text-align: center;
            width: 320px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, .15);
        }

        .logout-modal-icon {
            margin: 0 auto 12px;
            width: 48px;
            height: 48px;
            background: var(--primary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-white-color);
        }

        .logout-modal-title {
            font-size: 18px;
            margin: 8px 0;
            color: var(--foreground-color);
        }

        .logout-modal-desc {
            font-size: 14px;
            color: var(--foreground-sub-color);
            margin-bottom: 16px;
        }

        .logout-modal-actions {
            display: flex;
            gap: 8px;
            justify-content: center;
        }

        .logout-modal-cancel {
            background: var(--bg-gray-color);
            border: none;
            padding: 8px 16px 4px;
            border-radius: 6px;
            cursor: pointer;
            color: var(--foreground-color);
            transition: var(--transition);
        }

        .logout-modal-cancel:hover {
            background: var(--border-color);
        }

        .logout-modal-confirm {
            background: var(--secondary-color);
            color: var(--text-white-color);
            border: none;
            padding: 8px 16px 4px;
            border-radius: 6px;
            cursor: pointer;
            transition: var(--transition);
        }

        .logout-modal-confirm:hover {
            background: var(--primary-color);
        }

        /* ════════════════════════════════════
                                               RESPONSIVE — TABLET (max 900px)
                                            ════════════════════════════════════ */
        @media (max-width: 900px) {
            .cd-container {
                flex-direction: column;
                gap: 16px;
            }

            .cd-sidebar {
                width: 100%;
                position: static;
            }

            .cd-nav {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 6px;
                padding: 10px;
            }

            .cd-nav-item {
                width: 100%;
                justify-content: flex-start;
                padding: 10px 12px;
                font-size: 13px;
            }

            .cd-nav-item.active {
                border-left: none;
                border-bottom: 2.5px solid var(--secondary-color);
                border-radius: 10px 10px 8px 8px;
            }

            .logout-item {
                grid-column: 1/-1;
            }

            .cd-stats {
                grid-template-columns: repeat(2, 1fr);
            }

            .cd-overview-grid {
                grid-template-columns: 1fr;
            }

            .cd-password-wrap {
                flex-direction: column;
            }

            .cd-security-tips {
                width: 100%;
                box-sizing: border-box;
                width: 37.5rem;
            }

            .cd-form-card {
                width: 100%;
                box-sizing: border-box;
            }

            .cd-form-grid {
                grid-template-columns: 1fr !important;
            }

            .cd-form-group-full {
                grid-column: auto;
            }

            .cd-photo-upload {
                flex-direction: row;
                align-items: center;
                gap: 16px;
                width: 100%;
                box-sizing: border-box;
            }

            .cd-track-search {
                flex-direction: column;
                gap: 10px;
            }

            .cd-track-btn {
                width: 100%;
                padding: 12px 22px 8px;
                text-align: center;
            }

            .od-modal {
                max-width: 100%;
                border-radius: 12px;
            }

            .od-modal-header {
                flex-wrap: wrap;
                gap: 10px;
            }

            .od-invoice-btn {
                font-size: 12px;
                padding: 7px 12px 4px;
            }
        }

        /* ════════════════════════════════════
                                               RESPONSIVE — MOBILE (max 600px)
                                            ════════════════════════════════════ */
        @media (max-width: 600px) {
            .cd-section {
                padding: 24px 12px 48px;
            }

            .cd-nav {
                grid-template-columns: 1fr 1fr;
                gap: 4px;
            }

            .cd-nav-item {
                padding: 9px 10px;
                font-size: 12.5px;
                gap: 7px;
            }

            .cd-nav-icon {
                width: 28px;
                height: 28px;
                flex-shrink: 0;
            }

            .cd-stats {
                grid-template-columns: repeat(2, 1fr);
                gap: 10px;
            }

            .cd-stat-card {
                padding: 14px 12px;
                gap: 10px;
            }

            .cd-stat-num {
                font-size: 18px;
            }

            .cd-tab-header h2 {
                font-size: 18px;
            }

            .cd-form-grid {
                padding: 16px;
            }

            .cd-photo-upload {
                padding: 16px;
                flex-direction: column;
                align-items: flex-start;
                width: 37.5rem;
            }

            .cd-photo-preview {
                width: 68px;
                height: 68px;
            }

            .cd-form-card {
                padding: 16px;
                border-radius: 12px;
            }

            .cd-submit-btn {
                width: 100%;
                justify-content: center;
                padding: 14px 20px 10px;
            }

            .cd-track-box {
                padding: 18px 16px;
            }

            .cd-info-card {
                padding: 16px;
                width: 37.5rem;
            }

            .od-overlay {
                padding: 10px;
            }

            .od-modal-header {
                padding: 16px 16px 12px;
            }

            .od-modal-body {
                padding: 16px;
            }

            .od-meta-grid {
                grid-template-columns: 1fr 1fr;
                gap: 8px;
            }

            .track-order-meta {
                gap: 14px;
                font-size: 13px;
            }

            .cd-flash {
                font-size: 13px;
                padding: 11px 14px;
            }

            .logout-modal-box {
                width: 90%;
                max-width: 300px;
                padding: 20px;
            }
        }

        @media (max-width: 400px) {
            .od-meta-grid {
                grid-template-columns: 1fr;
            }
        }

        /* ════════════════════════════════════
                                               DESKTOP PASSWORD LAYOUT
                                            ════════════════════════════════════ */
        @media (min-width: 901px) {
            .cd-password-wrap {
                display: flex;
                gap: 24px;
                align-items: flex-start;
            }

            .cd-security-tips {
                width: 210px;
                flex-shrink: 0;
            }

            .cd-form-card {
                flex: 1;
                min-width: 0;
            }
        }
    </style>

    <script>
        let allOrders = [];

        const PAYMENT_LABELS = {
            paypal: 'PayPal',
            cod: 'Cash on Delivery',
            bank_transfer: 'Bank Transfer'
        };

        function getPaymentLabel(method) {
            if (!method) return '—';
            return PAYMENT_LABELS[method.toLowerCase()] ?? method;
        }

        /* ── Fetch Orders ── */
        async function fetchOrders() {
            try {
                const res = await fetch('{{ route('customer.orders') }}', {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                const data = await res.json();
                if (data.success) {
                    allOrders = data.orders;
                    renderOrderStats();
                    renderOrdersTable();
                    renderOverviewRecent();
                    renderTrackChips();
                }
            } catch (e) {
                document.getElementById('orders-container').innerHTML = '<p style="text-align:center;color:#ef4444;padding:40px;">Failed to load orders.</p>';
            }
        }

        /* ── Stats ── */
        function renderOrderStats() {
            const total = allOrders.length;
            const delivered = allOrders.filter(o => o.status === 'delivered').length;
            const pending = allOrders.filter(o => o.status === 'pending' || o.status === 'processing').length;
            const spent = allOrders.reduce((s, o) => s + parseFloat(o.total.replace(/,/g, '')), 0);
            document.getElementById('stat-total').textContent = total;
            document.getElementById('stat-delivered').textContent = delivered;
            document.getElementById('stat-pending').textContent = pending;
            document.getElementById('stat-spent').textContent = '$' + spent.toFixed(2);
        }

        /* ── Payment Badge ── */
        function paymentBadge(status) {
            const map = {
                paid: 'success',
                failed: 'danger',
                refunded: 'warning',
                pending: 'secondary'
            };
            return `<span class="ord-status-badge ${map[status]||'secondary'}">${status.charAt(0).toUpperCase()+status.slice(1)}</span>`;
        }

        /* ── Orders Table (mobile card / desktop table) ── */
        function renderOrdersTable() {
            const wrap = document.getElementById('orders-container');

            if (!allOrders.length) {
                wrap.innerHTML = `
                <div style="text-align:center;padding:60px 20px;">
                    <svg width="64" height="64" viewBox="0 0 24 24" fill="none" style="margin-bottom:16px;">
                        <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2" stroke="#e0c8d8" stroke-width="1.5" stroke-linecap="round"/>
                        <rect x="9" y="3" width="6" height="4" rx="1" stroke="#e0c8d8" stroke-width="1.5"/>
                        <path d="M9 12h6M9 16h4" stroke="#e0c8d8" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                    <h4 style="color:#6b7280;margin-bottom:8px;">No orders found</h4>
                    <p style="color:#9ca3af;font-size:14px;margin-bottom:20px;">You haven't placed any orders yet.</p>
                    <a href="{{ route('shop') }}" class="cd-shop-btn">Start Shopping →</a>
                </div>`;
                return;
            }

            if (window.innerWidth <= 767) {
                /* ── MOBILE: cards ── */
                wrap.innerHTML = allOrders.map(o => `
                <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:16px;margin-bottom:12px;box-shadow:0 1px 4px rgba(0,0,0,.05);box-sizing:border-box; width:37.5rem;">
                    <div style="font-size:14px;font-weight:700;color:#1A1A1A;margin-bottom:4px;">${o.order_number}</div>
                    <div style="font-size:12px;color:#9ca3af;margin-bottom:10px;">${o.date} &nbsp;·&nbsp; ${o.items.length} item(s)</div>
                    <div style="font-size:17px;font-weight:700;color:#1A1A1A;margin-bottom:10px;">$${o.total}</div>
                    <div style="display:flex;gap:6px;flex-wrap:wrap;margin-bottom:12px;">
                        ${paymentBadge(o.payment_status)}
                        <span class="ord-status-badge ${o.status_color}">${o.status_label}</span>
                    </div>
                    <div style="display:flex;gap:8px;width:100%;">
                        <button class="ord-view-btn"
                            style="flex:1;padding:10px 0 6px;text-align:center;font-size:13px;border-radius:8px;"
                            onclick="openOrderDetail(${o.id})" title="View Order">View</button>
                        <button class="ord-track-btn"
                            style="flex:1;padding:9px 0 5px;text-align:center;font-size:13px;margin-left:0;border-radius:8px;"
                            onclick="goTrack('${o.order_number}')" title="Track Order">Track</button>
                        <a href="${o.invoice_url}" target="_blank" class="ord-invoice-btn"
                            style="flex:1;padding:9px 0 5px;text-align:center;font-size:13px;border-radius:8px;justify-content:center;" title="Download Invoice">
                            Invoice
                        </a>
                    </div>
                </div>`).join('');
            } else {
                /* ── DESKTOP: table ── */
                wrap.innerHTML = `
                <div class="orders-table-wrap">
                    <table class="orders-table">
                        <thead><tr>
                            <th>Order #</th><th>Date</th><th>Items</th>
                            <th>Total</th><th>Payment</th><th>Status</th><th>Action</th>
                        </tr></thead>
                        <tbody>${allOrders.map(o => `
                                                            <tr>
                                                                <td><strong>${o.order_number}</strong></td>
                                                                <td>${o.date}</td>
                                                                <td>${o.items.length} item(s)</td>
                                                                <td><strong>$${o.total}</strong></td>
                                                                <td>${paymentBadge(o.payment_status)}</td>
                                                                <td><span class="ord-status-badge ${o.status_color}">${o.status_label}</span></td>
                                                                <td style="white-space:nowrap; display:flex; gap:6px; align-items:center;">
                                                                    <button class="ord-view-btn" onclick="openOrderDetail(${o.id})" title="View">
                                                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
                                                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                                                            <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2"/>
                                                                        </svg>
                                                                    </button>
                                                                    <button class="ord-track-btn" onclick="goTrack('${o.order_number}')" title="Track">
                                                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
                                                                            <circle cx="12" cy="12" r="7" stroke="currentColor" stroke-width="2"/>
                                                                            <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2"/>
                                                                            <line x1="12" y1="2" x2="12" y2="5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                                                            <line x1="12" y1="19" x2="12" y2="22" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                                                            <line x1="2" y1="12" x2="5" y2="12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                                                            <line x1="19" y1="12" x2="22" y2="12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                                                        </svg>
                                                                    </button>
                                                                    <a href="${o.invoice_url}" target="_blank" class="ord-invoice-btn" title="Download Invoice" style="padding: 9px 11px;">
                                                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
                                                                            <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                                                            <polyline points="7 10 12 15 17 10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                                            <line x1="12" y1="15" x2="12" y2="3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                                                        </svg>
                                                                    </a>
                                                                </td>
                                                            </tr>`).join('')}</tbody>
                    </table>
                </div>`;
            }
        }

        /* re-render on resize */
        let _rt;
        window.addEventListener('resize', () => {
            clearTimeout(_rt);
            _rt = setTimeout(() => {
                if (allOrders.length) renderOrdersTable();
            }, 200);
        });

        /* ── Overview Recent ── */
        function renderOverviewRecent() {
            const el = document.getElementById('overview-recent-orders');
            const last = allOrders.slice(0, 3);
            if (!last.length) {
                el.innerHTML = `<div class="cd-empty-state"><p>No orders yet</p></div>`;
                return;
            }
            el.innerHTML = last.map(o => `
            <div class="ov-order-row">
                <span><strong>${o.order_number}</strong> <small style="color:#9ca3af;">${o.date}</small></span>
                <span><strong>$${o.total}</strong></span>
                <span class="ord-status-badge ${o.status_color}" style="font-size:11px;">${o.status_label}</span>
            </div>`).join('');
        }

        /* ── Order Detail Modal ── */
        function openOrderDetail(id) {
            const o = allOrders.find(x => x.id === id);
            if (!o) return;

            document.getElementById('od-title').textContent = 'Order ' + o.order_number;
            document.getElementById('od-sub').textContent = 'Placed on ' + o.date;

            /* ✅ Set invoice download URL directly on the <a> tag */
            document.getElementById('od-invoice-btn').href = o.invoice_url;

            const itemsHtml = o.items.map(item => `
            <tr>
                <td><div style="display:flex;align-items:center;gap:10px;">
                    <img src="${item.image}" alt="" class="od-item-img">
                    <span style="font-size:13.5px;font-weight:500;">${item.name}</span>
                </div></td>
                <td style="text-align:center;color:#6b7280;">×${item.quantity}</td>
                <td style="text-align:right;font-weight:600;">$${item.subtotal}</td>
            </tr>`).join('');

            const discountRow = parseFloat(o.discount) > 0 ?
                `<div class="od-total-row" style="color:#059669;"><span>Discount</span><span>-$${o.discount}</span></div>` : '';

            document.getElementById('od-body').innerHTML = `
            <div class="od-section">
                <div class="od-section-title">Order Info</div>
                <div class="od-meta-grid">
                    <div class="od-meta-item"><div class="od-meta-label">Order Number</div><div class="od-meta-value">${o.order_number}</div></div>
                    <div class="od-meta-item"><div class="od-meta-label">Date</div><div class="od-meta-value">${o.date}</div></div>
                    <div class="od-meta-item"><div class="od-meta-label">Payment</div><div class="od-meta-value">${getPaymentLabel(o.payment_method)}</div></div>
                    <div class="od-meta-item"><div class="od-meta-label">Status</div><div class="od-meta-value"><span class="ord-status-badge ${o.status_color}">${o.status_label}</span></div></div>
                </div>
            </div>
            <div class="od-section">
                <div class="od-section-title">Items</div>
                <table class="od-items-table">
                    <thead><tr>
                        <th style="text-align:left;">Product</th>
                        <th style="text-align:center;">Qty</th>
                        <th style="text-align:right;">Total</th>
                    </tr></thead>
                    <tbody>${itemsHtml}</tbody>
                </table>
                <div class="od-totals">
                    <div class="od-total-row"><span>Subtotal</span><span>$${o.subtotal}</span></div>
                    ${discountRow}
                    <div class="od-total-row"><span>Shipping (${o.shipping_method})</span><span>$${o.shipping_cost}</span></div>
                    ${parseFloat(o.tax) > 0 ? `<div class="od-total-row"><span>Tax (${o.tax_rate}%)</span><span>$${o.tax}</span></div>` : ''}
                    <div class="od-total-row grand"><span>Total</span><span>$${o.total}</span></div>
                </div>
            </div>
            <div class="od-section">
                <div class="od-section-title">Shipping Address</div>
                <div class="od-addr">${o.address}<br>${o.phone}</div>
            </div>`;

            document.getElementById('orderDetailOverlay').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeOrderDetail(e) {
            if (e.target === document.getElementById('orderDetailOverlay')) closeOrderDetailBtn();
        }

        function closeOrderDetailBtn() {
            document.getElementById('orderDetailOverlay').classList.remove('active');
            document.body.style.overflow = '';
        }

        /* ── Track Order ── */
        const STATUS_STEPS = ['pending', 'processing', 'shipped', 'delivered'];

        function renderTrackChips() {
            if (!allOrders.length) return;
            document.getElementById('track-quick-pick').style.display = 'block';
            document.getElementById('track-order-chips').innerHTML = allOrders.slice(0, 5)
                .map(o => `<button class="track-chip" onclick="goTrack('${o.order_number}')">${o.order_number}</button>`).join('');
        }

        function goTrack(orderNumber) {
            switchTab('tracking');
            document.getElementById('trackOrderId').value = orderNumber;
            document.querySelectorAll('.track-chip').forEach(c => c.classList.toggle('active', c.textContent === orderNumber));
            trackOrder();
        }

        function trackOrder() {
            const input = document.getElementById('trackOrderId').value.trim();
            const resultEl = document.getElementById('trackResult');
            const notFoundEl = document.getElementById('track-not-found');
            resultEl.style.display = 'none';
            notFoundEl.style.display = 'none';
            if (!input) {
                alert('Please enter an order number.');
                return;
            }

            const o = allOrders.find(x =>
                x.order_number.toLowerCase() === input.toLowerCase() ||
                x.order_number.toLowerCase().includes(input.toLowerCase())
            );
            if (!o) {
                notFoundEl.style.display = 'block';
                return;
            }

            document.getElementById('track-order-meta').innerHTML = `
            <div><strong>Order</strong>${o.order_number}</div>
            <div><strong>Date</strong>${o.date}</div>
            <div><strong>Status</strong><span class="ord-status-badge ${o.status_color}" style="margin-top:3px;">${o.status_label}</span></div>
            <div><strong>Total</strong>$${o.total}</div>`;

            const currentIdx = o.status === 'cancelled' ? -1 : STATUS_STEPS.indexOf(o.status);
            const stepDefs = [{
                    key: 'pending',
                    label: 'Order Placed',
                    desc: 'Your order has been received'
                },
                {
                    key: 'processing',
                    label: 'Processing',
                    desc: 'Your order is being prepared'
                },
                {
                    key: 'shipped',
                    label: 'Shipped',
                    desc: 'Your order is on the way'
                },
                {
                    key: 'delivered',
                    label: 'Delivered',
                    desc: 'Order delivered successfully'
                },
            ];

            if (o.status === 'cancelled') {
                document.getElementById('track-steps-wrap').innerHTML = `
                <div style="text-align:center;padding:24px;background:#fff5f5;border-radius:10px;color:#ef4444;">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" style="margin-bottom:8px;">
                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
                        <path d="M15 9l-6 6M9 9l6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    <p style="font-weight:600;">This order has been cancelled.</p>
                </div>`;
            } else {
                let html = '';
                stepDefs.forEach((step, i) => {
                    const isDone = i < currentIdx;
                    const isActive = i === currentIdx;
                    const cls = isDone ? 'done' : isActive ? 'active' : '';
                    const icon = isDone ?
                        `<svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>` :
                        isActive ?
                        `<svg width="10" height="10" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="8" fill="#fff"/></svg>` :
                        `<svg width="10" height="10" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="6" stroke="#9ca3af" stroke-width="2"/></svg>`;
                    html += `<div class="cd-track-step ${cls}"><div class="cd-track-dot">${icon}</div><div class="cd-track-info"><strong>${step.label}</strong><span>${step.desc}</span></div></div>`;
                    if (i < stepDefs.length - 1) {
                        html += `<div class="cd-track-line ${isDone ? 'done' : isActive ? 'active' : ''}"></div>`;
                    }
                });
                document.getElementById('track-steps-wrap').innerHTML = html;
            }
            resultEl.style.display = 'block';
        }

        /* ── Tab Switching ── */
        document.querySelectorAll('.cd-nav-item[data-tab]').forEach(btn => {
            btn.addEventListener('click', function() {
                switchTab(this.dataset.tab);
            });
        });
        document.querySelectorAll('.cd-overview-btn[data-tab]').forEach(btn => {
            btn.addEventListener('click', function() {
                switchTab(this.dataset.tab);
            });
        });

        function switchTab(tab) {
            document.querySelectorAll('.cd-nav-item[data-tab]').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.cd-tab').forEach(t => t.classList.remove('active'));
            document.querySelector(`.cd-nav-item[data-tab="${tab}"]`)?.classList.add('active');
            document.getElementById(`tab-${tab}`)?.classList.add('active');
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        /* ── Helpers ── */
        function checkPassStrength(val) {
            const wrap = document.getElementById('passStrengthWrap');
            const fill = document.getElementById('passStrengthFill');
            const label = document.getElementById('passStrengthLabel');
            if (!val) {
                wrap.style.display = 'none';
                return;
            }
            wrap.style.display = 'flex';
            let score = 0;
            if (val.length >= 6) score++;
            if (val.length >= 10) score++;
            if (/[A-Z]/.test(val)) score++;
            if (/[0-9]/.test(val)) score++;
            if (/[^A-Za-z0-9]/.test(val)) score++;
            const levels = [{
                    w: '20%',
                    bg: '#ef4444',
                    text: 'Weak'
                },
                {
                    w: '40%',
                    bg: '#f97316',
                    text: 'Fair'
                },
                {
                    w: '60%',
                    bg: '#eab308',
                    text: 'Good'
                },
                {
                    w: '80%',
                    bg: '#22c55e',
                    text: 'Strong'
                },
                {
                    w: '100%',
                    bg: '#15803d',
                    text: 'Very Strong'
                },
            ];
            const lvl = levels[Math.min(score - 1, 4)] || levels[0];
            fill.style.width = lvl.w;
            fill.style.background = lvl.bg;
            label.textContent = lvl.text;
            label.style.color = lvl.bg;
        }

        function previewPhoto(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => {
                    document.getElementById('photoPreview').src = e.target.result;
                    document.getElementById('avatarPreview').src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        /* ── Logout Modal ── */
        document.getElementById('logoutBtn').addEventListener('click', e => {
            e.preventDefault();
            document.getElementById('logoutModalIcon').innerHTML = `<svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/><polyline points="16 17 21 12 16 7" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/><line x1="21" y1="12" x2="9" y2="12" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>`;
            document.getElementById('logoutModal').classList.add('active');
        });
        document.getElementById('logoutModalCancel').addEventListener('click', () => document.getElementById('logoutModal').classList.remove('active'));
        document.getElementById('logoutModalConfirm').addEventListener('click', () => {
            window.location.href = "{{ route('customer.logout') }}";
        });

        /* ── URL Hash Tab ── */
        const hash = window.location.hash.replace('#', '');
        if (['overview', 'orders', 'tracking', 'profile', 'password'].includes(hash)) switchTab(hash);

        fetchOrders();

        fetchMyBlogs();

        async function fetchMyBlogs() {
            try {
                const res = await fetch('{{ route('customer.blogs') }}', {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                const data = await res.json();
                renderMyBlogs(data.blogs ?? []);
            } catch (e) {
                document.getElementById('myblogs-container').innerHTML =
                    '<p style="color:#ef4444;text-align:center;padding:40px;">Failed to load blogs.</p>';
            }
        }

        function renderMyBlogs(blogs) {
            const wrap = document.getElementById('myblogs-container');

            // ── Stats update ──────────────────────────────────────────────────────
            document.getElementById('stat-blogs').textContent = blogs.length;

            if (!blogs.length) {
                wrap.innerHTML = `
        <div style="text-align:center;padding:60px 20px;">
            <svg width="56" height="56" viewBox="0 0 24 24" fill="none" style="margin-bottom:14px;opacity:.2;">
                <path d="M12 20h9M16.5 3.5a2.121 2.121 0 013 3L7 19l-4 1 1-4L16.5 3.5z"
                      stroke="#1a1a1a" stroke-width="1.8" stroke-linecap="round"/>
            </svg>
            <p style="color:#9ca3af;font-size:14px;margin-bottom:16px;">You haven't submitted any blogs yet.</p>
            <a href="{{ route('blog.submit') }}"
               style="display:inline-flex;align-items:center;gap:6px;background:#1a1a1a;color:#fff;
                      padding:10px 20px 6px;border-radius:9px;font-size:13.5px;font-weight:600;text-decoration:none;">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none">
                    <path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
                </svg>
                Write Your First Blog
            </a>
        </div>`;
                return;
            }

            // ── Mini stats bar ────────────────────────────────────────────────────
            const pending = blogs.filter(b => b.status === 'pending').length;
            const published = blogs.filter(b => b.status === 'active').length;
            const rejected = blogs.filter(b => b.status === 'rejected').length;

            const statsBar = `
    <div style="display:flex;gap:10px;flex-wrap:wrap;margin-bottom:20px;">
        <div style="background:#fef3c7;border-radius:9px;padding:10px 16px;flex:1;min-width:100px;text-align:center;">
            <div style="font-size:20px;font-weight:700;color:#92400e;">${pending}</div>
            <div style="font-size:11.5px;color:#b45309;margin-top:2px;">Pending</div>
        </div>
        <div style="background:#d1fae5;border-radius:9px;padding:10px 16px;flex:1;min-width:100px;text-align:center;">
            <div style="font-size:20px;font-weight:700;color:#065f46;">${published}</div>
            <div style="font-size:11.5px;color:#059669;margin-top:2px;">Published</div>
        </div>
        <div style="background:#fee2e2;border-radius:9px;padding:10px 16px;flex:1;min-width:100px;text-align:center;">
            <div style="font-size:20px;font-weight:700;color:#991b1b;">${rejected}</div>
            <div style="font-size:11.5px;color:#dc2626;margin-top:2px;">Rejected</div>
        </div>
    </div>`;

            // ── Status config ─────────────────────────────────────────────────────
            const statusColors = {
                pending: {
                    bg: '#fef3c7',
                    color: '#92400e',
                    label: 'Pending Review'
                },
                active: {
                    bg: '#d1fae5',
                    color: '#065f46',
                    label: 'Published'
                },
                rejected: {
                    bg: '#fee2e2',
                    color: '#991b1b',
                    label: 'Rejected'
                },
                inactive: {
                    bg: '#f3f4f6',
                    color: '#4b5563',
                    label: 'Inactive'
                },
            };

            // ── Blog cards ────────────────────────────────────────────────────────
            const cards = blogs.map(b => {
                const s = statusColors[b.status] || statusColors.inactive;

                // Edit button শুধু pending blogs এ দেখাবে
                const editBtn = b.status === 'pending' ?
                    `<a href="/blog/edit/${b.id}"
                  style="font-size:12px;color:#6b7280;border:1px solid #e5e7eb;border-radius:6px;
                         padding:4px 10px 1px;text-decoration:none;display:inline-flex;align-items:center;gap:4px;
                         transition:all .2s;"
                  onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background='transparent'">
                  <svg width="12" height="12" viewBox="0 0 24 24" fill="none">
                      <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                      <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                  </svg>
                  Edit
              </a>` :
                    '';

                // View link শুধু published blogs এ
                const viewLink = b.status === 'active' ?
                    `<a href="${b.url}" target="_blank"
                  style="font-size:12.5px;color:#2563eb;font-weight:600;text-decoration:none;">
                  View →
              </a>` :
                    '';

                return `
        <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;
                    padding:16px 20px;margin-bottom:10px;transition:box-shadow .2s;"
             onmouseover="this.style.boxShadow='0 2px 12px rgba(0,0,0,.08)'"
             onmouseout="this.style.boxShadow='none'">

            <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:12px;flex-wrap:wrap;">

                {{-- Left: info --}}
                <div style="flex:1;min-width:0;">
                    <h4 style="font-size:14.5px;font-weight:700;margin:0 0 5px;color:#1A1A1A;
                               white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                        ${b.title}
                    </h4>
                    <p style="font-size:12px;color:#9ca3af;margin:0 0 6px;">
                        <span style="background:#f3f4f6;border-radius:4px;padding:2px 7px;font-size:11px;">
                            ${b.category}
                        </span>
                        &nbsp;·&nbsp; Submitted ${b.submitted_at}
                    </p>
                    ${b.rejection_reason
                        ? `<p style="font-size:12px;color:#ef4444;margin:0;background:#fff5f5;
                                        border-radius:6px;padding:6px 10px;border-left:3px solid #ef4444;">
                                   <strong>Rejection reason:</strong> ${b.rejection_reason}
                               </p>`
                        : ''}
                </div>

                {{-- Right: status + actions --}}
                <div style="display:flex;align-items:center;gap:8px;flex-shrink:0;flex-wrap:wrap;">
                    <span style="background:${s.bg};color:${s.color};padding:4px 12px 1px;
                                 border-radius:20px;font-size:11.5px;font-weight:600;white-space:nowrap;">
                        ${s.label}
                    </span>
                    ${editBtn}
                    ${viewLink}
                </div>

            </div>
        </div>`;
            }).join('');

            wrap.innerHTML = statsBar + cards;
        }
    </script>

@endsection
