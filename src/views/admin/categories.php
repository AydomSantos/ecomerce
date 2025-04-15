<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Categorias - Painel Administrativo</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        pre {
            display: none;
        }
        .text-primary { color: #3b82f6; }
        .bg-primary { background-color: #3b82f6; }
        .border-primary { border-color: #3b82f6; }
        .hover\:bg-primary\/90:hover { background-color: rgba(59, 130, 246, 0.9); }
        .focus\:border-primary:focus { border-color: #3b82f6; }
        .focus\:ring-primary:focus { --tw-ring-color: #3b82f6; }
        .focus\:ring-primary\/50:focus { --tw-ring-color: rgba(59, 130, 246, 0.5); }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div class="hidden md:flex md:flex-shrink-0">
            <div class="flex flex-col w-64">
                <div class="flex flex-col h-0 flex-1 bg-gray-800">
                    <div class="flex-1 flex flex-col pt-5 pb-4 overflow-y-auto">
                        <div class="flex items-center flex-shrink-0 px-4">
                            <span class="text-white text-xl font-bold">Admin Panel</span>
                        </div>
                        <nav class="mt-5 flex-1 px-2 space-y-1">
                            <a href="index.php?c=admin&a=dashboard" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-300 hover:bg-gray-700 hover:text-white">
                                <i class="fas fa-tachometer-alt mr-3 text-gray-400"></i>
                                Dashboard
                            </a>
                            <a href="index.php?c=admin&a=products" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-300 hover:bg-gray-700 hover:text-white">
                                <i class="fas fa-box mr-3 text-gray-400"></i>
                                Produtos
                            </a>
                            <a href="index.php?c=admin&a=categories" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md bg-gray-700 text-white">
                                <i class="fas fa-tags mr-3 text-gray-400"></i>
                                Categorias
                            </a>
                            <a href="index.php?c=admin&a=orders" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-300 hover:bg-gray-700 hover:text-white">
                                <i class="fas fa-shopping-cart mr-3 text-gray-400"></i>
                                Pedidos
                            </a>
                            <a href="index.php?c=admin&a=customers" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-300 hover:bg-gray-700 hover:text-white">
                                <i class="fas fa-users mr-3 text-gray-400"></i>
                                Clientes
                            </a>
                            <a href="index.php?c=admin&a=settings" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-300 hover:bg-gray-700 hover:text-white">
                                <i class="fas fa-cog mr-3 text-gray-400"></i>
                                Configurações
                            </a>
                        </nav>
                    </div>
                    <div class="flex-shrink-0 flex border-t border-gray-700 p-4">
                        <a href="index.php?c=auth&a=logout" class="flex-shrink-0 group block">
                            <div class="flex items-center">
                                <div>
                                    <i class="fas fa-user-circle text-gray-400 text-2xl"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-300 group-hover:text-white">
                                        Sair
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Main content -->
        <div class="flex flex-col w-0 flex-1 overflow-hidden">
            <div class="md:hidden pl-1 pt-1 sm:pl-3 sm:pt-3">
                <button id="sidebarToggle" class="-ml-0.5 -mt-0.5 h-12 w-12 inline-flex items-center justify-center rounded-md text-gray-500 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary">
                    <span class="sr-only">Open sidebar</span>
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
            
            <main class="flex-1 relative z-0 overflow-y-auto focus:outline-none">
                <div class="py-6">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8 flex justify-between items-center">
                        <h1 class="text-2xl font-semibold text-gray-900">Gerenciar Categorias</h1>
                        <a href="index.php?c=admin&a=addCategory" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                            <i class="fas fa-plus mr-2"></i> Nova Categoria
                        </a>
                    </div>
                    
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8 mt-4">
                        <?php if (isset($_GET['success'])): ?>
                            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                                <p>Categoria salva com sucesso!</p>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (isset($_GET['deleted'])): ?>
                            <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mb-6" role="alert">
                                <p>Categoria excluída com sucesso!</p>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (isset($_GET['error'])): ?>
                            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                                <p>Ocorreu um erro. Por favor, tente novamente.</p>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Search and filter -->
                        <div class="bg-white shadow rounded-lg p-4 mb-6">
                            <form action="index.php" method="get" class="flex flex-col md:flex-row gap-4">
                                <input type="hidden" name="c" value="admin">
                                <input type="hidden" name="a" value="categories">
                                
                                <div class="flex-1">
                                    <label for="search" class="sr-only">Buscar</label>
                                    <div class="relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-search text-gray-400"></i>
                                        </div>
                                        <input type="text" name="search" id="search" value="<?php echo htmlspecialchars($search ?? ''); ?>" class="focus:ring-primary focus:border-primary block w-full pl-10 sm:text-sm border-gray-300 rounded-md" placeholder="Buscar categorias...">
                                    </div>
                                </div>
                                
                                <div>
                                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                        <i class="fas fa-search mr-2"></i> Buscar
                                    </button>
                                </div>
                            </form>
                        </div>
                        
                        <!-- Categories table -->
                        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Imagem</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                                    </tr>
                                </thead>
                                <!-- Inside the table body section -->
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <?php if (empty($categorias)): ?>
                                        <tr>
                                            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                                Nenhuma categoria encontrada.
                                            </td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($categorias as $categoria): ?>
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    <?php echo $categoria['i_id_categorias']; ?>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <?php if (!empty($categoria['s_imagem_categorias'])): ?>
                                                        <img src="<?php echo $categoria['s_imagem_categorias']; ?>" alt="<?php echo htmlspecialchars($categoria['s_nome_categorias']); ?>" class="h-10 w-10 rounded-full object-cover">
                                                    <?php else: ?>
                                                        <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                                            <i class="fas fa-tag text-gray-400"></i>
                                                        </div>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    <?php echo htmlspecialchars($categoria['s_nome_categorias']); ?>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    <?php if ($categoria['i_ativo_categorias']): ?>
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                            Ativo
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                            Inativo
                                                        </span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                    <a href="index.php?c=admin&a=editCategory&id=<?php echo $categoria['i_id_categorias']; ?>" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                                        <i class="fas fa-edit"></i> Editar
                                                    </a>
                                                    <a href="index.php?c=admin&a=deleteCategory&id=<?php echo $categoria['i_id_categorias']; ?>" class="text-red-600 hover:text-red-900" onclick="return confirm('Tem certeza que deseja excluir esta categoria?');">
                                                        <i class="fas fa-trash"></i> Excluir
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <?php if ($totalPages > 1): ?>
                            <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6 mt-4 rounded-lg shadow">
                                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                                    <div>
                                        <p class="text-sm text-gray-700">
                                            Mostrando <span class="font-medium"><?php echo ($currentPage - 1) * $perPage + 1; ?></span> a 
                                            <span class="font-medium"><?php echo min($currentPage * $perPage, $totalItems); ?></span> de 
                                            <span class="font-medium"><?php echo $totalItems; ?></span> resultados
                                        </p>
                                    </div>
                                    <div>
                                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                                            <?php if ($currentPage > 1): ?>
                                                <a href="index.php?c=admin&a=categories&page=<?php echo $currentPage - 1; ?>&search=<?php echo urlencode($search); ?>" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                                    <span class="sr-only">Anterior</span>
                                                    <i class="fas fa-chevron-left"></i>
                                                </a>
                                            <?php endif; ?>
                                            
                                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                                <a href="index.php?c=admin&a=categories&page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium <?php echo $i === $currentPage ? 'text-primary bg-primary/10' : 'text-gray-700 hover:bg-gray-50'; ?>">
                                                    <?php echo $i; ?>
                                                </a>
                                            <?php endfor; ?>
                                            
                                            <?php if ($currentPage < $totalPages): ?>
                                                <a href="index.php?c=admin&a=categories&page=<?php echo $currentPage + 1; ?>&search=<?php echo urlencode($search); ?>" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                                    <span class="sr-only">Próximo</span>
                                                    <i class="fas fa-chevron-right"></i>
                                                </a>
                                            <?php endif; ?>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </main>
        </div>
    </div>
    
    <script>
        function confirmDelete(id) {
            if (confirm('Tem certeza que deseja excluir esta categoria? Esta ação não pode ser desfeita.')) {
                window.location.href = 'index.php?c=admin&a=deleteCategory&id=' + id;
            }
        }
        
        document.getElementById('sidebarToggle')?.addEventListener('click', function() {
            const sidebar = document.querySelector('.md\\:flex-shrink-0');
            sidebar.classList.toggle('hidden');
            sidebar.classList.toggle('md:flex');
        });
    </script>
</body>
</html>