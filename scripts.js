document.addEventListener('DOMContentLoaded', () => {
    // 1. Seleciona o formulário e a mensagem de sucesso
    const form = document.querySelector('.cadastro-form');
    const successMessage = document.getElementById('successMessage');

    if (form) {
        // 2. Adiciona um "ouvinte" para o evento de submissão
        form.addEventListener('submit', function(event) {
            // Previne o envio padrão do formulário (que recarregaria a página)
            event.preventDefault(); 
            
            // Verifica se as senhas coincidem (Validação básica de cliente)
            const senha = document.getElementById('senha').value;
            const confirmarSenha = document.getElementById('confirmar-senha').value;
            
            if (senha !== confirmarSenha) {
                alert('As senhas não coincidem. Por favor, verifique.');
                return; // Impede o envio se as senhas forem diferentes
            }

            // Cria um objeto FormData com os dados do formulário
            const formData = new FormData(form);
            
            // Pega o valor do atributo 'action' do formulário (que é 'index.php')
            const actionUrl = form.getAttribute('action');

            // 3. Envia os dados de forma assíncrona (AJAX)
            fetch(actionUrl, {
                method: 'POST',
                body: formData
            })
            .then(response => {
                // O PHP deve retornar um JSON
                if (!response.ok) {
                    throw new Error('Erro na resposta do servidor: ' + response.status);
                }
                return response.json(); 
            })
            .then(data => {
                // 4. Verifica a resposta do PHP
                if (data.status === 'success') {
                    // 5. Mostra a mensagem de sucesso
                    successMessage.style.display = 'block';
                    
                    // Limpa o formulário
                    form.reset(); 
                    
                    // 6. Esconde a mensagem após 4 segundos
                    setTimeout(() => {
                        successMessage.style.display = 'none';
                    }, 4000); 
                    
                } else {
                    // Trata erros de lógica do PHP (ex: email já cadastrado)
                    console.error('Erro no cadastro:', data.message);
                    alert('Houve um erro no cadastro: ' + (data.message || 'Verifique o console para mais detalhes.'));
                }
            })
            .catch(error => {
                // Trata erros de rede ou de requisição
                console.error('Erro de requisição:', error);
                alert('Não foi possível se conectar ao servidor ou houve um erro inesperado.');
            });
        });
    }
});