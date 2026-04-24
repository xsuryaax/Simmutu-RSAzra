const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Des'];

let chart = null;
let chartType = 'line';
let currentCategory = 'Nasional'; // State to store current category
let isSpmMode = false; // State to store if we are in SPM mode

function getIndicatorColors(category, type = 'line') {
    let color = '#e63757'; // Default Red (Nasional)
    const cat = category ? category.toLowerCase() : '';
    
    if (cat.includes('rs') || cat.includes('imprs') || cat.includes('rumah sakit')) {
        color = '#198754'; // Green
    } else if (cat.includes('unit') || cat.includes('prioritas unit')) {
        color = '#6c757d'; // Gray
    } else if (cat.includes('spm')) {
        color = '#fd7e14'; // Orange for SPM
    }
    
    return {
        borderColor: color,
        backgroundColor: type === 'bar' ? `${color}cc` : `${color}11`,
        pointColor: color
    };
}

// Untuk nilai di bawah sumbu X — selalu dibulatkan, tanpa desimal
function formatNumber(value) {
    if (value === null || value === undefined || value === "-") {
        return "-";
    }
    return Math.round(parseFloat(value));
}

// Untuk nilai di titik chart — 2 desimal hanya jika tidak bulat
function formatNumberDetail(value) {
    if (value === null || value === undefined) return "-";
    let num = parseFloat(value);
    return num % 1 === 0 ? num.toFixed(0) : num.toFixed(2);
}

// Plugin untuk menampilkan nilai pencapaian langsung di bawah label bulan
const pencapaianLabelPlugin = {
    id: 'pencapaianLabel',
    afterDraw(chart) {
        const { ctx, scales: { x } } = chart;
        const realisasiDataset = chart.data.datasets[1];

        if (!realisasiDataset || !realisasiDataset.data) return;

        ctx.save();
        ctx.font = '11px sans-serif';
        ctx.textAlign = 'center';
        ctx.textBaseline = 'top';

        // Titik indikator di paling kiri
        const dotRadius = 4;
        const dotX = x.left - 25;
        const dotY = x.bottom + 20;
        ctx.beginPath();
        ctx.arc(dotX, dotY, dotRadius, 0, Math.PI * 2);
        
        const colors = getIndicatorColors(currentCategory);
        ctx.fillStyle = colors.pointColor;
        ctx.fill();

        // Nilai pencapaian sejajar dengan bulan — dibulatkan
        realisasiDataset.data.forEach((value, i) => {
            const xPos = x.getPixelForValue(i);
            const yPos = x.bottom + 14;

            const label = (value !== null && value !== undefined)
                ? formatNumber(value) + '%'
                : '-';

            ctx.fillStyle = '#555';
            ctx.fillText(label, xPos, yPos);
        });

        ctx.restore();
    }
};

function renderChart(targetData = [], realisasiData = []) {
    const ctx = document.getElementById('indicatorChart');
    if (!ctx) return;

    if (chart) {
        chart.destroy();
    }

    chart = new Chart(ctx.getContext('2d'), {
        type: chartType,
        data: {
            labels: months,
            datasets: [
                {
                    label: ' Standar',
                    data: targetData,
                    borderColor: '#2c7be5',
                    backgroundColor: 'transparent',
                    borderWidth: 2,
                    tension: 0.3,
                    pointRadius: 0,
                    borderDash: chartType === 'line' ? [6, 4] : [],
                    order: 1
                },
                {
                    label: ' Pencapaian',
                    data: realisasiData,
                    borderColor: getIndicatorColors(currentCategory).borderColor,
                    backgroundColor: getIndicatorColors(currentCategory, chartType).backgroundColor,
                    borderWidth: 2.5,
                    tension: 0.35,
                    fill: chartType === 'line',
                    pointRadius: 4,
                    pointBackgroundColor: getIndicatorColors(currentCategory).pointColor,
                    pointBorderColor: '#fff',
                    pointBorderWidth: 1.5,
                    order: 0
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            layout: {
                padding: {
                    bottom: 45
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                // Tooltip saat hover — tampilkan 2 desimal
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            const value = context.parsed.y;
                            if (value === null || value === undefined) return '-';
                            return ` ${context.dataset.label.trim()}: ${formatNumberDetail(value)}%`;
                        }
                    }
                },
                // Label langsung di atas titik — tampilkan 2 desimal
                datalabels: false
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 10,
                        callback: value => value + "%"
                    }
                },
                x: {
                    ticks: {
                        padding: 4
                    }
                }
            }
        },
        plugins: [pencapaianLabelPlugin]
    });
}

