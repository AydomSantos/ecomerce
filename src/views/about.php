<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre Nós - E-commerce</title>
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
                <a href="index.php?c=home&a=about" class="text-primary font-medium">Sobre</a>
                <a href="index.php?c=home&a=login" class="text-gray-600 hover:text-primary">Login</a>
                <a href="index.php?c=home&a=register" class="text-gray-600 hover:text-primary">Cadastro</a>
            </nav>
        </div>
    </header>

    <!-- Main content -->
    <main class="max-w-7xl mx-auto px-4 py-8">
        <!-- Hero Section -->
        <section class="bg-white shadow-md rounded-lg overflow-hidden mb-8">
            <div class="md:flex">
                <div class="md:w-1/2 p-8">
                    <h2 class="text-3xl font-bold text-primary mb-4">Nossa História</h2>
                    <p class="text-gray-700 mb-4">
                        Fundada em 2020, nossa empresa nasceu com a missão de revolucionar o comércio eletrônico, oferecendo produtos de alta qualidade com preços acessíveis e uma experiência de compra excepcional.
                    </p>
                    <p class="text-gray-700 mb-4">
                        Começamos como uma pequena operação familiar e, graças à confiança de nossos clientes, crescemos rapidamente para nos tornarmos uma referência no mercado de e-commerce brasileiro.
                    </p>
                    <p class="text-gray-700">
                        Hoje, contamos com uma equipe dedicada de profissionais comprometidos em proporcionar a melhor experiência possível para nossos clientes, desde a navegação no site até o recebimento do produto.
                    </p>
                </div>
                <div class="md:w-1/2">
                    <img src="https://images.unsplash.com/photo-1542744173-8e7e53415bb0?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Nossa equipe" class="w-full h-full object-cover">
                </div>
            </div>
        </section>

        <!-- Mission, Vision, Values -->
        <section class="mb-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="text-primary text-4xl mb-4">
                        <i class="fas fa-bullseye"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Nossa Missão</h3>
                    <p class="text-gray-700">
                        Proporcionar a melhor experiência de compra online, oferecendo produtos de qualidade a preços justos, com atendimento excepcional e entrega rápida.
                    </p>
                </div>
                
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="text-primary text-4xl mb-4">
                        <i class="fas fa-eye"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Nossa Visão</h3>
                    <p class="text-gray-700">
                        Ser reconhecida como a empresa de e-commerce mais confiável e inovadora do Brasil, expandindo continuamente nosso catálogo de produtos e alcançando novos mercados.
                    </p>
                </div>
                
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="text-primary text-4xl mb-4">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Nossos Valores</h3>
                    <ul class="text-gray-700 space-y-2">
                        <li><i class="fas fa-check text-primary mr-2"></i> Integridade e transparência</li>
                        <li><i class="fas fa-check text-primary mr-2"></i> Foco no cliente</li>
                        <li><i class="fas fa-check text-primary mr-2"></i> Inovação constante</li>
                        <li><i class="fas fa-check text-primary mr-2"></i> Responsabilidade social</li>
                        <li><i class="fas fa-check text-primary mr-2"></i> Trabalho em equipe</li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- Team Section -->
        <section class="mb-8">
            <h2 class="text-2xl font-semibold text-primary mb-6">Nossa Equipe</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Team Member -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Membro da equipe" class="w-full h-64 object-cover">
                    <div class="p-4">
                        <h3 class="text-lg font-bold">João Silva</h3>
                        <p class="text-primary">CEO & Fundador</p>
                        <p class="text-gray-600 mt-2">Com mais de 15 anos de experiência em e-commerce e tecnologia.</p>
                        <div class="mt-3 flex space-x-3">
                            <a href="#" class="text-gray-400 hover:text-primary"><i class="fab fa-linkedin"></i></a>
                            <a href="#" class="text-gray-400 hover:text-primary"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="text-gray-400 hover:text-primary"><i class="fas fa-envelope"></i></a>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Membro da equipe" class="w-full h-64 object-cover">
                    <div class="p-4">
                        <h3 class="text-lg font-bold">Maria Oliveira</h3>
                        <p class="text-primary">Diretora de Marketing</p>
                        <p class="text-gray-600 mt-2">Especialista em marketing digital e estratégias de crescimento.</p>
                        <div class="mt-3 flex space-x-3">
                            <a href="#" class="text-gray-400 hover:text-primary"><i class="fab fa-linkedin"></i></a>
                            <a href="#" class="text-gray-400 hover:text-primary"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="text-gray-400 hover:text-primary"><i class="fas fa-envelope"></i></a>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="https://randomuser.me/api/portraits/men/75.jpg" alt="Membro da equipe" class="w-full h-64 object-cover">
                    <div class="p-4">
                        <h3 class="text-lg font-bold">Carlos Santos</h3>
                        <p class="text-primary">CTO</p>
                        <p class="text-gray-600 mt-2">Desenvolvedor full-stack com paixão por criar experiências de usuário excepcionais.</p>
                        <div class="mt-3 flex space-x-3">
                            <a href="#" class="text-gray-400 hover:text-primary"><i class="fab fa-linkedin"></i></a>
                            <a href="#" class="text-gray-400 hover:text-primary"><i class="fab fa-github"></i></a>
                            <a href="#" class="text-gray-400 hover:text-primary"><i class="fas fa-envelope"></i></a>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="https://randomuser.me/api/portraits/women/65.jpg" alt="Membro da equipe" class="w-full h-64 object-cover">
                    <div class="p-4">
                        <h3 class="text-lg font-bold">Ana Pereira</h3>
                        <p class="text-primary">Gerente de Atendimento</p>
                        <p class="text-gray-600 mt-2">Dedicada a garantir que cada cliente tenha uma experiência incrível.</p>
                        <div class="mt-3 flex space-x-3">
                            <a href="#" class="text-gray-400 hover:text-primary"><i class="fab fa-linkedin"></i></a>
                            <a href="#" class="text-gray-400 hover:text-primary"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="text-gray-400 hover:text-primary"><i class="fas fa-envelope"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Testimonials -->
        <section class="mb-8">
            <h2 class="text-2xl font-semibold text-primary mb-6">O Que Nossos Clientes Dizem</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center mb-4">
                        <div class="text-yellow-400 flex">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <span class="ml-2 text-gray-600">5.0</span>
                    </div>
                    <p class="text-gray-700 mb-4">
                        "Comprei um produto e fiquei impressionado com a rapidez da entrega e a qualidade do atendimento. Certamente voltarei a comprar!"
                    </p>
                    <div class="flex items-center">
                        <img src="https://randomuser.me/api/portraits/men/41.jpg" alt="Cliente" class="w-10 h-10 rounded-full mr-3">
                        <div>
                            <p class="font-medium">Roberto Almeida</p>
                            <p class="text-gray-500 text-sm">Cliente desde 2021</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center mb-4">
                        <div class="text-yellow-400 flex">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <span class="ml-2 text-gray-600">5.0</span>
                    </div>
                    <p class="text-gray-700 mb-4">
                        "Excelente experiência de compra! O site é intuitivo, os preços são justos e o produto chegou antes do prazo previsto."
                    </p>
                    <div class="flex items-center">
                        <img src="https://randomuser.me/api/portraits/women/63.jpg" alt="Cliente" class="w-10 h-10 rounded-full mr-3">
                        <div>
                            <p class="font-medium">Fernanda Costa</p>
                            <p class="text-gray-500 text-sm">Cliente desde 2022</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center mb-4">
                        <div class="text-yellow-400 flex">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                        <span class="ml-2 text-gray-600">4.5</span>
                    </div>
                    <p class="text-gray-700 mb-4">
                        "Tive um pequeno problema com meu pedido, mas o suporte ao cliente resolveu rapidamente. Estou muito satisfeito com a atenção recebida."
                    </p>
                    <div class="flex items-center">
                        <img src="https://randomuser.me/api/portraits/men/22.jpg" alt="Cliente" class="w-10 h-10 rounded-full mr-3">
                        <div>
                            <p class="font-medium">Lucas Mendes</p>
                            <p class="text-gray-500 text-sm">Cliente desde 2020</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 py-6 text-center">
            <p class="text-gray-600">&copy; 2023 E-commerce. Todos os direitos reservados.</p>
        </div>
    </footer>
</body>
</html>