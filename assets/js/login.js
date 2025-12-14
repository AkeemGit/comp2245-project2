document.addEventListener("DOMContentLoaded", () => {

    const form = document.getElementById("loginForm");

    form.addEventListener("submit", function (e) {
        e.preventDefault();

        const email = form.email.value.trim();
        const password = form.password.value.trim();

        // Simple validation
        if (!email || !password) {
            alert("Please fill in both fields.");
            return;
        }

        // Optional: basic email format check
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(email)) {
            alert("Please enter a valid email address.");
            return;
        }

        // Send AJAX request
        fetch("pages/login_action.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ email, password })
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === "success") {
                window.location.href = "dashboard.php";
            } else {
                alert("Invalid email or password.");
            }
        })
        .catch(err => console.error("Login error:", err));
    });

});
