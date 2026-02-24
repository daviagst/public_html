


  function openModal() {
    document.getElementById("myModalTrabalho").style.display = "block";
}

function closeModalTrabalho() {
    document.getElementById("myModalTrabalho").style.display = "none";
}


    // Função para esconder o botão de confirmação após um certo tempo (opcional)
    function esconderConfirmacao() {
      var btnConfirmacao = document.getElementById('enviarBtn');
      btnConfirmacao.style.display = 'none';
  }

  // Chame esta função quando quiser exibir o botão de confirmação
  function exibirConfirmacao() {
      var btnConfirmacao = document.getElementById('enviarBtn');
      btnConfirmacao.classList.add('confirmacao-envio');
      
      // Você também pode esconder o botão após um certo tempo, se desejar
      setTimeout(esconderConfirmacao, 5000); // Esconde após 5 segundos (5000 milissegundos)
  }


  

  document.addEventListener('DOMContentLoaded', function() {
    var meuVideoInicio = document.getElementById('meuVideoInicio').volume = 0.3;
    var meuVideoFim = document.getElementById('meuVideoFim').volume = 0.1;

    var options = {
        root: null,
        threshold: 0.5
    };

    var observerInicio = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                meuVideoInicio.play();
                observerInicio.unobserve(entry.target);
            }
        });
    }, options);

    var observerFim = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                meuVideoFim.play();
                observerFim.unobserve(entry.target);
            }
        });
    }, options);

    observerInicio.observe(document.getElementById('inicioVideo'));
    observerFim.observe(document.getElementById('fimVideo'));
});




// MINHAS MODIFICAÇÕES



document.addEventListener('DOMContentLoaded', () => {
  const chatbotContainer = document.getElementById('chatbot-container');
  const openBtn  = document.getElementById('openChatbotBtn');
  const closeBtn = document.getElementById('closeChatbotBtn');
  const userInput = document.getElementById('chatbot-input');
  const chatBox   = document.getElementById('chatbot-box');
  const quickBtns = document.querySelectorAll('.quick-btn');
  let isProcessing = false;

  const toggleChatbot = () => {
    chatbotContainer.classList.toggle('chatbot-hidden');
    chatbotContainer.classList.toggle('chat-visible');
    if (!chatbotContainer.classList.contains('chatbot-hidden')) userInput.focus();
  };
  openBtn.addEventListener('click', toggleChatbot);
  closeBtn.addEventListener('click', toggleChatbot);



function addMessage(message, isUser) {
    const div = document.createElement('div');
    div.className = `message ${isUser? 'user-message':'bot-message'}`;
    
    // Remova a função linkify e use marked.js para renderizar markdown
    div.innerHTML = `
        <div class="message-content">${marked.parse(message)}</div>
        <div class="message-time">${new Date().toLocaleTimeString()}</div>
    `;
    
    chatBox.appendChild(div);
    chatBox.scrollTo({ top: chatBox.scrollHeight, behavior: 'smooth' });
}

  async function sendMessage() {
    const text = userInput.value.trim();
    if (!text || isProcessing) return;
    isProcessing = true;
    addMessage(text, true);
    userInput.value = '';

    // indicador de digitação
    const loader = document.createElement('div');
    loader.className = 'message bot-message';
    loader.innerHTML = '<div class="typing-indicator"><div class="dot"></div><div class="dot"></div><div class="dot"></div></div>';
    chatBox.appendChild(loader);

    try {
      const res = await fetch('chat.php', {
        method: 'POST',
        headers: {
          'Accept':       'application/json',
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({ message: text })
      });
      if (!res.ok) throw new Error(`HTTP ${res.status}`);
      const { reply } = await res.json();
      loader.remove();
      addMessage(reply, false);
    } catch (err) {
      loader.remove();
      console.error(err);
      addMessage('⚠️ Problema técnico. Tente novamente ou fale no WhatsApp: (94) 98402-2691', false);
    } finally {
      isProcessing = false;
    }
  }

  quickBtns.forEach(btn => btn.addEventListener('click', e => {
    userInput.value = e.target.textContent;
    sendMessage();
  }));

  userInput.addEventListener('keypress', e => {
    if (e.key === 'Enter' && !e.shiftKey) {
      e.preventDefault();
      sendMessage();
    }
  });
});
