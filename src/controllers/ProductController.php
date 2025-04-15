<?php
namespace Aydom\Ecomerce\Controllers;

use Aydom\Ecomerce\Models\Product;
use Aydom\Ecomerce\Models\Category;
use PDO;

class ProductController {
    private PDO $conn;
    private Product $productModel;
    private Category $categoryModel;

    public function __construct(PDO $conn) {
        $this->conn = $conn;
        $this->productModel = new Product($conn);
        $this->categoryModel = new Category($conn);
    }

    public function list(): void {
        $filters = [];

        if (isset($_GET['categorias'])) {
            $filters['i_id_categorias'] = (int) $_GET['categorias'];
        }

        if (isset($_GET['search'])) {
            $filters['search'] = (string) $_GET['search'];
        }

        if (isset($_GET['min_price'])) {
            $filters['min_price'] = (float) $_GET['min_price'];
        }

        if (isset($_GET['max_price'])) {
            $filters['max_price'] = (float) $_GET['max_price'];
        }

        $sort = (string) ($_GET['sort'] ?? 'name_asc');

        $produtos = $this->productModel->getAll($filters, $sort);
        $categorias = $this->categoryModel->getAll();

        include __DIR__ . '/../views/product/list.php';
    }

    public function detail(): void {
        try {
            $id = isset($_GET['id']) ? (int) $_GET['id'] : null;

            if (!$id) {
                header("Location: index.php?c=product&a=list");
                exit;
            }

            $produto = $this->productModel->getById($id);

            if (!$produto) {
                header("Location: index.php?c=product&a=list");
                exit;
            }

            $imagens = $this->productModel->getImages($id);
            $categoria_id = $produto['i_id_categorias'] ?? null;
            $produtos_relacionados = [];

            if ($categoria_id) {
                $filters = ['i_id_categorias' => $categoria_id];
                $related = $this->productModel->getAll($filters);

                foreach ($related as $rel) {
                    if ($rel['i_id_produtos'] != $id) {
                        $produtos_relacionados[] = $rel;
                    }

                    if (count($produtos_relacionados) >= 4) {
                        break;
                    }
                }
            }

            include __DIR__ . '/../views/product/detail.php';

        } catch (\Exception $e) {
            echo "Erro ao exibir detalhes do produto: " . $e->getMessage();
        }
    }

    public function addProduct(): void {
        try {
            $categorias = $this->categoryModel->getAll();

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $nome = (string) $_POST['nome'];
                $descricao = (string) $_POST['descricao'];
                $preco = (float) $_POST['preco'];
                $id_categorias = isset($_POST['id_categorias']) ? (int) $_POST['id_categorias'] : null;

                $image = '';
                if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    $uploadDir = __DIR__ . '/../../public/uploads/products/';

                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }

                    $fileName = time() . '_' . basename($_FILES['image']['name']);
                    $uploadFile = $uploadDir . $fileName;

                    if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                        $image = '/uploads/products/' . $fileName;
                    }
                }

                $productId = $this->productModel->create($nome, $descricao, $preco, $id_categorias, $image);

                if ($productId && isset($_FILES['image']['tmp_name']) && is_array($_FILES['image']['tmp_name'])) {
                    $uploadDir = __DIR__ . '/../../public/uploads/products/';
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }
                    foreach ($_FILES['image']['tmp_name'] as $key => $tmpName) {
                        if ($_FILES['image']['error'][$key] === UPLOAD_ERR_OK) {
                            $fileName = time() . '_' . basename($_FILES['image']['name'][$key]);
                            $uploadFile = $uploadDir . $fileName;
                            if (move_uploaded_file($tmpName, $uploadFile)) {
                                $image = '/uploads/products/' . $fileName;
                                $this->productModel->addImage($productId, $image);
                            }
                        }
                    }
                }
            }

            include __DIR__ . '/../views/product/add.php';
            exit;

        } catch (\Exception $e) {
            echo "Erro ao adicionar produto: " . $e->getMessage();
        }
    }

    public function edit(int $id): void {
        try {
            $categorias = $this->categoryModel->getAll();
            $product = $this->productModel->getById($id);

            if (!$product) {
                header("Location: index.php?c=product&a=list");
                exit;
            }

            $images = $this->productModel->getImages($id);

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $nome = (string) $_POST['nome'];
                $descricao = (string) $_POST['descricao'];
                $preco = (float) $_POST['preco'];
                $id_categorias = isset($_POST['id_categorias']) ? (int) $_POST['id_categorias'] : null;
                $image = $product['image'] ?? null;

                if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    $uploadDir = __DIR__ . '/../../public/uploads/products/';

                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }

                    $fileName = time() . '_' . basename($_FILES['image']['name']);
                    $uploadFile = $uploadDir . $fileName;

                    if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                        $image = '/uploads/products/' . $fileName;
                    }
                }

                $this->productModel->update($id, [
                    'nome' => $nome,
                    'descricao' => $descricao,
                    'preco' => $preco,
                    'id_categorias' => $id_categorias,
                    'image' => $image,
                    'category_id' => $product['i_id_categorias']
                ]);

                if (isset($_FILES['image']['tmp_name']) && is_array($_FILES['image']['tmp_name'])) {
                    $uploadDir = __DIR__ . '/../../public/uploads/products/';
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }
                    foreach ($_FILES['image']['tmp_name'] as $key => $tmpName) {
                        if ($_FILES['image']['error'][$key] === UPLOAD_ERR_OK) {
                            $fileName = time() . '_' . basename($_FILES['image']['name'][$key]);
                            $uploadFile = $uploadDir . $fileName;

                            if (move_uploaded_file($tmpName, $uploadFile)) {
                                $image = '/uploads/products/' . $fileName;
                                $this->productModel->addImage($id, $image);
                            }
                        }
                    }
                }
                header("Location: index.php?c=product&a=list");
                exit;
            }

            include __DIR__ . '/../views/product/form.php';
        } catch (\Exception $e) {
            echo "Erro ao detalhar produto: " . $e->getMessage();
        }
    }

    public function delete(int $id): void {
        try {
            $this->productModel->delete($id);
            header("Location: index.php?c=product&a=list");
            exit;
        } catch (\Exception $e) {
            echo "Erro ao detalhar produto: " . $e->getMessage();
        }
    }
}