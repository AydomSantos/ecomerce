<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - E-commerce</title>
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
        
        /* Sidebar active state */
        .sidebar-active {
            background-color: rgba(59, 130, 246, 0.1);
            border-left: 3px solid #3b82f6;
            color: #3b82f6;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div class="hidden md:flex md:flex-shrink-0">
            <div class="flex flex-col w-64 bg-white border-r">
                <div class="flex items-center justify-center h-16 bg-primary">
                    <span class="text-white text-lg font-bold">E-commerce Admin</span>
                </div>
                <div class="flex flex-col flex-grow overflow-y-auto">
                    <nav class="flex-1 px-2 py-4 space-y-1">
                        <a href="index.php?c=admin&a=dashboard" class="sidebar-active flex items-center px-4 py-3 text-sm font-medium rounded-md">
                            <i class="fas fa-tachometer-alt mr-3 text-primary"></i>
                            Dashboard
                        </a>
                        <a href="index.php?c=admin&a=products" class="flex items-center px-4 py-3 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-primary rounded-md">
                            <i class="fas fa-box mr-3"></i>
                            Produtos
                        </a>
                        <a href="index.php?c=admin&a=categories" class="flex items-center px-4 py-3 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-primary rounded-md">
                            <i class="fas fa-tags mr-3"></i>
                            Categorias
                        </a>
                        <a href="index.php?c=admin&a=orders" class="flex items-center px-4 py-3 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-primary rounded-md">
                            <i class="fas fa-shopping-cart mr-3"></i>
                            Pedidos
                        </a>
                        <a href="index.php?c=admin&a=users" class="flex items-center px-4 py-3 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-primary rounded-md">
                            <i class="fas fa-users mr-3"></i>
                            Usuários
                        </a>
                        <!-- Update this link -->
                        <a href="index.php?c=admin&a=configurations" class="flex items-center px-4 py-3 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-primary rounded-md">
                            <i class="fas fa-cog mr-3"></i>
                            Configurações
                        </a>
                    </nav>
                    <div class="p-4 border-t">
                        <a href="index.php?c=admin&a=logout" class="flex items-center text-sm font-medium text-red-500 hover:text-red-700">
                            <i class="fas fa-sign-out-alt mr-3"></i>
                            Sair
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <div class="flex flex-col flex-1 overflow-hidden">
            <!-- Top navbar -->
            <header class="bg-white shadow-sm">
                <div class="flex items-center justify-between px-6 py-3">
                    <div class="flex items-center">
                        <button class="md:hidden text-gray-500 focus:outline-none" id="sidebarToggle">
                            <i class="fas fa-bars"></i>
                        </button>
                        <h1 class="ml-3 md:ml-0 text-lg font-semibold text-gray-700">Dashboard</h1>
                    </div>
                    <div class="flex items-center">
                        <div class="relative">
                            <button class="flex items-center text-gray-500 hover:text-gray-700 focus:outline-none">
                                <span class="mr-2 text-sm">Admin</span>
                                <img class="h-8 w-8 rounded-full object-cover" src="https://ui-avatars.com/api/?name=Admin&background=3b82f6&color=fff" alt="Avatar">
                            </button>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main content area -->
            <main class="flex-1 overflow-y-auto p-6">
                <!-- Dashboard overview -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-100 text-primary">
                                <i class="fas fa-shopping-bag text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Total de Produtos</p>
                                <p class="text-2xl font-semibold text-gray-700"><?php echo $totalProdutos ?? 0; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-100 text-green-600">
                                <i class="fas fa-chart-line text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Vendas do Mês</p>
                                <p class="text-2xl font-semibold text-gray-700">R$ <?php echo number_format($vendasMes ?? 0, 2, ',', '.'); ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                                <i class="fas fa-users text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Total de Usuários</p>
                                <p class="text-2xl font-semibold text-gray-700"><?php echo $totalUsuarios ?? 0; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                                <i class="fas fa-shopping-cart text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Pedidos Pendentes</p>
                                <p class="text-2xl font-semibold text-gray-700"><?php echo $pedidosPendentes ?? 0; ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent products -->
                <div class="bg-white rounded-lg shadow-sm mb-8">
                    <div class="flex items-center justify-between px-6 py-4 border-b">
                        <h2 class="text-lg font-semibold text-gray-700">Produtos Recentes</h2>
                        <a href="index.php?c=admin&a=products" class="text-sm text-primary hover:underline">Ver todos</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produto</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categoria</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Preço</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estoque</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php if (isset($produtos) && is_array($produtos)): ?>
                                    <?php foreach ($produtos as $produto): ?>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo $produto['i_id_produtos']; ?></td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="h-10 w-10 flex-shrink-0">
                                                        <?php if (!empty($produto['s_imagem_produtos'])): ?>
                                                            <img class="h-10 w-10 rounded-full object-cover" src="<?php echo $produto['s_imagem_produtos']; ?>" alt="<?php echo $produto['s_nome_produtos']; ?>">
                                                        <?php else: ?>
                                                            <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                                                <i class="fas fa-box text-gray-400"></i>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900"><?php echo $produto['s_nome_produtos']; ?></div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo $produto['s_nome_categorias'] ?? 'Sem categoria'; ?></td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">R$ <?php echo number_format($produto['d_preco_produtos'], 2, ',', '.'); ?></td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <?php if (isset($produto['i_estoque']) && $produto['i_estoque'] > 10): ?>
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                        <?php echo $produto['i_estoque']; ?> unidades
                                                    </span>
                                                <?php elseif (isset($produto['i_estoque']) && $produto['i_estoque'] > 0): ?>
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                        <?php echo $produto['i_estoque']; ?> unidades
                                                    </span>
                                                <?php else: ?>
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                        Esgotado
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex space-x-2">
                                                    <a href="index.php?c=admin&a=editProduct&id=<?php echo $produto['i_id_produtos']; ?>" class="text-indigo-600 hover:text-indigo-900">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="index.php?c=admin&a=deleteProduct&id=<?php echo $produto['i_id_produtos']; ?>" class="text-red-600 hover:text-red-900" onclick="return confirm('Tem certeza que deseja excluir este produto?')">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">Nenhum produto encontrado</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Recent orders -->
                <div class="bg-white rounded-lg shadow-sm">
                    <div class="flex items-center justify-between px-6 py-4 border-b">
                        <h2 class="text-lg font-semibold text-gray-700">Pedidos Recentes</h2>
                        <a href="index.php?c=admin&a=orders" class="text-sm text-primary hover:underline">Ver todos</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cliente</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php if (isset($pedidos) && is_array($pedidos)): ?>
                                    <?php foreach ($pedidos as $pedido): ?>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">#<?php echo $pedido['id']; ?></td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900"><?php echo $pedido['nome_cliente']; ?></div>
                                                <div class="text-sm text-gray-500"><?php echo $pedido['email_cliente']; ?></div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo date('d/m/Y H:i', strtotime($pedido['data'])); ?></td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">R$ <?php echo number_format($pedido['total'], 2, ',', '.'); ?></td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <?php if ($pedido['status'] == 'pendente'): ?>
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                        Pendente
                                                    </span>
                                                <?php elseif ($pedido['status'] == 'pago'): ?>
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                        Pago
                                                    </span>
                                                <?php elseif ($pedido['status'] == 'enviado'): ?>
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                        Enviado
                                                    </span>
                                                <?php elseif ($pedido['status'] == 'entregue'): ?>
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                                        Entregue
                                                    </span>
                                                <?php elseif ($pedido['status'] == 'cancelado'): ?>
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                        Cancelado
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex space-x-2">
                                                    <a href="index.php?c=admin&a=viewOrder&id=<?php echo $pedido['id']; ?>" class="text-indigo-600 hover:text-indigo-900">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="index.php?c=admin&a=updateOrderStatus&id=<?php echo $pedido['id']; ?>" class="text-green-600 hover:text-green-900">
                                                        <i class="fas fa-sync-alt"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">Nenhum pedido encontrado</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        // Toggle sidebar on mobile
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            const sidebar = document.querySelector('.md\\:flex-shrink-0');
            sidebar.classList.toggle('hidden');
            sidebar.classList.toggle('block');
        });
    </script>
</body>
</html>