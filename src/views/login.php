<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - E-commerce</title>
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
                <a href="index.php?c=home&a=contact" class="text-gray-600 hover:text-primary">Contato</a>
                <a href="index.php?c=home&a=about" class="text-gray-600 hover:text-primary">Sobre</a>
                <a href="index.php?c=home&a=login" class="text-primary font-medium">Login</a>
                <a href="index.php?c=home&a=register" class="text-gray-600 hover:text-primary">Cadastro</a>
            </nav>
        </div>
    </header>

    <!-- Main content -->
    <main class="max-w-7xl mx-auto px-4 py-12">
        <div class="max-w-md mx-auto bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-primary py-4 px-6">
                <h2 class="text-2xl font-bold text-white">Login</h2>
            </div>
            
            <div class="p-6">
                <?php if (isset($_SESSION['login_error'])): ?>
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                        <p><?php echo $_SESSION['login_error']; ?></p>
                        <?php unset($_SESSION['login_error']); ?>
                    </div>
                <?php endif; ?>
                
                <?php if (isset($_SESSION['register_success'])): ?>
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                        <p><?php echo $_SESSION['register_success']; ?></p>
                        <?php unset($_SESSION['register_success']); ?>
                    </div>
                <?php endif; ?>
                
                <form action="index.php?c=auth&a=login" method="post" class="space-y-6">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-gray-400"></i>
                            </div>
                            <input type="email" id="email" name="email" 
                                   class="pl-10 w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary" 
                                   placeholder="seu@email.com" required>
                        </div>
                    </div>
                    
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Senha</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <input type="password" id="password" name="password" 
                                   class="pl-10 w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary" 
                                   placeholder="********" required>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember_me" name="remember_me" type="checkbox" 
                                   class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                            <label for="remember_me" class="ml-2 block text-sm text-gray-700">
                                Lembrar de mim
                            </label>
                        </div>
                        
                        <div class="text-sm">
                            <a href="index.php?c=auth&a=forgotPassword" class="text-primary hover:text-secondary">
                                Esqueceu a senha?
                            </a>
                        </div>
                    </div>
                    
                    <div>
                        <button type="submit" class="w-full bg-primary text-white py-2 px-4 rounded-md hover:bg-secondary transition duration-300">
                            Entrar
                        </button>
                    </div>
                </form>
                
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        Não tem uma conta? 
                        <a href="index.php?c=home&a=register" class="text-primary hover:text-secondary font-medium">
                            Cadastre-se
                        </a>
                    </p>
                </div>
                
                <div class="mt-6">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-500">Ou continue com</span>
                        </div>
                    </div>
                    
                    <div class="mt-6 grid grid-cols-2 gap-3">
                        <a href="#" class="w-full flex items-center justify-center px-4 py-2 border rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            <i class="fab fa-google text-red-500 mr-2"></i>
                            Google
                        </a>
                        <a href="#" class="w-full flex items-center justify-center px-4 py-2 border rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            <i class="fab fa-facebook text-blue-600 mr-2"></i>
                            Facebook
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white shadow-sm mt-auto">
        <div class="max-w-7xl mx-auto px-4 py-6 text-center">
            <p class="text-gray-600">&copy; 2023 E-commerce. Todos os direitos reservados.</p>
        </div>
    </footer>
</body>
</html>