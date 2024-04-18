document.addEventListener("DOMContentLoaded", function () {
    const container = document.querySelector(".SugestaoCurso");
    const cars = document.querySelectorAll(".carrossel-tres");
    const prevBtn = document.querySelector(".control-preve-dois");
    const nextBtn = document.querySelector(".control-nexte-dois");

    if (container && cars.length > 5 && prevBtn && nextBtn) {
        const itemsToShow = 5;
        let currentIndex = 0;

        prevBtn.addEventListener("click", function () {
            currentIndex = currentIndex > 0 ? currentIndex - 1 : cars.length - itemsToShow;
            updateCarousel();
        });

        nextBtn.addEventListener("click", function () {
            currentIndex = currentIndex < cars.length - itemsToShow ? currentIndex + 1 : 0;
            updateCarousel();
        });

        function updateCarousel() {
            cars.forEach((car, index) => {
                const isVisible = index >= currentIndex && index < currentIndex + itemsToShow;
                car.style.display = isVisible ? "flex" : "none";
            });
        }
        
        updateCarousel();
    }
});
