<?php
declare(strict_types=1);
namespace Aydom\Ecomerce\Controllers;

use Aydom\Ecomerce\Models\Product;
use Aydom\Ecomerce\Models\Category;
use Aydom\Ecomerce\Models\User;
use Aydom\Ecomerce\Models\Order;

class AdminController
{
    private $conn;
    private $productModel;
    private $categoryModel;
    private $userModel;
    private $orderModel;

    public function __construct($conn){
        $this->conn = $conn;
        // Initialize models with the database connection
        $this->productModel = new Product($this->conn);
        $this->categoryModel = new Category($this->conn);
        $this->userModel = new User($this->conn);
        $this->orderModel = new Order($this->conn);
    }
    // Display the login form
    public function login(?string $mensagem = null) : void {
        // Check if already logged in
        if (isset($_SESSION['admin_id'])) {
            header('Location: index.php?c=admin&a=dashboard');
            exit;
        }
        
        include __DIR__ . '/../views/admin/login.php';
    }
    // Autentica usuario
    public function authenticate() : void {
        // Get form data
        $email = (string) ($_POST['email'] ?? '');
        $password = (string) ($_POST['password'] ?? '');
        $remember = isset($_POST['remember_me']);
        
        // Simple validation
        if (empty($email) || empty($password)) {
            $_SESSION['admin_login_error'] = 'Por favor, preencha todos os campos.';
            header('Location: index.php?c=admin&a=login');
            exit;
        }
        
        // Check if user exists and is an admin
        $user = $this->userModel->getByEmail($email);
    
        // Debugging: log user data
        error_log('User fetched: ' . print_r($user, true));
        error_log('Password entered: ' . $password);

        if ($user && $user['s_tipo_usuarios'] === 'admin' && password_verify($password, $user['s_senha_usuarios'])) {
            // Set admin session
            $_SESSION['admin_id'] = $user['i_id_usuarios'];
            $_SESSION['admin_email'] = $user['s_email_usuarios'];
            $_SESSION['admin_name'] = $user['s_nome_usuarios'];

            // Se "lembrar-me" estiver marcado, define um cookie
            if ($remember) {
                $expiry = time() + (30 * 24 * 60 * 60); // 30 days
                setcookie('admin_email', $email, $expiry, '/');
            }
            
            header('Location: index.php?c=admin&a=dashboard');
            exit;
        } else {
            $_SESSION['admin_login_error'] = 'Email ou senha inválidos.';
            header('Location: index.php?c=admin&a=login');
            exit;
        }
    }
    // Logout admin
    public function logout() : void {
        // Start session if not already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Clear admin session variables
        unset($_SESSION['admin_id']);
        unset($_SESSION['admin_email']);
        unset($_SESSION['admin_name']);
        
        // Remove admin cookie if exists
        if (isset($_COOKIE['admin_email'])) {
            setcookie('admin_email', '', time() - 3600, '/');
        }
        
        // Redirect to login page
        header('Location: index.php?c=admin&a=login');
        exit;
    }
    // Display the admin dashboard
    public function dashboard() {
        // Check if admin is logged in
        if (!isset($_SESSION['admin_id'])) {
            header('Location: index.php?c=admin&a=login');
            exit;
        }
        
        $totalProdutos = $this->productModel->countAll();
        $vendasMes = $this->orderModel->calculateMonthSales();
        $totalUsuarios = $this->userModel->getTotalUsers(); 
        $pedidosPendentes = $this->orderModel->countPending();
        
        // Get recent products
        $produtos = $this->productModel->getRecent(5); 
        
        // Get recent orders
        $pedidos = $this->orderModel->getRecent(5); 
        
        include __DIR__ . '/../views/admin/dashboard.php';
    }

    public function task(){
        $task = [
        [
            'id' => 1,
            'title' => 'Atualizar estoque',
        ],
        [
            'id' => 2,
            'title' => 'Verificar pedidos',
            'status' => 'conclusão'
        ],
        [
            'id' => 3,
            'title' => 'Responder mensagens',
            'status' => 'pendente'
        ],
            ];

        include __DIR__ . '/../views/admin/tasks.php';
    }

