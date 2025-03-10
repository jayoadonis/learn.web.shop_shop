
//REM: [NOTE] .|. Heavily linked with 'global.css'

const Theme = Object.freeze({
    dark: "dark",
    light: "light"
});

const KEY_LOCAL_STORAGE_THEME = "gym_stone_color_theme";
const ID_TOGGLE_THEME = "el-id-toggle-theme";
const ID_TOGGLE_THEME_SLIDER = "el-id-toggle-theme-slider";
const ID_TOGGLE_THEME_CONTAINER = "el-id-toggle-theme-container";

function applyTheme(theme) {
    const elChkBoxToggleTheme = document.getElementById(ID_TOGGLE_THEME);
    const elToggleThemeSlider = document.getElementById(ID_TOGGLE_THEME_SLIDER);

    document.documentElement.setAttribute("data-color-theme", theme || Theme.light);
    if (elChkBoxToggleTheme) elChkBoxToggleTheme.checked = (theme === Theme.dark);
    if (elToggleThemeSlider) elToggleThemeSlider.textContent = theme.toUpperCase();

    //REM: Update theme on server (fire-and-forget approach)
    fetch("/public/resources/php/api/theme/toggle_theme.php", {
        method: "POST",
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ theme })
    })
    .then(res => res.json())
    .then(data => {
        if (!data.isSuccess) console.error("Server error:", data);
        else console.log("Server updated theme:", data);
    }).catch(error => console.error(`Fetch error: ${error}`));
}

function initEventListenerTheme() {
    const elToggleThemeContainer = document.getElementById(ID_TOGGLE_THEME_CONTAINER);

    if (!elToggleThemeContainer) {
        console.error("Missing element: el-id-toggle-theme-container");
        return;
    }

    let currentTheme = localStorage.getItem(KEY_LOCAL_STORAGE_THEME) || Theme.light;
    
    elToggleThemeContainer.addEventListener("click", function (event) {

        event.preventDefault();

        currentTheme = (currentTheme === Theme.dark) ? Theme.light : Theme.dark;
        localStorage.setItem(KEY_LOCAL_STORAGE_THEME, currentTheme);

        applyTheme(currentTheme);
    });
}

document.addEventListener("DOMContentLoaded", initEventListenerTheme, { passive: true });

// //REM: Ensure UI reflects correct theme when navigating back/forward
window.addEventListener("pageshow", () => {
    const currentTheme = localStorage.getItem(KEY_LOCAL_STORAGE_THEME) || Theme.light;
    applyTheme(currentTheme);
}, { passive: true });
