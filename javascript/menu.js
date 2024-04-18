document.addEventListener("DOMContentLoaded", function() {
    const modulos = document.querySelectorAll('.modulo');

    modulos.forEach(modulo => {
        modulo.addEventListener('click', () => {
            //console.log('Módulo clicado');
            const aulas = modulo.nextElementSibling; // Encontra o próximo elemento, que deve ser o de aulas

            if (aulas && aulas.classList.contains('aulas')) {
                console.log('Elemento de aulas encontrado');
                if (aulas.style.display === 'none' || aulas.style.display === '') {
                    aulas.style.display = 'block';
                    modulo.classList.add('aberto'); // Adiciona a classe indicando que está aberto
                } else {
                    aulas.style.display = 'none';
                    modulo.classList.remove('aberto'); // Remove a classe indicando que está fechado
                }
            } else {
                //console.log('Elemento de aulas não encontrado');
            }
        });
    });
});
