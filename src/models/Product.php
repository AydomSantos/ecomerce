<?php

namespace Aydom\Ecomerce\Models;

class Product {
    private $conn;
    private $debug = true; 

    public function __construct($conn) {
        $this->conn = $conn;
        $this->logDebug("Conexão inicializada no construtor Product");
    }

    // Função auxiliar para debug
    private function logDebug($message) {
        if ($this->debug) {
            echo "<pre>[DEBUG] " . date('Y-m-d H:i:s') . " - " . $message . "</pre>";
        }
    }

    public function getAll($filters = []) {
        $this->logDebug("Iniciando getAll() com filtros: " . json_encode($filters));
        
        // Corrigindo a consulta SQL - faltava WHERE antes dos ANDs
        $sql = "SELECT * FROM produtos WHERE 1=1";
        
        if (!empty($filters['categoria_id'])) {
            $sql .= " AND categoria_id = :categoria_id";
        }

        if (!empty($filters['marca_id'])) {
            $sql .= " AND marca_id = :marca_id";
        }

        if (!empty($filters['search'])) {
            $sql .= " AND (s_nome_produtos LIKE :search OR t_descricao_produtos LIKE :search)";
        }

        // Ordenação
        $sql .= " ORDER BY created_at DESC";
        $this->logDebug("SQL construído: " . $sql);
        
        $stmt = $this->conn->prepare($sql);

        // Bind dos parâmetros - corrigindo o erro de digitação em "empy" e referência incorreta a $this->filters
        if (!empty($filters['categoria_id'])) {
            $stmt->bindValue(':categoria_id', $filters['categoria_id'], \PDO::PARAM_INT);
        }
        
        if (!empty($filters['marca_id'])) {
            $stmt->bindValue(':marca_id', $filters['marca_id'], \PDO::PARAM_INT);
        }
        
        if (!empty($filters['search'])) {
            $stmt->bindValue(':search', '%' . $filters['search'] . '%', \PDO::PARAM_STR);
        }
        
        try {
            $stmt->execute();
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            $this->logDebug("getAll() retornou " . count($result) . " registros");
            return $result;
        } catch (\PDOException $e) {
            $this->logDebug("Erro em getAll(): " . $e->getMessage());
            return [];
        }
    }

    public function getById($id) {
        $this->logDebug("Buscando produto com ID: " . $id);
        
        try {
            $sql = "SELECT * FROM produtos WHERE i_id_produtos = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            
            if ($result) {
                $this->logDebug("Produto encontrado: " . json_encode($result));
            } else {
                $this->logDebug("Produto não encontrado");
            }
            
            return $result;
        } catch (\PDOException $e) {
            $this->logDebug("Erro em getById(): " . $e->getMessage());
            return false;
        }
    }

    public function create($data) {
        $this->logDebug("Criando produto com dados: " . json_encode($data));
        
        try {
            $sql = "INSERT INTO produtos (s_nome_produtos, t_descricao_produtos, d_preco_produtos, i_estoque_produtos, categoria_id) 
                    VALUES (:nome, :descricao, :preco, :estoque, :categoria_id)";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':nome', $data['nome'], \PDO::PARAM_STR);
            $stmt->bindValue(':descricao', $data['descricao'], \PDO::PARAM_STR);
            $stmt->bindValue(':preco', $data['preco'], \PDO::PARAM_STR);
            $stmt->bindValue(':estoque', $data['estoque'], \PDO::PARAM_INT);
            $stmt->bindValue(':categoria_id', $data['categoria_id'], \PDO::PARAM_INT);
            
            $stmt->execute();
            $lastId = $this->conn->lastInsertId();
            $this->logDebug("Produto criado com ID: " . $lastId);
            return $lastId;
        } catch (\PDOException $e) {
            $this->logDebug("Erro em create(): " . $e->getMessage());
            return false;
        }
    }

    public function update($id, $data) {
        $this->logDebug("Atualizando produto ID: " . $id . " com dados: " . json_encode($data));
        
        try {
            $sql = "UPDATE produtos SET 
                    s_nome_produtos = :nome, 
                    t_descricao_produtos = :descricao, 
                    d_preco_produtos = :preco, 
                    i_estoque_produtos = :estoque, 
                    categoria_id = :categoria_id 
                    WHERE i_id_produtos = :id";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
            $stmt->bindValue(':nome', $data['nome'], \PDO::PARAM_STR);
            $stmt->bindValue(':descricao', $data['descricao'], \PDO::PARAM_STR);
            $stmt->bindValue(':preco', $data['preco'], \PDO::PARAM_STR);
            $stmt->bindValue(':estoque', $data['estoque'], \PDO::PARAM_INT);
            $stmt->bindValue(':categoria_id', $data['categoria_id'], \PDO::PARAM_INT);
            
            $result = $stmt->execute();
            $this->logDebug("Atualização " . ($result ? "bem-sucedida" : "falhou"));
            return $result;
        } catch (\PDOException $e) {
            $this->logDebug("Erro em update(): " . $e->getMessage());
            return false;
        }
    }

    public function delete($id) {
        $this->logDebug("Excluindo produto ID: " . $id);
        
        try {
            $stmt = $this->conn->prepare("DELETE FROM produtos WHERE i_id_produtos = :id");
            $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
            $result = $stmt->execute();
            $this->logDebug("Exclusão " . ($result ? "bem-sucedida" : "falhou"));
            return $result;
        } catch (\PDOException $e) {
            $this->logDebug("Erro em delete(): " . $e->getMessage());
            return false;
        }
    }

    public function getImages($productId) {
        $this->logDebug("Buscando imagens para o produto ID: " . $productId);
        
        try {
            $stmt = $this->conn->prepare("SELECT * FROM product_images WHERE produto_id = :product_id");
            $stmt->bindValue(':product_id', $productId, \PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            $this->logDebug("Encontradas " . count($result) . " imagens");
            return $result;
        } catch (\PDOException $e) {
            $this->logDebug("Erro em getImages(): " . $e->getMessage());
            return [];
        }
    }

    public function addImage($productId, $imagePath, $isMain = 0) {
        $this->logDebug("Adicionando imagem para produto ID: " . $productId . ", caminho: " . $imagePath);
        
        try {
            $sql = "INSERT INTO product_images (produto_id, image_path, is_main) VALUES (:product_id, :image_path, :is_main)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':product_id', $productId, \PDO::PARAM_INT);
            $stmt->bindValue(':image_path', $imagePath, \PDO::PARAM_STR);
            $stmt->bindValue(':is_main', $isMain, \PDO::PARAM_INT);
            $result = $stmt->execute();
            $this->logDebug("Adição de imagem " . ($result ? "bem-sucedida" : "falhou"));
            return $result;
        } catch (\PDOException $e) {
            $this->logDebug("Erro em addImage(): " . $e->getMessage());
            return false;
        }
    }
}
?>