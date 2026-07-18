document.addEventListener('DOMContentLoaded', () => {
    // 1. Copy to Clipboard Functionality
    const copyButtons = document.querySelectorAll('.copy-btn');
    copyButtons.forEach(button => {
        button.addEventListener('click', () => {
            const container = button.closest('.code-container');
            const code = container.querySelector('code').innerText;
            
            navigator.clipboard.writeText(code).then(() => {
                const textSpan = button.querySelector('span:not(.material-symbols-outlined)');
                const originalText = textSpan.innerText;
                
                textSpan.innerText = 'Copied!';
                button.style.color = '#10b981';
                
                setTimeout(() => {
                    textSpan.innerText = originalText;
                    button.style.color = '';
                }, 2000);
            });
        });
    });

    // 2. Navigation Link Highlighting on Scroll (Intersection Observer)
    const sections = document.querySelectorAll('section');
    const navLinks = document.querySelectorAll('.nav-link');

    const observerOptions = {
        root: null,
        rootMargin: '-20% 0px -60% 0px',
        threshold: 0
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const activeId = entry.target.getAttribute('id');
                navLinks.forEach(link => {
                    if (link.getAttribute('href') === `#${activeId}`) {
                        link.classList.add('active');
                    } else {
                        link.classList.remove('active');
                    }
                });
            }
        });
    }, observerOptions);

    sections.forEach(section => observer.observe(section));
});
