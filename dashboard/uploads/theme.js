// theme.js
(function () {
  document.addEventListener('DOMContentLoaded', function () {
    const body = document.body;
    const storageKey = 'site-theme'; // stored value: 'dark' or 'light'
    const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;

    // Compute initial theme: localStorage -> prefers-color-scheme -> light
    const saved = localStorage.getItem(storageKey);
    const initialTheme = saved ? saved : (prefersDark ? 'dark' : 'light');

    function applyTheme(theme) {
      if (theme === 'dark') body.classList.add('dark');
      else body.classList.remove('dark');
    }
    applyTheme(initialTheme);

    // Toggle button
    const btn = document.getElementById('themeToggle');
    function updateToggleIcon() {
      if (!btn) return;
      const icon = btn.querySelector('i');
      if (!icon) return;
      if (body.classList.contains('dark')) {
        icon.className = 'fas fa-sun icon-purple';   // sun icon in purple
        btn.title = 'Switch to light mode';
      } else {
        icon.className = 'fas fa-moon icon-purple';  // moon icon in purple
        btn.title = 'Switch to dark mode';
      }
    }
    updateToggleIcon();

    if (btn) {
      btn.addEventListener('click', function () {
        const newTheme = body.classList.contains('dark') ? 'light' : 'dark';
        applyTheme(newTheme);
        localStorage.setItem(storageKey, newTheme);
        updateToggleIcon();
      });
    }
  });
})();

// Button toggle (for header icon)
const toggleBtn = document.getElementById("themeToggleBtn");

if (toggleBtn) {
  toggleBtn.addEventListener("click", () => {
    if (document.body.classList.contains("dark-mode")) {
      document.body.classList.remove("dark-mode");
      document.body.classList.add("light-mode");
      localStorage.setItem("theme", "light");
      toggleBtn.innerHTML = '<i class="fas fa-sun"></i>';
    } else {
      document.body.classList.remove("light-mode");
      document.body.classList.add("dark-mode");
      localStorage.setItem("theme", "dark");
      toggleBtn.innerHTML = '<i class="fas fa-moon"></i>';
    }
  });
}


// theme.js
const toggle = document.getElementById("darkModeToggle");

// On load: apply saved theme
if (localStorage.getItem("theme") === "dark") {
  document.body.classList.add("dark-mode");
  if (toggle) toggle.checked = true;
} else {
  document.body.classList.add("light-mode");
  if (toggle) toggle.checked = false;
}

// Toggle theme when user clicks
if (toggle) {
  toggle.addEventListener("change", () => {
    if (toggle.checked) {
      document.body.classList.remove("light-mode");
      document.body.classList.add("dark-mode");
      localStorage.setItem("theme", "dark");
    } else {
      document.body.classList.remove("dark-mode");
      document.body.classList.add("light-mode");
      localStorage.setItem("theme", "light");
    }
  });
}

