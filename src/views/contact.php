<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contato - E-commerce</title>
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
        .focus\:border-primary:focus { border-color: #3b82f6; }
        .focus\:ring-primary:focus { --tw-ring-color: #3b82f6; }
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
                <a href="index.php?c=home&a=contact" class="text-primary font-medium">Contato</a>
            </nav>
        </div>
    </header>

    <!-- Main content -->
    <main class="max-w-7xl mx-auto px-4 py-8">
        <div class="bg-white shadow-md rounded-lg p-8 max-w-3xl mx-auto">
            <h2 class="text-2xl font-semibold text-primary mb-6">Entre em Contato</h2>
            
            <?php if (isset($_SESSION['contact_success'])): ?>
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                    <p><?php echo $_SESSION['contact_success']; ?></p>
                    <?php unset($_SESSION['contact_success']); ?>
                </div>
            <?php endif; ?>
            
            <?php if (isset($_SESSION['contact_error'])): ?>
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                    <p><?php echo $_SESSION['contact_error']; ?></p>
                    <?php unset($_SESSION['contact_error']); ?>
                </div>
            <?php endif; ?>
            
            <form action="index.php?c=home&a=submitContact" method="post" class="space-y-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nome Completo</label>
                    <input type="text" id="name" name="name" value="<?php echo $_SESSION['contact_data']['name'] ?? ''; ?>" 
                           class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary" required>
                    <?php if (isset($_SESSION['contact_errors']['name'])): ?>
                        <p class="text-red-500 text-sm mt-1"><?php echo $_SESSION['contact_errors']['name']; ?></p>
                    <?php endif; ?>
                </div>
                
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo $_SESSION['contact_data']['email'] ?? ''; ?>"
                           class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary" required>
                    <?php if (isset($_SESSION['contact_errors']['email'])): ?>
                        <p class="text-red-500 text-sm mt-1"><?php echo $_SESSION['contact_errors']['email']; ?></p>
                    <?php endif; ?>
                </div>
                
                <div>
                    <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Assunto</label>
                    <input type="text" id="subject" name="subject" value="<?php echo $_SESSION['contact_data']['subject'] ?? ''; ?>"
                           class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary" required>
                    <?php if (isset($_SESSION['contact_errors']['subject'])): ?>
                        <p class="text-red-500 text-sm mt-1"><?php echo $_SESSION['contact_errors']['subject']; ?></p>
                    <?php endif; ?>
                </div>
                
                <div>
                    <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Mensagem</label>
                    <textarea id="message" name="message" rows="5" 
                              class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary" required><?php echo $_SESSION['contact_data']['message'] ?? ''; ?></textarea>
                    <?php if (isset($_SESSION['contact_errors']['message'])): ?>
                        <p class="text-red-500 text-sm mt-1"><?php echo $_SESSION['contact_errors']['message']; ?></p>
                    <?php endif; ?>
                </div>
                
                <button type="submit" class="w-full bg-primary text-white py-2 px-4 rounded-md hover:bg-secondary transition duration-300">
                    Enviar Mensagem
                </button>
            </form>
        </div>
        
        <div class="bg-white shadow-md rounded-lg p-8 max-w-3xl mx-auto mt-8">
            <h2 class="text-2xl font-semibold text-primary mb-6">Informações de Contato</h2>
            
            <div class="space-y-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0 mt-1">
                        <i class="fas fa-map-marker-alt text-primary"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-gray-700 font-medium">Endereço</p>
                        <p class="text-gray-600">Av. Paulista, 1000 - Bela Vista, São Paulo - SP, 01310-100</p>
                    </div>
                </div>
                
                <div class="flex items-start">
                    <div class="flex-shrink-0 mt-1">
                        <i class="fas fa-phone-alt text-primary"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-gray-700 font-medium">Telefone</p>
                        <p class="text-gray-600">(11) 9999-9999</p>
                    </div>
                </div>
                
                <div class="flex items-start">
                    <div class="flex-shrink-0 mt-1">
                        <i class="fas fa-envelope text-primary"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-gray-700 font-medium">Email</p>
                        <p class="text-gray-600">contato@ecommerce.com</p>
                    </div>
                </div>
                
                <div class="flex items-start">
                    <div class="flex-shrink-0 mt-1">
                        <i class="fas fa-clock text-primary"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-gray-700 font-medium">Horário de Atendimento</p>
                        <p class="text-gray-600">Segunda a Sexta: 9h às 18h</p>
                        <p class="text-gray-600">Sábado: 9h às 13h</p>
                    </div>
                </div>
            </div>
            
            <div class="mt-6">
                <h3 class="text-lg font-medium text-gray-800 mb-3">Redes Sociais</h3>
                <div class="flex space-x-4">
                    <a href="#" class="text-primary hover:text-secondary">
                        <i class="fab fa-facebook-f text-xl"></i>
                    </a>
                    <a href="#" class="text-primary hover:text-secondary">
                        <i class="fab fa-instagram text-xl"></i>
                    </a>
                    <a href="#" class="text-primary hover:text-secondary">
                        <i class="fab fa-twitter text-xl"></i>
                    </a>
                    <a href="#" class="text-primary hover:text-secondary">
                        <i class="fab fa-linkedin-in text-xl"></i>
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
    
    <?php
    // Clear session data after displaying
    if (isset($_SESSION['contact_errors'])) {
        unset($_SESSION['contact_errors']);
    }
    if (isset($_SESSION['contact_data'])) {
        unset($_SESSION['contact_data']);
    }
    ?>
</body>
</html>