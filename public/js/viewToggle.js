const viewToggle = () => {
    const tableView = document.getElementById("tableView");
    const listView = document.getElementById("listView");
    const cardDiv = document.getElementById("cardDiv");
    const tableDiv = document.getElementById("tableDiv");

    // Toggle hidden class to switch views
    tableView.classList.toggle("hidden");
    listView.classList.toggle("hidden");

    cardDiv.classList.toggle("hidden");
    tableDiv.classList.toggle("hidden");
};
