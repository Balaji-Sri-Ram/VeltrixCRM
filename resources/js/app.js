import './bootstrap';
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import Lenis from 'lenis';

gsap.registerPlugin(ScrollTrigger);

window.gsap = gsap;
window.ScrollTrigger = ScrollTrigger;

document.addEventListener('DOMContentLoaded', () => {
    // 1. Initialize Lenis Smooth Scroll
    const lenis = new Lenis({
        duration: 1.4, // slightly longer for more premium, luxurious deceleration
        easing: (t) => 1 - Math.pow(1 - t, 4), // ultra-smooth quartic ease-out
        direction: 'vertical',
        gestureDirection: 'vertical',
        smooth: true,
        smoothWheel: true,
        syncTouch: false, // use native scroll on touch devices for maximum performance
        infinite: false,
    });

    // Scroll to section helper using Lenis
    const scrollToSection = (target, duration = 1.2) => {
        lenis.scrollTo(target, {
            duration: duration,
            easing: (t) => 1 - Math.pow(1 - t, 4), // ultra-smooth quartic ease-out
            offset: 0,
        });
    };

    // Attach click listeners to navbar logo
    const navbarLogo = document.getElementById('navbar-logo');
    if (navbarLogo) {
        navbarLogo.addEventListener('click', (e) => {
            if (window.location.pathname === '/' || window.location.pathname.endsWith('index.php')) {
                e.preventDefault();
                scrollToSection(0, 1.5); // scroll to top smoothly
            }
        });
    }

    // Attach click listeners to all hash links in navbar / footer (e.g. #features, #contact, #)
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', (e) => {
            const targetId = anchor.getAttribute('href');
            if (targetId === '#') {
                e.preventDefault();
                scrollToSection(0, 1.5); // scroll to top smoothly
                return;
            }
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                e.preventDefault();
                scrollToSection(targetElement, 1.2);
            }
        });
    });

    // Update ScrollTrigger on Lenis scroll
    lenis.on('scroll', ScrollTrigger.update);

    // Sync GSAP ticker with Lenis scroll
    gsap.ticker.add((time) => {
        lenis.raf(time * 1000);
    });

    // Clear any existing ScrollTriggers to prevent duplicate/competing triggers on HMR reloads
    ScrollTrigger.getAll().forEach(t => t.kill());
    
    // Disable lag smoothing for GSAP to prevent stutters
    gsap.ticker.lagSmoothing(0);

    // 2. Entrance Animations (Hero Intro on Page Load)
    const tl = gsap.timeline({ defaults: { ease: 'power3.out', duration: 1.2 } });

    tl.from('.animate-hero-text', {
        y: 40,
        opacity: 0,
        stagger: 0.15,
    });

    // Premium Spread Animation for Hero Cards
    const heroCards = Array.from(document.querySelectorAll('.hero-card'));
    if (heroCards.length === 6) {
        // The anchor point is Column 1 Row 2 position (card-1 is in col-1 with margin-top acting as row 2)
        const anchorCard = heroCards[0];
        
        // Wait for layout to settle and CSS to apply
        requestAnimationFrame(() => {
            const anchorRect = anchorCard.getBoundingClientRect();
            
            const cardDeltas = heroCards.map(card => {
                const rect = card.getBoundingClientRect();
                return {
                    dx: anchorRect.left - rect.left,
                    dy: anchorRect.top - rect.top
                };
            });

            // 1. INSTANTLY force all cards to the shared origin state BEFORE they become visible
            // This guarantees absolutely ZERO flash or layout shift.
            heroCards.forEach((card, i) => {
                gsap.set(card, {
                    x: cardDeltas[i].dx,
                    y: cardDeltas[i].dy,
                    scale: 0.9,
                    opacity: 0,
                    force3D: true // Hardware acceleration (translate3d)
                });
            });

            // 2. Animate them outward smoothly to their natural grid positions
            heroCards.forEach((card, index) => {
                tl.to(card, {
                    x: 0, 
                    y: 0, 
                    scale: 1, 
                    opacity: 1, 
                    duration: 1.4, 
                    ease: 'power4.out', // Extremely smooth premium easing similar to cubic-bezier(0.22, 1, 0.36, 1)
                    force3D: true
                }, index === 0 ? '-=0.8' : `-=${1.25}`);
            });

            const idleTweens = [];
            // Idle Float Animation (Subtle continuous movement)
            tl.add(() => {
                heroCards.forEach((card, i) => {
                    idleTweens.push(
                        gsap.to(card, {
                            yPercent: -4,
                            duration: 3 + i * 0.3,
                            ease: "sine.inOut",
                            yoyo: true,
                            repeat: -1,
                            delay: i * 0.2
                        })
                    );
                });
            });

            // Scroll-linked Collapse Effect (Scroll down away from hero)
            const heroSection = document.querySelector('section.pt-2');
            const nextSection = document.querySelector('.scroll-section');
            
            if (heroSection && nextSection) {
                const collapseTl = gsap.timeline({
                    scrollTrigger: {
                        trigger: heroSection,
                        start: 'top top',
                        endTrigger: nextSection,
                        end: 'top top',
                        scrub: 1.2, // smoother spring scrub
                        fastScrollEnd: true,
                        preventOverlaps: true,
                        invalidateOnRefresh: true,
                        onUpdate: (self) => {
                            if (self.progress > 0) {
                                // Pause idle floating to completely prevent transform matrix recalculation fighting
                                idleTweens.forEach(t => t.pause());
                            } else if (self.progress === 0) {
                                // Resume idle float seamlessly when back at the exact top
                                idleTweens.forEach(t => t.play());
                            }
                        }
                    }
                });

                // Collapse all cards back to the exact same shared origin
                heroCards.forEach((card, index) => {
                    collapseTl.to(card, {
                        x: cardDeltas[index].dx,
                        y: cardDeltas[index].dy,
                        yPercent: 0, // Reset yPercent to perfectly align into the origin stack without jitter
                        scale: 0.9,
                        opacity: 0,
                        force3D: true, // Force GPU acceleration
                        ease: 'none'
                    }, 0);
                });
            }
        });
    } else {
        tl.from('.animate-hero-img', {
            y: 60,
            opacity: 0,
        }, '-=0.6');
    }

    tl.from('.animate-stats', {
        y: 30,
        opacity: 0,
    }, '-=0.8');

    // 3. Select all Sections
    const sections = gsap.utils.toArray('.scroll-section');

    // 4. Premium Sticky Stacking & Depth Recession Transitions (Inspired by Harsh Mishra Portfolio)
    sections.forEach((section, index) => {
        // Set dynamic stack layering z-index inline to guarantee next section always slides UPSIDE/ON TOP
        section.style.zIndex = index + 1;

        // Find inner wrapper to apply scaling and depth transitions
        const inner = section.querySelector('.container-boxed') || section.firstElementChild;
        const isLast = index === sections.length - 1;
        const nextSection = isLast ? document.querySelector('footer') : sections[index + 1];
        
        if (nextSection) {
            // A. Sticky Pinning (with NO pin spacing so next section slides over it like a stack)
            ScrollTrigger.create({
                trigger: section,
                start: 'top top', // strictly pin at top top
                endTrigger: nextSection,
                end: isLast ? 'bottom bottom' : 'top top',
                pin: section,
                pinSpacing: false,
                anticipatePin: 1, // completely eliminates pinning jumps or jitter
                invalidateOnRefresh: true,
            });

            // B. Scroll-linked Depth Recession (Current section shrinks and blurs as the next slides up)
            if (inner) {
                gsap.to(inner, {
                    yPercent: -10,       // subtle vertical shift
                    scale: 0.95,         // premium scaling recession
                    opacity: 0.15,       // slowly becomes low opacity to disappear
                    ease: 'none',
                    scrollTrigger: {
                        trigger: nextSection,
                        start: 'top bottom', // starts when next section enters screen from bottom
                        end: isLast ? 'bottom bottom' : 'top top', // ends when next section/footer reaches its scroll limit
                        scrub: true,         // scrub directly binds animation to scroll momentum
                        invalidateOnRefresh: true,
                    }
                });
            }
        }
    });

    // 5. Features Section Multi-Step Scroll Swap Reveal (Row 1 & Row 2 Swap In-Place)
    const featuresSection = document.querySelector('#features');
    if (featuresSection) {
        // A. Section Entrance Animation (Header + Row 1 cards enter together on section scroll-in)
        gsap.fromTo(['#features .text-center', '.features-row-1'],
            { opacity: 0, y: 50 },
            {
                opacity: 1,
                y: 0,
                duration: 1.0,
                stagger: 0.15,
                ease: 'power2.out',
                scrollTrigger: {
                    trigger: featuresSection,
                    start: 'top bottom-=100', // plays as soon as section enters viewport bottom
                    toggleActions: 'play none none none',
                }
            }
        );

        // B. Card Swap Transition (Row 1 slides up/fades out, Row 2 slides up/fades in directly in its place)
        const swapTimeline = gsap.timeline({
            scrollTrigger: {
                trigger: featuresSection,
                start: 'top top',
                end: '+=60%', // scroll distance to execute the swap somewhat fast
                scrub: true,
                invalidateOnRefresh: true,
            }
        });

        swapTimeline.to('.features-row-1', {
            opacity: 0,
            y: -50,
            pointerEvents: 'none',
            duration: 0.4,
            ease: 'power2.inOut',
        })
        .fromTo('.features-row-2',
            { opacity: 0, y: 50, pointerEvents: 'none' },
            {
                opacity: 1,
                y: 0,
                pointerEvents: 'auto',
                duration: 0.4,
                ease: 'power2.inOut',
            },
            '-=0.2' // slight overlap for a seamless cross-fade
        );
    }
});
