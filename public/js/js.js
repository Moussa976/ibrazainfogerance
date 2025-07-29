// Mobile menu toggle
const menuBtn = document.getElementById('menu-btn');
const mobileMenu = document.getElementById('mobile-menu');

menuBtn.addEventListener('click', () => {
    mobileMenu.classList.toggle('hidden');
});

// Smooth scrolling for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();

        const targetId = this.getAttribute('href');
        if (targetId === '#') return;

        const targetElement = document.querySelector(targetId);
        if (targetElement) {
            // Close mobile menu if open
            mobileMenu.classList.add('hidden');

            window.scrollTo({
                top: targetElement.offsetTop - 80,
                behavior: 'smooth'
            });
        }
    });
});


const scrollToTopBtn = document.getElementById("scrollToTopBtn");

window.addEventListener("scroll", () => {
    if (window.scrollY > 300) {
        scrollToTopBtn.classList.add("show");
        scrollToTopBtn.classList.remove("hidden");
    } else {
        scrollToTopBtn.classList.remove("show");
        scrollToTopBtn.classList.add("hidden");
    }
});


// toogle nos coordonnées : 
function toggleContactInfo() {
    const info = document.getElementById('contact-info');
    const icon = document.getElementById('toggle-icon');
    info.classList.toggle('hidden');
    icon.classList.toggle('rotate-180');
}


// Axeptio
window.axeptioSettings = {
    clientId: "68868623ed5ba5dbf698c3f8",
    cookiesVersion: "ibrazainfogerance-fr-EU",
    googleConsentMode: {
        default: {
            analytics_storage: "denied",
            ad_storage: "denied",
            ad_user_data: "denied",
            ad_personalization: "denied",
            wait_for_update: 500
        }
    }
};

(function (d, s) {
    var t = d.getElementsByTagName(s)[0], e = d.createElement(s);
    e.async = true; e.src = "//static.axept.io/sdk.js";
    t.parentNode.insertBefore(e, t);
})(document, "script");


// Pour le newsletter
fetch('/newsletter/fragment')
    .then(response => response.text())
    .then(html => {
        document.querySelector('#newsletter-container').innerHTML = html;
    });