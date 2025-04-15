<?php

namespace Aydom\Ecomerce\Models;

use PDO;

class User
{
    private PDO $conn; // Tipagem da propriedade

    public function __construct(PDO $conn) { // Tipagem do parâmetro
        $this->conn = $conn;
    }

    /**
     * Retrieve all users from the database
     *
     * @return array
     */
    public function getAll(): array // Tipagem do retorno
    {
        $query = "SELECT
            i_id_usuarios,
            s_nome_usuarios,
            s_email_usuarios,
            s_senha_usuarios,
            s_tipo_usuarios,
            s_telefone_usuarios,
            s_endereco_usuarios,
            s_cidade_usuarios,
            s_estado_usuarios,
            s_cep_usuarios,
            b_ativo_usuarios,
            dt_cadastro_usuarios,
            dt_atualizacao_usuarios
        FROM usuarios";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Create a new user
     *
     * @param array $userData Array containing user data
     * @return bool True on success, false on failure
     */
    public function create(array $userData): bool // Tipagem do parâmetro e do retorno
    {
        $query = "INSERT INTO usuarios (
            s_nome_usuarios,
            s_email_usuarios,
            s_senha_usuarios,
            s_tipo_usuarios,
            s_telefone_usuarios,
            s_endereco_usuarios,
            s_cidade_usuarios,
            s_estado_usuarios,
            s_cep_usuarios,
            b_ativo_usuarios,
            dt_cadastro_usuarios
        ) VALUES (
            :nome,
            :email,
            :senha,
            :tipo,
            :telefone,
            :endereco,
            :cidade,
            :estado,
            :cep,
            :ativo,
            NOW()
        )";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ':nome' => $userData['s_nome_usuarios'],
            ':email' => $userData['s_email_usuarios'],
            ':senha' => password_hash($userData['s_senha_usuarios'], PASSWORD_BCRYPT),
            ':tipo' => $userData['s_tipo_usuarios'],
            ':telefone' => $userData['s_telefone_usuarios'],
            ':endereco' => $userData['s_endereco_usuarios'],
            ':cidade' => $userData['s_cidade_usuarios'],
            ':estado' => $userData['s_estado_usuarios'],
            ':cep' => $userData['s_cep_usuarios'],
            ':ativo' => $userData['b_ativo_usuarios']
        ]);
    }

    /**
     * Update an existing user
     *
     * @param int $id User ID
     * @param array $userData Array containing user data to update
     * @return bool True on success, false on failure
     */
    public function update(int $id, array $userData): bool // Tipagem dos parâmetros e do retorno
    {
        $query = "UPDATE usuarios SET
            s_nome_usuarios = :nome,
            s_email_usuarios = :email,
            s_tipo_usuarios = :tipo,
            s_telefone_usuarios = :telefone,
            s_endereco_usuarios = :endereco,
            s_cidade_usuarios = :cidade,
            s_estado_usuarios = :estado,
            s_cep_usuarios = :cep,
            b_ativo_usuarios = :ativo,
            dt_atualizacao_usuarios = NOW()
        WHERE i_id_usuarios = :id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ':id' => $id,
            ':nome' => $userData['s_nome_usuarios'],
            ':email' => $userData['s_email_usuarios'],
            ':tipo' => $userData['s_tipo_usuarios'],
            ':telefone' => $userData['s_telefone_usuarios'],
            ':endereco' => $userData['s_endereco_usuarios'],
            ':cidade' => $userData['s_cidade_usuarios'],
            ':estado' => $userData['s_estado_usuarios'],
            ':cep' => $userData['s_cep_usuarios'],
            ':ativo' => $userData['b_ativo_usuarios']
        ]);
    }

    /**
     * Delete a user
     *
     * @param int $id User ID
     * @return bool True on success, false on failure
     */
    public function delete(int $id): bool // Tipagem do parâmetro e do retorno
    {
        $query = "DELETE FROM usuarios WHERE i_id_usuarios = :id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([':id' => $id]);
    }

    /**
     * Retrieve a single user by ID
     *
     * @param int $id User ID
     * @return array|null User data or null if not found
     */
    public function getById(int $id): ?array // Tipagem do parâmetro e do retorno
    {
        $query = "SELECT
            i_id_usuarios,
            s_nome_usuarios,
            s_email_usuarios,
            s_senha_usuarios,
            s_tipo_usuarios,
            s_telefone_usuarios,
            s_endereco_usuarios,
            s_cidade_usuarios,
            s_estado_usuarios,
            s_cep_usuarios,
            b_ativo_usuarios,
            dt_cadastro_usuarios,
            dt_atualizacao_usuarios
        FROM usuarios WHERE i_id_usuarios = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null; // Retorna null se não encontrado
    }

    /**
     * Count all users
     *
     * @return int
     */
    public function countAll(): int // Tipagem do retorno
    {
        $query = "SELECT COUNT(*) as total FROM usuarios"; // Correção do nome da tabela para 'usuarios'
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int) ($result['total'] ?? 0); // Garante que o retorno seja um inteiro
    }

    /**
     * Count total users
     *
     * @return int
     */
    public function getTotalUsers(): int
    {
        $query = "SELECT COUNT(*) as total FROM usuarios";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int) ($result['total'] ?? 0);
    }

    /**
     * Retrieve a single user by email
     *
     * @param string $email User email
     * @return array|null User data or null if not found
     */
    public function getByEmail(string $email): ?array {
        $sql = "SELECT * FROM usuarios WHERE s_email_usuarios = :email LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':email', $email, \PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC) ?: null;
    }
}