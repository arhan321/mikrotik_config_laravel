<x-filament-panels::page>
    <style>
        .mik-ip-page {
            --mik-bg: #050816;
            --mik-card: rgba(15, 23, 42, .82);
            --mik-card-2: rgba(2, 6, 23, .88);
            --mik-border: rgba(148, 163, 184, .16);
            --mik-border-strong: rgba(96, 165, 250, .38);
            --mik-text: #f8fafc;
            --mik-muted: #94a3b8;
            --mik-muted-2: #64748b;
            --mik-blue: #38bdf8;
            --mik-blue-2: #2563eb;
            --mik-green: #34d399;
            --mik-yellow: #f59e0b;
            --mik-red: #fb7185;
            --mik-purple: #a78bfa;
            color: var(--mik-text);
        }

        .mik-ip-page * {
            box-sizing: border-box;
        }

        .mik-ip-shell {
            position: relative;
            overflow: hidden;
            border-radius: 28px;
            border: 1px solid var(--mik-border);
            background:
                radial-gradient(circle at top left, rgba(56, 189, 248, .24), transparent 34%),
                radial-gradient(circle at 85% 15%, rgba(167, 139, 250, .18), transparent 30%),
                radial-gradient(circle at 55% 90%, rgba(52, 211, 153, .12), transparent 28%),
                linear-gradient(135deg, rgba(15, 23, 42, .96), rgba(2, 6, 23, .98));
            box-shadow: 0 24px 70px rgba(0, 0, 0, .45);
            padding: 28px;
        }

        .mik-ip-shell::before {
            content: '';
            position: absolute;
            inset: 0;
            pointer-events: none;
            background-image:
                linear-gradient(rgba(255,255,255,.035) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,.035) 1px, transparent 1px);
            background-size: 42px 42px;
            mask-image: linear-gradient(to bottom, black, transparent 85%);
        }

        .mik-ip-hero {
            position: relative;
            display: grid;
            grid-template-columns: 1.5fr .9fr;
            gap: 24px;
            align-items: center;
            margin-bottom: 22px;
        }

        .mik-ip-kicker {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            padding: 8px 12px;
            border-radius: 999px;
            border: 1px solid rgba(56, 189, 248, .28);
            background: rgba(14, 165, 233, .12);
            color: #bae6fd;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: .05em;
            text-transform: uppercase;
        }

        .mik-ip-dot {
            width: 9px;
            height: 9px;
            border-radius: 999px;
            background: var(--mik-green);
            box-shadow: 0 0 18px rgba(52, 211, 153, .95);
        }

        .mik-ip-title {
            margin: 14px 0 0;
            font-size: clamp(28px, 3vw, 42px);
            line-height: 1;
            font-weight: 950;
            letter-spacing: -.055em;
            color: #ffffff;
        }

        .mik-ip-subtitle {
            margin-top: 12px;
            max-width: 720px;
            color: #cbd5e1;
            font-size: 14px;
            line-height: 1.75;
        }

        .mik-ip-hero-metrics {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
        }

        .mik-ip-metric {
            border: 1px solid rgba(255, 255, 255, .12);
            background: rgba(255, 255, 255, .075);
            backdrop-filter: blur(14px);
            border-radius: 22px;
            padding: 18px 14px;
            text-align: center;
            box-shadow: inset 0 1px 0 rgba(255,255,255,.08);
        }

        .mik-ip-metric-value {
            font-size: 30px;
            line-height: 1;
            font-weight: 950;
            color: #fff;
        }

        .mik-ip-metric-label {
            margin-top: 7px;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: .05em;
            text-transform: uppercase;
            color: #94a3b8;
        }

        .mik-ip-grid {
            display: grid;
            grid-template-columns: 390px minmax(0, 1fr);
            gap: 18px;
            align-items: start;
        }

        .mik-ip-card {
            overflow: hidden;
            border-radius: 24px;
            border: 1px solid var(--mik-border);
            background: var(--mik-card);
            box-shadow: 0 18px 45px rgba(0, 0, 0, .28);
        }

        .mik-ip-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            padding: 18px 20px;
            border-bottom: 1px solid var(--mik-border);
            background: linear-gradient(135deg, rgba(15,23,42,.92), rgba(2,6,23,.8));
        }

        .mik-ip-card-title-wrap {
            display: flex;
            align-items: center;
            gap: 13px;
            min-width: 0;
        }

        .mik-ip-icon {
            display: inline-flex;
            width: 42px;
            height: 42px;
            flex: 0 0 42px;
            align-items: center;
            justify-content: center;
            border-radius: 16px;
            border: 1px solid rgba(56, 189, 248, .22);
            background: rgba(56, 189, 248, .12);
            color: #7dd3fc;
        }

        .mik-ip-icon svg {
            width: 22px;
            height: 22px;
        }

        .mik-ip-card-title {
            margin: 0;
            color: #fff;
            font-size: 16px;
            font-weight: 900;
            letter-spacing: -.02em;
        }

        .mik-ip-card-desc {
            margin: 3px 0 0;
            color: var(--mik-muted);
            font-size: 12.5px;
            line-height: 1.45;
        }

        .mik-ip-card-body {
            padding: 20px;
        }

        .mik-ip-selector-row {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 180px;
            gap: 12px;
            align-items: end;
        }

        .mik-ip-label {
            display: block;
            margin-bottom: 8px;
            color: #cbd5e1;
            font-size: 12px;
            font-weight: 850;
            letter-spacing: .05em;
            text-transform: uppercase;
        }

        .mik-ip-input,
        .mik-ip-select {
            width: 100%;
            min-height: 46px;
            border-radius: 16px;
            border: 1px solid rgba(148, 163, 184, .18);
            background: rgba(2, 6, 23, .76) !important;
            color: #f8fafc !important;
            padding: 0 14px;
            outline: none;
            font-size: 14px;
            box-shadow: inset 0 1px 0 rgba(255,255,255,.05);
            transition: border-color .15s ease, box-shadow .15s ease, transform .15s ease;
        }

        .mik-ip-select option {
            background: #020617;
            color: #f8fafc;
        }

        .mik-ip-input::placeholder {
            color: #64748b;
        }

        .mik-ip-input:focus,
        .mik-ip-select:focus {
            border-color: rgba(56, 189, 248, .78);
            box-shadow: 0 0 0 4px rgba(56, 189, 248, .13), inset 0 1px 0 rgba(255,255,255,.05);
        }

        .mik-ip-form-stack {
            display: grid;
            gap: 16px;
        }

        .mik-ip-btn {
            width: 100%;
            min-height: 46px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            border: 0;
            border-radius: 16px;
            color: #fff;
            font-weight: 900;
            cursor: pointer;
            background: linear-gradient(135deg, #0284c7, #2563eb 55%, #4f46e5);
            box-shadow: 0 16px 34px rgba(37, 99, 235, .28);
            transition: transform .15s ease, filter .15s ease, box-shadow .15s ease;
        }

        .mik-ip-btn:hover {
            filter: brightness(1.08);
            transform: translateY(-1px);
            box-shadow: 0 18px 42px rgba(37, 99, 235, .38);
        }

        .mik-ip-btn-danger {
            min-height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            padding: 0 13px;
            border: 0;
            border-radius: 12px;
            background: linear-gradient(135deg, #e11d48, #dc2626);
            color: #fff;
            font-size: 12px;
            font-weight: 900;
            cursor: pointer;
            box-shadow: 0 12px 26px rgba(225, 29, 72, .24);
        }

        .mik-ip-message {
            margin-top: 14px;
            border: 1px solid rgba(52, 211, 153, .25);
            background: rgba(16, 185, 129, .11);
            color: #a7f3d0;
            border-radius: 16px;
            padding: 12px 14px;
            font-size: 13px;
            font-weight: 700;
        }

        .mik-ip-warning {
            border: 1px solid rgba(245, 158, 11, .25);
            background: rgba(245, 158, 11, .1);
            color: #fde68a;
            border-radius: 18px;
            padding: 14px;
            font-size: 13px;
            line-height: 1.65;
        }

        .mik-ip-warning strong {
            display: block;
            margin-bottom: 4px;
            color: #fef3c7;
        }

        .mik-ip-stats-mini {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 10px;
            margin-bottom: 18px;
        }

        .mik-ip-mini {
            border-radius: 20px;
            border: 1px solid var(--mik-border);
            background: var(--mik-card-2);
            padding: 16px;
        }

        .mik-ip-mini-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
        }

        .mik-ip-mini-label {
            color: var(--mik-muted);
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .05em;
        }

        .mik-ip-mini-value {
            margin-top: 7px;
            color: #fff;
            font-size: 20px;
            font-weight: 950;
        }

        .mik-ip-table-wrap {
            overflow-x: auto;
        }

        .mik-ip-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 760px;
        }

        .mik-ip-table th {
            padding: 14px 18px;
            text-align: left;
            color: #94a3b8;
            background: rgba(15, 23, 42, .8);
            border-bottom: 1px solid var(--mik-border);
            font-size: 11px;
            font-weight: 900;
            letter-spacing: .07em;
            text-transform: uppercase;
        }

        .mik-ip-table td {
            padding: 16px 18px;
            border-bottom: 1px solid rgba(148, 163, 184, .11);
            color: #cbd5e1;
            vertical-align: middle;
        }

        .mik-ip-table tbody tr {
            transition: background .15s ease;
        }

        .mik-ip-table tbody tr:hover {
            background: rgba(30, 41, 59, .55);
        }

        .mik-ip-address-main {
            color: #fff;
            font-size: 15px;
            font-weight: 950;
            letter-spacing: -.01em;
        }

        .mik-ip-pills {
            display: flex;
            flex-wrap: wrap;
            gap: 7px;
            margin-top: 8px;
        }

        .mik-ip-pill {
            display: inline-flex;
            align-items: center;
            border-radius: 999px;
            padding: 5px 8px;
            font-size: 10.5px;
            font-weight: 900;
            line-height: 1;
            letter-spacing: .03em;
            text-transform: uppercase;
            border: 1px solid transparent;
        }

        .mik-ip-pill-blue {
            color: #bfdbfe;
            background: rgba(37, 99, 235, .14);
            border-color: rgba(96, 165, 250, .22);
        }

        .mik-ip-pill-green {
            color: #bbf7d0;
            background: rgba(22, 163, 74, .14);
            border-color: rgba(74, 222, 128, .22);
        }

        .mik-ip-pill-yellow {
            color: #fde68a;
            background: rgba(217, 119, 6, .14);
            border-color: rgba(251, 191, 36, .22);
        }

        .mik-ip-pill-red {
            color: #fecdd3;
            background: rgba(225, 29, 72, .14);
            border-color: rgba(251, 113, 133, .22);
        }

        .mik-ip-interface-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 76px;
            border-radius: 14px;
            border: 1px solid rgba(148, 163, 184, .22);
            background: rgba(2, 6, 23, .72);
            color: #e2e8f0;
            padding: 9px 11px;
            font-size: 13px;
            font-weight: 950;
        }

        .mik-ip-empty {
            padding: 54px 18px;
            text-align: center;
            color: var(--mik-muted);
        }

        .mik-ip-empty-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 60px;
            height: 60px;
            border-radius: 20px;
            border: 1px solid var(--mik-border);
            background: rgba(2, 6, 23, .65);
            color: #64748b;
            margin-bottom: 14px;
        }

        .mik-ip-interface-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
        }

        .mik-ip-interface-card {
            position: relative;
            overflow: hidden;
            border-radius: 22px;
            border: 1px solid var(--mik-border);
            background: rgba(15, 23, 42, .62);
            padding: 18px;
            transition: transform .15s ease, border-color .15s ease, background .15s ease;
        }

        .mik-ip-interface-card:hover {
            transform: translateY(-2px);
            border-color: var(--mik-border-strong);
            background: rgba(15, 23, 42, .92);
        }

        .mik-ip-interface-card::after {
            content: '';
            position: absolute;
            width: 120px;
            height: 120px;
            border-radius: 999px;
            right: -66px;
            top: -66px;
            background: rgba(56, 189, 248, .08);
        }

        .mik-ip-interface-head {
            position: relative;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 12px;
        }

        .mik-ip-interface-name {
            display: flex;
            align-items: center;
            gap: 9px;
            color: #fff;
            font-size: 18px;
            font-weight: 950;
        }

        .mik-ip-status-dot {
            width: 10px;
            height: 10px;
            border-radius: 999px;
            flex: 0 0 10px;
        }

        .mik-ip-status-running {
            background: var(--mik-green);
            box-shadow: 0 0 18px rgba(52, 211, 153, .9);
        }

        .mik-ip-status-idle {
            background: #64748b;
        }

        .mik-ip-status-disabled {
            background: var(--mik-red);
            box-shadow: 0 0 18px rgba(251, 113, 133, .75);
        }

        .mik-ip-status-label {
            border-radius: 999px;
            padding: 6px 9px;
            font-size: 10px;
            font-weight: 950;
            line-height: 1;
            text-transform: uppercase;
            letter-spacing: .05em;
        }

        .mik-ip-status-label.running {
            background: rgba(16, 185, 129, .13);
            color: #a7f3d0;
            border: 1px solid rgba(52, 211, 153, .23);
        }

        .mik-ip-status-label.idle {
            background: rgba(100, 116, 139, .13);
            color: #cbd5e1;
            border: 1px solid rgba(148, 163, 184, .18);
        }

        .mik-ip-status-label.disabled {
            background: rgba(225, 29, 72, .13);
            color: #fecdd3;
            border: 1px solid rgba(251, 113, 133, .23);
        }

        .mik-ip-interface-type {
            position: relative;
            margin-top: 12px;
            color: #94a3b8;
            font-size: 13px;
            font-weight: 750;
        }

        .mik-ip-mac {
            position: relative;
            margin-top: 8px;
            color: #64748b;
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
            font-size: 12px;
        }

        .mik-ip-error {
            margin-top: 7px;
            color: #fb7185;
            font-size: 12px;
            font-weight: 700;
        }

        .mik-ip-loading {
            position: fixed;
            right: 24px;
            bottom: 24px;
            z-index: 50;
            display: inline-flex;
            align-items: center;
            gap: 12px;
            border-radius: 18px;
            border: 1px solid rgba(255,255,255,.12);
            background: rgba(2,6,23,.92);
            color: #fff;
            padding: 13px 16px;
            box-shadow: 0 24px 60px rgba(0,0,0,.5);
            font-size: 13px;
            font-weight: 900;
        }

        .mik-ip-spinner {
            width: 18px;
            height: 18px;
            border-radius: 50%;
            border: 2px solid rgba(255,255,255,.18);
            border-top-color: var(--mik-blue);
            animation: mik-ip-spin .8s linear infinite;
        }

        @keyframes mik-ip-spin {
            to { transform: rotate(360deg); }
        }

        @media (max-width: 1180px) {
            .mik-ip-grid,
            .mik-ip-hero {
                grid-template-columns: 1fr;
            }

            .mik-ip-interface-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 760px) {
            .mik-ip-shell {
                padding: 18px;
                border-radius: 22px;
            }

            .mik-ip-selector-row,
            .mik-ip-stats-mini,
            .mik-ip-hero-metrics,
            .mik-ip-interface-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="mik-ip-page">
        <div class="mik-ip-shell">
            <section class="mik-ip-hero">
                <div>
                    <div class="mik-ip-kicker">
                        <span class="mik-ip-dot"></span>
                        RouterOS API Live Console
                    </div>

                    <h1 class="mik-ip-title">IP Address Manager</h1>

                    <p class="mik-ip-subtitle">
                        Kelola IP address MikroTik langsung dari Filament. Halaman ini membaca interface dan IP address secara realtime melalui RouterOS API, sehingga perubahan dapat langsung terlihat di router.
                    </p>
                </div>

                <div class="mik-ip-hero-metrics">
                    <div class="mik-ip-metric">
                        <div class="mik-ip-metric-value">{{ count($devices ?? []) }}</div>
                        <div class="mik-ip-metric-label">Devices</div>
                    </div>

                    <div class="mik-ip-metric">
                        <div class="mik-ip-metric-value">{{ count($interfaces ?? []) }}</div>
                        <div class="mik-ip-metric-label">Interfaces</div>
                    </div>

                    <div class="mik-ip-metric">
                        <div class="mik-ip-metric-value">{{ count($ipAddresses ?? []) }}</div>
                        <div class="mik-ip-metric-label">IP Address</div>
                    </div>
                </div>
            </section>

            <section class="mik-ip-card" style="margin-bottom: 18px;">
                <div class="mik-ip-card-header">
                    <div class="mik-ip-card-title-wrap">
                        <div class="mik-ip-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 20h12M8 16h8a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 16v4" />
                            </svg>
                        </div>

                        <div>
                            <h2 class="mik-ip-card-title">Pilih MikroTik Device</h2>
                            <p class="mik-ip-card-desc">Pilih router target, lalu refresh untuk mengambil data interface dan IP address.</p>
                        </div>
                    </div>
                </div>

                <div class="mik-ip-card-body">
                    <div class="mik-ip-selector-row">
                        <div>
                            <label class="mik-ip-label">MikroTik Device</label>

                            <select
                                wire:model.live="selectedDeviceId"
                                wire:change="loadRouterData"
                                class="mik-ip-select"
                            >
                                <option value="">Pilih Device MikroTik</option>

                                @foreach ($devices as $device)
                                    <option value="{{ $device['id'] }}">
                                        {{ $device['name'] }} — {{ $device['ip_address'] }}:{{ $device['api_port'] ?? 8728 }}
                                        @if (! empty($device['status']))
                                            ({{ $device['status'] }})
                                        @endif
                                    </option>
                                @endforeach
                            </select>

                            @error('selectedDeviceId')
                                <div class="mik-ip-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="button" class="mik-ip-btn" wire:click="loadRouterData" wire:loading.attr="disabled">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20 11a8.1 8.1 0 0 0-15.5-2M4 5v4h4" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 13a8.1 8.1 0 0 0 15.5 2M20 19v-4h-4" />
                            </svg>
                            Refresh Data
                        </button>
                    </div>

                    @if ($lastMessage)
                        <div class="mik-ip-message">
                            {{ $lastMessage }}
                        </div>
                    @endif
                </div>
            </section>

            <div class="mik-ip-stats-mini">
                <div class="mik-ip-mini">
                    <div class="mik-ip-mini-top">
                        <span class="mik-ip-mini-label">Connection</span>
                        <span class="mik-ip-pill {{ filled($selectedDeviceId) ? 'mik-ip-pill-green' : 'mik-ip-pill-yellow' }}">
                            {{ filled($selectedDeviceId) ? 'Ready' : 'Waiting' }}
                        </span>
                    </div>
                    <div class="mik-ip-mini-value">{{ filled($selectedDeviceId) ? 'Router Selected' : 'Select Router' }}</div>
                </div>

                <div class="mik-ip-mini">
                    <div class="mik-ip-mini-top">
                        <span class="mik-ip-mini-label">Router Data</span>
                        <span class="mik-ip-pill mik-ip-pill-blue">Live</span>
                    </div>
                    <div class="mik-ip-mini-value">{{ count($interfaces ?? []) }} Interface</div>
                </div>

                <div class="mik-ip-mini">
                    <div class="mik-ip-mini-top">
                        <span class="mik-ip-mini-label">IP Records</span>
                        <span class="mik-ip-pill mik-ip-pill-green">RouterOS</span>
                    </div>
                    <div class="mik-ip-mini-value">{{ count($ipAddresses ?? []) }} Address</div>
                </div>
            </div>

            <div class="mik-ip-grid">
                <aside class="mik-ip-card">
                    <div class="mik-ip-card-header">
                        <div class="mik-ip-card-title-wrap">
                            <div class="mik-ip-icon" style="border-color: rgba(52,211,153,.22); background: rgba(52,211,153,.12); color: #86efac;">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="mik-ip-card-title">Tambah IP Address</h2>
                                <p class="mik-ip-card-desc">Gunakan CIDR, contoh: 192.168.20.1/24 ke ether2.</p>
                            </div>
                        </div>
                    </div>

                    <div class="mik-ip-card-body">
                        <form wire:submit.prevent="addIpAddress" class="mik-ip-form-stack">
                            <div>
                                <label class="mik-ip-label">Address / CIDR</label>
                                <input
                                    type="text"
                                    wire:model.defer="address"
                                    placeholder="192.168.20.1/24"
                                    class="mik-ip-input"
                                />
                                @error('address')
                                    <div class="mik-ip-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label class="mik-ip-label">Interface</label>
                                <select wire:model.defer="interface" class="mik-ip-select">
                                    <option value="">Pilih Interface</option>

                                    @foreach ($interfaces as $item)
                                        <option value="{{ $item['name'] }}">
                                            {{ $item['name'] }}
                                            @if ($item['running'])
                                                - running
                                            @endif
                                            @if ($item['disabled'])
                                                - disabled
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                @error('interface')
                                    <div class="mik-ip-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label class="mik-ip-label">Comment</label>
                                <input
                                    type="text"
                                    wire:model.defer="comment"
                                    placeholder="Added from Filament"
                                    class="mik-ip-input"
                                />
                                @error('comment')
                                    <div class="mik-ip-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mik-ip-warning">
                                <strong>Catatan aman</strong>
                                Jangan hapus atau ubah IP yang sedang dipakai Laravel untuk konek ke MikroTik, misalnya 192.168.88.1/24 di ether1.
                            </div>

                            <button type="submit" class="mik-ip-btn" wire:loading.attr="disabled">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14" />
                                </svg>
                                Tambahkan IP Address
                            </button>
                        </form>
                    </div>
                </aside>

                <main class="mik-ip-card">
                    <div class="mik-ip-card-header">
                        <div class="mik-ip-card-title-wrap">
                            <div class="mik-ip-icon" style="border-color: rgba(167,139,250,.22); background: rgba(167,139,250,.12); color: #c4b5fd;">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 20a8 8 0 1 0 0-16 8 8 0 0 0 0 16Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2 12h20M12 2c2 2.2 3 5.6 3 10s-1 7.8-3 10M12 2c-2 2.2-3 5.6-3 10s1 7.8 3 10" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="mik-ip-card-title">Daftar IP Address</h2>
                                <p class="mik-ip-card-desc">Data dibaca realtime dari MikroTik melalui RouterOS API.</p>
                            </div>
                        </div>

                        <span class="mik-ip-pill mik-ip-pill-blue">{{ count($ipAddresses ?? []) }} Records</span>
                    </div>

                    <div class="mik-ip-table-wrap">
                        <table class="mik-ip-table">
                            <thead>
                                <tr>
                                    <th>Address</th>
                                    <th>Network</th>
                                    <th>Interface</th>
                                    <th>Comment</th>
                                    <th style="text-align:right;">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($ipAddresses as $item)
                                    <tr wire:key="ip-row-{{ $item['id'] ?? md5((string) ($item['address'] ?? 'unknown')) }}">
                                        <td>
                                            <div class="mik-ip-address-main">{{ $item['address'] ?? '-' }}</div>
                                            <div class="mik-ip-pills">
                                                @if ($item['dynamic'])
                                                    <span class="mik-ip-pill mik-ip-pill-yellow">Dynamic</span>
                                                @else
                                                    <span class="mik-ip-pill mik-ip-pill-blue">Static</span>
                                                @endif

                                                @if ($item['disabled'])
                                                    <span class="mik-ip-pill mik-ip-pill-red">Disabled</span>
                                                @else
                                                    <span class="mik-ip-pill mik-ip-pill-green">Active</span>
                                                @endif
                                            </div>
                                        </td>

                                        <td>{{ $item['network'] ?? '-' }}</td>

                                        <td>
                                            <span class="mik-ip-interface-badge">{{ $item['interface'] ?? '-' }}</span>
                                        </td>

                                        <td>{{ $item['comment'] ?? '-' }}</td>

                                        <td style="text-align:right;">
                                            @if (! $item['dynamic'])
                                                <button
                                                    type="button"
                                                    class="mik-ip-btn-danger"
                                                    wire:click="removeIpAddress(@js($item['id']), @js($item['address']))"
                                                    wire:confirm="Yakin ingin menghapus IP {{ $item['address'] }}?"
                                                    wire:loading.attr="disabled"
                                                >
                                                    Hapus
                                                </button>
                                            @else
                                                <span class="mik-ip-pill mik-ip-pill-yellow">Dynamic</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5">
                                            <div class="mik-ip-empty">
                                                <div class="mik-ip-empty-icon">
                                                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 13V7a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v6" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13h6l2 3h2l2-3h6v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4Z" />
                                                    </svg>
                                                </div>
                                                <div style="font-weight: 900; color: #fff;">Belum ada data IP Address</div>
                                                <div style="margin-top: 5px;">Pilih device lalu klik Refresh Data.</div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </main>
            </div>

            <section class="mik-ip-card" style="margin-top: 18px;">
                <div class="mik-ip-card-header">
                    <div class="mik-ip-card-title-wrap">
                        <div class="mik-ip-icon" style="border-color: rgba(245,158,11,.22); background: rgba(245,158,11,.12); color: #fcd34d;">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 7h16M4 12h16M4 17h16" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="mik-ip-card-title">Interface MikroTik</h2>
                            <p class="mik-ip-card-desc">Pilih salah satu interface ini ketika menambahkan IP address baru.</p>
                        </div>
                    </div>

                    <span class="mik-ip-pill mik-ip-pill-green">{{ count($interfaces ?? []) }} Interfaces</span>
                </div>

                <div class="mik-ip-card-body">
                    <div class="mik-ip-interface-grid">
                        @forelse ($interfaces as $item)
                            <div class="mik-ip-interface-card">
                                <div class="mik-ip-interface-head">
                                    <div>
                                        <div class="mik-ip-interface-name">
                                            <span class="mik-ip-status-dot @if ($item['disabled']) mik-ip-status-disabled @elseif ($item['running']) mik-ip-status-running @else mik-ip-status-idle @endif"></span>
                                            {{ $item['name'] }}
                                        </div>

                                        <div class="mik-ip-interface-type">{{ $item['type'] ?? '-' }}</div>

                                        @if ($item['mac_address'])
                                            <div class="mik-ip-mac">{{ $item['mac_address'] }}</div>
                                        @endif
                                    </div>

                                    @if ($item['disabled'])
                                        <span class="mik-ip-status-label disabled">Disabled</span>
                                    @elseif ($item['running'])
                                        <span class="mik-ip-status-label running">Running</span>
                                    @else
                                        <span class="mik-ip-status-label idle">Idle</span>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="mik-ip-empty" style="grid-column: 1 / -1;">
                                <div class="mik-ip-empty-icon">
                                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 22a10 10 0 1 0 0-20 10 10 0 0 0 0 20Z" />
                                    </svg>
                                </div>
                                <div style="font-weight: 900; color: #fff;">Belum ada interface yang dimuat</div>
                                <div style="margin-top: 5px;">Pilih MikroTik device lalu klik Refresh Data.</div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </section>
        </div>

        <div wire:loading.delay class="mik-ip-loading">
            <span class="mik-ip-spinner"></span>
            Memproses RouterOS API...
        </div>
    </div>
</x-filament-panels::page>
