<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Produto</title>
    <!-- Tailwind CSS - Production Version -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* Hide debug messages */
        pre {
            display: none;
        }
        
        /* Custom colors */
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
            <h1 class="text-4xl font-bold text-primary mb-2">Detalhes do Produto</h1>
            <div class="flex items-center text-sm text-gray-500">
                <a href="index.php" class="hover:text-primary transition-colors">Home</a>
                <span class="mx-2">/</span>
                <a href="index.php?c=product&a=list" class="hover:text-primary transition-colors">Produtos</a>
                <span class="mx-2">/</span>
                <span><?php echo $produto['s_nome_produtos'] ?? 'Produto'; ?></span>
            </div>
        </header>

        <?php if (isset($produto) && !empty($produto)): ?>
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="md:flex">
                    <!-- Imagem do produto -->
                    <div class="md:w-1/2 p-6">
                        <div class="bg-gray-100 rounded-lg overflow-hidden">
                            <?php if (!empty($produto['s_imagem_produtos'])): ?>
                                <img src="<?php echo $produto['s_imagem_produtos']; ?>" class="w-full h-auto object-contain max-h-96 mx-auto" alt="<?php echo $produto['s_nome_produtos']; ?>">
                            <?php else: ?>
                                <img src="https://via.placeholder.com/600x400/3b82f6/ffffff?text=<?php echo urlencode($produto['s_nome_produtos']); ?>" class="w-full h-auto object-contain max-h-96 mx-auto" alt="<?php echo $produto['s_nome_produtos']; ?>">
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Informações do produto -->
                    <div class="md:w-1/2 p-6">
                        <div class="mb-4">
                            <span class="inline-block bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded mb-2">
                                <?php echo $produto['s_nome_categorias'] ?? 'Sem categoria'; ?>
                            </span>
                            <h1 class="text-3xl font-bold text-gray-800 mb-2"><?php echo $produto['s_nome_produtos']; ?></h1>
                            <div class="flex items-center mb-4">
                                <div class="flex text-yellow-400">
                                    <?php 
                                    $rating = isset($produto['i_avaliacao']) ? $produto['i_avaliacao'] : 5;
                                    for ($i = 1; $i <= 5; $i++): 
                                        if ($i <= $rating): ?>
                                            <i class="fas fa-star"></i>
                                        <?php else: ?>
                                            <i class="far fa-star"></i>
                                        <?php endif;
                                    endfor; ?>
                                </div>
                                <span class="text-gray-500 text-sm ml-2">(<?php echo isset($produto['i_avaliacoes_count']) ? $produto['i_avaliacoes_count'] : rand(10, 100); ?> avaliações)</span>
                            </div>
                            <div class="text-3xl font-bold text-primary mb-4">
                                R$ <?php echo number_format($produto['d_preco_produtos'], 2, ',', '.'); ?>
                            </div>
                            <?php if (isset($produto['i_estoque']) && $produto['i_estoque'] > 0): ?>
                                <div class="text-success mb-4">
                                    <i class="fas fa-check-circle mr-1"></i> Em estoque
                                </div>
                            <?php else: ?>
                                <div class="text-red-500 mb-4">
                                    <i class="fas fa-times-circle mr-1"></i> Fora de estoque
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mb-6">
                            <h2 class="text-lg font-semibold mb-2">Descrição</h2>
                            <p class="text-gray-600">
                                <?php echo $produto['s_descricao_produtos'] ?? 'Este produto não possui descrição detalhada.'; ?>
                            </p>
                        </div>
                        
                        <div class="mb-6">
                            <h2 class="text-lg font-semibold mb-2">Quantidade</h2>
                            <div class="flex items-center mb-4">
                                <button class="bg-gray-200 px-3 py-1 rounded-l-md" onclick="decrementQuantity()">-</button>
                                <input type="number" id="quantity" value="1" min="1" max="<?php echo $produto['i_estoque'] ?? 10; ?>" class="w-16 text-center border-y border-gray-200 py-1">
                                <button class="bg-gray-200 px-3 py-1 rounded-r-md" onclick="incrementQuantity()">+</button>
                            </div>
                        </div>
                        
                        <div class="flex flex-wrap gap-3">
                            <a href="index.php?c=cart&a=add&id=<?php echo $produto['i_id_produtos']; ?>" 
                               class="flex-1 bg-primary hover:bg-primary/90 text-white py-3 px-6 rounded-md transition-colors text-center">
                                <i class="fas fa-shopping-cart mr-2"></i> Adicionar ao Carrinho
                            </a>
                            <a href="#" class="bg-gray-200 hover:bg-gray-300 text-gray-700 py-3 px-4 rounded-md transition-colors">
                                <i class="far fa-heart"></i>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Detalhes adicionais -->
                <div class="border-t border-gray-100 p-6">
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold mb-4">Especificações</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <?php if (isset($produto['s_especificacoes']) && is_array($produto['s_especificacoes'])): ?>
                                <?php foreach ($produto['s_especificacoes'] as $key => $value): ?>
                                    <div class="flex">
                                        <span class="font-medium w-1/3"><?php echo $key; ?>:</span>
                                        <span class="text-gray-600"><?php echo $value; ?></span>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="flex">
                                    <span class="font-medium w-1/3">Marca:</span>
                                    <span class="text-gray-600"><?php echo $produto['s_marca'] ?? 'Não especificado'; ?></span>
                                </div>
                                <div class="flex">
                                    <span class="font-medium w-1/3">Modelo:</span>
                                    <span class="text-gray-600"><?php echo $produto['s_modelo'] ?? 'Não especificado'; ?></span>
                                </div>
                                <div class="flex">
                                    <span class="font-medium w-1/3">Garantia:</span>
                                    <span class="text-gray-600">12 meses</span>
                                </div>
                                <div class="flex">
                                    <span class="font-medium w-1/3">Código:</span>
                                    <span class="text-gray-600"><?php echo $produto['i_id_produtos']; ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Produtos relacionados -->
            <?php if (isset($produtos_relacionados) && is_array($produtos_relacionados) && count($produtos_relacionados) > 0): ?>
                <div class="mt-12">
                    <h2 class="text-2xl font-bold mb-6">Produtos Relacionados</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        <?php foreach ($produtos_relacionados as $prod_rel): ?>
                            <div class="bg-white rounded-lg shadow-sm overflow-hidden transition-all duration-300 hover:shadow-md hover:-translate-y-1">
                                <div class="relative">
                                    <?php if (!empty($prod_rel['s_imagem_produtos'])): ?>
                                        <img src="<?php echo $prod_rel['s_imagem_produtos']; ?>" class="w-full h-48 object-cover" alt="<?php echo $prod_rel['s_nome_produtos']; ?>">
                                    <?php else: ?>
                                        <img src="https://via.placeholder.com/400x300/3b82f6/ffffff?text=Produto" class="w-full h-48 object-cover" alt="<?php echo $prod_rel['s_nome_produtos']; ?>">
                                    <?php endif; ?>
                                    <div class="absolute top-3 right-3">
                                        <span class="bg-primary text-white text-sm font-medium px-3 py-1 rounded-full">
                                            R$ <?php echo number_format($prod_rel['d_preco_produtos'], 2, ',', '.'); ?>
                                        </span>
                                    </div>
                                </div>
                                <div class="p-4">
                                    <h3 class="font-semibold text-lg mb-2 text-gray-800"><?php echo $prod_rel['s_nome_produtos']; ?></h3>
                                    <div class="mb-4">
                                        <span class="inline-block bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded">
                                            <?php echo $prod_rel['s_nome_categorias'] ?? 'Sem categoria'; ?>
                                        </span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <a href="index.php?c=product&a=detail&id=<?php echo $prod_rel['i_id_produtos']; ?>" 
                                           class="text-primary border border-primary px-3 py-1.5 rounded text-sm hover:bg-primary hover:text-white transition-colors">
                                            Ver detalhes
                                        </a>
                                        <a href="index.php?c=cart&a=add&id=<?php echo $prod_rel['i_id_produtos']; ?>" 
                                           class="bg-success text-white w-9 h-9 flex items-center justify-center rounded-full hover:bg-success/90 transition-colors">
                                            <i class="fas fa-shopping-cart"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
            
        <?php else: ?>
            <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded">
                <p class="text-blue-700">Produto não encontrado.</p>
                <p class="text-blue-700 mt-2">
                    <a href="index.php?c=product&a=list" class="underline hover:no-underline">Ver todos os produtos</a>
                </p>
            </div>
        <?php endif; ?>
    </div>

    <script>
        function incrementQuantity() {
            const quantityInput = document.getElementById('quantity');
            const maxQuantity = parseInt(quantityInput.getAttribute('max'));
            let currentValue = parseInt(quantityInput.value);
            
            if (currentValue < maxQuantity) {
                quantityInput.value = currentValue + 1;
            }
        }
        
        function decrementQuantity() {
            const quantityInput = document.getElementById('quantity');
            let currentValue = parseInt(quantityInput.value);
            
            if (currentValue > 1) {
                quantityInput.value = currentValue - 1;
            }
        }
    </script>
</body>
</html>