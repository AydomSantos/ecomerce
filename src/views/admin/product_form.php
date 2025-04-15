<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($produto) ? 'Editar Produto' : 'Novo Produto'; ?> - Painel Administrativo</title>
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
                            <a href="index.php?c=admin&a=products" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md bg-gray-700 text-white">
                                <i class="fas fa-box mr-3 text-gray-400"></i>
                                Produtos
                            </a>
                            <a href="index.php?c=admin&a=categories" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-300 hover:bg-gray-700 hover:text-white">
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
                        <h1 class="text-2xl font-semibold text-gray-900"><?php echo isset($produto) ? 'Editar Produto' : 'Novo Produto'; ?></h1>
                        <a href="index.php?c=admin&a=products" class="flex items-center text-sm text-gray-600 hover:text-gray-900">
                            <i class="fas fa-arrow-left mr-1"></i> Voltar para lista
                        </a>
                    </div>
                    
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8 mt-4">
                        <?php if (isset($_GET['error'])): ?>
                            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                                <p>Ocorreu um erro ao salvar o produto. Por favor, tente novamente.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <form action="index.php?c=admin&a=<?php echo isset($produto) ? 'updateProduct' : 'saveProduct'; ?>" method="post" enctype="multipart/form-data" class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
                        <?php if (isset($produto)): ?>
                            <input type="hidden" name="id" value="<?php echo $produto['i_id_produtos']; ?>">
                        <?php endif; ?>
                        
                        <div class="bg-white shadow overflow-hidden sm:rounded-lg p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Informações Básicas</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label for="nome" class="block text-sm font-medium text-gray-700 mb-1">Nome do Produto *</label>
                                    <input type="text" id="nome" name="nome" value="<?php echo $produto['s_nome_produtos'] ?? ''; ?>" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary/50">
                                </div>
                                
                                <div>
                                    <label for="categoria_id" class="block text-sm font-medium text-gray-700 mb-1">Categoria *</label>
                                    <select id="categoria_id" name="categoria_id" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary/50">
                                        <option value="">Selecione uma categoria</option>
                                        <?php foreach ($categorias as $categoria): ?>
                                            <option value="<?php echo $categoria['i_id_categorias']; ?>" <?php echo (isset($produto['categoria_id']) && $produto['categoria_id'] == $categoria['i_id_categorias']) ? 'selected' : ''; ?>>
                                                <?php echo $categoria['s_nome_categorias']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                
                                <div>
                                    <label for="preco" class="block text-sm font-medium text-gray-700 mb-1">Preço (R$) *</label>
                                    <input type="number" id="preco" name="preco" value="<?php echo $produto['d_preco_produtos'] ?? ''; ?>" step="0.01" min="0" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary/50">
                                </div>
                                
                                <div>
                                    <label for="estoque" class="block text-sm font-medium text-gray-700 mb-1">Estoque *</label>
                                    <input type="number" id="estoque" name="estoque" value="<?php echo $produto['i_estoque_produtos'] ?? ''; ?>" min="0" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary/50">
                                </div>
                            </div>
                            
                            <!-- Additional Information -->
                            <div class="space-y-6">
                                <div>
                                    <label for="descricao" class="block text-sm font-medium text-gray-700 mb-1">Descrição *</label>
                                    <textarea id="descricao" name="descricao" rows="5" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary/50"><?php echo $produto['t_descricao_produtos'] ?? ''; ?></textarea>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Imagem do Produto</label>
                                    <div class="mt-1 flex items-center">
                                        <?php if (isset($produto['s_imagem_produtos']) && !empty($produto['s_imagem_produtos'])): ?>
                                            <div class="relative">
                                                <img src="<?php echo $produto['s_imagem_produtos']; ?>" alt="<?php echo $produto['s_nome_produtos']; ?>" class="h-32 w-32 object-cover rounded-md">
                                                <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity rounded-md">
                                                    <button type="button" class="text-white p-1 rounded-full bg-red-500 hover:bg-red-600" onclick="document.getElementById('remover_imagem').value = '1'; this.closest('.relative').classList.add('hidden');">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <input type="hidden" name="remover_imagem" id="remover_imagem" value="0">
                                        <?php else: ?>
                                            <div class="h-32 w-32 rounded-md bg-gray-200 flex items-center justify-center">
                                                <i class="fas fa-image text-gray-400 text-3xl"></i>
                                            </div>
                                        <?php endif; ?>
                                        <div class="ml-5">
                                            <div class="flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 relative">
                                                <i class="fas fa-upload mr-2"></i>
                                                <span>Carregar imagem</span>
                                                <input type="file" name="imagem" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                            </div>
                                            <p class="mt-1 text-xs text-gray-500">PNG, JPG ou GIF até 2MB</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div>
                                    <label for="destaque" class="flex items-center">
                                        <input type="checkbox" id="destaque" name="destaque" value="1" <?php echo (isset($produto['i_destaque_produtos']) && $produto['i_destaque_produtos'] == 1) ? 'checked' : ''; ?> class="rounded border-gray-300 text-primary focus:ring-primary">
                                        <span class="ml-2 text-sm text-gray-700">Produto em destaque na página inicial</span>
                                    </label>
                                </div>
                                
                                <div>
                                    <label for="ativo" class="flex items-center">
                                        <input type="checkbox" id="ativo" name="ativo" value="1" <?php echo (!isset($produto['i_ativo_produtos']) || $produto['i_ativo_produtos'] == 1) ? 'checked' : ''; ?> class="rounded border-gray-300 text-primary focus:ring-primary">
                                        <span class="ml-2 text-sm text-gray-700">Produto ativo (visível na loja)</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <!-- SEO Information -->
                        <div class="mt-8 pt-6 border-t">
                            <h3 class="text-md font-medium text-gray-700 mb-4">Informações para SEO (opcional)</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="meta_titulo" class="block text-sm font-medium text-gray-700 mb-1">Meta Título</label>
                                    <input type="text" id="meta_titulo" name="meta_titulo" value="<?php echo $produto['s_meta_titulo_produtos'] ?? ''; ?>" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary/50">
                                    <p class="mt-1 text-xs text-gray-500">Recomendado: 50-60 caracteres</p>
                                </div>
                                
                                <div>
                                    <label for="meta_descricao" class="block text-sm font-medium text-gray-700 mb-1">Meta Descrição</label>
                                    <textarea id="meta_descricao" name="meta_descricao" rows="2" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary/50"><?php echo $produto['s_meta_descricao_produtos'] ?? ''; ?></textarea>
                                    <p class="mt-1 text-xs text-gray-500">Recomendado: 150-160 caracteres</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Pricing and Inventory -->
                        <div class="mt-8 pt-6 border-t">
                            <h3 class="text-md font-medium text-gray-700 mb-4">Preços e Estoque Avançados (opcional)</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label for="preco_promocional" class="block text-sm font-medium text-gray-700 mb-1">Preço Promocional (R$)</label>
                                    <input type="number" id="preco_promocional" name="preco_promocional" value="<?php echo $produto['d_preco_promocional_produtos'] ?? ''; ?>" step="0.01" min="0" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary/50">
                                </div>
                                
                                <div>
                                    <label for="promocao_inicio" class="block text-sm font-medium text-gray-700 mb-1">Início da Promoção</label>
                                    <input type="date" id="promocao_inicio" name="promocao_inicio" value="<?php echo $produto['d_promocao_inicio_produtos'] ?? ''; ?>" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary/50">
                                </div>
                                
                                <div>
                                    <label for="promocao_fim" class="block text-sm font-medium text-gray-700 mb-1">Fim da Promoção</label>
                                    <input type="date" id="promocao_fim" name="promocao_fim" value="<?php echo $produto['d_promocao_fim_produtos'] ?? ''; ?>" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary/50">
                                </div>
                                
                                <div>
                                    <label for="sku" class="block text-sm font-medium text-gray-700 mb-1">SKU (Código do Produto)</label>
                                    <input type="text" id="sku" name="sku" value="<?php echo $produto['s_sku_produtos'] ?? ''; ?>" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary/50">
                                </div>
                                
                                <div>
                                    <label for="peso" class="block text-sm font-medium text-gray-700 mb-1">Peso (kg)</label>
                                    <input type="number" id="peso" name="peso" value="<?php echo $produto['d_peso_produtos'] ?? ''; ?>" step="0.01" min="0" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary/50">
                                </div>
                                
                                <div>
                                    <label for="estoque_minimo" class="block text-sm font-medium text-gray-700 mb-1">Estoque Mínimo</label>
                                    <input type="number" id="estoque_minimo" name="estoque_minimo" value="<?php echo $produto['i_estoque_minimo_produtos'] ?? ''; ?>" min="0" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary/50">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Form actions -->
                        <div class="mt-8 pt-6 border-t flex justify-end space-x-3">
                            <a href="index.php?c=admin&a=products" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                Cancelar
                            </a>
                            <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                <?php echo isset($produto) ? 'Atualizar Produto' : 'Salvar Produto'; ?>
                            </button>
                        </div>
                    </form>
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
        
        // Preview image before upload
        const fileInput = document.querySelector('input[type="file"]');
        fileInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imageContainer = document.querySelector('.h-32.w-32');
                    if (imageContainer) {
                        if (imageContainer.tagName === 'IMG') {
                            imageContainer.src = e.target.result;
                        } else {
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.classList.add('h-32', 'w-32', 'object-cover', 'rounded-md');
                            imageContainer.parentNode.replaceChild(img, imageContainer);
                        }
                    }
                }
                reader.readAsDataURL(this.files[0]);
            }
        });
    </script>
</body>
</html>