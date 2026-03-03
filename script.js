document.addEventListener("DOMContentLoaded", function() {

  fetch("unidades.json")
    .then(response => response.json())
    .then(dados => {

      const container = document.getElementById("unidadesContainer");

      let delay = 0;

      for (let uf in dados) {
        for (let cidade in dados[uf]) {

          dados[uf][cidade].forEach(unidade => {

            const card = document.createElement("div");
            card.classList.add("card-unidade");

            card.setAttribute("data-aos", "fade-up");
            card.setAttribute("data-aos-delay", delay);

            delay += 150;

            card.innerHTML = `
              <img src="${unidade.imagem}" alt="${unidade.nome}">
              <div class="card-info">
                  <h3>${unidade.nome}</h3>
                  <p class="localizacao">
                    ${cidade} / ${uf}
                  </p>
              </div>
            `;

            container.appendChild(card);

          });

        }
      }

      // 🔥 AGORA INICIA O AOS DEPOIS DOS CARDS EXISTIREM
      AOS.init({
        duration: 800,
        once: false
      });

    });

});