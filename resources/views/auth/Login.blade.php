<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MediCore &mdash; Secure Access</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;1,400;1,500&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'display': ['Playfair Display', 'Georgia', 'serif'],
                        'body': ['Outfit', 'system-ui', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --blue-deep: #0F2D6B;
            --blue-mid:  #1A4DB8;
            --blue-vivid:#2563EB;
            --blue-light:#DBEAFE;
            --blue-pale: #EFF6FF;
            --white:     #FFFFFF;
            --slate-800: #1E293B;
            --slate-600: #475569;
            --slate-400: #94A3B8;
            --slate-200: #E2E8F0;
            --emerald:   #10B981;
            --red-soft:  #FEF2F2;
            --red-border:#FECACA;
            --red-text:  #B91C1C;
        }

        html, body {
            min-height: 100vh;
            font-family: 'Outfit', system-ui, sans-serif;
            background: #EBF4FF;
            overflow-x: hidden;
        }

        /* ═══════════════════════════════════════
           ANIMATED MESH BACKGROUND
        ═══════════════════════════════════════ */
        .bg-mesh {
            position: fixed;
            inset: 0;
            z-index: 0;
            overflow: hidden;
            pointer-events: none;
        }

        /* SVG grid lines */
        .bg-mesh svg {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            opacity: 0.07;
        }

        /* Gradient orbs */
        .orb {
            position: absolute;
            border-radius: 9999px;
            filter: blur(90px);
            pointer-events: none;
        }

        .orb-1 {
            width: 700px; height: 700px;
            background: radial-gradient(circle, rgba(59,130,246,0.4) 0%, transparent 65%);
            top: -200px; left: -180px;
            animation: orb-drift-1 18s ease-in-out infinite;
        }
        .orb-2 {
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(147,197,253,0.35) 0%, transparent 65%);
            bottom: -120px; right: -100px;
            animation: orb-drift-2 22s ease-in-out infinite;
        }
        .orb-3 {
            width: 300px; height: 300px;
            background: radial-gradient(circle, rgba(96,165,250,0.25) 0%, transparent 65%);
            top: 45%; left: 55%;
            animation: orb-drift-3 14s ease-in-out infinite;
        }
        .orb-4 {
            width: 200px; height: 200px;
            background: radial-gradient(circle, rgba(16,185,129,0.15) 0%, transparent 65%);
            top: 20%; right: 20%;
            animation: orb-drift-1 20s ease-in-out infinite reverse;
        }

        @keyframes orb-drift-1 {
            0%,100% { transform: translate(0, 0) scale(1); }
            33%      { transform: translate(40px, 30px) scale(1.05); }
            66%      { transform: translate(-20px, 50px) scale(0.97); }
        }
        @keyframes orb-drift-2 {
            0%,100% { transform: translate(0, 0) scale(1); }
            40%      { transform: translate(-50px, -30px) scale(1.08); }
            70%      { transform: translate(30px, -20px) scale(0.95); }
        }
        @keyframes orb-drift-3 {
            0%,100% { transform: translate(0, 0); }
            50%      { transform: translate(-40px, 30px); }
        }

        /* Floating particles */
        .particle {
            position: absolute;
            border-radius: 50%;
            background: rgba(37,99,235,0.25);
            animation: particle-float linear infinite;
        }

        @keyframes particle-float {
            0%   { transform: translateY(100vh) scale(0); opacity: 0; }
            10%  { opacity: 1; }
            90%  { opacity: 0.6; }
            100% { transform: translateY(-100px) scale(1); opacity: 0; }
        }

        /* ═══════════════════════════════════════
           MAIN LAYOUT
        ═══════════════════════════════════════ */
        .page-wrapper {
            position: relative;
            z-index: 10;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }

        .card-shell {
            width: 100%;
            max-width: 1020px;
            display: flex;
            border-radius: 28px;
            overflow: hidden;
            box-shadow:
                0 0 0 1px rgba(255,255,255,0.6),
                0 32px 80px rgba(15,45,107,0.22),
                0 8px 24px rgba(15,45,107,0.1);
            animation: card-enter 0.8s cubic-bezier(0.22, 1, 0.36, 1) both;
        }

        @keyframes card-enter {
            0% { opacity: 0; transform: translateY(40px) scale(0.97); }
            100% { opacity: 1; transform: translateY(0) scale(1); }
        }

        /* ═══════════════════════════════════════
           LEFT PANEL
        ═══════════════════════════════════════ */
        .left-panel {
            display: none;
            flex-direction: column;
            justify-content: space-between;
            width: 42%;
            padding: 52px 44px;
            background: linear-gradient(145deg, #0F2D6B 0%, #1A4DB8 50%, #1D4ED8 100%);
            position: relative;
            overflow: hidden;
        }

        @media (min-width: 1024px) {
            .left-panel { display: flex; }
        }

        /* Animated mesh overlay on left panel */
        .left-panel-mesh {
            position: absolute;
            inset: 0;
            opacity: 0.08;
            background-image:
                linear-gradient(rgba(255,255,255,0.8) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.8) 1px, transparent 1px);
            background-size: 40px 40px;
            animation: mesh-scroll 30s linear infinite;
        }

        @keyframes mesh-scroll {
            0% { transform: translate(0, 0); }
            100% { transform: translate(40px, 40px); }
        }

        /* Decorative circles on left */
        .left-deco-circle {
            position: absolute;
            border-radius: 50%;
            border: 1px solid rgba(255,255,255,0.12);
            pointer-events: none;
        }
        .ldc-1 { width: 260px; height: 260px; top: -80px; right: -80px; animation: rotate-slow 40s linear infinite; }
        .ldc-2 { width: 180px; height: 180px; top: -30px; right: -30px; animation: rotate-slow 30s linear infinite reverse; }
        .ldc-3 { width: 320px; height: 320px; bottom: -100px; left: -100px; animation: rotate-slow 50s linear infinite; }

        @keyframes rotate-slow {
            from { transform: rotate(0deg); }
            to   { transform: rotate(360deg); }
        }

        /* Medical cross icon */
        .med-icon {
            width: 48px; height: 48px;
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.25);
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            position: relative;
            backdrop-filter: blur(8px);
            animation: icon-pulse 4s ease-in-out infinite;
        }
        .med-icon::before, .med-icon::after {
            content: '';
            position: absolute;
            background: rgba(255,255,255,0.9);
            border-radius: 2px;
        }
        .med-icon::before { width: 4px; height: 22px; }
        .med-icon::after  { width: 22px; height: 4px; }

        @keyframes icon-pulse {
            0%,100% { box-shadow: 0 0 0 0 rgba(255,255,255,0.2); }
            50%      { box-shadow: 0 0 0 8px rgba(255,255,255,0); }
        }

        /* Left panel heading */
        .left-heading {
            font-family: 'Playfair Display', serif;
            font-size: 2.4rem;
            font-weight: 400;
            color: #fff;
            line-height: 1.25;
            margin-top: 2rem;
        }
        .left-heading em {
            font-style: italic;
            color: rgba(186,230,253,0.95);
        }

        .left-sub {
            font-family: 'Outfit', sans-serif;
            font-size: 0.87rem;
            color: rgba(186,230,253,0.85);
            line-height: 1.7;
            font-weight: 300;
            margin-top: 1rem;
            max-width: 260px;
        }

        /* Stat cards */
        .stat-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-top: 28px;
        }

        .stat-card {
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.14);
            border-radius: 16px;
            padding: 16px;
            backdrop-filter: blur(4px);
            position: relative;
            overflow: hidden;
            transition: background 0.3s ease;
        }
        .stat-card:hover { background: rgba(255,255,255,0.13); }
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
            animation: shimmer-line 3s ease-in-out infinite;
        }
        .stat-card:last-child::before { animation-delay: 1.5s; }

        @keyframes shimmer-line {
            0%   { transform: translateX(-100%); opacity: 0; }
            50%  { opacity: 1; }
            100% { transform: translateX(100%); opacity: 0; }
        }

        .stat-value {
            font-family: 'Playfair Display', serif;
            font-size: 1.6rem;
            font-weight: 600;
            color: #fff;
            line-height: 1;
        }
        .stat-label {
            font-size: 0.72rem;
            color: rgba(186,230,253,0.75);
            margin-top: 6px;
            letter-spacing: 0.03em;
            text-transform: uppercase;
        }

        /* Status badge */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 999px;
            padding: 7px 14px;
            font-size: 0.78rem;
            color: rgba(255,255,255,0.88);
            margin-bottom: 20px;
            backdrop-filter: blur(6px);
        }
        .status-dot {
            width: 7px; height: 7px;
            border-radius: 50%;
            background: #10B981;
            box-shadow: 0 0 0 0 rgba(16,185,129,0.5);
            animation: ping-dot 2s ease-in-out infinite;
        }
        @keyframes ping-dot {
            0%,100% { box-shadow: 0 0 0 0 rgba(16,185,129,0.5); }
            50%      { box-shadow: 0 0 0 5px rgba(16,185,129,0); }
        }

        /* Version text */
        .left-footer { font-size: 0.72rem; color: rgba(147,197,253,0.5); }

        /* ═══════════════════════════════════════
           RIGHT PANEL
        ═══════════════════════════════════════ */
        .right-panel {
            flex: 1;
            background: rgba(255,255,255,0.92);
            backdrop-filter: blur(30px) saturate(180%);
            -webkit-backdrop-filter: blur(30px) saturate(180%);
            padding: 52px 48px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            border-left: 1px solid rgba(255,255,255,0.7);
            position: relative;
            overflow: hidden;
        }

        /* Subtle top-right glow on right panel */
        .right-panel::before {
            content: '';
            position: absolute;
            top: -60px; right: -60px;
            width: 240px; height: 240px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(219,234,254,0.7) 0%, transparent 60%);
            pointer-events: none;
        }

        /* ═══════════════════════════════════════
           FORM HEADER
        ═══════════════════════════════════════ */
        .form-eyebrow {
            font-size: 0.72rem;
            font-weight: 500;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--blue-vivid);
            margin-bottom: 10px;
            opacity: 0;
            animation: rise-in 0.6s 0.2s cubic-bezier(0.22,1,0.36,1) forwards;
        }

        .form-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.6rem;
            font-weight: 400;
            color: var(--slate-800);
            line-height: 1.15;
            margin-bottom: 32px;
            opacity: 0;
            animation: rise-in 0.6s 0.35s cubic-bezier(0.22,1,0.36,1) forwards;
        }
        .form-title span {
            font-style: italic;
            color: var(--blue-vivid);
        }

        @keyframes rise-in {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        /* ═══════════════════════════════════════
           ERROR ALERT
        ═══════════════════════════════════════ */
        .alert-box {
            background: var(--red-soft);
            border: 1px solid var(--red-border);
            border-radius: 12px;
            padding: 12px 16px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 24px;
            font-size: 0.84rem;
            color: var(--red-text);
            animation: shake 0.5s cubic-bezier(0.36,0.07,0.19,0.97) both;
        }

        @keyframes shake {
            0%,100% { transform: translateX(0); }
            15%      { transform: translateX(-6px); }
            30%      { transform: translateX(6px); }
            45%      { transform: translateX(-4px); }
            60%      { transform: translateX(4px); }
            75%      { transform: translateX(-2px); }
        }

        /* ═══════════════════════════════════════
           INPUT FIELDS
        ═══════════════════════════════════════ */
        .field-group {
            margin-bottom: 20px;
            opacity: 0;
        }
        .field-group.delay-1 { animation: rise-in 0.6s 0.5s cubic-bezier(0.22,1,0.36,1) forwards; }
        .field-group.delay-2 { animation: rise-in 0.6s 0.62s cubic-bezier(0.22,1,0.36,1) forwards; }

        .field-label {
            display: block;
            font-size: 0.72rem;
            font-weight: 500;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--slate-600);
            margin-bottom: 8px;
        }

        .input-wrap {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--slate-400);
            pointer-events: none;
            transition: color 0.25s ease;
        }

        .field-input {
            width: 100%;
            padding: 14px 16px 14px 46px;
            font-family: 'Outfit', sans-serif;
            font-size: 0.9rem;
            font-weight: 400;
            color: var(--slate-800);
            background: rgba(248,250,252,0.8);
            border: 1.5px solid var(--slate-200);
            border-radius: 14px;
            outline: none;
            transition:
                border-color 0.3s ease,
                background 0.3s ease,
                box-shadow 0.3s ease,
                transform 0.2s ease;
        }
        .field-input::placeholder { color: var(--slate-400); font-weight: 300; }

        .field-input:hover {
            border-color: #BFDBFE;
            background: rgba(239,246,255,0.7);
        }

        .field-input:focus {
            border-color: var(--blue-vivid);
            background: #fff;
            box-shadow:
                0 0 0 4px rgba(37,99,235,0.1),
                0 2px 12px rgba(37,99,235,0.08);
            transform: translateY(-1px);
        }

        .input-wrap:focus-within .input-icon {
            color: var(--blue-vivid);
        }

        /* Animated underline on focus */
        .input-underline {
            position: absolute;
            bottom: 0; left: 20%; right: 20%;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--blue-vivid), transparent);
            border-radius: 2px;
            opacity: 0;
            transition: opacity 0.3s ease, left 0.3s ease, right 0.3s ease;
        }
        .input-wrap:focus-within .input-underline {
            opacity: 1;
            left: 10%; right: 10%;
        }

        .pw-toggle {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--slate-400);
            cursor: pointer;
            padding: 4px;
            transition: color 0.2s ease;
            display: flex; align-items: center;
        }
        .pw-toggle:hover { color: var(--blue-vivid); }

        /* ═══════════════════════════════════════
           REMEMBER / FORGOT
        ═══════════════════════════════════════ */
        .form-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 28px;
            opacity: 0;
            animation: rise-in 0.6s 0.75s cubic-bezier(0.22,1,0.36,1) forwards;
        }

        .check-label {
            display: flex;
            align-items: center;
            gap: 9px;
            cursor: pointer;
            font-size: 0.84rem;
            color: var(--slate-600);
        }
        .check-label input[type="checkbox"] {
            width: 16px; height: 16px;
            accent-color: var(--blue-vivid);
            cursor: pointer;
        }

        .forgot-link {
            font-size: 0.84rem;
            font-weight: 500;
            color: var(--blue-vivid);
            text-decoration: none;
            position: relative;
        }
        .forgot-link::after {
            content: '';
            position: absolute;
            left: 0; bottom: -1px; right: 100%;
            height: 1px;
            background: var(--blue-vivid);
            transition: right 0.25s ease;
        }
        .forgot-link:hover::after { right: 0; }

        /* ═══════════════════════════════════════
           SUBMIT BUTTON
        ═══════════════════════════════════════ */
        .btn-wrap {
            opacity: 0;
            animation: rise-in 0.6s 0.88s cubic-bezier(0.22,1,0.36,1) forwards;
        }

        .btn-submit {
            width: 100%;
            padding: 15px 24px;
            font-family: 'Outfit', sans-serif;
            font-size: 0.9rem;
            font-weight: 500;
            letter-spacing: 0.04em;
            color: #fff;
            background: linear-gradient(130deg, #1A4DB8 0%, #2563EB 50%, #1D4ED8 100%);
            background-size: 200% 100%;
            border: none;
            border-radius: 14px;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition:
                transform 0.25s cubic-bezier(0.22,1,0.36,1),
                box-shadow 0.3s ease,
                background-position 0.4s ease;
            box-shadow: 0 5px 20px rgba(37,99,235,0.38), 0 1px 4px rgba(37,99,235,0.2);
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 32px rgba(37,99,235,0.46), 0 2px 8px rgba(37,99,235,0.25);
            background-position: 100% 0;
        }

        .btn-submit:active {
            transform: translateY(0);
            box-shadow: 0 3px 10px rgba(37,99,235,0.3);
        }

        /* Ripple on click */
        .btn-submit .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255,255,255,0.35);
            transform: scale(0);
            animation: ripple-expand 0.6s linear;
            pointer-events: none;
        }
        @keyframes ripple-expand {
            to { transform: scale(4); opacity: 0; }
        }

        /* Shine sweep */
        .btn-submit::after {
            content: '';
            position: absolute;
            top: 0; left: -100%;
            width: 60%;
            height: 100%;
            background: linear-gradient(105deg, transparent 40%, rgba(255,255,255,0.18) 50%, transparent 60%);
            animation: shine-sweep 3.5s ease-in-out infinite;
        }
        @keyframes shine-sweep {
            0%   { left: -100%; opacity: 0; }
            20%  { opacity: 1; }
            60%  { left: 140%; opacity: 1; }
            61%,100% { opacity: 0; }
        }

        .btn-inner {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        /* ═══════════════════════════════════════
           FOOTER BADGES
        ═══════════════════════════════════════ */
        .form-footer {
            margin-top: 32px;
            opacity: 0;
            animation: rise-in 0.6s 1.05s cubic-bezier(0.22,1,0.36,1) forwards;
        }

        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
        }
        .divider-line { flex: 1; height: 1px; background: var(--slate-200); }
        .divider-text {
            font-size: 0.68rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--slate-400);
            white-space: nowrap;
        }

        .badge-row {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }
        .badge-item {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.75rem;
            color: var(--slate-400);
        }

        /* ═══════════════════════════════════════
           LOADING STATE
        ═══════════════════════════════════════ */
        @keyframes spin { to { transform: rotate(360deg); } }
        .spinner { animation: spin 0.8s linear infinite; display: inline-block; }

        /* ═══════════════════════════════════════
           MOBILE LOGO
        ═══════════════════════════════════════ */
        .mobile-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 28px;
        }
        @media (min-width: 1024px) { .mobile-logo { display: none; } }

        .mobile-logo-icon {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, var(--blue-mid), var(--blue-vivid));
            border-radius: 10px;
            position: relative;
            display: flex; align-items: center; justify-content: center;
        }
        .mobile-logo-icon::before, .mobile-logo-icon::after {
            content: '';
            position: absolute;
            background: #fff;
            border-radius: 1.5px;
        }
        .mobile-logo-icon::before { width: 3px; height: 16px; }
        .mobile-logo-icon::after  { width: 16px; height: 3px; }

        /* ═══════════════════════════════════════
           LEFT PANEL ENTRANCE ANIMATIONS
        ═══════════════════════════════════════ */
        .lp-top    { opacity: 0; animation: slide-right 0.7s 0.2s cubic-bezier(0.22,1,0.36,1) forwards; }
        .lp-middle { opacity: 0; animation: slide-right 0.7s 0.4s cubic-bezier(0.22,1,0.36,1) forwards; }
        .lp-bottom { opacity: 0; animation: slide-right 0.7s 0.6s cubic-bezier(0.22,1,0.36,1) forwards; }

        @keyframes slide-right {
            0%   { opacity: 0; transform: translateX(-28px); }
            100% { opacity: 1; transform: translateX(0); }
        }

        /* ═══════════════════════════════════════
           RESPONSIVE
        ═══════════════════════════════════════ */
        @media (max-width: 768px) {
            .right-panel { padding: 36px 28px; }
            .form-title  { font-size: 2rem; }
        }
    </style>
