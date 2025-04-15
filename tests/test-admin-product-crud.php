<?php
// Incluir o autoloader
require_once __DIR__ . '/../vendor/autoload.php';

// Incluir a configuração do banco de dados
require_once __DIR__ . '/../config/config.php';

// Usar as classes necessárias
use Aydom\Ecomerce\Models\Product;

// Função para verificar testes
function assert_test($condition, $message) {
    if ($condition) {
        echo "<div style='color:green'>✓ PASSOU: $message</div>";
    } else {
        echo "<div style='color:red'>✗ FALHOU: $message</div>";
    }
}

// Função para garantir que existe uma categoria válida para teste
function ensure_test_category($conn) {
    // Verificar se já existe uma categoria
    $stmt = $conn->prepare("SELECT i_id_categorias FROM categorias LIMIT 1");
    $stmt->execute();
    $category = $stmt->fetch(\PDO::FETCH_ASSOC);
    
    if ($category) {
        return $category['i_id_categorias'];
    }
    
    // Se não existir, criar uma categoria de teste
    $stmt = $conn->prepare("INSERT INTO categorias (s_nome_categarias) VALUES ('Categoria Teste Admin')");
    $stmt->execute();
    return $conn->lastInsertId();
}

// Função para garantir que existe um usuário admin para teste
function ensure_admin_user($conn) {
    // Verificar se já existe um admin
    $stmt = $conn->prepare("SELECT i_id_usuarios FROM usuarios WHERE s_tipo_usuarios = 'admin' LIMIT 1");
    $stmt->execute();
    $admin = $stmt->fetch(\PDO::FETCH_ASSOC);
    
    if ($admin) {
        return $admin['i_id_usuarios'];
    }
    
    // Se não existir, criar um admin de teste
    $hashedPassword = password_hash('admin123', PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO usuarios (s_nome_usuarios, s_email_usuarios, s_senha_usuarios, s_tipo_usuarios) 
                           VALUES ('Admin Teste', 'admin_test@ecomerce.com', :senha, 'admin')");
    $stmt->bindParam(':senha', $hashedPassword);
    $stmt->execute();
    return $conn->lastInsertId();
}

// Classe para simular requisições HTTP e sessão de admin
class AdminRequestSimulator {
    public static function simulateGet($params = []) {
        $_GET = $params;
        $_SERVER['REQUEST_METHOD'] = 'GET';
    }
    
    public static function simulatePost($params = [], $files = []) {
        $_POST = $params;
        $_FILES = $files;
        $_SERVER['REQUEST_METHOD'] = 'POST';
    }
    
    public static function simulateAdmin($adminId) {
        // Simular sessão de administrador
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['admin_id'] = $adminId;
        $_SESSION['admin_name'] = 'Admin Teste';
    }
    
    public static function reset() {
        $_GET = [];
        $_POST = [];
        $_FILES = [];
        $_SERVER['REQUEST_METHOD'] = 'GET';
        
        // Limpar sessão
        if (session_status() == PHP_SESSION_ACTIVE) {
            session_destroy();
        }
    }
}

echo "<h1>Testes de CRUD de Produtos (Admin)</h1>";

// Obter uma categoria válida para teste
$categoria_id = ensure_test_category($conn);
echo "<div>Usando categoria ID: $categoria_id para testes</div>";

// Obter um usuário admin para teste
$admin_id = ensure_admin_user($conn);
echo "<div>Usando admin ID: $admin_id para testes</div>";

// Simular login de administrador
AdminRequestSimulator::simulateAdmin($admin_id);

// Criar uma instância do modelo Product
$productModel = new Product($conn);

// Testar criação de produto (Create)
echo "<h2>Testando Criação de Produto (Admin)</h2>";

$newProductData = [
    'nome' => 'Produto Admin Teste',
    'descricao' => 'Descrição do produto de teste para admin',
    'preco' => 149.90,
    'estoque' => 25,
    'categoria_id' => $categoria_id,
    'imagem' => '/assets/images/admin-test.jpg'
];

$newProductId = $productModel->create($newProductData);
assert_test($newProductId !== false, "Admin deve conseguir criar um produto");

// Testar leitura de produto (Read)
echo "<h2>Testando Leitura de Produto (Admin)</h2>";

if ($newProductId) {
    $product = $productModel->getById($newProductId);
    assert_test(is_array($product), "Admin deve conseguir ler um produto");
    assert_test($product['s_nome_produtos'] === 'Produto Admin Teste', "O nome do produto deve corresponder");
    assert_test((float)$product['d_preco_produtos'] === 149.90, "O preço do produto deve corresponder");
    
    // Testar atualização de produto (Update)
    echo "<h2>Testando Atualização de Produto (Admin)</h2>";
    
    $updateData = [
        'nome' => 'Produto Admin Atualizado',
        'descricao' => 'Descrição atualizada pelo admin',
        'preco' => 199.90,
        'estoque' => 30,
        'categoria_id' => $categoria_id,
        'imagem' => '/assets/images/admin-updated.jpg'
    ];
    
    $updateResult = $productModel->update($newProductId, $updateData);
    assert_test($updateResult === true, "Admin deve conseguir atualizar um produto");
    
    // Verificar se a atualização funcionou
    $updatedProduct = $productModel->getById($newProductId);
    assert_test($updatedProduct['s_nome_produtos'] === 'Produto Admin Atualizado', "O nome do produto deve ser atualizado");
    assert_test((float)$updatedProduct['d_preco_produtos'] === 199.90, "O preço do produto deve ser atualizado");
    
    // Testar adição de imagem ao produto
    echo "<h2>Testando Adição de Imagem ao Produto (Admin)</h2>";
    
    $addImageResult = $productModel->addImage($newProductId, '/assets/images/admin-product-image.jpg');
    assert_test($addImageResult === true, "Admin deve conseguir adicionar imagem ao produto");
    
    // Verificar se a imagem foi adicionada
    $images = $productModel->getImages($newProductId);
    assert_test(is_array($images), "getImages() deve retornar um array");
    assert_test(count($images) >= 1, "Deve haver pelo menos uma imagem");
    
    // Testar exclusão de produto (Delete)
    echo "<h2>Testando Exclusão de Produto (Admin)</h2>";
    
    $deleteResult = $productModel->delete($newProductId);
    assert_test($deleteResult === true, "Admin deve conseguir excluir um produto");
    
    // Verificar se o produto foi realmente excluído
    $deletedProduct = $productModel->getById($newProductId);
    assert_test($deletedProduct === false, "O produto deve ser excluído do banco de dados");
} else {
    echo "<div style='color:red'>Não foi possível criar o produto de teste. Os testes subsequentes foram ignorados.</div>";
}

// Testar listagem de produtos com filtros (Admin)
echo "<h2>Testando Listagem de Produtos com Filtros (Admin)</h2>";

// Criar alguns produtos para testar a listagem
$testProducts = [];
for ($i = 1; $i <= 3; $i++) {
    $productData = [
        'nome' => "Produto Admin Listagem $i",
        'descricao' => "Descrição do produto de listagem $i",
        'preco' => 99.90 + ($i * 10),
        'estoque' => 10 + $i,
        'categoria_id' => $categoria_id,
        'imagem' => "/assets/images/admin-list-$i.jpg"
    ];
    
    $productId = $productModel->create($productData);
    if ($productId) {
        $testProducts[] = $productId;
    }
}

// Verificar se conseguimos criar produtos para teste
assert_test(count($testProducts) === 3, "Deve ser possível criar produtos para teste de listagem");

// Testar listagem com filtro de categoria
$filteredProducts = $productModel->getAll(['i_id_categorias' => $categoria_id]);
assert_test(count($filteredProducts) >= 3, "Deve listar pelo menos 3 produtos da categoria de teste");

// Testar listagem com filtro de busca
$searchProducts = $productModel->getAll(['search' => 'Listagem']);
assert_test(count($searchProducts) >= 3, "Deve encontrar pelo menos 3 produtos com o termo 'Listagem'");

// Limpar produtos de teste
foreach ($testProducts as $productId) {
    $productModel->delete($productId);
}

echo "<h2>Resumo dos Testes de CRUD Admin</h2>";
echo "<p>Todos os testes de CRUD administrativo foram executados. Verifique os resultados acima.</p>";

// Limpar simulação
AdminRequestSimulator::reset();
?>