<?php
<<<<<<< HEAD
namespace Aydom\Ecomerce\Controllers;
use Aydom\Ecomerce\Models\Product;

class ProductController {
    private $productModel;

    public function __construct($conn){
        $this->productModel = new Product($conn);
    }

    public function list(){
        try{
            $filters = [];
            if(isset($_GET['categorias'])){
                $filters['i_id_categorias'] = $_GET['categorias'];
            }

            if(isset($_GET['search'])){
                $filters['search'] = $_GET['search'];
            }

            $produtos = $this->productModel->getAll($filters);

            // Renderizar a view
            include __DIR__ . '/../views/product/list.php';

        }catch(\Exception $e){
            echo "Erro ao listar produtos: " . $e->getMessage();
        }
    }

    public function detal($id){
        try{
            $produtos = $this->productModel->getById($id);
            if(!$produtos){
                header("Location: index.php?c=product&a=list");
                exit;
            }

            // Buscar imahens do produto
            $imagens = $this->productModel->getImages($id);
            // Renderizar a view
            include __DIR__ . '/../views/product/detail.php';
        }catch(\Exception $e){
            echo "Erro ao detalhar produto: ". $e->getMessage();
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
=======
namespace App\Controllers; 

class ProductController {
    public function list(){
        include __DIR__ . '/../../src/views/product/list.php';
>>>>>>> 63ba0037a64ef6dc88e139907ce4a86d1a6133b6
    }
}