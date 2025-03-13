//REM: Global timeout IDs to manage removal and animation cleanup
let toastTimeoutId = null;
let toastAnimationTimeoutId = null;

function showToast(message) {
    //REM: If an existing elToast is present, remove it first
    const existingToast = document.getElementById("el-toast-container");
    if (existingToast) {
        clearTimeout(toastTimeoutId);
        clearTimeout(toastAnimationTimeoutId);
        existingToast.remove();
    }

    //REM: Create a new elToast element
    const elToast = document.createElement("div");
    elToast.id = "el-toast-container";
    elToast.className = "el-toast";

    //REM: Create a container for the message
    const msgElem = document.createElement("div");
    msgElem.className = "el-toast-message";
    msgElem.textContent = message;
    elToast.appendChild(msgElem);

    //REM: Create the progress bar element
    const progress = document.createElement("div");
    progress.className = "el-toast-progress";
    elToast.appendChild(progress);

    document.body.appendChild(elToast);

    //REM: After 2000ms, start the fade-out transition
    toastTimeoutId = setTimeout(() => {
        elToast.classList.add("el-toast-fadeout");
        //REM: After fade-out animation completes (500ms), remove the elToast
        toastAnimationTimeoutId = setTimeout(() => {
            elToast.remove();
        }, 500);
    }, 2000);
}