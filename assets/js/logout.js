document.addEventListener("DOMContentLoaded", () => {
    const logoutBtn = document.getElementById("logoutBtn");

    if (!logoutBtn) return;

    logoutBtn.addEventListener("click", () => {
        fetch("logout.php", {
            method: "POST"
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === "success") {
                window.location.href = "pages/login.php";
            }
        })
        .catch(() => alert("Logout failed"));
    });
});
