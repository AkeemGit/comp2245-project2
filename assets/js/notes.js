document.querySelector(".add-note-box").addEventListener("submit", function (e) {
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
        return res.json();
      })
      .then((data) => {
        if (data.success) {
          console.log("AJAX SUCCESS: updating notes and date");
          document.querySelector("#notes-list").innerHTML = data.notesHTML;
          document.querySelector(".comment").value = "";

          // Update the "Updated on" date
          const metaElements = document.querySelectorAll(".meta");
          if (metaElements.length > 1) {
            metaElements[1].innerHTML = `Updated on ${data.updatedDate}`;
          }
        }
      })
      .catch((err) => console.error("Fetch failed:", err));
  });
