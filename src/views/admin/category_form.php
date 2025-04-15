<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($categoria) ? 'Editar Categoria' : 'Nova Categoria'; ?> - Painel Administrativo</title>
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
                        <h1 class="text-2xl font-semibold text-gray-900"><?php echo isset($categoria) ? 'Editar Categoria' : 'Nova Categoria'; ?></h1>
                        <a href="index.php?c=admin&a=categories" class="flex items-center text-sm text-gray-600 hover:text-gray-900">
                            <i class="fas fa-arrow-left mr-1"></i> Voltar para lista
                        </a>
                    </div>
                    
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8 mt-4">
                        <?php if (isset($_GET['error'])): ?>
                            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                                <p>Ocorreu um erro ao salvar a categoria. Por favor, tente novamente.</p>
                            </div>
                        <?php endif; ?>
                        
                        <form action="index.php?c=admin&a=<?php echo isset($categoria) ? 'updateCategory' : 'saveCategory'; ?>" method="post" enctype="multipart/form-data" class="space-y-8">
                            <?php if (isset($categoria)): ?>
                                <input type="hidden" name="id" value="<?php echo $categoria['i_id_categorias']; ?>">
                            <?php endif; ?>
                            
                            <div class="bg-white shadow overflow-hidden sm:rounded-lg p-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="nome" class="block text-sm font-medium text-gray-700 mb-1">Nome da Categoria *</label>
                                        <input type="text" id="nome" name="nome" value="<?php echo $categoria['s_nome_categorias'] ?? ''; ?>" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary/50">
                                    </div>
                                    
                                    <div>
                                        <label for="ativo" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                        <div class="flex items-center mt-2">
                                            <input type="checkbox" id="ativo" name="ativo" <?php echo (isset($categoria) && $categoria['i_ativo_categorias']) ? 'checked' : ''; ?> class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                                            <label for="ativo" class="ml-2 block text-sm text-gray-900">Ativo</label>
                                        </div>
                                    </div>
                                    
                                    <div class="md:col-span-2">
                                        <label for="descricao" class="block text-sm font-medium text-gray-700 mb-1">Descrição</label>
                                        <textarea id="descricao" name="descricao" rows="4" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary/50"><?php echo $categoria['s_descricao_categorias'] ?? ''; ?></textarea>
                                    </div>
                                    
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Imagem da Categoria</label>
                                        <?php if (isset($categoria) && !empty($categoria['s_imagem_categorias'])): ?>
                                            <div class="mb-3">
                                                <img src="<?php echo $categoria['s_imagem_categorias']; ?>" alt="<?php echo htmlspecialchars($categoria['s_nome_categorias']); ?>" class="h-32 w-32 object-cover rounded">
                                                <div class="mt-2">
                                                    <label class="inline-flex items-center">
                                                        <input type="checkbox" name="remover_imagem" value="1" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                                                        <span class="ml-2 text-sm text-gray-600">Remover imagem atual</span>
                                                    </label>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                            <div class="space-y-1 text-center">
                                                <i class="fas fa-image mx-auto h-12 w-12 text-gray-400"></i>
                                                <div class="flex text-sm text-gray-600">
                                                    <label for="imagem" class="relative cursor-pointer bg-white rounded-md font-medium text-primary hover:text-primary/90 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-primary">
                                                        <span>Carregar imagem</span>
                                                        <input id="imagem" name="imagem" type="file" class="sr-only" accept="image/*">
                                                    </label>
                                                    <p class="pl-1">ou arraste e solte</p>
                                                </div>
                                                <p class="text-xs text-gray-500">PNG, JPG, GIF até 2MB</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-white shadow overflow-hidden sm:rounded-lg p-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">SEO</h3>
                                <div class="grid grid-cols-1 gap-6">
                                    <div>
                                        <label for="meta_titulo" class="block text-sm font-medium text-gray-700 mb-1">Meta Título</label>
                                        <input type="text" id="meta_titulo" name="meta_titulo" value="<?php echo $categoria['s_meta_titulo_categorias'] ?? ''; ?>" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary/50">
                                        <p class="mt-1 text-sm text-gray-500">Título para SEO (aparece na aba do navegador)</p>
                                    </div>
                                    
                                    <div>
                                        <label for="meta_descricao" class="block text-sm font-medium text-gray-700 mb-1">Meta Descrição</label>
                                        <textarea id="meta_descricao" name="meta_descricao" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary/50"><?php echo $categoria['s_meta_descricao_categorias'] ?? ''; ?></textarea>
                                        <p class="mt-1 text-sm text-gray-500">Breve descrição para resultados de busca</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex justify-end">
                                <a href="index.php?c=admin&a=categories" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary mr-3">
                                    Cancelar
                                </a>
                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                    <?php echo isset($categoria) ? 'Atualizar Categoria' : 'Salvar Categoria'; ?>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>
    
    <script>
        // Toggle sidebar on mobile
        document.getElementById('sidebarToggle')?.addEventListener('click', function() {
            const sidebar = document.querySelector('.md\\:flex-shrink-0');
            sidebar.classList.toggle('hidden');
            sidebar.classList.toggle('md:flex');
        });
        
        // Preview image before upload
        document.getElementById('imagem')?.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();   
                reader.onload = function(e) {
                    // Check if there's already a preview
                    let preview = document.querySelector('.image-preview');
                    
                    if (!preview) {
                        // Create preview container
                        preview = document.createElement('div');
                        preview.className = 'image-preview mb-3 mt-3';
                        
                        // Create image element
                        const img = document.createElement('img');
                        img.className = 'h-32 w-32 object-cover rounded';
                        img.src = e.target.result;
                        img.alt = 'Preview';
                        
                        // Add image to preview container
                        preview.appendChild(img);
                        
                        // Insert preview before the upload box
                        const uploadBox = document.querySelector('.border-dashed');
                        uploadBox.parentNode.insertBefore(preview, uploadBox);
                    } else {
                        // Update existing preview
                        const img = preview.querySelector('img');
                        img.src = e.target.result;
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>