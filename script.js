let currentIndex = 0;

function showTestimonios(index) {
    const testimonios = document.querySelectorAll('.testimonio');
    const testimoniosContainer = document.querySelector('.testimonios');
    const totalTestimonios = testimonios.length;

    let testimoniosVisible;
    if (window.innerWidth <= 480) {
        testimoniosVisible = 1; // Móviles: 1 testimonio visible
    } else if (window.innerWidth <= 768) {
        testimoniosVisible = 2; // Tablets: 2 testimonios visibles
    } else {
        testimoniosVisible = 3; // Escritorio: 3 testimonios visibles
    }

    if (index < 0) {
        currentIndex = 0;
    } else if (index > totalTestimonios - testimoniosVisible) {
        currentIndex = totalTestimonios - testimoniosVisible;
    } else {
        currentIndex = index;
    }

    const offset = -(currentIndex * (100 / testimoniosVisible));
    testimoniosContainer.style.transform = `translateX(${offset}%)`;

    document.querySelector('.prev').style.display = currentIndex === 0 ? 'none' : 'block';
    document.querySelector('.next').style.display = currentIndex >= totalTestimonios - testimoniosVisible ? 'none' : 'block';
}

function prevTestimonio() {
    showTestimonios(currentIndex - 1);
}

function nextTestimonio() {
    showTestimonios(currentIndex + 1);
}

window.addEventListener('resize', () => {
    showTestimonios(currentIndex); // Ajustar cuando se redimensiona la ventana
});

document.addEventListener('DOMContentLoaded', () => {
    showTestimonios(currentIndex);
});
