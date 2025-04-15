<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Pedidos - Admin Dashboard</title>
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
                        <a href="index.php?c=admin&a=dashboard" class="flex items-center px-4 py-3 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-primary rounded-md">
                            <i class="fas fa-tachometer-alt mr-3"></i>
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
                        <a href="index.php?c=admin&a=orders" class="sidebar-active flex items-center px-4 py-3 text-sm font-medium rounded-md">
                            <i class="fas fa-shopping-cart mr-3 text-primary"></i>
                            Pedidos
                        </a>
                        <a href="index.php?c=admin&a=users" class="flex items-center px-4 py-3 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-primary rounded-md">
                            <i class="fas fa-users mr-3"></i>
                            Usuários
                        </a>
                        <a href="index.php?c=admin&a=settings" class="flex items-center px-4 py-3 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-primary rounded-md">
                            <i class="fas fa-cog mr-3"></i>
                            Configurações
                        </a>
                    </nav>
                    <div class="p-4 border-t">
                        <a href="index.php?c=auth&a=logout" class="flex items-center text-sm font-medium text-red-500 hover:text-red-700">
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
                        <h1 class="ml-3 md:ml-0 text-lg font-semibold text-gray-700">Gerenciar Pedidos</h1>
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
                <!-- Filters and search -->
                <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                    <form action="index.php" method="GET" class="space-y-4">
                        <input type="hidden" name="c" value="admin">
                        <input type="hidden" name="a" value="orders">
                        
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                <select id="status" name="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary/50">
                                    <option value="">Todos</option>
                                    <option value="pendente" <?php echo isset($_GET['status']) && $_GET['status'] == 'pendente' ? 'selected' : ''; ?>>Pendente</option>
                                    <option value="pago" <?php echo isset($_GET['status']) && $_GET['status'] == 'pago' ? 'selected' : ''; ?>>Pago</option>
                                    <option value="enviado" <?php echo isset($_GET['status']) && $_GET['status'] == 'enviado' ? 'selected' : ''; ?>>Enviado</option>
                                    <option value="entregue" <?php echo isset($_GET['status']) && $_GET['status'] == 'entregue' ? 'selected' : ''; ?>>Entregue</option>
                                    <option value="cancelado" <?php echo isset($_GET['status']) && $_GET['status'] == 'cancelado' ? 'selected' : ''; ?>>Cancelado</option>
                                </select>
                            </div>
                            
                            <div>
                                <label for="date_from" class="block text-sm font-medium text-gray-700 mb-1">Data Inicial</label>
                                <input type="date" id="date_from" name="date_from" value="<?php echo $_GET['date_from'] ?? ''; ?>" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary/50">
                            </div>
                            
                            <div>
                                <label for="date_to" class="block text-sm font-medium text-gray-700 mb-1">Data Final</label>
                                <input type="date" id="date_to" name="date_to" value="<?php echo $_GET['date_to'] ?? ''; ?>" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary/50">
                            </div>
                            
                            <div>
                                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Buscar</label>
                                <div class="relative">
                                    <input type="text" id="search" name="search" placeholder="ID, cliente ou email" value="<?php echo $_GET['search'] ?? ''; ?>" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary/50 pl-10">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-search text-gray-400"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex justify-end">
                            <button type="submit" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-primary/90 transition-colors">
                                <i class="fas fa-filter mr-2"></i>Filtrar
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Orders table -->
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b">
                        <h2 class="text-lg font-semibold text-gray-700">Pedidos</h2>
                    </div>
                    
                    <?php if (isset($pedidos) && !empty($pedidos)): ?>
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
                                                    <a href="index.php?c=admin&a=viewOrder&id=<?php echo $pedido['id']; ?>" class="text-indigo-600 hover:text-indigo-900" title="Ver detalhes">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <div class="relative" x-data="{ open: false }">
                                                        <button @click="open = !open" class="text-green-600 hover:text-green-900" title="Atualizar status">
                                                            <i class="fas fa-sync-alt"></i>
                                                        </button>
                                                        <div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-10">
                                                            <div class="py-1" role="menu" aria-orientation="vertical">
                                                                <a href="index.php?c=admin&a=updateOrderStatus&id=<?php echo $pedido['id']; ?>&status=pendente" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Pendente</a>
                                                                <a href="index.php?c=admin&a=updateOrderStatus&id=<?php echo $pedido['id']; ?>&status=pago" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Pago</a>
                                                                <a href="index.php?c=admin&a=updateOrderStatus&id=<?php echo $pedido['id']; ?>&status=enviado" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Enviado</a>
                                                                <a href="index.php?c=admin&a=updateOrderStatus&id=<?php echo $pedido['id']; ?>&status=entregue" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Entregue</a>
                                                                <a href="index.php?c=admin&a=updateOrderStatus&id=<?php echo $pedido['id']; ?>&status=cancelado" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Cancelado</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <a href="index.php?c=admin&a=printOrder&id=<?php echo $pedido['id']; ?>" class="text-gray-600 hover:text-gray-900" title="Imprimir" target="_blank">
                                                        <i class="fas fa-print"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <?php if (isset($totalPages) && $totalPages > 1): ?>
                            <div class="px-6 py-4 border-t">
                                <div class="flex justify-between items-center">
                                    <div class="text-sm text-gray-500">
                                        Mostrando <span class="font-medium"><?php echo $currentPage; ?></span> de <span class="font-medium"><?php echo $totalPages; ?></span> páginas
                                    </div>
                                    <div class="flex space-x-1">
                                        <?php if ($currentPage > 1): ?>
                                            <a href="index.php?c=admin&a=orders&page=<?php echo $currentPage - 1; ?><?php echo isset($_GET['status']) ? '&status=' . $_GET['status'] : ''; ?><?php echo isset($_GET['search']) ? '&search=' . $_GET['search'] : ''; ?>" class="px-3 py-1 rounded-md bg-gray-100 text-gray-700 hover:bg-gray-200">
                                                <i class="fas fa-chevron-left"></i>
                                            </a>
                                        <?php endif; ?>
                                        
                                        <?php for ($i = max(1, $currentPage - 2); $i <= min($totalPages, $currentPage + 2); $i++): ?>
                                            <a href="index.php?c=admin&a=orders&page=<?php echo $i; ?><?php echo isset($_GET['status']) ? '&status=' . $_GET['status'] : ''; ?><?php echo isset($_GET['search']) ? '&search=' . $_GET['search'] : ''; ?>" class="px-3 py-1 rounded-md <?php echo $i == $currentPage ? 'bg-primary text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'; ?>">
                                                <?php echo $i; ?>
                                            </a>
                                        <?php endfor; ?>
                                        
                                        <?php if ($currentPage < $totalPages): ?>
                                            <a href="index.php?c=admin&a=orders&page=<?php echo $currentPage + 1; ?><?php echo isset($_GET['status']) ? '&status=' . $_GET['status'] : ''; ?><?php echo isset($_GET['search']) ? '&search=' . $_GET['search'] : ''; ?>" class="px-3 py-1 rounded-md bg-gray-100 text-gray-700 hover:bg-gray-200">
                                                <i class="fas fa-chevron-right"></i>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="px-6 py-12 text-center">
                            <div class="text-gray-500 mb-4">
                                <i class="fas fa-shopping-cart text-5xl"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Nenhum pedido encontrado</h3>
                            <p class="text-gray-500">Não há pedidos que correspondam aos critérios de busca.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </main>
        </div>
    </div>

    <!-- Alpine.js for dropdown functionality -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>
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