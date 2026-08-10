@extends('admin.dashboard')
@section('admin')
    <style>
        :root {
            --nm-gold: #B8860B;
            --nm-gold-light: #D4A017;
            --nm-gold-pale: #F5ECD0;
            --nm-dark: #1A1A1A;
            --nm-dark-2: #2C2C2A;
            --nm-surface: #FAFAF8;
        }

        .nm-dashboard {
            background: #fff;
            min-height: 100vh;
            padding: 28px 32px 48px;
            font-family: 'Georgia', serif;
        }

        /* ── Hero Banner ─────────────────────────────── */
        .nm-hero {
            position: relative;
            background: var(--nm-dark);
            border-radius: 16px;
            overflow: hidden;
            padding: 32px 40px;
            margin-bottom: 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .nm-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(115deg, #000 0%, #1A1400 40%, #3A2800 70%, #6B4E00 100%);
            opacity: 0.9;
        }

        .nm-hero-accent {
            position: absolute;
            top: -60px;
            right: -60px;
            width: 280px;
            height: 280px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(184, 134, 11, 0.35) 0%, transparent 70%);
            pointer-events: none;
        }

        .nm-hero-accent2 {
            position: absolute;
            bottom: -40px;
            left: 30%;
            width: 180px;
            height: 180px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(184, 134, 11, 0.15) 0%, transparent 70%);
            pointer-events: none;
        }

        .nm-hero-left {
            position: relative;
            z-index: 2;
        }

        .nm-hero-eyebrow {
            font-size: 11px;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: var(--nm-gold);
            margin-bottom: 6px;
            font-family: sans-serif;
            font-weight: 600;
        }

        .nm-hero-title {
            font-size: 28px;
            font-weight: 700;
            color: #fff;
            margin: 0 0 6px;
            letter-spacing: -0.3px;
        }

        .nm-hero-sub {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.55);
            margin: 0;
            font-family: sans-serif;
        }

        .nm-hero-right {
            position: relative;
            z-index: 2;
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .nm-hero-date {
            text-align: right;
            font-family: sans-serif;
        }

        .nm-hero-date .day {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.4);
            display: block;
        }

        .nm-hero-date .full {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.75);
            display: block;
            margin-top: 2px;
        }

        .nm-visit-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--nm-gold);
            color: #fff !important;
            border: none;
            border-radius: 50px;
            padding: 11px 24px;
            font-size: 13px;
            font-weight: 600;
            font-family: sans-serif;
            letter-spacing: 0.3px;
            text-decoration: none !important;
            transition: background 0.2s, transform 0.15s;
            white-space: nowrap;
        }

        .nm-visit-btn:hover {
            background: var(--nm-gold-light);
            transform: translateY(-1px);
            color: #fff !important;
        }

        .nm-visit-btn svg {
            flex-shrink: 0;
        }

        /* ── Section Title ───────────────────────────── */
        .nm-section-label {
            font-size: 11px;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: #888;
            font-family: sans-serif;
            font-weight: 600;
            margin-bottom: 14px;
            margin-top: 36px;
        }

        /* ── Stat Cards Grid ─────────────────────────── */
        .nm-stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 32px;
        }

        .nm-stat-card {
            background: #F5F4F0;
            border-radius: 14px;
            padding: 22px 24px;
            text-decoration: none !important;
            color: inherit !important;
            border: 1px solid rgba(0, 0, 0, 0.06);
            transition: transform 0.2s, box-shadow 0.2s;
            display: block;
            position: relative;
            overflow: hidden;
        }

        .nm-stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.09);
            color: inherit !important;
            text-decoration: none !important;
        }

        .nm-stat-card::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 3px;
        }

        .nm-stat-card.c-products::after {
            background: linear-gradient(90deg, #185FA5, #378ADD);
        }

        .nm-stat-card.c-orders::after {
            background: linear-gradient(90deg, #0F6E56, #1D9E75);
        }

        .nm-stat-card.c-blogs::after {
            background: linear-gradient(90deg, #854F0B, #EF9F27);
        }

        .nm-stat-card.c-contacts::after {
            background: linear-gradient(90deg, #993C1D, #D85A30);
        }

        .nm-stat-card.c-revenue::after {
            background: linear-gradient(90deg, var(--nm-gold), #D4A017);
        }

        .nm-stat-card.c-users::after {
            background: linear-gradient(90deg, #534AB7, #7F77DD);
        }

        .nm-stat-icon {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
            font-size: 20px;
        }

        .c-products .nm-stat-icon {
            background: #E6F1FB;
            color: #185FA5;
        }

        .c-orders .nm-stat-icon {
            background: #E1F5EE;
            color: #0F6E56;
        }

        .c-blogs .nm-stat-icon {
            background: #FAEEDA;
            color: #854F0B;
        }

        .c-contacts .nm-stat-icon {
            background: #FAECE7;
            color: #993C1D;
        }

        .c-revenue .nm-stat-icon {
            background: #F5ECD0;
            color: #854F0B;
        }

        .c-users .nm-stat-icon {
            background: #EEEDFE;
            color: #534AB7;
        }

        .nm-stat-label {
            font-size: 12px;
            color: #999;
            font-family: sans-serif;
            font-weight: 500;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            margin-bottom: 6px;
        }

        .nm-stat-value {
            font-size: 30px;
            font-weight: 700;
            color: #1A1A1A;
            line-height: 1;
            font-family: sans-serif;
        }

        .nm-stat-trend {
            font-size: 12px;
            font-family: sans-serif;
            margin-top: 8px;
            color: #aaa;
        }

        .nm-stat-trend .up {
            color: #1D9E75;
            font-weight: 600;
        }

        .nm-stat-trend .down {
            color: #D85A30;
            font-weight: 600;
        }

        /* ── Bottom Grid: Activity + Quick Access ────── */
        .nm-bottom-grid {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 20px;
            align-items: start;
        }

        /* ── Quick Access Panel ──────────────────────── */
        .nm-panel {
            background: #F5F4F0;
            border-radius: 14px;
            border: 1px solid rgba(0, 0, 0, 0.06);
            overflow: hidden;
        }

        .nm-panel-header {
            padding: 18px 22px 14px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.06);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .nm-panel-title {
            font-size: 14px;
            font-weight: 700;
            color: #1A1A1A;
            font-family: sans-serif;
            margin: 0;
        }

        .nm-panel-badge {
            font-size: 11px;
            background: #F5ECD0;
            color: #854F0B;
            padding: 3px 9px;
            border-radius: 20px;
            font-family: sans-serif;
            font-weight: 600;
        }

        /* Quick Access Links */
        .nm-quick-links {
            padding: 8px 10px;
        }

        .nm-quick-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 12px;
            border-radius: 9px;
            text-decoration: none !important;
            color: #1A1A1A !important;
            transition: background 0.15s;
            font-family: sans-serif;
        }

        .nm-quick-link:hover {
            background: #F5F4F0;
            text-decoration: none !important;
        }

        .nm-quick-link-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            flex-shrink: 0;
        }

        .nm-quick-link-text {
            font-size: 13px;
            font-weight: 500;
            flex: 1;
        }

        .nm-quick-link-arrow {
            color: #ccc;
            font-size: 13px;
        }

        /* ── Activity Feed ───────────────────────────── */
        .nm-activity-list {
            padding: 0;
        }

        .nm-activity-item {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            padding: 16px 22px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.04);
            font-family: sans-serif;
        }

        .nm-activity-item:last-child {
            border-bottom: none;
        }

        .nm-activity-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            margin-top: 5px;
            flex-shrink: 0;
        }

        .nm-activity-body {
            flex: 1;
        }

        .nm-activity-text {
            font-size: 13px;
            color: #333;
            line-height: 1.5;
            margin: 0;
        }

        .nm-activity-text strong {
            color: #1A1A1A;
        }

        .nm-activity-time {
            font-size: 11px;
            color: #bbb;
            margin-top: 3px;
            display: block;
        }

        /* ── Revenue Chart ───────────────────────────── */
        .nm-chart-wrap {
            background: #F5F4F0;
            border-radius: 14px;
            border: 1px solid rgba(0, 0, 0, 0.06);
            padding: 22px 24px;
            margin-bottom: 20px;
        }

        .nm-chart-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .nm-chart-title {
            font-size: 14px;
            font-weight: 700;
            color: #1A1A1A;
            font-family: sans-serif;
            margin: 0;
        }

        .nm-chart-subtitle {
            font-size: 12px;
            color: #aaa;
            font-family: sans-serif;
            margin-top: 2px;
        }

        .nm-chart-tabs {
            display: flex;
            gap: 4px;
        }

        .nm-tab {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-family: sans-serif;
            font-weight: 500;
            cursor: pointer;
            border: none;
            background: transparent;
            color: #999;
            transition: all 0.15s;
        }

        .nm-tab.active {
            background: var(--nm-dark);
            color: #fff;
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .nm-stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 900px) {
            .nm-bottom-grid {
                grid-template-columns: 1fr;
            }

            .nm-dashboard {
                padding: 20px 16px 40px;
            }

            .nm-hero {
                padding: 24px 22px;
                flex-direction: column;
                align-items: flex-start;
                gap: 20px;
            }
        }
    </style>

    <div class="page-content">
        <div class="container-fluid">
            {{-- Breadcrumb --}}
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Dashboard</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Nicole Murray</a></li>
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="nm-dashboard">

                {{-- ── Hero Banner ─────────────────────────── --}}
                <div class="nm-hero">
                    <div class="nm-hero-accent"></div>
                    <div class="nm-hero-accent2"></div>
                    <div class="nm-hero-left">
                        <p class="nm-hero-eyebrow">Nicole Murray Admin</p>
                        <h1 class="nm-hero-title">Welcome back, {{ Auth::guard('admin')->user()->name ?? 'Admin' }}</h1>
                        <p class="nm-hero-sub">Here's what's happening with your store today.</p>
                    </div>
                    <div class="nm-hero-right">
                        <div class="nm-hero-date">
                            <span class="day">{{ now()->format('l') }}</span>
                            <span class="full">{{ now()->format('d M Y') }}</span>
                        </div>
                        <a href="{{ route('index') }}" target="_blank" class="nm-visit-btn">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10" />
                                <line x1="2" y1="12" x2="22" y2="12" />
                                <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z" />
                            </svg>
                            Visit Frontend
                        </a>
                    </div>
                </div>

                {{-- ── Stats ────────────────────────────────── --}}
                <p class="nm-section-label">Store Overview</p>
                <div class="nm-stats-grid">

                    <a href="{{ route('backend.products.list') }}" class="nm-stat-card c-products">
                        <div class="nm-stat-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" />
                            </svg>
                        </div>
                        <div class="nm-stat-label">Total Products</div>
                        <div class="nm-stat-value">{{ $productCount ?? 0 }}</div>
                        <div class="nm-stat-trend">Active listings in store</div>
                    </a>

                    <a href="{{ route('backend.contact_form.list') }}" class="nm-stat-card c-contacts">
                        <div class="nm-stat-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                                <polyline points="22,6 12,13 2,6" />
                            </svg>
                        </div>
                        <div class="nm-stat-label">Contact Forms</div>
                        <div class="nm-stat-value">{{ $contactCount ?? 0 }}</div>
                        <div class="nm-stat-trend">Unread inquiries</div>
                    </a>

                </div>

                {{-- ── Bottom Grid ──────────────────────────── --}}
                <div class="nm-bottom-grid">

                    {{-- Left: Activity --}}
                    <div>
                        {{-- Recent Activity --}}
                        <div class="nm-panel">
                            <div class="nm-panel-header">
                                <p class="nm-panel-title">Recent Activity</p>
                                <span class="nm-panel-badge">Live</span>
                            </div>
                            <div class="nm-activity-list">
                                <div class="nm-activity-item">
                                    <div class="nm-activity-dot" style="background:#378ADD"></div>
                                    <div class="nm-activity-body">
                                        <p class="nm-activity-text"><strong>{{ $productCount ?? 0 }} products</strong> currently listed on the store</p>
                                        <span class="nm-activity-time">Store status</span>
                                    </div>
                                </div>
                                <div class="nm-activity-item">
                                    <div class="nm-activity-dot" style="background:#EF9F27"></div>
                                    <div class="nm-activity-body">
                                        <p class="nm-activity-text"><strong>{{ $blogCount ?? 0 }} blog posts</strong> published and live</p>
                                        <span class="nm-activity-time">Content status</span>
                                    </div>
                                </div>
                                <div class="nm-activity-item">
                                    <div class="nm-activity-dot" style="background:#D85A30"></div>
                                    <div class="nm-activity-body">
                                        <p class="nm-activity-text"><strong>{{ $contactCount ?? 0 }} contact submissions</strong> awaiting response</p>
                                        <span class="nm-activity-time">Needs attention</span>
                                    </div>
                                </div>
                                <div class="nm-activity-item">
                                    <div class="nm-activity-dot" style="background:#B8860B"></div>
                                    <div class="nm-activity-body">
                                        <p class="nm-activity-text">Admin panel last accessed by <strong>{{ Auth::guard('admin')->user()->name ?? 'Admin' }}</strong></p>
                                        <span class="nm-activity-time">{{ now()->format('d M, H:i') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Right: Quick Access --}}
                    <div>
                        <div class="nm-panel">
                            <div class="nm-panel-header">
                                <p class="nm-panel-title">Quick Access</p>
                            </div>
                            <div class="nm-quick-links">

                                <a href="{{ route('backend.products.add') }}" class="nm-quick-link">
                                    <div class="nm-quick-link-icon" style="background:#E6F1FB; color:#185FA5;">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                            <line x1="12" y1="5" x2="12" y2="19" />
                                            <line x1="5" y1="12" x2="19" y2="12" />
                                        </svg>
                                    </div>
                                    <span class="nm-quick-link-text">Add New Product</span>
                                    <span class="nm-quick-link-arrow">›</span>
                                </a>

                                <a href="{{ route('backend.customers.list') }}" class="nm-quick-link">
                                    <div class="nm-quick-link-icon" style="background:#EEF2FF; color:#4F46E5;">
                                        <i class="bx bxs-group" style="font-size:15px;"></i>
                                    </div>
                                    <span class="nm-quick-link-text">View Customers</span>
                                    <span class="nm-quick-link-arrow">›</span>
                                </a>

                                <a href="{{ route('backend.newsletter.list') }}" class="nm-quick-link">
                                    <div class="nm-quick-link-icon" style="background:#EEEDFE; color:#534AB7;">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                                        </svg>
                                    </div>
                                    <span class="nm-quick-link-text">Newsletter</span>
                                    <span class="nm-quick-link-arrow">›</span>
                                </a>

                                <a href="{{ route('backend.categories.list') }}" class="nm-quick-link">
                                    <div class="nm-quick-link-icon" style="background:#FAECE7; color:#993C1D;">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                            <rect x="3" y="3" width="7" height="7" />
                                            <rect x="14" y="3" width="7" height="7" />
                                            <rect x="14" y="14" width="7" height="7" />
                                            <rect x="3" y="14" width="7" height="7" />
                                        </svg>
                                    </div>
                                    <span class="nm-quick-link-text">Manage Categories</span>
                                    <span class="nm-quick-link-arrow">›</span>
                                </a>

                                <a href="{{ route('backend.site_settings') }}" class="nm-quick-link">
                                    <div class="nm-quick-link-icon" style="background:#F1EFE8; color:#5F5E5A;">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="12" cy="12" r="3" />
                                            <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 1 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 1 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 1 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 1 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z" />
                                        </svg>
                                    </div>
                                    <span class="nm-quick-link-text">Site Settings</span>
                                    <span class="nm-quick-link-arrow">›</span>
                                </a>

                                <a href="{{ url('/analytics') }}" target="_blank" class="nm-quick-link">
                                    <div class="nm-quick-link-icon" style="background:#E1F5EE; color:#0F6E56;">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                            <line x1="18" y1="20" x2="18" y2="10" />
                                            <line x1="12" y1="20" x2="12" y2="4" />
                                            <line x1="6" y1="20" x2="6" y2="14" />
                                        </svg>
                                    </div>
                                    <span class="nm-quick-link-text">Analytics</span>
                                    <span class="nm-quick-link-arrow" style="font-size:10px;">↗</span>
                                </a>

                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

@endsection