<?php
namespace Aydom\Ecomerce\Controllers;

use Aydom\Ecomerce\Models\Product;
use Aydom\Ecomerce\Models\Category;

class ProductController {
    private $conn;
    private $productModel;
    private $categoryModel;

    public function __construct($conn) {
        $this->conn = $conn;
        $this->productModel = new Product($conn);
        $this->categoryModel = new Category($conn); 
    }

    public function list() {
        // Obter filtros da URL
        $filters = [];
        
        if (isset($_GET['categorias'])) {
            $filters['i_id_categorias'] = $_GET['categorias'];
        }
        
        if (isset($_GET['search'])) {
            $filters['search'] = $_GET['search'];
        }
        
        if (isset($_GET['min_price'])) {
            $filters['min_price'] = $_GET['min_price'];
        }
        
        if (isset($_GET['max_price'])) {
            $filters['max_price'] = $_GET['max_price'];
        }
        
        // Obter ordenação
        $sort = $_GET['sort'] ?? 'name_asc';
        
        // Obter produtos com filtros
        $produtos = $this->productModel->getAll($filters, $sort);
        
        // Obter todas as categorias para o filtro
        $categorias = $this->categoryModel->getAll();
        
        // Incluir a view
        include __DIR__ . '/../views/product/list.php';
    }
    
    public function detail() {
        try {
            // Get product ID from URL
            $id = isset($_GET['id']) ? $_GET['id'] : null;
            
            if (!$id) {
                header("Location: index.php?c=product&a=list");
                exit;
            }
            
            // Get product details
            $produto = $this->productModel->getById($id);
            
            if (!$produto) {
                header("Location: index.php?c=product&a=list");
                exit;
            }
            
            // Get product images
            $imagens = $this->productModel->getImages($id);
            
            // Get related products (optional)
            $categoria_id = $produto['i_id_categorias'] ?? null;
            $produtos_relacionados = [];
            
            if ($categoria_id) {
                // Get products from the same category, excluding the current product
                $filters = ['i_id_categorias' => $categoria_id];
                $related = $this->productModel->getAll($filters);
                
                // Filter out the current product
                foreach ($related as $rel) {
                    if ($rel['i_id_produtos'] != $id) {
                        $produtos_relacionados[] = $rel;
                    }
                    
                    // Limit to 4 related products
                    if (count($produtos_relacionados) >= 4) {
                        break;
                    }
                }
            }
            
            // Render the view
            include __DIR__ . '/../views/product/detail.php';
            
        } catch (\Exception $e) {
            echo "Erro ao exibir detalhes do produto: " . $e->getMessage();
        }
    }

    public function add(){
        try{
            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                $nome = $_POST['nome'];
                $descricao = $_POST['descricao'];
                $preco = $_POST['preco'];
                $id_categorias = $_POST['id_categorias'] ?? null; 

                $image = '';
                if(isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK){
                   $uploadDir = __DIR__. '/../../public/uploads/products/';

                   if(!is_dir($uploadDir)){
                    mkdir($uploadDir, 0777, true);
                   }

                   $fileName = time() . '_' . basename($_FILES['image']['name']);
                   $uploadFile = $uploadDir. $fileName;

                   if(move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)){
                    $image = '/uploads/products/' . $fileName;
                   }
                }

                // criar produto
                if($productId && isset($_FILE['image'])){
                    foreach($_FILES['image']['tmp_name'] as $key => $tmpName){
                        if($_FILES['image']['error'][$key] === UPLOAD_ERR_OK){
                            $fileName = time(). '_'. basename($_FILES['image']['name'][$key]);
                            $uploadFile = $uploadDir. $fileName; 
                        }

                        if(move_uploaded_file($tmpName, $uploadFile)){
                            $image = '/uploads/products/'. $fileName;
                            $this->productModel->addImage($productId, $image);
                        }
                    }
                }  
             }

            // Renderizar a view
            include __DIR__. '/../views/product/add.php';
            exit;

        }catch(\Exception $e){
            echo "Erro ao detalhar produto: ". $e->getMessage();
        }
       
    }

    public function edit($id){
        try{
          $product = $this->productModel->getById($id);
          if(!$product){
            header("Location: index.php?c=product&a=list");
            exit;
          }  

          // Buscar imagens do produto
          $images = $this->productModel->getImages($id);

          // Verificar se é uma requisição POST
          if($_SERVER['REQUEST_METHOD'] === 'POST'){
              // validando os dados
              $nome = $_POST['nome'];
              $descricao = $_POST['descricao'];
              $preco = $_POST['preco'];
              $id_categorias = $_POST['id_categorias']?? null;
              $image = $product['image']?? null;

              // Upload de imagem
              if(isset($_FILES['image']) && $_FILES['image'] ['error'] === UPLOAD_ERR_OK){
                $uploadDir = __DIR__ . '/../../public/uploads/products/';

                if(!is_dir($uploadDir)){
                    mkdir($uploadDir, 0777, true);
                }

                $fileName = time(). '_'. basename($_FILES['image']['name']);
                $uploadFile = $uploadDir. $fileName;

                if(move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)){
                    $image = '/uploads/products/'. $fileName;
                }

                // Atualizar producto
                $this->productModel->update($id,[
                    'nome' => $nome,
                    'descricao' => $descricao,
                    'preco' => $preco,
                    'id_categorias' => $id_categorias,
                    'image' => $image,
                    'category_id' => $categoria_id
                ] );

                // Upload de imagens adicionais
                if(isset($_FILES['image'])){
                    foreach($_FILES['image']['tmp_name'] as $key => $tmpName){
                        if($_FILES['image']['error'][$key] === UPLOAD_ERR_OK){
                            $fileName = time(). '_'. basename($_FILES['image']['name'][$key]);
                            $uploadFile = $uploadDir. $fileName; 

                            if(move_uploaded_file($tmpName, $uploadFile)){
                                $image = '/uploads/products/'. $fileName;
                                $this->productModel->addImage($id, $image);
                            }
                        } 
                    }  
                }
                header("Location: index.php?c=product&a=list");
                exit; 
              }

              // Renderizar formulário
              include __DIR__ . '/../views/product/form.php';
          }
        } catch(\Exception $e){
            echo "Erro ao detalhar produto: ". $e->getMessage();
        }
    }

    public function delete($id){
        try{
            $this->productModel->delete($id);
            header("Location: index.php?c=product&a=list");
            exit;
        }catch(\Exception $e){
            echo "Erro ao detalhar produto: ". $e->getMessage();
        }

        // Renderizar confirmação
        include __DIR__ . '/../views/product/delete.php';
    }
}