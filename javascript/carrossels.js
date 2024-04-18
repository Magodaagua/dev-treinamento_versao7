document.addEventListener("DOMContentLoaded", function () {
    const container = document.querySelector(".custom-carousel");
    const cars = document.querySelectorAll(".custom-car");
    const prevBtn = document.querySelector(".control-preve");
    const nextBtn = document.querySelector(".control-nexte");

    if (container && cars.length > 3 && prevBtn && nextBtn) {
        const itemsToShow = 3;
        let currentIndex = 0;

        prevBtn.addEventListener("click", function () {
            currentIndex = (currentIndex - 1 + cars.length) % cars.length;
            updateCarousel();
        });

        nextBtn.addEventListener("click", function () {
            currentIndex = (currentIndex + 1) % cars.length;
            updateCarousel();
        });

        function updateCarousel() {
            cars.forEach((car, index) => {
                const isVisible = index >= currentIndex && index < currentIndex + itemsToShow;
                car.style.display = isVisible ? "flex" : "none";
            });
        
            // Se houver menos cursos do que itemsToShow, ajustamos o índice atual
            if (cars.length <= itemsToShow) {
                currentIndex = 0;
            }
        }
        
        updateCarousel();
    }
});
