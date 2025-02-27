// Enum for toast positions
const ToastPosition = {
    CENTER: "center",
    CENTER_LEFT: "center-left",
    CENTER_RIGHT: "center-right",
    CENTER_TOP: "center-top",
    CENTER_BOTTOM: "center-bottom",
    TOP_LEFT: "top-left",
    TOP_RIGHT: "top-right",
    BOTTOM_LEFT: "bottom-left",
    BOTTOM_RIGHT: "bottom-right"
};

// Active toast tracking
const activeToasts = new Set();

/**
 * Displays a toast message with stacking and deduplication.
 *
 * @param {string} message - The message to display.
 * @param {string} position - Position from ToastPosition enum.
 */
async function showToastI(message, position = ToastPosition.BOTTOM_RIGHT) {
    const hash = await hashIt(message);
    const toastId = `el-toast-${hash}`;

    if (activeToasts.has(toastId)) {
        return; // Prevent duplicate messages
    }

    activeToasts.add(toastId);

    // Get or create the toast container
    let toastContainer = document.getElementById(`el-main`);
    if (!toastContainer) {
        toastContainer = document.createElement("div");
        toastContainer.id = `el-main-${position}`;
        toastContainer.className = `el-main ${position}`;
        document.body.appendChild(toastContainer);
    }

    // Create toast element
    const elToast = document.createElement("div");
    elToast.id = toastId;
    elToast.className = `el-toast ${position}`;

    // Message content
    const msgElem = document.createElement("div");
    msgElem.className = "el-toast-message";
    msgElem.textContent = message;
    elToast.appendChild(msgElem);

    // Progress bar
    const progress = document.createElement("div");
    progress.className = "el-toast-progress";
    elToast.appendChild(progress);

    // Insert toast at the top of the stack
    toastContainer.prepend(elToast);

    // Auto-remove after 2s
    setTimeout(() => {
        elToast.classList.add("el-toast-fadeout");
        setTimeout(() => {
            elToast.remove();
            activeToasts.delete(toastId);
        }, 500);
    }, 2000);
}