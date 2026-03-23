// Sidebar toggle button logic
const hamBurger = document.querySelector(".toggle-btn");

// Toggle sidebar expand/collapse and store the state in localStorage
hamBurger.addEventListener("click", function () {
    const sidebar = document.querySelector("#sidebar");
    sidebar.classList.toggle("expand");
    localStorage.setItem('sidebar-expanded', sidebar.classList.contains("expand"));
});

// Restore sidebar state on page load
if (localStorage.getItem('sidebar-expanded') === 'true') {
    document.querySelector("#sidebar").classList.add("expand");
}

// Add to sidebar.js

document.addEventListener("DOMContentLoaded", () => {
    const sidebarLinks = document.querySelectorAll(".sidebar-link");
    
    // Set active link from localStorage on load
    const activePath = localStorage.getItem('activeSidebarLink');
    if (activePath) {
        sidebarLinks.forEach(link => {
            link.classList.toggle("active", link.getAttribute("href") === activePath);
        });
    }
    
    // Add click event to sidebar links
    sidebarLinks.forEach(link => {
        link.addEventListener("click", function () {
            // Remove 'active' from all links
            sidebarLinks.forEach(link => link.classList.remove("active"));
            
            // Add 'active' to clicked link and save to localStorage
            this.classList.add("active");
            localStorage.setItem('activeSidebarLink', this.getAttribute("href"));
        });
    });
});




