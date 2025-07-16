const folderToggle = () => {
    const folderDiv = document.getElementById("folderDiv");
    const folderOpen = document.getElementById("folderOpen");
    const folderClose = document.getElementById("folderClose");

    // Toggle hidden class to show/hide
    folderDiv.classList.toggle("hidden");

    // Toggle icons
    folderOpen.classList.toggle("hidden");
    folderClose.classList.toggle("hidden");
};
