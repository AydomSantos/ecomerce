<?php
// Incluir o autoloader
require_once __DIR__ . '/../vendor/autoload.php';

// Incluir a configuração do banco de dados
require_once __DIR__ . '/../config/config.php';

// Usar a classe Product
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
    $stmt = $conn->prepare("INSERT INTO categorias (s_nome_categarias) VALUES ('Categoria Teste')");
    $stmt->execute();
    return $conn->lastInsertId();
}

// Criar uma instância da classe Product
$productModel = new Product($conn);

echo "<h1>Testes Unitários da Classe Product</h1>";

// Obter uma categoria válida para teste
$categoria_id = ensure_test_category($conn);
echo "<div>Usando categoria ID: $categoria_id para testes</div>";

// Testar o método getAll()
echo "<h2>Testando getAll()</h2>";
$products = $productModel->getAll();
assert_test(is_array($products), "getAll() deve retornar um array");

// Testar o método create()
echo "<h2>Testando create()</h2>";
$newProductData = [
    'nome' => 'Produto Teste',
    'descricao' => 'Descrição do produto de teste',
    'preco' => 99.90,
    'estoque' => 10,
    'categoria_id' => $categoria_id, // Usar a categoria válida
    'imagem' => '/assets/images/default.jpg' // Adicionando campo de imagem
];
$newProductId = $productModel->create($newProductData);
assert_test($newProductId !== false, "create() deve retornar um ID válido");

// Se o produto foi criado com sucesso
if ($newProductId) {
    // Testar o método getById()
    echo "<h2>Testando getById()</h2>";
    $product = $productModel->getById($newProductId);
    assert_test(is_array($product), "getById() deve retornar um array");
    assert_test($product['s_nome_produtos'] === 'Produto Teste', "O nome do produto deve corresponder");
    
    // Testar o método update()
    echo "<h2>Testando update()</h2>";
    $updateData = [
        'nome' => 'Produto Teste Atualizado',
        'descricao' => 'Descrição atualizada',
        'preco' => 129.90,
        'estoque' => 15,
        'categoria_id' => $categoria_id,
        'imagem' => '/assets/images/updated.jpg'
    ];
    $updateResult = $productModel->update($newProductId, $updateData);
    assert_test($updateResult === true, "update() deve retornar true");
    
    // Verificar se a atualização funcionou
    $updatedProduct = $productModel->getById($newProductId);
    assert_test($updatedProduct['s_nome_produtos'] === 'Produto Teste Atualizado', "O nome do produto deve ser atualizado");
    assert_test((float)$updatedProduct['d_preco_produtos'] === 129.90, "O preço do produto deve ser atualizado");
    
    // Testar o método addImage()
    echo "<h2>Testando addImage()</h2>";
    $addImageResult = $productModel->addImage($newProductId, '/assets/images/test-image.jpg', 1);
    assert_test($addImageResult === true, "addImage() deve retornar true");
    
    // Testar o método getImages()
    echo "<h2>Testando getImages()</h2>";
    $images = $productModel->getImages($newProductId);
    assert_test(is_array($images), "getImages() deve retornar um array");
    assert_test(count($images) >= 1, "Deve haver pelo menos uma imagem");
    
    // Testar o método delete()
    echo "<h2>Testando delete()</h2>";
    $deleteResult = $productModel->delete($newProductId);
    assert_test($deleteResult === true, "delete() deve retornar true");
    
    // Verificar se o produto foi realmente excluído
    $deletedProduct = $productModel->getById($newProductId);
    assert_test($deletedProduct === false, "O produto deve ser excluído do banco de dados");
    
    echo "<h2>Resumo dos Testes</h2>";
    echo "<p>Todos os testes foram executados. Verifique os resultados acima.</p>";
} else {
    echo "<div style='color:red'>Não foi possível criar o produto de teste. Verifique a conexão com o banco de dados e a estrutura da tabela.</div>";
    echo "<div>Erro detalhado: Verifique se a tabela 'categorias' existe e contém registros.</div>";
}
?>