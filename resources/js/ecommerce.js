// Importa GSAP desde npm (mejor para producción)
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import Drift from 'drift-zoom';

// O si prefieres CDN (en tu blade layout principal)
// <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js"></script>
// <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/ScrollTrigger.min.js"></script>
// <script src="https://cdnjs.cloudflare.com/ajax/libs/Drift/1.4.1/Drift.min.js"></script>

// Inicialización de animaciones
document.addEventListener('DOMContentLoaded', function() {
    // Registrar plugins GSAP
    gsap.registerPlugin(ScrollTrigger);
    
    // Animación de elementos al hacer scroll
    gsap.utils.toArray('.animate-on-scroll').forEach(element => {
        gsap.from(element, {
            scrollTrigger: {
                trigger: element,
                start: "top 80%",
                toggleActions: "play none none none"
            },
            opacity: 0,
            y: 50,
            duration: 0.8,
            ease: "power3.out"
        });
    });
    
    // Efecto parallax en hero
    document.querySelectorAll('.parallax-hero').forEach(hero => {
        gsap.to(hero, {
            scrollTrigger: {
                scrub: true
            },
            yPercent: 20,
            ease: "none"
        });
    });
    /*
    // Inicializar Drift en todas las imágenes con zoom
    document.querySelectorAll('[data-zoom]').forEach(img => {
        new Drift(img, {
            paneContainer: img.parentElement,
            inlinePane: false
        });
    });
    */
});