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

        /* ═══════════════════════════════════════════════════════
           MEDICORE — PREMIUM MODAL STYLES
        ═══════════════════════════════════════════════════════ */

        /* ─── MODAL OVERLAY ──────────────────────────────────── */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(8, 20, 55, 0.55);
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 90;
            padding: 20px;
            animation: overlayIn 0.22s ease both;
        }

        @keyframes overlayIn {
            from { opacity: 0; }
            to   { opacity: 1; }
        }

        /* ─── MODAL WINDOW ───────────────────────────────────── */
        .modal-window {
            width: min(860px, 100%);
            background: #fff;
            border-radius: 28px;
            box-shadow:
                0 0 0 1px rgba(15, 37, 87, 0.07),
                0 8px 24px rgba(15, 37, 87, 0.08),
                0 32px 80px rgba(15, 37, 87, 0.18);
            position: relative;
            max-height: calc(100vh - 48px);
            overflow-y: auto;
            animation: modalIn 0.28s cubic-bezier(0.22, 1, 0.36, 1) both;
            overflow-x: hidden;
        }

        @keyframes modalIn {
            from { opacity: 0; transform: translateY(24px) scale(0.975); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        /* ─── MODAL HEADER BAND ──────────────────────────────── */
        .modal-window::before {
            content: '';
            display: block;
            height: 5px;
            background: linear-gradient(90deg, #2563EB 0%, #38BDF8 50%, #10B981 100%);
            border-radius: 28px 28px 0 0;
            position: sticky;
            top: 0;
            z-index: 2;
            margin-bottom: 0;
        }

        /* ─── MODAL INNER PADDING ────────────────────────────── */
        .modal-window > *:not(:first-child) {
            padding-left: 32px;
            padding-right: 32px;
        }

        .modal-window h3 {
            font-size: 21px;
            font-weight: 700;
            color: #0F2557;
            letter-spacing: -0.4px;
            margin-bottom: 4px;
            padding: 26px 32px 0;
        }

        .modal-window > p {
            font-size: 13px;
            color: #64748B;
            margin-bottom: 20px;
            padding: 0 32px;
        }

        /* ─── MODAL CLOSE ────────────────────────────────────── */
        .modal-close {
            position: sticky;
            top: 18px;
            float: right;
            margin: 14px 18px 0 0;
            width: 36px;
            height: 36px;
            border: 1px solid rgba(15, 37, 87, 0.10);
            border-radius: 10px;
            background: #F8FAFC;
            cursor: pointer;
            display: grid;
            place-items: center;
            font-size: 16px;
            color: #64748B;
            transition: background 0.18s, color 0.18s, transform 0.18s;
            z-index: 3;
            line-height: 1;
        }
        .modal-close:hover {
            background: #FEE2E2;
            color: #B91C1C;
            border-color: #FCA5A5;
            transform: rotate(90deg);
        }

        /* ─── MODAL GRID ──────────────────────────────────────── */
        .modal-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
            margin: 0 32px 24px;
        }

        .modal-grid.full-width { grid-column: 1 / -1; }

        /* ─── MODAL FIELD ────────────────────────────────────── */
        .modal-field {
            display: flex;
            flex-direction: column;
            gap: 7px;
        }

        .modal-field label {
            font-size: 11.5px;
            font-weight: 700;
            color: #64748B;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        /* ─── MODAL INPUTS ───────────────────────────────────── */
        .modal-field input,
        .modal-field select,
        .modal-field textarea {
            border: 1.5px solid rgba(15, 37, 87, 0.12);
            border-radius: 12px;
            padding: 12px 14px;
            font-size: 14px;
            font-family: 'Sora', sans-serif;
            color: #0F2557;
            background: #FAFCFF;
            outline: none;
            width: 100%;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
        }

        .modal-field input:focus,
        .modal-field select:focus,
        .modal-field textarea:focus {
            border-color: #2563EB;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.09);
        }

        .modal-field input[readonly] {
            background: #F1F5F9;
            color: #94A3B8;
            cursor: default;
            font-family: 'Space Mono', monospace;
            font-size: 13px;
        }

        .modal-field input::placeholder,
        .modal-field textarea::placeholder {
            color: #CBD5E1;
        }

        .modal-field textarea {
            min-height: 110px;
            resize: vertical;
            line-height: 1.6;
        }

        .modal-field select {
            cursor: pointer;
            appearance: none;
            -webkit-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%2364748B' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            padding-right: 38px;
        }

        /* ─── MODAL DIVIDER ──────────────────────────────────── */
        .modal-section-divider {
            height: 1px;
            background: rgba(15, 37, 87, 0.06);
            margin: 4px 32px 20px;
        }

        /* ─── MODAL ACTIONS ──────────────────────────────────── */
        .modal-actions {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 10px;
            padding: 18px 32px 28px;
            border-top: 1px solid rgba(15, 37, 87, 0.06);
            margin-top: 4px;
            position: sticky;
            bottom: 0;
            background: #fff;
            border-radius: 0 0 28px 28px;
            z-index: 2;
        }

        /* ─── MODAL BUTTONS ──────────────────────────────────── */
        .modal-button-secondary {
            background: #F1F5F9;
            border: 1.5px solid rgba(15, 37, 87, 0.10);
            color: #475569;
            padding: 11px 22px;
            border-radius: 12px;
            cursor: pointer;
            font-size: 13.5px;
            font-weight: 600;
            font-family: 'Sora', sans-serif;
            transition: all 0.18s;
        }
        .modal-button-secondary:hover {
            background: #E2E8F0;
            color: #1E293B;
            border-color: rgba(15, 37, 87, 0.18);
        }

        /* Override button-primary inside modals */
        .modal-actions .button-primary {
            padding: 11px 24px;
            border-radius: 12px;
            font-size: 13.5px;
            box-shadow: 0 4px 14px rgba(37, 99, 235, 0.25);
        }
        .modal-actions .button-primary:hover {
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.35);
            transform: translateY(-2px);
        }

        /* ─── MODAL ERROR ─────────────────────────────────────── */
        .modal-error {
            background: #FFF5F5;
            border: 1.5px solid #FCA5A5;
            color: #7F1D1D;
            border-radius: 14px;
            padding: 14px 18px;
            margin: 0 32px 18px;
            font-size: 13px;
            line-height: 1.6;
        }

        .modal-error strong {
            font-weight: 700;
            color: #991B1B;
        }

        .modal-error ul {
            margin-top: 6px;
            padding-left: 18px;
        }

        /* ─── VIEW MODAL (compact, read-only) ────────────────── */
        .modal-window[style*="max-width:480px"] h3,
        .modal-window[style*="max-width: 480px"] h3 {
            padding-bottom: 4px;
        }

        /* ─── VIEW MODAL FIELD ───────────────────────────────── */
        .modal-window .modal-field > div {
            font-size: 14px;
            color: #0F2557;
            font-weight: 500;
            min-height: 22px;
        }

        /* ─── VIEW MODAL INNER GRID ──────────────────────────── */
        .modal-window > div[style*="grid-template-columns"] {
            margin: 0 32px 12px;
        }

        /* ─── FIELD HIGHLIGHT on VIEW modals ─────────────────── */
        .modal-window .modal-field {
            background: #FAFCFF;
            border: 1px solid rgba(15, 37, 87, 0.07);
            border-radius: 12px;
            padding: 12px 14px;
            gap: 5px;
        }

        /* ─── SCROLLBAR inside modal ─────────────────────────── */
        .modal-window::-webkit-scrollbar { width: 5px; }
        .modal-window::-webkit-scrollbar-track { background: transparent; }
        .modal-window::-webkit-scrollbar-thumb { background: rgba(37,99,235,0.15); border-radius: 4px; }
        .modal-window::-webkit-scrollbar-thumb:hover { background: rgba(37,99,235,0.3); }

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

        /* ═══════════════════════════════════════════
           CALENDAR STYLES
        ═══════════════════════════════════════════ */
        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 6px;
        }

        .calendar-day-header {
            text-align: center;
            font-size: 11px;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.06em;
            padding: 10px 4px;
        }

        .calendar-day {
            aspect-ratio: 1;
            border-radius: 12px;
            border: 1px solid rgba(15,37,87,0.06);
            background: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            padding: 6px 4px;
            cursor: pointer;
            transition: all 0.18s ease;
            position: relative;
            min-height: 64px;
        }

        .calendar-day:hover {
            background: #F5F9FF;
            border-color: rgba(37,99,235,0.2);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(15,37,87,0.06);
        }

        .calendar-day.other-month {
            color: #CBD5E1;
            background: #FAFBFC;
        }

        .calendar-day.today {
            border-color: var(--blue-bright);
            background: #EFF6FF;
            box-shadow: 0 0 0 1px rgba(37,99,235,0.15);
        }

        .calendar-day.selected {
            border-color: var(--blue-bright);
            background: #DBEAFE;
        }

        .calendar-day-number {
            font-size: 13px;
            font-weight: 600;
            color: var(--blue-deep);
            width: 26px;
            height: 26px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }

        .calendar-day.today .calendar-day-number {
            background: var(--blue-bright);
            color: #fff;
        }

        .calendar-day-dots {
            display: flex;
            gap: 3px;
            margin-top: 4px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .calendar-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
        }

        .calendar-dot.outpatient { background: #F59E0B; }
        .calendar-dot.inpatient { background: #8B5CF6; }

        .calendar-day-count {
            font-size: 10px;
            font-weight: 700;
            color: var(--text-muted);
            margin-top: 2px;
        }

        .schedule-item {
            background: #F8FBFF;
            border: 1px solid rgba(37,99,235,0.08);
            border-radius: 12px;
            padding: 12px 14px;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.18s;
        }

        .schedule-item:hover {
            background: #F0F7FF;
            border-color: rgba(37,99,235,0.15);
        }

        .schedule-item-avatar {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 700;
            flex-shrink: 0;
        }

        .schedule-item-info {
            flex: 1;
            min-width: 0;
        }

        .schedule-item-name {
            font-size: 13px;
            font-weight: 600;
            color: var(--blue-deep);
        }

        .schedule-item-meta {
            font-size: 11px;
            color: var(--text-muted);
            margin-top: 2px;
        }

        .schedule-item-type {
            font-size: 10px;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 20px;
            white-space: nowrap;
        }

        .schedule-item-type.outpatient { background: #FEF3C7; color: #92400E; }
        .schedule-item-type.inpatient { background: #F5F3FF; color: #6D28D9; }
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

            <div class="sidebar-item" data-section="doctors">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2a5 5 0 1 0 0 10A5 5 0 0 0 12 2zm0 12c-6 0-9 3-9 4v1h18v-1c0-1-3-4-9-4z"/><path d="M18 8h4m-2-2v4"/></svg>
                <span>Dokter</span>
                <div class="nav-dot"></div>
            </div>

            <div class="sidebar-item" data-section="polikliniks">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                <span>Poliklinik</span>
                <div class="nav-dot"></div>
            </div>

            <div class="sidebar-item" data-section="medicines">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19.07 4.93l-1.41 1.41M4.93 4.93l1.41 1.41M12 2v2M12 20v2M2 12H4m16 0h2M4.93 19.07l1.41-1.41M19.07 19.07l-1.41-1.41"/><circle cx="12" cy="12" r="3"/></svg>
                <span>Obat</span>
                <div class="nav-dot"></div>
            </div>

            <div class="sidebar-item" data-section="outpatient">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
                <span>Rawat Jalan</span>
                <div class="nav-dot"></div>
            </div>

            <div class="sidebar-item" data-section="inpatient">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/><path d="M8 14h8M8 18h5"/></svg>
                <span>Rawat Inap</span>
                <div class="nav-dot"></div>
            </div>

            <div class="sidebar-item" data-section="schedule">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                <span>Jadwal</span>
                <div class="nav-dot"></div>
            </div>

            <div class="sidebar-item" data-section="medical-records">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                <span>Rekam Medis</span>
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
                            <a href="#" class="view-all" id="viewAllOutpatient">Lihat semua</a>
                        </div>
                        <table>
                            <thead><tr><th>#</th><th>Pasien</th><th>Poli</th><th>Status</th></tr></thead>
                            <tbody>
                                @foreach($outpatientAdmissions as $index => $admission)
                                <tr>
                                    <td style="color:var(--text-muted);font-size:12px;font-family:'Space Mono',monospace;">{{ $index + 1 }}</td>
                                    <td><div class="td-name">{{ $admission->patient->name }}</div><div class="td-rm">{{ $admission->patient->medical_record_number }}</div></td>
                                    <td style="font-size:13px;">{{ $admission->clinic }}</td>
                                    <td>
                                        @if($admission->status === 'menunggu')
                                            <span class="badge badge-warning">Menunggu</span>
                                        @elseif($admission->status === 'diperiksa')
                                            <span class="badge badge-info">Diperiksa</span>
                                        @else
                                            <span class="badge badge-success">Selesai</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="table-card">
                        <div class="table-header">
                            <div class="section-title">Rawat Inap Aktif</div>
                            <a href="#" class="view-all" id="viewAllInpatient">Lihat semua</a>
                        </div>
                        <table>
                            <thead><tr><th>Pasien</th><th>Ruangan</th><th>Dokter</th><th>Status</th></tr></thead>
                            <tbody>
                                @forelse($inpatientAdmissions as $admission)
                                <tr>
                                    <td><div class="td-name">{{ $admission->patient->name }}</div><div class="td-rm">{{ $admission->patient->medical_record_number }}</div></td>
                                    <td style="font-size:13px;">{{ optional($admission->room)->room_name ?? $admission->room_number ?? 'N/A' }}</td>
                                    <td style="font-size:13px;">{{ $admission->doctor->name ?? 'N/A' }}</td>
                                    <td>
                                        @if($admission->status === 'menunggu')
                                            <span class="badge badge-warning">Menunggu</span>
                                        @elseif(in_array($admission->status, ['dirawat', 'sedang dirawat']))
                                            <span class="badge badge-info">Dirawat</span>
                                        @else
                                            <span class="badge badge-success">Selesai</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="4" style="text-align:center; padding:20px; color:var(--text-muted);">Tidak ada pasien rawat inap aktif.</td></tr>
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

            <!-- ════════════════════ DOCTORS SECTION ════════════════════ -->
            <div id="doctorsSection" style="display:none;">

                <div class="section-page-header reveal" style="background: linear-gradient(130deg, #047857 0%, #065F46 60%, #064E3B 100%);">
                    <div class="section-page-header-text">
                        <div class="tag">✦ Manajemen Dokter</div>
                        <h2>Data Dokter</h2>
                        <p>Kelola dokter, SIP, spesialisasi, telepon, dan status praktik langsung dari database.</p>
                    </div>
                    <button type="button" class="button-white" id="openDoctorModalBtn">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        Tambah Dokter
                    </button>
                </div>

                <div class="summary-strip reveal">
                    <div class="summary-chip">
                        <div class="summary-chip-icon" style="background:#ECFDF5;">👨‍⚕️</div>
                        <div class="summary-chip-text">
                            <div class="label">Total Dokter</div>
                            <div class="value">{{ $totalDoctors }}</div>
                        </div>
                    </div>
                    <div class="summary-chip">
                        <div class="summary-chip-icon" style="background:#EFF6FF;">✅</div>
                        <div class="summary-chip-text">
                            <div class="label">Aktif</div>
                            <div class="value">{{ $activeDoctors }}</div>
                        </div>
                    </div>
                    <div class="summary-chip">
                        <div class="summary-chip-icon" style="background:#F8FAFC;">⛔</div>
                        <div class="summary-chip-text">
                            <div class="label">Nonaktif</div>
                            <div class="value">{{ $inactiveDoctors }}</div>
                        </div>
                    </div>
                    <div class="summary-chip">
                        <div class="summary-chip-icon" style="background:#EFF6FF;">🏥</div>
                        <div class="summary-chip-text">
                            <div class="label">Spesialisasi</div>
                            <div class="value">{{ $distinctSpecializations }}</div>
                        </div>
                    </div>
                </div>

                <div class="search-bar-wrapper reveal">
                    <div class="search-bar-inner">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        <input type="text" id="doctorSearch" placeholder="Cari nama, SIP, spesialisasi..." />
                    </div>
                    <select class="search-filter-select" id="doctorStatusFilter">
                        <option value="">Semua Status</option>
                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Nonaktif</option>
                    </select>
                    <button type="button" class="search-btn" id="doctorSearchBtn">Cari</button>
                </div>

                <div class="premium-table-wrap reveal">
                    <table>
                        <thead>
                            <tr>
                                <th style="width:42px;">#</th>
                                <th>Nama Dokter</th>
                                <th>Spesialisasi</th>
                                <th>No. SIP</th>
                                <th>Poliklinik</th>
                                <th>Telepon</th>
                                <th>Status</th>
                                <th style="text-align:center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="doctorTableBody">
                            @forelse($doctors as $index => $doctor)
                            <tr data-status="{{ $doctor->is_active ? 'aktif' : 'nonaktif' }}">
                                <td style="color:var(--text-muted);font-size:12px;font-family:'Space Mono',monospace;text-align:center;">{{ $index + 1 }}</td>
                                <td>
                                    <div class="patient-cell">
                                        <div class="patient-avatar {{ $doctor->is_active ? 'male' : 'other' }}">{{ strtoupper(substr($doctor->name, 0, 1)) }}</div>
                                        <div>
                                            <div class="patient-name">{{ $doctor->name }}</div>
                                            <div class="td-rm">{{ $doctor->specialization }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $doctor->specialization }}</td>
                                <td>{{ $doctor->license_number }}</td>
                                <td>{{ $doctor->poliklinik_name ?? '-' }}</td>
                                <td>{{ $doctor->phone ?? '-' }}</td>
                                <td>
                                    <div class="status-cell status-{{ $doctor->is_active ? 'aktif' : 'nonaktif' }}">
                                        <span class="status-dot"></span>
                                        {{ $doctor->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </div>
                                </td>
                                <td>
                                    <div class="act-wrap" style="justify-content:center;">
                                        <button type="button" class="act-btn edit edit-doctor"
                                            title="Edit"
                                            data-id="{{ $doctor->id }}"
                                            data-name="{{ $doctor->name }}"
                                            data-license="{{ $doctor->license_number }}"
                                            data-specialization="{{ $doctor->specialization }}"
                                            data-poliklinik-id="{{ $doctor->poliklinik_id }}"
                                            data-email="{{ $doctor->email }}"
                                            data-phone="{{ $doctor->phone }}"
                                            data-active="{{ $doctor->is_active ? '1' : '0' }}"
                                        >
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z"/></svg>
                                        </button>
                                        <button type="button" class="act-btn delete delete-doctor" title="Hapus" data-id="{{ $doctor->id }}">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8">
                                    <div class="empty-state">
                                        <div class="empty-state-icon">🩺</div>
                                        <h4>Belum Ada Data Dokter</h4>
                                        <p>Tambahkan dokter baru agar data muncul di tabel ini.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div><!-- /doctorsSection -->

            <!-- ════════════════════ POLIKLINIK SECTION ════════════════════ -->
            <div id="polikliniksSection" style="display:none;">

                <div class="section-page-header reveal" style="background: linear-gradient(130deg, #0F172A 0%, #1E293B 60%, #334155 100%);">
                    <div class="section-page-header-text">
                        <div class="tag">✦ Manajemen Poliklinik</div>
                        <h2>Data Poliklinik</h2>
                        <p>Kelola daftar poliklinik dan sambungkan dokter dengan pilihan poliklinik dari database.</p>
                    </div>
                    <button type="button" class="button-white" id="openPoliklinikModalBtn">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        Tambah Poliklinik
                    </button>
                </div>

                <div class="summary-strip reveal">
                    <div class="summary-chip">
                        <div class="summary-chip-icon" style="background:#EFF6FF;">🏥</div>
                        <div class="summary-chip-text">
                            <div class="label">Total Poliklinik</div>
                            <div class="value">{{ $polikliniks->count() }}</div>
                        </div>
                    </div>
                    <div class="summary-chip">
                        <div class="summary-chip-icon" style="background:#ECFDF5;">👩‍⚕️</div>
                        <div class="summary-chip-text">
                            <div class="label">Total Dokter</div>
                            <div class="value">{{ $polikliniks->sum('doctors_count') }}</div>
                        </div>
                    </div>
                    <div class="summary-chip">
                        <div class="summary-chip-icon" style="background:#FDF2F8;">🔁</div>
                        <div class="summary-chip-text">
                            <div class="label">Kunjungan</div>
                            <div class="value">{{ $polikliniks->sum('admissions_count') }}</div>
                        </div>
                    </div>
                    <div class="summary-chip">
                        <div class="summary-chip-icon" style="background:#F8FAFC;">✅</div>
                        <div class="summary-chip-text">
                            <div class="label">Aktif</div>
                            <div class="value">{{ $polikliniks->where('status','Aktif')->count() }}</div>
                        </div>
                    </div>
                </div>

                <div class="search-bar-wrapper reveal">
                    <div class="search-bar-inner">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        <input type="text" id="poliklinikSearch" placeholder="Cari poliklinik..." />
                    </div>
                    <select class="search-filter-select" id="poliklinikStatusFilter">
                        <option value="">Semua Status</option>
                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Nonaktif</option>
                    </select>
                    <button type="button" class="search-btn" id="poliklinikSearchBtn">Cari</button>
                </div>

                <div class="premium-table-wrap reveal">
                    <table>
                        <thead>
                            <tr>
                                <th style="width:42px;">#</th>
                                <th>Nama Poliklinik</th>
                                <th>Deskripsi</th>
                                <th>Dokter</th>
                                <th>Kunjungan</th>
                                <th>Status</th>
                                <th style="text-align:center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="poliklinikTableBody">
                            @forelse($polikliniks as $index => $poliklinik)
                            <tr data-status="{{ strtolower($poliklinik->status) }}">
                                <td style="color:var(--text-muted);font-size:12px;font-family:'Space Mono',monospace;text-align:center;">{{ $index + 1 }}</td>
                                <td>
                                    <div class="patient-cell">
                                        <div class="patient-avatar {{ $poliklinik->status === 'Aktif' ? 'male' : 'other' }}">{{ strtoupper(substr($poliklinik->name, 0, 1)) }}</div>
                                        <div>
                                            <div class="patient-name">{{ $poliklinik->name }}</div>
                                            <div class="td-rm">Poliklinik</div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $poliklinik->description ?? '-' }}</td>
                                <td>{{ $poliklinik->doctors_count }}</td>
                                <td>{{ $poliklinik->admissions_count }}</td>
                                <td>
                                    <div class="status-cell status-{{ strtolower($poliklinik->status) }}">
                                        <span class="status-dot"></span>
                                        {{ $poliklinik->status }}
                                    </div>
                                </td>
                                <td>
                                    <div class="act-wrap" style="justify-content:center;">
                                        <button type="button" class="act-btn edit edit-poliklinik"
                                            title="Edit"
                                            data-id="{{ $poliklinik->id }}"
                                            data-name="{{ $poliklinik->name }}"
                                            data-description="{{ $poliklinik->description }}"
                                            data-status="{{ $poliklinik->status }}"
                                        >
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z"/></svg>
                                        </button>
                                        <button type="button" class="act-btn delete delete-poliklinik" title="Hapus" data-id="{{ $poliklinik->id }}">
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
                                        <h4>Belum Ada Data Poliklinik</h4>
                                        <p>Tambahkan poliklinik baru agar dokter bisa memilih dari daftar.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div><!-- /polikliniksSection -->

            <!-- ════════════════════ MEDICINES SECTION ════════════════════ -->
            <div id="medicinesSection" style="display:none;">

                <div class="section-page-header reveal" style="background: linear-gradient(130deg, #0369A1 0%, #0EA5E9 60%, #38BDF8 100%);">
                    <div class="section-page-header-text">
                        <div class="tag">✦ Manajemen Obat</div>
                        <h2>Data Obat</h2>
                        <p>Kelola daftar obat, stok, harga, dan status ketersediaan dengan mudah.</p>
                    </div>
                    <button type="button" class="button-white" id="openMedicineModalBtn">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        Tambah Obat
                    </button>
                </div>

                <div class="summary-strip reveal">
                    <div class="summary-chip">
                        <div class="summary-chip-icon" style="background:#EFF6FF;">💊</div>
                        <div class="summary-chip-text">
                            <div class="label">Total Obat</div>
                            <div class="value">{{ $totalMedicines }}</div>
                        </div>
                    </div>
                    <div class="summary-chip">
                        <div class="summary-chip-icon" style="background:#ECFDF5;">✅</div>
                        <div class="summary-chip-text">
                            <div class="label">Aktif</div>
                            <div class="value">{{ $activeMedicines }}</div>
                        </div>
                    </div>
                    <div class="summary-chip">
                        <div class="summary-chip-icon" style="background:#FEF2F2;">⚠️</div>
                        <div class="summary-chip-text">
                            <div class="label">Stok Rendah</div>
                            <div class="value">{{ $lowStockMedicines }}</div>
                        </div>
                    </div>
                    <div class="summary-chip">
                        <div class="summary-chip-icon" style="background:#F0FDF4;">💰</div>
                        <div class="summary-chip-text">
                            <div class="label">Nilai Stok</div>
                            <div class="value" style="font-size:18px; padding-top:2px;">Rp {{ number_format($totalMedicineValue, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>

                <div class="search-bar-wrapper reveal">
                    <div class="search-bar-inner">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        <input type="text" id="medicineSearch" placeholder="Cari nama obat atau kode..." />
                    </div>
                    <select class="search-filter-select" id="medicineStatusFilter">
                        <option value="">Semua Status</option>
                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Nonaktif</option>
                    </select>
                    <button type="button" class="search-btn" id="medicineSearchBtn">Cari</button>
                </div>

                <div class="premium-table-wrap reveal">
                    <table>
                        <thead>
                            <tr>
                                <th style="width:42px;">#</th>
                                <th>Nama Obat</th>
                                <th>Kode</th>
                                <th>Stok</th>
                                <th>Minimum Stok</th>
                                <th>Satuan</th>
                                <th>Harga</th>
                                <th>Status</th>
                                <th style="text-align:center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="medicineTableBody">
                            @forelse($medicines as $index => $medicine)
                            @php
                                $isLowStock = $medicine->stock < $medicine->minimum_stock;
                                $statusLower = $medicine->is_active ? 'aktif' : 'nonaktif';
                            @endphp
                            <tr data-status="{{ $statusLower }}">
                                <td style="color:var(--text-muted);font-size:12px;font-family:'Space Mono',monospace;text-align:center;">{{ $index + 1 }}</td>
                                <td>
                                    <div class="patient-cell">
                                        <div class="patient-avatar {{ $medicine->is_active ? 'male' : 'other' }}">{{ strtoupper(substr($medicine->name, 0, 1)) }}</div>
                                        <div>
                                            <div class="patient-name">{{ $medicine->name }}</div>
                                            <div class="td-rm">{{ $medicine->code }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td style="font-family:'Space Mono',monospace; font-size:13px;">{{ $medicine->code }}</td>
                                <td>
                                    <div style="font-size:13px; font-weight:700; color: {{ $isLowStock ? 'var(--accent-red)' : 'var(--blue-deep)' }};">{{ $medicine->stock }}</div>
                                    @if($isLowStock)
                                        <div style="font-size:11px; color:var(--accent-red);">Stok rendah</div>
                                    @endif
                                </td>
                                <td style="font-size:13px; color:var(--text-muted);">{{ $medicine->minimum_stock }}</td>
                                <td style="font-size:13px;">{{ $medicine->unit }}</td>
                                <td class="price-cell">Rp {{ number_format($medicine->price, 0, ',', '.') }}</td>
                                <td>
                                    <div class="status-cell status-{{ $statusLower }}">
                                        <span class="status-dot"></span>
                                        {{ $medicine->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </div>
                                </td>
                                <td>
                                    <div class="act-wrap" style="justify-content:center;">
                                        <button type="button" class="act-btn view view-medicine"
                                            title="Lihat"
                                            data-name="{{ $medicine->name }}"
                                            data-code="{{ $medicine->code }}"
                                            data-stock="{{ $medicine->stock }}"
                                            data-minimum-stock="{{ $medicine->minimum_stock }}"
                                            data-unit="{{ $medicine->unit }}"
                                            data-price="{{ number_format($medicine->price, 2, '.', '') }}"
                                            data-description="{{ $medicine->description }}"
                                            data-active="{{ $medicine->is_active ? '1' : '0' }}"
                                        >
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                        </button>
                                        <button type="button" class="act-btn edit edit-medicine"
                                            title="Edit"
                                            data-id="{{ $medicine->id }}"
                                            data-name="{{ $medicine->name }}"
                                            data-code="{{ $medicine->code }}"
                                            data-stock="{{ $medicine->stock }}"
                                            data-minimum-stock="{{ $medicine->minimum_stock }}"
                                            data-unit="{{ $medicine->unit }}"
                                            data-price="{{ number_format($medicine->price, 2, '.', '') }}"
                                            data-description="{{ $medicine->description }}"
                                            data-active="{{ $medicine->is_active ? '1' : '0' }}"
                                        >
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z"/></svg>
                                        </button>
                                        <button type="button" class="act-btn delete delete-medicine" title="Hapus" data-id="{{ $medicine->id }}">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9">
                                    <div class="empty-state">
                                        <div class="empty-state-icon">💊</div>
                                        <h4>Belum Ada Data Obat</h4>
                                        <p>Tambahkan obat baru untuk mengisi tabel ini.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div><!-- /medicinesSection -->

            <!-- ════════════════════ OUTPATIENT SECTION ════════════════════ -->
            <div id="outpatientSection" style="display:none;">

                <div class="section-page-header reveal" style="background: linear-gradient(130deg, #B45309 0%, #D97706 60%, #F59E0B 100%);">
                    <div class="section-page-header-text">
                        <div class="tag">✦ Antrian Rawat Jalan</div>
                        <h2>Pendaftaran Rawat Jalan</h2>
                        <p>Kelola antrian pasien rawat jalan dengan nomor registrasi otomatis dan status pelayanan.</p>
                    </div>
                    <button type="button" class="button-white" id="openOutpatientModalBtn">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        Tambah Antrian
                    </button>
                </div>

                <div class="summary-strip reveal">
                    <div class="summary-chip">
                        <div class="summary-chip-icon" style="background:#FFFBEB;">📋</div>
                        <div class="summary-chip-text">
                            <div class="label">Total Hari Ini</div>
                            <div class="value">{{ $outpatientAdmissionsToday->count() }}</div>
                        </div>
                    </div>
                    <div class="summary-chip">
                        <div class="summary-chip-icon" style="background:#FEF3C7;">⏳</div>
                        <div class="summary-chip-text">
                            <div class="label">Menunggu</div>
                            <div class="value">{{ $outpatientAdmissionsToday->where('status','menunggu')->count() }}</div>
                        </div>
                    </div>
                    <div class="summary-chip">
                        <div class="summary-chip-icon" style="background:#ECFDF5;">🔍</div>
                        <div class="summary-chip-text">
                            <div class="label">Diperiksa</div>
                            <div class="value">{{ $outpatientAdmissionsToday->where('status','diperiksa')->count() }}</div>
                        </div>
                    </div>
                    <div class="summary-chip">
                        <div class="summary-chip-icon" style="background:#F0FDF4;">✅</div>
                        <div class="summary-chip-text">
                            <div class="label">Selesai</div>
                            <div class="value">{{ $outpatientAdmissionsToday->where('status','selesai')->count() }}</div>
                        </div>
                    </div>
                </div>

                <div class="search-bar-wrapper reveal">
                    <div class="search-bar-inner">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        <input type="text" id="outpatientSearch" placeholder="Cari nama pasien, nomor registrasi..." />
                    </div>
                    <select class="search-filter-select" id="outpatientStatusFilter">
                        <option value="">Semua Status</option>
                        <option value="menunggu">Menunggu</option>
                        <option value="diperiksa">Diperiksa</option>
                        <option value="selesai">Selesai</option>
                    </select>
                    <input type="date" class="search-filter-select" id="outpatientDateFilter" value="{{ date('Y-m-d') }}" />
                    <button type="button" class="search-btn" id="outpatientSearchBtn">Cari</button>
                </div>

                <div class="premium-table-wrap reveal">
                    <table>
                        <thead>
                            <tr>
                                <th style="width:42px;">#</th>
                                <th>No. Registrasi</th>
                                <th>Pasien</th>
                                <th>Poliklinik</th>
                                <th>Dokter</th>
                                <th>Keluhan</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th style="text-align:center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="outpatientTableBody">
                            @forelse($outpatientAdmissionsToday as $index => $admission)
                            <tr data-status="{{ $admission->status }}">
                                <td style="color:var(--text-muted);font-size:12px;font-family:'Space Mono',monospace;text-align:center;">{{ $index + 1 }}</td>
                                <td>
                                    <div style="font-family:'Space Mono',monospace; font-size:12px; font-weight:700; color:var(--blue-deep); background:#EFF6FF; padding:4px 8px; border-radius:6px; display:inline-block;">{{ $admission->registration_number }}</div>
                                </td>
                                <td>
                                    <div class="patient-cell">
                                        <div class="patient-avatar {{ optional($admission->patient)->gender === 'M' ? 'male' : (optional($admission->patient)->gender === 'F' ? 'female' : 'other') }}">{{ strtoupper(substr(optional($admission->patient)->name ?? '?', 0, 1)) }}</div>
                                        <div>
                                            <div class="patient-name">{{ optional($admission->patient)->name ?? 'Pasien tidak ditemukan' }}</div>
                                            <div class="td-rm">{{ optional($admission->patient)->medical_record_number ?? '-' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td style="font-size:13px;">{{ optional($admission->poliklinik)->name ?? $admission->clinic ?? '-' }}</td>
                                <td style="font-size:13px;">{{ optional($admission->doctor)->name ?? '-' }}</td>
                                <td style="font-size:12px; color:var(--text-muted); max-width:200px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ $admission->complaints ?? '-' }}</td>
                                <td>
                                    <div style="font-size:13px; font-weight:500;">{{ $admission->admission_date ? \Carbon\Carbon::parse($admission->admission_date)->format('d M Y') : '-' }}</div>
                                    <div style="font-size:11px; color:var(--text-muted);">{{ $admission->admission_date ? \Carbon\Carbon::parse($admission->admission_date)->format('H:i') : '-' }}</div>
                                </td>
                                <td>
                                    @if($admission->status === 'menunggu')
                                        <div class="status-cell" style="color:#B45309;"><span class="status-dot" style="background:#F59E0B;"></span>Menunggu</div>
                                    @elseif($admission->status === 'diperiksa')
                                        <div class="status-cell" style="color:#0369A1;"><span class="status-dot" style="background:#38BDF8;"></span>Diperiksa</div>
                                    @else
                                        <div class="status-cell" style="color:#047857;"><span class="status-dot" style="background:#10B981;"></span>Selesai</div>
                                    @endif
                                </td>
                                <td>
                                    <div class="act-wrap" style="justify-content:center;">
                                        <button type="button" class="act-btn view view-outpatient"
                                            title="Lihat"
                                            data-reg="{{ $admission->registration_number }}"
                                            data-patient="{{ optional($admission->patient)->name ?? '-' }}"
                                            data-poliklinik="{{ optional($admission->poliklinik)->name ?? $admission->clinic ?? '-' }}"
                                            data-doctor="{{ optional($admission->doctor)->name ?? '-' }}"
                                            data-complaints="{{ $admission->complaints }}"
                                            data-date="{{ $admission->admission_date }}"
                                            data-status="{{ $admission->status }}"
                                        >
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                        </button>
                                        <button type="button" class="act-btn edit edit-outpatient"
                                            title="Edit"
                                            data-id="{{ $admission->id }}"
                                            data-patient-id="{{ $admission->patient_id }}"
                                            data-doctor-id="{{ $admission->doctor_id }}"
                                            data-poliklinik-id="{{ $admission->poliklinik_id }}"
                                            data-clinic="{{ $admission->clinic }}"
                                            data-admission-date="{{ $admission->admission_date }}"
                                            data-complaints="{{ $admission->complaints }}"
                                            data-status="{{ $admission->status }}"
                                        >
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z"/></svg>
                                        </button>
                                        <button type="button" class="act-btn delete delete-outpatient" title="Hapus" data-id="{{ $admission->id }}">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9">
                                    <div class="empty-state">
                                        <div class="empty-state-icon">📋</div>
                                        <h4>Belum Ada Antrian Rawat Jalan</h4>
                                        <p>Tambahkan antrian baru untuk hari ini.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div><!-- /outpatientSection -->

            <!-- ════════════════════ INPATIENT SECTION ════════════════════ -->
            <div id="inpatientSection" style="display:none;">

                <div class="section-page-header reveal" style="background: linear-gradient(130deg, #7C3AED 0%, #8B5CF6 60%, #A78BFA 100%);">
                    <div class="section-page-header-text">
                        <div class="tag">✦ Manajemen Rawat Inap</div>
                        <h2>Data Rawat Inap</h2>
                        <p>Kelola pasien rawat inap dengan nomor admisi otomatis, ruangan, dokter, dan status perawatan.</p>
                    </div>
                    <button type="button" class="button-white" id="openInpatientModalBtn">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        Tambah Rawat Inap
                    </button>
                </div>

                <div class="summary-strip reveal">
                    <div class="summary-chip">
                        <div class="summary-chip-icon" style="background:#F5F3FF;">🏥</div>
                        <div class="summary-chip-text">
                            <div class="label">Total Pasien</div>
                            <div class="value">{{ $inpatientAll->count() }}</div>
                        </div>
                    </div>
                    <div class="summary-chip">
                        <div class="summary-chip-icon" style="background:#FEF3C7;">⏳</div>
                        <div class="summary-chip-text">
                            <div class="label">Menunggu</div>
                            <div class="value">{{ $inpatientMenunggu }}</div>
                        </div>
                    </div>
                    <div class="summary-chip">
                        <div class="summary-chip-icon" style="background:#DBEAFE;">🛏️</div>
                        <div class="summary-chip-text">
                            <div class="label">Dirawat</div>
                            <div class="value">{{ $inpatientDirawat + $inpatientSedangDirawat }}</div>
                        </div>
                    </div>
                    <div class="summary-chip">
                        <div class="summary-chip-icon" style="background:#ECFDF5;">✅</div>
                        <div class="summary-chip-text">
                            <div class="label">Selesai</div>
                            <div class="value">{{ $inpatientSelesai }}</div>
                        </div>
                    </div>
                </div>

                <div class="search-bar-wrapper reveal">
                    <div class="search-bar-inner">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        <input type="text" id="inpatientSearch" placeholder="Cari nama pasien, nomor admisi..." />
                    </div>
                    <select class="search-filter-select" id="inpatientStatusFilter">
                        <option value="">Semua Status</option>
                        <option value="menunggu">Menunggu</option>
                        <option value="dirawat">Dirawat</option>
                        <option value="selesai">Selesai</option>
                    </select>
                    <input type="date" class="search-filter-select" id="inpatientDateFilter" />
                    <button type="button" class="search-btn" id="inpatientSearchBtn">Cari</button>
                </div>

                <div class="premium-table-wrap reveal">
                    <table>
                        <thead>
                            <tr>
                                <th style="width:42px;">#</th>
                                <th>No. Admisi</th>
                                <th>Pasien</th>
                                <th>Dokter</th>
                                <th>Ruang / Bed</th>
                                <th>Tgl Masuk</th>
                                <th>Tgl Keluar</th>
                                <th>Status</th>
                                <th style="text-align:center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="inpatientTableBody">
                            @forelse($inpatientAll as $index => $admission)
                            <tr data-status="{{ $admission->status }}" data-date="{{ $admission->admission_date ? \Carbon\Carbon::parse($admission->admission_date)->format('Y-m-d') : '' }}">
                                <td style="color:var(--text-muted);font-size:12px;font-family:'Space Mono',monospace;text-align:center;">{{ $index + 1 }}</td>
                                <td>
                                    <div style="font-family:'Space Mono',monospace; font-size:12px; font-weight:700; color:var(--blue-deep); background:#EFF6FF; padding:4px 8px; border-radius:6px; display:inline-block;">{{ $admission->registration_number ?? '-' }}</div>
                                </td>
                                <td>
                                    <div class="patient-cell">
                                        <div class="patient-avatar {{ optional($admission->patient)->gender === 'M' ? 'male' : (optional($admission->patient)->gender === 'F' ? 'female' : 'other') }}">{{ strtoupper(substr(optional($admission->patient)->name ?? '?', 0, 1)) }}</div>
                                        <div>
                                            <div class="patient-name">{{ optional($admission->patient)->name ?? 'Pasien tidak ditemukan' }}</div>
                                            <div class="td-rm">{{ optional($admission->patient)->medical_record_number ?? '-' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td style="font-size:13px;">{{ optional($admission->doctor)->name ?? '-' }}</td>
                                <td>
                                    @if(optional($admission->room)->room_name)
                                        <div style="font-size:13px; font-weight:600; color:var(--blue-deep);">{{ $admission->room->room_name }}</div>
                                        <div style="font-size:11px; color:var(--text-muted);">{{ $admission->room->room_type }}</div>
                                    @else
                                        <span style="color:var(--text-muted); font-size:13px;">—</span>
                                    @endif
                                </td>
                                <td>
                                    <div style="font-size:13px; font-weight:500;">{{ $admission->admission_date ? \Carbon\Carbon::parse($admission->admission_date)->format('d M Y') : '-' }}</div>
                                    <div style="font-size:11px; color:var(--text-muted);">{{ $admission->admission_date ? \Carbon\Carbon::parse($admission->admission_date)->format('H:i') : '-' }}</div>
                                </td>
                                <td>
                                    @if($admission->discharge_date)
                                        <div style="font-size:13px; font-weight:500;">{{ \Carbon\Carbon::parse($admission->discharge_date)->format('d M Y') }}</div>
                                        <div style="font-size:11px; color:var(--text-muted);">{{ \Carbon\Carbon::parse($admission->discharge_date)->format('H:i') }}</div>
                                    @else
                                        <span style="color:var(--text-muted); font-size:13px;">—</span>
                                    @endif
                                </td>
                                <td>
                                    @if($admission->status === 'menunggu')
                                        <div class="status-cell" style="color:#B45309;"><span class="status-dot" style="background:#F59E0B;"></span>Menunggu</div>
                                    @elseif(in_array($admission->status, ['dirawat', 'sedang dirawat']))
                                        <div class="status-cell" style="color:#0369A1;"><span class="status-dot" style="background:#38BDF8;"></span>Dirawat</div>
                                    @else
                                        <div class="status-cell" style="color:#047857;"><span class="status-dot" style="background:#10B981;"></span>Selesai</div>
                                    @endif
                                </td>
                                <td>
                                    <div class="act-wrap" style="justify-content:center;">
                                        <button type="button" class="act-btn view view-inpatient"
                                            title="Lihat"
                                            data-reg="{{ $admission->registration_number }}"
                                            data-patient="{{ optional($admission->patient)->name ?? '-' }}"
                                            data-rm="{{ optional($admission->patient)->medical_record_number ?? '-' }}"
                                            data-doctor="{{ optional($admission->doctor)->name ?? '-' }}"
                                            data-room="{{ optional($admission->room)->room_name ?? '-' }}"
                                            data-room-type="{{ optional($admission->room)->room_type ?? '-' }}"
                                            data-admission-date="{{ $admission->admission_date }}"
                                            data-discharge-date="{{ $admission->discharge_date }}"
                                            data-status="{{ $admission->status }}"
                                        >
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                        </button>
                                        <button type="button" class="act-btn edit edit-inpatient"
                                            title="Edit"
                                            data-id="{{ $admission->id }}"
                                            data-patient-id="{{ $admission->patient_id }}"
                                            data-doctor-id="{{ $admission->doctor_id }}"
                                            data-room-id="{{ $admission->room_id }}"
                                            data-admission-date="{{ $admission->admission_date }}"
                                            data-discharge-date="{{ $admission->discharge_date }}"
                                            data-status="{{ $admission->status }}"
                                        >
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z"/></svg>
                                        </button>
                                        <button type="button" class="act-btn delete delete-inpatient" title="Hapus" data-id="{{ $admission->id }}">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9">
                                    <div class="empty-state">
                                        <div class="empty-state-icon">🏥</div>
                                        <h4>Belum Ada Data Rawat Inap</h4>
                                        <p>Tambahkan pasien rawat inap baru untuk mengisi tabel ini.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div><!-- /inpatientSection -->

            <!-- ════════════════════ SCHEDULE SECTION ════════════════════ -->
            <div id="scheduleSection" style="display:none;">

                <div class="section-page-header reveal" style="background: linear-gradient(130deg, #0F766E 0%, #14B8A6 60%, #2DD4BF 100%);">
                    <div class="section-page-header-text">
                        <div class="tag">✦ Jadwal & Kalender</div>
                        <h2>Kalender Pasien</h2>
                        <p>Lihat jadwal masuk pasien rawat jalan dan rawat inap dalam tampilan kalender.</p>
                    </div>
                </div>

                <div style="display:grid; grid-template-columns: 1fr 340px; gap: 20px;" class="reveal">
                    <!-- Calendar -->
                    <div class="card-panel" style="padding:24px;">
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
                            <h3 id="calendarMonthYear" style="font-size:18px; font-weight:700; color:var(--blue-deep);"></h3>
                            <div style="display:flex; gap:8px;">
                                <button type="button" id="prevMonthBtn" class="act-btn" style="width:36px; height:36px; background:#F1F5F9; color:#475569;">
                                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                                </button>
                                <button type="button" id="todayBtn" style="background:#F1F5F9; border:none; border-radius:10px; padding:8px 16px; font-size:13px; font-weight:600; color:#475569; cursor:pointer; font-family:'Sora',sans-serif;">Hari Ini</button>
                                <button type="button" id="nextMonthBtn" class="act-btn" style="width:36px; height:36px; background:#F1F5F9; color:#475569;">
                                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                                </button>
                            </div>
                        </div>

                        <div class="calendar-grid" id="calendarGrid">
                            <!-- Calendar header -->
                            <div class="calendar-day-header">Min</div>
                            <div class="calendar-day-header">Sen</div>
                            <div class="calendar-day-header">Sel</div>
                            <div class="calendar-day-header">Rab</div>
                            <div class="calendar-day-header">Kam</div>
                            <div class="calendar-day-header">Jum</div>
                            <div class="calendar-day-header">Sab</div>
                        </div>

                        <div style="display:flex; gap:20px; margin-top:20px; padding-top:16px; border-top:1px solid var(--border);">
                            <div style="display:flex; align-items:center; gap:6px;">
                                <span style="width:8px; height:8px; border-radius:50%; background:#F59E0B;"></span>
                                <span style="font-size:12px; color:var(--text-muted);">Rawat Jalan</span>
                            </div>
                            <div style="display:flex; align-items:center; gap:6px;">
                                <span style="width:8px; height:8px; border-radius:50%; background:#8B5CF6;"></span>
                                <span style="font-size:12px; color:var(--text-muted);">Rawat Inap</span>
                            </div>
                        </div>
                    </div>

                    <!-- Selected Date Detail -->
                    <div class="card-panel" style="padding:24px; height:fit-content;">
                        <h3 style="font-size:16px; font-weight:700; color:var(--blue-deep); margin-bottom:16px;">Detail Tanggal</h3>
                        <div id="selectedDateLabel" style="font-size:14px; font-weight:600; color:var(--text-muted); margin-bottom:16px;">Pilih tanggal di kalender</div>
                        <div id="selectedDateList" style="display:flex; flex-direction:column; gap:10px;">
                            <!-- Dynamic content -->
                        </div>
                    </div>
                </div>
            </div><!-- /scheduleSection -->

            <!-- ════════════════════ MEDICAL RECORDS SECTION ════════════════════ -->
            <div id="medicalRecordsSection" style="display:none;">

                <div class="section-page-header reveal" style="background: linear-gradient(130deg, #BE185D 0%, #DB2777 60%, #F472B6 100%);">
                    <div class="section-page-header-text">
                        <div class="tag">✦ Riwayat Medis</div>
                        <h2>Rekam Medis</h2>
                        <p>Kelola rekam medis pasien yang telah menyelesaikan pelayanan rawat jalan dan rawat inap.</p>
                    </div>
                </div>

                <div class="summary-strip reveal">
                    <div class="summary-chip">
                        <div class="summary-chip-icon" style="background:#FDF2F8;">📋</div>
                        <div class="summary-chip-text">
                            <div class="label">Total Rekam Medis</div>
                            <div class="value">{{ $medicalRecordsCount }}</div>
                        </div>
                    </div>
                    <div class="summary-chip">
                        <div class="summary-chip-icon" style="background:#FFFBEB;">🚶</div>
                        <div class="summary-chip-text">
                            <div class="label">Rawat Jalan</div>
                            <div class="value">{{ $medicalRecordsOutpatient }}</div>
                        </div>
                    </div>
                    <div class="summary-chip">
                        <div class="summary-chip-icon" style="background:#F5F3FF;">🏥</div>
                        <div class="summary-chip-text">
                            <div class="label">Rawat Inap</div>
                            <div class="value">{{ $medicalRecordsInpatient }}</div>
                        </div>
                    </div>
                    <div class="summary-chip">
                        <div class="summary-chip-icon" style="background:#ECFDF5;">📅</div>
                        <div class="summary-chip-text">
                            <div class="label">Bulan Ini</div>
                            <div class="value">{{ $medicalRecords->filter(fn($r) => $r->completed_at && $r->completed_at->format('Y-m') === now()->format('Y-m'))->count() }}</div>
                        </div>
                    </div>
                </div>

                <div class="search-bar-wrapper reveal">
                    <div class="search-bar-inner">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        <input type="text" id="medicalRecordSearch" placeholder="Cari nama pasien, nomor rekam medis, diagnosis..." />
                    </div>
                    <select class="search-filter-select" id="medicalRecordTypeFilter">
                        <option value="">Semua Jenis</option>
                        <option value="rawat jalan">Rawat Jalan</option>
                        <option value="rawat inap">Rawat Inap</option>
                    </select>
                    <input type="date" class="search-filter-select" id="medicalRecordDateFilter" />
                    <button type="button" class="search-btn" id="medicalRecordSearchBtn">Cari</button>
                </div>

                <div class="premium-table-wrap reveal">
                    <table>
                        <thead>
                            <tr>
                                <th style="width:42px;">#</th>
                                <th>No. Rekam Medis</th>
                                <th>Pasien</th>
                                <th>Dokter</th>
                                <th>Jenis</th>
                                <th>Diagnosis</th>
                                <th>ICD-10</th>
                                <th>Tanggal Selesai</th>
                                <th style="text-align:center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="medicalRecordTableBody">
                            @forelse($medicalRecords as $index => $record)
                            <tr data-type="{{ strtolower($record->admission_type) }}" data-date="{{ $record->completed_at ? $record->completed_at->format('Y-m-d') : '' }}">
                                <td style="color:var(--text-muted);font-size:12px;font-family:'Space Mono',monospace;text-align:center;">{{ $index + 1 }}</td>
                                <td>
                                    <div style="font-family:'Space Mono',monospace; font-size:12px; font-weight:700; color:var(--blue-deep); background:#FDF2F8; padding:4px 8px; border-radius:6px; display:inline-block;">{{ $record->record_number }}</div>
                                </td>
                                <td>
                                    <div class="patient-cell">
                                        <div class="patient-avatar {{ optional($record->patient)->gender === 'M' ? 'male' : (optional($record->patient)->gender === 'F' ? 'female' : 'other') }}">{{ strtoupper(substr(optional($record->patient)->name ?? '?', 0, 1)) }}</div>
                                        <div>
                                            <div class="patient-name">{{ optional($record->patient)->name ?? 'Pasien tidak ditemukan' }}</div>
                                            <div class="td-rm">{{ optional($record->patient)->medical_record_number ?? '-' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td style="font-size:13px;">{{ optional($record->doctor)->name ?? '-' }}</td>
                                <td>
                                    @if($record->admission_type === 'Rawat Jalan')
                                        <span style="font-size:11.5px; font-weight:600; padding:4px 10px; border-radius:20px; background:#FEF3C7; color:#92400E;">Rawat Jalan</span>
                                    @else
                                        <span style="font-size:11.5px; font-weight:600; padding:4px 10px; border-radius:20px; background:#F5F3FF; color:#6D28D9;">Rawat Inap</span>
                                    @endif
                                </td>
                                <td style="font-size:12px; color:var(--text-muted); max-width:200px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ $record->diagnosis ?? '-' }}</td>
                                <td>
                                    @if($record->icd_code)
                                        <div style="font-family:'Space Mono',monospace; font-size:12px; font-weight:700; color:var(--blue-deep);">{{ $record->icd_code }}</div>
                                        <div style="font-size:11px; color:var(--text-muted);">{{ $record->icd_description }}</div>
                                    @else
                                        <span style="color:var(--text-muted); font-size:13px;">—</span>
                                    @endif
                                </td>
                                <td>
                                    <div style="font-size:13px; font-weight:500;">{{ $record->completed_at ? $record->completed_at->format('d M Y') : '-' }}</div>
                                    <div style="font-size:11px; color:var(--text-muted);">{{ $record->completed_at ? $record->completed_at->format('H:i') : '-' }}</div>
                                </td>
                                <td>
                                    <div class="act-wrap" style="justify-content:center;">
                                        <button type="button" class="act-btn view view-medical-record"
                                            title="Lihat"
                                            data-record-number="{{ $record->record_number }}"
                                            data-patient="{{ optional($record->patient)->name ?? '-' }}"
                                            data-rm="{{ optional($record->patient)->medical_record_number ?? '-' }}"
                                            data-doctor="{{ optional($record->doctor)->name ?? '-' }}"
                                            data-type="{{ $record->admission_type }}"
                                            data-diagnosis="{{ $record->diagnosis }}"
                                            data-icd-code="{{ $record->icd_code }}"
                                            data-icd-description="{{ $record->icd_description }}"
                                            data-completed-at="{{ $record->completed_at }}"
                                        >
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                        </button>
                                        <button type="button" class="act-btn edit edit-medical-record"
                                            title="Edit"
                                            data-id="{{ $record->id }}"
                                            data-diagnosis="{{ $record->diagnosis }}"
                                            data-icd-code="{{ $record->icd_code }}"
                                            data-icd-description="{{ $record->icd_description }}"
                                        >
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z"/></svg>
                                        </button>
                                        <button type="button" class="act-btn delete delete-medical-record" title="Hapus" data-id="{{ $record->id }}">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9">
                                    <div class="empty-state">
                                        <div class="empty-state-icon">📋</div>
                                        <h4>Belum Ada Rekam Medis</h4>
                                        <p>Rekam medis akan otomatis muncul ketika pasien rawat jalan atau rawat inap dinyatakan selesai.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div><!-- /medicalRecordsSection -->

            <!-- Doctor Add/Edit Modal -->
            <div class="modal-overlay" id="doctorModal">
                <div class="modal-window">
                    <button type="button" class="modal-close" id="closeDoctorModalBtn">✕</button>
                    <h3>Tambah Dokter Baru</h3>
                    <p style="font-size:13px; color:var(--text-muted);">Masukkan data dokter dan nomor SIP agar dapat ditampilkan di tabel.</p>

                    @if ($errors->any() && old('form_type') === 'doctor')
                        <div class="modal-error">
                            <strong>Perbaiki data berikut:</strong>
                            <ul style="margin-top:8px; padding-left:18px;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('doctors.store') }}" id="doctorForm">
                        @csrf
                        <input type="hidden" name="_method" id="doctor_method" value="">
                        <input type="hidden" name="form_type" value="doctor">
                        <div class="modal-grid">
                            <div class="modal-field">
                                <label for="doctor_name">Nama Dokter</label>
                                <input id="doctor_name" name="name" type="text" value="{{ old('name') }}" required />
                            </div>
                            <div class="modal-field">
                                <label for="license_number">No. SIP</label>
                                <input id="license_number" name="license_number" type="text" value="{{ old('license_number') }}" placeholder="SIP-2026-001" required />
                            </div>
                            <div class="modal-field">
                                <label for="specialization">Spesialisasi</label>
                                <input id="specialization" name="specialization" type="text" value="{{ old('specialization') }}" placeholder="Spesialis Penyakit Dalam, Saraf, Anak" required />
                            </div>
                            <div class="modal-field">
                                <label for="poliklinik_id">Poliklinik</label>
                                <select id="poliklinik_id" name="poliklinik_id" required>
                                    <option value="">Pilih Poliklinik</option>
                                    @foreach($polikliniks as $poliklinik)
                                        <option value="{{ $poliklinik->id }}" {{ old('poliklinik_id') == $poliklinik->id ? 'selected' : '' }}>{{ $poliklinik->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="modal-field">
                                <label for="email">Email</label>
                                <input id="doctor_email" name="email" type="email" value="{{ old('email') }}" placeholder="dokter@rumahsakit.com" />
                            </div>
                            <div class="modal-field">
                                <label for="phone">Telepon</label>
                                <input id="doctor_phone" name="phone" type="tel" inputmode="numeric" pattern="\d{8,15}" value="{{ old('phone') }}" placeholder="081234567890" />
                            </div>
                            <div class="modal-field full-width">
                                <label for="is_active">Status Praktik</label>
                                <select id="is_active" name="is_active" required>
                                    <option value="1" {{ old('is_active') === '1' ? 'selected' : '' }}>Aktif</option>
                                    <option value="0" {{ old('is_active') === '0' ? 'selected' : '' }}>Nonaktif</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-actions">
                            <button type="button" class="modal-button-secondary" id="cancelDoctorModalBtn">Batal</button>
                            <button type="submit" class="button-primary" id="doctorModalSubmitBtn">Simpan Dokter</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Poliklinik Add/Edit Modal -->
            <div class="modal-overlay" id="poliklinikModal">
                <div class="modal-window">
                    <button type="button" class="modal-close" id="closePoliklinikModalBtn">✕</button>
                    <h3>Tambah Poliklinik Baru</h3>
                    <p style="font-size:13px; color:var(--text-muted);">Tambahkan poliklinik baru agar dokter dapat memilih dari daftar yang tersedia.</p>

                    @if ($errors->any() && old('form_type') === 'poliklinik')
                        <div class="modal-error">
                            <strong>Perbaiki data berikut:</strong>
                            <ul style="margin-top:8px; padding-left:18px;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('polikliniks.store') }}" id="poliklinikForm">
                        @csrf
                        <input type="hidden" name="_method" id="poliklinik_method" value="">
                        <input type="hidden" name="form_type" value="poliklinik">
                        <div class="modal-grid">
                            <div class="modal-field">
                                <label for="poliklinik_name">Nama Poliklinik</label>
                                <input id="poliklinik_name" name="name" type="text" value="{{ old('name') }}" required />
                            </div>
                            <div class="modal-field full-width">
                                <label for="poliklinik_description">Deskripsi</label>
                                <textarea id="poliklinik_description" name="description" placeholder="Penjelasan singkat tentang layanan poliklinik.">{{ old('description') }}</textarea>
                            </div>
                            <div class="modal-field full-width">
                                <label for="poliklinik_status">Status</label>
                                <select id="poliklinik_status" name="status" required>
                                    <option value="Aktif" {{ old('status') === 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="Nonaktif" {{ old('status') === 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-actions">
                            <button type="button" class="modal-button-secondary" id="cancelPoliklinikModalBtn">Batal</button>
                            <button type="submit" class="button-primary" id="poliklinikModalSubmitBtn">Simpan Poliklinik</button>
                        </div>
                    </form>
                </div>
            </div>

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

            <!-- Medicine Add/Edit Modal -->
            <div class="modal-overlay" id="medicineModal">
                <div class="modal-window">
                    <button type="button" class="modal-close" id="closeMedicineModalBtn">✕</button>
                    <h3>Tambah Obat Baru</h3>
                    <p style="font-size:13px; color:var(--text-muted);">Masukkan data obat untuk menyimpannya ke sistem.</p>

                    @if ($errors->any() && old('form_type') === 'medicine')
                        <div class="modal-error">
                            <strong>Perbaiki data berikut:</strong>
                            <ul style="margin-top:8px; padding-left:18px;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('medicines.store') }}" id="medicineForm">
                        @csrf
                        <input type="hidden" name="_method" id="medicine_method" value="">
                        <input type="hidden" name="form_type" value="medicine">
                        <div class="modal-grid">
                            <div class="modal-field">
                                <label for="medicine_name">Nama Obat</label>
                                <input id="medicine_name" name="name" type="text" value="{{ old('name') }}" placeholder="Paracetamol 500mg" required />
                            </div>
                            <div class="modal-field">
                                <label for="medicine_code">Kode Obat</label>
                                <input id="medicine_code" name="code" type="text" value="{{ old('code') }}" placeholder="OBT-001" required />
                            </div>
                            <div class="modal-field">
                                <label for="medicine_stock">Stok</label>
                                <input id="medicine_stock" name="stock" type="number" min="0" value="{{ old('stock', 0) }}" placeholder="0" required />
                            </div>
                            <div class="modal-field">
                                <label for="medicine_minimum_stock">Minimum Stok</label>
                                <input id="medicine_minimum_stock" name="minimum_stock" type="number" min="0" value="{{ old('minimum_stock', 10) }}" placeholder="10" required />
                            </div>
                            <div class="modal-field">
                                <label for="medicine_unit">Satuan</label>
                                <input id="medicine_unit" name="unit" type="text" value="{{ old('unit') }}" placeholder="Tablet, Botol, Ampul" required />
                            </div>
                            <div class="modal-field">
                                <label for="medicine_price">Harga (Rp)</label>
                                <input id="medicine_price" name="price" type="number" min="0" step="0.01" value="{{ old('price', 0) }}" placeholder="15000" required />
                            </div>
                            <div class="modal-field full-width">
                                <label for="medicine_description">Deskripsi</label>
                                <textarea id="medicine_description" name="description" placeholder="Keterangan tentang obat.">{{ old('description') }}</textarea>
                            </div>
                            <div class="modal-field full-width">
                                <label for="medicine_is_active">Status</label>
                                <select id="medicine_is_active" name="is_active" required>
                                    <option value="1" {{ old('is_active') === '1' ? 'selected' : '' }}>Aktif</option>
                                    <option value="0" {{ old('is_active') === '0' ? 'selected' : '' }}>Nonaktif</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-actions">
                            <button type="button" class="modal-button-secondary" id="cancelMedicineModalBtn">Batal</button>
                            <button type="submit" class="button-primary" id="medicineModalSubmitBtn">Simpan Obat</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Medicine View Modal -->
            <div class="modal-overlay" id="medicineViewModal">
                <div class="modal-window" style="max-width:480px;">
                    <button type="button" class="modal-close" id="closeMedicineViewModalBtn">✕</button>
                    <h3>Detail Obat</h3>
                    <div style="margin-top:20px; display:grid; grid-template-columns:1fr 1fr; gap:14px;">
                        <div class="modal-field"><label>Nama Obat</label><div id="view_medicine_name" style="font-weight:700;">-</div></div>
                        <div class="modal-field"><label>Kode</label><div id="view_medicine_code" style="font-family:'Space Mono',monospace;">-</div></div>
                        <div class="modal-field"><label>Stok</label><div id="view_medicine_stock">-</div></div>
                        <div class="modal-field"><label>Minimum Stok</label><div id="view_medicine_minimum_stock">-</div></div>
                        <div class="modal-field"><label>Satuan</label><div id="view_medicine_unit">-</div></div>
                        <div class="modal-field"><label>Harga</label><div id="view_medicine_price" style="font-family:'Space Mono',monospace; color:var(--blue-deep); font-weight:700;">-</div></div>
                        <div class="modal-field" style="grid-column:1/-1;"><label>Deskripsi</label><div id="view_medicine_description" style="font-size:13px; color:var(--text-muted);">-</div></div>
                        <div class="modal-field" style="grid-column:1/-1;"><label>Status</label><div id="view_medicine_status">-</div></div>
                    </div>
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

            <!-- Outpatient Add/Edit Modal -->
            <div class="modal-overlay" id="outpatientModal">
                <div class="modal-window">
                    <button type="button" class="modal-close" id="closeOutpatientModalBtn">✕</button>
                    <h3>Tambah Antrian Rawat Jalan</h3>
                    <p style="font-size:13px; color:var(--text-muted);">Daftarkan pasien rawat jalan dengan nomor registrasi otomatis.</p>

                    @if ($errors->any() && old('form_type') === 'outpatient')
                        <div class="modal-error">
                            <strong>Perbaiki data berikut:</strong>
                            <ul style="margin-top:8px; padding-left:18px;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admissions.store') }}" id="outpatientForm">
                        @csrf
                        <input type="hidden" name="_method" id="outpatient_method" value="">
                        <input type="hidden" name="form_type" value="outpatient">
                        <input type="hidden" name="admission_type" value="Rawat Jalan">
                        <input type="hidden" name="clinic" id="outpatient_clinic" value="{{ old('clinic') }}">
                        <input type="hidden" name="admission_date" id="outpatient_admission_date" value="{{ old('admission_date', date('Y-m-d')) }}">
                        <div class="modal-grid">
                            <div class="modal-field">
                                <label for="outpatient_patient_id">Pasien</label>
                                <select id="outpatient_patient_id" name="patient_id" required>
                                    <option value="">Pilih Pasien</option>
                                    @foreach($patients as $patient)
                                        <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>{{ $patient->name }} ({{ $patient->medical_record_number }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="modal-field">
                                <label for="outpatient_doctor_id">Dokter</label>
                                <select id="outpatient_doctor_id" name="doctor_id" required>
                                    <option value="">Pilih Dokter</option>
                                    @foreach($doctors as $doctor)
                                        <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>{{ $doctor->name }} — {{ $doctor->specialization }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="modal-field">
                                <label for="outpatient_poliklinik_id">Poliklinik</label>
                                <select id="outpatient_poliklinik_id" name="poliklinik_id" required>
                                    <option value="">Pilih Poliklinik</option>
                                    @foreach($polikliniks as $poliklinik)
                                        <option value="{{ $poliklinik->id }}" {{ old('poliklinik_id') == $poliklinik->id ? 'selected' : '' }}>{{ $poliklinik->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="modal-field">
                                <label for="outpatient_status">Status</label>
                                <select id="outpatient_status" name="status" required>
                                    <option value="menunggu" {{ old('status') === 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                    <option value="diperiksa" {{ old('status') === 'diperiksa' ? 'selected' : '' }}>Diperiksa</option>
                                    <option value="selesai" {{ old('status') === 'selesai' ? 'selected' : '' }}>Selesai</option>
                                </select>
                            </div>
                            <div class="modal-field full-width">
                                <label for="outpatient_complaints">Keluhan</label>
                                <textarea id="outpatient_complaints" name="complaints" placeholder="Deskripsikan keluhan pasien...">{{ old('complaints') }}</textarea>
                            </div>
                        </div>
                        <div class="modal-actions">
                            <button type="button" class="modal-button-secondary" id="cancelOutpatientModalBtn">Batal</button>
                            <button type="submit" class="button-primary" id="outpatientModalSubmitBtn">Simpan Antrian</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Outpatient View Modal -->
            <div class="modal-overlay" id="outpatientViewModal">
                <div class="modal-window" style="max-width:480px;">
                    <button type="button" class="modal-close" id="closeOutpatientViewModalBtn">✕</button>
                    <h3>Detail Rawat Jalan</h3>
                    <div style="margin-top:20px; display:grid; grid-template-columns:1fr 1fr; gap:14px;">
                        <div class="modal-field"><label>No. Registrasi</label><div id="view_outpatient_reg" style="font-family:'Space Mono',monospace; font-weight:700; color:var(--blue-deep);">-</div></div>
                        <div class="modal-field"><label>Pasien</label><div id="view_outpatient_patient" style="font-weight:600;">-</div></div>
                        <div class="modal-field"><label>Poliklinik</label><div id="view_outpatient_poliklinik">-</div></div>
                        <div class="modal-field"><label>Dokter</label><div id="view_outpatient_doctor">-</div></div>
                        <div class="modal-field" style="grid-column:1/-1;"><label>Keluhan</label><div id="view_outpatient_complaints" style="font-size:13px; color:var(--text-muted);">-</div></div>
                        <div class="modal-field"><label>Tanggal</label><div id="view_outpatient_date">-</div></div>
                        <div class="modal-field"><label>Status</label><div id="view_outpatient_status">-</div></div>
                    </div>
                </div>
            </div>

            <!-- Inpatient Add/Edit Modal -->
            <div class="modal-overlay" id="inpatientModal">
                <div class="modal-window">
                    <button type="button" class="modal-close" id="closeInpatientModalBtn">✕</button>
                    <h3>Tambah Rawat Inap</h3>
                    <p style="font-size:13px; color:var(--text-muted);">Daftarkan pasien rawat inap dengan nomor admisi otomatis.</p>

                    @if ($errors->any() && old('form_type') === 'inpatient')
                        <div class="modal-error">
                            <strong>Perbaiki data berikut:</strong>
                            <ul style="margin-top:8px; padding-left:18px;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admissions.store') }}" id="inpatientForm">
                        @csrf
                        <input type="hidden" name="_method" id="inpatient_method" value="">
                        <input type="hidden" name="form_type" value="inpatient">
                        <input type="hidden" name="admission_type" value="Rawat Inap">
                        <div class="modal-grid">
                            <div class="modal-field">
                                <label for="inpatient_patient_id">Pasien</label>
                                <select id="inpatient_patient_id" name="patient_id" required>
                                    <option value="">Pilih Pasien</option>
                                    @foreach($allPatients as $patient)
                                        <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>{{ $patient->name }} ({{ $patient->medical_record_number }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="modal-field">
                                <label for="inpatient_doctor_id">Dokter</label>
                                <select id="inpatient_doctor_id" name="doctor_id" required>
                                    <option value="">Pilih Dokter</option>
                                    @foreach($allDoctors as $doctor)
                                        <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>{{ $doctor->name }} — {{ $doctor->specialization }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="modal-field">
                                <label for="inpatient_room_id">Ruang / Bed</label>
                                <select id="inpatient_room_id" name="room_id" required>
                                    <option value="">Pilih Ruangan</option>
                                    @foreach($allRooms as $room)
                                        <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>{{ $room->room_name }} — {{ $room->room_type }} (tersedia {{ $room->available }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="modal-field">
                                <label for="inpatient_status">Status</label>
                                <select id="inpatient_status" name="status" required>
                                    <option value="menunggu" {{ old('status') === 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                    <option value="dirawat" {{ old('status') === 'dirawat' ? 'selected' : '' }}>Dirawat</option>
                                    <option value="selesai" {{ old('status') === 'selesai' ? 'selected' : '' }}>Selesai</option>
                                </select>
                            </div>
                            <div class="modal-field">
                                <label for="inpatient_admission_date">Tanggal Masuk</label>
                                <input type="datetime-local" id="inpatient_admission_date" name="admission_date" value="{{ old('admission_date', now()->format('Y-m-d\TH:i')) }}" required />
                            </div>
                            <div class="modal-field">
                                <label for="inpatient_discharge_date">Tanggal Keluar <span style="color:var(--text-muted);font-weight:400;">(opsional)</span></label>
                                <input type="datetime-local" id="inpatient_discharge_date" name="discharge_date" value="{{ old('discharge_date') }}" />
                            </div>
                        </div>
                        <div class="modal-actions">
                            <button type="button" class="modal-button-secondary" id="cancelInpatientModalBtn">Batal</button>
                            <button type="submit" class="button-primary" id="inpatientModalSubmitBtn">Simpan Rawat Inap</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Inpatient View Modal -->
            <div class="modal-overlay" id="inpatientViewModal">
                <div class="modal-window" style="max-width:480px;">
                    <button type="button" class="modal-close" id="closeInpatientViewModalBtn">✕</button>
                    <h3>Detail Rawat Inap</h3>
                    <div style="margin-top:20px; display:grid; grid-template-columns:1fr 1fr; gap:14px;">
                        <div class="modal-field"><label>No. Admisi</label><div id="view_inpatient_reg" style="font-family:'Space Mono',monospace; font-weight:700; color:var(--blue-deep);">-</div></div>
                        <div class="modal-field"><label>Pasien</label><div id="view_inpatient_patient" style="font-weight:600;">-</div></div>
                        <div class="modal-field"><label>No. RM</label><div id="view_inpatient_rm" style="font-family:'Space Mono',monospace;">-</div></div>
                        <div class="modal-field"><label>Dokter</label><div id="view_inpatient_doctor">-</div></div>
                        <div class="modal-field"><label>Ruang / Bed</label><div id="view_inpatient_room">-</div></div>
                        <div class="modal-field"><label>Tipe Ruangan</label><div id="view_inpatient_room_type">-</div></div>
                        <div class="modal-field"><label>Tanggal Masuk</label><div id="view_inpatient_admission_date">-</div></div>
                        <div class="modal-field"><label>Tanggal Keluar</label><div id="view_inpatient_discharge_date">-</div></div>
                        <div class="modal-field" style="grid-column:1/-1;"><label>Status</label><div id="view_inpatient_status">-</div></div>
                    </div>
                </div>
            </div>

            <!-- Medical Record View Modal -->
            <div class="modal-overlay" id="medicalRecordViewModal">
                <div class="modal-window" style="max-width:480px;">
                    <button type="button" class="modal-close" id="closeMedicalRecordViewModalBtn">✕</button>
                    <h3>Detail Rekam Medis</h3>
                    <div style="margin-top:20px; display:grid; grid-template-columns:1fr 1fr; gap:14px;">
                        <div class="modal-field"><label>No. Rekam Medis</label><div id="view_mr_record_number" style="font-family:'Space Mono',monospace; font-weight:700; color:var(--blue-deep);">-</div></div>
                        <div class="modal-field"><label>Pasien</label><div id="view_mr_patient" style="font-weight:600;">-</div></div>
                        <div class="modal-field"><label>No. RM</label><div id="view_mr_rm" style="font-family:'Space Mono',monospace;">-</div></div>
                        <div class="modal-field"><label>Dokter</label><div id="view_mr_doctor">-</div></div>
                        <div class="modal-field"><label>Jenis Pelayanan</label><div id="view_mr_type">-</div></div>
                        <div class="modal-field"><label>Tanggal Selesai</label><div id="view_mr_completed_at">-</div></div>
                        <div class="modal-field" style="grid-column:1/-1;"><label>Diagnosis</label><div id="view_mr_diagnosis" style="font-size:13px; color:var(--text-muted);">-</div></div>
                        <div class="modal-field"><label>Kode ICD-10</label><div id="view_mr_icd_code" style="font-family:'Space Mono',monospace; font-weight:700; color:var(--blue-deep);">-</div></div>
                        <div class="modal-field" style="grid-column:1/-1;"><label>Deskripsi ICD-10</label><div id="view_mr_icd_description" style="font-size:13px; color:var(--text-muted);">-</div></div>
                    </div>
                </div>
            </div>

            <!-- Medical Record Edit Modal -->
            <div class="modal-overlay" id="medicalRecordEditModal">
                <div class="modal-window">
                    <button type="button" class="modal-close" id="closeMedicalRecordEditModalBtn">✕</button>
                    <h3>Edit Rekam Medis</h3>
                    <p style="font-size:13px; color:var(--text-muted);">Perbarui diagnosis dan kode ICD-10 rekam medis pasien.</p>

                    @if ($errors->any() && old('form_type') === 'medical_record')
                        <div class="modal-error">
                            <strong>Perbaiki data berikut:</strong>
                            <ul style="margin-top:8px; padding-left:18px;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ url('/medical-records') }}" id="medicalRecordEditForm">
                        @csrf
                        <input type="hidden" name="_method" id="medical_record_method" value="">
                        <input type="hidden" name="form_type" value="medical_record">
                        <div class="modal-grid">
                            <div class="modal-field full-width">
                                <label for="medical_record_diagnosis">Diagnosis</label>
                                <textarea id="medical_record_diagnosis" name="diagnosis" placeholder="Masukkan diagnosis pasien...">{{ old('diagnosis') }}</textarea>
                            </div>
                            <div class="modal-field">
                                <label for="medical_record_icd_code">Kode ICD-10</label>
                                <input id="medical_record_icd_code" name="icd_code" type="text" value="{{ old('icd_code') }}" placeholder="Contoh: J18.9" />
                            </div>
                            <div class="modal-field full-width">
                                <label for="medical_record_icd_description">Deskripsi ICD-10</label>
                                <input id="medical_record_icd_description" name="icd_description" type="text" value="{{ old('icd_description') }}" placeholder="Contoh: Pneumonia, unspecified organism" />
                            </div>
                        </div>
                        <div class="modal-actions">
                            <button type="button" class="modal-button-secondary" id="cancelMedicalRecordEditModalBtn">Batal</button>
                            <button type="submit" class="button-primary" id="medicalRecordEditModalSubmitBtn">Simpan Perubahan</button>
                        </div>
                    </form>
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
                document.getElementById('doctorsSection').style.display   = t === 'doctors'   ? 'block' : 'none';
                document.getElementById('polikliniksSection').style.display = t === 'polikliniks' ? 'block' : 'none';
                document.getElementById('medicinesSection').style.display = t === 'medicines' ? 'block' : 'none';
                document.getElementById('outpatientSection').style.display = t === 'outpatient' ? 'block' : 'none';
                document.getElementById('inpatientSection').style.display = t === 'inpatient' ? 'block' : 'none';
                document.getElementById('scheduleSection').style.display = t === 'schedule' ? 'block' : 'none';
                document.getElementById('medicalRecordsSection').style.display = t === 'medical-records' ? 'block' : 'none';
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

        // ── View All links navigation
        document.getElementById('viewAllOutpatient')?.addEventListener('click', function (e) {
            e.preventDefault();
            const sectionItem = document.querySelector('[data-section="outpatient"]');
            if (sectionItem) {
                document.querySelectorAll('.sidebar-item').forEach(s => s.classList.remove('active'));
                sectionItem.classList.add('active');
                document.getElementById('dashboardSection').style.display = 'none';
                document.getElementById('outpatientSection').style.display = 'block';
                document.getElementById('patientsSection').style.display = 'none';
                document.getElementById('roomsSection').style.display = 'none';
                document.getElementById('doctorsSection').style.display = 'none';
                document.getElementById('polikliniksSection').style.display = 'none';
                document.getElementById('medicinesSection').style.display = 'none';
                document.getElementById('inpatientSection').style.display = 'none';
                document.getElementById('scheduleSection').style.display = 'none';
                localStorage.setItem('activeSection', 'outpatient');
            }
        });

        document.getElementById('viewAllInpatient')?.addEventListener('click', function (e) {
            e.preventDefault();
            const sectionItem = document.querySelector('[data-section="inpatient"]');
            if (sectionItem) {
                document.querySelectorAll('.sidebar-item').forEach(s => s.classList.remove('active'));
                sectionItem.classList.add('active');
                document.getElementById('dashboardSection').style.display = 'none';
                document.getElementById('inpatientSection').style.display = 'block';
                document.getElementById('patientsSection').style.display = 'none';
                document.getElementById('roomsSection').style.display = 'none';
                document.getElementById('doctorsSection').style.display = 'none';
                document.getElementById('polikliniksSection').style.display = 'none';
                document.getElementById('medicinesSection').style.display = 'none';
                document.getElementById('outpatientSection').style.display = 'none';
                document.getElementById('scheduleSection').style.display = 'none';
                localStorage.setItem('activeSection', 'inpatient');
            }
        });

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

        // ── Doctor Modal
        const doctorModal      = document.getElementById('doctorModal');
        const doctorForm       = document.getElementById('doctorForm');
        const doctorMethod     = document.getElementById('doctor_method');
        const doctorModalTitle = document.querySelector('#doctorModal .modal-window h3');
        const doctorModalBtn   = document.getElementById('doctorModalSubmitBtn');
        const doctorBaseUrl    = "{{ url('/doctors') }}";

        const setDoctorFormMode = (mode, doctor = null) => {
            if (mode === 'edit' && doctor) {
                doctorModalTitle.textContent = 'Edit Dokter';
                doctorModalBtn.textContent = 'Perbarui Dokter';
                doctorForm.action = `${doctorBaseUrl}/${doctor.id}`;
                doctorMethod.value = 'PUT';
                document.getElementById('doctor_name').value = doctor.name || '';
                document.getElementById('license_number').value = doctor.license_number || '';
                document.getElementById('specialization').value = doctor.specialization || '';
                document.getElementById('poliklinik_id').value = doctor.poliklinikId || '';
                document.getElementById('doctor_email').value = doctor.email || '';
                document.getElementById('doctor_phone').value = doctor.phone || '';
                document.getElementById('is_active').value = doctor.active || '1';
            } else {
                doctorModalTitle.textContent = 'Tambah Dokter Baru';
                doctorModalBtn.textContent = 'Simpan Dokter';
                doctorForm.action = "{{ route('doctors.store') }}";
                doctorMethod.value = '';
                document.getElementById('doctor_name').value = '';
                document.getElementById('license_number').value = '';
                document.getElementById('specialization').value = '';
                document.getElementById('poliklinik_id').value = '';
                document.getElementById('doctor_email').value = '';
                document.getElementById('doctor_phone').value = '';
                document.getElementById('is_active').value = '1';
                doctorForm.reset();
            }
        };

        const openDoctorModal  = () => { doctorModal.style.display = 'flex'; document.body.style.overflow = 'hidden'; };
        const closeDoctorModal = () => { doctorModal.style.display = 'none'; document.body.style.overflow = ''; };

        document.getElementById('openDoctorModalBtn')?.addEventListener('click', () => { setDoctorFormMode('create'); openDoctorModal(); });
        document.getElementById('closeDoctorModalBtn')?.addEventListener('click', closeDoctorModal);
        document.getElementById('cancelDoctorModalBtn')?.addEventListener('click', closeDoctorModal);
        doctorModal?.addEventListener('click', e => { if (e.target === doctorModal) closeDoctorModal(); });

        document.querySelectorAll('.edit-doctor').forEach(btn => {
            btn.addEventListener('click', function () {
                setDoctorFormMode('edit', {
                    id: this.dataset.id,
                    name: this.dataset.name,
                    license_number: this.dataset.license,
                    specialization: this.dataset.specialization,
                    poliklinikId: this.dataset.poliklinikId,
                    email: this.dataset.email,
                    phone: this.dataset.phone,
                    active: this.dataset.active,
                });
                openDoctorModal();
            });
        });

        document.querySelectorAll('.delete-doctor').forEach(btn => {
            btn.addEventListener('click', function () {
                if (!confirm('Hapus data dokter ini?')) return;
                const f = document.createElement('form');
                f.method = 'POST'; f.action = `${doctorBaseUrl}/${this.dataset.id}`;
                f.innerHTML = `<input type="hidden" name="_token" value="{{ csrf_token() }}"><input type="hidden" name="_method" value="DELETE">`;
                document.body.appendChild(f); f.submit();
            });
        });

        // ── Poliklinik Modal
        const poliklinikModal      = document.getElementById('poliklinikModal');
        const poliklinikForm       = document.getElementById('poliklinikForm');
        const poliklinikMethod     = document.getElementById('poliklinik_method');
        const poliklinikModalTitle = document.querySelector('#poliklinikModal .modal-window h3');
        const poliklinikModalBtn   = document.getElementById('poliklinikModalSubmitBtn');
        const poliklinikBaseUrl    = "{{ url('/polikliniks') }}";

        const setPoliklinikFormMode = (mode, poliklinik = null) => {
            if (mode === 'edit' && poliklinik) {
                poliklinikModalTitle.textContent = 'Edit Poliklinik';
                poliklinikModalBtn.textContent = 'Perbarui Poliklinik';
                poliklinikForm.action = `${poliklinikBaseUrl}/${poliklinik.id}`;
                poliklinikMethod.value = 'PUT';
                document.getElementById('poliklinik_name').value = poliklinik.name || '';
                document.getElementById('poliklinik_description').value = poliklinik.description || '';
                document.getElementById('poliklinik_status').value = poliklinik.status || 'Aktif';
            } else {
                poliklinikModalTitle.textContent = 'Tambah Poliklinik Baru';
                poliklinikModalBtn.textContent = 'Simpan Poliklinik';
                poliklinikForm.action = "{{ route('polikliniks.store') }}";
                poliklinikMethod.value = '';
                document.getElementById('poliklinik_name').value = '';
                document.getElementById('poliklinik_description').value = '';
                document.getElementById('poliklinik_status').value = 'Aktif';
                poliklinikForm.reset();
            }
        };

        const openPoliklinikModal  = () => { poliklinikModal.style.display = 'flex'; document.body.style.overflow = 'hidden'; };
        const closePoliklinikModal = () => { poliklinikModal.style.display = 'none'; document.body.style.overflow = ''; };

        document.getElementById('openPoliklinikModalBtn')?.addEventListener('click', () => { setPoliklinikFormMode('create'); openPoliklinikModal(); });
        document.getElementById('closePoliklinikModalBtn')?.addEventListener('click', closePoliklinikModal);
        document.getElementById('cancelPoliklinikModalBtn')?.addEventListener('click', closePoliklinikModal);
        poliklinikModal?.addEventListener('click', e => { if (e.target === poliklinikModal) closePoliklinikModal(); });

        document.querySelectorAll('.edit-poliklinik').forEach(btn => {
            btn.addEventListener('click', function () {
                setPoliklinikFormMode('edit', {
                    id: this.dataset.id,
                    name: this.dataset.name,
                    description: this.dataset.description,
                    status: this.dataset.status,
                });
                openPoliklinikModal();
            });
        });

        document.querySelectorAll('.delete-poliklinik').forEach(btn => {
            btn.addEventListener('click', function () {
                if (!confirm('Hapus data poliklinik ini?')) return;
                const f = document.createElement('form');
                f.method = 'POST'; f.action = `${poliklinikBaseUrl}/${this.dataset.id}`;
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

        const filterDoctors = () => {
            const q      = document.getElementById('doctorSearch')?.value.trim().toLowerCase() || '';
            const status = document.getElementById('doctorStatusFilter')?.value.toLowerCase() || '';
            document.querySelectorAll('#doctorTableBody tr').forEach(row => {
                const text = Array.from(row.cells).map(c => c.textContent.toLowerCase()).join(' ');
                const rowStatus = row.dataset.status || '';
                const matchQ = !q || text.includes(q);
                const matchS = !status || rowStatus.includes(status);
                row.style.display = (matchQ && matchS) ? '' : 'none';
            });
        };
        document.getElementById('doctorSearchBtn')?.addEventListener('click', filterDoctors);
        document.getElementById('doctorSearch')?.addEventListener('keyup', e => { if(e.key==='Enter') filterDoctors(); });
        document.getElementById('doctorStatusFilter')?.addEventListener('change', filterDoctors);

        const filterPolikliniks = () => {
            const q      = document.getElementById('poliklinikSearch')?.value.trim().toLowerCase() || '';
            const status = document.getElementById('poliklinikStatusFilter')?.value.toLowerCase() || '';
            document.querySelectorAll('#poliklinikTableBody tr').forEach(row => {
                const text = Array.from(row.cells).map(c => c.textContent.toLowerCase()).join(' ');
                const rowStatus = row.dataset.status || '';
                const matchQ = !q || text.includes(q);
                const matchS = !status || rowStatus.includes(status);
                row.style.display = (matchQ && matchS) ? '' : 'none';
            });
        };
        document.getElementById('poliklinikSearchBtn')?.addEventListener('click', filterPolikliniks);
        document.getElementById('poliklinikSearch')?.addEventListener('keyup', e => { if(e.key==='Enter') filterPolikliniks(); });
        document.getElementById('poliklinikStatusFilter')?.addEventListener('change', filterPolikliniks);

        // ── Restore active section from localStorage on first load
        const savedSection = localStorage.getItem('activeSection') || 'dashboard';
        const sectionItem = document.querySelector(`[data-section="${savedSection}"]`);
        if (sectionItem) {
            document.querySelectorAll('.sidebar-item').forEach(s => s.classList.remove('active'));
            sectionItem.classList.add('active');
            document.getElementById('dashboardSection').style.display = savedSection === 'dashboard' ? 'block' : 'none';
            document.getElementById('patientsSection').style.display  = savedSection === 'patients'  ? 'block' : 'none';
            document.getElementById('roomsSection').style.display     = savedSection === 'rooms'     ? 'block' : 'none';
            document.getElementById('doctorsSection').style.display   = savedSection === 'doctors'   ? 'block' : 'none';
            document.getElementById('polikliniksSection').style.display = savedSection === 'polikliniks' ? 'block' : 'none';
            document.getElementById('medicinesSection').style.display = savedSection === 'medicines' ? 'block' : 'none';
            document.getElementById('outpatientSection').style.display = savedSection === 'outpatient' ? 'block' : 'none';
            document.getElementById('inpatientSection').style.display = savedSection === 'inpatient' ? 'block' : 'none';
            document.getElementById('scheduleSection').style.display = savedSection === 'schedule' ? 'block' : 'none';
            document.getElementById('medicalRecordsSection').style.display = savedSection === 'medical-records' ? 'block' : 'none';
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

        // ── Medicine Modal
        const medicineModal      = document.getElementById('medicineModal');
        const medicineForm       = document.getElementById('medicineForm');
        const medicineMethod     = document.getElementById('medicine_method');
        const medicineModalTitle = document.querySelector('#medicineModal .modal-window h3');
        const medicineModalBtn   = document.getElementById('medicineModalSubmitBtn');
        const medicineBaseUrl    = "{{ url('/medicines') }}";

        const setMedicineFormMode = (mode, medicine = null) => {
            if (mode === 'edit' && medicine) {
                medicineModalTitle.textContent = 'Edit Obat';
                medicineModalBtn.textContent = 'Perbarui Obat';
                medicineForm.action = `${medicineBaseUrl}/${medicine.id}`;
                medicineMethod.value = 'PUT';
                document.getElementById('medicine_name').value = medicine.name || '';
                document.getElementById('medicine_code').value = medicine.code || '';
                document.getElementById('medicine_stock').value = medicine.stock || 0;
                document.getElementById('medicine_minimum_stock').value = medicine.minimumStock || 10;
                document.getElementById('medicine_unit').value = medicine.unit || '';
                document.getElementById('medicine_price').value = medicine.price || 0;
                document.getElementById('medicine_description').value = medicine.description || '';
                document.getElementById('medicine_is_active').value = medicine.active || '1';
            } else {
                medicineModalTitle.textContent = 'Tambah Obat Baru';
                medicineModalBtn.textContent = 'Simpan Obat';
                medicineForm.action = "{{ route('medicines.store') }}";
                medicineMethod.value = '';
                document.getElementById('medicine_name').value = '';
                document.getElementById('medicine_code').value = '';
                document.getElementById('medicine_stock').value = 0;
                document.getElementById('medicine_minimum_stock').value = 10;
                document.getElementById('medicine_unit').value = '';
                document.getElementById('medicine_price').value = 0;
                document.getElementById('medicine_description').value = '';
                document.getElementById('medicine_is_active').value = '1';
                medicineForm.reset();
            }
        };

        const openMedicineModal  = () => { medicineModal.style.display = 'flex'; document.body.style.overflow = 'hidden'; };
        const closeMedicineModal = () => { medicineModal.style.display = 'none'; document.body.style.overflow = ''; };

        document.getElementById('openMedicineModalBtn')?.addEventListener('click', () => { setMedicineFormMode('create'); openMedicineModal(); });
        document.getElementById('closeMedicineModalBtn')?.addEventListener('click', closeMedicineModal);
        document.getElementById('cancelMedicineModalBtn')?.addEventListener('click', closeMedicineModal);
        medicineModal?.addEventListener('click', e => { if (e.target === medicineModal) closeMedicineModal(); });

        // ── Medicine View Modal
        const medicineViewModal = document.getElementById('medicineViewModal');
        document.getElementById('closeMedicineViewModalBtn')?.addEventListener('click', () => { medicineViewModal.style.display='none'; document.body.style.overflow=''; });
        medicineViewModal?.addEventListener('click', e => { if (e.target === medicineViewModal) { medicineViewModal.style.display='none'; document.body.style.overflow=''; } });

        document.querySelectorAll('.view-medicine').forEach(btn => {
            btn.addEventListener('click', function () {
                document.getElementById('view_medicine_name').textContent = this.dataset.name || '-';
                document.getElementById('view_medicine_code').textContent = this.dataset.code || '-';
                document.getElementById('view_medicine_stock').textContent = this.dataset.stock || '-';
                document.getElementById('view_medicine_minimum_stock').textContent = this.dataset.minimumStock || '-';
                document.getElementById('view_medicine_unit').textContent = this.dataset.unit || '-';
                document.getElementById('view_medicine_price').textContent = this.dataset.price ? `Rp ${Number(this.dataset.price).toLocaleString('id-ID')}` : '-';
                document.getElementById('view_medicine_description').textContent = this.dataset.description || '-';
                document.getElementById('view_medicine_status').textContent = this.dataset.active === '1' ? 'Aktif' : 'Nonaktif';
                medicineViewModal.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            });
        });

        document.querySelectorAll('.edit-medicine').forEach(btn => {
            btn.addEventListener('click', function () {
                setMedicineFormMode('edit', {
                    id: this.dataset.id,
                    name: this.dataset.name,
                    code: this.dataset.code,
                    stock: this.dataset.stock,
                    minimumStock: this.dataset.minimumStock,
                    unit: this.dataset.unit,
                    price: this.dataset.price,
                    description: this.dataset.description,
                    active: this.dataset.active,
                });
                openMedicineModal();
            });
        });

        document.querySelectorAll('.delete-medicine').forEach(btn => {
            btn.addEventListener('click', function () {
                if (!confirm('Hapus data obat ini?')) return;
                const f = document.createElement('form');
                f.method = 'POST'; f.action = `${medicineBaseUrl}/${this.dataset.id}`;
                f.innerHTML = `<input type="hidden" name="_token" value="{{ csrf_token() }}"><input type="hidden" name="_method" value="DELETE">`;
                document.body.appendChild(f); f.submit();
            });
        });

        const filterMedicines = () => {
            const q      = document.getElementById('medicineSearch')?.value.trim().toLowerCase() || '';
            const status = document.getElementById('medicineStatusFilter')?.value.toLowerCase() || '';
            document.querySelectorAll('#medicineTableBody tr').forEach(row => {
                const text = Array.from(row.cells).map(c => c.textContent.toLowerCase()).join(' ');
                const rowStatus = row.dataset.status || '';
                const matchQ = !q || text.includes(q);
                const matchS = !status || rowStatus.includes(status);
                row.style.display = (matchQ && matchS) ? '' : 'none';
            });
        };
        document.getElementById('medicineSearchBtn')?.addEventListener('click', filterMedicines);
        document.getElementById('medicineSearch')?.addEventListener('keyup', e => { if(e.key==='Enter') filterMedicines(); });
        document.getElementById('medicineStatusFilter')?.addEventListener('change', filterMedicines);

        // ── Outpatient Modal
        const outpatientModal      = document.getElementById('outpatientModal');
        const outpatientForm       = document.getElementById('outpatientForm');
        const outpatientMethod     = document.getElementById('outpatient_method');
        const outpatientModalTitle = document.querySelector('#outpatientModal .modal-window h3');
        const outpatientModalBtn   = document.getElementById('outpatientModalSubmitBtn');
        const outpatientBaseUrl    = "{{ url('/admissions') }}";

        const setOutpatientFormMode = (mode, outpatient = null) => {
            if (mode === 'edit' && outpatient) {
                outpatientModalTitle.textContent = 'Edit Antrian Rawat Jalan';
                outpatientModalBtn.textContent = 'Perbarui Antrian';
                outpatientForm.action = `${outpatientBaseUrl}/${outpatient.id}`;
                outpatientMethod.value = 'PUT';
                document.getElementById('outpatient_patient_id').value = outpatient.patientId || '';
                document.getElementById('outpatient_doctor_id').value = outpatient.doctorId || '';
                document.getElementById('outpatient_poliklinik_id').value = outpatient.poliklinikId || '';
                document.getElementById('outpatient_clinic').value = outpatient.clinic || '';
                document.getElementById('outpatient_admission_date').value = outpatient.admissionDate || '';
                document.getElementById('outpatient_status').value = outpatient.status || 'menunggu';
                document.getElementById('outpatient_complaints').value = outpatient.complaints || '';
            } else {
                outpatientModalTitle.textContent = 'Tambah Antrian Rawat Jalan';
                outpatientModalBtn.textContent = 'Simpan Antrian';
                outpatientForm.action = "{{ route('admissions.store') }}";
                outpatientMethod.value = '';
                document.getElementById('outpatient_patient_id').value = '';
                document.getElementById('outpatient_doctor_id').value = '';
                document.getElementById('outpatient_poliklinik_id').value = '';
                document.getElementById('outpatient_clinic').value = '';
                const now = new Date();
                const pad = n => n.toString().padStart(2, '0');
                document.getElementById('outpatient_admission_date').value = `${now.getFullYear()}-${pad(now.getMonth()+1)}-${pad(now.getDate())} ${pad(now.getHours())}:${pad(now.getMinutes())}:${pad(now.getSeconds())}`;
                document.getElementById('outpatient_status').value = 'menunggu';
                document.getElementById('outpatient_complaints').value = '';
                outpatientForm.reset();
            }
        };

        const openOutpatientModal  = () => { outpatientModal.style.display = 'flex'; document.body.style.overflow = 'hidden'; };
        const closeOutpatientModal = () => { outpatientModal.style.display = 'none'; document.body.style.overflow = ''; };

        // Sync clinic hidden field with selected poliklinik text
        const outpatientPoliklinikSelect = document.getElementById('outpatient_poliklinik_id');
        const outpatientClinicInput = document.getElementById('outpatient_clinic');
        if (outpatientPoliklinikSelect && outpatientClinicInput) {
            outpatientPoliklinikSelect.addEventListener('change', function () {
                const selectedOption = this.options[this.selectedIndex];
                outpatientClinicInput.value = selectedOption.textContent.trim();
            });
        }

        document.getElementById('openOutpatientModalBtn')?.addEventListener('click', () => { setOutpatientFormMode('create'); openOutpatientModal(); });
        document.getElementById('closeOutpatientModalBtn')?.addEventListener('click', closeOutpatientModal);
        document.getElementById('cancelOutpatientModalBtn')?.addEventListener('click', closeOutpatientModal);
        outpatientModal?.addEventListener('click', e => { if (e.target === outpatientModal) closeOutpatientModal(); });

        // ── Outpatient View Modal
        const outpatientViewModal = document.getElementById('outpatientViewModal');
        document.getElementById('closeOutpatientViewModalBtn')?.addEventListener('click', () => { outpatientViewModal.style.display='none'; document.body.style.overflow=''; });
        outpatientViewModal?.addEventListener('click', e => { if (e.target === outpatientViewModal) { outpatientViewModal.style.display='none'; document.body.style.overflow=''; } });

        document.querySelectorAll('.view-outpatient').forEach(btn => {
            btn.addEventListener('click', function () {
                document.getElementById('view_outpatient_reg').textContent = this.dataset.reg || '-';
                document.getElementById('view_outpatient_patient').textContent = this.dataset.patient || '-';
                document.getElementById('view_outpatient_poliklinik').textContent = this.dataset.poliklinik || '-';
                document.getElementById('view_outpatient_doctor').textContent = this.dataset.doctor || '-';
                document.getElementById('view_outpatient_complaints').textContent = this.dataset.complaints || '-';
                document.getElementById('view_outpatient_date').textContent = this.dataset.date ? new Date(this.dataset.date).toLocaleDateString('id-ID', {day:'numeric', month:'long', year:'numeric'}) : '-';
                const statusMap = { 'menunggu': 'Menunggu', 'diperiksa': 'Diperiksa', 'selesai': 'Selesai' };
                document.getElementById('view_outpatient_status').textContent = statusMap[this.dataset.status] || this.dataset.status || '-';
                outpatientViewModal.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            });
        });

        document.querySelectorAll('.edit-outpatient').forEach(btn => {
            btn.addEventListener('click', function () {
                setOutpatientFormMode('edit', {
                    id: this.dataset.id,
                    patientId: this.dataset.patientId,
                    doctorId: this.dataset.doctorId,
                    poliklinikId: this.dataset.poliklinikId,
                    clinic: this.dataset.clinic,
                    admissionDate: this.dataset.admissionDate,
                    complaints: this.dataset.complaints,
                    status: this.dataset.status,
                });
                openOutpatientModal();
            });
        });

        document.querySelectorAll('.delete-outpatient').forEach(btn => {
            btn.addEventListener('click', function () {
                if (!confirm('Hapus data antrian ini?')) return;
                const f = document.createElement('form');
                f.method = 'POST'; f.action = `${outpatientBaseUrl}/${this.dataset.id}`;
                f.innerHTML = `<input type="hidden" name="_token" value="{{ csrf_token() }}"><input type="hidden" name="_method" value="DELETE">`;
                document.body.appendChild(f); f.submit();
            });
        });

        const filterOutpatients = () => {
            const q      = document.getElementById('outpatientSearch')?.value.trim().toLowerCase() || '';
            const status = document.getElementById('outpatientStatusFilter')?.value.toLowerCase() || '';
            const date   = document.getElementById('outpatientDateFilter')?.value || '';
            document.querySelectorAll('#outpatientTableBody tr').forEach(row => {
                const text = Array.from(row.cells).map(c => c.textContent.toLowerCase()).join(' ');
                const rowStatus = row.dataset.status || '';
                const matchQ = !q || text.includes(q);
                const matchS = !status || rowStatus.includes(status);
                row.style.display = (matchQ && matchS) ? '' : 'none';
            });
        };
        document.getElementById('outpatientSearchBtn')?.addEventListener('click', filterOutpatients);
        document.getElementById('outpatientSearch')?.addEventListener('keyup', e => { if(e.key==='Enter') filterOutpatients(); });
        document.getElementById('outpatientStatusFilter')?.addEventListener('change', filterOutpatients);
        document.getElementById('outpatientDateFilter')?.addEventListener('change', filterOutpatients);

        // ── Inpatient Modal
        const inpatientModal      = document.getElementById('inpatientModal');
        const inpatientForm       = document.getElementById('inpatientForm');
        const inpatientMethod     = document.getElementById('inpatient_method');
        const inpatientModalTitle = document.querySelector('#inpatientModal .modal-window h3');
        const inpatientModalBtn   = document.getElementById('inpatientModalSubmitBtn');
        const inpatientBaseUrl    = "{{ url('/admissions') }}";

        const setInpatientFormMode = (mode, inpatient = null) => {
            if (mode === 'edit' && inpatient) {
                inpatientModalTitle.textContent = 'Edit Rawat Inap';
                inpatientModalBtn.textContent = 'Perbarui Rawat Inap';
                inpatientForm.action = `${inpatientBaseUrl}/${inpatient.id}`;
                inpatientMethod.value = 'PUT';
                document.getElementById('inpatient_patient_id').value = inpatient.patientId || '';
                document.getElementById('inpatient_doctor_id').value = inpatient.doctorId || '';
                document.getElementById('inpatient_room_id').value = inpatient.roomId || '';
                document.getElementById('inpatient_status').value = inpatient.status || 'menunggu';
                document.getElementById('inpatient_admission_date').value = inpatient.admissionDate || '';
                document.getElementById('inpatient_discharge_date').value = inpatient.dischargeDate || '';
            } else {
                inpatientModalTitle.textContent = 'Tambah Rawat Inap';
                inpatientModalBtn.textContent = 'Simpan Rawat Inap';
                inpatientForm.action = "{{ route('admissions.store') }}";
                inpatientMethod.value = '';
                document.getElementById('inpatient_patient_id').value = '';
                document.getElementById('inpatient_doctor_id').value = '';
                document.getElementById('inpatient_room_id').value = '';
                document.getElementById('inpatient_status').value = 'menunggu';
                const now = new Date();
                const pad = n => n.toString().padStart(2, '0');
                document.getElementById('inpatient_admission_date').value = `${now.getFullYear()}-${pad(now.getMonth()+1)}-${pad(now.getDate())}T${pad(now.getHours())}:${pad(now.getMinutes())}`;
                document.getElementById('inpatient_discharge_date').value = '';
                inpatientForm.reset();
            }
        };

        const openInpatientModal  = () => { inpatientModal.style.display = 'flex'; document.body.style.overflow = 'hidden'; };
        const closeInpatientModal = () => { inpatientModal.style.display = 'none'; document.body.style.overflow = ''; };

        document.getElementById('openInpatientModalBtn')?.addEventListener('click', () => { setInpatientFormMode('create'); openInpatientModal(); });
        document.getElementById('closeInpatientModalBtn')?.addEventListener('click', closeInpatientModal);
        document.getElementById('cancelInpatientModalBtn')?.addEventListener('click', closeInpatientModal);
        inpatientModal?.addEventListener('click', e => { if (e.target === inpatientModal) closeInpatientModal(); });

        // ── Inpatient View Modal
        const inpatientViewModal = document.getElementById('inpatientViewModal');
        document.getElementById('closeInpatientViewModalBtn')?.addEventListener('click', () => { inpatientViewModal.style.display='none'; document.body.style.overflow=''; });
        inpatientViewModal?.addEventListener('click', e => { if (e.target === inpatientViewModal) { inpatientViewModal.style.display='none'; document.body.style.overflow=''; } });

        document.querySelectorAll('.view-inpatient').forEach(btn => {
            btn.addEventListener('click', function () {
                document.getElementById('view_inpatient_reg').textContent = this.dataset.reg || '-';
                document.getElementById('view_inpatient_patient').textContent = this.dataset.patient || '-';
                document.getElementById('view_inpatient_rm').textContent = this.dataset.rm || '-';
                document.getElementById('view_inpatient_doctor').textContent = this.dataset.doctor || '-';
                document.getElementById('view_inpatient_room').textContent = this.dataset.room || '-';
                document.getElementById('view_inpatient_room_type').textContent = this.dataset.roomType || '-';
                document.getElementById('view_inpatient_admission_date').textContent = this.dataset.admissionDate ? new Date(this.dataset.admissionDate).toLocaleDateString('id-ID', {day:'numeric', month:'long', year:'numeric', hour:'2-digit', minute:'2-digit'}) : '-';
                document.getElementById('view_inpatient_discharge_date').textContent = this.dataset.dischargeDate ? new Date(this.dataset.dischargeDate).toLocaleDateString('id-ID', {day:'numeric', month:'long', year:'numeric', hour:'2-digit', minute:'2-digit'}) : '—';
                const statusMap = { 'menunggu': 'Menunggu', 'dirawat': 'Dirawat', 'sedang dirawat': 'Dirawat', 'selesai': 'Selesai' };
                document.getElementById('view_inpatient_status').textContent = statusMap[this.dataset.status] || this.dataset.status || '-';
                inpatientViewModal.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            });
        });

        document.querySelectorAll('.edit-inpatient').forEach(btn => {
            btn.addEventListener('click', function () {
                setInpatientFormMode('edit', {
                    id: this.dataset.id,
                    patientId: this.dataset.patientId,
                    doctorId: this.dataset.doctorId,
                    roomId: this.dataset.roomId,
                    admissionDate: this.dataset.admissionDate ? this.dataset.admissionDate.slice(0,16) : '',
                    dischargeDate: this.dataset.dischargeDate ? this.dataset.dischargeDate.slice(0,16) : '',
                    status: this.dataset.status,
                });
                openInpatientModal();
            });
        });

        document.querySelectorAll('.delete-inpatient').forEach(btn => {
            btn.addEventListener('click', function () {
                if (!confirm('Hapus data rawat inap ini?')) return;
                const f = document.createElement('form');
                f.method = 'POST'; f.action = `${inpatientBaseUrl}/${this.dataset.id}`;
                f.innerHTML = `<input type="hidden" name="_token" value="{{ csrf_token() }}"><input type="hidden" name="_method" value="DELETE">`;
                document.body.appendChild(f); f.submit();
            });
        });

        const filterInpatients = () => {
            const q      = document.getElementById('inpatientSearch')?.value.trim().toLowerCase() || '';
            const status = document.getElementById('inpatientStatusFilter')?.value.toLowerCase() || '';
            const date   = document.getElementById('inpatientDateFilter')?.value || '';
            document.querySelectorAll('#inpatientTableBody tr').forEach(row => {
                const text = Array.from(row.cells).map(c => c.textContent.toLowerCase()).join(' ');
                const rowStatus = row.dataset.status || '';
                const rowDate = row.dataset.date || '';
                const matchQ = !q || text.includes(q);
                const matchS = !status || rowStatus.includes(status) || (status === 'dirawat' && rowStatus === 'sedang dirawat');
                const matchD = !date || rowDate === date;
                row.style.display = (matchQ && matchS && matchD) ? '' : 'none';
            });
        };
        document.getElementById('inpatientSearchBtn')?.addEventListener('click', filterInpatients);
        document.getElementById('inpatientSearch')?.addEventListener('keyup', e => { if(e.key==='Enter') filterInpatients(); });
        document.getElementById('inpatientStatusFilter')?.addEventListener('change', filterInpatients);
        document.getElementById('inpatientDateFilter')?.addEventListener('change', filterInpatients);

        // ── Old data restore & error handling for inpatient
        @if (old('form_type') === 'inpatient')
            document.querySelector('[data-section="inpatient"]').click();
            setInpatientFormMode('create');
            openInpatientModal();
        @endif

        // ── Calendar / Schedule
        const scheduleData = @json($scheduleAdmissions);
        let currentCalendarDate = new Date();
        let selectedCalendarDate = null;

        const monthNames = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];

        function renderCalendar(date) {
            const year = date.getFullYear();
            const month = date.getMonth();
            const firstDay = new Date(year, month, 1).getDay();
            const daysInMonth = new Date(year, month + 1, 0).getDate();
            const daysInPrevMonth = new Date(year, month, 0).getDate();

            document.getElementById('calendarMonthYear').textContent = `${monthNames[month]} ${year}`;

            const grid = document.getElementById('calendarGrid');
            // Keep headers
            grid.innerHTML = `
                <div class="calendar-day-header">Min</div>
                <div class="calendar-day-header">Sen</div>
                <div class="calendar-day-header">Sel</div>
                <div class="calendar-day-header">Rab</div>
                <div class="calendar-day-header">Kam</div>
                <div class="calendar-day-header">Jum</div>
                <div class="calendar-day-header">Sab</div>
            `;

            // Previous month days
            for (let i = firstDay - 1; i >= 0; i--) {
                const dayNum = daysInPrevMonth - i;
                const cell = document.createElement('div');
                cell.className = 'calendar-day other-month';
                cell.innerHTML = `<span class="calendar-day-number">${dayNum}</span>`;
                grid.appendChild(cell);
            }

            // Current month days
            const today = new Date();
            for (let day = 1; day <= daysInMonth; day++) {
                const dateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                const isToday = today.getFullYear() === year && today.getMonth() === month && today.getDate() === day;
                const isSelected = selectedCalendarDate === dateStr;

                const cell = document.createElement('div');
                cell.className = 'calendar-day' + (isToday ? ' today' : '') + (isSelected ? ' selected' : '');
                cell.dataset.date = dateStr;

                let dotsHtml = '';
                let countHtml = '';
                const admissions = scheduleData[dateStr];
                if (admissions && admissions.length > 0) {
                    const outpatientCount = admissions.filter(a => a.admission_type === 'Rawat Jalan').length;
                    const inpatientCount = admissions.filter(a => a.admission_type === 'Rawat Inap').length;
                    const dots = [];
                    if (outpatientCount > 0) dots.push('<span class="calendar-dot outpatient"></span>');
                    if (inpatientCount > 0) dots.push('<span class="calendar-dot inpatient"></span>');
                    dotsHtml = `<div class="calendar-day-dots">${dots.join('')}</div>`;
                    if (admissions.length > 2) {
                        countHtml = `<span class="calendar-day-count">+${admissions.length}</span>`;
                    }
                }

                cell.innerHTML = `<span class="calendar-day-number">${day}</span>${dotsHtml}${countHtml}`;
                cell.addEventListener('click', () => selectCalendarDate(dateStr));
                grid.appendChild(cell);
            }

            // Next month days to fill grid
            const totalCells = firstDay + daysInMonth;
            const remaining = (7 - (totalCells % 7)) % 7;
            for (let day = 1; day <= remaining; day++) {
                const cell = document.createElement('div');
                cell.className = 'calendar-day other-month';
                cell.innerHTML = `<span class="calendar-day-number">${day}</span>`;
                grid.appendChild(cell);
            }
        }

        function selectCalendarDate(dateStr) {
            selectedCalendarDate = dateStr;
            renderCalendar(currentCalendarDate);

            const [y, m, d] = dateStr.split('-');
            const dateObj = new Date(y, m - 1, d);
            const dayNames = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
            const monthNamesShort = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
            document.getElementById('selectedDateLabel').textContent = `${dayNames[dateObj.getDay()]}, ${d} ${monthNamesShort[m-1]} ${y}`;

            const admissions = scheduleData[dateStr] || [];
            const list = document.getElementById('selectedDateList');

            if (admissions.length === 0) {
                list.innerHTML = `
                    <div class="empty-state" style="padding:30px 10px;">
                        <div class="empty-state-icon" style="width:48px; height:48px; font-size:20px;">📅</div>
                        <h4 style="font-size:14px;">Tidak Ada Pasien</h4>
                        <p style="font-size:12px;">Tidak ada pasien masuk pada tanggal ini.</p>
                    </div>
                `;
                return;
            }

            list.innerHTML = admissions.map(a => {
                const isOutpatient = a.admission_type === 'Rawat Jalan';
                const typeClass = isOutpatient ? 'outpatient' : 'inpatient';
                const typeLabel = isOutpatient ? 'Rawat Jalan' : 'Rawat Inap';
                const patientName = a.patient?.name || 'Pasien tidak ditemukan';
                const doctorName = a.doctor?.name || '-';
                const time = a.admission_date ? new Date(a.admission_date).toLocaleTimeString('id-ID', {hour:'2-digit', minute:'2-digit'}) : '-';
                const initial = patientName.charAt(0).toUpperCase();
                const avatarBg = isOutpatient ? '#FEF3C7' : '#F5F3FF';
                const avatarColor = isOutpatient ? '#92400E' : '#6D28D9';

                return `
                    <div class="schedule-item">
                        <div class="schedule-item-avatar" style="background:${avatarBg}; color:${avatarColor};">${initial}</div>
                        <div class="schedule-item-info">
                            <div class="schedule-item-name">${patientName}</div>
                            <div class="schedule-item-meta">${doctorName} &bull; ${time}</div>
                        </div>
                        <span class="schedule-item-type ${typeClass}">${typeLabel}</span>
                    </div>
                `;
            }).join('');
        }

        document.getElementById('prevMonthBtn')?.addEventListener('click', () => {
            currentCalendarDate.setMonth(currentCalendarDate.getMonth() - 1);
            renderCalendar(currentCalendarDate);
        });

        document.getElementById('nextMonthBtn')?.addEventListener('click', () => {
            currentCalendarDate.setMonth(currentCalendarDate.getMonth() + 1);
            renderCalendar(currentCalendarDate);
        });

        document.getElementById('todayBtn')?.addEventListener('click', () => {
            currentCalendarDate = new Date();
            const todayStr = `${currentCalendarDate.getFullYear()}-${String(currentCalendarDate.getMonth()+1).padStart(2,'0')}-${String(currentCalendarDate.getDate()).padStart(2,'0')}`;
            selectCalendarDate(todayStr);
        });

        // Initial render
        renderCalendar(currentCalendarDate);

        // ── Medical Records Modal
        const medicalRecordViewModal = document.getElementById('medicalRecordViewModal');
        const medicalRecordEditModal = document.getElementById('medicalRecordEditModal');
        const medicalRecordEditForm = document.getElementById('medicalRecordEditForm');
        const medicalRecordBaseUrl = "{{ url('/medical-records') }}";

        document.getElementById('closeMedicalRecordViewModalBtn')?.addEventListener('click', () => { medicalRecordViewModal.style.display='none'; document.body.style.overflow=''; });
        medicalRecordViewModal?.addEventListener('click', e => { if (e.target === medicalRecordViewModal) { medicalRecordViewModal.style.display='none'; document.body.style.overflow=''; } });

        document.getElementById('closeMedicalRecordEditModalBtn')?.addEventListener('click', () => { medicalRecordEditModal.style.display='none'; document.body.style.overflow=''; });
        document.getElementById('cancelMedicalRecordEditModalBtn')?.addEventListener('click', () => { medicalRecordEditModal.style.display='none'; document.body.style.overflow=''; });
        medicalRecordEditModal?.addEventListener('click', e => { if (e.target === medicalRecordEditModal) { medicalRecordEditModal.style.display='none'; document.body.style.overflow=''; } });

        document.querySelectorAll('.view-medical-record').forEach(btn => {
            btn.addEventListener('click', function () {
                document.getElementById('view_mr_record_number').textContent = this.dataset.recordNumber || '-';
                document.getElementById('view_mr_patient').textContent = this.dataset.patient || '-';
                document.getElementById('view_mr_rm').textContent = this.dataset.rm || '-';
                document.getElementById('view_mr_doctor').textContent = this.dataset.doctor || '-';
                document.getElementById('view_mr_type').textContent = this.dataset.type || '-';
                document.getElementById('view_mr_diagnosis').textContent = this.dataset.diagnosis || '-';
                document.getElementById('view_mr_icd_code').textContent = this.dataset.icdCode || '-';
                document.getElementById('view_mr_icd_description').textContent = this.dataset.icdDescription || '-';
                document.getElementById('view_mr_completed_at').textContent = this.dataset.completedAt ? new Date(this.dataset.completedAt).toLocaleDateString('id-ID', {day:'numeric', month:'long', year:'numeric', hour:'2-digit', minute:'2-digit'}) : '-';
                medicalRecordViewModal.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            });
        });

        document.querySelectorAll('.edit-medical-record').forEach(btn => {
            btn.addEventListener('click', function () {
                const id = this.dataset.id;
                medicalRecordEditForm.action = `${medicalRecordBaseUrl}/${id}`;
                document.getElementById('medical_record_method').value = 'PUT';
                document.getElementById('medical_record_diagnosis').value = this.dataset.diagnosis || '';
                document.getElementById('medical_record_icd_code').value = this.dataset.icdCode || '';
                document.getElementById('medical_record_icd_description').value = this.dataset.icdDescription || '';
                document.querySelector('#medicalRecordEditModal .modal-window h3').textContent = 'Edit Rekam Medis';
                document.getElementById('medicalRecordEditModalSubmitBtn').textContent = 'Simpan Perubahan';
                medicalRecordEditModal.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            });
        });

        document.querySelectorAll('.delete-medical-record').forEach(btn => {
            btn.addEventListener('click', function () {
                if (!confirm('Hapus rekam medis ini?')) return;
                const f = document.createElement('form');
                f.method = 'POST'; f.action = `${medicalRecordBaseUrl}/${this.dataset.id}`;
                f.innerHTML = `<input type="hidden" name="_token" value="{{ csrf_token() }}"><input type="hidden" name="_method" value="DELETE">`;
                document.body.appendChild(f); f.submit();
            });
        });

        const filterMedicalRecords = () => {
            const q = document.getElementById('medicalRecordSearch')?.value.trim().toLowerCase() || '';
            const type = document.getElementById('medicalRecordTypeFilter')?.value.toLowerCase() || '';
            const date = document.getElementById('medicalRecordDateFilter')?.value || '';
            document.querySelectorAll('#medicalRecordTableBody tr').forEach(row => {
                const text = Array.from(row.cells).map(c => c.textContent.toLowerCase()).join(' ');
                const rowType = row.dataset.type || '';
                const rowDate = row.dataset.date || '';
                const matchQ = !q || text.includes(q);
                const matchT = !type || rowType.includes(type);
                const matchD = !date || rowDate === date;
                row.style.display = (matchQ && matchT && matchD) ? '' : 'none';
            });
        };
        document.getElementById('medicalRecordSearchBtn')?.addEventListener('click', filterMedicalRecords);
        document.getElementById('medicalRecordSearch')?.addEventListener('keyup', e => { if(e.key==='Enter') filterMedicalRecords(); });
        document.getElementById('medicalRecordTypeFilter')?.addEventListener('change', filterMedicalRecords);
        document.getElementById('medicalRecordDateFilter')?.addEventListener('change', filterMedicalRecords);

        // ── Old data restore & error handling for medical records
        @if (old('form_type') === 'medical_record')
            document.querySelector('[data-section="medical-records"]').click();
            medicalRecordEditModal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
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
