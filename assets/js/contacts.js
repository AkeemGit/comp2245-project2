document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("newContactForm");
    const msg = document.getElementById("formMessage");
    const btn = document.getElementById("saveBtn");

    if (!form) return;

    const setMessage = (text, ok = false) => {
        msg.textContent = text;
        msg.style.padding = text ? "10px" : "0";
        msg.style.borderRadius = "6px";
        msg.style.border = text ? "1px solid #ccc" : "none";
        msg.style.background = ok ? "#eaffea" : "#fff2f2";
    };

    form.addEventListener("submit", async (e) => {
        e.preventDefault();
        setMessage("");

        btn.disabled = true;
        btn.textContent = "Saving...";

        try {
            const formData = new FormData(form);

            const res = await fetch("../api/add_contact.php", {
                method: "POST",
                body: formData,
            });

            const text = await res.text();
            let data;
            try {
                data = JSON.parse(text);
            } catch (err) {
                throw new Error("Server returned an unexpected response.");
            }

            if (data.success) {
                setMessage("Contact saved successfully.", true);
                form.reset();
            } else {
                setMessage(`${data.error || "Could not save contact."}`, false);
            }
        } catch (err) {
            setMessage(`${err.message || "Something went wrong."}`, false);
        } finally {
            btn.disabled = false;
            btn.textContent = "Save";
        }
    });
});