    public function orders() : void {
        // Obter parâmetros de filtro
        $status = (string)($_GET['status'] ?? '');
        $dateFrom = (string)($_GET['date_from'] ?? '');
        $dataTo = (string)($_GET['date_to'] ?? '');
        $search = (string)($_GET['search'] ?? '');
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Ensure 'page' key is checked
        $perPage = 10;
        
        $pedidos = $this->orderModel->getOrders(
            $status,
            $dateFrom,
            $dataTo,
            $search,
            $page,
            $perPage
        );
        
        // Simulação de paginação
        $totalItems = count($pedidos);
        $totalPages = ceil($totalItems / $perPage);
        $currentPage = min($page, $totalPages);
        
        // Renderizar a view
        include __DIR__ . '/../views/admin/orders.php';
    }

    public function products() : void {
        // Get pagination parameters
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = 10;
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        
        // Use the existing productModel instance that was initialized in the constructor
        $produtos = $this->productModel->getAllProducts($page, $perPage, $search);
        $totalItems = $this->productModel->countProducts($search);
        $totalPages = ceil($totalItems / $perPage);
        $currentPage = min($page, $totalPages);
        
        // Load the view
        include __DIR__ . '/../views/admin/products.php';
    }
    // Display the categories management page
    public function categories() : void {
        // Get pagination parameters
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = 10;
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        
        // Get categories with pagination
        $categorias = $this->categoryModel->getAll($page, $perPage, $search);

        // Count total for pagination
        $totalItems = $this->categoryModel->countAll($search);
        $totalPages = ceil($totalItems / $perPage);
        $currentPage = min($page, $totalPages);
        
        // Load the view
        include __DIR__ . '/../views/admin/categories.php';
    }
    // Display the add category form
    public function addCategory() {
        // Load the category form view
        include __DIR__ . '/../views/admin/category_form.php';
    }
    // Display the edit category form
    public function editCategory() : void {
        if (!isset($_GET['id']) || empty($_GET['id'])) {
            header('Location: index.php?c=admin&a=categories');
            exit;
        }
        
        $id = (int)$_GET['id'];
        $categoria = $this->categoryModel->getById($id);
        
        if (!$categoria) {
            header('Location: index.php?c=admin&a=categories');
            exit;
        }
        
        // Load the category form view
        include __DIR__ . '/../views/admin/category_form.php';
    }
    // Save a new category
    public function saveCategory() : void{
        // Check if form was submitted
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?c=admin&a=categories');
            exit;
        }
        
        // Process image upload if present
        $imagemPath = '';
        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../public/uploads/categories/';
            
            // Create directory if it doesn't exist
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            
            $fileName = time() . '_' . basename($_FILES['imagem']['name']);
            $uploadFile = $uploadDir . $fileName;
            
