     // Obtém o botão e o modal
     var openModalBtns = document.querySelectorAll('.openModalBtn');
     var modalPassaporte = document.getElementById('myModalPassaporte');
     
     // Adiciona ouvintes de evento de clique a todos os botões com a classe
     openModalBtns.forEach(function (btn) {
         btn.addEventListener('click', function () {
             // Exibe o modal ao clicar
             modalPassaporte.style.display = 'block';
         });
     });
     
     // Adiciona ouvinte de evento para fechar o modal ao clicar fora dele
     window.addEventListener('mousedown', function (event) {
         if (event.target === modalPassaporte) {
             closeModal();
         }
     });
     
     // Função para fechar o modal
     function closeModal() {
         modalPassaporte.style.display = 'none';
     }