<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - E-commerce</title>
    <style>

    pre{
        display: none;
    }

    </style>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-blue-100 to-blue-300 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md mx-auto bg-white rounded-xl shadow-lg p-8">
        <div class="mb-6 text-center">
            <h1 class="text-3xl font-bold text-blue-700">Painel Administrativo</h1>
            <p class="text-gray-500 mt-2">Acesse sua conta de administrador</p>
        </div>
        <?php if (isset($_SESSION['admin_login_error'])): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                <p><?php echo $_SESSION['admin_login_error']; ?></p>
                <?php unset($_SESSION['admin_login_error']); ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="index.php?c=admin&a=authenticate" class="space-y-5">
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" required
                    class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400 focus:border-blue-400 outline-none transition">
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Senha</label>
                <input type="password" name="password" id="password" required
                    class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400 focus:border-blue-400 outline-none transition">
            </div>
            <div class="flex items-center">
                <input type="checkbox" name="remember_me" id="remember_me" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                <label for="remember_me" class="ml-2 block text-sm text-gray-900">Lembrar-me</label>
            </div>
            <button type="submit"
                class="w-full py-2 px-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-md shadow transition">
                Entrar
            </button>
        </form>
        <div class="mt-6 text-center">
            <a href="index.php" class="text-sm text-blue-600 hover:underline">← Voltar para o site</a>
        </div>
    </div>
</body>
</html>