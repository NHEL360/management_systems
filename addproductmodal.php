<div class="modal" id="addProductModal">
    <div class="modal-content">
        <span class="close" id="closeAddProductModal">&times;</span>
        <h2>Add New Product</h2>
        <form method="POST" action="add_product.php">
            <input type="text" name="product_name" placeholder="Product Name" required>
            <textarea name="description" placeholder="Description"></textarea>
            <input type="number" name="price" placeholder="Price" required>
            <select name="category_id">
                <?php
                $stmt = $pdo->query("SELECT * FROM categories");
                while ($row = $stmt->fetch()) {
                    echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                }
                ?>
            </select>
            <button type="submit">Add Product</button>
        </form>
    </div>
</div>
