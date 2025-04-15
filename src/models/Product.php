<?php

namespace Aydom\Ecomerce\Models;

class Product {
    private $conn;
    private $debug = true;

    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    /**
     * Get featured products
     * 
     * @param int $limit Number of products to return
     * @return array Array of featured products
     */
    public function getFeatured($limit = 5) {
        try {
            $sql = "SELECT * FROM produtos WHERE i_destaque_produtos = 1 AND i_ativo_produtos = 1 ORDER BY i_id_produtos DESC LIMIT :limit";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            if ($this->debug) {
                error_log("Error in getFeatured(): " . $e->getMessage());
            }
            return [];
        }
    }
    
    /**
     * Get best selling products
     * 
     * @param int $limit Number of products to return
     * @return array Array of best selling products
     */
    public function getBestSellers($limit = 8) {
        try {
            // This would typically join with an orders table to get actual best sellers
            // For now, we'll simulate with a simple query
            $sql = "SELECT * FROM produtos WHERE i_ativo_produtos = 1 ORDER BY i_vendas_produtos DESC LIMIT :limit";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            if ($this->debug) {
                error_log("Error in getBestSellers(): " . $e->getMessage());
            }
            return [];
        }
    }
    
    /**
     * Get recommended products (could be personalized in the future)
     * 
     * @param int $limit Number of products to return
     * @return array Array of recommended products
     */
    public function getRecommended($limit = 5) {
        try {
            // For now, just return random active products
            $sql = "SELECT * FROM produtos WHERE i_ativo_produtos = 1 ORDER BY RAND() LIMIT :limit";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            if ($this->debug) {
                error_log("Error in getRecommended(): " . $e->getMessage());
            }
            return [];
        }
    }
    
