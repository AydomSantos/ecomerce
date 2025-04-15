<?php

namespace Aydom\Ecomerce\Controllers;

use Aydom\Ecomerce\Models\Product;
use Aydom\Ecomerce\Models\Category;
use PDO; 

class HomeController {
    private Product $productModel; 
    private Category $categoryModel; 

    public function __construct(PDO $conn) { 
        // Pass the database connection to the models
        $this->productModel = new Product($conn);
        $this->categoryModel = new Category($conn);
    }

    /**
     * Display the home page with featured products
     */
    public function index(): void { // Tipagem do retorno
        // Get featured products
        $featuredProducts = $this->productModel->getFeatured(5); 
        // Get best selling products
        $bestSellers = $this->productModel->getBestSellers(8); 
        // Get recommended products (could be based on user preferences or random)
        $recommendedProducts = $this->productModel->getRecommended(5); 
        // Get all active categories
        $categories = $this->categoryModel->getAll(); 
        // Load the home view
        include __DIR__ . '/../views/home.php';
    }

    /**
     * Display the about us page
     */
    public function about(): void { // Tipagem do retorno
        include __DIR__ . '/../views/about.php';
    }

    /**
     * Display the contact page
     */
    public function contact(): void { // Tipagem do retorno
        include __DIR__ . '/../views/contact.php';
    }

    /**
     * Process contact form submission
     */
    public function submitContact(): void { // Tipagem do retorno
        // Check if form was submitted
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?c=home&a=contact');
            exit;
        }

        // Process form data
        $name = (string) ($_POST['name'] ?? '');
        $email = (string) ($_POST['email'] ?? '');
        $subject = (string) ($_POST['subject'] ?? '');
        $message = (string) ($_POST['message'] ?? '');

        // Validate form data
        $errors = [];

        if (empty($name)) {
            $errors['name'] = 'Nome é obrigatório';
        }

        if (empty($email)) {
            $errors['email'] = 'Email é obrigatório';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email inválido';
        }

        if (empty($subject)) {
            $errors['subject'] = 'Assunto é obrigatório';
        }

        if (empty($message)) {
            $errors['message'] = 'Mensagem é obrigatória';
        }

        // If there are errors, redirect back to form with errors
        if (!empty($errors)) {
            $_SESSION['contact_errors'] = $errors;
            $_SESSION['contact_data'] = [
                'name' => $name,
                'email' => $email,
                'subject' => $subject,
                'message' => $message
            ];
            header('Location: index.php?c=home&a=contact');
            exit;
        }

        $success = true; 

        if ($success) {
            $_SESSION['contact_success'] = 'Mensagem enviada com sucesso! Entraremos em contato em breve.';
        } else {
            $_SESSION['contact_error'] = 'Erro ao enviar mensagem. Por favor, tente novamente.';
        }

        header('Location: index.php?c=home&a=contact');
        exit;
    }

    public function faq(): void { // Tipagem do retorno
        include __DIR__ . '/../views/faq.php';
    }

    /**
     * Display the login page
     */
    public function login(): void { // Tipagem do retorno
        // If user is already logged in, redirect to home page
        if (isset($_SESSION['user_id'])) {
            header('Location: index.php');
            exit;
        }

        include __DIR__ . '/../views/login.php';
    }

    /**
     * Display the registration page
     */
    public function register(): void { // Tipagem do retorno
        // If user is already logged in, redirect to home page
        if (isset($_SESSION['user_id'])) {
            header('Location: index.php');
            exit;
        }

        include __DIR__ . '/../views/register.php';
    }
}