<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Produtos - Admin Dashboard</title>
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        pre{
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
                        <a href="index.php?c=admin&a=products" class="sidebar-active flex items-center px-4 py-3 text-sm font-medium rounded-md">
                            <i class="fas fa-box mr-3 text-primary"></i>
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
                        <h1 class="ml-3 md:ml-0 text-lg font-semibold text-gray-700">Gerenciar Produtos</h1>
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
                <!-- Action buttons -->
                <div class="mb-6 flex justify-between items-center">
                    <div class="flex space-x-2">
                        <a href="index.php?c=admin&a=addProduct" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-primary/90 transition-colors">
                            <i class="fas fa-plus mr-2"></i>Adicionar Produto
                        </a>
                        <a href="index.php?c=admin&a=categories" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition-colors">
                            <i class="fas fa-tags mr-2"></i>Gerenciar Categorias
                        </a>
                    </div>
                    <div>
                        <form action="index.php" method="GET" class="flex">
                            <input type="hidden" name="c" value="admin">
                            <input type="hidden" name="a" value="products">
                            <div class="relative">
                                <input type="text" name="search" placeholder="Buscar produtos..." value="<?php echo $_GET['search'] ?? ''; ?>" class="w-64 rounded-l-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary/50 pl-10">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                            </div>
                            <button type="submit" class="bg-primary text-white px-4 py-2 rounded-r-md hover:bg-primary/90 transition-colors">
                                Buscar
                            </button>
                        </form>
                    </div>
                </div>
                
                <!-- Products table -->
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b flex justify-between items-center">
                        <h2 class="text-lg font-semibold text-gray-700">Lista de Produtos</h2>
                        <div class="text-sm text-gray-500">
                            Total: <span class="font-medium"><?php echo count($produtos ?? []); ?></span> produtos
                        </div>
                    </div>
                    
                    <?php if (isset($produtos) && !empty($produtos)): ?>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produto</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categoria</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Preço</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estoque</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
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
                                                        <div class="text-xs text-gray-500 truncate max-w-xs"><?php echo substr($produto['t_descricao_produtos'] ?? '', 0, 50); ?><?php echo strlen($produto['t_descricao_produtos'] ?? '') > 50 ? '...' : ''; ?></div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo $produto['s_nome_categorias'] ?? 'Sem categoria'; ?></td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">R$ <?php echo number_format($produto['d_preco_produtos'], 2, ',', '.'); ?></td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo $produto['i_estoque_produtos'] ?? 0; ?></td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <?php if (isset($produto['i_estoque_produtos']) && $produto['i_estoque_produtos'] > 10): ?>
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                        Em estoque
                                                    </span>
                                                <?php elseif (isset($produto['i_estoque_produtos']) && $produto['i_estoque_produtos'] > 0): ?>
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                        Estoque baixo
                                                    </span>
                                                <?php else: ?>
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                        Esgotado
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex space-x-2">
                                                    <a href="index.php?c=admin&a=editProduct&id=<?php echo $produto['i_id_produtos']; ?>" class="text-indigo-600 hover:text-indigo-900" title="Editar">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="index.php?c=admin&a=deleteProduct&id=<?php echo $produto['i_id_produtos']; ?>" class="text-red-600 hover:text-red-900" title="Excluir" onclick="return confirm('Tem certeza que deseja excluir este produto?')">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                    <a href="index.php?c=admin&a=duplicateProduct&id=<?php echo $produto['i_id_produtos']; ?>" class="text-green-600 hover:text-green-900" title="Duplicar">
                                                        <i class="fas fa-copy"></i>
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
                                            <a href="index.php?c=admin&a=products&page=<?php echo $currentPage - 1; ?><?php echo isset($_GET['search']) ? '&search=' . $_GET['search'] : ''; ?>" class="px-3 py-1 rounded-md bg-gray-100 text-gray-700 hover:bg-gray-200">
                                                <i class="fas fa-chevron-left"></i>
                                            </a>
                                        <?php endif; ?>
                                        
                                        <?php for ($i = max(1, $currentPage - 2); $i <= min($totalPages, $currentPage + 2); $i++): ?>
                                            <a href="index.php?c=admin&a=products&page=<?php echo $i; ?><?php echo isset($_GET['search']) ? '&search=' . $_GET['search'] : ''; ?>" class="px-3 py-1 rounded-md <?php echo $i == $currentPage ? 'bg-primary text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'; ?>">
                                                <?php echo $i; ?>
                                            </a>
                                        <?php endfor; ?>
                                        
                                        <?php if ($currentPage < $totalPages): ?>
                                            <a href="index.php?c=admin&a=products&page=<?php echo $currentPage + 1; ?><?php echo isset($_GET['search']) ? '&search=' . $_GET['search'] : ''; ?>" class="px-3 py-1 rounded-md bg-gray-100 text-gray-700 hover:bg-gray-200">
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
                                <i class="fas fa-box-open text-5xl"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Nenhum produto encontrado</h3>
                            <p class="text-gray-500 mb-6">Comece adicionando seu primeiro produto ou tente uma busca diferente.</p>
                            <a href="index.php?c=admin&a=addProduct" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-primary/90 transition-colors">
                                <i class="fas fa-plus mr-2"></i>Adicionar Produto
                            </a>
                        </div>
                    <?php endif; ?>
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