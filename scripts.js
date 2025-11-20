function adicionarAoCarrinho() {
    let contador = document.getElementById('carrinho-contador');
    let quantidade = parseInt(contador.textContent);
    quantidade += 1;
    contador.textContent = quantidade;
}

function abrirPopup(mensagem, destino = null) {
    const overlay = document.getElementById("popup-overlay");
    const msg = document.getElementById("popup-message");
    const fechar = document.getElementById("popup-close");

    msg.textContent = mensagem; 
    overlay.style.display = "flex";

    fechar.onclick = () => {
        overlay.style.display = "none";
        if (destino) window.location.href = destino;
    };
}

console.log("scripts.js carregou!");