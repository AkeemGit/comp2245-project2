document.addEventListener("DOMContentLoaded", () => {

    const form = document.getElementById("loginForm");
    let errorMessage = document.querySelector(".error-message");

    form.addEventListener("submit", function (e) {
        e.preventDefault();

        const email = form.email.value.trim();
        const password = form.password.value.trim();

        if (!email || !password) { 
            errorMessage.textContent = "Please fill in both fields.";
            errorMessage.style.display = "block";
            return;
        }

        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(email)) {
            errorMessage.textContent = "Please enter a valid email address.";
            errorMessage.style.display = "block";
            return;
        }

        fetch("../includes/login_action.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ email, password })
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === "success") {
                window.location.href = "dashboard.php";
            } else {
                errorMessage.textContent = "Incorrect email or password.";
                errorMessage.style.display = "block";
            }
        })
        .catch(err => console.error("Login error:", err));
    });

});
