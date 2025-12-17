document.addEventListener("DOMContentLoaded", () => {
  const assignBtn = document.getElementById("assignBtn");
  const switchBtn = document.getElementById("switchBtn");

 
  const post = async (url, payload) => {
    const formData = new FormData();
    Object.keys(payload).forEach(k => formData.append(k, payload[k]));
    const res = await fetch(url, { method: "POST", body: formData });
    return res.json();
  };

 
  const updateButtonText = (btn, newText) => {
    const icon = btn.querySelector("i");
    btn.textContent = "";
    if (icon) btn.appendChild(icon);
    btn.append(" " + newText);
  };


  if (assignBtn) {
    assignBtn.addEventListener("click", async () => {
      const contactId = assignBtn.dataset.contactId;
      const data = await post("../api/assign_contact.php", { contact_id: contactId });

      if (data.success) {
        
        const assignedEl = document.getElementById("assigned-user");
        if (assignedEl) assignedEl.textContent = data.assigned_name;

        assignBtn.disabled = true;
        updateButtonText(assignBtn, "Assigned to You");
      } else {
        alert(data.error || "Could not assign contact.");
      }
    });
  }


  if (switchBtn) {
    switchBtn.addEventListener("click", async () => {
      const contactId = switchBtn.dataset.contactId;
      const data = await post("../api/toggle_contact_type.php", { contact_id: contactId });

      if (data.success) {
        const newText = (data.type === "Sales Lead") ? "Switch to Support" : "Switch to Sales Lead";
        updateButtonText(switchBtn, newText);


        const typeEl = document.getElementById("contact-type");
        if (typeEl) typeEl.textContent = data.type;
      } else {
        alert(data.error || "Could not switch contact type.");
      }
    });
  }
});
