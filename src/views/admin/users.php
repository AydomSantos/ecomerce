<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        pre{
            display: none;
        }

    </style>
    <title>Gerenciar Usuários</title>
    <!-- Tailwind CSS - Production Version -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body class="bg-gray-50 text-gray-800">
    <div class="max-w-7xl mx-auto px-4 py-8">
        <header class="mb-8">
            <h1 class="text-4xl font-bold text-primary mb-2">Usuários</h1>
            <div class="flex items-center text-sm text-gray-500">
                <a href="index.php" class="hover:text-primary transition-colors">Home</a>
                <span class="mx-2">/</span>
                <span>Usuários</span>
            </div>
        </header>

        <div class="bg-white rounded-lg shadow-sm p-5 mb-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-semibold">Lista de Usuários</h2>
                <a href="index.php?c=admin&a=addUser" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-primary/90 transition-colors">
                    <i class="fas fa-user-plus"></i> Adicionar Usuário
                </a>
            </div>

            <!-- User table -->
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b border-gray-200 text-left text-sm font-semibold text-gray-600">ID</th>
                        <th class="py-2 px-4 border-b border-gray-200 text-left text-sm font-semibold text-gray-600">Nome</th>
                        <th class="py-2 px-4 border-b border-gray-200 text-left text-sm font-semibold text-gray-600">Email</th>
                        <th class="py-2 px-4 border-b border-gray-200 text-left text-sm font-semibold text-gray-600">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($usuarios) && is_array($usuarios)): ?>
                        <?php foreach ($usuarios as $usuario): ?>
                            <tr>
                                <td class="py-2 px-4 border-b border-gray-200"><?php echo $usuario['id'] ?? 'N/A'; ?></td>
                                <td class="py-2 px-4 border-b border-gray-200"><?php echo $usuario['nome'] ?? 'N/A'; ?></td>
                                <td class="py-2 px-4 border-b border-gray-200"><?php echo $usuario['email'] ?? 'N/A'; ?></td>
                                <td class="py-2 px-4 border-b border-gray-200">
                                    <a href="index.php?c=admin&a=editUser&id=<?php echo $usuario['id'] ?? ''; ?>" class="text-primary hover:text-primary/90 transition-colors">
                                        <i class="fas fa-edit"></i> Editar
                                    </a>
                                    <a href="index.php?c=admin&a=deleteUser&id=<?php echo $usuario['id'] ?? ''; ?>" class="text-red-600 hover:text-red-800 transition-colors ml-2">
                                        <i class="fas fa-trash"></i> Excluir
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="py-2 px-4 border-b border-gray-200 text-center text-gray-600">Nenhum usuário encontrado.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>