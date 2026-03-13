/**
 * Dashboard Combined Chart JS
 * Style: Matching Analisa Data
 * Dependencies: Chart.js, Bootstrap Icons
 */

(() => {
    'use strict';

    // ─────────────────────────────────────────────────────────
    // CONFIG & STATE
    // ─────────────────────────────────────────────────────────
    const config = window.DashboardChartConfig || {};
    const CHART_URL   = config.chartUrl;
    const MONTHS_ALL  = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
    const QUARTER_MAP = { Tahun:[0,12], Q1:[0,3], Q2:[3,6], Q3:[6,9], Q4:[9,12] };

    let currentType    = 'imn';
    let currentUnit    = '';
    let currentQuarter = 'Tahun';
    let currentChartType = 'line';
    let currentSearch   = '';
    let dataCache       = {};
    let chartInstances  = {};
    let observer        = null;
    let searchTimeout   = null;

    // ─────────────────────────────────────────────────────────
    // INTERSECTION OBSERVER
    // ─────────────────────────────────────────────────────────
    function initObserver() {
        if (observer) observer.disconnect();
        
        observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const card = entry.target;
                    const indId = card.dataset.indicatorId;
                    const json = card.dataset.jsonData ? JSON.parse(card.dataset.jsonData) : null;
                    
                    // Add visible class for animation
                    card.classList.add('visible');
                    
                    if (indId && json && !card.classList.contains('loaded')) {
                        // Render chart
                        renderMiniChart(json);
                        card.classList.add('loaded');
                    }
                    
                    // We can keep observing for visibility class if we want, 
                    // but for "loaded" we only need it once.
                    // However, to keep standard behavior, we unobserve once fully loaded.
                    if (card.classList.contains('loaded')) {
                        observer.unobserve(card);
                    }
                }
            });
        }, {
            rootMargin: '50px', // Start loading slightly before they appear
            threshold: 0.1
        });
    }

    // ─────────────────────────────────────────────────────────
    // PLUGINS
    // ─────────────────────────────────────────────────────────
    const pencapaianLabelPlugin = {
        id: 'pencapaianLabel',
        afterDraw(chart) {
            const { ctx, scales: { x } } = chart;
            const dataset = chart.data.datasets[0]; // Pencapaian
            if (!dataset || !dataset.data) return;

            // Scale font and dot based on chart height (for PDF resolution)
            const isHighRes = chart.width > 800;
            const fontSize = isHighRes ? 18 : 10;
            const dotSize = isHighRes ? 5 : 3;
            const spacing = isHighRes ? 7 : 4;
            const offsetY = isHighRes ? 24 : 16;
            const textOffsetY = isHighRes ? 18 : 12;

            ctx.save();
            ctx.font = `600 ${fontSize}px sans-serif`;
            ctx.textBaseline = 'top';

            dataset.data.forEach((value, i) => {
                const xPos = x.getPixelForValue(i);
                if (isNaN(xPos)) return;
                
                const label = (value !== null && value !== undefined) ? Math.floor(value) + '%' : '-';
                const textWidth = ctx.measureText(label).width;
                const totalWidth = (dotSize * 2) + spacing + textWidth;
                
                // Calculate start X to center the dot + text combo
                const startX = xPos - (totalWidth / 2);
                
                // Draw Red Dot
                ctx.beginPath();
                ctx.arc(startX + dotSize, x.bottom + offsetY, dotSize, 0, Math.PI * 2);
                ctx.fillStyle = '#e63757';
                ctx.fill();
                
                // Draw Text
                ctx.fillStyle = '#333';
                ctx.textAlign = 'left';
                ctx.fillText(label, startX + (dotSize * 2) + spacing, x.bottom + textOffsetY);
            });
            ctx.restore();
        }
    };
    const whiteBackgroundPlugin = {
        id: 'whiteBackground',
        beforeDraw(chart) {
            const { ctx, width, height } = chart;
            ctx.save();
            ctx.fillStyle = '#ffffff';
            ctx.fillRect(0, 0, width, height);
            ctx.restore();
        }
    };

    // ─────────────────────────────────────────────────────────
    // INIT
    // ─────────────────────────────────────────────────────────
    document.addEventListener('DOMContentLoaded', () => {
        const jenisFilter = document.getElementById('jenisFilter');
        const unitFilter  = document.getElementById('unitFilter');
        const tahunFilter = document.getElementById('tahunFilter');
        const searchInput = document.getElementById('indicatorSearch');
        const quarterBtns = document.querySelectorAll('.btn-quarter');

        if (jenisFilter) {
            jenisFilter.addEventListener('change', e => {
                currentType = e.target.value;
                updateHeaderTitle();
                loadAndRender(currentType, currentTahunFilter(), currentUnitFilter());
            });
        }

        if (unitFilter) {
            unitFilter.addEventListener('change', e => {
                currentUnit = e.target.value;
                loadAndRender(currentType, currentTahunFilter(), currentUnitFilter());
            });
        }

        if (tahunFilter) {
            tahunFilter.addEventListener('change', () => {
                dataCache = {};
                if (searchInput) searchInput.value = ''; 
                currentSearch = '';
                loadAndRender(currentType, currentTahunFilter(), currentUnitFilter());
            });
        }

        if (searchInput) {
            searchInput.addEventListener('input', e => {
                currentSearch = e.target.value.toLowerCase().trim();
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    const cacheKey = getCacheKey();
                    if (dataCache[cacheKey]) {
                        buildGrid(currentType, dataCache[cacheKey]);
                    }
                }, 300);
            });
        }

        quarterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                quarterBtns.forEach(b => {
                    b.classList.remove('active', 'btn-primary');
                    b.classList.add('btn-light');
                    b.setAttribute('aria-pressed', 'false');
                });
                btn.classList.add('active', 'btn-primary');
                btn.classList.remove('btn-light');
                btn.setAttribute('aria-pressed', 'true');
                currentQuarter = btn.dataset.q;
                rebuildAllCharts();
            });
        });

        window.gantiTipeChart = function(type) {
            currentChartType = type;
            const btnBar  = document.getElementById('btnBar');
            const btnLine = document.getElementById('btnLine');
            if (btnBar && btnLine) {
                if(type === 'bar') {
                    btnBar.classList.replace('btn-light', 'btn-brand-standar');
                    btnBar.classList.add('active');
                    btnBar.setAttribute('aria-pressed', 'true');
                    btnLine.classList.replace('btn-brand-standar', 'btn-light');
                    btnLine.classList.remove('active');
                    btnLine.setAttribute('aria-pressed', 'false');
                } else {
                    btnLine.classList.replace('btn-light', 'btn-brand-standar');
                    btnLine.classList.add('active');
                    btnLine.setAttribute('aria-pressed', 'true');
                    btnBar.classList.replace('btn-brand-standar', 'btn-light');
                    btnBar.classList.remove('active');
                    btnBar.setAttribute('aria-pressed', 'false');
                }
            }
            rebuildAllCharts();
        };

        if (jenisFilter) {
            currentType = jenisFilter.value;
            currentUnit = unitFilter ? unitFilter.value : '';
            loadAndRender(currentType, currentTahunFilter(), currentUnitFilter());
        }
    });

    function currentTahunFilter() {
        const el = document.getElementById('tahunFilter');
        return el ? el.value : (new Date()).getFullYear();
    }

    function currentUnitFilter() {
        const el = document.getElementById('unitFilter');
        return el ? el.value : '';
    }

    function getCacheKey() {
        return `${currentType}_${currentTahunFilter()}_${currentUnitFilter()}`;
    }

    function updateHeaderTitle() {
        const titleEl = document.getElementById('multiChartTitle');
        const filterEl = document.getElementById('jenisFilter');
        
        if (titleEl && filterEl) {
            // Simply update text content since icon and badge are now siblings
            titleEl.textContent = `${filterEl.options[filterEl.selectedIndex].text} — Tahun ${currentTahunFilter()}`;
        }
    }

    // ─────────────────────────────────────────────────────────
    // FETCH & RENDER
    // ─────────────────────────────────────────────────────────
    async function loadAndRender(type, tahun, unitId = '') {
        const cacheKey = getCacheKey();
        if (dataCache[cacheKey]) {
            updateHeaderTitle();
            return buildGrid(type, dataCache[cacheKey]);
        }

        showLoader();

        try {
            // Use URLSearchParams for robust URL construction
            const params = new URLSearchParams();
            params.append('type', type);
            params.append('tahun', tahun);
            if (unitId) params.append('unit_id', unitId);

            const res  = await fetch(`${CHART_URL}?${params.toString()}`);
            const json = await res.json();
            if (!res.ok) throw new Error(json.message ?? 'Server error');

            dataCache[cacheKey] = json;
            updateHeaderTitle();
            buildGrid(type, json);
        } catch (err) {
            console.error('Fetch error:', err);
            const grid = document.getElementById('chartGrid');
            if(grid) grid.innerHTML = `<div class="chart-grid-loader text-danger">Gagal memuat data: ${err.message}</div>`;
        }
    }

    function buildGrid(type, json) {
        destroyAll();
        initObserver(); // Initialize a new observer for this batch
        
        const grid = document.getElementById('chartGrid');
        if (!grid) return;
        grid.innerHTML = '';

        let indikators = json.indikators ?? [];

        // Apply Search Filter Client-side
        if (currentSearch) {
            indikators = indikators.filter(ind => 
                (ind.nama || '').toLowerCase().includes(currentSearch) ||
                (ind.unit || '').toLowerCase().includes(currentSearch) ||
                (ind.kategori || '').toLowerCase().includes(currentSearch)
            );
        }

        if (indikators.length === 0) {
            grid.innerHTML = `<div class="chart-grid-loader col-12">${currentSearch ? 'Tidak ada indikator yang sesuai dengan pencarian.' : 'Tidak ada data indikator untuk jenis dan tahun ini.'}</div>`;
            return;
        }

        // --- UPDATE TOTAL INDICATOR BADGE ---
        const badgeEl = document.getElementById('totalIndikatorBadge');
        if (badgeEl) {
            badgeEl.textContent = `Total: ${indikators.length} Indikator`;
        }
        // ------------------------------------

        // Use requestAnimationFrame to chunk the grid building and avoid long tasks (TBT Optimization)
        let chunkIndex = 0;
        const chunkSize = 4;
        
        function renderNextChunk() {
            const end = Math.min(chunkIndex + chunkSize, indikators.length);
            for (let i = chunkIndex; i < end; i++) {
                const ind = indikators[i];
                const card = createCard(ind);
                grid.appendChild(card);
                observer.observe(card);
            }
            chunkIndex = end;
            if (chunkIndex < indikators.length) {
                requestAnimationFrame(renderNextChunk);
            }
        }
        
        requestAnimationFrame(renderNextChunk);
    }

    function createCard(ind) {
        const wrapper = document.createElement('div');
        wrapper.className = 'chart-card';
        wrapper.id = `card-${ind.id}`;
        
        // Store data for lazy loading
        wrapper.dataset.indicatorId = ind.id;
        wrapper.dataset.jsonData = JSON.stringify(ind);
        
        // Add click listener to open modal, but ignore clicks on the download dropdown
        wrapper.style.cursor = 'pointer';
        wrapper.onclick = function(e) {
            if (e.target.closest('.dropdown, .dropstart')) return; // Ignore dropdown clicks
            openDetailModal(ind.id);
        };

        let parts = [];
        if (ind.unit) parts.push(`<span class="me-2"><i class="bi bi-hospital me-1"></i>${escHtml(ind.unit)}</span>`);
        if (ind.kategori) parts.push(`<span><i class="bi bi-tags me-1"></i>${escHtml(ind.kategori)}</span>`);
        
        const subtitleHTML = parts.length > 0 
            ? `<div class="chart-ind-subtitle d-flex align-items-center flex-wrap pt-1">${parts.join('')}</div>`
            : '';

        wrapper.innerHTML = `
            <div class="chart-card-header align-items-center">
                <div class="chart-ind-info">
                    <div class="chart-ind-title">${escHtml(ind.nama)}</div>
                    ${subtitleHTML}
                </div>
                <div class="d-flex align-items-center flex-shrink-0 ms-auto">
                    <div class="dropdown me-3">
                        <button class="btn btn-danger btn-sm rounded d-flex align-items-center justify-content-center border-0 dropdown-toggle-custom btn-pdf-export text-white" type="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-boundary="window" title="Opsi Cetak PDF" style="width: 32px; height: 32px; padding: 0; transition: all 0.2s;">
                            <i class="bi bi-download"></i>
                        </button>
                        <ul class="dropdown-menu shadow-lg border-0 py-2 mt-1" style="font-size: 0.85rem; border-radius: 10px; min-width: 14rem;">
                            <li><h6 class="dropdown-header text-uppercase text-muted fw-bold pb-1" style="font-size: 0.75rem; letter-spacing: 0.5px;">Pilihan Ekspor</h6></li>
                            <li><a class="dropdown-item py-2 px-3 fw-medium d-flex align-items-center mb-1" href="#" onclick="downloadSatuPDF(event, ${ind.id}, '${escJs(ind.nama)}', false)"><i class="bi bi-file-bar-graph fs-5 me-3 text-secondary"></i>Cetak Grafik Saja</a></li>
                            <li><a class="dropdown-item py-2 px-3 fw-medium d-flex align-items-center bg-light text-dark rounded mx-2" href="#" onclick="downloadSatuPDF(event, ${ind.id}, '${escJs(ind.nama)}', true)"><i class="bi bi-file-earmark-medical fs-5 me-3 text-danger"></i>Beserta PDSA</a></li>
                        </ul>
                    </div>

                    <div class="chart-legend d-none d-sm-flex flex-shrink-0">
                        <span class="legend-item me-2">
                            <span class="legend-dot pencapaian"></span> <small>Pencapaian</small>
                        </span>
                        <span class="legend-item">
                            <span class="legend-dot standar"></span> <small>Standar: ${ind.arah_target === 'lebih_kecil' ? '≤' : '≥'} ${ind.target_value}%</small>
                        </span>
                    </div>
                </div>
            </div>
            <div class="chart-card-body">
                <canvas id="canvas-${ind.id}"></canvas>
            </div>`;
        return wrapper;
    }

    const quarterDividerPlugin = {
        id: 'quarterDivider',
        beforeDraw: (chart) => {
            const xAxis = chart.scales.x;
            const yAxis = chart.scales.y;
            if (!xAxis || !yAxis) return;
            
            const ctx = chart.ctx;
            ctx.save();
            ctx.strokeStyle = 'rgba(0, 0, 0, 0.15)'; // Subtle divider color
            ctx.lineWidth = 1;
            ctx.setLineDash([5, 5]);

            xAxis.ticks.forEach((tick, index) => {
                const label = tick.label || xAxis.getLabelForValue(tick.value);
                if (label === 'Mar' || label === 'Jun' || label === 'Sep') {
                    if (index < xAxis.ticks.length - 1) {
                        const x1 = xAxis.getPixelForTick(index);
                        const x2 = xAxis.getPixelForTick(index + 1);
                        const x = (x1 + x2) / 2;
                        
                        ctx.beginPath();
                        ctx.moveTo(x, yAxis.top);
                        ctx.lineTo(x, yAxis.bottom);
                        ctx.stroke();
                    }
                }
            });
            ctx.restore();
        }
    };

    function renderMiniChart(ind) {
        const ctx = document.getElementById(`canvas-${ind.id}`);
        if (!ctx) return;

        const [start, end] = QUARTER_MAP[currentQuarter] || [0, 12];
        const labels = MONTHS_ALL.slice(start, end);
        const hasil  = (ind.hasil ?? []).slice(start, end);
        const target = (ind.target ?? []).slice(start, end);

        if (chartInstances[ind.id]) chartInstances[ind.id].destroy();

        // Dynamic Color logic based on currentType
        // IMN = Red, IMPRS = Green, UNIT = Gray
        let chartColor = '#e63757'; // Default Red
        let bgColor = currentChartType === 'bar' ? '#e63757cc' : '#e6375711';
        
        if (currentType === 'imprs') {
            chartColor = '#198754'; // Green
            bgColor = currentChartType === 'bar' ? '#198754cc' : '#19875411';
        } else if (currentType === 'unit') {
            chartColor = '#6c757d'; // Gray
            bgColor = currentChartType === 'bar' ? '#6c757dcc' : '#6c757d11';
        }

        chartInstances[ind.id] = new Chart(ctx, {
            type: currentChartType,
            data: {
                labels,
                datasets: [
                    {
                        label: 'Pencapaian',
                        data: hasil,
                        borderColor: chartColor,
                        backgroundColor: bgColor,
                        borderWidth: 2.5,
                        tension: 0.35,
                        fill: currentChartType === 'line',
                        pointRadius: 4,
                        pointBackgroundColor: chartColor,
                        pointBorderColor: '#fff',
                        pointBorderWidth: 1.5,
                        order: 0
                    },
                    {
                        label: 'Standar',
                        data: target,
                        borderColor: '#2c7be5',
                        backgroundColor: 'transparent',
                        borderWidth: 2,
                        tension: 0.35,
                        pointRadius: 0,
                        borderDash: currentChartType === 'line' ? [6, 4] : [],
                        order: 1
                    }
                ]
            },
            options: {
                animation: false, // Disable animations for performance
                responsive: true,
                maintainAspectRatio: false,
                layout: { padding: { bottom: 20 } },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        callbacks: {
                            label: (ctx) => ` ${ctx.dataset.label}: ${ctx.parsed.y}%`
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#edf2f9',
                            drawBorder: false
                        },
                        ticks: { 
                            font: { size: 9, weight: '500' }, 
                            color: '#718af0',
                            stepSize: 20,
                            padding: 8,
                            callback: function(v) {
                                if (v === parseFloat(ind.target_value)) {
                                    return (ind.arah_target === 'lebih_kecil' ? '≤' : '≥') + v + '%';
                                }
                                return v + '%';
                            }
                        },
                        afterBuildTicks: (axis) => {
                            const targetVal = parseFloat(ind.target_value);
                            if (!isNaN(targetVal)) {
                                // Remove any ticks too close to the target to avoid overlap
                                axis.ticks = axis.ticks.filter(t => Math.abs(t.value - targetVal) > 5);
                                
                                if (!axis.ticks.some(t => t.value === targetVal)) {
                                    axis.ticks.push({ value: targetVal });
                                    axis.ticks.sort((a, b) => a.value - b.value);
                                }
                            }
                        }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { 
                            font: { size: 10 },
                            color: '#748194',
                            padding: 5
                        }
                    }
                }
            },
            plugins: [quarterDividerPlugin]
        });
    }

    function rebuildAllCharts() {
        const cacheKey = getCacheKey();
        const json = dataCache[cacheKey];
        if (!json) return;
        
        (json.indikators ?? []).forEach(ind => {
            const card = document.getElementById(`card-${ind.id}`);
            // Only rebuild if it was already lazily loaded
            if (card && card.classList.contains('loaded')) {
                renderMiniChart(ind);
            }
        });
    }

    function destroyAll() {
        Object.values(chartInstances).forEach(c => c.destroy());
        chartInstances = {};
        if (observer) observer.disconnect();
    }

    function showLoader() {
        const grid = document.getElementById('chartGrid');
        if (grid) {
            grid.innerHTML = `<div class="chart-grid-loader col-12">
                <div class="spinner-border spinner-border-sm text-primary me-2"></div>
                Memuat data indikator...
            </div>`;
        }
    }

    window.downloadSatuPDF = function(e, indId, nama, includePdsa) {
        if (e) { e.preventDefault(); e.stopPropagation(); }
        document.getElementById('inputIncludePdsa').value = includePdsa ? '1' : '0';
        submitPdfExport(null, nama, indId);
    };

    window.downloadSemuaPDF = async function(e) {
        e.preventDefault();
        const cacheKey = getCacheKey();
        const json = dataCache[cacheKey];
        if (!json || !json.indikators?.length) return alert('Data kosong');

        const indicators = json.indikators;
        const total = indicators.length;
        const batch = [];
        
        const overlay = document.getElementById('batchExportOverlay');
        const progress = document.getElementById('batchExportProgress');
        const form = document.getElementById('exportPdfForm');
        
        if (overlay) overlay.style.display = 'flex';
        
        try {
            // Re-use a single hidden canvas for all batch generation
            // Slightly reduced for batch to avoid massive payload/timeout, while still sharp for A4
            const tempCanvas = document.createElement('canvas');
            tempCanvas.width = 1000;
            tempCanvas.height = 500;
            tempCanvas.style.display = 'none';
            document.body.appendChild(tempCanvas);

            for (let i = 0; i < total; i++) {
                const ind = indicators[i];
                if (progress) progress.textContent = `Memproses indikator ${i + 1} / ${total}: ${ind.nama}`;
                
                const highResImage = await generateHighResImage(tempCanvas, ind, true);
                batch.push({
                    indicator_id: ind.id,
                    judul: ind.nama,
                    chart_image: highResImage
                });
                
                // Yield to main thread every item for better responsiveness in large batches
                await new Promise(r => requestAnimationFrame(r));
            }

            document.body.removeChild(tempCanvas);

            if (form) {
                const jenisText = document.getElementById('jenisFilter')?.options[document.getElementById('jenisFilter').selectedIndex].text || '';
                form.querySelector('input[name="is_batch"]').value = "1";
                form.querySelector('input[name="batch"]').value = JSON.stringify(batch);
                form.querySelector('input[name="tahun"]').value = currentTahunFilter();
                form.querySelector('input[name="judul"]').value = jenisText;
                form.submit();
                
                // Reset batch fields after short delay so subsequent single downloads work
                setTimeout(() => {
                    form.querySelector('input[name="is_batch"]').value = "";
                    form.querySelector('input[name="batch"]').value = "";
                }, 1000);
            }
        } catch (err) {
            console.error('Batch export error:', err);
            alert('Gagal menyiapkan laporan batch: ' + err.message);
        } finally {
            if (overlay) overlay.style.display = 'none';
        }
    };

    async function generateHighResImage(canvas, ind, isBatch = false) {
        const [start, end] = QUARTER_MAP[currentQuarter] || [0, 12];
        const labels = MONTHS_ALL.slice(start, end);
        const hasil  = (ind.hasil ?? []).slice(start, end);
        const target = (ind.target ?? []).slice(start, end);

        // Reduced for better "non-zoomed" look on A4
        const fontSize = isBatch ? 14 : 16;

        const tempChart = new Chart(canvas, {
            type: currentChartType,
            data: {
                labels,
                datasets: [
                    {
                        label: 'Pencapaian',
                        data: hasil,
                        borderColor: '#e63757',
                        backgroundColor: currentChartType === 'bar' ? '#e63757cc' : '#e6375711',
                        borderWidth: 3,
                        tension: 0.35,
                        fill: currentChartType === 'line',
                        pointRadius: 5,
                        pointBackgroundColor: '#e63757',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                    },
                    {
                        label: 'Standar',
                        data: target,
                        borderColor: '#2c7be5',
                        backgroundColor: 'transparent',
                        borderWidth: 2,
                        tension: 0.35,
                        pointRadius: 0,
                        borderDash: currentChartType === 'line' ? [8, 6] : [],
                    }
                ]
            },
            options: {
                animation: false,
                devicePixelRatio: 2,
                responsive: false, // Important for fixed canvas size
                plugins: { 
                    legend: { display: false },
                    pencapaianLabel: { enabled: true } 
                },
                scales: {
                    y: { 
                        beginAtZero: true, 
                        grid: { color: '#edf2f9', lineWidth: 2 },
                        ticks: { 
                            font: { size: fontSize, weight: '700' },
                            color: '#1a2b4b',
                            stepSize: 20,
                            padding: isBatch ? 5 : 8,
                            callback: function(v) {
                                if (v === parseFloat(ind.target_value)) {
                                    return (ind.arah_target === 'lebih_kecil' ? '≤' : '≥') + v + '%';
                                }
                                return v + '%';
                            }
                        },
                        afterBuildTicks: (axis) => {
                            const targetVal = parseFloat(ind.target_value);
                            if (!isNaN(targetVal)) {
                                axis.ticks = axis.ticks.filter(t => Math.abs(t.value - targetVal) > 5);
                                if (!axis.ticks.some(t => t.value === targetVal)) {
                                    axis.ticks.push({ value: targetVal });
                                    axis.ticks.sort((a, b) => a.value - b.value);
                                }
                            }
                        }
                    },
                    x: { 
                        grid: { display: false },
                        ticks: { font: { size: fontSize, weight: '700' }, color: '#1a2b4b', padding: isBatch ? 5 : 8 } 
                    }
                }
            },
            plugins: [pencapaianLabelPlugin, whiteBackgroundPlugin]
        });

        // Wait a tiny bit for render (50ms is usually enough for high-res once data is ready)
        await new Promise(r => setTimeout(r, 50));
        const img = canvas.toDataURL('image/jpeg', 0.7);
        tempChart.destroy();
        return img;
    }

    async function submitPdfExport(chart, judul, indicatorId) {
        const form = document.getElementById('exportPdfForm');
        if (!form) return;

        // --- High-Res Export Logic ---
        // Create hidden canvas for rendering high-quality image
        const tempCanvas = document.createElement('canvas');
        tempCanvas.width = 1200;  // Sharp enough for A4
        tempCanvas.height = 600;  
        tempCanvas.style.display = 'none';
        document.body.appendChild(tempCanvas);

        // Get current indicator data from cache
        const cacheKey = getCacheKey();
        const json = dataCache[cacheKey];
        const ind = (json.indikators ?? []).find(i => i.id === indicatorId);
        
        if (!ind) {
            document.body.removeChild(tempCanvas);
            return alert('Data tidak ditemukan');
        }

        const [start, end] = QUARTER_MAP[currentQuarter] || [0, 12];
        const labels = MONTHS_ALL.slice(start, end);
        const hasil  = (ind.hasil ?? []).slice(start, end);
        const target = (ind.target ?? []).slice(start, end);

        // Render to hidden canvas at high resolution
        const tempChart = new Chart(tempCanvas, {
            type: currentChartType,
            data: {
                labels,
                datasets: [
                    {
                        label: 'Pencapaian',
                        data: hasil,
                        borderColor: '#e63757',
                        backgroundColor: currentChartType === 'bar' ? '#e63757cc' : '#e6375711',
                        borderWidth: 3,
                        tension: 0.35,
                        fill: currentChartType === 'line',
                        pointRadius: 5,
                        pointBackgroundColor: '#e63757',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                    },
                    {
                        label: 'Standar',
                        data: target,
                        borderColor: '#2c7be5',
                        backgroundColor: 'transparent',
                        borderWidth: 2,
                        tension: 0.35,
                        pointRadius: 0,
                        borderDash: currentChartType === 'line' ? [8, 6] : [],
                    }
                ]
            },
            options: {
                animation: false,
                devicePixelRatio: 2, // High DPI
                plugins: { 
                    legend: { display: false },
                    pencapaianLabel: { enabled: true } // Ensure plugin runs
                },
                scales: {
                    y: { 
                        beginAtZero: true, 
                        grid: { color: '#edf2f9', lineWidth: 2 },
                        ticks: { 
                            font: { size: 22, weight: '700' }, // Much larger for PDF
                            color: '#1a2b4b',
                            stepSize: 20,
                            padding: 15,
                            callback: function(v) {
                                if (v === parseFloat(ind.target_value)) {
                                    return (ind.arah_target === 'lebih_kecil' ? '≤' : '≥') + v + '%';
                                }
                                return v + '%';
                            }
                        },
                        afterBuildTicks: (axis) => {
                            const targetVal = parseFloat(ind.target_value);
                            if (!isNaN(targetVal)) {
                                axis.ticks = axis.ticks.filter(t => Math.abs(t.value - targetVal) > 5);
                                if (!axis.ticks.some(t => t.value === targetVal)) {
                                    axis.ticks.push({ value: targetVal });
                                    axis.ticks.sort((a, b) => a.value - b.value);
                                }
                            }
                        }
                    },
                    x: { 
                        grid: { display: false },
                        ticks: { font: { size: 22, weight: '700' }, color: '#1a2b4b', padding: 10 } 
                    }
                }
            },
            plugins: [pencapaianLabelPlugin, whiteBackgroundPlugin]
        });

        // Wait a tiny bit for render
        await new Promise(r => setTimeout(r, 100));

        const highResImage = tempCanvas.toDataURL('image/jpeg', 0.8);
        
        // Cleanup
        tempChart.destroy();
        document.body.removeChild(tempCanvas);

        form.querySelector('input[name="chart_image"]').value = highResImage;
        form.querySelector('input[name="judul"]').value = judul;
        form.querySelector('input[name="indicator_id"]').value = indicatorId;
        form.querySelector('input[name="tahun"]').value = currentTahunFilter();
        form.submit();
    }

    // --- CHART MODAL LOGIC ---
    let mdChartInstance = null;
    let currentModalQuarter = 'Tahun';
    let cachedModalData = null;

    // Attach Event Listeners to Modal Quarter Buttons
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('#mdQuarterGroup .md-btn-quarter').forEach(btn => {
            btn.addEventListener('click', function() {
                currentModalQuarter = this.dataset.q;
                updateModalQuarterButtons();
                if (cachedModalData) renderModalContent();
            });
        });
    });

    function updateModalQuarterButtons() {
        document.querySelectorAll('#mdQuarterGroup .md-btn-quarter').forEach(btn => {
            if (btn.dataset.q === currentModalQuarter) {
                btn.classList.remove('btn-light', 'border');
                btn.classList.add('btn-primary', 'active');
            } else {
                btn.classList.remove('btn-primary', 'active');
                btn.classList.add('btn-light', 'border');
            }
        });
    }

    window.openDetailModal = async function(indId) {
        try {
            // Check if modal instance exists or create it
            const modalEl = document.getElementById('modalDetailChart');
            if (!modalEl) return;
            
            // Bootstrap might be loaded via import or globally
            const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
            modal.show();

            // Reset UI
            document.getElementById('mdLoader').classList.remove('d-none');
            document.getElementById('mdLoader').innerHTML = `
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <span class="ms-3 fw-semibold text-secondary">Sedang memuat rincian data...</span>
            `;
            document.getElementById('mdContent').classList.add('d-none');
            
            currentModalQuarter = currentQuarter; // Inherit dashboard context
            updateModalQuarterButtons();

            // Get Detail from API
            const tahun = currentTahunFilter();
            const res = await fetch(`/dashboard/indikator-detail/${indId}?tahun=${tahun}`);
            const data = await res.json();

            if (data.error) throw new Error(data.error);

            cachedModalData = data;
            renderModalContent();

        } catch (err) {
            console.error(err);
            document.getElementById('mdLoader').innerHTML = `<div class="alert alert-danger w-100 mx-4 border-0 border-start border-4 border-danger"><i class="bi bi-exclamation-triangle me-2"></i> Gagal memuat data: ${err.message}</div>`;
        }
    };

    function renderModalContent() {
        const data = cachedModalData;
        if (!data) return;

            // Populate Meta
            document.getElementById('mdIndikatorTitle').textContent = data.meta.nama_indikator;
            document.getElementById('mdIndikatorUnit').innerHTML = `<i class="bi bi-hospital me-1"></i> ${data.meta.nama_unit ?? 'Seluruh Rumah Sakit'}`;
            document.getElementById('mdIndikatorKategori').innerHTML = `<i class="bi bi-tags me-1"></i> ${data.meta.kategori_indikator}`;
            document.getElementById('mdIndikatorStandar').innerHTML = `<i class="bi bi-bullseye me-1"></i> Standar: ${data.meta.arah_target === 'lebih_kecil' ? '≤' : '≥'}${parseFloat(data.meta.target_indikator)}%`;
            
            // Slice Monthly Table and Chart Data based on currentModalQuarter
            const [startMonth, endMonth] = QUARTER_MAP[currentModalQuarter] || [0, 12];
            const activeMonths = MONTHS_ALL.slice(startMonth, endMonth);
            const activeMonthlyData = data.monthly.slice(startMonth, endMonth);
            const activeHasilData = data.hasil.slice(startMonth, endMonth);
            const activeTargetArray = arrayFill(0, endMonth - startMonth, parseFloat(data.meta.target_indikator));
            
            // Populate Monthly Table
            const tbodyBulanan = document.getElementById('mdTbodyBulanan');
            tbodyBulanan.innerHTML = '';
            
            let totalNum = 0;
            let totalDen = 0;
            let totalPencapaian = 0;
            let validMonths = 0;

            activeMonthlyData.forEach((m, idx) => {
                const target = parseFloat(data.meta.target_indikator);
                let achieved = false;
                if (data.meta.arah_target === 'lebih_kecil') {
                    achieved = m.pencapaian <= target && m.pencapaian !== null;
                } else {
                    achieved = m.pencapaian >= target && m.pencapaian !== null;
                }
                const colorClass = achieved ? 'text-success' : 'text-danger';
                
                // Format pencapaian to remove trailing .00
                const pencapaianVal = m.pencapaian !== null ? Number(m.pencapaian).toLocaleString('id-ID', { maximumFractionDigits: 2 }) + '%' : '-';

                tbodyBulanan.innerHTML += `
                    <tr>
                        <td class="fw-bold bg-light py-1">${activeMonths[idx]}</td>
                        <td class="py-1">${m.numerator.toLocaleString('id-ID')}</td>
                        <td class="py-1">${m.denominator.toLocaleString('id-ID')}</td>
                        <td class="fw-bold ${colorClass} py-1">${pencapaianVal}</td>
                    </tr>
                `;

                if (m.pencapaian !== null) {
                    totalPencapaian += parseFloat(m.pencapaian);
                    validMonths++;
                }
            });

            // Add Summary Row for Quarter
            if (currentModalQuarter !== 'Tahun') {
                const avgPencapaian = validMonths > 0 ? (totalPencapaian / 3) : 0; // Divided by 3 months in a quarter
                const target = parseFloat(data.meta.target_indikator);
                let avgAchieved = false;
                if (data.meta.arah_target === 'lebih_kecil') {
                    avgAchieved = avgPencapaian <= target;
                } else {
                    avgAchieved = avgPencapaian >= target;
                }
                
                const avgColorClass = avgAchieved ? 'text-success' : 'text-danger';
                const avgLabel = avgAchieved ? 'Tercapai' : 'Tidak Tercapai';
                const avgPencapaianVal = Number(avgPencapaian).toLocaleString('id-ID', { maximumFractionDigits: 2 }) + '%';

                tbodyBulanan.innerHTML += `
                    <tr class="table-secondary">
                        <td colspan="3" class="fw-bold text-center py-2">Rata-rata ${currentModalQuarter} (${avgLabel}):</td>
                        <td class="fw-bold py-2 text-center border-start border-light ${avgColorClass}">${avgPencapaianVal}</td>
                    </tr>
                `;
            }

            // Populate PDSA Table
            const tbodyPdsa = document.getElementById('mdTbodyPdsa');
            tbodyPdsa.innerHTML = '';
            let hasPdsa = false;
            
            let pdsaKeys = Object.keys(data.pdsa);
            if (currentModalQuarter !== 'Tahun') {
                pdsaKeys = pdsaKeys.filter(q => q === currentModalQuarter);
            }

            pdsaKeys.forEach(qName => {
                const p = data.pdsa[qName];
                if (p && p.status !== 'Belum Ada') {
                    hasPdsa = true;
                    tbodyPdsa.innerHTML += `
                        <tr>
                            <td class="fw-bold align-middle text-center py-1">${qName}</td>
                            <td class="align-middle text-center py-1"><span class="badge bg-${p.color}">${p.status}</span></td>
                            <td class="text-start align-top py-1" style="font-size: 0.8rem; white-space: pre-wrap;"><small>${escHtml(p.plan)}</small></td>
                            <td class="text-start align-top py-1" style="font-size: 0.8rem; white-space: pre-wrap;"><small>${escHtml(p.do)}</small></td>
                            <td class="text-start align-top py-1" style="font-size: 0.8rem; white-space: pre-wrap;"><small>${escHtml(p.study)}</small></td>
                            <td class="text-start align-top py-1" style="font-size: 0.8rem; white-space: pre-wrap;"><small>${escHtml(p.action)}</small></td>
                        </tr>
                    `;
                }
            });

            if (!hasPdsa) {
                const emptyMessage = currentModalQuarter !== 'Tahun' ? `Tidak ada penugasan PDSA untuk ${currentModalQuarter}.` : `Tidak ada penugasan PDSA untuk tahun ini.`;
                tbodyPdsa.innerHTML = `<tr><td colspan="6" class="text-center text-muted py-3">${emptyMessage}</td></tr>`;
            }

            // Configure Chart
            const ctx = document.getElementById('mdChartCanvas');
            if (mdChartInstance) mdChartInstance.destroy();
            
            // Dynamic Color logic based on currentType
            let chartColor = '#e63757'; // Default Red
            let bgColor = currentChartType === 'bar' ? '#e63757cc' : '#e6375711';
            
            if (currentType === 'imprs') {
                chartColor = '#198754'; // Green
                bgColor = currentChartType === 'bar' ? '#198754cc' : '#19875411';
            } else if (currentType === 'unit') {
                chartColor = '#6c757d'; // Gray
                bgColor = currentChartType === 'bar' ? '#6c757dcc' : '#6c757d11';
            }

            mdChartInstance = new Chart(ctx, {
                type: currentChartType,
                data: {
                    labels: activeMonths,
                    datasets: [
                        {
                            label: 'Pencapaian',
                            data: activeHasilData,
                            borderColor: chartColor,
                            backgroundColor: bgColor,
                            borderWidth: 2.5,
                            tension: 0.35,
                            fill: currentChartType === 'line',
                            pointRadius: 4,
                            pointBackgroundColor: chartColor,
                            pointBorderColor: '#fff',
                            pointBorderWidth: 1.5,
                            order: 0
                        },
                        {
                            label: 'Standar',
                            data: activeTargetArray,
                            borderColor: '#2c7be5',
                            backgroundColor: 'transparent',
                            borderWidth: 2,
                            tension: 0.35,
                            pointRadius: 0,
                            borderDash: currentChartType === 'line' ? [6, 4] : [],
                            order: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { 
                        legend: { display: false },
                        pencapaianLabel: { enabled: true }
                    },
                    scales: {
                        y: { 
                            beginAtZero: true, 
                            grid: { borderDash: [4, 4] }
                        },
                        x: { 
                            grid: { display: false } 
                        }
                    }
                },
                plugins: [pencapaianLabelPlugin, quarterDividerPlugin]
            });

            // Show Content
            document.getElementById('mdLoader').classList.add('d-none');
            document.getElementById('mdContent').classList.remove('d-none');

    }

    function arrayFill(start, count, value) {
        return Array(count).fill(value);
    }

    function escHtml(str) {
        if (!str) return '';
        const d = document.createElement('div');
        d.textContent = str;
        return d.innerHTML;
    }
    function escJs(str) {
        return str ? str.replace(/'/g, "\\'") : '';
    }

})();
