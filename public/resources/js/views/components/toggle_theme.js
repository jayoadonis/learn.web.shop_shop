
//REM: [NOTE] .|. Heavily linked with 'global.css'

document.addEventListener( 
    "DOMContentLoaded", 
    function() {

        console.log(ID_TOGGLE_THEME, "[DOMContentLoaded]");

        initEventListenerTheme();
    }, 
    { passive: true } 
);

// //REM: Ensure UI reflects correct theme when navigating back/forward
window.addEventListener("pageshow", () => {

    console.log(ID_TOGGLE_THEME, "[pageshow]");

    const currentTheme = localStorage.getItem(KEY_LOCAL_STORAGE_THEME) || Theme.light;

    applyTheme(currentTheme);

    // pilotColorTheme(currentTheme);
}, { passive: true });


const Theme = Object.freeze({
    dark: "dark",
    light: "light"
});

const KEY_LOCAL_STORAGE_THEME       = "gym_stone_color_theme";
const ID_TOGGLE_THEME               = "el-id-toggle-theme";
const ID_TOGGLE_THEME_SLIDER        = "el-id-toggle-theme-slider";
const ID_TOGGLE_THEME_CONTAINER     = "el-id-toggle-theme-container";
const ATTR_DATA_COLOR_THEME         = "data-color-theme";


function initEventListenerTheme() {

    console.log(ID_TOGGLE_THEME, "initEventListenerTheme");

    const elToggleThemeContainer = document.getElementById(ID_TOGGLE_THEME_CONTAINER);

    if (!elToggleThemeContainer) {
        
        console.error(`Missing element: ${ID_TOGGLE_THEME_CONTAINER}`);
        return;
    }

    const currentTheme = localStorage.getItem(KEY_LOCAL_STORAGE_THEME) || Theme.light;
    pilotColorTheme(currentTheme);
     
    elToggleThemeContainer.addEventListener("click", function (event) {

        console.log(ID_TOGGLE_THEME, "[click]");

        event.preventDefault();

        let currentTheme = localStorage.getItem(KEY_LOCAL_STORAGE_THEME) || Theme.light;

        currentTheme = (currentTheme === Theme.dark) ? Theme.light : Theme.dark;

        //REM: [LITLE_BIT_OPTMIZATION] .|. We don't want to put it inside of 'applyTheme(string)'
        localStorage.setItem(KEY_LOCAL_STORAGE_THEME, currentTheme);

        applyTheme(currentTheme);
    });

    console.log(`${ID_TOGGLE_THEME} addEventListener "click"`);
}


function applyTheme(theme) {
    
    console.log(ID_TOGGLE_THEME, "applyTheme");

    pilotColorTheme(theme);

    //REM: ES5+
    xmlHttpRequest(
        "POST",
        "/apis/views/components/toggle_theme.php",
        {
            header: {"content-type": "application/josn"},
            body: JSON.stringify({ theme } ),
            footer: {}
        },
        function( error, response ) {
            if( error ) {
                console.log( error );
            }
            else {

                if( response.status >= StatusCode.OK && response.status < 300 ) {

                    var body = response.letter.body;

                    if( body.isSuccess ) {

                        console.log( ID_TOGGLE_THEME, response.letter );
                    }
                    else {

                        console.error( ID_TOGGLE_THEME, response.letter );
                    }
                }
                else {
                    
                    console.error( ID_TOGGLE_THEME, response.letter );
                }
            }
        },
        true
    );

    console.log(`${ID_TOGGLE_THEME} (XHR) HTTP POST request`)
 
    //REM: ES6+
    // //REM: Update theme on server (fire-and-forget approach)
    // fetch("/apis/views/components/toggle_theme.php", {
    //     method: "POST",
    //     headers: { 'Content-Type': 'application/json' },
    //     body: JSON.stringify({ theme })
    // })
    // .then(res => res.json())
    // .then(data => {
    //     if (!data.isSuccess) console.error("Server error:", data);
    //     else console.log(ID_TOGGLE_THEME, "Server updated theme:", data);
    // }).catch(error => console.error(`Fetch error: ${error}`));


    //REM: ES5+
    // (function() {

    //     var payLoad = JSON.stringify({theme});
    //     var xhr = new XMLHttpRequest();

    //     xhr.open("POST", "/apis/views/components/toggle_theme.php", true);
    //     xhr.setRequestHeader("Content-Type", "appliccation/json");

    //     xhr.onreadystatechange = function( event ) {

    //         if( xhr.readyState === RequestState.DONE ) {

    //             if( xhr.status >= StatusCode.OK && xhr.status < StatusCode.MULT_RES ) {

    //                 try {

    //                     var data = JSON.parse( xhr.responseText );

    //                     if( !data.isSuccess ) {

    //                         console.error("Server error:", data);
    //                     }
    //                     else {

    //                         console.log(ID_TOGGLE_THEME, "Server updated theme:", data);
    //                     }
    //                 }
    //                 catch( err ) {
                        
    //                     console.error("Error parsing JSON response:", err );
    //                 }
    //             }
    //             else {

    //                 console.error("HTTP error:", xhr.status, xhr.statusText );
    //             }
    //         }
    //     };

    //     xhr.send( payLoad );
    // })();
}


/**
 * 
 * @param {string} theme 
 * @return {boolean} TRUE if re-updated
 */
function pilotColorTheme( theme ) {

    console.log(ID_TOGGLE_THEME, "pilotColorTheme");

    const elChkBoxToggleTheme = document.getElementById(ID_TOGGLE_THEME);
    const elToggleThemeSlider = document.getElementById(ID_TOGGLE_THEME_SLIDER);

    document.documentElement.setAttribute(ATTR_DATA_COLOR_THEME, theme || Theme.light);

    if (elChkBoxToggleTheme) elChkBoxToggleTheme.checked = (theme === Theme.dark);
    if (elToggleThemeSlider) elToggleThemeSlider.textContent = theme.toUpperCase();

    return ( elChkBoxToggleTheme && elToggleThemeSlider ) != null;
}