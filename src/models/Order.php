<?php

namespace Aydom\Ecomerce\Models;

class Order
{
    private $db;

    public function __construct($conn = null)
    {
        $this->db = $conn;
    }

    /**
     * Count all orders in the database
     * 
     * @return int The total number of orders
     */
    public function countAll(): int
    {
        $sql = "SELECT COUNT(*) as total FROM pedidos";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        return (int) $result['total'];
    }

    /**
     * Count pending orders in the database
     * 
     * @return int The number of pending orders
     */
    public function countPending(): int
    {
        $sql = "SELECT COUNT(*) as total FROM pedidos WHERE status = 'pendente'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        return (int) $result['total'];
    }

    /**
     * Calculate total sales for the current month
     * 
     * @return float Total sales amount
     */
    public function calculateMonthSales() {
        try {
            $sql = "SELECT SUM(d_total_pedidos) as total FROM pedidos 
                    WHERE MONTH(d_data_pedidos) = MONTH(CURRENT_DATE()) 
                    AND YEAR(d_data_pedidos) = YEAR(CURRENT_DATE())";
            $stmt = $this->db->prepare($sql); // Changed from $this->conn to $this->db
            $stmt->execute();
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            
            return (float) ($result['total'] ?? 0);
        } catch (\PDOException $e) {
            // Log the error
            error_log("Error in calculateMonthSales(): " . $e->getMessage());
            // Return 0 if there's an error (like table not existing)
            return 0;
        }
    }

    /**
     * Get the most recent orders
     * 
     * @param int $limit The maximum number of orders to return
     * @return array The list of recent orders
     */
    public function getRecent(int $limit = 5): array
    {
        $sql = "SELECT p.id, u.s_nome_usuarios as nome_cliente, u.s_email_usuarios as email_cliente, 
                       p.data_pedido as data, p.total, p.status
                FROM pedidos p
                JOIN usuarios u ON p.id_usuario = u.i_id_usuarios
                ORDER BY p.data_pedido DESC
                LIMIT :limit";
                
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}