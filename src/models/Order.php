<?php

namespace Aydom\Ecomerce\Models;

use PDO;

class Order
{
    private ?PDO $db; 

    public function __construct(?PDO $conn = null) 
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
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

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
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return (int) $result['total'];
    }

    /**
     * Calculate total sales for the current month
     *
     * @return float Total sales amount
     */
    public function calculateMonthSales(): float
    {
        try {
            $sql = "SELECT SUM(d_total_pedidos) as total FROM pedidos
                          WHERE MONTH(d_data_pedidos) = MONTH(CURRENT_DATE())
                          AND YEAR(d_data_pedidos) = YEAR(CURRENT_DATE())";
            $stmt = $this->db->prepare($sql); // Changed from $this->conn to $this->db
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return (float) ($result['total'] ?? 0);
        } catch (PDOException $e) { // Tipagem da exceção
            // Log the error
            error_log("Error in calculateMonthSales(): " . $e->getMessage());
            // Return 0 if there's an error (like table not existing)
            return 0.0; // Retorna 0.0 para garantir o tipo float
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
        $sql = "SELECT pedidos.id as id_pedido, usuarios.s_nome_usuarios as nome_cliente, usuarios.s_email_usuarios as email_cliente,
                        pedidos.d_data_pedidos as data, pedidos.d_total_pedidos as total, pedidos.status as status
                  FROM pedidos
                  JOIN usuarios ON pedidos.id_usuario = usuarios.i_id_usuarios
                  ORDER BY pedidos.d_data_pedidos DESC
                  LIMIT :limit";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOrders(string $status = '', string $dateFrom = '', string $dateTo = '', string $search = '', int $page = 1, int $perPage = 10): array {
        try {
            $offset = ($page - 1) * $perPage;
            $sql = "SELECT * FROM pedidos WHERE 1=1";
            $params = [];

            if (!empty($status)) {
                $sql .= " AND status = :status";
                $params[':status'] = $status;
            }
            if (!empty($dateFrom)) {
                $sql .= " AND d_data_pedidos >= :dateFrom";
                $params[':dateFrom'] = $dateFrom;
            }
            if (!empty($dateTo)) {
                $sql .= " AND d_data_pedidos <= :dateTo";
                $params[':dateTo'] = $dateTo;
            }
            if (!empty($search)) {
                $sql .= " AND (s_nome_usuarios LIKE :search OR s_email_usuarios LIKE :search)";
                $params[':search'] = '%' . $search . '%';
            }

            $sql .= " ORDER BY d_data_pedidos DESC LIMIT :limit OFFSET :offset";
            $stmt = $this->db->prepare($sql);

            foreach ($params as $param => &$val) {
                $stmt->bindParam($param, $val);
            }
            $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error in getOrders(): " . $e->getMessage());
            return [];
        }
    }
}