document.addEventListener("DOMContentLoaded", function () {
    const carouselInner = document.querySelector(".carousel-inner");
    const indicatorsContainer = document.querySelector(".carousel-indicators");
    const prevButton = document.querySelector(".carousel-prev");
    const nextButton = document.querySelector(".carousel-next");
  
    let currentIndex = 0;
  
    function showSlide(index) {
        const itemWidth = carouselInner.clientWidth;
        const offset = -index * itemWidth;
        carouselInner.style.transform = `translateX(${offset}px)`;

        // Atualize o indicador ativo
        const indicators = Array.from(indicatorsContainer.children);
        indicators.forEach((indicator, i) => {
        indicator.classList.toggle("active-indicator", i === index);
        });
    }
  
    function showPrev() {
        currentIndex = (currentIndex - 1 + carouselInner.children.length) % carouselInner.children.length;
        showSlide(currentIndex);
    }
    
    function showNext() {
        currentIndex = (currentIndex + 1) % carouselInner.children.length;
        showSlide(currentIndex);
    }

    function autoRotate() {
        showNext();
        setTimeout(autoRotate, 20000); // Troca de slide a cada 5 segundos (ajuste conforme necessário)
    }

    // Adicione indicadores
    Array.from(carouselInner.children).forEach((item, index) => {
        const indicator = document.createElement("div");
        indicator.classList.add("indicator");
        indicatorsContainer.appendChild(indicator);

        indicator.addEventListener("click", () => {
            showSlide(index);
        });
    });
  
    prevButton.addEventListener("click", showPrev);
    nextButton.addEventListener("click", showNext);

    // Inicia a rotação automática ao carregar a página
    autoRotate();
  });
  