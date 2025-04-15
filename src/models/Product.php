<?php

namespace Aydom\Ecomerce\Models;

use PDO;

class Product {
    private PDO $conn; // Tipagem da propriedade
    private bool $debug = true; // Tipagem da propriedade

    public function __construct(PDO $conn) { // Tipagem do parâmetro
        $this->conn = $conn;
    }

    /**
     * Get featured products
     *
     * @param int $limit Number of products to return
     * @return array Array of featured products
     */
    public function getFeatured(int $limit = 5): array // Tipagem do parâmetro e do retorno
    {
        try {
            $sql = "SELECT * FROM produtos WHERE i_destaque_produtos = 1 AND i_ativo_produtos = 1 ORDER BY i_id_produtos DESC LIMIT :limit";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) { // Tipagem da exceção
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
    public function getBestSellers(int $limit = 8): array // Tipagem do parâmetro e do retorno
    {
        try {
            // This would typically join with an orders table to get actual best sellers
            // For now, we'll simulate with a simple query
            $sql = "SELECT * FROM produtos WHERE i_ativo_produtos = 1 ORDER BY i_vendas_produtos DESC LIMIT :limit";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) { // Tipagem da exceção
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
    public function getRecommended(int $limit = 5): array // Tipagem do parâmetro e do retorno
    {
        try {
            // For now, just return random active products
            $sql = "SELECT * FROM produtos WHERE i_ativo_produtos = 1 ORDER BY RAND() LIMIT :limit";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) { // Tipagem da exceção
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
    public function getById(int $id): ?array // Tipagem do parâmetro e do retorno
    {
        try {
            $sql = "SELECT * FROM produtos WHERE i_id_produtos = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ?: null; // Retorna null se não encontrado
        } catch (PDOException $e) { // Tipagem da exceção
            if ($this->debug) {
                error_log("Error in getById(): " . $e->getMessage());
            }
            return null;
        }
    }

    /**
     * Get all active products
     *
     * @param array $filters Array of filters (e.g., ['i_id_categorias' => 1, 'min_price' => 10])
     * @param string $sort Sorting option (e.g., 'name_asc', 'price_desc')
     * @return array Array of products
     */
    public function getAll(array $filters = [], string $sort = 'i_id_produtos DESC'): array // Tipagem dos parâmetros e do retorno
    {
        try {
            $sql = "SELECT * FROM produtos WHERE i_ativo_produtos = 1";
            $params = [];

            foreach ($filters as $key => $value) {
                if ($key === 'i_id_categorias') {
                    $sql .= " AND i_categoria_id = :i_id_categorias";
                    $params[':i_id_categorias'] = $value;
                } elseif ($key === 'min_price') {
                    $sql .= " AND d_preco_produtos >= :min_price";
                    $params[':min_price'] = $value;
                } elseif ($key === 'max_price') {
                    $sql .= " AND d_preco_produtos <= :max_price";
                    $params[':max_price'] = $value;
                } elseif ($key === 'search') {
                    $sql .= " AND (s_nome_produtos LIKE :search OR t_descricao_produtos LIKE :search)";
                    $params[':search'] = '%' . $value . '%';
                }
            }

            $sql .= " ORDER BY " . $this->mapSortToColumn($sort);

            $stmt = $this->conn->prepare($sql);

            foreach ($params as $param => &$val) {
                $stmt->bindParam($param, $val);
            }

            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) { // Tipagem da exceção
            if ($this->debug) {
                error_log("Error in getAll(): " . $e->getMessage());
            }
            return [];
        }
    }

    /**
     * Maps the sort option to the database column
     *
     * @param string $sort The sort option
     * @return string The database column to sort by
     */
    private function mapSortToColumn(string $sort): string
    {
        switch ($sort) {
            case 'name_asc':
                return 's_nome_produtos ASC';
            case 'name_desc':
                return 's_nome_produtos DESC';
            case 'price_asc':
                return 'd_preco_produtos ASC';
            case 'price_desc':
                return 'd_preco_produtos DESC';
            default:
                return 'i_id_produtos DESC';
        }
    }

    /**
     * Count all products in the database
     *
     * @return int The total number of products
     */
    public function countAll(): int // Tipagem do retorno
    {
        $sql = "SELECT COUNT(*) as total FROM produtos";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return (int) $result['total'];
    }

    /**
     * Log debug messages if debug is enabled
     *
     * @param string $message Debug message
     * @return void
     */
    private function logDebug(string $message): void // Tipagem do parâmetro e do retorno
    {
        if ($this->debug) {
            error_log($message);
        }
    }
    /** 
     * @param int $limit The maximum number of products to return
     * @return array The list of recent products
     */
    public function getRecent($limit) {
        $sql = "SELECT produtos.*, categorias.s_nome_categorias
                FROM produtos
                JOIN categorias ON produtos.categoria_id = categorias.i_id_categorias
                WHERE categorias.i_ativo_categorias = 1
                ORDER BY produtos.created_at DESC
                LIMIT :limit";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get all products with pagination and search
     *
     * @param int $page Current page number
     * @param int $perPage Items per page
     * @param string $search Search term
     * @return array Array of products
     */
    public function getAllProducts(int $page = 1, int $perPage = 10, string $search = ''): array // Tipagem dos parâmetros e do retorno
    {
        try {
            $offset = ($page - 1) * $perPage;

            $sql = "SELECT p.*, c.s_nome_categorias
                          FROM produtos p
                          LEFT JOIN categorias c ON p.categoria_id = c.i_id_categorias
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
                $stmt->bindValue(':search', $params[':search'], PDO::PARAM_STR);
            }

            $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) { // Tipagem da exceção
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
    public function countProducts(string $search = ''): int // Tipagem do parâmetro e do retorno
    {
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
                $stmt->bindValue(':search', $params[':search'], PDO::PARAM_STR);
            }

            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return (int) $result['total'];
        } catch (PDOException $e) { // Tipagem da exceção
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
    public function create(string $nome, string $descricao, float $preco, ?int $id_categorias = null, ?string $image = null): ?int // Tipagem dos parâmetros e do retorno
    {
        try {
            // Validate inputs
            if (empty($nome) || empty($descricao) || $preco <= 0) {
                throw new \InvalidArgumentException("Invalid product data.");
            }

            $sql = "INSERT INTO produtos (s_nome_produtos, t_descricao_produtos, d_preco_produtos, i_categoria_id, s_imagem_produtos)
                          VALUES (:nome, :descricao, :preco, :id_categorias, :image)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':nome', htmlspecialchars($nome), PDO::PARAM_STR);
            $stmt->bindValue(':descricao', htmlspecialchars($descricao), PDO::PARAM_STR);
            $stmt->bindValue(':preco', $preco, PDO::PARAM_STR);
            $stmt->bindValue(':id_categorias', $id_categorias, PDO::PARAM_INT);
            $stmt->bindValue(':image', htmlspecialchars($image), PDO::PARAM_STR);
            $stmt->execute();

            return (int) $this->conn->lastInsertId();
        } catch (PDOException $e) { // Tipagem da exceção
            if ($this->debug) {
                error_log("Error in addProduct(): " . $e->getMessage());
            }
            return null;
        } catch (\InvalidArgumentException $e) { // Tipagem da exceção
            if ($this->debug) {
                error_log("Validation error in addProduct(): " . $e->getMessage());
            }
            return null;
        }
    }

    public function update(int $id, array $data): bool // Tipagem dos parâmetros e do retorno
    {
        try {
            $sql = "UPDATE produtos SET
                    s_nome_produtos = :nome,
                    t_descricao_produtos = :descricao,
                    d_preco_produtos = :preco,
                    i_categoria_id = :id_categorias,
                    s_imagem_produtos = :image
                WHERE i_id_produtos = :id";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':nome', htmlspecialchars($data['nome']), PDO::PARAM_STR);
            $stmt->bindValue(':descricao', htmlspecialchars($data['descricao']), PDO::PARAM_STR);
            $stmt->bindValue(':preco', $data['preco'], PDO::PARAM_STR);
            $stmt->bindValue(':id_categorias', $data['id_categorias'] ?? null, PDO::PARAM_INT);
            $stmt->bindValue(':image', htmlspecialchars($data['image']) ?? null, PDO::PARAM_STR);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            if ($this->debug) {
                error_log("Error in update(): " . $e->getMessage());
            }
            return false;
        }
    }

    public function addImage(int $productId, string $imagePath): bool // Tipagem dos parâmetros e do retorno
    {
        try {
            $sql = "INSERT INTO produto_imagens (i_produto_id, s_path_imagem) VALUES (:produto_id, :path)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':produto_id', $productId, PDO::PARAM_INT);
            $stmt->bindValue(':path', htmlspecialchars($imagePath), PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            if ($this->debug) {
                error_log("Error in addImage(): " . $e->getMessage());
            }
            return false;
        }
    }

    public function getImages(int $productId): array // Tipagem do parâmetro e do retorno
    {
        try {
            $sql = "SELECT s_path_imagem FROM produto_imagens WHERE i_produto_id = :produto_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':produto_id', $productId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_COLUMN);
        } catch (PDOException $e) {
            if ($this->debug) {
                error_log("Error in getImages(): " . $e->getMessage());
            }
            return [];
        }
    }

    public function delete(int $id): bool // Tipagem do parâmetro e do retorno
    {
        try {
            // First, delete related images
            $sqlDeleteImages = "DELETE FROM produto_imagens WHERE i_produto_id = :id";
            $stmtDeleteImages = $this->conn->prepare($sqlDeleteImages);
            $stmtDeleteImages->bindValue(':id', $id, PDO::PARAM_INT);
            $stmtDeleteImages->execute();

            // Then, delete the product
            $sqlDeleteProduct = "DELETE FROM produtos WHERE i_id_produtos = :id";
            $stmtDeleteProduct = $this->conn->prepare($sqlDeleteProduct);
            $stmtDeleteProduct->bindValue(':id', $id, PDO::PARAM_INT);
            $stmtDeleteProduct->execute();

            return $stmtDeleteProduct->rowCount() > 0;
        } catch (PDOException $e) {
            if ($this->debug) {
                error_log("Error in delete(): " . $e->getMessage());
            }
            return false;
        }
    }
}
?>