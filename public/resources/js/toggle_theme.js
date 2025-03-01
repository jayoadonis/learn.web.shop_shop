document.addEventListener("DOMContentLoaded", () => {

    handleThemeColor();
});


function handleThemeColor() {

    const LS_THEME_KEY = "theme_toggle"; //REM: LocalStorage Key
    const btnThemeToggle = document.getElementById("toggle-theme-container");
    const toggleTheme = document.getElementById("toggle-theme");
    const toggleThemeSlider = document.getElementById("toggle-theme-slider");

    if (!btnThemeToggle || !toggleTheme) {
        console.error("Missing required element id(s): (toggle-theme-container)");
        return;
    }

    //REM: Get saved theme from localStorage, default to "light" if not set
    let currentTheme = localStorage.getItem(LS_THEME_KEY) || "light";
    localStorage.setItem(LS_THEME_KEY, currentTheme);

    //REM: Apply theme
    document.documentElement.setAttribute("color-theme", currentTheme);

    //REM: Sync toggle button state with theme
    toggleTheme.checked = (currentTheme === "dark");

    toggleThemeSlider.textContent = currentTheme.toUpperCase();

    // toggleTheme.addEventListener("change", (event) => {

    //     event.preventDefault();
    // });

    btnThemeToggle.addEventListener("click", (event) => {

        event.preventDefault();

        toggleTheme.checked = (!toggleTheme.checked);

        const newTheme = toggleTheme.checked ? "dark" : "light";

        toggleThemeSlider.textContent = newTheme.toUpperCase();


        localStorage.setItem(LS_THEME_KEY, newTheme);
        document.documentElement.setAttribute("color-theme", newTheme);

    });

    return;
}