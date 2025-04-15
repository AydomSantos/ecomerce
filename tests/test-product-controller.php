<?php
// Incluir o autoloader
require_once __DIR__ . '/../vendor/autoload.php';

// Incluir a configuração do banco de dados
require_once __DIR__ . '/../config/config.php';

// Usar as classes necessárias
use Aydom\Ecomerce\Controllers\ProductController;
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

// Função para criar um produto de teste
function create_test_product($productModel, $categoria_id) {
    $productData = [
        'nome' => 'Produto Teste Controller',
        'descricao' => 'Descrição do produto de teste para controller',
        'preco' => 99.90,
        'estoque' => 10,
        'categoria_id' => $categoria_id,
        'imagem' => '/assets/images/test.jpg'
    ];
    
    return $productModel->create($productData);
}

// Classe para simular requisições HTTP
class RequestSimulator {
    public static function simulateGet($params = []) {
        $_GET = $params;
        $_SERVER['REQUEST_METHOD'] = 'GET';
    }
    
    public static function simulatePost($params = [], $files = []) {
        $_POST = $params;
        $_FILES = $files;
        $_SERVER['REQUEST_METHOD'] = 'POST';
    }
    
    public static function reset() {
        $_GET = [];
        $_POST = [];
        $_FILES = [];
        $_SERVER['REQUEST_METHOD'] = 'GET';
    }
}

echo "<h1>Testes Unitários do ProductController</h1>";

// Obter uma categoria válida para teste
$categoria_id = ensure_test_category($conn);
echo "<div>Usando categoria ID: $categoria_id para testes</div>";

// Criar uma instância do modelo Product
$productModel = new Product($conn);

// Criar uma instância do controller
$controller = new ProductController($conn);

// Testar o método list()
echo "<h2>Testando list()</h2>";
ob_start(); // Iniciar buffer de saída
RequestSimulator::simulateGet();
$controller->list();
$output = ob_get_clean(); // Capturar saída
assert_test(strpos($output, 'Erro ao listar') === false, "list() não deve gerar erros");

// Testar o método list() com filtros
echo "<h2>Testando list() com filtros</h2>";
ob_start();
RequestSimulator::simulateGet(['categorias' => $categoria_id, 'search' => 'teste']);
$controller->list();
$output = ob_get_clean();
assert_test(strpos($output, 'Erro ao listar') === false, "list() com filtros não deve gerar erros");

// Criar um produto de teste para os próximos testes
$testProductId = create_test_product($productModel, $categoria_id);
assert_test($testProductId !== false, "Produto de teste criado com sucesso");

if ($testProductId) {
    // Testar o método detail()
    echo "<h2>Testando detail()</h2>";
    ob_start();
    try {
        // Corrigir o nome do método de detal para detail se necessário
        if (method_exists($controller, 'detail')) {
            $controller->detail($testProductId);
        } else {
            $controller->detal($testProductId);
        }
        $output = ob_get_clean();
        assert_test(strpos($output, 'Erro ao detalhar') === false, "detail() não deve gerar erros");
    } catch (\Exception $e) {
        ob_get_clean();
        echo "<div style='color:red'>Erro ao testar detail(): " . $e->getMessage() . "</div>";
    }
    
    // Testar o método edit() (apenas GET)
    echo "<h2>Testando edit() (GET)</h2>";
    ob_start();
    RequestSimulator::reset();
    try {
        $controller->edit($testProductId);
        $output = ob_get_clean();
        assert_test(strpos($output, 'Erro ao detalhar') === false, "edit() (GET) não deve gerar erros");
    } catch (\Exception $e) {
        ob_get_clean();
        echo "<div style='color:red'>Erro ao testar edit() (GET): " . $e->getMessage() . "</div>";
    }
    
    // Testar o método edit() (POST)
    echo "<h2>Testando edit() (POST)</h2>";
    ob_start();
    RequestSimulator::simulatePost([
        'nome' => 'Produto Teste Atualizado',
        'descricao' => 'Descrição atualizada pelo teste',
        'preco' => 129.90,
        'estoque' => 15,
        'id_categorias' => $categoria_id
    ]);
    try {
        $controller->edit($testProductId);
        $output = ob_get_clean();
        assert_test(strpos($output, 'Erro ao detalhar') === false, "edit() (POST) não deve gerar erros");
    } catch (\Exception $e) {
        ob_get_clean();
        echo "<div style='color:red'>Erro ao testar edit() (POST): " . $e->getMessage() . "</div>";
    }
    
    // Testar o método delete()
    echo "<h2>Testando delete()</h2>";
    ob_start();
    try {
        $controller->delete($testProductId);
        $output = ob_get_clean();
        assert_test(strpos($output, 'Erro ao detalhar') === false, "delete() não deve gerar erros");
    } catch (\Exception $e) {
        ob_get_clean();
        echo "<div style='color:red'>Erro ao testar delete(): " . $e->getMessage() . "</div>";
    }
    
    // Verificar se o produto foi realmente excluído
    $deletedProduct = $productModel->getById($testProductId);
    assert_test($deletedProduct === false, "O produto deve ser excluído do banco de dados");
} else {
    echo "<div style='color:red'>Não foi possível criar o produto de teste. Os testes subsequentes foram ignorados.</div>";
}

echo "<h2>Resumo dos Testes</h2>";
echo "<p>Todos os testes foram executados. Verifique os resultados acima.</p>";

// Limpar simulação
RequestSimulator::reset();
?>