document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.accordion-header').forEach(header => {
        header.addEventListener('click', () => {
            const content = header.nextElementSibling; // Pega o conteúdo associado
            const arrow = header.querySelector('.arrow'); // Pega a seta

            // Alterna a visibilidade do conteúdo
            if (content.style.display === 'block') {
                content.style.display = 'none'; // Se estiver visível, esconde
                arrow.textContent = '➕'; // Troca a seta para "fechar"
            } else {
                content.style.display = 'block'; // Caso contrário, mostra
                arrow.textContent = '➖'; // Troca a seta para "abrir"
            }
        });
    });
});