// Ambil elemen checkbox toggle
const toggleCheckbox = document.getElementById('toggle-dark');
const html = document.documentElement; // Target elemen <html>

// Cek preferensi dari localStorage (default: false/light)
const isDark = localStorage.getItem('theme') === 'dark';
toggleCheckbox.checked = isDark; // Set checkbox sesuai preferensi
html.classList.toggle('dark', isDark); // Terapkan class dark jika perlu

// Event listener untuk perubahan checkbox
toggleCheckbox.addEventListener('change', () => {
  const isChecked = toggleCheckbox.checked;
  html.classList.toggle('dark', isChecked);
  localStorage.setItem('theme', isChecked ? 'dark' : 'light');
});