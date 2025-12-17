document.addEventListener("DOMContentLoaded", () => {
  const assignBtn = document.getElementById("assignBtn");
  const switchBtn = document.getElementById("switchBtn");

  const post = async (url, payload) => {
    const formData = new FormData();
    Object.keys(payload).forEach(k => formData.append(k, payload[k]));
    const res = await fetch(url, { method: "POST", body: formData });
    return res.json();
  };

  if (assignBtn) {
    assignBtn.addEventListener("click", async () => {
      const id = assignBtn.dataset.contactId;
      const data = await post("../api/assign_contact.php", { contact_id: id });
      if (data.success) location.reload();
      else alert(data.error || "Could not assign contact.");
    });
  }

  if (switchBtn) {
    switchBtn.addEventListener("click", async () => {
      const id = switchBtn.dataset.contactId;
      const data = await post("../api/toggle_contact_type.php", { contact_id: id });
      if (data.success) location.reload();
      else alert(data.error || "Could not switch type.");
    });
  }
});
