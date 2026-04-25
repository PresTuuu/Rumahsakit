<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard — MediCore Hospital System</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        :root {
            --blue-deep:    #0F2557;
            --blue-mid:     #1A3A8F;
            --blue-bright:  #2563EB;
            --blue-light:   #60A5FA;
            --blue-glow:    rgba(37,99,235,0.18);
            --accent:       #38BDF8;
            --accent-green: #10B981;
            --accent-amber: #F59E0B;
            --accent-red:   #EF4444;
            --accent-purple:#8B5CF6;
            --surface:      #F0F7FF;
            --card:         #FFFFFF;
            --text-main:    #0F2557;
            --text-muted:   #64748B;
            --border:       rgba(37,99,235,0.10);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Sora', sans-serif;
            background: var(--surface);
            color: var(--text-main);
            overflow-x: hidden;
        }

        /* ─── SIDEBAR ─────────────────────────────── */
        .sidebar {
            position: fixed;
            left: 0; top: 0;
            width: 260px; height: 100vh;
            background: linear-gradient(160deg, var(--blue-deep) 0%, var(--blue-mid) 100%);
            overflow-y: auto;
            z-index: 40;
            border-right: 1px solid rgba(255,255,255,0.06);
        }

        .sidebar::before {
            content: '';
            position: absolute;
            top: -80px; right: -80px;
            width: 220px; height: 220px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(96,165,250,0.25) 0%, transparent 70%);
            pointer-events: none;
        }

        .sidebar-logo {
            padding: 28px 20px 24px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }

        .logo-icon {
            width: 42px; height: 42px;
            background: linear-gradient(135deg, var(--accent) 0%, var(--blue-bright) 100%);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 22px;
            box-shadow: 0 0 20px rgba(56,189,248,0.35);
            animation: logoPulse 3s ease-in-out infinite;
        }

        @keyframes logoPulse {
            0%, 100% { box-shadow: 0 0 20px rgba(56,189,248,0.35); }
            50%       { box-shadow: 0 0 34px rgba(56,189,248,0.6); }
        }

        .logo-text { font-size: 18px; font-weight: 700; color: #fff; letter-spacing: -0.3px; }
        .logo-sub  { font-size: 11px; color: rgba(255,255,255,0.45); letter-spacing: 0.06em; margin-top: 2px; }

        nav { padding: 20px 12px; }

        .nav-section-label {
            font-size: 10px; font-weight: 600; letter-spacing: 0.12em;
            color: rgba(255,255,255,0.3); text-transform: uppercase;
            padding: 16px 10px 6px;
        }

        .sidebar-item {
            display: flex; align-items: center; gap: 12px;
            padding: 11px 14px;
            color: rgba(255,255,255,0.6);
            cursor: pointer;
            border-radius: 10px;
            margin-bottom: 2px;
            transition: all 0.22s ease;
            position: relative;
            overflow: hidden;
        }

        .sidebar-item::before {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(255,255,255,0);
            transition: background 0.22s ease;
            border-radius: 10px;
        }

        .sidebar-item:hover { color: #fff; }
        .sidebar-item:hover::before { background: rgba(255,255,255,0.07); }

        .sidebar-item.active {
            color: #fff;
            background: rgba(255,255,255,0.12);
            box-shadow: inset 0 0 0 1px rgba(255,255,255,0.1);
        }

        .sidebar-item.active .nav-dot {
            background: var(--accent);
            box-shadow: 0 0 8px var(--accent);
        }

        .nav-dot {
            width: 6px; height: 6px;
            border-radius: 50%;
            background: transparent;
            position: absolute; right: 14px;
            transition: all 0.22s;
        }

        .sidebar-item span { font-size: 14px; font-weight: 500; }

        /* ─── MAIN ────────────────────────────────── */
        .main-content { margin-left: 260px; min-height: 100vh; }

        /* ─── TOPBAR ──────────────────────────────── */
        .topbar {
            background: rgba(255,255,255,0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
            padding: 14px 28px;
            display: flex; justify-content: space-between; align-items: center;
            position: sticky; top: 0; z-index: 30;
        }

        .topbar-greeting h1 {
            font-size: 20px; font-weight: 700; color: var(--blue-deep);
            letter-spacing: -0.4px;
        }

        .topbar-greeting p { font-size: 13px; color: var(--text-muted); margin-top: 2px; }

        .topbar-right { display: flex; align-items: center; gap: 14px; }

        .notif-btn {
            width: 38px; height: 38px;
            border-radius: 10px;
            background: var(--surface);
            border: 1px solid var(--border);
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
            position: relative;
        }
        .notif-btn:hover { background: #EFF6FF; border-color: var(--blue-bright); }

        .notif-badge {
            position: absolute; top: 7px; right: 7px;
            width: 8px; height: 8px; border-radius: 50%;
            background: var(--accent-red);
            border: 2px solid #fff;
            animation: notifPing 2s ease-in-out infinite;
        }
        @keyframes notifPing {
            0%, 100% { transform: scale(1); opacity: 1; }
            50%       { transform: scale(1.3); opacity: 0.7; }
        }

        .user-pill {
            display: flex; align-items: center; gap: 10px;
            background: var(--surface);
            border: 1px solid var(--border);
            padding: 6px 14px 6px 6px;
            border-radius: 30px;
            cursor: pointer;
            transition: all 0.2s;
        }
        .user-pill:hover { border-color: var(--blue-bright); }

        .avatar {
            width: 30px; height: 30px; border-radius: 50%;
            background: linear-gradient(135deg, var(--blue-bright), var(--blue-deep));
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-weight: 700; font-size: 12px;
        }

        .user-pill-name { font-size: 13px; font-weight: 600; color: var(--blue-deep); }
        .user-pill-role { font-size: 11px; color: var(--text-muted); }

        /* ─── CONTENT BODY ────────────────────────── */
        .content-body { padding: 28px; }

        .card-panel {
            background: #fff;
            border: 1px solid rgba(15,37,87,0.08);
            border-radius: 18px;
            padding: 22px;
            box-shadow: 0 10px 30px rgba(15,37,87,0.05);
        }

        /* ─── MODAL ───────────────────────────────── */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(15,37,87,0.45);
            backdrop-filter: blur(2px);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 90;
        }

        .modal-window {
            width: min(820px, calc(100% - 40px));
            background: #fff;
            border-radius: 28px;
            box-shadow: 0 30px 70px rgba(15,37,87,0.25);
            padding: 28px;
            position: relative;
            max-height: calc(100vh - 64px);
            overflow-y: auto;
        }

        .modal-window h3 { font-size: 22px; margin-bottom: 8px; }

        .modal-close {
            position: absolute; top: 18px; right: 18px;
            width: 38px; height: 38px;
            border: none; border-radius: 12px;
            background: rgba(15,37,87,0.06);
            cursor: pointer; display: grid; place-items: center;
        }
        .modal-close:hover { background: rgba(15,37,87,0.1); }

        .modal-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px; margin-top: 18px;
        }
        .modal-grid.full-width { grid-column: 1 / -1; }

        .modal-field { display: flex; flex-direction: column; gap: 8px; }
        .modal-field label { font-size: 13px; font-weight: 600; color: var(--text-main); }

        .modal-field input,
        .modal-field select,
        .modal-field textarea {
            border: 1px solid rgba(15,37,87,0.12);
            border-radius: 12px; padding: 12px 14px;
            font-size: 14px; outline: none; width: 100%;
        }
        .modal-field textarea { min-height: 110px; resize: vertical; }

        .modal-actions { display: flex; justify-content: flex-end; gap: 12px; margin-top: 20px; }

        .modal-button-secondary {
            background: #F8FAFC;
            border: 1px solid rgba(15,37,87,0.12);
            color: var(--text-main); padding: 12px 20px;
            border-radius: 14px; cursor: pointer;
        }

        .modal-error {
            background: #FEE2E2; color: #991B1B;
            border-radius: 14px; padding: 14px 16px;
            margin-bottom: 16px; font-size: 13px;
        }

        /* ─── BUTTON PRIMARY ──────────────────────── */
        .button-primary {
            background: var(--blue-bright); color: #fff;
            border: none; padding: 12px 20px;
            border-radius: 14px; font-weight: 600;
            cursor: pointer; transition: transform 0.2s ease, background 0.2s ease;
            display: inline-flex; align-items: center; gap: 8px;
            font-family: 'Sora', sans-serif; font-size: 14px;
        }
        .button-primary:hover { background: #1d4ed8; transform: translateY(-1px); }

        /* ─── DATE BANNER ─────────────────────────── */
        .date-banner {
            display: inline-flex; align-items: center; gap: 8px;
            background: linear-gradient(90deg, #EFF6FF, #F0F9FF);
            border: 1px solid rgba(37,99,235,0.15);
            border-radius: 20px; padding: 6px 16px;
            font-size: 12px; color: var(--blue-bright); font-weight: 600;
            margin-bottom: 24px;
            animation: fadeSlideDown 0.5s ease both;
        }

        /* ─── STAT CARDS ──────────────────────────── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px; margin-bottom: 16px;
        }

        .stat-card {
            background: var(--card); border-radius: 16px; padding: 20px;
            border: 1px solid var(--border);
            position: relative; overflow: hidden;
            transition: transform 0.25s ease, box-shadow 0.25s ease;
            opacity: 0; animation: cardReveal 0.5s ease forwards;
        }
        .stat-card:hover { transform: translateY(-3px); box-shadow: 0 16px 40px var(--blue-glow); }
        .stat-card::after {
            content: ''; position: absolute; inset: 0; border-radius: 16px;
            background: linear-gradient(135deg, rgba(37,99,235,0.04) 0%, transparent 60%);
            pointer-events: none;
        }
        .stat-card:nth-child(1) { animation-delay: 0.05s; }
        .stat-card:nth-child(2) { animation-delay: 0.10s; }
        .stat-card:nth-child(3) { animation-delay: 0.15s; }
        .stat-card:nth-child(4) { animation-delay: 0.20s; }

        @keyframes cardReveal {
            from { opacity: 0; transform: translateY(18px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .stat-icon { width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 22px; margin-bottom: 14px; }
        .stat-label { font-size: 11px; font-weight: 600; letter-spacing: 0.07em; text-transform: uppercase; color: var(--text-muted); }
        .stat-value { font-size: 30px; font-weight: 700; color: var(--blue-deep); line-height: 1.1; margin: 6px 0 4px; font-family: 'Space Mono', monospace; }
        .stat-sub { font-size: 12px; color: var(--text-muted); }
        .stat-bar { height: 3px; border-radius: 2px; background: #EFF6FF; margin-top: 14px; overflow: hidden; }
        .stat-bar-fill { height: 100%; border-radius: 2px; width: 0%; transition: width 1.2s cubic-bezier(0.4,0,0.2,1) 0.6s; }

        /* ─── TABLE CARD ──────────────────────────── */
        .table-card {
            background: var(--card); border-radius: 16px; border: 1px solid var(--border); overflow: hidden;
            opacity: 0; animation: cardReveal 0.5s ease forwards;
        }
        .table-card:nth-child(1) { animation-delay: 0.3s; }
        .table-card:nth-child(2) { animation-delay: 0.4s; }

        .table-header { padding: 16px 20px; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center; }

        table { width: 100%; border-collapse: collapse; }
        thead { background: #FAFCFF; }
        thead tr { border-bottom: 1px solid var(--border); }
        th { padding: 10px 16px; text-align: left; font-size: 11px; font-weight: 600; letter-spacing: 0.07em; text-transform: uppercase; color: var(--text-muted); }
        tbody tr { border-bottom: 1px solid var(--border); transition: background 0.18s; }
        tbody tr:last-child { border-bottom: none; }
        tbody tr:hover { background: #F8FBFF; }
        td { padding: 12px 16px; font-size: 13.5px; color: var(--text-main); }
        .td-name { font-weight: 600; font-size: 13.5px; }
        .td-rm   { font-size: 11px; color: var(--text-muted); margin-top: 2px; font-family: 'Space Mono', monospace; }

        /* ─── BADGES ──────────────────────────────── */
        .badge { display: inline-flex; align-items: center; gap: 5px; padding: 4px 11px; border-radius: 20px; font-size: 11.5px; font-weight: 600; }
        .badge::before { content: ''; width: 6px; height: 6px; border-radius: 50%; }
        .badge-success { background: rgba(16,185,129,0.1); color: #047857; }
        .badge-success::before { background: #10B981; }
        .badge-warning { background: rgba(245,158,11,0.1); color: #B45309; }
        .badge-warning::before { background: #F59E0B; }
        .badge-info    { background: rgba(56,189,248,0.1); color: #0369A1; }
        .badge-info::before    { background: #38BDF8; }
        .badge-danger  { background: rgba(239,68,68,0.1); color: #B91C1C; }
        .badge-danger::before  { background: #EF4444; }
        .badge-purple  { background: rgba(139,92,246,0.1); color: #6D28D9; }
        .badge-purple::before  { background: #8B5CF6; }

        /* ─── VIEW ALL LINK ───────────────────────── */
        .view-all {
            font-size: 12px; font-weight: 600; color: var(--blue-bright);
            text-decoration: none; padding: 5px 12px; border-radius: 6px;
            background: #EFF6FF; transition: all 0.18s;
        }
        .view-all:hover { background: var(--blue-bright); color: #fff; }

        /* ─── SECTION DIVIDER ─────────────────────── */
        .section-divider { height: 1px; background: var(--border); margin: 24px 0; }

        /* ─── PULSE LINE ──────────────────────────── */
        .pulse-line {
            position: absolute; bottom: 0; left: 0; right: 0; height: 2px;
            background: linear-gradient(90deg, transparent 0%, var(--accent) 50%, transparent 100%);
            background-size: 200% 100%;
            animation: pulseLine 2.5s linear infinite;
            opacity: 0; transition: opacity 0.3s;
        }
        .stat-card:hover .pulse-line { opacity: 1; }
        @keyframes pulseLine { 0% { background-position: -100% 0; } 100% { background-position: 200% 0; } }

        /* ─── SCROLL REVEAL ───────────────────────── */
        .reveal { opacity: 0; transform: translateY(20px); transition: opacity 0.5s ease, transform 0.5s ease; }
        .reveal.visible { opacity: 1; transform: translateY(0); }

        /* ─── SECTION TITLE ───────────────────────── */
        .section-title { font-size: 16px; font-weight: 700; color: var(--blue-deep); letter-spacing: -0.3px; }

        /* ─── SCROLLBAR ───────────────────────────── */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(37,99,235,0.2); border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(37,99,235,0.4); }

        /* ═══════════════════════════════════════════
           PATIENTS SECTION — NEW PREMIUM DESIGN
        ═══════════════════════════════════════════ */

        /* Page header */
        .section-page-header {
            background: linear-gradient(130deg, var(--blue-deep) 0%, #1e40af 60%, #1d4ed8 100%);
            border-radius: 20px;
            padding: 28px 32px;
            margin-bottom: 24px;
            position: relative;
            overflow: hidden;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
        }

        .section-page-header::before {
            content: '';
            position: absolute;
            top: -60px; right: -60px;
            width: 260px; height: 260px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(96,165,250,0.22) 0%, transparent 70%);
            pointer-events: none;
        }

        .section-page-header::after {
            content: '';
            position: absolute;
            bottom: -40px; left: 40%;
            width: 180px; height: 180px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(56,189,248,0.14) 0%, transparent 70%);
            pointer-events: none;
        }

        .section-page-header-text .tag {
            font-size: 11px; font-weight: 700; letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--accent);
            margin-bottom: 6px;
        }

        .section-page-header-text h2 {
            font-size: 24px; font-weight: 700; color: #fff;
            letter-spacing: -0.5px; line-height: 1.2;
            margin-bottom: 6px;
        }

        .section-page-header-text p {
            font-size: 13px; color: rgba(255,255,255,0.55);
        }

        .section-page-header .button-white {
            background: #fff;
            color: var(--blue-deep);
            border: none;
            padding: 12px 22px;
            border-radius: 14px;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
            font-family: 'Sora', sans-serif;
            transition: transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
            flex-shrink: 0;
        }
        .section-page-header .button-white:hover { transform: translateY(-2px); box-shadow: 0 8px 30px rgba(0,0,0,0.2); }

        /* Summary strip */
        .summary-strip {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
            margin-bottom: 22px;
        }

        .summary-chip {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 16px 20px;
            display: flex;
            align-items: center;
            gap: 14px;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .summary-chip:hover { transform: translateY(-2px); box-shadow: 0 8px 24px var(--blue-glow); }

        .summary-chip-icon {
            width: 40px; height: 40px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px; flex-shrink: 0;
        }

        .summary-chip-text .label {
            font-size: 11px; font-weight: 600;
            letter-spacing: 0.06em; text-transform: uppercase;
            color: var(--text-muted);
        }
        .summary-chip-text .value {
            font-size: 22px; font-weight: 700;
            color: var(--blue-deep);
            font-family: 'Space Mono', monospace;
            line-height: 1.2;
        }

        /* Advanced search bar */
        .search-bar-wrapper {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 16px 20px;
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .search-bar-inner {
            flex: 1;
            min-width: 220px;
            position: relative;
            display: flex;
            align-items: center;
        }

        .search-bar-inner svg {
            position: absolute; left: 14px;
            color: var(--text-muted); pointer-events: none;
        }

        .search-bar-inner input {
            width: 100%;
            border: 1.5px solid rgba(15,37,87,0.12);
            border-radius: 12px;
            padding: 11px 14px 11px 42px;
            font-size: 14px;
            font-family: 'Sora', sans-serif;
            color: var(--text-main);
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .search-bar-inner input:focus {
            border-color: var(--blue-bright);
            box-shadow: 0 0 0 3px rgba(37,99,235,0.08);
        }
        .search-bar-inner input::placeholder { color: var(--text-muted); }

        .search-filter-select {
            border: 1.5px solid rgba(15,37,87,0.12);
            border-radius: 12px;
            padding: 11px 14px;
            font-size: 13px;
            font-family: 'Sora', sans-serif;
            color: var(--text-main);
            outline: none;
            cursor: pointer;
            background: #fff;
            min-width: 150px;
        }

        .search-btn {
            background: var(--blue-bright);
            color: #fff; border: none;
            padding: 11px 20px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
            font-family: 'Sora', sans-serif;
            transition: background 0.2s, transform 0.2s;
        }
        .search-btn:hover { background: #1d4ed8; transform: translateY(-1px); }

        /* Premium table */
        .premium-table-wrap {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 18px;
            overflow: hidden;
        }

        .premium-table-wrap table { width: 100%; border-collapse: collapse; }
        .premium-table-wrap thead { background: #F8FBFF; }
        .premium-table-wrap thead tr { border-bottom: 1.5px solid rgba(37,99,235,0.08); }

        .premium-table-wrap th {
            padding: 13px 18px;
            text-align: left;
            font-size: 10.5px; font-weight: 700;
            letter-spacing: 0.1em; text-transform: uppercase;
            color: #94a3b8;
        }

        .premium-table-wrap tbody tr {
            border-bottom: 1px solid rgba(37,99,235,0.06);
            transition: background 0.18s;
        }
        .premium-table-wrap tbody tr:last-child { border-bottom: none; }
        .premium-table-wrap tbody tr:hover { background: #F5F9FF; }
        .premium-table-wrap td { padding: 14px 18px; font-size: 13.5px; color: var(--text-main); }

        /* Patient avatar cell */
        .patient-cell { display: flex; align-items: center; gap: 12px; }

        .patient-avatar {
            width: 36px; height: 36px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 14px; flex-shrink: 0;
        }

        .patient-avatar.male   { background: #EFF6FF; color: var(--blue-bright); }
        .patient-avatar.female { background: #FDF4FF; color: #9333ea; }
        .patient-avatar.other  { background: #F0FDF4; color: var(--accent-green); }

        .patient-name { font-weight: 600; font-size: 13.5px; color: var(--blue-deep); }
        .patient-rm   { font-size: 11px; color: var(--text-muted); font-family: 'Space Mono', monospace; margin-top: 2px; }

        /* Insurance badge colors */
        .ins-bpjs   { background: #EFF6FF; color: #1d4ed8; }
        .ins-swasta { background: #F5F3FF; color: #6d28d9; }
        .ins-tunai  { background: #F0FDF4; color: #15803d; }
        .ins-badge  { font-size: 11.5px; font-weight: 600; padding: 4px 12px; border-radius: 20px; display: inline-block; }

        /* Action buttons */
        .act-wrap { display: flex; align-items: center; gap: 6px; }

        .act-btn {
            width: 34px; height: 34px;
            border: none; border-radius: 10px;
            display: inline-flex; align-items: center; justify-content: center;
            cursor: pointer;
            transition: transform 0.18s, box-shadow 0.18s;
        }
        .act-btn:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.12); }
        .act-btn svg { width: 15px; height: 15px; }

        .act-btn.view   { background: rgba(56,189,248,0.12); color: #0369a1; }
        .act-btn.edit   { background: rgba(16,185,129,0.12); color: #047857; }
        .act-btn.delete { background: rgba(239,68,68,0.12);  color: #b91c1c; }

        /* Rooms specific */
        .room-type-pill {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 4px 12px; border-radius: 20px;
            font-size: 11.5px; font-weight: 600;
        }

        .room-type-vvip   { background: #FEF3C7; color: #92400E; }
        .room-type-vip    { background: #EDE9FE; color: #5B21B6; }
        .room-type-icu    { background: #FEE2E2; color: #991B1B; }
        .room-type-umum   { background: #DBEAFE; color: #1E40AF; }
        .room-type-default{ background: #F1F5F9; color: #475569; }

        .status-dot { width: 7px; height: 7px; border-radius: 50%; display: inline-block; margin-right: 5px; }
        .status-aktif    .status-dot { background: var(--accent-green); }
        .status-nonaktif .status-dot { background: #CBD5E1; }
        .status-cell { display: flex; align-items: center; font-size: 13px; }
        .status-aktif    { color: #047857; }
        .status-nonaktif { color: #94A3B8; }

        .capacity-bar-wrap { display: flex; align-items: center; gap: 8px; }
        .capacity-bar {
            flex: 1; height: 5px; border-radius: 3px;
            background: #EFF6FF; overflow: hidden; min-width: 50px;
        }
        .capacity-bar-fill { height: 100%; border-radius: 3px; background: var(--blue-bright); }
        .capacity-label { font-size: 11.5px; color: var(--text-muted); white-space: nowrap; }

        .price-cell { font-family: 'Space Mono', monospace; font-size: 13px; color: var(--blue-deep); }

        /* Empty state */
        .empty-state {
            padding: 60px 20px;
            text-align: center;
        }
        .empty-state-icon {
            width: 64px; height: 64px;
            border-radius: 20px;
            background: #EFF6FF;
            display: flex; align-items: center; justify-content: center;
            font-size: 28px;
            margin: 0 auto 16px;
        }
        .empty-state h4 { font-size: 16px; font-weight: 700; color: var(--blue-deep); margin-bottom: 6px; }
        .empty-state p  { font-size: 13px; color: var(--text-muted); }

        /* ─── RESPONSIVE ──────────────────────────── */
        @media (max-width: 1100px) { .stats-grid { grid-template-columns: repeat(2, 1fr); } .summary-strip { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 700px)  { .stats-grid { grid-template-columns: 1fr; } .sidebar { width: 0; } .main-content { margin-left: 0; } .summary-strip { grid-template-columns: 1fr 1fr; } }

        @keyframes fadeSlideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to   { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>

<body>

    <!-- ══════════════════════════════ SIDEBAR ══════════════════════════════ -->
    <div class="sidebar">
        <div class="sidebar-logo">
            <div style="display:flex;align-items:center;gap:12px;">
                <div class="logo-icon">✚</div>
                <div>
                    <div class="logo-text">MediCore</div>
                    <div class="logo-sub">Hospital System</div>
                </div>
            </div>
        </div>

        <nav>
            <div class="nav-section-label">Menu</div>

            <div class="sidebar-item active" data-section="dashboard">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
                <span>Dashboard</span>
                <div class="nav-dot"></div>
            </div>

            <div class="sidebar-item" data-section="patients">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                <span>Pasien</span>
                <div class="nav-dot"></div>
            </div>

            <div class="sidebar-item" data-section="rooms">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 7h18"/><path d="M6 7v14h12V7"/><path d="M9 7V4h6v3"/><path d="M6 13h12"/><path d="M6 17h12"/></svg>
                <span>Ruangan</span>
                <div class="nav-dot"></div>
            </div>

            <div class="sidebar-item">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2a5 5 0 1 0 0 10A5 5 0 0 0 12 2zm0 12c-6 0-9 3-9 4v1h18v-1c0-1-3-4-9-4z"/><path d="M18 8h4m-2-2v4"/></svg>
                <span>Dokter</span>
                <div class="nav-dot"></div>
            </div>

            <div class="sidebar-item">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                <span>Jadwal</span>
                <div class="nav-dot"></div>
            </div>

            <div class="nav-section-label" style="margin-top:8px;">Admin</div>

            <div class="sidebar-item">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93l-1.41 1.41M4.93 4.93l1.41 1.41M12 2v2M12 20v2M2 12H4m16 0h2M4.93 19.07l1.41-1.41M19.07 19.07l-1.41-1.41"/></svg>
                <span>Pengaturan</span>
                <div class="nav-dot"></div>
            </div>

            <div class="sidebar-item" id="logoutBtn">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                <span>Keluar</span>
                <div class="nav-dot"></div>
            </div>
        </nav>
    </div>

    <!-- ══════════════════════════════ MAIN ══════════════════════════════ -->
    <div class="main-content">

        <!-- TOPBAR -->
        <div class="topbar">
            <div class="topbar-greeting">
                <h1>Halo, <span style="color:var(--blue-bright);">{{ Auth::user()->name }}</span> 👋</h1>
                <p>Berikut ringkasan operasional rumah sakit hari ini.</p>
            </div>
            <div class="topbar-right">
                <div class="notif-btn">
                    <svg width="17" height="17" fill="none" stroke="#64748B" stroke-width="2" viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                    <div class="notif-badge"></div>
                </div>
                <div class="user-pill">
                    <div class="avatar">{{ substr(Auth::user()->name, 0, 1) }}</div>
                    <div>
                        <div class="user-pill-name">{{ Auth::user()->name }}</div>
                        <div class="user-pill-role">Administrator</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- BODY -->
        <div class="content-body">

            <!-- ════════════════════ DASHBOARD SECTION ════════════════════ -->
            <div id="dashboardSection">
                <div class="date-banner">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                    <span id="liveDateLabel"></span>
                </div>

                @if(session('status'))
                    <div class="card-panel reveal" style="margin-top:16px; border-left:4px solid var(--accent);">
                        <div style="font-size:14px;color:var(--blue-deep);">{{ session('status') }}</div>
                    </div>
                @endif

                <div class="stats-grid" id="statsRow1">
                    <div class="stat-card">
                        <div class="stat-icon" style="background:#EFF6FF;">👥</div>
                        <div class="stat-label">Total Pasien</div>
                        <div class="stat-value" data-count="{{ $totalPatients }}">0</div>
                        <div class="stat-sub">Pasien terdaftar</div>
                        <div class="stat-bar"><div class="stat-bar-fill" style="background:var(--blue-bright);width:78%"></div></div>
                        <div class="pulse-line"></div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon" style="background:#FEF3C7;">🏥</div>
                        <div class="stat-label">Total Ruangan</div>
                        <div class="stat-value" data-count="{{ $totalRooms ?? 0 }}">0</div>
                        <div class="stat-sub">Ruangan tersedia</div>
                        <div class="stat-bar"><div class="stat-bar-fill" style="background:var(--accent-amber);width:72%"></div></div>
                        <div class="pulse-line"></div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon" style="background:#ECFDF5;">⚕️</div>
                        <div class="stat-label">Dokter Aktif</div>
                        <div class="stat-value" data-count="{{ $activeDoctors }}">0</div>
                        <div class="stat-sub">Dokter praktik</div>
                        <div class="stat-bar"><div class="stat-bar-fill" style="background:var(--accent-green);width:92%"></div></div>
                        <div class="pulse-line"></div>
                    </div>
                    <div class="stat-card" id="outpatientCard" style="cursor:pointer;">
                        <div class="stat-icon" style="background:#FFFBEB;">📋</div>
                        <div class="stat-label">Rawat Jalan Hari Ini</div>
                        <div class="stat-value" data-count="{{ $outpatientToday }}">0</div>
                        <div class="stat-sub">Kunjungan hari ini</div>
                        <div class="stat-bar"><div class="stat-bar-fill" style="background:var(--accent-amber);width:55%"></div></div>
                        <div class="pulse-line"></div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon" style="background:#F5F3FF;">🏥</div>
                        <div class="stat-label">Rawat Inap</div>
                        <div class="stat-value" data-count="{{ $inpatientTotal }}">0</div>
                        <div class="stat-sub">{{ $usedBeds }} / {{ $totalBeds }} bed terpakai</div>
                        <div class="stat-bar"><div class="stat-bar-fill" style="background:var(--accent-purple);width:{{ $totalBeds > 0 ? round(($usedBeds / $totalBeds) * 100) : 0 }}%"></div></div>
                        <div class="pulse-line"></div>
                    </div>
                </div>

                <div class="stats-grid" id="statsRow2">
                    <div class="stat-card">
                        <div class="stat-icon" style="background:#FEF2F2;">⚠️</div>
                        <div class="stat-label">Stok Obat Rendah</div>
                        <div class="stat-value" style="color:var(--accent-red);" data-count="{{ $lowStockMedicines }}">0</div>
                        <div class="stat-sub" style="color:var(--accent-red);">Perlu restock segera</div>
                        <div class="stat-bar"><div class="stat-bar-fill" style="background:var(--accent-red);width:30%"></div></div>
                        <div class="pulse-line"></div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon" style="background:#FFF7ED;">📄</div>
                        <div class="stat-label">Tagihan Pending</div>
                        <div class="stat-value" style="color:#EA580C;" data-count="{{ $pendingInvoices }}">0</div>
                        <div class="stat-sub">Belum dibayar</div>
                        <div class="stat-bar"><div class="stat-bar-fill" style="background:#F97316;width:45%"></div></div>
                        <div class="pulse-line"></div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon" style="background:#F0FDF4;">💰</div>
                        <div class="stat-label">Pendapatan Hari Ini</div>
                        <div class="stat-value" style="font-size:20px;padding-top:2px;">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</div>
                        <div class="stat-sub">Dari pembayaran</div>
                        <div class="stat-bar"><div class="stat-bar-fill" style="background:var(--accent-green);width:60%"></div></div>
                        <div class="pulse-line"></div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon" style="background:#EEF2FF;">📊</div>
                        <div class="stat-label">Pendapatan Bulan Ini</div>
                        <div class="stat-value" style="font-size:20px;padding-top:2px;">Rp {{ number_format($monthRevenue, 0, ',', '.') }}</div>
                        <div class="stat-sub">Total bulan berjalan</div>
                        <div class="stat-bar"><div class="stat-bar-fill" style="background:var(--accent-purple);width:72%"></div></div>
                        <div class="pulse-line"></div>
                    </div>
                </div>

                <div class="section-divider reveal"></div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;" class="reveal">
                    <div class="table-card">
                        <div class="table-header">
                            <div class="section-title">Rawat Jalan Hari Ini</div>
                            <a href="#" class="view-all">Lihat semua</a>
                        </div>
                        <table>
                            <thead><tr><th>#</th><th>Pasien</th><th>Poli</th><th>Status</th></tr></thead>
                            <tbody>
                                @foreach($outpatientAdmissions as $index => $admission)
                                <tr>
                                    <td style="color:var(--text-muted);font-size:12px;font-family:'Space Mono',monospace;">{{ $index + 1 }}</td>
                                    <td><div class="td-name">{{ $admission->patient->name }}</div><div class="td-rm">{{ $admission->patient->medical_record_number }}</div></td>
                                    <td style="font-size:13px;">{{ $admission->clinic }}</td>
                                    <td><span class="badge badge-success">Diperiksa</span></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="table-card">
                        <div class="table-header">
                            <div class="section-title">Rawat Inap Aktif</div>
                            <a href="#" class="view-all">Lihat semua</a>
                        </div>
                        <table>
                            <thead><tr><th>Pasien</th><th>Ruangan</th><th>Dokter</th></tr></thead>
                            <tbody>
                                @forelse($inpatientAdmissions as $admission)
                                <tr>
                                    <td><div class="td-name">{{ $admission->patient->name }}</div><div class="td-rm">{{ $admission->patient->medical_record_number }}</div></td>
                                    <td style="font-size:13px;">{{ $admission->room_number ?? 'N/A' }}</td>
                                    <td style="font-size:13px;">{{ $admission->doctor->name ?? 'N/A' }}</td>
                                </tr>
                                @empty
                                <tr><td colspan="3" style="text-align:center; padding:20px; color:var(--text-muted);">Tidak ada pasien rawat inap aktif.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div><!-- /dashboardSection -->


            <!-- ════════════════════ PATIENTS SECTION ════════════════════ -->
            <div id="patientsSection" style="display:none;">

                <!-- Header Banner -->
                <div class="section-page-header reveal">
                    <div class="section-page-header-text">
                        <div class="tag">✦ Manajemen Pasien</div>
                        <h2>Data Pasien</h2>
                        <p>Kelola semua rekam medis dan informasi pasien rumah sakit dengan mudah.</p>
                    </div>
                    <button type="button" class="button-white" id="openPatientModalBtn">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        Tambah Pasien
                    </button>
                </div>

                <!-- Summary Chips -->
                <div class="summary-strip reveal">
                    <div class="summary-chip">
                        <div class="summary-chip-icon" style="background:#EFF6FF;">👥</div>
                        <div class="summary-chip-text">
                            <div class="label">Total Pasien</div>
                            <div class="value">{{ $patients->count() }}</div>
                        </div>
                    </div>
                    <div class="summary-chip">
                        <div class="summary-chip-icon" style="background:#F0FDF4;">♂️</div>
                        <div class="summary-chip-text">
                            <div class="label">Laki-laki</div>
                            <div class="value">{{ $patients->where('gender','M')->count() }}</div>
                        </div>
                    </div>
                    <div class="summary-chip">
                        <div class="summary-chip-icon" style="background:#FDF4FF;">♀️</div>
                        <div class="summary-chip-text">
                            <div class="label">Perempuan</div>
                            <div class="value">{{ $patients->where('gender','F')->count() }}</div>
                        </div>
                    </div>
                    <div class="summary-chip">
                        <div class="summary-chip-icon" style="background:#FFFBEB;">🔒</div>
                        <div class="summary-chip-text">
                            <div class="label">BPJS</div>
                            <div class="value">{{ $patients->where('insurance','BPJS')->count() }}</div>
                        </div>
                    </div>
                </div>

                <!-- Search Bar -->
                <div class="search-bar-wrapper reveal">
                    <div class="search-bar-inner">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        <input type="text" id="patientSearch" placeholder="Cari nama, nomor RM, email, atau telepon..." />
                    </div>
                    <select class="search-filter-select" id="patientGenderFilter">
                        <option value="">Semua Jenis Kelamin</option>
                        <option value="laki">Laki-laki</option>
                        <option value="perempuan">Perempuan</option>
                    </select>
                    <select class="search-filter-select" id="patientInsuranceFilter">
                        <option value="">Semua Jaminan</option>
                        <option value="bpjs">BPJS</option>
                        <option value="asuransi swasta">Asuransi Swasta</option>
                        <option value="tunai">Tunai/Umum</option>
                    </select>
                    <button type="button" class="search-btn" id="patientSearchBtn">Cari</button>
                </div>

                <!-- Premium Table -->
                <div class="premium-table-wrap reveal">
                    <table>
                        <thead>
                            <tr>
                                <th style="width:42px;">#</th>
                                <th>Pasien</th>
                                <th>Kontak</th>
                                <th>Tanggal Masuk</th>
                                <th>Ruangan</th>
                                <th>Jaminan</th>
                                <th>Gol. Darah</th>
                                <th style="text-align:center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="patientTableBody">
                            @forelse($patients as $index => $patient)
                            @php
                                $initial = strtoupper(substr($patient->name, 0, 1));
                                $avatarClass = $patient->gender === 'M' ? 'male' : ($patient->gender === 'F' ? 'female' : 'other');
                                $insClass = '';
                                if($patient->insurance === 'BPJS') $insClass = 'ins-bpjs';
                                elseif($patient->insurance === 'Asuransi Swasta') $insClass = 'ins-swasta';
                                else $insClass = 'ins-tunai';
                            @endphp
                            <tr data-gender="{{ strtolower($patient->gender === 'M' ? 'laki' : 'perempuan') }}" data-insurance="{{ strtolower($patient->insurance ?? '') }}">
                                <td style="color:var(--text-muted);font-size:12px;font-family:'Space Mono',monospace;text-align:center;">{{ $index + 1 }}</td>
                                <td>
                                    <div class="patient-cell">
                                        <div class="patient-avatar {{ $avatarClass }}">{{ $initial }}</div>
                                        <div>
                                            <div class="patient-name">{{ $patient->name }}</div>
                                            <div class="patient-rm">{{ $patient->medical_record_number }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div style="font-size:13px; color:var(--text-main);">{{ $patient->email ?? '-' }}</div>
                                    <div style="font-size:11.5px; color:var(--text-muted); margin-top:2px;">{{ $patient->phone ?? '-' }}</div>
                                </td>
                                <td>
                                    <div style="font-size:13px; color:var(--text-main); font-weight:500;">{{ $patient->created_at->format('d M Y') }}</div>
                                    <div style="font-size:11.5px; color:var(--text-muted); margin-top:2px;">{{ $patient->created_at->format('H:i') }}</div>
                                </td>
                                <td>
                                    @if(optional($patient->room)->room_name)
                                        <div style="font-size:13px; font-weight:600; color:var(--blue-deep);">{{ $patient->room->room_name }}</div>
                                        <div style="font-size:11px; color:var(--text-muted);">{{ $patient->room->room_type }}</div>
                                    @else
                                        <span style="color:var(--text-muted); font-size:13px;">—</span>
                                    @endif
                                </td>
                                <td>
                                    @if($patient->insurance)
                                        <span class="ins-badge {{ $insClass }}">{{ $patient->insurance }}</span>
                                    @else
                                        <span style="color:var(--text-muted); font-size:13px;">—</span>
                                    @endif
                                </td>
                                <td>
                                    @if($patient->blood_type)
                                        <span style="font-size:13px; font-weight:700; font-family:'Space Mono',monospace; color:var(--accent-red);">{{ $patient->blood_type }}</span>
                                    @else
                                        <span style="color:var(--text-muted);">—</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="act-wrap" style="justify-content:center;">
                                        <button type="button" class="act-btn view icon-btn-patient-view"
                                            title="Lihat"
                                            data-id="{{ $patient->id }}"
                                            data-rm="{{ $patient->medical_record_number }}"
                                            data-name="{{ $patient->name }}"
                                            data-email="{{ $patient->email }}"
                                            data-phone="{{ $patient->phone }}"
                                            data-dob="{{ $patient->date_of_birth }}"
                                            data-gender="{{ $patient->gender }}"
                                            data-room-type="{{ optional($patient->room)->room_type }}"
                                            data-room-id="{{ $patient->room_id }}"
                                            data-insurance="{{ $patient->insurance }}"
                                            data-address="{{ $patient->address }}"
                                            data-blood="{{ $patient->blood_type }}"
                                        >
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                        </button>
                                        <button type="button" class="act-btn edit icon-btn-patient-edit"
                                            title="Edit"
                                            data-id="{{ $patient->id }}"
                                            data-rm="{{ $patient->medical_record_number }}"
                                            data-name="{{ $patient->name }}"
                                            data-email="{{ $patient->email }}"
                                            data-phone="{{ $patient->phone }}"
                                            data-dob="{{ $patient->date_of_birth }}"
                                            data-gender="{{ $patient->gender }}"
                                            data-room-type="{{ optional($patient->room)->room_type }}"
                                            data-room-id="{{ $patient->room_id }}"
                                            data-insurance="{{ $patient->insurance }}"
                                            data-address="{{ $patient->address }}"
                                            data-blood="{{ $patient->blood_type }}"
                                        >
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z"/></svg>
                                        </button>
                                        <button type="button" class="act-btn delete icon-btn-patient-delete" title="Hapus" data-id="{{ $patient->id }}">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7">
                                    <div class="empty-state">
                                        <div class="empty-state-icon">👥</div>
                                        <h4>Belum Ada Data Pasien</h4>
                                        <p>Tambah pasien baru untuk mengisi tabel ini.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div><!-- /patientsSection -->


            <!-- ════════════════════ ROOMS SECTION ════════════════════ -->
            <div id="roomsSection" style="display:none;">

                <!-- Header Banner -->
                <div class="section-page-header reveal" style="background: linear-gradient(130deg, #064E3B 0%, #065F46 60%, #047857 100%);">
                    <div class="section-page-header-text">
                        <div class="tag">✦ Manajemen Ruangan</div>
                        <h2>Data Ruangan</h2>
                        <p>Kelola daftar ruangan beserta tipe, kapasitas, tarif, dan ketersediaan.</p>
                    </div>
                    <button type="button" class="button-white" id="openRoomModalBtn">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        Tambah Ruangan
                    </button>
                </div>

                <!-- Summary Chips for Rooms -->
                <div class="summary-strip reveal">
                    <div class="summary-chip">
                        <div class="summary-chip-icon" style="background:#ECFDF5;">🏥</div>
                        <div class="summary-chip-text">
                            <div class="label">Total Ruangan</div>
                            <div class="value">{{ $rooms->count() }}</div>
                        </div>
                    </div>
                    <div class="summary-chip">
                        <div class="summary-chip-icon" style="background:#F0FDF4;">✅</div>
                        <div class="summary-chip-text">
                            <div class="label">Aktif</div>
                            <div class="value">{{ $rooms->where('status','Aktif')->count() }}</div>
                        </div>
                    </div>
                    <div class="summary-chip">
                        <div class="summary-chip-icon" style="background:#F8FAFC;">⛔</div>
                        <div class="summary-chip-text">
                            <div class="label">Nonaktif</div>
                            <div class="value">{{ $rooms->where('status','Nonaktif')->count() }}</div>
                        </div>
                    </div>
                    <div class="summary-chip">
                        <div class="summary-chip-icon" style="background:#FFF7ED;">🛏️</div>
                        <div class="summary-chip-text">
                            <div class="label">Total Kapasitas</div>
                            <div class="value">{{ $rooms->sum('capacity') }}</div>
                        </div>
                    </div>
                </div>

                <!-- Search Bar -->
                <div class="search-bar-wrapper reveal">
                    <div class="search-bar-inner">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        <input type="text" id="roomSearch" placeholder="Cari nama ruangan, tipe, lantai..." />
                    </div>
                    <select class="search-filter-select" id="roomStatusFilter">
                        <option value="">Semua Status</option>
                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Nonaktif</option>
                    </select>
                    <button type="button" class="search-btn" id="roomSearchButton">Cari</button>
                </div>

                <!-- Premium Rooms Table -->
                <div class="premium-table-wrap reveal">
                    <table>
                        <thead>
                            <tr>
                                <th style="width:42px;">#</th>
                                <th>Ruangan</th>
                                <th>Lantai</th>
                                <th>Kapasitas</th>
                                <th>Biaya / Hari</th>
                                <th>Status</th>
                                <th style="text-align:center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="roomTableBody">
                            @forelse($rooms as $room)
                            @php
                                $typeUpper = strtoupper($room->room_type ?? '');
                                $typeClass = 'room-type-default';
                                if(str_contains($typeUpper,'VVIP')) $typeClass = 'room-type-vvip';
                                elseif(str_contains($typeUpper,'VIP')) $typeClass = 'room-type-vip';
                                elseif(str_contains($typeUpper,'ICU')) $typeClass = 'room-type-icu';
                                elseif(str_contains($typeUpper,'UMUM')) $typeClass = 'room-type-umum';

                                $pct = $room->capacity > 0 ? max(0, min(100, round((($room->capacity - $room->available) / $room->capacity) * 100))) : 0;
                                $statusLower = strtolower($room->status ?? '');
                            @endphp
                            <tr data-status="{{ strtolower($room->status ?? '') }}">
                                <td style="color:var(--text-muted);font-size:12px;font-family:'Space Mono',monospace;text-align:center;">{{ $loop->iteration }}</td>
                                <td>
                                    <div style="font-weight:700; font-size:14px; color:var(--blue-deep);">{{ $room->room_name }}</div>
                                    <span class="room-type-pill {{ $typeClass }}" style="margin-top:5px; display:inline-flex;">{{ $room->room_type }}</span>
                                </td>
                                <td>
                                    <div style="display:inline-flex;align-items:center;gap:6px;background:#F1F5F9;border-radius:8px;padding:5px 10px;">
                                        <svg width="13" height="13" fill="none" stroke="#64748B" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M9 9h6M9 12h6M9 15h4"/></svg>
                                        <span style="font-size:13px; font-weight:600; color:#475569;">Lantai {{ $room->floor }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="capacity-bar-wrap">
                                        <div class="capacity-bar">
                                            <div class="capacity-bar-fill" style="width:{{ $pct }}%; background: {{ $pct > 80 ? 'var(--accent-red)' : ($pct > 50 ? 'var(--accent-amber)' : 'var(--accent-green)') }};"></div>
                                        </div>
                                        <span class="capacity-label">{{ $room->available }}/{{ $room->capacity }}</span>
                                    </div>
                                </td>
                                <td class="price-cell">Rp {{ number_format($room->price_per_day, 0, ',', '.') }}</td>
                                <td>
                                    <div class="status-cell status-{{ $statusLower }}">
                                        <span class="status-dot"></span>
                                        {{ $room->status }}
                                    </div>
                                </td>
                                <td>
                                    <div class="act-wrap" style="justify-content:center;">
                                        <button type="button" class="act-btn view view-room"
                                            title="Lihat"
                                            data-room-name="{{ $room->room_name }}"
                                            data-room-type="{{ $room->room_type }}"
                                            data-floor="{{ $room->floor }}"
                                            data-capacity="{{ $room->capacity }}"
                                            data-available="{{ $room->available }}"
                                            data-price="{{ number_format($room->price_per_day, 2, '.', '') }}"
                                            data-status="{{ $room->status }}"
                                        >
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                        </button>
                                        <button type="button" class="act-btn edit edit-room"
                                            title="Edit"
                                            data-id="{{ $room->id }}"
                                            data-room-name="{{ $room->room_name }}"
                                            data-room-type="{{ $room->room_type }}"
                                            data-floor="{{ $room->floor }}"
                                            data-capacity="{{ $room->capacity }}"
                                            data-available="{{ $room->available }}"
                                            data-price="{{ number_format($room->price_per_day, 2, '.', '') }}"
                                            data-status="{{ $room->status }}"
                                        >
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z"/></svg>
                                        </button>
                                        <button type="button" class="act-btn delete delete-room" title="Hapus" data-id="{{ $room->id }}">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7">
                                    <div class="empty-state">
                                        <div class="empty-state-icon">🏥</div>
                                        <h4>Belum Ada Data Ruangan</h4>
                                        <p>Tambah ruangan baru untuk mengisi tabel ini.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div><!-- /roomsSection -->


            <!-- ════════════════════ MODALS ════════════════════ -->

            <!-- Patient Add/Edit Modal -->
            <div class="modal-overlay" id="patientModal">
                <div class="modal-window">
                    <button type="button" class="modal-close" id="closePatientModalBtn">✕</button>
                    <h3>Tambah Pasien Baru</h3>
                    <p style="font-size:13px; color:var(--text-muted);">Masukkan data pasien baru agar langsung tersimpan ke sistem.</p>

                    @if ($errors->any())
                        <div class="modal-error">
                            <strong>Perbaiki data berikut:</strong>
                            <ul style="margin-top:8px; padding-left:18px;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('patients.store') }}" id="patientForm">
                        @csrf
                        <input type="hidden" name="_method" id="_method" value="">
                        <input type="hidden" name="patient_id" id="patient_id" value="{{ old('patient_id', '') }}">
                        <div class="modal-grid">
                            <div class="modal-field">
                                <label for="medical_record_number">No. Pasien</label>
                                <input id="medical_record_number" name="medical_record_number" type="text" value="{{ old('medical_record_number') }}" placeholder="Akan dibuat otomatis" readonly />
                            </div>
                            <div class="modal-field">
                                <label for="name">Nama Lengkap</label>
                                <input id="name" name="name" type="text" value="{{ old('name') }}" required />
                            </div>
                            <div class="modal-field">
                                <label for="email">Email</label>
                                <input id="email" name="email" type="email" value="{{ old('email') }}" placeholder="nama@domain.com" />
                            </div>
                            <div class="modal-field">
                                <label for="phone">Telepon</label>
                                <input id="phone" name="phone" type="tel" inputmode="numeric" pattern="\d{8,15}" value="{{ old('phone') }}" placeholder="081234567890" />
                            </div>
                            <div class="modal-field">
                                <label for="date_of_birth">Tanggal Lahir</label>
                                <input id="date_of_birth" name="date_of_birth" type="date" value="{{ old('date_of_birth') }}" />
                            </div>
                            <div class="modal-field">
                                <label for="gender">Jenis Kelamin</label>
                                <select id="gender" name="gender">
                                    <option value="">Pilih</option>
                                    <option value="M" {{ old('gender') === 'M' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="F" {{ old('gender') === 'F' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                            <div class="modal-field">
                                <label for="room_id">Ruangan</label>
                                <select id="room_id" name="room_id" required>
                                    <option value="">Pilih Ruangan</option>
                                    @foreach($rooms as $room)
                                        <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>
                                            {{ $room->room_name }} — {{ $room->room_type }} (tersedia {{ $room->available }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="modal-field">
                                <label for="insurance">Jaminan</label>
                                <select id="insurance" name="insurance">
                                    <option value="">Pilih</option>
                                    <option value="BPJS" {{ old('insurance') === 'BPJS' ? 'selected' : '' }}>BPJS</option>
                                    <option value="Asuransi Swasta" {{ old('insurance') === 'Asuransi Swasta' ? 'selected' : '' }}>Asuransi Swasta</option>
                                    <option value="Tunai/Umum" {{ old('insurance') === 'Tunai/Umum' ? 'selected' : '' }}>Tunai/Umum</option>
                                </select>
                            </div>
                            <div class="modal-field full-width">
                                <label for="address">Alamat</label>
                                <textarea id="address" name="address">{{ old('address') }}</textarea>
                            </div>
                            <div class="modal-field">
                                <label for="blood_type">Golongan Darah</label>
                                <select id="blood_type" name="blood_type">
                                    <option value="">Pilih</option>
                                    <option value="A" {{ old('blood_type') === 'A' ? 'selected' : '' }}>A</option>
                                    <option value="B" {{ old('blood_type') === 'B' ? 'selected' : '' }}>B</option>
                                    <option value="AB" {{ old('blood_type') === 'AB' ? 'selected' : '' }}>AB</option>
                                    <option value="O" {{ old('blood_type') === 'O' ? 'selected' : '' }}>O</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-actions">
                            <button type="button" class="modal-button-secondary" id="cancelPatientModalBtn">Batal</button>
                            <button type="submit" class="button-primary">Simpan Pasien</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Patient View Modal -->
            <div class="modal-overlay" id="patientViewModal">
                <div class="modal-window" style="max-width:480px;">
                    <button type="button" class="modal-close" id="closeViewModalBtn">✕</button>
                    <h3>Informasi Pasien</h3>
                    <div style="margin-top:20px; display:flex; flex-direction:column; gap:14px;">
                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px;">
                            <div class="modal-field"><label>No. RM</label><div id="view_rm" style="font-weight:700; font-family:'Space Mono',monospace;">-</div></div>
                            <div class="modal-field"><label>Nama</label><div id="view_name" style="font-weight:600;">-</div></div>
                            <div class="modal-field"><label>Email</label><div id="view_email" style="font-size:13px; color:var(--text-muted);">-</div></div>
                            <div class="modal-field"><label>Telepon</label><div id="view_phone" style="font-size:13px;">-</div></div>
                            <div class="modal-field"><label>Tanggal Lahir</label><div id="view_dob" style="font-size:13px;">-</div></div>
                            <div class="modal-field"><label>Jenis Kelamin</label><div id="view_gender" style="font-size:13px;">-</div></div>
                            <div class="modal-field"><label>Jaminan</label><div id="view_insurance" style="font-size:13px;">-</div></div>
                            <div class="modal-field"><label>Gol. Darah</label><div id="view_blood" style="font-size:20px; font-weight:800; color:var(--accent-red); font-family:'Space Mono',monospace;">-</div></div>
                        </div>
                        <div class="modal-field"><label>Alamat</label><div id="view_address" style="font-size:13px; color:var(--text-muted);">-</div></div>
                    </div>
                </div>
            </div>

            <!-- Room Add/Edit Modal -->
            <div class="modal-overlay" id="roomModal">
                <div class="modal-window">
                    <button type="button" class="modal-close" id="closeRoomModalBtn">✕</button>
                    <h3>Tambah Ruangan Baru</h3>
                    <p style="font-size:13px; color:var(--text-muted);">Tambah atau perbarui informasi ruangan agar manajemen kamar berjalan lancar.</p>

                    @if ($errors->any() && old('form_type') === 'room')
                        <div class="modal-error">
                            <strong>Perbaiki data berikut:</strong>
                            <ul style="margin-top:8px; padding-left:18px;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('rooms.store') }}" id="roomForm">
                        @csrf
                        <input type="hidden" name="_method" id="room_method" value="">
                        <input type="hidden" id="room_form_id" value="{{ old('room_id', '') }}">
                        <input type="hidden" name="form_type" value="room">
                        <div class="modal-grid">
                            <div class="modal-field">
                                <label for="room_name">Nama Ruangan</label>
                                <input id="room_name" name="room_name" type="text" value="{{ old('room_name') }}" placeholder="Anggrek 101" required />
                            </div>
                            <div class="modal-field">
                                <label for="room_type">Tipe Ruangan</label>
                                <input id="room_type" name="room_type" type="text" value="{{ old('room_type') }}" placeholder="VVIP, VIP, ICU" required />
                            </div>
                            <div class="modal-field">
                                <label for="floor">Lantai</label>
                                <input id="floor" name="floor" type="number" min="0" value="{{ old('floor') }}" placeholder="1" required />
                            </div>
                            <div class="modal-field">
                                <label for="capacity">Kapasitas</label>
                                <input id="capacity" name="capacity" type="number" min="1" value="{{ old('capacity') }}" placeholder="1" required />
                            </div>
                            <div class="modal-field">
                                <label for="available">Tersedia</label>
                                <input id="available" name="available" type="number" min="0" value="{{ old('available', 0) }}" placeholder="0" required />
                            </div>
                            <div class="modal-field">
                                <label for="price_per_day">Biaya / Hari</label>
                                <input id="price_per_day" name="price_per_day" type="number" min="0" step="0.01" value="{{ old('price_per_day', 0) }}" placeholder="1500000" required />
                            </div>
                            <div class="modal-field full-width">
                                <label for="status">Status</label>
                                <select id="status" name="status" required>
                                    <option value="">Pilih</option>
                                    <option value="Aktif" {{ old('status') === 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="Nonaktif" {{ old('status') === 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-actions">
                            <button type="button" class="modal-button-secondary" id="cancelRoomModalBtn">Batal</button>
                            <button type="submit" class="button-primary">Simpan Ruangan</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Room View Modal -->
            <div class="modal-overlay" id="roomViewModal">
                <div class="modal-window" style="max-width:480px;">
                    <button type="button" class="modal-close" id="closeRoomViewModalBtn">✕</button>
                    <h3>Detail Ruangan</h3>
                    <div style="margin-top:20px; display:grid; grid-template-columns:1fr 1fr; gap:14px;">
                        <div class="modal-field"><label>Nama Ruangan</label><div id="view_room_name" style="font-weight:700;">-</div></div>
                        <div class="modal-field"><label>Tipe</label><div id="view_room_type">-</div></div>
                        <div class="modal-field"><label>Lantai</label><div id="view_floor">-</div></div>
                        <div class="modal-field"><label>Kapasitas</label><div id="view_capacity">-</div></div>
                        <div class="modal-field"><label>Tersedia</label><div id="view_available">-</div></div>
                        <div class="modal-field"><label>Biaya / Hari</label><div id="view_price" style="font-family:'Space Mono',monospace; color:var(--blue-deep); font-weight:700;">-</div></div>
                        <div class="modal-field" style="grid-column:1/-1;"><label>Status</label><div id="view_status">-</div></div>
                    </div>
                </div>
            </div>

        </div><!-- /content-body -->
    </div><!-- /main-content -->

    <script>
        // ── Live date label
        const dateEl = document.getElementById('liveDateLabel');
        const days = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
        const months = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        const now = new Date();
        dateEl.textContent = `${days[now.getDay()]}, ${now.getDate()} ${months[now.getMonth()]} ${now.getFullYear()}`;

        // ── Count-up animation
        function animateCount(el, target, duration = 1200) {
            const start = performance.now();
            const update = (time) => {
                const elapsed = time - start;
                const progress = Math.min(elapsed / duration, 1);
                const ease = 1 - Math.pow(1 - progress, 3);
                el.textContent = Math.round(ease * target);
                if (progress < 1) requestAnimationFrame(update);
            };
            requestAnimationFrame(update);
        }

        document.querySelectorAll('[data-count]').forEach((el, i) => {
            const target = parseInt(el.getAttribute('data-count'));
            setTimeout(() => animateCount(el, target), 300 + i * 80);
        });

        // ── Scroll reveal
        const reveals = document.querySelectorAll('.reveal');
        const observer = new IntersectionObserver(entries => {
            entries.forEach(e => {
                if (e.isIntersecting) { e.target.classList.add('visible'); observer.unobserve(e.target); }
            });
        }, { threshold: 0.05 });
        reveals.forEach(r => observer.observe(r));

        // ── Sidebar nav
        document.querySelectorAll('.sidebar-item[data-section]').forEach(item => {
            item.addEventListener('click', function () {
                document.querySelectorAll('.sidebar-item').forEach(s => s.classList.remove('active'));
                this.classList.add('active');
                const t = this.dataset.section;
                document.getElementById('dashboardSection').style.display = t === 'dashboard' ? 'block' : 'none';
                document.getElementById('patientsSection').style.display  = t === 'patients'  ? 'block' : 'none';
                document.getElementById('roomsSection').style.display     = t === 'rooms'     ? 'block' : 'none';
                localStorage.setItem('activeSection', t);
            });
        });

        // ── Outpatient card navigation
        const outpatientCard = document.getElementById('outpatientCard');
        if (outpatientCard) {
            outpatientCard.addEventListener('click', function () {
                const patientsItem = document.querySelector('[data-section="patients"]');
                if (patientsItem) {
                    document.querySelectorAll('.sidebar-item').forEach(s => s.classList.remove('active'));
                    patientsItem.classList.add('active');
                    document.getElementById('dashboardSection').style.display = 'none';
                    document.getElementById('patientsSection').style.display = 'block';
                    document.getElementById('roomsSection').style.display = 'none';
                    localStorage.setItem('activeSection', 'patients');
                }
            });
        }

        // ── Patient Modal
        const patientModal      = document.getElementById('patientModal');
        const patientForm       = document.getElementById('patientForm');
        const patientIdInput    = document.getElementById('patient_id');
        const methodInput       = document.getElementById('_method');
        const patientBaseUrl    = "{{ url('/patients') }}";

        const patientModalTitle = document.querySelector('#patientModal .modal-window h3');
        const patientModalBtn   = document.querySelector('#patientModal .modal-actions .button-primary');

        const setPatientFormMode = (mode, patient = null) => {
            if (mode === 'edit' && patient) {
                patientModalTitle.textContent = 'Edit Pasien';
                patientModalBtn.textContent = 'Perbarui Pasien';
                patientForm.action = `${patientBaseUrl}/${patient.id}`;
                methodInput.value = 'PUT';
                patientIdInput.value = patient.id;
                document.getElementById('medical_record_number').value = patient.rm || '';
                document.getElementById('name').value = patient.name || '';
                document.getElementById('email').value = patient.email || '';
                document.getElementById('phone').value = patient.phone || '';
                document.getElementById('date_of_birth').value = patient.dob || '';
                document.getElementById('gender').value = patient.gender || '';
                document.getElementById('room_id').value = patient.room_id || '';
                document.getElementById('insurance').value = patient.insurance || '';
                document.getElementById('address').value = patient.address || '';
                document.getElementById('blood_type').value = patient.blood || '';
            } else {
                patientModalTitle.textContent = 'Tambah Pasien Baru';
                patientModalBtn.textContent = 'Simpan Pasien';
                patientForm.action = "{{ route('patients.store') }}";
                methodInput.value = '';
                patientIdInput.value = '';
                document.getElementById('medical_record_number').value = '';
                document.getElementById('name').value = '';
                document.getElementById('email').value = '';
                document.getElementById('phone').value = '';
                document.getElementById('date_of_birth').value = '';
                document.getElementById('gender').value = '';
                document.getElementById('room_id').value = '';
                document.getElementById('insurance').value = '';
                document.getElementById('address').value = '';
                document.getElementById('blood_type').value = '';
                patientForm.reset();
            }
        };

        const openPatientModal  = () => { patientModal.style.display = 'flex'; document.body.style.overflow = 'hidden'; };
        const closePatientModal = () => { patientModal.style.display = 'none'; document.body.style.overflow = ''; };

        document.getElementById('openPatientModalBtn').addEventListener('click', () => {
            setPatientFormMode('create');
            openPatientModal();
        });
        document.getElementById('closePatientModalBtn').addEventListener('click', closePatientModal);
        document.getElementById('cancelPatientModalBtn').addEventListener('click', closePatientModal);
        patientModal.addEventListener('click', e => { if (e.target === patientModal) closePatientModal(); });

        // ── Patient View Modal
        const patientViewModal = document.getElementById('patientViewModal');
        document.getElementById('closeViewModalBtn').addEventListener('click', () => { patientViewModal.style.display='none'; document.body.style.overflow=''; });
        patientViewModal.addEventListener('click', e => { if (e.target === patientViewModal) { patientViewModal.style.display='none'; document.body.style.overflow=''; } });

        // ── Room Modal
        const roomModal     = document.getElementById('roomModal');
        const roomForm      = document.getElementById('roomForm');
        const roomIdInput   = document.getElementById('room_form_id');
        const roomMethod    = document.getElementById('room_method');
        const roomBaseUrl   = "{{ url('/rooms') }}";

        const roomModalTitle = document.querySelector('#roomModal .modal-window h3');
        const roomModalBtn   = document.querySelector('#roomModal .modal-actions .button-primary');

        const setRoomFormMode = (mode, room = null) => {
            if (mode === 'edit' && room) {
                roomModalTitle.textContent = 'Edit Ruangan';
                roomModalBtn.textContent = 'Perbarui Ruangan';
                roomForm.action = `${roomBaseUrl}/${room.id}`;
                roomMethod.value = 'PUT';
                roomIdInput.value = room.id;
                document.getElementById('room_name').value = room.room_name || '';
                document.getElementById('room_type').value = room.room_type || '';
                document.getElementById('floor').value = room.floor || '';
                document.getElementById('capacity').value = room.capacity || '';
                document.getElementById('available').value = room.available ?? 0;
                document.getElementById('price_per_day').value = room.price_per_day || 0;
                document.getElementById('status').value = room.status || '';
            } else {
                roomModalTitle.textContent = 'Tambah Ruangan Baru';
                roomModalBtn.textContent = 'Simpan Ruangan';
                roomForm.action = "{{ route('rooms.store') }}";
                roomMethod.value = '';
                roomIdInput.value = '';
                document.getElementById('room_name').value = '';
                document.getElementById('room_type').value = '';
                document.getElementById('floor').value = '';
                document.getElementById('capacity').value = '';
                document.getElementById('available').value = 0;
                document.getElementById('price_per_day').value = 0;
                document.getElementById('status').value = '';
                roomForm.reset();
            }
        };

        const openRoomModal  = () => { roomModal.style.display = 'flex'; document.body.style.overflow = 'hidden'; };
        const closeRoomModal = () => { roomModal.style.display = 'none'; document.body.style.overflow = ''; };

        document.getElementById('openRoomModalBtn').addEventListener('click', () => { setRoomFormMode('create'); openRoomModal(); });
        document.getElementById('closeRoomModalBtn').addEventListener('click', closeRoomModal);
        document.getElementById('cancelRoomModalBtn').addEventListener('click', closeRoomModal);
        roomModal.addEventListener('click', e => { if (e.target === roomModal) closeRoomModal(); });

        // ── Room View Modal
        const roomViewModal = document.getElementById('roomViewModal');
        document.getElementById('closeRoomViewModalBtn').addEventListener('click', () => { roomViewModal.style.display='none'; document.body.style.overflow=''; });
        roomViewModal.addEventListener('click', e => { if (e.target === roomViewModal) { roomViewModal.style.display='none'; document.body.style.overflow=''; } });

        // ── Patient action buttons
        document.querySelectorAll('.icon-btn-patient-view').forEach(btn => {
            btn.addEventListener('click', function () {
                document.getElementById('view_rm').textContent       = this.dataset.rm || '-';
                document.getElementById('view_name').textContent     = this.dataset.name || '-';
                document.getElementById('view_email').textContent    = this.dataset.email || '-';
                document.getElementById('view_phone').textContent    = this.dataset.phone || '-';
                document.getElementById('view_dob').textContent      = this.dataset.dob || '-';
                document.getElementById('view_gender').textContent   = this.dataset.gender === 'M' ? 'Laki-laki' : this.dataset.gender === 'F' ? 'Perempuan' : '-';
                document.getElementById('view_insurance').textContent= this.dataset.insurance || '-';
                document.getElementById('view_blood').textContent    = this.dataset.blood || '-';
                document.getElementById('view_address').textContent  = this.dataset.address || '-';
                patientViewModal.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            });
        });

        document.querySelectorAll('.icon-btn-patient-edit').forEach(btn => {
            btn.addEventListener('click', function () {
                setPatientFormMode('edit', {
                    id: this.dataset.id, rm: this.dataset.rm, name: this.dataset.name,
                    email: this.dataset.email, phone: this.dataset.phone, dob: this.dataset.dob,
                    gender: this.dataset.gender, room_id: this.dataset.roomId,
                    insurance: this.dataset.insurance, address: this.dataset.address, blood: this.dataset.blood,
                });
                openPatientModal();
            });
        });

        document.querySelectorAll('.icon-btn-patient-delete').forEach(btn => {
            btn.addEventListener('click', function () {
                if (!confirm('Hapus data pasien ini?')) return;
                const f = document.createElement('form');
                f.method = 'POST'; f.action = `${patientBaseUrl}/${this.dataset.id}`;
                f.innerHTML = `<input type="hidden" name="_token" value="{{ csrf_token() }}"><input type="hidden" name="_method" value="DELETE">`;
                document.body.appendChild(f); f.submit();
            });
        });

        // ── Room action buttons
        document.querySelectorAll('.view-room').forEach(btn => {
            btn.addEventListener('click', function () {
                document.getElementById('view_room_name').textContent = this.dataset.roomName || '-';
                document.getElementById('view_room_type').textContent = this.dataset.roomType || '-';
                document.getElementById('view_floor').textContent     = this.dataset.floor || '-';
                document.getElementById('view_capacity').textContent  = this.dataset.capacity || '-';
                document.getElementById('view_available').textContent = this.dataset.available || '-';
                document.getElementById('view_price').textContent     = this.dataset.price ? `Rp ${Number(this.dataset.price).toLocaleString('id-ID')}` : '-';
                document.getElementById('view_status').textContent    = this.dataset.status || '-';
                roomViewModal.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            });
        });

        document.querySelectorAll('.edit-room').forEach(btn => {
            btn.addEventListener('click', function () {
                setRoomFormMode('edit', {
                    id: this.dataset.id, room_name: this.dataset.roomName, room_type: this.dataset.roomType,
                    floor: this.dataset.floor, capacity: this.dataset.capacity, available: this.dataset.available,
                    price_per_day: this.dataset.price, status: this.dataset.status,
                });
                openRoomModal();
            });
        });

        document.querySelectorAll('.delete-room').forEach(btn => {
            btn.addEventListener('click', function () {
                if (!confirm('Hapus data ruangan ini?')) return;
                const f = document.createElement('form');
                f.method = 'POST'; f.action = `${roomBaseUrl}/${this.dataset.id}`;
                f.innerHTML = `<input type="hidden" name="_token" value="{{ csrf_token() }}"><input type="hidden" name="_method" value="DELETE">`;
                document.body.appendChild(f); f.submit();
            });
        });

        // ── Patient search & filter
        const filterPatients = () => {
            const q   = document.getElementById('patientSearch')?.value.trim().toLowerCase() || '';
            const g   = document.getElementById('patientGenderFilter')?.value.toLowerCase() || '';
            const ins = document.getElementById('patientInsuranceFilter')?.value.toLowerCase() || '';
            document.querySelectorAll('#patientTableBody tr').forEach(row => {
                const text = Array.from(row.cells).map(c => c.textContent.toLowerCase()).join(' ');
                const rowGender = row.dataset.gender || '';
                const rowInsurance = row.dataset.insurance || '';
                const matchQ   = !q   || text.includes(q);
                const matchG   = !g   || rowGender.includes(g);
                const matchIns = !ins || rowInsurance.includes(ins);
                row.style.display = (matchQ && matchG && matchIns) ? '' : 'none';
            });
        };
        document.getElementById('patientSearchBtn')?.addEventListener('click', filterPatients);
        document.getElementById('patientSearch')?.addEventListener('keyup', e => { if(e.key==='Enter') filterPatients(); });
        document.getElementById('patientGenderFilter')?.addEventListener('change', filterPatients);
        document.getElementById('patientInsuranceFilter')?.addEventListener('change', filterPatients);

        const filterRooms = () => {
            const q      = document.getElementById('roomSearch')?.value.trim().toLowerCase() || '';
            const status = document.getElementById('roomStatusFilter')?.value.toLowerCase() || '';
            document.querySelectorAll('#roomTableBody tr').forEach(row => {
                const text = Array.from(row.cells).map(c => c.textContent.toLowerCase()).join(' ');
                const rowStatus = row.dataset.status || '';
                const matchQ = !q || text.includes(q);
                const matchS = !status || rowStatus.includes(status);
                row.style.display = (matchQ && matchS) ? '' : 'none';
            });
        };
        document.getElementById('roomSearchButton')?.addEventListener('click', filterRooms);
        document.getElementById('roomSearch')?.addEventListener('keyup', e => { if(e.key==='Enter') filterRooms(); });
        document.getElementById('roomStatusFilter')?.addEventListener('change', filterRooms);

        // ── Restore active section from localStorage on first load
        const savedSection = localStorage.getItem('activeSection') || 'dashboard';
        const sectionItem = document.querySelector(`[data-section="${savedSection}"]`);
        if (sectionItem) {
            document.querySelectorAll('.sidebar-item').forEach(s => s.classList.remove('active'));
            sectionItem.classList.add('active');
            document.getElementById('dashboardSection').style.display = savedSection === 'dashboard' ? 'block' : 'none';
            document.getElementById('patientsSection').style.display  = savedSection === 'patients'  ? 'block' : 'none';
            document.getElementById('roomsSection').style.display     = savedSection === 'rooms'     ? 'block' : 'none';
        }

        // ── Old data restore & error handling for patients
        const oldPatientId = "{{ old('patient_id', '') }}";
        if (oldPatientId) {
            setPatientFormMode('edit', {
                id: oldPatientId,
                rm: "{{ old('medical_record_number', '') }}",
                name: "{{ old('name', '') }}",
                email: "{{ old('email', '') }}",
                phone: "{{ old('phone', '') }}",
                dob: "{{ old('date_of_birth', '') }}",
                gender: "{{ old('gender', '') }}",
                room_id: "{{ old('room_id', '') }}",
                insurance: "{{ old('insurance', '') }}",
                address: "{{ old('address', '') }}",
                blood: "{{ old('blood_type', '') }}",
            });
            document.querySelector('[data-section="patients"]').click();
            openPatientModal();
        }

        @if ($errors->any() && !old('patient_id'))
            setPatientFormMode('create');
            document.querySelector('[data-section="patients"]').click();
            openPatientModal();
        @endif

        // ── Logout
        document.getElementById('logoutBtn').addEventListener('click', () => {
            const form = document.createElement('form');
            form.method = 'POST'; form.action = '{{ route("logout") }}';
            form.innerHTML = '<input type="hidden" name="_token" value="{{ csrf_token() }}">';
            document.body.appendChild(form); form.submit();
        });
    </script>
</body>
</html>
