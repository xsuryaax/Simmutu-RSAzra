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
            const icon = '<i class="bi bi-bar-chart-line-fill me-2 text-primary"></i>';
            titleEl.innerHTML = icon + filterEl.options[filterEl.selectedIndex].text + ' — Tahun ' + currentTahunFilter();
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
                <div class="chart-legend mx-2 d-none d-sm-flex flex-shrink-0">
                    <span class="legend-item me-2">
                        <span class="legend-dot pencapaian"></span> <small>Pencapaian</small>
                    </span>
                    <span class="legend-item">
                        <span class="legend-dot standar"></span> <small>Standar: ${ind.arah_target === 'lebih_kecil' ? '≤' : '≥'} ${ind.target_value}%</small>
                    </span>
                </div>
                <button class="btn btn-xs btn-download-ind ms-2 flex-shrink-0"
                        onclick="downloadSatuPDF(${ind.id}, '${escJs(ind.nama)}')"
                        title="Download PDF"
                        aria-label="Download PDF untuk ${escHtml(ind.nama)}">
                    <i class="bi bi-download" style="font-size: .8rem;"></i>
                </button>
            </div>
            <div class="chart-card-body">
                <canvas id="canvas-${ind.id}"></canvas>
            </div>`;
        return wrapper;
    }

    function renderMiniChart(ind) {
        const ctx = document.getElementById(`canvas-${ind.id}`);
        if (!ctx) return;

        const [start, end] = QUARTER_MAP[currentQuarter] || [0, 12];
        const labels = MONTHS_ALL.slice(start, end);
        const hasil  = (ind.hasil ?? []).slice(start, end);
        const target = (ind.target ?? []).slice(start, end);

        if (chartInstances[ind.id]) chartInstances[ind.id].destroy();

        chartInstances[ind.id] = new Chart(ctx, {
            type: currentChartType,
            data: {
                labels,
                datasets: [
                    {
                        label: 'Pencapaian',
                        data: hasil,
                        borderColor: '#e63757',
                        backgroundColor: currentChartType === 'bar' ? '#e63757cc' : '#e6375711',
                        borderWidth: 2.5,
                        tension: 0.35,
                        fill: currentChartType === 'line',
                        pointRadius: 4,
                        pointBackgroundColor: '#e63757',
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
            plugins: [pencapaianLabelPlugin]
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

    window.downloadSatuPDF = function(indId, nama) {
        // No need for chart instances, submitPdfExport renders its own from cache
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
            tempCanvas.width = 1200;
            tempCanvas.height = 600;
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
                form.querySelector('input[name="is_batch"]').value = "1";
                form.querySelector('input[name="batch"]').value = JSON.stringify(batch);
                form.querySelector('input[name="tahun"]').value = currentTahunFilter();
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
            plugins: [pencapaianLabelPlugin]
        });

        // Wait a tiny bit for render (50ms is usually enough for high-res once data is ready)
        await new Promise(r => setTimeout(r, 50));
        const img = tempChart.toBase64Image();
        tempChart.destroy();
        return img;
    }

    async function submitPdfExport(chart, judul, indicatorId) {
        const form = document.getElementById('exportPdfForm');
        if (!form) return;

        // --- High-Res Export Logic ---
        // Create hidden canvas for rendering high-quality image
        const tempCanvas = document.createElement('canvas');
        tempCanvas.width = 1600;  // Extra wide for sharp PDF
        tempCanvas.height = 800;  // Extra height
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
            plugins: [pencapaianLabelPlugin]
        });

        // Wait a tiny bit for render
        await new Promise(r => setTimeout(r, 100));

        const highResImage = tempChart.toBase64Image();
        
        // Cleanup
        tempChart.destroy();
        document.body.removeChild(tempCanvas);

        // Submit form
        form.querySelector('input[name="chart_image"]').value = highResImage;
        form.querySelector('input[name="judul"]').value = judul;
        form.querySelector('input[name="indicator_id"]').value = indicatorId;
        form.querySelector('input[name="tahun"]').value = currentTahunFilter();
        form.submit();
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
