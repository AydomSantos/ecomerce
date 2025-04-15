

<?php foreach ($categorias as $categoria): ?>
    <option value="<?= $categoria['id'] ?>"><?= $categoria['s_nome_categorias'] ?></option>
<?php endforeach; ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listagem de Produtos</title>
    <!-- Tailwind CSS - Production Version -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* Hide debug messages */
        pre {
            display: none;
        }
        .php-error {
        display: none;
        }
        
        /* Custom colors to replace Tailwind config */
        .bg-primary {
            background-color: #3b82f6;
        }
        .text-primary {
            color: #3b82f6;
        }
        .border-primary {
            border-color: #3b82f6;
        }
        .hover\:bg-primary:hover {
            background-color: #3b82f6;
        }
        .hover\:text-primary:hover {
            color: #3b82f6;
        }
        .focus\:ring-primary\/50:focus {
            --tw-ring-color: rgba(59, 130, 246, 0.5);
        }
        .bg-success {
            background-color: #10b981;
        }
        .hover\:bg-primary\/90:hover {
            background-color: rgba(59, 130, 246, 0.9);
        }
        .hover\:bg-success\/90:hover {
            background-color: rgba(16, 185, 129, 0.9);
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">
    <div class="max-w-7xl mx-auto px-4 py-8">
        <header class="mb-8">
            <h1 class="text-4xl font-bold text-primary mb-2">Produtos</h1>
            <div class="flex items-center text-sm text-gray-500">
                <a href="index.php" class="hover:text-primary transition-colors">Home</a>
                <span class="mx-2">/</span>
                <span>Produtos</span>
            </div>
        </header>

        <div class="flex flex-col md:flex-row gap-6">
            <!-- Sidebar com filtros -->
            <aside class="w-full md:w-64 flex-shrink-0">
                <div class="bg-white rounded-lg shadow-sm p-5 mb-6">
                    <h5 class="font-semibold text-lg mb-4 pb-2 border-b border-gray-100">Categorias</h5>
                    <ul class="space-y-2">
                        <li>
                            <a href="index.php?c=product&a=list" 
                               class="block py-1.5 <?php echo !isset($_GET['categorias']) ? 'text-primary font-medium' : 'text-gray-600 hover:text-primary'; ?> transition-colors">
                                Todas as Categorias
                            </a>
                        </li>
                        <?php if (isset($categorias) && is_array($categorias)): ?>
                            <?php foreach ($categorias as $categoria): ?>
                                <li>
                                    <a href="index.php?c=product&a=list&categorias=<?php echo $categoria['i_id_categorias']; ?>" 
                                       class="block py-1.5 <?php echo (isset($_GET['categorias']) && $_GET['categorias'] == $categoria['i_id_categorias']) ? 'text-primary font-medium' : 'text-gray-600 hover:text-primary'; ?> transition-colors">
                                        <?php echo $categoria['s_nome_categorias']; ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-5">
                    <h5 class="font-semibold text-lg mb-4 pb-2 border-b border-gray-100">Preço</h5>
                    <form action="index.php" method="get" id="price-filter">
                        <input type="hidden" name="c" value="product">
                        <input type="hidden" name="a" value="list">
                        <?php if (isset($_GET['categorias'])): ?>
                            <input type="hidden" name="categorias" value="<?php echo $_GET['categorias']; ?>">
                        <?php endif; ?>
                        
                        <div class="space-y-4">
                            <div class="grid grid-cols-5 gap-2 items-center">
                                <input type="number" name="min_price" class="col-span-2 w-full px-3 py-2 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-primary/50" placeholder="Mín" 
                                       value="<?php echo isset($_GET['min_price']) ? $_GET['min_price'] : ''; ?>">
                                <div class="text-center">até</div>
                                <input type="number" name="max_price" class="col-span-2 w-full px-3 py-2 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-primary/50" placeholder="Máx"
                                       value="<?php echo isset($_GET['max_price']) ? $_GET['max_price'] : ''; ?>">
                            </div>
                            <button type="submit" class="w-full bg-primary hover:bg-primary/90 text-white py-2 px-4 rounded-md transition-colors">
                                Filtrar
                            </button>
                        </div>
                    </form>
                </div>
            </aside>

            <!-- Conteúdo principal com produtos -->
            <main class="flex-1">
                <div class="bg-white rounded-lg shadow-sm p-5 mb-6">
                    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
                        <div class="w-full md:w-1/2">
                            <form action="index.php" method="get">
                                <input type="hidden" name="c" value="product">
                                <input type="hidden" name="a" value="list">
                                <?php if (isset($_GET['categorias'])): ?>
                                    <input type="hidden" name="categorias" value="<?php echo $_GET['categorias']; ?>">
                                <?php endif; ?>
                                
                                <div class="flex">
                                    <input type="text" name="search" class="flex-1 px-3 py-2 border border-gray-200 rounded-l-md focus:outline-none focus:ring-2 focus:ring-primary/50" placeholder="Buscar produtos..." 
                                           value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                                    <button type="submit" class="bg-primary text-white px-4 py-2 rounded-r-md hover:bg-primary/90 transition-colors">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                        
                        <div class="flex items-center">
                            <label for="sort" class="mr-2 text-gray-600">Ordenar por:</label>
                            <select name="sort" id="sort" class="px-3 py-2 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-primary/50" onchange="updateSort(this.value)">
                                <option value="name_asc" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'name_asc') ? 'selected' : ''; ?>>Nome (A-Z)</option>
                                <option value="name_desc" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'name_desc') ? 'selected' : ''; ?>>Nome (Z-A)</option>
                                <option value="price_asc" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'price_asc') ? 'selected' : ''; ?>>Preço (menor-maior)</option>
                                <option value="price_desc" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'price_desc') ? 'selected' : ''; ?>>Preço (maior-menor)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <?php if (isset($produtos) && is_array($produtos) && count($produtos) > 0): ?>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        <?php foreach ($produtos as $produto): ?>
                            <div class="bg-white rounded-lg shadow-sm overflow-hidden transition-all duration-300 hover:shadow-md hover:-translate-y-1">
                                <div class="relative">
                                    <?php if (!empty($produto['s_imagem_produtos'])): ?>
                                        <img src="<?php echo $produto['s_imagem_produtos']; ?>" class="w-full h-48 object-cover" alt="<?php echo $produto['s_nome_produtos']; ?>">
                                    <?php else: ?>
                                        <?php
                                        // Use online placeholder images instead of local files
                                        $placeholderImages = [
                                            'https://via.placeholder.com/400x300/3b82f6/ffffff?text=Produto',
                                            'https://via.placeholder.com/400x300/10b981/ffffff?text=Produto',
                                            'https://via.placeholder.com/400x300/6366f1/ffffff?text=Produto',
                                            'https://via.placeholder.com/400x300/f59e0b/ffffff?text=Produto',
                                            'https://via.placeholder.com/400x300/ef4444/ffffff?text=Produto'
                                        ];
                                        $imageIndex = isset($produto['i_id_produtos']) ? ($produto['i_id_produtos'] % count($placeholderImages)) : 0;
                                        $placeholderImage = $placeholderImages[$imageIndex];
                                        ?>
                                        <img src="<?php echo $placeholderImage; ?>" class="w-full h-48 object-cover" alt="<?php echo $produto['s_nome_produtos']; ?>">
                                    <?php endif; ?>
                                    <div class="absolute top-3 right-3">
                                        <span class="bg-primary text-white text-sm font-medium px-3 py-1 rounded-full">
                                            R$ <?php echo number_format($produto['d_preco_produtos'], 2, ',', '.'); ?>
                                        </span>
                                    </div>
                                </div>
                                <div class="p-4">
                                    <h3 class="font-semibold text-lg mb-2 text-gray-800"><?php echo $produto['s_nome_produtos']; ?></h3>
                                    <div class="mb-4">
                                        <span class="inline-block bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded">
                                            <?php echo $produto['s_nome_categorias'] ?? 'Sem categoria'; ?>
                                        </span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <!-- In your product cards, change the "Ver detalhes" link from: -->
                                        <a href="index.php?c=product&a=detail&id=<?php echo $produto['i_id_produtos']; ?>" 
                                           class="text-primary border border-primary px-3 py-1.5 rounded text-sm hover:bg-primary hover:text-white transition-colors">
                                            Ver detalhes
                                        </a>
                                        
                                        
                                        <a href="index.php?c=cart&a=add&id=<?php echo $produto['i_id_produtos']; ?>" 
                                           class="bg-success text-white w-9 h-9 flex items-center justify-center rounded-full hover:bg-success/90 transition-colors">
                                            <i class="fas fa-shopping-cart"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded">
                        <p class="text-blue-700">Nenhum produto encontrado.</p>
                        <?php if (isset($_GET['search']) || isset($_GET['categorias']) || isset($_GET['min_price']) || isset($_GET['max_price'])): ?>
                            <p class="text-blue-700 mt-2">
                                Tente ajustar seus filtros ou <a href="index.php?c=product&a=list" class="underline hover:no-underline">ver todos os produtos</a>.
                            </p>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </main>
        </div>
    </div>

    <script>
        function updateSort(sortValue) {
            // Obter a URL atual
            let currentUrl = new URL(window.location.href);
            let searchParams = currentUrl.searchParams;
            
            // Atualizar ou adicionar o parâmetro de ordenação
            searchParams.set('sort', sortValue);
            
            // Redirecionar para a URL atualizada
            window.location.href = currentUrl.toString();
        }
    </script>
</body>
</html>
