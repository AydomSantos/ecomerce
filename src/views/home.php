<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - E-commerce</title>
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
                <a href="#" class="text-gray-600 hover:text-primary">Home</a>
                <a href="index.php?c=product&a=list" class="text-gray-600 hover:text-primary">Produtos</a>
                <a href="index.php?c=home&a=contact" class="text-gray-600 hover:text-primary">Contato</a>
                <a href="index.php?c=home&a=about" class="text-gray-600 hover:text-primary">Sobre</a>
                <a href="index.php?c=home&a=faq" class="text-gray-600 hover:text-primary">FAQ</a>
                <a href="index.php?c=home&a=login" class="text-gray-600 hover:text-primary">Login</a>
                <a href="index.php?c=home&a=register" class="text-gray-600 hover:text-primary">Cadastro</a>
            </nav>
        </div>
    </header>

    <!-- Main content -->
    <main class="max-w-7xl mx-auto px-4 py-8">
        <!-- Promoções -->
        <section class="mb-8">
            <h2 class="text-2xl font-semibold text-primary mb-4">Promoções</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Card de produto -->
                <div class="bg-white rounded-lg shadow-md p-4">
                    <img src="https://via.placeholder.com/150" alt="Produto" class="w-full h-40 object-cover mb-4">
                    <h3 class="text-lg font-bold">Produto 1</h3>
                    <p class="text-gray-500">Descrição breve do produto.</p>
                    <button class="mt-4 bg-primary text-white py-2 px-4 rounded hover:bg-secondary">Comprar</button>
                </div>
                <div class="bg-white rounded-lg shadow-md p-4">
                    <img src="https://via.placeholder.com/150" alt="Produto" class="w-full h-40 object-cover mb-4">
                    <h3 class="text-lg font-bold">Produto 1</h3>
                    <p class="text-gray-500">Descrição breve do produto.</p>
                    <button class="mt-4 bg-primary text-white py-2 px-4 rounded hover:bg-secondary">Comprar</button>
                </div>
                <div class="bg-white rounded-lg shadow-md p-4">
                    <img src="https://via.placeholder.com/150" alt="Produto" class="w-full h-40 object-cover mb-4">
                    <h3 class="text-lg font-bold">Produto 1</h3>
                    <p class="text-gray-500">Descrição breve do produto.</p>
                    <button class="mt-4 bg-primary text-white py-2 px-4 rounded hover:bg-secondary">Comprar</button>
                </div>
                <!-- Repetir para outros produtos -->
            </div>
        </section>

        <!-- Mais vendidos -->
        <section class="mb-8">
            <h2 class="text-2xl font-semibold text-primary mb-4">Mais Vendidos</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Card de produto -->
                <div class="bg-white rounded-lg shadow-md p-4">
                    <img src="https://via.placeholder.com/150" alt="Produto" class="w-full h-40 object-cover mb-4">
                    <h3 class="text-lg font-bold">Produto 2</h3>
                    <p class="text-gray-500">Descrição breve do produto.</p>
                    <button class="mt-4 bg-primary text-white py-2 px-4 rounded hover:bg-secondary">Comprar</button>
                </div>
                <div class="bg-white rounded-lg shadow-md p-4">
                    <img src="https://via.placeholder.com/150" alt="Produto" class="w-full h-40 object-cover mb-4">
                    <h3 class="text-lg font-bold">Produto 2</h3>
                    <p class="text-gray-500">Descrição breve do produto.</p>
                    <button class="mt-4 bg-primary text-white py-2 px-4 rounded hover:bg-secondary">Comprar</button>
                </div>
                <div class="bg-white rounded-lg shadow-md p-4">
                    <img src="https://via.placeholder.com/150" alt="Produto" class="w-full h-40 object-cover mb-4">
                    <h3 class="text-lg font-bold">Produto 2</h3>
                    <p class="text-gray-500">Descrição breve do produto.</p>
                    <button class="mt-4 bg-primary text-white py-2 px-4 rounded hover:bg-secondary">Comprar</button>
                </div>
                <!-- Repetir para outros produtos -->
            </div>
        </section>

        <!-- Recomendados -->
        <section class="mb-8">
            <h2 class="text-2xl font-semibold text-primary mb-4">Recomendados</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Card de produto -->
                <div class="bg-white rounded-lg shadow-md p-4">
                    <img src="https://via.placeholder.com/150" alt="Produto" class="w-full h-40 object-cover mb-4">
                    <h3 class="text-lg font-bold">Produto 3</h3>
                    <p class="text-gray-500">Descrição breve do produto.</p>
                    <button class="mt-4 bg-primary text-white py-2 px-4 rounded hover:bg-secondary">Comprar</button>
                </div>
                <div class="bg-white rounded-lg shadow-md p-4">
                    <img src="https://via.placeholder.com/150" alt="Produto" class="w-full h-40 object-cover mb-4">
                    <h3 class="text-lg font-bold">Produto 2</h3>
                    <p class="text-gray-500">Descrição breve do produto.</p>
                    <button class="mt-4 bg-primary text-white py-2 px-4 rounded hover:bg-secondary">Comprar</button>
                </div>
                <div class="bg-white rounded-lg shadow-md p-4">
                    <img src="https://via.placeholder.com/150" alt="Produto" class="w-full h-40 object-cover mb-4">
                    <h3 class="text-lg font-bold">Produto 2</h3>
                    <p class="text-gray-500">Descrição breve do produto.</p>
                    <button class="mt-4 bg-primary text-white py-2 px-4 rounded hover:bg-secondary">Comprar</button>
                </div>
                <!-- Repetir para outros produtos -->
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