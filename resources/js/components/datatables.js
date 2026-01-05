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
            responsive: true,
            autoWidth: false,
            dom: 
                "<'row align-items-center'<'col-sm-12 col-md-1'l><'col-md-8 d-none d-md-block'><'col-sm-12 col-md-3'f>>" + 
                "<'row dt-row'<'col-sm-12'tr>>" + 
                "<'row mt-3'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            "language": {
                "info": "Page _PAGE_ of _PAGES_",
                "lengthMenu": "_MENU_ ",
                "search": "",
                "searchPlaceholder": "Search.."
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
            responsive: true,
            pagingType: 'full_numbers',
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