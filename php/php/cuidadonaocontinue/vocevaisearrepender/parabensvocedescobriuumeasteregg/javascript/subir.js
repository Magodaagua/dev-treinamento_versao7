        // Get the button
        var mybutton = document.getElementById("myBtn");

        // When the user scrolls down 20px from the top of the document, show the button
        window.onscroll = function() {
          scrollFunction();
        };

        function scrollFunction() {
          if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            mybutton.style.display = "block";
          } else {
            mybutton.style.display = "none";
          }
        }

        // When the user clicks on the button, scroll to the top of the document smoothly
        mybutton.addEventListener("click", function() {
          scrollToTop();
        });

        function scrollToTop() {
          // Define a função de animação de rolagem
          var scrollStep = -window.scrollY / (500 / 15); // Ajuste a velocidade de rolagem aqui
          var scrollInterval = setInterval(function() {
            if (window.scrollY != 0) {
              window.scrollBy(0, scrollStep);
            } else {
              clearInterval(scrollInterval);
            }
          }, 15);
        }