# ProjetoPraticoP2
Repositorio do projeto pratico do professor Jeofton de uma aplicação web utilizando HTML5, CSS3, PHP8 e Java Script tendo implementação com banco de dados MySQL

## 📋 Visão Geral  
Este projeto consiste em uma aplicação web simples, voltada para a gestão ou apresentação de produtos (“loja de jogos”), com cadastro e listagem, utilizando as tecnologias:  
- Front-end: HTML5, CSS3, JavaScript  
- Back-end: PHP 8  
- Banco de dados: MySQL  
- Arquitetura: páginas estáticas + scripts PHP + conexão ao banco

O objetivo é colocar em prática conceitos de desenvolvimento web full-stack básico, integração com banco, manipulação de dados e interface de usuário.

## 🗂 Estrutura do Projeto  
A seguir a estrutura geral de arquivos/folders mais relevantes:

- /imagens/
-cadastro
    | conection.php
    | processa.php
    | login.php
- cadastro.html -página de cadastro de usuários
- index.html -página inicial estática
- login.html -página de login
- produtos.html -página de listagem de produtos
- scripts.js -arquivo JavaScript para interatividade
- sobre.html -página “Sobre” explicando o projeto
- styles.css -estilos CSS para layout do site

## ✅ Funcionalidades  
A aplicação contempla as seguintes funcionalidades principais:

- Formulário de cadastro (via **cadastro.html**) para inserir usuários no banco de dados – envio via PHP.  
- Conexão com o banco MySQL (via **conection.php**) para consulta/inserção de dados.  
- Página inicial dinâmica (**index.php**) que pode trazer dados do banco ou componentes PHP para renderizar conteúdo.  
- Navegação entre páginas informativas (sobre.html), listagem de produtos (produtos.html) e loja de jogos (lojadejogos.html).  
- Front-end responsivo ou estilizado com CSS3 e comportamento com JavaScript (scripts.js) para manipulação de DOM, validações ou efeitos.  
- Estrutura modular: separar front-end estático das partes dinâmicas/back-end.

## 🛠 Tecnologias Utilizadas  
- **HTML5** – marcação semântica para estrutura de páginas.  
- **CSS3** – estilização, layout responsivo e design visual.  
- **JavaScript** – scripts para comportamento no cliente (interatividade, validação, manipulação).  
- **PHP 8** – lógica de back-end, interação com banco, páginas dinâmicas.  
- **MySQL** – sistema de banco de dados relacional para armazenar dados de produtos ou usuários.  
- (Opcional) Servidor web local ou remoto para hospedar a aplicação (por exemplo Apache ou Nginx + PHP + MySQL).
