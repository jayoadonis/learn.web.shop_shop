//REM: Enum for toast positions
const ToastPosition = Object.freeze({
    CENTER: "center",
    CENTER_LEFT: "center-left",
    CENTER_RIGHT: "center-right",
    CENTER_TOP: "center-top",
    CENTER_BOTTOM: "center-bottom",
    TOP_LEFT: "top-left",
    TOP_RIGHT: "top-right",
    BOTTOM_LEFT: "bottom-left",
    BOTTOM_RIGHT: "bottom-right"
});

const ToastType = Object.freeze({
    INFO: "info",
    WARNING: "warning",
    ERROR: "error",
    FATAL: "fatal"
});

const ToastDuration = Object.freeze({
    SHORT: Object.freeze({
        us: 3000000,
        ms: 3000,
        sec: 3
    }),
    LONG: Object.freeze({
        us: 8000000,
        ms: 8000,
        sec: 8
    }),
})

//REM: Active toast tracking
const activeToastsI = new Set();
let containerToastITimeoutId = undefined;

/**
 * Displays a toast message with stacking and deduplication.
 *
 * @param {string} message - The message to display.
 * @param {string} position - Position from ToastPosition enum.
 * @param {string} elContainerId - Container ID prefix.
 */
async function showToastI(
    message,
    type = ToastType.INFO,
    position = ToastPosition.BOTTOM_RIGHT,
    duration = ToastDuration.SHORT,
    elContainerId = "el-toast-i-container"
) {
    const hash = await hashIt(message);
    const toastId = `el-toast-i-${hash}`;

    if (activeToastsI.has(toastId)) {
        return; //REM: Prevent duplicate messages
    }

    activeToastsI.add(toastId);

    //REM: Get or create the toast container for this position
    const containerKey = `${elContainerId}-${position}`;
    let toastContainer = document.getElementById(containerKey);
    if (!toastContainer) {
        clearInterval(containerToastITimeoutId);
        toastContainer = document.createElement("div");
        toastContainer.id = containerKey;
        toastContainer.className = `${elContainerId} ${position}`;
        document.body.appendChild(toastContainer);
    }

    //REM: Create toast element
    const elToast = document.createElement("div");
    elToast.id = toastId;
    elToast.className = `el-toast-i ${type} ${position}`;

    //REM: Message content
    const msgElem = document.createElement("div");
    msgElem.className = "el-toast-i-message";
    msgElem.textContent = message;
    elToast.appendChild(msgElem);

    //REM: Progress bar
    const progress = document.createElement("div");
    progress.className = "el-toast-i-progress";
    elToast.appendChild(progress);

    //REM: Insert toast at the top of the stack
    toastContainer.prepend(elToast);

    progress.style.animationDuration = `${duration.sec}s`;

    //REM: Auto-remove after 2s
    setTimeout(() => {
        activeToastsI.delete(toastId);
        elToast.classList.add("el-toast-i-fadeout");
        setTimeout(() => {
            elToast.remove();
            removeContainerIfEmpty(toastContainer);
        }, 500);
    }, duration.ms + 500);

    if (!containerToastITimeoutId) {
        containerToastITimeoutId = setInterval(() => {
            if (activeToastsI.size <= 0) {
                toastContainer.remove();
                clearInterval(containerToastITimeoutId);
                containerToastITimeoutId = undefined;
            }
        }, 500);
    }
}

/**
 * Removes the toast container if empty.
 */
function removeContainerIfEmpty(container) {
    requestAnimationFrame(() => {
        if (activeToastsI.size === 0) {
            container.remove();
            containerToastITimeoutId = undefined;
        }
    });
}