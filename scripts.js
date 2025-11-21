// scripts.js
console.log("scripts.js carregou!");

// =========================
// LISTA DE PRODUTOS (com imagem)
// =========================
const produtos = [
    { id: 1, nome: "Xbox Series X", preco: 5249.84},
    { id: 2, nome: "GTA V para PS5", preco: 199.9},
    { id: 3, nome: "Battlefield 6 Phantom Edition PS5", preco: 300.99},
    { id: 4, nome: "Batman: Arkham Knight", preco: 199.90,},
    { id: 5, nome: "Nintendo Switch", preco: 1999.80,},
    { id: 6, nome: "Hollow Knight: Silk Song", preco: 48.90,},
    { id: 7, nome: "Ghost Of Tsushima", preco: 168.78,}
];

// =========================
// HELPERS: ler / salvar carrinho
// =========================
function lerCarrinho() {
    return JSON.parse(localStorage.getItem("carrinho")) || [];
}

function salvarCarrinho(carrinho) {
    localStorage.setItem("carrinho", JSON.stringify(carrinho));
}

// =========================
// ADICIONAR AO CARRINHO
// =========================
function adicionarAoCarrinho(idProduto) {
    let carrinho = lerCarrinho();
    const produto = produtos.find(p => p.id === idProduto);
    if (!produto) {
        console.error("Produto não encontrado:", idProduto);
        return;
    }

    const itemExistente = carrinho.find(item => item.id === produto.id);
    if (itemExistente) {
        itemExistente.quantidade++;
    } else {
        carrinho.push({ ...produto, quantidade: 1 });
    }

    salvarCarrinho(carrinho);
    atualizarContador();
    carregarCarrinho();
    abrirPopup(`"${produto.nome}" adicionado ao carrinho.`);
}

// =========================
// REMOVER / ALTERAR QUANTIDADE
// =========================
function removerDoCarrinho(idProduto) {
    let carrinho = lerCarrinho();
    carrinho = carrinho.filter(item => item.id !== idProduto);
    salvarCarrinho(carrinho);
    atualizarContador();
    carregarCarrinho();
}

function alterarQuantidade(idProduto, novaQtd) {
    let carrinho = lerCarrinho();
    const item = carrinho.find(i => i.id === idProduto);
    if (!item) return;

    item.quantidade = Math.max(0, parseInt(novaQtd) || 0);
    if (item.quantidade === 0) {
        carrinho = carrinho.filter(i => i.id !== idProduto);
    }

    salvarCarrinho(carrinho);
    atualizarContador();
    carregarCarrinho();
}

function incrementar(idProduto) {
    let carrinho = lerCarrinho();
    const item = carrinho.find(i => i.id === idProduto);
    if (!item) return;

    item.quantidade++;
    salvarCarrinho(carrinho);
    atualizarContador();
    carregarCarrinho();
}

function decrementar(idProduto) {
    let carrinho = lerCarrinho();
    const item = carrinho.find(i => i.id === idProduto);
    if (!item) return;

    item.quantidade--;
    if (item.quantidade <= 0) {
        carrinho = carrinho.filter(i => i.id !== idProduto);
    }

    salvarCarrinho(carrinho);
    atualizarContador();
    carregarCarrinho();
}

// =========================
// LIMPAR CARRINHO
// =========================
function limparCarrinho() {
    salvarCarrinho([]);
    atualizarContador();
    carregarCarrinho();
    abrirPopup("Carrinho limpo.");
}

// =========================
// CONTADOR DO CARRINHO
// =========================
function atualizarContador() {
    const carrinho = lerCarrinho();
    const total = carrinho.reduce((soma, item) => soma + item.quantidade, 0);
    const contador = document.getElementById("carrinho-contador");
    if (contador) contador.textContent = total;
}
// =========================
// FINALIZAR COMPRA
// =========================
function finalizarCompra() {
    const carrinho = lerCarrinho();
    
    if (carrinho.length === 0) {
        abrirPopup("Seu carrinho está vazio!");
        return;
    }

    // Calcula total
    const total = carrinho.reduce((soma, item) => soma + item.preco * item.quantidade, 0);

    // Mensagem de sucesso
    abrirPopup(`Compra finalizada com sucesso! Total: R$ ${total.toFixed(2).replace(".", ",")}`, "index.html");

    // Limpa o carrinho
    salvarCarrinho([]);
    atualizarContador();
    carregarCarrinho();
}

// =========================
// POPUP SIMPLES
// =========================
function abrirPopup(mensagem, destino = null) {
    const overlay = document.getElementById("popup-overlay");
    const msg = document.getElementById("popup-message");
    const fechar = document.getElementById("popup-close");

    if (!overlay || !msg || !fechar) {
        alert(mensagem);
        if (destino) window.location.href = destino;
        return;
    }

    msg.textContent = mensagem;
    overlay.style.display = "flex";

    fechar.onclick = () => {
        overlay.style.display = "none";
        if (destino) window.location.href = destino;
    };
}

// =========================
// CARREGAR CARRINHO (renderiza itens na página carrinho.html)
// =========================
function carregarCarrinho() {
    const itens = lerCarrinho();
    const container = document.getElementById("carrinho-container");
    const totalSpan = document.getElementById("carrinho-total");

    container.innerHTML = "";
    let total = 0;

    itens.forEach((item, index) => {
        total += item.preco * item.quantidade;

        container.innerHTML += `
            <div class="carrinho-item">
                <div class="carrinho-info">
                    <h3>${item.nome}</h3>
                    <p>R$ ${item.preco.toFixed(2)}</p>
                    <p>Qtd: 
                        <button onclick="decrementar(${item.id})">−</button>
                        ${item.quantidade}
                        <button onclick="incrementar(${item.id})">+</button>
                    </p>
                </div>
                <button class="btn-remover" onclick="removerDoCarrinho(${item.id})">X</button>
            </div>
        `;
    });

    totalSpan.textContent = total.toFixed(2).replace(".", ",");
}

// =========================
// INICIALIZAÇÃO AO CARREGAR PÁGINA
// =========================
document.addEventListener("DOMContentLoaded", () => {
    atualizarContador();
    carregarCarrinho();
});

