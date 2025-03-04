document.addEventListener("DOMContentLoaded", function() {

    handleThemeColor();
}, {
    passive: true
});

window.addEventListener("pageshow", function(event) {
    //REM: check event.persisted to only run when the page is loaded from bfcache:
    if (event.persisted) {
        handleThemeColor();
    }
}, {
    passive: true
});


function handleThemeColor() {
    const LS_THEME_KEY = "theme_toggle"; //REM: LocalStorage key
    const btnThemeToggle = document.getElementById("toggle-theme-container");
    const toggleTheme = document.getElementById("toggle-theme");
    const toggleThemeSlider = document.getElementById("toggle-theme-slider");

    if (!btnThemeToggle || !toggleTheme || !toggleThemeSlider) {
        console.error("Missing required element id(s): toggle-theme-container, toggle-theme, or toggle-theme-slider");
        return;
    }

    //REM: Get saved theme from localStorage, default to "light" if not set
    let currentTheme = localStorage.getItem(LS_THEME_KEY) || "light";
    localStorage.setItem(LS_THEME_KEY, currentTheme);

    //REM: Update UI with the current theme
    function applyTheme(theme) {
        document.documentElement.setAttribute("color-theme", theme);
        toggleTheme.checked = theme === "dark";
        toggleThemeSlider.textContent = theme.toUpperCase();
    }

    //REM: Initialize theme on page load
    applyTheme(currentTheme);

    //REM: Toggle theme on button click
    btnThemeToggle.addEventListener("click", function(event) {
        event.preventDefault();
        currentTheme = currentTheme === "dark" ? "light" : "dark";
        localStorage.setItem(LS_THEME_KEY, currentTheme);
        applyTheme(currentTheme);
    });
}