document
  .querySelector(".add-note-box")
  .addEventListener("submit", function (e) {
    e.preventDefault();

    const form = new FormData(this);

    fetch("/comp2245-project2/actions/add_note.php", {
      method: "POST",
      body: form,
    })
      .then((res) => {
        if (!res.ok) {
          throw new Error("HTTP ERROR: " + res.status);
        }
        return res.text();
      })
      .then((updatedNotesHTML) => {
        console.log("AJAX SUCCESS: updating HTML");
        document.querySelector("#notes-list").innerHTML = updatedNotesHTML;
        document.querySelector(".comment").value = "";
      })
      .catch((err) => console.error("Fetch failed:", err));
  });