window.loadChart = function (indikatorId, namaIndikator, namaUnit, kategori, unitId) {
    document.getElementById('chart-title').textContent = namaIndikator;
    document.getElementById('chart-subtitle').textContent = namaUnit;
    currentCategory = kategori || 'Nasional';
    isSpmMode = (kategori === 'SPM');

    // Highlight row
    document.querySelectorAll('table tbody tr').forEach(row => {
        row.classList.remove('table-active');
    });
    
    const selector = isSpmMode 
        ? `tr[data-id="${indikatorId}"]` 
        : `tr[data-id="${indikatorId}"][data-unit="${unitId}"]`;
    const selectedRow = document.querySelector(selector);
    if (selectedRow) {
        selectedRow.classList.add('table-active');
    }

    // Update legend dot color in view
    const legendDot = document.querySelector('.legend-dot.realisasi');
    if (legendDot) {
        legendDot.style.backgroundColor = getIndicatorColors(currentCategory).pointColor;
    }

    const tahun = document.querySelector('select[name="tahun"]').value;
    const chartUrl = isSpmMode
        ? `/analisa-spm/chart/${indikatorId}?tahun=${tahun}`
        : `/analisa-data/chart/${indikatorId}?tahun=${tahun}`;

    fetch(chartUrl)
        .then(res => {
            if (!res.ok) throw new Error('Network response was not ok');
            return res.json();
        })
        .then(res => {
            renderChart(res.target, res.realisasi);
        })
        .catch(err => {
            console.error(err);
            alert("Gagal memuat data chart");
        });
};

window.openModal = function (id, nama, analisa = '', tindakLanjut = '', unitId = null) {
    const idInput = document.getElementById('indikator_id') || document.getElementById('spm_id');
    if (idInput) idInput.value = id;

    // Store unitId for saveAnalysis
    const modal = document.getElementById('analysisModal');
    if (unitId) modal.setAttribute('data-unit-id', unitId);

    document.getElementById('analysisModalLabel').textContent = `Edit Analisa untuk ${nama}`;
    document.getElementById('analisa').value = analisa;
    document.getElementById('tindak_lanjut').value = tindakLanjut;

    const modalInstance = new bootstrap.Modal(document.getElementById('analysisModal'));
    modalInstance.show();
};

window.saveAnalysis = function () {
    const analysisModalElem = document.getElementById('analysisModal');
    const idInput = document.getElementById('indikator_id') || document.getElementById('spm_id');
    const idValue = idInput ? idInput.value : null;
    const unitId = analysisModalElem.getAttribute('data-unit-id');
    const analisa = document.getElementById('analisa').value;
    const tindak_lanjut = document.getElementById('tindak_lanjut').value;
    const tahun = document.querySelector('select[name="tahun"]').value;
    const bulan = document.querySelector('select[name="bulan"]').value;

    const formData = new FormData();
    if (isSpmMode) {
        formData.append('spm_id', idValue);
    } else {
        formData.append('indikator_id', idValue);
    }
    formData.append('analisa', analisa);
    formData.append('tindak_lanjut', tindak_lanjut);
    formData.append('tahun', tahun);
    formData.append('bulan', bulan);
    if (unitId) formData.append('unit_id', unitId);

    fetch(analisaStoreUrl, {
        method: "POST",
        headers: { "X-CSRF-TOKEN": csrfToken },
        body: formData
    })
        .then(res => res.json())
        .then(res => {
            if (res.success) {
                alert("Analisa berhasil disimpan");
                location.reload();
            }
        })
        .catch(err => {
            console.error(err);
            alert("Terjadi error di server");
        });
};

document.addEventListener('DOMContentLoaded', function () {
    if (typeof firstIndikator !== "undefined" && firstIndikator) {
        loadChart(
            firstIndikator.id,
            firstIndikator.nama_indikator,
            firstIndikator.nama_unit,
            firstIndikator.kategori_indikator,
            firstIndikator.unit_id
        );
    }

    if (typeof firstSpm !== "undefined" && firstSpm) {
        loadChart(
            firstSpm.id,
            firstSpm.nama_spm,
            firstSpm.nama_unit,
            "SPM",
            firstSpm.unit_id
        );
    }


    document.getElementById('line-chart-btn')?.addEventListener('click', () => {
        chartType = 'line';
        if (chart) {
            renderChart(
                chart.data.datasets[0].data,
                chart.data.datasets[1].data
            );
        }
    });

    document.getElementById('bar-chart-btn')?.addEventListener('click', () => {
        chartType = 'bar';
        if (chart) {
            renderChart(
                chart.data.datasets[0].data,
                chart.data.datasets[1].data
            );
        }
    });
});