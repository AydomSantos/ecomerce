<?php
// Start session
session_start();

// Include necessary files
require_once 'src/config/config.php';
require_once 'src/config/database.php';

// Connect to database
$database = new Database();
$conn = $database->getConnection();

if (!$conn) {
    die("Database connection failed");
}

// Hash the password
$password = 'aydon1234512345';
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Prepare admin user data
$nome = 'Aydom';
$email = 'admin@ecomerce.com';
$tipo = 'admin';
$telefone = '(00) 00000-0000';
$endereco = 'Rua Exemplo, 123';
$cidade = 'São Paulo';
$estado = 'SP';
$cep = '01000-000';
$ativo = 1;
$data_cadastro = date('Y-m-d H:i:s');
$data_atualizacao = date('Y-m-d H:i:s');

try {
    // Check if user already exists
    $check_stmt = $conn->prepare("SELECT * FROM usuarios WHERE s_email_usuarios = :email");
    $check_stmt->bindParam(':email', $email);
    $check_stmt->execute();
    
    if ($check_stmt->rowCount() > 0) {
        echo "<h2>Admin user already exists!</h2>";
    } else {
        // Insert admin user
        $sql = "INSERT INTO usuarios (
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
                    :data_cadastro,
                    :data_atualizacao
                )";
                
        $stmt = $conn->prepare($sql);
        
        // Bind parameters
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $hashed_password);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':endereco', $endereco);
        $stmt->bindParam(':cidade', $cidade);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':cep', $cep);
        $stmt->bindParam(':ativo', $ativo);
        $stmt->bindParam(':data_cadastro', $data_cadastro);
        $stmt->bindParam(':data_atualizacao', $data_atualizacao);
        
        // Execute query
        if ($stmt->execute()) {
            echo "<h2>Admin user created successfully!</h2>";
            echo "<p>Username: admin@ecomerce.com</p>";
            echo "<p>Password: aydon1234512345</p>";
        } else {
            echo "<h2>Failed to create admin user.</h2>";
        }
    }
} catch (PDOException $e) {
    echo "<h2>Error: " . $e->getMessage() . "</h2>";
}
?>

<p><a href="index.php">Return to homepage</a></p>