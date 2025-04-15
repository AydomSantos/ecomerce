<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - E-commerce</title>
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        pre {
            display: none;
        }
        /* Custom colors */
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
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full mx-4">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-primary">E-commerce Admin</h1>
            <p class="text-gray-600 mt-2">Painel de Administração</p>
        </div>
        
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-primary py-4 px-6">
                <h2 class="text-xl font-semibold text-white">Login Administrativo</h2>
            </div>
            
            <div class="p-6">
                <?php if (isset($_SESSION['admin_login_error'])): ?>
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                        <p><?php echo $_SESSION['admin_login_error']; ?></p>
                        <?php unset($_SESSION['admin_login_error']); ?>
                    </div>
                <?php endif; ?>
                
                <form method="POST" action="index.php?c=admin&a=authenticate">
                    <!-- Your form fields here -->
                    <input type="email" name="email" required>
                    <input type="password" name="password" required>
                    <input type="checkbox" name="remember_me">
                    <button type="submit">Entrar</button>
                </form>
                
                <div class="mt-6 text-center">
                    <a href="index.php" class="text-sm text-primary hover:text-secondary">
                        <i class="fas fa-arrow-left mr-1"></i> Voltar para o site
                    </a>
                </div>
            </div>
        </div>
        
        <div class="mt-6 text-center text-gray-500 text-sm">
            &copy; 2023 E-commerce. Todos os direitos reservados.
        </div>
    </div>
</body>
</html>