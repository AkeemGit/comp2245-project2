document.addEventListener("DOMContentLoaded",function (){
    const form = document.querySelector("form");
    const passwordInput = document.getElementById("password");

    const Regex_check = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/;

    form.addEventListener("submit", function (e) {
        let errors = [];

        const firstname = document.getElementById("first_name").value.trim();
        const lastname = document.getElementById("last_name").value.trim();
        const email = document.getElementById("email").value.trim();
        const password = passwordInput.value;

        if (!firstname || !lastname || !email || !password) {
            errors.push("All fields are required.");
        }

        if (!Regex_check.test(password)) {
            errors.push("Password must be at least 8 characters long and include at least one uppercase letter, one lowercase letter, and one number.");
        }

        if (errors.length > 0) {
            e.preventDefault();
            alert(errors.join("\n"));
        }
    })
})