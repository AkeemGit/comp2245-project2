document.addEventListener("DOMContentLoaded", () => {
  const filterButtons = document.querySelectorAll("[data-filter]");
  const container = document.getElementById("contacts-container");

  function loadContacts(filter = "all") {
    container.innerHTML = "<p>Loading...</p>";

    fetch(`../api/getContacts.php?filter=${filter}`)
      .then((res) => res.json())
      .then((data) => {
        if (!data.success) {
          container.innerHTML = `
                        <div class="error-message">
                            <i class="fa-solid fa-circle-exclamation"></i>
                            <span>${data.error}</span>
                        </div>`;
          return;
        }

        const contacts = data.data;

        if (contacts.length === 0) {
          container.innerHTML = `
                        <div class="no-contacts">
                            <i class="fa-solid fa-user-slash"></i>
                            <p>No contacts found.</p>
                        </div>`;
          return;
        }

        let rows = contacts
          .map((contact) => {
            const badgeClass = contact.type.toLowerCase().replace(" ", "-");

            return `
                        <tr>
                            <td>${contact.title}. ${contact.firstname} ${contact.lastname}</td>
                            <td>${contact.email}</td>
                            <td>${contact.company}</td>
                            <td>
                                <span class="contact-type-badge ${badgeClass}">
                                    ${contact.type}
                                </span>
                            </td>
                            <td><a href="contact_details.php?id=${contact.id}" class="view-link">View <i class="fa-solid fa-arrow-right"></i></a></td>
                        </tr>`;
          })
          .join("");

        container.innerHTML = `
                    <table class="contacts-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Company</th>
                                <th>Type</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>${rows}</tbody>
                    </table>
                `;
      });
  }

  filterButtons.forEach((btn) => {
    btn.addEventListener("click", () => {
      filterButtons.forEach((b) => b.classList.remove("active"));
      btn.classList.add("active");

      const filter = btn.dataset.filter;
      loadContacts(filter);

      window.history.pushState({}, "", `?filter=${filter}`);
    });
  });

  const params = new URLSearchParams(window.location.search);
  const initialFilter = params.get("filter") || "all";
  document
    .querySelector(`[data-filter="${initialFilter}"]`)
    ?.classList.add("active");

  loadContacts(initialFilter);
});
