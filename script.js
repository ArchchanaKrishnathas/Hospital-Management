// document.getElementById('registrationForm').addEventListener('submit', function (event) {
//     event.preventDefault();
//     alert('Registration submitted successfully!');
// });

// document.getElementById('appointmentForm').addEventListener('submit', function (event) {
//     event.preventDefault();
//     alert('Appointment booked successfully!');
// });


document.addEventListener('DOMContentLoaded', () => {
    const slider = document.querySelector('.gallery-slider');
    let isDown = false;
    let startX;
    let scrollLeft;

    slider.addEventListener('mousedown', (e) => {
        isDown = true;
        slider.classList.add('active');
        startX = e.pageX - slider.offsetLeft;
        scrollLeft = slider.scrollLeft;
    });

    slider.addEventListener('mouseleave', () => {
        isDown = false;
        slider.classList.remove('active');
    });

    slider.addEventListener('mouseup', () => {
        isDown = false;
        slider.classList.remove('active');
    });

    slider.addEventListener('mousemove', (e) => {
        if (!isDown) return;
        e.preventDefault();
        const x = e.pageX - slider.offsetLeft;
        const walk = (x - startX) * 3; // scroll-fast
        slider.scrollLeft = scrollLeft - walk;
    });
});