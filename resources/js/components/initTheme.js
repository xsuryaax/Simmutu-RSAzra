
const getPreferredTheme = () => {
    // 1. Cek jika pengguna pernah menyimpan pilihan
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme) {
        return savedTheme;
    }
    // 2. Jika belum, cek preferensi sistem operasi
    return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
}

/**
 * Mengatur tema pada elemen <html> dan menyimpan ke LocalStorage
 */
const setTheme = (theme) => {
    // Terapkan class 'dark' pada elemen HTML root
    if (theme === 'dark') {
        document.documentElement.classList.add('dark');
        document.documentElement.setAttribute('data-bs-theme', 'dark'); // Untuk Bootstrap 5
        localStorage.setItem('theme', 'dark');
    } else {
        document.documentElement.classList.remove('dark');
        document.documentElement.setAttribute('data-bs-theme', 'light'); // Untuk Bootstrap 5
        localStorage.setItem('theme', 'light');
    }
}

/**
 * Sinkronisasi state toggle (checkbox) dengan tema yang aktif
 */
const syncToggleState = () => {
    const toggle = document.getElementById('toggle-dark');
    if (toggle) {
        const currentTheme = getPreferredTheme();
        // Atur status checked pada toggle
        toggle.checked = (currentTheme === 'dark'); 
    }
}

/**
 * Handler utama untuk mengubah tema saat toggle diklik
 */
const handleThemeToggle = () => {
    const toggle = document.getElementById('toggle-dark');

    if (toggle) {
        toggle.addEventListener('change', () => {
            const newTheme = toggle.checked ? 'dark' : 'light';
            setTheme(newTheme);
        });
    }
}

// ----------------------------------------------------
// Eksekusi Saat DOM Dimuat
// ----------------------------------------------------

document.addEventListener('DOMContentLoaded', () => {
    // 1. Terapkan tema yang tersimpan/disukai saat pertama kali halaman dimuat
    setTheme(getPreferredTheme());
    
    // 2. Sinkronkan status checkbox
    syncToggleState();
    
    // 3. Tambahkan event listener untuk toggle
    handleThemeToggle();
});

// Anda bisa mengekspor fungsi jika diperlukan di file lain
// export { setTheme, getPreferredTheme };