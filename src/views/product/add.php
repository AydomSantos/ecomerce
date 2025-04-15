<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
</head>
<body>
    <h1>Add New Product</h1>
    <form action="index.php?c=product&a=addProduct" method="post" enctype="multipart/form-data">
        <label for="nome">Product Name:</label>
        <input type="text" id="nome" name="nome" required>
        
        <label for="descricao">Description:</label>
        <textarea id="descricao" name="descricao" required></textarea>
        
        <label for="preco">Price:</label>
        <input type="number" id="preco" name="preco" step="0.01" required>
        
        <label for="id_categorias">Category:</label>
        <select id="id_categorias" name="id_categorias" required>
            <?php foreach ($categorias as $categoria): ?>
                <option value="<?= $categoria['id'] ?>"><?= $categoria['nome'] ?></option>
            <?php endforeach; ?>
        </select>
        
        <label for="image">Image:</label>
        <input type="file" id="image" name="image">
        
        <button type="submit">Add Product</button>
    </form>
</body>
</html>