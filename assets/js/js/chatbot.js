document.addEventListener('DOMContentLoaded', () => {
  const chatbotContainer = document.getElementById('chatbot-container');
  const openBtn  = document.getElementById('openChatbotBtn');
  const closeBtn = document.getElementById('closeChatbotBtn');
  const userInput = document.getElementById('chatbot-input');
  const chatBox   = document.getElementById('chatbot-box');
  const quickBtns = document.querySelectorAll('.quick-btn');
  const sendBtn = document.getElementById('sendChatbotBtn');
  let isProcessing = false;

  const toggleChatbot = () => {
    chatbotContainer.classList.toggle('chatbot-hidden');
    chatbotContainer.classList.toggle('chat-visible');
    if (!chatbotContainer.classList.contains('chatbot-hidden')) userInput.focus();
  };
  openBtn.addEventListener('click', toggleChatbot);
  closeBtn.addEventListener('click', toggleChatbot);
 sendBtn.addEventListener('click', sendMessage);


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