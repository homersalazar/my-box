const fileToggle = () => {
    const fileDiv = document.getElementById("fileDiv");
    const fileOpen = document.getElementById("fileOpen");
    const fileClose = document.getElementById("fileClose");

    // Toggle hidden class to show/hide
    fileDiv.classList.toggle("hidden");

    // Toggle icons
    fileOpen.classList.toggle("hidden");
    fileClose.classList.toggle("hidden");
};
