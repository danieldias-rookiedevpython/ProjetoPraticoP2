function adicionarAoCarrinho() {
    let contador = document.getElementById('carrinho-contador');
    let quantidade = parseInt(contador.textContent);
    quantidade += 1;
    contador.textContent = quantidade;
}

function abrirPopup(mensagem, destino = null) {
    const overlay = document.createElement('div');
    overlay.classList.add('popup-overlay', 'active');

    overlay.innerHTML = `
        <div class="popup">
            <p>${mensagem}</p>
            <button id="fechar-popup">Fechar</button>
        </div>
    `;

    document.body.appendChild(overlay);

    document.getElementById("fechar-popup").onclick = () => {
        overlay.remove();
        if (destino) {
            window.location.href = destino;
        }
    };
}   