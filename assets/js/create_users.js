document.addEventListener("DOMContentLoaded",function (){
    const form = document.querySelector("form");
    const passwordInput = document.getElementById("password");

    const Regex_check = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/;

    form.addEventListener("submit", function (e) {
        e.preventDefault();

        let errors = [];

        const firstname = document.getElementById("firstname").value.trim();
        const lastname = document.getElementById("lastname").value.trim();
        const email = document.getElementById("email").value.trim();
        const password = passwordInput.value;

        if (!firstname || !lastname || !email || !password) {
            errors.push("All fields are required.");
        }

        if (!Regex_check.test(password)) {
            errors.push("Password must be at least 8 characters long and include at least one uppercase letter, one lowercase letter, and one number.");
        }

       if (errors.length > 0) {
            const messageDiv = document.querySelector(".messages");
            messageDiv.innerHTML = errors.map(err => `<p class="error-message">${err}</p>`).join('');
            return;
        }

        const formData = new FormData(form);

        fetch("create_users.php", {
            method: "POST",
            headers: {
                "X-Requested-With": "XMLHttpRequest"
            },
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            document.querySelector(".messages").innerHTML = data;

            if (data.includes("Successful creation of user")) {
                form.reset();
            }
        })
        .catch(error => {
            console.error("Error:", error);
        });
    })
})