function openNav() {
    document.getElementById("sidebar").style.width = "250px";
    document.getElementById("main").style.marginLeft = "250px";
    document.getElementById("openbtn").style.display = "none"; // Hide the open button
}

function closeNav() {
    document.getElementById("sidebar").style.width = "0";
    document.getElementById("main").style.marginLeft= "0";
    document.getElementById("openbtn").style.display = "block"; // Show the open button
}

// Since the sidebar is open by default, the open button is hidden by default.
// There's no need to call openNav() on page load in this case.