            if (move_uploaded_file($_FILES['imagem']['tmp_name'], $uploadFile)) {
                $imagemPath = 'public/uploads/categories/' . $fileName;
            }
        }
        
        // Prepare category data
        $categoryData = [
            's_nome_categorias' => (string) ($_POST['nome'] ?? ''),
            's_descricao_categorias' => (string) ($_POST['descricao'] ?? ''),
            's_slug_categorias' => $this->createSlug((string) $_POST['nome'] ?? ''),
            'i_ativo_categorias' => isset($_POST['ativo']) ? 1 : 0,
            's_imagem_categorias' => $imagemPath,
            's_meta_titulo_categorias' => (string) ($_POST['meta_titulo'] ?? ''),
            's_meta_descricao_categorias' => (string) ($_POST['meta_descricao'] ?? '')
        ];
        
        $result = $this->categoryModel->create($categoryData);
        
        if ($result) {
            header('Location: index.php?c=admin&a=categories&success=1');
        } else {
            header('Location: index.php?c=admin&a=addCategory&error=1');
        }
        exit;
    }
    // Update an existing category
    public function updateCategory() : void {
        try {
            $id = isset($_POST['id']) ? (int)$_POST['id'] : null;
            
            if (!$id) {
                header("Location: index.php?c=admin&a=categories&error=1");
                exit;
            }
            
            // Process image upload if present
            $imagemPath = null;
            if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/../../public/uploads/categories/';
                
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                
                $fileName = time() . '_' . basename($_FILES['imagem']['name']);
                $uploadFile = $uploadDir . $fileName;
                
                if (move_uploaded_file($_FILES['imagem']['tmp_name'], $uploadFile)) {
                    $imagemPath = 'public/uploads/categories/' . $fileName;
                }
            }
            
            // Prepare category data with correct field names
            $categoryData = [
                's_nome_categorias' => (string) ($_POST['nome'] ?? ''),
                't_descricao_categorias' => (string) ($_POST['descricao'] ?? ''),
                's_slug_categorias' => $this->createSlug((string)($_POST['nome'] ?? '')),
                'i_ativo_categorias' => isset($_POST['ativo']) ? 1 : 0,
                's_meta_titulo_categorias' => (string) ($_POST['meta_titulo'] ?? ''),
                's_meta_descricao_categorias' => (string) ($_POST['meta_descricao'] ?? '')
            ];
            
            // Add image path only if a new image was uploaded
            if ($imagemPath !== null) {
                $categoryData['s_imagem_categorias'] = $imagemPath;
            }
            
            // Update the category - pass ID and data as separate parameters
            $success = $this->categoryModel->update($id, $categoryData);
            
            if ($success) {
                header("Location: index.php?c=admin&a=categories&success=1");
            } else {
                header("Location: index.php?c=admin&a=categories&error=2");
            }
            exit;
        } catch (\Exception $e) {
            // Log the error
            error_log("Error updating category: " . $e->getMessage());
            header("Location: index.php?c=admin&a=categories&error=3");
            exit;
        }
    }
    // Delete a category
    public function deleteCategory() : void {
        if (!isset($_GET['id']) || empty($_GET['id'])) {
            header('Location: index.php?c=admin&a=categories');
            exit;
        }
        
        $id = (int)$_GET['id'];
        
        // Get category data to check for image
        $category = $this->categoryModel->getById($id);
        
        if ($category) {
            // Delete category image if exists
            if (!empty($category['s_imagem_categorias']) && file_exists(__DIR__ . '/../../' . $category['s_imagem_categorias'])) {
                unlink(__DIR__ . '/../../' . $category['s_imagem_categorias']);
            }
            
            // Delete category
            $result = $this->categoryModel->delete($id);
            
            if ($result) {
                header('Location: index.php?c=admin&a=categories&deleted=1');
            } else {
                header('Location: index.php?c=admin&a=categories&error=1');
            }
        } else {
            header('Location: index.php?c=admin&a=categories');
        }
        exit;
    }
    // Helper method to create a slug from a string
    private function createSlug($string) {
        $string = preg_replace('/[^a-zA-Z0-9\s]/', '', $string);
        $string = strtolower($string);
        $string = str_replace(' ', '-', $string);
        return $string;
    }
    // Display the add product form
    public function addProduct() {
        // Use the existing categoryModel instance that was initialized in the constructor
        $categorias = $this->categoryModel->getAll();
        
        // Load the product form view
        include __DIR__ . '/../views/admin/product_form.php';
    }
    // Display the edit product form
    public function editProduct() {
        if (!isset($_GET['id']) || empty($_GET['id'])) {
            // Redirect to products list if no ID provided
            header('Location: index.php?c=admin&a=products');
            exit;
        }
        
        $id = (int)$_GET['id'];
        
        // Use the existing productModel instance that was initialized in the constructor
        $produto = $this->productModel->getProductById($id);
        
        if (!$produto) {
            // Product not found, redirect to products list
            header('Location: index.php?c=admin&a=products');
            exit;
        }
        
        // Use the existing categoryModel instance that was initialized in the constructor
        $categorias = $this->categoryModel->getAll();
        
        // Load the product form view
        include __DIR__ . '/../views/admin/product_form.php';
    }
    // Save a new product
    public function saveProduct(): void {
        // Check if form was submitted
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?c=admin&a=products');
            exit;
        }
        // Process image upload if present
        $imagemPath = '';
        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../public/uploads/products/';
    
            // Create directory if it doesn't exist
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
    
            $fileName = time() . '_' . basename($_FILES['imagem']['name']);
            $uploadFile = $uploadDir . $fileName;
    
            if (move_uploaded_file($_FILES['imagem']['tmp_name'], $uploadFile)) {
                $imagemPath = 'public/uploads/products/' . $fileName;
            }
        }
    
        // Prepare product data
        $productData = [
            's_nome_produtos' => (string) ($_POST['nome'] ?? ''),
            'i_categoria_id' => (int) ($_POST['categoria_id'] ?? 0),
            'd_preco_produtos' => (float) ($_POST['preco'] ?? 0),
            'i_estoque_produtos' => (int) ($_POST['estoque'] ?? 0),
            't_descricao_produtos' => (string) ($_POST['descricao'] ?? ''),
            'i_destaque_produtos' => isset($_POST['destaque']) ? 1 : 0,
            'i_ativo_produtos' => isset($_POST['ativo']) ? 1 : 0,
            's_meta_titulo_produtos' => (string) ($_POST['meta_titulo'] ?? ''),
            's_meta_descricao_produtos' => (string) ($_POST['meta_descricao'] ?? ''),
            'd_preco_promocional_produtos' => isset($_POST['preco_promocional']) ? (float) $_POST['preco_promocional'] : null,
            'd_promocao_inicio_produtos' => $_POST['promocao_inicio'] ?? null,
            'd_promocao_fim_produtos' => $_POST['promocao_fim'] ?? null,
            's_sku_produtos' => (string) ($_POST['sku'] ?? ''),
            'd_peso_produtos' => (float) ($_POST['peso'] ?? 0),
            'i_estoque_minimo_produtos' => (int) ($_POST['estoque_minimo'] ?? 0)
        ];
    
        // Add image path if uploaded
        if (!empty($imagemPath)) {
            $productData['s_imagem_produtos'] = $imagemPath;
        }
    
        // Save product - pass the correct arguments to addProduct()
        $productId = $this->productModel->addProduct(
            $productData['s_nome_produtos'],
            $productData['t_descricao_produtos'],
            $productData['d_preco_produtos'],
            $productData['i_categoria_id'],
            $productData['s_imagem_produtos']
        );
    
        if ($productId) {
            // Process additional images if any
            if (isset($_FILES['imagens']) && is_array($_FILES['imagens']['name'])) {
                $uploadDir = __DIR__ . '/../../public/uploads/products/';
    
                // Create directory if it doesn't exist
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
    
                foreach ($_FILES['imagens']['name'] as $key => $name) {
                    if ($_FILES['imagens']['error'][$key] === UPLOAD_ERR_OK) {
                        $fileName = time() . '_' . $key . '_' . basename($name);
                        $uploadFile = $uploadDir . $fileName;
    
                        if (move_uploaded_file($_FILES['imagens']['tmp_name'][$key], $uploadFile)) {
                            $imagePath = 'public/uploads/products/' . $fileName;
                            // Add image to product - use addImage() method
                            $this->productModel->addImage($productId, $imagePath);
                        }
                    }
                }
            }
    
            // Success, redirect to products list
            header('Location: index.php?c=admin&a=products&success=1');
        } else {
            // Error, redirect back to form
            header('Location: index.php?c=admin&a=addProduct&error=1');
        }
        exit;
    }
    // Update an existing product
    public function updateProduct(): void {
        // Check if form was submitted
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['id'])) {
            header('Location: index.php?c=admin&a=products');
            exit;
        }
    
        $id = (int)$_POST['id'];
        // Get current product data
        $currentProduct = $this->productModel->getProductById($id);
    
        if (!$currentProduct) {
            header('Location: index.php?c=admin&a=products');
            exit;
        }
    
        // Process image upload if present
        $imagemPath = $currentProduct['s_imagem_produtos'] ?? '';
    
        // Check if image should be removed
        if (isset($_POST['remover_imagem']) && $_POST['remover_imagem'] == '1') {
            $imagemPath = '';
        }
    
        // Process new image upload
        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../public/uploads/products/';
    
            // Create directory if it doesn't exist
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
    
            $fileName = time() . '_' . basename($_FILES['imagem']['name']);
            $uploadFile = $uploadDir . $fileName;
    
            if (move_uploaded_file($_FILES['imagem']['tmp_name'], $uploadFile)) {
                // Delete old image if exists
                if (!empty($imagemPath) && file_exists(__DIR__ . '/../../' . $imagemPath)) {
                    unlink(__DIR__ . '/../../' . $imagemPath);
                }
    
                $imagemPath = 'public/uploads/products/' . $fileName;
            }
        }
    
        // Prepare product data
        $productData = [
            'i_id_produtos' => $id,
            's_nome_produtos' => (string) ($_POST['nome'] ?? ''),
            'i_categoria_id' => (int) ($_POST['categoria_id'] ?? 0),
            'd_preco_produtos' => (float) ($_POST['preco'] ?? 0),
            'i_estoque_produtos' => (int) ($_POST['estoque'] ?? 0),
            't_descricao_produtos' => (string) ($_POST['descricao'] ?? ''),
            'i_destaque_produtos' => isset($_POST['destaque']) ? 1 : 0,
            'i_ativo_produtos' => isset($_POST['ativo']) ? 1 : 0,
            's_meta_titulo_produtos' => (string) ($_POST['meta_titulo'] ?? ''),
            's_meta_descricao_produtos' => (string) ($_POST['meta_descricao'] ?? ''),
            'd_preco_promocional_produtos' => isset($_POST['preco_promocional']) ? (float) $_POST['preco_promocional'] : null,
            'd_promocao_inicio_produtos' => $_POST['promocao_inicio'] ?? null,
            'd_promocao_fim_produtos' => $_POST['promocao_fim'] ?? null,
            's_sku_produtos' => (string) ($_POST['sku'] ?? ''),
            'd_peso_produtos' => (float) ($_POST['peso'] ?? 0),
            'i_estoque_minimo_produtos' => (int) ($_POST['estoque_minimo'] ?? 0),
            's_imagem_produtos' => $imagemPath
        ];
    
        // Update product using the existing productModel instance
        $result = $this->productModel->update($id, $productData); // Changed from updateProduct to update
    
        if ($result) {
            // Success, redirect to products list
            header('Location: index.php?c=admin&a=products&success=1');
        } else {
            // Error, redirect back to form
            header('Location: index.php?c=admin&a=editProduct&id=' . $id . '&error=1');
        }
        exit;
    }
    // Delete a product
    public function deleteProduct() {
        if (!isset($_GET['id']) || empty($_GET['id'])) {
            header('Location: index.php?c=admin&a=products');
            exit;
        }
        
        $id = (int)$_GET['id'];
         
        // Get product data to check for image
        $product = $this->productModel->getProductById($id);
        
        if ($product) {
            // Delete product image if exists
            if (!empty($product['s_imagem_produtos']) && file_exists(__DIR__ . '/../../' . $product['s_imagem_produtos'])) {
                unlink(__DIR__ . '/../../' . $product['s_imagem_produtos']);
            }
            
            // Delete product using the existing productModel instance - use delete() method
            $result = $this->productModel->delete($id);
            
            if ($result) {
                header('Location: index.php?c=admin&a=products&deleted=1');
            } else {
                header('Location: index.php?c=admin&a=products&error=1');
            }
        } else {
            header('Location: index.php?c=admin&a=products');
        }
        exit;
    }  
    public function users() : void {
        // Fetch all users
        $usuarios = $this->userModel->getAll();
    
        // Render the view
        include __DIR__ . '/../views/admin/users.php';
    }
    public function settings() {
        if (!isset($_SESSION['admin_id'])) {
            header('Location: index.php?c=admin&a=login');
            exit;
        }

        include __DIR__ . '/../views/admin/configurations.php';
    }
}
?>

