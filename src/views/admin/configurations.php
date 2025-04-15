
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configurações</title>
    <!-- Tailwind CSS - Production Version -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body class="bg-gray-50 text-gray-800">
    <div class="max-w-7xl mx-auto px-4 py-8">
        <header class="mb-8">
            <h1 class="text-4xl font-bold text-primary mb-2">Configurações</h1>
            <div class="flex items-center text-sm text-gray-500">
                <a href="index.php" class="hover:text-primary transition-colors">Home</a>
                <span class="mx-2">/</span>
                <span>Configurações</span>
            </div>
        </header>

        <div class="bg-white rounded-lg shadow-sm p-5 mb-6">
            <h2 class="text-2xl font-semibold mb-4">Preferências Gerais</h2>
            <form action="index.php?c=admin&a=saveConfigurations" method="post">
                <div class="space-y-4">
                    <div>
                        <label for="s_nome_usuarios" class="block text-sm font-medium text-gray-700">Nome do Usuário</label>
                        <input type="text" name="s_nome_usuarios" id="s_nome_usuarios" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary/50" placeholder="Nome do Usuário">
                    </div>
                    <div>
                        <label for="i_id_usuarios" class="block text-sm font-medium text-gray-700">ID do Usuário</label>
                        <input type="text" name="i_id_usuarios" id="i_id_usuarios" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary/50" placeholder="ID do Usuário">
                    </div>
                    <div>
                        <label for="s_email_usuarios" class="block text-sm font-medium text-gray-700">Email do Usuário</label>
                        <input type="email" name="s_email_usuarios" id="s_email_usuarios" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary/50" placeholder="Email do Usuário">
                    </div>
                    <div>
                        <label for="s_senha_usuarios" class="block text-sm font-medium text-gray-700">Senha do Usuário</label>
                        <input type="password" name="s_senha_usuarios" id="s_senha_usuarios" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary/50" placeholder="Senha do Usuário">
                    </div>
                    <div>
                        <label for="s_tipo_usuarios" class="block text-sm font-medium text-gray-700">Tipo de Usuário</label>
                        <input type="text" name="s_tipo_usuarios" id="s_tipo_usuarios" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary/50" placeholder="Tipo de Usuário">
                    </div>
                    <div>
                        <label for="s_telefone_usuarios" class="block text-sm font-medium text-gray-700">Telefone do Usuário</label>
                        <input type="text" name="s_telefone_usuarios" id="s_telefone_usuarios" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary/50" placeholder="Telefone do Usuário">
                    </div>
                    <div>
                        <label for="s_endereco_usuarios" class="block text-sm font-medium text-gray-700">Endereço do Usuário</label>
                        <input type="text" name="s_endereco_usuarios" id="s_endereco_usuarios" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary/50" placeholder="Endereço do Usuário">
                    </div>
                    <div>
                        <label for="s_cidade_usuarios" class="block text-sm font-medium text-gray-700">Cidade do Usuário</label>
                        <input type="text" name="s_cidade_usuarios" id="s_cidade_usuarios" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary/50" placeholder="Cidade do Usuário">
                    </div>
                    <div>
                        <label for="s_estado_usuarios" class="block text-sm font-medium text-gray-700">Estado do Usuário</label>
                        <input type="text" name="s_estado_usuarios" id="s_estado_usuarios" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary/50" placeholder="Estado do Usuário">
                    </div>
                    <div>
                        <label for="s_cep_usuarios" class="block text-sm font-medium text-gray-700">CEP do Usuário</label>
                        <input type="text" name="s_cep_usuarios" id="s_cep_usuarios" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary/50" placeholder="CEP do Usuário">
                    </div>
                    <div>
                        <label for="b_ativo_usuarios" class="block text-sm font-medium text-gray-700">Usuário Ativo</label>
                        <input type="checkbox" name="b_ativo_usuarios" id="b_ativo_usuarios" class="mt-1 block px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary/50">
                    </div>
                    <div>
                        <label for="dt_cadastro_usuarios" class="block text-sm font-medium text-gray-700">Data de Cadastro</label>
                        <input type="date" name="dt_cadastro_usuarios" id="dt_cadastro_usuarios" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary/50">
                    </div>
                    <div>
                        <label for="dt_atualizacao_usuarios" class="block text-sm font-medium text-gray-700">Data de Atualização</label>
                        <input type="date" name="dt_atualizacao_usuarios" id="dt_atualizacao_usuarios" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary/50">
                    </div>
                    <button type="submit" class="w-full bg-primary hover:bg-primary/90 text-white py-2 px-4 rounded-md transition-colors">
                        Salvar Configurações
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>