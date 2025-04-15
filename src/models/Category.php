<?php

namespace Aydom\Ecomerce\Models;

class Category {
    private $conn;
    private $debug = true;

    public function __construct($conn) {
        $this->conn = $conn;
        $this->logDebug("Conexão inicializada no construtor Category");
    }

    // Função auxiliar para debug
    private function logDebug($message) {
        if ($this->debug) {
            echo "<pre>[DEBUG] " . date('Y-m-d H:i:s') . " - " . $message . "</pre>";
        }
    }

    // Add countAll method to support pagination in the categories page
    public function countAll($search = '') {
        $this->logDebug("Contando categorias" . ($search ? " com filtro: $search" : ""));
        
        try {
            $sql = "SELECT COUNT(*) FROM categorias";
            $params = [];
            
            if (!empty($search)) {
                $sql .= " WHERE s_nome_categorias LIKE :search";
                $params[':search'] = "%$search%";
            }
            
            $stmt = $this->conn->prepare($sql);
            
            foreach ($params as $param => $value) {
                $stmt->bindValue($param, $value);
            }
            
            $stmt->execute();
            $count = $stmt->fetchColumn();
            
            $this->logDebug("Total de categorias encontradas: $count");
            return $count;
        } catch (\PDOException $e) {
            $this->logDebug("Erro em countAll(): " . $e->getMessage());
            return 0;
        }
    }
    
    // Add pagination support to getAll method
    public function getAll($page = null, $perPage = null, $search = '') {
        $this->logDebug("Iniciando getAll() em Category" . 
                       ($page !== null ? " (página $page, $perPage por página)" : "") . 
                       ($search ? ", filtro: $search" : ""));
        
        try {
            $sql = "SELECT * FROM categorias";
            $params = [];
            
            if (!empty($search)) {
                $sql .= " WHERE s_nome_categorias LIKE :search";
                $params[':search'] = "%$search%";
            }
            
            $sql .= " ORDER BY s_nome_categorias ASC";
            
            // Add pagination if requested
            if ($page !== null && $perPage !== null) {
                $offset = ($page - 1) * $perPage;
                $sql .= " LIMIT :limit OFFSET :offset";
                $params[':limit'] = $perPage;
                $params[':offset'] = $offset;
            }
            
            $stmt = $this->conn->prepare($sql);
            
            // Bind parameters
            foreach ($params as $param => $value) {
                if ($param == ':limit' || $param == ':offset') {
                    $stmt->bindValue($param, $value, \PDO::PARAM_INT);
                } else {
                    $stmt->bindValue($param, $value);
                }
            }
            
            $stmt->execute();
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            $this->logDebug("getAll() retornou " . count($result) . " categorias");
            return $result;
        } catch (\PDOException $e) {
            $this->logDebug("Erro em getAll(): " . $e->getMessage());
            return [];
        }
    }

    public function getById($id) {
        $this->logDebug("Buscando categoria com ID: " . $id);
        
        try {
            $sql = "SELECT * FROM categorias WHERE i_id_categorias = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            
            if ($result) {
                $this->logDebug("Categoria encontrada: " . json_encode($result));
            } else {
                $this->logDebug("Categoria não encontrada");
            }
            
            return $result;
        } catch (\PDOException $e) {
            $this->logDebug("Erro em getById(): " . $e->getMessage());
            return false;
        }
    }

    public function create($data) {
        $this->logDebug("Criando categoria com dados: " . json_encode($data));
        
        try {
            $sql = "INSERT INTO categorias (s_nome_categorias, t_descricao_categorias) 
                    VALUES (:nome, :descricao)";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':nome', $data['nome'], \PDO::PARAM_STR);
            $stmt->bindValue(':descricao', $data['descricao'] ?? '', \PDO::PARAM_STR);
            
            $stmt->execute();
            $lastId = $this->conn->lastInsertId();
            $this->logDebug("Categoria criada com ID: " . $lastId);
            return $lastId;
        } catch (\PDOException $e) {
            $this->logDebug("Erro em create(): " . $e->getMessage());
            return false;
        }
    }

    public function update($id, $data) {
        $this->logDebug("Atualizando categoria ID: " . $id . " com dados: " . json_encode($data));
        
        try {
            $sql = "UPDATE categorias SET 
                    s_nome_categorias = :nome, 
                    t_descricao_categorias = :descricao
                    WHERE i_id_categorias = :id";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':nome', $data['nome'], \PDO::PARAM_STR);
            $stmt->bindValue(':descricao', $data['descricao'] ?? '', \PDO::PARAM_STR);
            $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
            
            $stmt->execute();
            $this->logDebug("Categoria atualizada com sucesso");
            return true;
        } catch (\PDOException $e) {
            $this->logDebug("Erro em update(): " . $e->getMessage());
            return false;
        }
    }

    public function delete($id) {
        $this->logDebug("Excluindo categoria ID: " . $id);
        
        try {
            $sql = "DELETE FROM categorias WHERE i_id_categorias = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
            $stmt->execute();
            $this->logDebug("Categoria excluída com sucesso");
            return true;
        } catch (\PDOException $e) {
            $this->logDebug("Erro em delete(): " . $e->getMessage());
            return false;
        }
    }
}