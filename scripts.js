function adicionarAoCarrinho() {
    let contador = document.getElementById('carrinho-contador');
    let quantidade = parseInt(contador.textContent);
    quantidade += 1;
    contador.textContent = quantidade;
}