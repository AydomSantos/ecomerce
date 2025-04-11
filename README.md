# E-commerce Project

## Visão Geral
Este projeto é uma aplicação de e-commerce desenvolvida utilizando PHP, HTML, CSS e JavaScript. Ele permite que os usuários naveguem por produtos, adicionem itens ao carrinho e realizem compras.

## Estrutura do Projeto
- **src**: Contém o código fonte principal, incluindo controladores, modelos, serviços e visualizações.
- **public**: Diretório acessível ao público, contendo arquivos CSS, JavaScript e imagens.
- **database**: Scripts de migração e seeds para configuração do banco de dados.
- **tests**: Contém scripts de teste para validar a funcionalidade dos componentes.
- **vendor**: Dependências gerenciadas pelo Composer.

## Tecnologias Utilizadas
- **PHP**: Linguagem de programação para lógica de servidor.
- **HTML/CSS**: Para estrutura e estilo das páginas web.
- **JavaScript**: Para interatividade no lado do cliente.
- **Tailwind CSS**: Framework CSS para design responsivo e moderno.
- **Font Awesome**: Biblioteca de ícones para melhorar a interface do usuário.
- **Composer**: Gerenciador de dependências PHP.
- **PDO**: Para conexão e operações com banco de dados.

## Funcionalidades Implementadas
- Listagem de produtos com filtros por categoria e preço
- Sistema de busca de produtos
- Ordenação de produtos por nome e preço
- Visualização detalhada de produtos com múltiplas imagens
- Seleção de quantidade na página de produto
- Exibição de produtos relacionados
- Interface responsiva adaptada para dispositivos móveis e desktop
- Autenticação de usuários
- Testes unitários para validação de componentes

## Design e Interface
- Interface moderna e minimalista usando Tailwind CSS
- Design responsivo para todos os tamanhos de tela
- Animações sutis para melhorar a experiência do usuário
- Exibição de produtos em cards com informações essenciais
- Página de detalhes com layout otimizado para conversão

## Configuração e Execução
1. Instale o XAMPP para configurar o ambiente PHP.
2. Clone o repositório para o diretório `htdocs` do XAMPP.
3. Execute o servidor Apache e MySQL através do painel de controle do XAMPP.
4. Importe o esquema de banco de dados a partir dos scripts em `/database`.
5. Acesse a aplicação via navegador em `http://localhost/ecomerce`.

## Testes
O projeto inclui testes unitários para validar o funcionamento dos componentes:

1. **Testes de Modelo**: Verificam se as operações CRUD estão funcionando corretamente.
   - Execute `http://localhost/ecomerce/tests/test-product.php` para testar o modelo de produtos.

2. **Testes de Controlador**: Verificam se os controladores processam corretamente as requisições.
   - Execute `http://localhost/ecomerce/tests/test-product-controller.php` para testar o controlador de produtos.

Os testes utilizam uma abordagem simples com asserções visuais para facilitar a identificação de problemas.

## Contribuição
Para contribuir com o projeto, faça um fork do repositório e envie um pull request com suas alterações.

## Estrutura do Banco de Dados
O sistema utiliza um banco de dados MySQL com as seguintes tabelas principais:
- **categorias**: Armazena as categorias de produtos
- **produtos**: Armazena informações dos produtos
- **product_images**: Armazena múltiplas imagens para cada produto