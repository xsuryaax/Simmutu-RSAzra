import $, { get } from 'jquery';
import 'datatables.net'; // Mengimpor fungsionalitas DataTables

/**
 * Menginisialisasi tabel DataTables default.
 */
const initJqueryDataTable = () => {
    // Cek apakah #table1 ada di DOM sebelum inisialisasi
    const table1El = $('#table1');
    if (table1El.length) {
        const jquery_datatable = table1El.DataTable({
            responsive: false,
            autoWidth: false,
            stateSave: true,
            lengthChange: false, 
            pageLength: 10,
            dom: 
                "<'table-custom-controls d-flex justify-content-between align-items-center mb-3'<'dt-search-container'f><'#table-actions-placeholder'>>" +
                "<'table-responsive'tr>" +
                "<'row mt-3'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 d-flex justify-content-md-end justify-content-center'p>>",
            language: {
                search: "",
                searchPlaceholder: "Cari data...",
                paginate: {
                    previous: "<",
                    next: ">"
                }
            },
            initComplete: function() {
                // Search input styling is now handled via CSS for better reliability
                const filterContainer = $('.dataTables_filter');
                if (filterContainer.length) {
                    const searchInput = filterContainer.find('input');
                    searchInput.attr('placeholder', 'Cari data...');
                    searchInput.removeClass('form-control-sm'); // Use standard sizing
                }

                // Move actions if they exist
                const actionContent = document.getElementById('table-actions-content');
                const actionPlaceholder = document.getElementById('table-actions-placeholder');
                if (actionContent && actionPlaceholder) {
                    actionPlaceholder.appendChild(actionContent);
                    actionContent.classList.remove('d-none');
                }

                // Move legends if they exist (now handles external placeholders)
                const legendContent = document.getElementById('table-legend-content');
                const legendPlaceholder = document.getElementById('table-legend-placeholder');
                if (legendContent && legendPlaceholder) {
                    legendPlaceholder.appendChild(legendContent);
                    legendContent.classList.remove('d-none');
                }
            }
        });
        // Terapkan pewarnaan saat draw event
        jquery_datatable.on('draw', setTableColor);
        return jquery_datatable;
    }
    return null;
}

/**
 * Menginisialisasi tabel DataTables dengan kustomisasi DOM dan paging.
 */
const initCustomizedDataTable = () => {
    // Cek apakah #table2 ada di DOM sebelum inisialisasi
    const table2El = $('#table2');
    if (table2El.length) {
        const customized_datatable = table2El.DataTable({
            responsive: false,
            pagingType: 'full_numbers',
            stateSave: true,
            dom:
                "<'row'<'col-4'l><'col-4'f>>" +
                "<'row dt-row'<'col-sm-12'tr>>" +
                "<'row'<'col-4'i><'col-8'p>>",
            "language": {
                "info": "Page _PAGE_ of _PAGES_",
                "lengthMenu": "_MENU_ ",
                "search": "",
                "searchPlaceholder": "Search.."
            }
        });
        // Terapkan pewarnaan saat draw event
        customized_datatable.on('draw', setTableColor);
        return customized_datatable;
    }
    return null;
}

/**
 * Fungsi untuk menambahkan kelas warna ke elemen pagination DataTables.
 */
const setTableColor = () => {
    // Cek hanya elemen pagination yang ada
    document.querySelectorAll('.dataTables_paginate .pagination').forEach(dt => {
        // Asumsi 'pagination-primary' adalah kelas dari template CSS Anda
        dt.classList.add('pagination-primary') 
    })
}

/**
 * Fungsi utama untuk menginisialisasi semua DataTables dan mengatur warna awal.
 */
const initializeDataTables = () => {
    // Atur warna segera setelah inisialisasi
    setTableColor(); 
    
    // Inisialisasi tabel
    initJqueryDataTable();
    initCustomizedDataTable();
}

// 2. Jalankan inisialisasi setelah DOM sepenuhnya dimuat
// Ini lebih aman daripada menjalankan langsung di root file, karena elemen #table1 dan #table2 mungkin belum ada.
document.addEventListener('DOMContentLoaded', initializeDataTables);

// Anda dapat mengekspor fungsi-fungsi inisialisasi jika diperlukan dari file JS lain
// export { initJqueryDataTable, initCustomizedDataTable, setTableColor };