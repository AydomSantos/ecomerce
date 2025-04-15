<?php

namespace Aydom\Ecomerce\Models;

class User
{
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    /**
     * Retrieve all users from the database
     */
    public function getAll() {
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
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Create a new user
     */
    public function create($userData) {
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
     */
    public function update($id, $userData) {
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
     */
    public function delete($id) {
        $query = "DELETE FROM usuarios WHERE i_id_usuarios = :id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([':id' => $id]);
    }

    /**
     * Retrieve a single user by ID
     */
    public function getById($id) {
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
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Count all users
     * 
     * @return int
     */
    public function countAll() {
        $query = "SELECT COUNT(*) as total FROM users";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }
}