    /**
     * Get a product by ID
     * 
     * @param int $id Product ID
     * @return array|false Product data or false if not found
     */
    public function getById($id) {
        try {
            $sql = "SELECT * FROM produtos WHERE i_id_produtos = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            if ($this->debug) {
                error_log("Error in getById(): " . $e->getMessage());
            }
            return false;
        }
    }
    
    /**
     * Get all active products
     * 
     * @param int $limit Optional limit of products to return
     * @param int $offset Optional offset for pagination
     * @return array Array of products
     */
    public function getAll($limit = null, $offset = null) {
        try {
            $sql = "SELECT * FROM produtos WHERE i_ativo_produtos = 1 ORDER BY i_id_produtos DESC";
            
            // Add limit and offset if provided
            if ($limit !== null) {
                $sql .= " LIMIT :limit";
                if ($offset !== null) {
                    $sql .= " OFFSET :offset";
                }
            }
            
            $stmt = $this->conn->prepare($sql);
            
            // Bind limit and offset if provided
            if ($limit !== null) {
                $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
                if ($offset !== null) {
                    $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
                }
            }
            
            $stmt->execute();
            
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            if ($this->debug) {
                error_log("Error in getAll(): " . $e->getMessage());
            }
            return [];
        }
    }
    
    /**
     * Count all products in the database
     * 
     * @return int The total number of products
     */
    public function countAll(): int
    {
        $sql = "SELECT COUNT(*) as total FROM produtos";
        $stmt = $this->conn->prepare($sql); // Changed $db to $conn
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC); // Added backslash
        
        return (int) $result['total'];
    }
    
    /**
     * Log debug messages if debug is enabled
     * 
     * @param string $message Debug message
     * @return void
     */
    private function logDebug($message) {
        if ($this->debug) {
            error_log($message);
        }
    }
    
    /**
     * Get the most recent products
     * 
     * @param int $limit The maximum number of products to return
     * @return array The list of recent products
     */
    public function getRecent(int $limit = 5): array
    {
        try {
            $sql = "SELECT p.i_id_produtos, p.s_nome_produtos, p.s_imagem_produtos, 
                       p.d_preco_produtos, p.i_estoque_produtos as i_estoque, c.s_nome_categorias
                FROM produtos p
                LEFT JOIN categorias c ON p.i_categoria_id = c.i_id_categorias
                ORDER BY p.i_id_produtos DESC
                LIMIT :limit";
                
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            // Log the error
            error_log("Error in getRecent(): " . $e->getMessage());
            // Return empty array if there's an error
            return [];
        }
    }
    
    /**
     * Get all products with pagination and search
     * 
     * @param int $page Current page number
     * @param int $perPage Items per page
     * @param string $search Search term
     * @return array Array of products
     */
    public function getAllProducts($page = 1, $perPage = 10, $search = '') {
        try {
            $offset = ($page - 1) * $perPage;
            
            $sql = "SELECT p.*, c.s_nome_categorias 
                    FROM produtos p
                    LEFT JOIN categorias c ON p.i_categoria_id = c.i_id_categorias
                    WHERE 1=1";
            
            $params = [];
            
            // Add search condition if search term is provided
            if (!empty($search)) {
                $sql .= " AND (p.s_nome_produtos LIKE :search 
                          OR p.t_descricao_produtos LIKE :search 
                          OR p.s_sku_produtos LIKE :search)";
                $params[':search'] = '%' . $search . '%';
            }
            
            $sql .= " ORDER BY p.i_id_produtos DESC LIMIT :limit OFFSET :offset";
            
            $stmt = $this->conn->prepare($sql);
            
            // Bind search parameter if exists
            if (!empty($search)) {
                $stmt->bindValue(':search', $params[':search'], \PDO::PARAM_STR);
            }
            
            $stmt->bindValue(':limit', $perPage, \PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            if ($this->debug) {
                error_log("Error in getAllProducts(): " . $e->getMessage());
            }
            return [];
        }
    }
    
    /**
     * Count products with search filter
     * 
     * @param string $search Search term
     * @return int Number of products matching the search
     */
    public function countProducts($search = '') {
        try {
            $sql = "SELECT COUNT(*) as total FROM produtos WHERE 1=1";
            $params = [];
            
            // Add search condition if search term is provided
            if (!empty($search)) {
                $sql .= " AND (s_nome_produtos LIKE :search 
                          OR t_descricao_produtos LIKE :search 
                          OR s_sku_produtos LIKE :search)";
                $params[':search'] = '%' . $search . '%';
            }
            
            $stmt = $this->conn->prepare($sql);
            
            // Bind search parameter if exists
            if (!empty($search)) {
                $stmt->bindValue(':search', $params[':search'], \PDO::PARAM_STR);
            }
            
            $stmt->execute();
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            
            return (int) $result['total'];
        } catch (\PDOException $e) {
            if ($this->debug) {
                error_log("Error in countProducts(): " . $e->getMessage());
            }
            return 0;
        }
    }
    
    /**
     * Add a new product to the database
     * 
     * @param string $nome Product name
     * @param string $descricao Product description
     * @param float $preco Product price
     * @param int|null $id_categorias Category ID
     * @param string|null $image Image path
     * @return int|false The ID of the newly created product or false on failure
     */
    public function addProduct($nome, $descricao, $preco, $id_categorias = null, $image = null) {
        try {
            // Validate inputs
            if (empty($nome) || empty($descricao) || $preco <= 0) {
                throw new \InvalidArgumentException("Invalid product data.");
            }

            $sql = "INSERT INTO produtos (s_nome_produtos, t_descricao_produtos, d_preco_produtos, i_categoria_id, s_imagem_produtos) 
                    VALUES (:nome, :descricao, :preco, :id_categorias, :image)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':nome', htmlspecialchars($nome), \PDO::PARAM_STR);
            $stmt->bindValue(':descricao', htmlspecialchars($descricao), \PDO::PARAM_STR);
            $stmt->bindValue(':preco', $preco, \PDO::PARAM_STR);
            $stmt->bindValue(':id_categorias', $id_categorias, \PDO::PARAM_INT);
            $stmt->bindValue(':image', htmlspecialchars($image), \PDO::PARAM_STR);
            $stmt->execute();

            return $this->conn->lastInsertId();
        } catch (\PDOException $e) {
            if ($this->debug) {
                error_log("Error in addProduct(): " . $e->getMessage());
            }
            return false;
        } catch (\InvalidArgumentException $e) {
            if ($this->debug) {
                error_log("Validation error in addProduct(): " . $e->getMessage());
            }
            return false;
        }
    }
}
?>