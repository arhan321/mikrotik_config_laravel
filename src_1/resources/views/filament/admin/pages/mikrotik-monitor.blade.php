<x-filament-panels::page>
    @php
        $cpuPercent = min((int) $this->cpuLoad, 100);
        $memoryPercent = min((int) $this->memoryUsagePercent, 100);
        $storagePercent = min((int) $this->hddUsagePercent, 100);
        $interfaceCount = count($interfaces);
        $addressCount = count($addresses);
        $runningInterfaceCount = $this->runningInterfacesCount;
        $disabledInterfaceCount = $this->disabledInterfacesCount;
        $identityName = data_get($identity, 'name', '-');
        $routerVersion = data_get($resource, 'version', '-');
        $boardName = data_get($resource, 'board-name', data_get($routerboard, 'model', '-'));
        $architectureName = data_get($resource, 'architecture-name', '-');
        $platformName = data_get($resource, 'platform', '-');
        $uptime = data_get($resource, 'uptime', '-');
        $cpuName = data_get($resource, 'cpu', '-');
        $cpuFrequency = data_get($resource, 'cpu-frequency');

        $statusMeta = match ($connectionStatus) {
            'online' => [
                'label' => 'Online',
                'class' => 'is-online',
                'dot' => 'Online',
                'message' => $connectionMessage ?: 'Berhasil terhubung ke MikroTik.',
            ],
            'failed' => [
                'label' => 'Offline / Error',
                'class' => 'is-offline',
                'dot' => 'Error',
                'message' => $connectionMessage ?: 'Gagal membaca device MikroTik.',
            ],
            default => [
                'label' => 'Menunggu Device',
                'class' => 'is-idle',
                'dot' => 'Idle',
                'message' => 'Pilih device MikroTik untuk mulai monitoring.',
            ],
        };
    @endphp

    @once
        <style>
            .mtk-monitor {
                --mtk-bg: #020617;
                --mtk-card: rgba(15, 23, 42, .76);
                --mtk-card-soft: rgba(15, 23, 42, .52);
                --mtk-border: rgba(148, 163, 184, .18);
                --mtk-border-strong: rgba(34, 211, 238, .30);
                --mtk-text: #f8fafc;
                --mtk-muted: #94a3b8;
                --mtk-soft: #cbd5e1;
                --mtk-blue: #38bdf8;
                --mtk-cyan: #22d3ee;
                --mtk-violet: #a78bfa;
                --mtk-emerald: #34d399;
                --mtk-amber: #f59e0b;
                --mtk-red: #fb7185;
                color: var(--mtk-text);
            }

            .mtk-monitor *,
            .mtk-monitor *::before,
            .mtk-monitor *::after {
                box-sizing: border-box;
            }

            .mtk-shell {
                position: relative;
                display: grid;
                gap: 22px;
                isolation: isolate;
            }

            .mtk-shell::before {
                content: '';
                position: fixed;
                inset: 0;
                pointer-events: none;
                background:
                    radial-gradient(circle at 15% 5%, rgba(56, 189, 248, .13), transparent 28%),
                    radial-gradient(circle at 85% 15%, rgba(167, 139, 250, .10), transparent 28%),
                    radial-gradient(circle at 65% 85%, rgba(16, 185, 129, .08), transparent 28%);
                z-index: -2;
            }

            .mtk-hero {
                position: relative;
                overflow: hidden;
                border: 1px solid var(--mtk-border);
                border-radius: 30px;
                padding: 26px;
                background:
                    linear-gradient(135deg, rgba(15, 23, 42, .95), rgba(2, 6, 23, .78)),
                    radial-gradient(circle at top right, rgba(34, 211, 238, .24), transparent 34%),
                    radial-gradient(circle at bottom left, rgba(59, 130, 246, .20), transparent 34%);
                box-shadow: 0 24px 80px rgba(0, 0, 0, .35), inset 0 1px 0 rgba(255, 255, 255, .08);
            }

            .mtk-hero::before,
            .mtk-hero::after {
                content: '';
                position: absolute;
                border-radius: 999px;
                filter: blur(12px);
                opacity: .75;
                pointer-events: none;
            }

            .mtk-hero::before {
                width: 260px;
                height: 260px;
                right: -95px;
                top: -105px;
                background: rgba(34, 211, 238, .22);
            }

            .mtk-hero::after {
                width: 220px;
                height: 220px;
                left: -95px;
                bottom: -115px;
                background: rgba(59, 130, 246, .22);
            }

            .mtk-hero-grid {
                position: relative;
                z-index: 1;
                display: grid;
                grid-template-columns: minmax(0, 1.35fr) minmax(340px, .65fr);
                gap: 22px;
                align-items: stretch;
            }

            .mtk-badge {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                width: fit-content;
                border: 1px solid rgba(34, 211, 238, .25);
                border-radius: 999px;
                padding: 7px 12px;
                background: rgba(34, 211, 238, .09);
                color: #a5f3fc;
                font-size: 12px;
                font-weight: 800;
                letter-spacing: .06em;
                text-transform: uppercase;
            }

            .mtk-badge span {
                width: 8px;
                height: 8px;
                border-radius: 999px;
                background: var(--mtk-cyan);
                box-shadow: 0 0 22px rgba(34, 211, 238, .95);
            }

            .mtk-title {
                margin: 16px 0 0;
                font-size: clamp(28px, 4vw, 48px);
                line-height: 1.02;
                font-weight: 950;
                letter-spacing: -0.055em;
                color: #ffffff;
            }

            .mtk-title span {
                background: linear-gradient(90deg, #67e8f9, #93c5fd, #c4b5fd);
                -webkit-background-clip: text;
                background-clip: text;
                color: transparent;
            }

            .mtk-subtitle {
                max-width: 760px;
                margin-top: 14px;
                color: var(--mtk-soft);
                font-size: 14px;
                line-height: 1.7;
            }

            .mtk-mini-grid {
                display: grid;
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 12px;
                margin-top: 22px;
            }

            .mtk-mini-card,
            .mtk-control-card,
            .mtk-card {
                border: 1px solid var(--mtk-border);
                background: rgba(15, 23, 42, .56);
                box-shadow: inset 0 1px 0 rgba(255, 255, 255, .055);
                backdrop-filter: blur(18px);
            }

            .mtk-mini-card {
                min-height: 90px;
                border-radius: 22px;
                padding: 16px;
            }

            .mtk-kicker {
                color: var(--mtk-muted);
                font-size: 11px;
                font-weight: 900;
                letter-spacing: .08em;
                text-transform: uppercase;
            }

            .mtk-value {
                margin-top: 8px;
                color: #fff;
                font-size: 18px;
                font-weight: 900;
                line-height: 1.2;
                overflow-wrap: anywhere;
            }

            .mtk-muted {
                color: var(--mtk-muted);
            }

            .mtk-control-card {
                border-radius: 26px;
                padding: 18px;
                background: rgba(2, 6, 23, .44);
            }

            .mtk-control-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 12px;
                margin-bottom: 14px;
            }

            .mtk-control-title {
                margin: 0;
                color: #fff;
                font-size: 14px;
                font-weight: 900;
            }

            .mtk-pill {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                border-radius: 999px;
                padding: 6px 10px;
                font-size: 11px;
                font-weight: 900;
                white-space: nowrap;
            }

            .mtk-pill::before {
                content: '';
                width: 7px;
                height: 7px;
                border-radius: 999px;
                background: currentColor;
            }

            .mtk-pill.is-online {
                color: #86efac;
                background: rgba(16, 185, 129, .12);
                border: 1px solid rgba(52, 211, 153, .22);
            }

            .mtk-pill.is-offline {
                color: #fda4af;
                background: rgba(244, 63, 94, .12);
                border: 1px solid rgba(251, 113, 133, .24);
            }

            .mtk-pill.is-idle {
                color: #cbd5e1;
                background: rgba(148, 163, 184, .12);
                border: 1px solid rgba(148, 163, 184, .22);
            }

            .mtk-button-wrap {
                margin-top: 14px;
            }

            .mtk-status-box {
                margin-top: 14px;
                border-radius: 20px;
                padding: 14px;
                border: 1px solid var(--mtk-border);
                background: rgba(15, 23, 42, .52);
            }

            .mtk-status-main {
                display: flex;
                align-items: flex-start;
                gap: 12px;
            }

            .mtk-status-icon {
                display: grid;
                place-items: center;
                flex: 0 0 auto;
                width: 36px;
                height: 36px;
                border-radius: 14px;
                color: #fff;
                font-weight: 900;
            }

            .mtk-status-icon.is-online { background: linear-gradient(135deg, #059669, #34d399); }
            .mtk-status-icon.is-offline { background: linear-gradient(135deg, #be123c, #fb7185); }
            .mtk-status-icon.is-idle { background: linear-gradient(135deg, #475569, #94a3b8); }

            .mtk-status-title {
                margin: 0;
                font-weight: 950;
                color: #fff;
                line-height: 1.25;
            }

            .mtk-status-desc {
                margin: 4px 0 0;
                color: var(--mtk-muted);
                font-size: 12px;
                line-height: 1.55;
            }

            .mtk-stats {
                display: grid;
                grid-template-columns: repeat(4, minmax(0, 1fr));
                gap: 16px;
            }

            .mtk-stat-card {
                position: relative;
                overflow: hidden;
                min-height: 186px;
                border-radius: 28px;
                padding: 18px;
                border: 1px solid var(--mtk-border);
                background:
                    radial-gradient(circle at 85% 15%, rgba(255, 255, 255, .08), transparent 25%),
                    linear-gradient(145deg, rgba(15, 23, 42, .90), rgba(2, 6, 23, .72));
                box-shadow: 0 16px 45px rgba(0, 0, 0, .22), inset 0 1px 0 rgba(255, 255, 255, .06);
            }

            .mtk-stat-card::before {
                content: '';
                position: absolute;
                inset: 0;
                pointer-events: none;
                background: linear-gradient(90deg, transparent, rgba(255, 255, 255, .07), transparent);
                transform: translateX(-100%);
                animation: mtk-shine 5s ease-in-out infinite;
            }

            .mtk-stat-card.cpu { --accent: var(--mtk-cyan); }
            .mtk-stat-card.memory { --accent: var(--mtk-violet); }
            .mtk-stat-card.storage { --accent: var(--mtk-amber); }
            .mtk-stat-card.uptime { --accent: var(--mtk-emerald); }

            .mtk-stat-top {
                position: relative;
                display: flex;
                align-items: flex-start;
                justify-content: space-between;
                gap: 12px;
                z-index: 1;
            }

            .mtk-stat-label {
                margin: 0;
                color: var(--mtk-muted);
                font-size: 13px;
                font-weight: 850;
            }

            .mtk-stat-number {
                margin: 8px 0 0;
                color: #fff;
                font-size: 38px;
                line-height: 1;
                font-weight: 950;
                letter-spacing: -0.05em;
            }

            .mtk-stat-number.small {
                font-size: 25px;
                letter-spacing: -0.035em;
                line-height: 1.15;
            }

            .mtk-stat-icon {
                display: grid;
                place-items: center;
                width: 48px;
                height: 48px;
                border-radius: 18px;
                color: var(--accent);
                background: color-mix(in srgb, var(--accent) 15%, transparent);
                border: 1px solid color-mix(in srgb, var(--accent) 25%, transparent);
                box-shadow: 0 0 40px color-mix(in srgb, var(--accent) 18%, transparent);
                font-size: 22px;
            }

            .mtk-meter {
                position: relative;
                height: 10px;
                margin-top: 24px;
                overflow: hidden;
                border-radius: 999px;
                background: rgba(30, 41, 59, .9);
                z-index: 1;
            }

            .mtk-meter span {
                display: block;
                width: var(--value);
                height: 100%;
                border-radius: inherit;
                background: linear-gradient(90deg, color-mix(in srgb, var(--accent) 65%, #ffffff), var(--accent));
                box-shadow: 0 0 24px color-mix(in srgb, var(--accent) 42%, transparent);
            }

            .mtk-stat-note {
                position: relative;
                z-index: 1;
                margin: 14px 0 0;
                color: var(--mtk-muted);
                font-size: 12px;
                line-height: 1.5;
                overflow-wrap: anywhere;
            }

            .mtk-grid-main {
                display: grid;
                grid-template-columns: minmax(330px, .36fr) minmax(0, .64fr);
                gap: 18px;
            }

            .mtk-card {
                overflow: hidden;
                border-radius: 28px;
                background:
                    linear-gradient(180deg, rgba(15, 23, 42, .82), rgba(2, 6, 23, .70));
            }

            .mtk-card-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 14px;
                padding: 18px 18px 14px;
                border-bottom: 1px solid rgba(148, 163, 184, .13);
            }

            .mtk-card-title {
                margin: 0;
                color: #fff;
                font-size: 17px;
                font-weight: 950;
                letter-spacing: -0.025em;
            }

            .mtk-card-subtitle {
                margin: 4px 0 0;
                color: var(--mtk-muted);
                font-size: 12px;
                line-height: 1.45;
            }

            .mtk-card-icon {
                display: grid;
                place-items: center;
                width: 42px;
                height: 42px;
                border-radius: 16px;
                color: #67e8f9;
                background: rgba(34, 211, 238, .10);
                border: 1px solid rgba(34, 211, 238, .20);
            }

            .mtk-info-list {
                display: grid;
                gap: 11px;
                padding: 16px;
            }

            .mtk-info-item {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 14px;
                border-radius: 18px;
                padding: 13px 14px;
                background: rgba(15, 23, 42, .54);
                border: 1px solid rgba(148, 163, 184, .12);
            }

            .mtk-info-item span:first-child {
                color: var(--mtk-muted);
                font-size: 12px;
                font-weight: 850;
            }

            .mtk-info-item span:last-child {
                color: #fff;
                font-size: 13px;
                font-weight: 900;
                text-align: right;
                overflow-wrap: anywhere;
            }

            .mtk-table-wrap {
                padding: 16px;
            }

            .mtk-table-scroll {
                overflow-x: auto;
                border-radius: 20px;
                border: 1px solid rgba(148, 163, 184, .14);
            }

            .mtk-table {
                width: 100%;
                min-width: 760px;
                border-collapse: separate;
                border-spacing: 0;
                font-size: 13px;
            }

            .mtk-table thead th {
                position: sticky;
                top: 0;
                z-index: 1;
                padding: 13px 14px;
                color: #cbd5e1;
                background: rgba(15, 23, 42, .96);
                font-size: 11px;
                font-weight: 950;
                letter-spacing: .075em;
                text-align: left;
                text-transform: uppercase;
                border-bottom: 1px solid rgba(148, 163, 184, .16);
            }

            .mtk-table tbody td {
                padding: 13px 14px;
                color: #cbd5e1;
                border-bottom: 1px solid rgba(148, 163, 184, .10);
                vertical-align: middle;
            }

            .mtk-table tbody tr {
                background: rgba(2, 6, 23, .18);
                transition: background .18s ease, transform .18s ease;
            }

            .mtk-table tbody tr:hover {
                background: rgba(34, 211, 238, .065);
            }

            .mtk-table tbody tr:last-child td {
                border-bottom: 0;
            }

            .mtk-table .strong {
                color: #fff;
                font-weight: 950;
            }

            .mtk-chip-row {
                display: flex;
                flex-wrap: wrap;
                gap: 8px;
            }

            .mtk-chip {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                width: fit-content;
                border-radius: 999px;
                padding: 5px 9px;
                font-size: 11px;
                font-weight: 950;
                white-space: nowrap;
            }

            .mtk-chip.green { color: #86efac; background: rgba(16, 185, 129, .12); border: 1px solid rgba(52, 211, 153, .18); }
            .mtk-chip.red { color: #fda4af; background: rgba(244, 63, 94, .12); border: 1px solid rgba(251, 113, 133, .18); }
            .mtk-chip.blue { color: #93c5fd; background: rgba(59, 130, 246, .12); border: 1px solid rgba(96, 165, 250, .18); }
            .mtk-chip.gray { color: #cbd5e1; background: rgba(148, 163, 184, .10); border: 1px solid rgba(148, 163, 184, .16); }

            .mtk-empty {
                padding: 34px 16px !important;
                color: var(--mtk-muted) !important;
                text-align: center;
            }

            .mtk-section-grid {
                display: grid;
                gap: 18px;
            }

            .mtk-raw {
                max-height: 360px;
                overflow: auto;
                margin: 16px;
                padding: 16px;
                border-radius: 18px;
                border: 1px solid rgba(148, 163, 184, .14);
                color: #a7f3d0;
                background: rgba(0, 0, 0, .38);
                font-size: 12px;
                line-height: 1.65;
            }

            .mtk-toolbar-pills {
                display: flex;
                flex-wrap: wrap;
                gap: 9px;
            }

            @@keyframes mtk-shine {
                0%, 70% { transform: translateX(-120%); }
                100% { transform: translateX(120%); }
            }

            @@media (max-width: 1280px) {
                .mtk-hero-grid,
                .mtk-grid-main {
                    grid-template-columns: 1fr;
                }

                .mtk-stats {
                    grid-template-columns: repeat(2, minmax(0, 1fr));
                }
            }

            @@media (max-width: 760px) {
                .mtk-hero {
                    padding: 18px;
                    border-radius: 24px;
                }

                .mtk-mini-grid,
                .mtk-stats {
                    grid-template-columns: 1fr;
                }

                .mtk-card-header,
                .mtk-info-item {
                    align-items: flex-start;
                    flex-direction: column;
                }

                .mtk-info-item span:last-child {
                    text-align: left;
                }
            }
        </style>
    @endonce

    <div class="mtk-monitor">
        <div class="mtk-shell">
            <section class="mtk-hero">
                <div class="mtk-hero-grid">
                    <div>
                        <div class="mtk-badge">
                            <span></span>
                            Real-time MikroTik Monitoring
                        </div>

                        <h1 class="mtk-title">
                            MikroTik Router <span>Health Monitor</span>
                        </h1>

                        <p class="mtk-subtitle">
                            Pantau kondisi RouterOS secara langsung dari API: CPU, memory, storage, uptime,
                            identity, interface, IP address, hingga raw resource untuk kebutuhan monitoring jaringan.
                        </p>

                        <div class="mtk-mini-grid">
                            <div class="mtk-mini-card">
                                <div class="mtk-kicker">Device Aktif</div>
                                <div class="mtk-value">{{ $currentDeviceName ?: 'Belum dipilih' }}</div>
                            </div>

                            <div class="mtk-mini-card">
                                <div class="mtk-kicker">Terakhir Dicek</div>
                                <div class="mtk-value">{{ $lastCheckedAt ?: '-' }}</div>
                            </div>

                            <div class="mtk-mini-card">
                                <div class="mtk-kicker">Router Identity</div>
                                <div class="mtk-value">{{ $identityName }}</div>
                            </div>
                        </div>
                    </div>

                    <aside class="mtk-control-card">
                        <div class="mtk-control-header">
                            <div>
                                <p class="mtk-control-title">Monitoring Control</p>
                                <p class="mtk-card-subtitle">Pilih router lalu refresh data.</p>
                            </div>

                            <span class="mtk-pill {{ $statusMeta['class'] }}">{{ $statusMeta['dot'] }}</span>
                        </div>

                        {{ $this->form }}

                        <div class="mtk-button-wrap">
                            <x-filament::button
                                wire:click="loadDeviceInfo"
                                icon="heroicon-o-arrow-path"
                                color="info"
                                class="w-full"
                            >
                                Refresh Monitor
                            </x-filament::button>
                        </div>

                        <div class="mtk-status-box">
                            <div class="mtk-status-main">
                                <div class="mtk-status-icon {{ $statusMeta['class'] }}">
                                    @if ($connectionStatus === 'online')
                                        ✓
                                    @elseif ($connectionStatus === 'failed')
                                        !
                                    @else
                                        •
                                    @endif
                                </div>

                                <div>
                                    <p class="mtk-status-title">{{ $statusMeta['label'] }}</p>
                                    <p class="mtk-status-desc">{{ $statusMeta['message'] }}</p>
                                </div>
                            </div>
                        </div>
                    </aside>
                </div>
            </section>

            <section class="mtk-stats">
                <article class="mtk-stat-card cpu">
                    <div class="mtk-stat-top">
                        <div>
                            <p class="mtk-stat-label">CPU Load</p>
                            <p class="mtk-stat-number">{{ $cpuPercent }}%</p>
                        </div>
                        <div class="mtk-stat-icon">CPU</div>
                    </div>
                    <div class="mtk-meter" style="--value: {{ $cpuPercent }}%;"><span></span></div>
                    <p class="mtk-stat-note">
                        CPU: {{ $cpuName }}{{ $cpuFrequency ? ' / ' . $cpuFrequency . ' MHz' : '' }}
                    </p>
                </article>

                <article class="mtk-stat-card memory">
                    <div class="mtk-stat-top">
                        <div>
                            <p class="mtk-stat-label">Memory Usage</p>
                            <p class="mtk-stat-number">{{ $memoryPercent }}%</p>
                        </div>
                        <div class="mtk-stat-icon">RAM</div>
                    </div>
                    <div class="mtk-meter" style="--value: {{ $memoryPercent }}%;"><span></span></div>
                    <p class="mtk-stat-note">
                        {{ $this->formatBytes($this->usedMemory) }} / {{ $this->formatBytes($this->totalMemory) }}
                    </p>
                </article>

                <article class="mtk-stat-card storage">
                    <div class="mtk-stat-top">
                        <div>
                            <p class="mtk-stat-label">Storage Usage</p>
                            <p class="mtk-stat-number">{{ $storagePercent }}%</p>
                        </div>
                        <div class="mtk-stat-icon">DSK</div>
                    </div>
                    <div class="mtk-meter" style="--value: {{ $storagePercent }}%;"><span></span></div>
                    <p class="mtk-stat-note">
                        {{ $this->formatBytes($this->usedHdd) }} / {{ $this->formatBytes($this->totalHdd) }}
                    </p>
                </article>

                <article class="mtk-stat-card uptime">
                    <div class="mtk-stat-top">
                        <div>
                            <p class="mtk-stat-label">Uptime</p>
                            <p class="mtk-stat-number small">{{ $uptime }}</p>
                        </div>
                        <div class="mtk-stat-icon">UP</div>
                    </div>
                    <p class="mtk-stat-note">
                        Router aktif berdasarkan uptime terakhir dari RouterOS resource.
                    </p>
                </article>
            </section>

            <section class="mtk-grid-main">
                <article class="mtk-card">
                    <div class="mtk-card-header">
                        <div>
                            <h2 class="mtk-card-title">Router Identity</h2>
                            <p class="mtk-card-subtitle">Informasi utama perangkat RouterOS.</p>
                        </div>
                        <div class="mtk-card-icon">ID</div>
                    </div>

                    <div class="mtk-info-list">
                        <div class="mtk-info-item">
                            <span>Identity</span>
                            <span>{{ $identityName }}</span>
                        </div>
                        <div class="mtk-info-item">
                            <span>RouterOS Version</span>
                            <span>{{ $routerVersion }}</span>
                        </div>
                        <div class="mtk-info-item">
                            <span>Board Name</span>
                            <span>{{ $boardName }}</span>
                        </div>
                        <div class="mtk-info-item">
                            <span>Architecture</span>
                            <span>{{ $architectureName }}</span>
                        </div>
                        <div class="mtk-info-item">
                            <span>Platform</span>
                            <span>{{ $platformName }}</span>
                        </div>
                    </div>
                </article>

                <article class="mtk-card">
                    <div class="mtk-card-header">
                        <div>
                            <h2 class="mtk-card-title">Interfaces</h2>
                            <p class="mtk-card-subtitle">
                                Total {{ $interfaceCount }} interface, {{ $runningInterfaceCount }} running,
                                {{ $disabledInterfaceCount }} disabled.
                            </p>
                        </div>

                        <div class="mtk-toolbar-pills">
                            <span class="mtk-chip green">Running: {{ $runningInterfaceCount }}</span>
                            <span class="mtk-chip red">Disabled: {{ $disabledInterfaceCount }}</span>
                        </div>
                    </div>

                    <div class="mtk-table-wrap">
                        <div class="mtk-table-scroll">
                            <table class="mtk-table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>MAC</th>
                                        <th>MTU</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($interfaces as $interface)
                                        @php
                                            $isRunning = data_get($interface, 'running') === 'true';
                                            $isDisabled = data_get($interface, 'disabled') === 'true';
                                        @endphp

                                        <tr>
                                            <td class="strong">{{ data_get($interface, 'name', '-') }}</td>
                                            <td>{{ data_get($interface, 'type', '-') }}</td>
                                            <td>{{ data_get($interface, 'mac-address', '-') }}</td>
                                            <td>{{ data_get($interface, 'mtu', '-') }}</td>
                                            <td>
                                                @if ($isDisabled)
                                                    <span class="mtk-chip red">Disabled</span>
                                                @elseif ($isRunning)
                                                    <span class="mtk-chip green">Running</span>
                                                @else
                                                    <span class="mtk-chip gray">Inactive</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="mtk-empty">Belum ada data interface.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </article>
            </section>

            <section class="mtk-section-grid">
                <article class="mtk-card">
                    <div class="mtk-card-header">
                        <div>
                            <h2 class="mtk-card-title">IP Addresses</h2>
                            <p class="mtk-card-subtitle">Daftar alamat IP yang terbaca dari RouterOS.</p>
                        </div>

                        <span class="mtk-chip blue">Total IP: {{ $addressCount }}</span>
                    </div>

                    <div class="mtk-table-wrap">
                        <div class="mtk-table-scroll">
                            <table class="mtk-table">
                                <thead>
                                    <tr>
                                        <th>Address</th>
                                        <th>Network</th>
                                        <th>Interface</th>
                                        <th>Comment</th>
                                        <th>Flags</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($addresses as $address)
                                        <tr>
                                            <td class="strong">{{ data_get($address, 'address', '-') }}</td>
                                            <td>{{ data_get($address, 'network', '-') }}</td>
                                            <td>{{ data_get($address, 'interface', '-') }}</td>
                                            <td>{{ data_get($address, 'comment', '-') }}</td>
                                            <td>
                                                <div class="mtk-chip-row">
                                                    @if (data_get($address, 'dynamic') === 'true')
                                                        <span class="mtk-chip blue">Dynamic</span>
                                                    @endif

                                                    @if (data_get($address, 'disabled') === 'true')
                                                        <span class="mtk-chip red">Disabled</span>
                                                    @else
                                                        <span class="mtk-chip green">Active</span>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="mtk-empty">Belum ada data IP address.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </article>

                <article class="mtk-card">
                    <div class="mtk-card-header">
                        <div>
                            <h2 class="mtk-card-title">Raw System Resource</h2>
                            <p class="mtk-card-subtitle">
                                Data mentah dari command <code>/system/resource/print</code>.
                            </p>
                        </div>
                        <div class="mtk-card-icon">JSON</div>
                    </div>

                    <pre class="mtk-raw">{{ json_encode($resource, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                </article>
            </section>
        </div>
    </div>
</x-filament-panels::page>
