document.addEventListener("DOMContentLoaded", () => {

    const btnTest1 = document.getElementById("btn-test-1");
    const btnTest2 = document.getElementById("btn-test-2");

    if (!btnTest1 || !btnTest2) {
        console.error("Error: Required element not found.");
        return;
    }

    btnTest1.addEventListener("click", () => {
        showToastI(
            "Button Test One (1)",
            ToastType.ERROR,
            ToastPosition.BOTTOM_RIGHT,
            ToastDuration.LONG
        );
    }, {
        passive: true
    });

    btnTest2.addEventListener("click", () => {
        showToastI(
            "Button Test Two (2), Button Test Two (2), 123",
            ToastType.INFO,
            ToastPosition.BOTTOM_RIGHT
        );
    }, {
        passive: true
    });
});

//REM: Global variable to store the timeout ID
// let toastTimeoutId = null;

// function showToast(message) {
//     //REM: If there's an existing toast, clear its timeout and remove it
//     const existingToast = document.getElementById("custom-toast");
//     if (existingToast) {
//         clearTimeout(toastTimeoutId);
//         existingToast.remove();
//     }

//     //REM: Create a new toast element with an id for later reference
//     const toast = document.createElement("div");
//     toast.id = "custom-toast";
//     toast.textContent = message;
//     toast.style.cssText = "position:fixed; bottom:20px; left:20px; background:#333; color:#fff; padding:10px; border-radius:4px; z-index:1000;";
//     document.body.appendChild(toast);

//     //REM: Set a timeout to remove the toast after 2000ms
//     toastTimeoutId = setTimeout(() => {
//         const currentToast = document.getElementById("custom-toast");
//         if (currentToast) {
//             currentToast.remove();
//         }
//         toastTimeoutId = null;
//     }, 2000);
// }