</head>

<body>

    <!-- ══ ANIMATED BACKGROUND ══ -->
    <div class="bg-mesh" aria-hidden="true">
        <svg xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="grid" width="56" height="56" patternUnits="userSpaceOnUse">
                    <path d="M 56 0 L 0 0 0 56" fill="none" stroke="#1A4DB8" stroke-width="1"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#grid)"/>
        </svg>
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>
        <div class="orb orb-4"></div>

        <!-- Floating particles -->
        <div class="particle" style="width:6px;height:6px;left:10%;animation-duration:12s;animation-delay:0s;"></div>
        <div class="particle" style="width:4px;height:4px;left:22%;animation-duration:17s;animation-delay:2s;"></div>
        <div class="particle" style="width:8px;height:8px;left:40%;animation-duration:14s;animation-delay:5s;"></div>
        <div class="particle" style="width:4px;height:4px;left:65%;animation-duration:19s;animation-delay:1s;"></div>
        <div class="particle" style="width:6px;height:6px;left:80%;animation-duration:15s;animation-delay:7s;"></div>
        <div class="particle" style="width:3px;height:3px;left:90%;animation-duration:22s;animation-delay:3s;"></div>
        <div class="particle" style="width:5px;height:5px;left:55%;animation-duration:16s;animation-delay:9s;"></div>
    </div>

    <!-- ══ PAGE WRAPPER ══ -->
    <div class="page-wrapper">
        <div class="card-shell">

            <!-- ══ LEFT PANEL ══ -->
            <div class="left-panel">
                <div class="left-panel-mesh"></div>
                <div class="left-deco-circle ldc-1"></div>
                <div class="left-deco-circle ldc-2"></div>
                <div class="left-deco-circle ldc-3"></div>

                <!-- Top: Logo + Heading -->
                <div class="lp-top" style="position:relative;z-index:2;">
                    <div style="display:flex;align-items:center;gap:14px;margin-bottom:36px;">
                        <div class="med-icon"></div>
                        <div>
                            <div style="font-family:'Playfair Display',serif;font-size:1.4rem;font-weight:500;color:#fff;letter-spacing:0.02em;">MediCore</div>
                            <div style="font-size:0.68rem;color:rgba(186,230,253,0.7);letter-spacing:0.18em;text-transform:uppercase;margin-top:2px;">Hospital System</div>
                        </div>
                    </div>

                    <h2 class="left-heading">
                        Trusted Care,<br>
                        <em>Seamlessly</em><br>
                        Delivered.
                    </h2>
                    <p class="left-sub">
                        Secure, integrated hospital management at your fingertips. Access patient records, scheduling, and analytics — all in one place.
                    </p>
                </div>

                <!-- Middle: Stats -->
                <div class="lp-middle" style="position:relative;z-index:2;">
                    <div class="status-badge">
                        <div class="status-dot"></div>
                        All systems operational
                    </div>
                    <div class="stat-grid">
                        <div class="stat-card">
                            <div class="stat-value">2,400+</div>
                            <div class="stat-label">Active Patients</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-value">98.7%</div>
                            <div class="stat-label">Uptime SLA</div>
                        </div>
                    </div>
                </div>

                <!-- Bottom: Version -->
                <div class="lp-bottom left-footer" style="position:relative;z-index:2;">
                    MediCore HMS &bull; v3.2.1 &bull; &copy; {{ date('Y') }}
                </div>
            </div>
            <!-- /LEFT PANEL -->

            <!-- ══ RIGHT PANEL ══ -->
            <div class="right-panel">

                <!-- Mobile Logo -->
                <div class="mobile-logo">
                    <div class="mobile-logo-icon"></div>
                    <span style="font-family:'Playfair Display',serif;font-size:1.2rem;font-weight:500;color:var(--blue-deep);">MediCore</span>
                </div>

                <!-- Header -->
                <p class="form-eyebrow">Welcome back</p>
                <h1 class="form-title">
                    Sign in to your<br>
                    <span>workspace</span>
                </h1>

                <!-- Error alerts -->
                @if ($errors->any())
                <div class="alert-box">
                    <svg class="flex-shrink-0" style="width:16px;height:16px;color:#DC2626;margin-top:1px;" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <div>
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
                @endif

                @if (session('error'))
                <div class="alert-box">
                    <svg class="flex-shrink-0" style="width:16px;height:16px;color:#DC2626;margin-top:1px;" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <p>{{ session('error') }}</p>
                </div>
                @endif

                <!-- Form -->
                <form method="POST" action="{{ route('login') }}" id="loginForm" novalidate>
                    @csrf

                    <!-- Email -->
                    <div class="field-group delay-1">
                        <label class="field-label" for="email">Email Address</label>
                        <div class="input-wrap">
                            <span class="input-icon" aria-hidden="true">
                                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                                </svg>
                            </span>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                class="field-input"
                                placeholder="admin@hospital.com"
                                value="{{ old('email') }}"
                                autocomplete="email"
                                required
                                autofocus
                            >
                            <div class="input-underline"></div>
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="field-group delay-2">
                        <label class="field-label" for="password">Password</label>
                        <div class="input-wrap">
                            <span class="input-icon" aria-hidden="true">
                                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </span>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="field-input"
                                placeholder="••••••••••••"
                                autocomplete="current-password"
                                required
                            >
                            <div class="input-underline"></div>
                            <button type="button" class="pw-toggle" id="pwToggle" aria-label="Toggle password visibility">
                                <svg id="eyeIcon" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Remember + Forgot -->
                    <div class="form-options">
                        <label class="check-label">
                            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <span>Remember me</span>
                        </label>
                        @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-link">Forgot password?</a>
                        @endif
                    </div>

                    <!-- Submit -->
                    <div class="btn-wrap">
                        <button type="submit" class="btn-submit" id="loginBtn">
                            <span class="btn-inner" id="btnInner">
                                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                                </svg>
                                Sign In Securely
                            </span>
                        </button>
                    </div>
                </form>

                <!-- Footer -->
                <div class="form-footer">
                    <div class="divider">
                        <div class="divider-line"></div>
                        <span class="divider-text">Secured by</span>
                        <div class="divider-line"></div>
                    </div>
                    <div class="badge-row">
                        <div class="badge-item">
                            <svg width="13" height="13" fill="none" viewBox="0 0 20 20" style="color:#10B981;">
                                <path fill="currentColor" fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            256-bit SSL
                        </div>
                        <div style="width:3px;height:3px;border-radius:50%;background:var(--slate-300);"></div>
                        <div class="badge-item">
                            <svg width="13" height="13" fill="none" viewBox="0 0 20 20" style="color:#2563EB;">
                                <path fill="currentColor" fill-rule="evenodd" d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" clip-rule="evenodd"/>
                                <path fill="currentColor" fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                            </svg>
                            HIPAA Compliant
                        </div>
                        <div style="width:3px;height:3px;border-radius:50%;background:var(--slate-300);"></div>
                        <div class="badge-item">
                            <svg width="13" height="13" fill="none" viewBox="0 0 20 20" style="color:#7C3AED;">
                                <path fill="currentColor" d="M10 2a5 5 0 00-5 5v2a2 2 0 00-2 2v5a2 2 0 002 2h10a2 2 0 002-2v-5a2 2 0 00-2-2H7V7a3 3 0 015.905-.75 1 1 0 001.937-.5A5.002 5.002 0 0010 2z"/>
                            </svg>
                            2FA Ready
                        </div>
                    </div>
                </div>

            </div>
            <!-- /RIGHT PANEL -->

        </div>
    </div>

    <script>
        /* ── Password toggle ── */
        document.getElementById('pwToggle').addEventListener('click', function () {
            const pw = document.getElementById('password');
            const icon = document.getElementById('eyeIcon');
            const isHidden = pw.type === 'password';
            pw.type = isHidden ? 'text' : 'password';
            icon.innerHTML = isHidden
                ? `<path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>`
                : `<path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                   <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>`;
        });

        /* ── Loading state ── */
        document.getElementById('loginForm').addEventListener('submit', function () {
            const btn  = document.getElementById('loginBtn');
            const inner = document.getElementById('btnInner');
            btn.disabled = true;
            btn.style.opacity = '0.85';
            inner.innerHTML = `
                <svg class="spinner" width="16" height="16" fill="none" viewBox="0 0 24 24">
                    <circle style="opacity:0.25;" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path style="opacity:0.75;" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                </svg>
                Authenticating…`;
        });

        /* ── Button ripple effect ── */
        document.getElementById('loginBtn').addEventListener('mousedown', function (e) {
            const btn = this;
            const circle = document.createElement('span');
            const diameter = Math.max(btn.clientWidth, btn.clientHeight);
            const radius = diameter / 2;
            const rect = btn.getBoundingClientRect();
            circle.classList.add('ripple');
            circle.style.cssText = `
                width: ${diameter}px;
                height: ${diameter}px;
                left: ${e.clientX - rect.left - radius}px;
                top: ${e.clientY - rect.top - radius}px;
            `;
            const existing = btn.querySelector('.ripple');
            if (existing) existing.remove();
            btn.appendChild(circle);
        });

        /* ── Parallax on orbs ── */
        document.addEventListener('mousemove', function (e) {
            const cx = window.innerWidth / 2, cy = window.innerHeight / 2;
            const dx = (e.clientX - cx) / cx, dy = (e.clientY - cy) / cy;
            document.querySelectorAll('.orb').forEach((orb, i) => {
                const f = (i + 1) * 12;
                orb.style.transform = `translate(${dx * f}px, ${dy * f}px)`;
            });
        });

        /* ── Input floating label lift on focus ── */
        document.querySelectorAll('.field-input').forEach(input => {
            input.addEventListener('focus', () => {
                input.closest('.field-group').querySelector('.field-label').style.color = '#2563EB';
            });
            input.addEventListener('blur', () => {
                input.closest('.field-group').querySelector('.field-label').style.color = '';
            });
        });
    </script>

</body>
</html>
