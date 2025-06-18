import './bootstrap';
import 'flowbite'; //  Flowbite di-import
import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();


// Smooth scroll untuk semua halaman
document.addEventListener('DOMContentLoaded', function() {
    const handleAnchorClick = (e) => {
        const href = e.currentTarget.getAttribute('href');
        
        // Skip jika bukan anchor link atau link eksternal
        if (href === '#' || href.startsWith('http')) return;
        
        // Jika anchor link
        if (href.startsWith('#')) {
            e.preventDefault();
            const target = document.querySelector(href);
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
                
                // Update URL tanpa reload
                if (history.pushState) {
                    history.pushState(null, null, href);
                } else {
                    window.location.hash = href;
                }
            }
        }
    };

    // Attach event listener ke anchor links yang ada
    document.querySelectorAll('a[href*="#"]').forEach(anchor => {
        anchor.addEventListener('click', handleAnchorClick);
    });
});


    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        
        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});