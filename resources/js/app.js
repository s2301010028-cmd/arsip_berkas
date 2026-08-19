import '../css/arsip.css';
import '../css/dashboard.css';

import './notice';
import './arsip';
import './dashboard';

console.log("Digital Archive Loaded");

const sidebar = document.getElementById("sidebar");
const menu = document.getElementById("menu-toggle");
const main = document.querySelector(".main");
const topNavbar = document.querySelector(".top-navbar");

if (menu && sidebar && main && topNavbar) {
    menu.addEventListener("click", () => {
        sidebar.classList.toggle("collapsed");
        main.classList.toggle("collapsed");
        topNavbar.classList.toggle("collapsed");
        sidebar.classList.toggle("show"); // for mobile compatibility
    });
}

// Dark Mode Toggle
const darkModeBtn = document.getElementById("darkModeBtn");
if (darkModeBtn) {
    const icon = darkModeBtn.querySelector('i');
    
    // Check local storage
    if (localStorage.getItem("darkMode") === "enabled") {
        document.body.classList.add("dark-mode");
        icon.classList.replace('bi-moon-stars', 'bi-sun');
    }

    darkModeBtn.addEventListener("click", () => {
        document.body.classList.toggle("dark-mode");
        if (document.body.classList.contains("dark-mode")) {
            localStorage.setItem("darkMode", "enabled");
            icon.classList.replace('bi-moon-stars', 'bi-sun');
        } else {
            localStorage.setItem("darkMode", "disabled");
            icon.classList.replace('bi-sun', 'bi-moon-stars');
        }
    });
}

// Realtime Date
const dateElement = document.getElementById("realtime-date");
if (dateElement) {
    setInterval(() => {
        const now = new Date();
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit' };
        dateElement.textContent = now.toLocaleDateString('id-ID', options).replace(/\./g, ':');
    }, 1000);
}