<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perguntas Frequentes - E-commerce</title>
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* Custom colors */
        pre{
            display: none;
        }
        .bg-primary { background-color: #3b82f6; }
        .text-primary { color: #3b82f6; }
        .border-primary { border-color: #3b82f6; }
        .hover\:bg-primary:hover { background-color: #3b82f6; }
        .hover\:text-primary:hover { color: #3b82f6; }
        .bg-secondary { background-color: #1e40af; }
        .hover\:bg-secondary:hover { background-color: #1e40af; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 py-6 flex justify-between items-center">
            <h1 class="text-3xl font-bold text-primary">E-commerce</h1>
            <nav class="flex space-x-4">
                <a href="index.php" class="text-gray-600 hover:text-primary">Home</a>
                <a href="index.php?c=product&a=list" class="text-gray-600 hover:text-primary">Produtos</a>
                <a href="index.php?c=home&a=contact" class="text-gray-600 hover:text-primary">Contato</a>
                <a href="index.php?c=home&a=about" class="text-gray-600 hover:text-primary">Sobre</a>
                <a href="index.php?c=home&a=faq" class="text-primary font-medium">FAQ</a>
                <a href="index.php?c=home&a=login" class="text-gray-600 hover:text-primary">Login</a>
                <a href="index.php?c=home&a=register" class="text-gray-600 hover:text-primary">Cadastro</a>
            </nav>
        </div>
    </header>

    <!-- Main content -->
    <main class="max-w-7xl mx-auto px-4 py-8">
        <div class="bg-white shadow-md rounded-lg p-8">
            <h1 class="text-3xl font-bold text-primary mb-8">Perguntas Frequentes</h1>
            
            <!-- Search bar -->
            <div class="mb-8">
                <div class="relative">
                    <input type="text" id="faq-search" placeholder="Buscar perguntas..." 
                           class="w-full px-4 py-2 pl-10 border rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                </div>
            </div>
            
            <!-- FAQ Categories -->
            <div class="mb-8">
                <div class="flex flex-wrap gap-2">
                    <button class="bg-primary text-white px-4 py-2 rounded-full text-sm font-medium">Todos</button>
                    <button class="bg-gray-200 text-gray-700 px-4 py-2 rounded-full text-sm font-medium hover:bg-gray-300">Pedidos</button>
                    <button class="bg-gray-200 text-gray-700 px-4 py-2 rounded-full text-sm font-medium hover:bg-gray-300">Pagamentos</button>
                    <button class="bg-gray-200 text-gray-700 px-4 py-2 rounded-full text-sm font-medium hover:bg-gray-300">Entregas</button>
                    <button class="bg-gray-200 text-gray-700 px-4 py-2 rounded-full text-sm font-medium hover:bg-gray-300">Trocas e Devoluções</button>
                    <button class="bg-gray-200 text-gray-700 px-4 py-2 rounded-full text-sm font-medium hover:bg-gray-300">Conta</button>
                </div>
            </div>
            
            <!-- FAQ Items -->
            <div class="space-y-6">
                <!-- FAQ Item 1 -->
                <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <button class="flex justify-between items-center w-full px-6 py-4 text-left bg-white hover:bg-gray-50 focus:outline-none" onclick="toggleFaq(this)">
                        <span class="text-lg font-medium text-gray-900">Como faço para realizar um pedido?</span>
                        <i class="fas fa-chevron-down text-gray-500 transition-transform"></i>
                    </button>
                    <div class="hidden px-6 py-4 bg-gray-50 border-t border-gray-200">
                        <p class="text-gray-700">
                            Para realizar um pedido, siga estes passos simples:
                        </p>
                        <ol class="list-decimal pl-5 mt-2 space-y-1 text-gray-700">
                            <li>Navegue pelo nosso catálogo e encontre os produtos que deseja comprar.</li>
                            <li>Clique no botão "Comprar" ou "Adicionar ao Carrinho".</li>
                            <li>Revise os itens no seu carrinho e clique em "Finalizar Compra".</li>
                            <li>Preencha suas informações de envio e pagamento.</li>
                            <li>Confirme seu pedido e pronto!</li>
                        </ol>
                        <p class="mt-2 text-gray-700">
                            Você receberá um e-mail de confirmação com os detalhes do seu pedido.
                        </p>
                    </div>
                </div>
                
                <!-- FAQ Item 2 -->
                <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <button class="flex justify-between items-center w-full px-6 py-4 text-left bg-white hover:bg-gray-50 focus:outline-none" onclick="toggleFaq(this)">
                        <span class="text-lg font-medium text-gray-900">Quais são as formas de pagamento aceitas?</span>
                        <i class="fas fa-chevron-down text-gray-500 transition-transform"></i>
                    </button>
                    <div class="hidden px-6 py-4 bg-gray-50 border-t border-gray-200">
                        <p class="text-gray-700">
                            Aceitamos diversas formas de pagamento para sua conveniência:
                        </p>
                        <ul class="list-disc pl-5 mt-2 space-y-1 text-gray-700">
                            <li>Cartões de crédito (Visa, Mastercard, American Express, Elo)</li>
                            <li>Cartões de débito</li>
                            <li>Boleto bancário</li>
                            <li>PIX</li>
                            <li>Transferência bancária</li>
                            <li>PayPal</li>
                        </ul>
                        <p class="mt-2 text-gray-700">
                            Para pagamentos com boleto, o pedido será processado após a confirmação do pagamento, o que pode levar até 3 dias úteis.
                        </p>
                    </div>
                </div>
                
                <!-- FAQ Item 3 -->
                <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <button class="flex justify-between items-center w-full px-6 py-4 text-left bg-white hover:bg-gray-50 focus:outline-none" onclick="toggleFaq(this)">
                        <span class="text-lg font-medium text-gray-900">Qual é o prazo de entrega?</span>
                        <i class="fas fa-chevron-down text-gray-500 transition-transform"></i>
                    </button>
                    <div class="hidden px-6 py-4 bg-gray-50 border-t border-gray-200">
                        <p class="text-gray-700">
                            O prazo de entrega varia de acordo com a sua localização e o método de envio escolhido:
                        </p>
                        <ul class="list-disc pl-5 mt-2 space-y-1 text-gray-700">
                            <li><strong>Entrega Expressa:</strong> 1 a 3 dias úteis (capitais e regiões metropolitanas)</li>
                            <li><strong>Entrega Padrão:</strong> 3 a 7 dias úteis</li>
                            <li><strong>Entrega Econômica:</strong> 7 a 15 dias úteis</li>
                        </ul>
                        <p class="mt-2 text-gray-700">
                            O prazo começa a contar a partir da confirmação do pagamento e aprovação do pedido. Você pode acompanhar o status da sua entrega na área "Meus Pedidos" da sua conta.
                        </p>
                    </div>
                </div>
                
                <!-- FAQ Item 4 -->
                <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <button class="flex justify-between items-center w-full px-6 py-4 text-left bg-white hover:bg-gray-50 focus:outline-none" onclick="toggleFaq(this)">
                        <span class="text-lg font-medium text-gray-900">Como faço para trocar ou devolver um produto?</span>
                        <i class="fas fa-chevron-down text-gray-500 transition-transform"></i>
                    </button>
                    <div class="hidden px-6 py-4 bg-gray-50 border-t border-gray-200">
                        <p class="text-gray-700">
                            Você pode solicitar uma troca ou devolução em até 7 dias após o recebimento do produto, conforme o Código de Defesa do Consumidor.
                        </p>
                        <p class="mt-2 text-gray-700">
                            Para iniciar o processo:
                        </p>
                        <ol class="list-decimal pl-5 mt-2 space-y-1 text-gray-700">
                            <li>Acesse sua conta e vá para "Meus Pedidos"</li>
                            <li>Encontre o pedido e clique em "Solicitar Troca/Devolução"</li>
                            <li>Selecione os produtos e informe o motivo</li>
                            <li>Siga as instruções para envio do produto</li>
                        </ol>
                        <p class="mt-2 text-gray-700">
                            Após recebermos o produto e confirmarmos que está nas condições adequadas, processaremos o reembolso ou enviaremos um novo produto, conforme sua escolha.
                        </p>
                    </div>
                </div>
                
                <!-- FAQ Item 5 -->
                <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <button class="flex justify-between items-center w-full px-6 py-4 text-left bg-white hover:bg-gray-50 focus:outline-none" onclick="toggleFaq(this)">
                        <span class="text-lg font-medium text-gray-900">Como posso rastrear meu pedido?</span>
                        <i class="fas fa-chevron-down text-gray-500 transition-transform"></i>
                    </button>
                    <div class="hidden px-6 py-4 bg-gray-50 border-t border-gray-200">
                        <p class="text-gray-700">
                            Você pode rastrear seu pedido de duas maneiras:
                        </p>
                        <ol class="list-decimal pl-5 mt-2 space-y-1 text-gray-700">
                            <li>Faça login na sua conta, acesse "Meus Pedidos" e clique em "Rastrear" ao lado do pedido desejado.</li>
                            <li>Use o código de rastreamento enviado no e-mail de confirmação de envio diretamente no site da transportadora.</li>
                        </ol>
                        <p class="mt-2 text-gray-700">
                            Se você tiver algum problema para rastrear seu pedido, entre em contato com nosso suporte ao cliente.
                        </p>
                    </div>
                </div>
                
                <!-- FAQ Item 6 -->
                <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <button class="flex justify-between items-center w-full px-6 py-4 text-left bg-white hover:bg-gray-50 focus:outline-none" onclick="toggleFaq(this)">
                        <span class="text-lg font-medium text-gray-900">Como recuperar minha senha?</span>
                        <i class="fas fa-chevron-down text-gray-500 transition-transform"></i>
                    </button>
                    <div class="hidden px-6 py-4 bg-gray-50 border-t border-gray-200">
                        <p class="text-gray-700">
                            Para recuperar sua senha:
                        </p>
                        <ol class="list-decimal pl-5 mt-2 space-y-1 text-gray-700">
                            <li>Clique em "Login" no menu superior</li>
                            <li>Clique em "Esqueceu a senha?"</li>
                            <li>Digite o e-mail associado à sua conta</li>
                            <li>Clique em "Enviar link de recuperação"</li>
                            <li>Verifique seu e-mail e siga as instruções enviadas</li>
                        </ol>
                        <p class="mt-2 text-gray-700">
                            O link de recuperação expira em 24 horas. Se você não receber o e-mail, verifique sua pasta de spam ou entre em contato com nosso suporte.
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Still need help section -->
            <div class="mt-12 bg-gray-50 p-6 rounded-lg border border-gray-200">
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Ainda precisa de ajuda?</h3>
                <p class="text-gray-700 mb-4">
                    Se você não encontrou a resposta para sua pergunta, nossa equipe de suporte está pronta para ajudar.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="index.php?c=home&a=contact" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-primary hover:bg-secondary">
                        <i class="fas fa-envelope mr-2"></i> Contato
                    </a>
                    <a href="#" class="inline-flex items-center justify-center px-5 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        <i class="fas fa-comments mr-2"></i> Chat ao vivo
                    </a>
                    <a href="tel:+551199999999" class="inline-flex items-center justify-center px-5 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        <i class="fas fa-phone-alt mr-2"></i> (11) 9999-9999
                    </a>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white shadow-sm mt-8">
        <div class="max-w-7xl mx-auto px-4 py-6 text-center">
            <p class="text-gray-600">&copy; 2023 E-commerce. Todos os direitos reservados.</p>
        </div>
    </footer>

    <!-- JavaScript for FAQ accordion -->
    <script>
        function toggleFaq(button) {
            // Toggle the answer visibility
            const answer = button.nextElementSibling;
            answer.classList.toggle('hidden');
            
            // Toggle the icon rotation
            const icon = button.querySelector('i');
            icon.classList.toggle('transform');
            icon.classList.toggle('rotate-180');
        }
        
        // Search functionality
        document.getElementById('faq-search').addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            const faqItems = document.querySelectorAll('.border.border-gray-200.rounded-lg');
            
            faqItems.forEach(item => {
                const question = item.querySelector('span').textContent.toLowerCase();
                const answer = item.querySelector('div[class^="hidden"]').textContent.toLowerCase();
                
                if (question.includes(searchTerm) || answer.includes(searchTerm)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>