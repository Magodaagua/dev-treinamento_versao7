             document.getElementById('chat-form').addEventListener('submit', function (e) {
                    e.preventDefault();

                    // ... (código para enviar a mensagem)
                    var usuario = document.getElementById('usuario').value;
                    var nome = document.getElementById('nome').value;
                    var mensagem = document.getElementById('mensagem').value;
                    var tipo = document.getElementById('tipo').value;

                    // Adicione a identificação única do cliente à requisição
                    var cliente_id = 'coloqueAquiOIDUnicoDoCliente';  // Substitua pelo ID único do cliente com quem o suporte está interagindo
                            var xhr = new XMLHttpRequest();
                            xhr.open('POST', 'php/enviar_mensagem.php', true);
                            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                            xhr.onreadystatechange = function () {
                                if (xhr.readyState == 4 && xhr.status == 200) {
                                    // Processar a resposta do servidor, se necessário
                                    console.log(xhr.responseText);
                                    // Atualizar mensagens após o envio bem-sucedido
                                    carregarMensagens();
                                }
                            };

                            xhr.send('usuario=' + encodeURIComponent(usuario) + '&nome=' + encodeURIComponent(nome) + '&mensagem=' + encodeURIComponent(mensagem) + '&tipo=' + encodeURIComponent(tipo));

                            // Limpar campo de mensagem após envio
                            document.getElementById('mensagem').value = '';

                    // Role para a última mensagem
                    var messagesContainer = document.getElementById('messages-container');
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                });

                // Variável global para armazenar o status da rolagem
                var scrolledToBottom = true;

                // Função para verificar se a área de mensagens está rolada para baixo
                function isScrolledToBottom(element) {
                    return element.scrollHeight - element.clientHeight <= element.scrollTop + 1;
                }


                // Função para carregar mensagens do servidor
                function carregarMensagens(id_grupo) {
                    var messagesContainer = document.getElementById('messages-container');
                    var shouldScrollToBottom = isScrolledToBottom(messagesContainer);

                    var xhr = new XMLHttpRequest();
                    xhr.open('GET', 'php/exibir_mensagens.php', true);
                    xhr.onreadystatechange = function () {
                        if (xhr.readyState == 4 && xhr.status == 200) {
                            // Atualizar o conteúdo do contêiner de mensagens
                            document.getElementById('messages-container').innerHTML = xhr.responseText;
                            
                            // Rolagem automática apenas se o usuário já estava no final da página
                            if (shouldScrollToBottom) {
                                messagesContainer.scrollTop = messagesContainer.scrollHeight;
                            }
                        }
                    };
                    xhr.send();
                }

                // Atualizar mensagens a cada 5 segundos (por exemplo)
                setInterval(carregarMensagens, 5000);
                // Atualizar mensagens apenas se o usuário estiver no final da página
                setInterval(function() {
                    if (scrolledToBottom) {
                        // Chamar a função carregarMensagens() com o id_grupo
                        carregarMensagens();
                    }
                }, 5000);
