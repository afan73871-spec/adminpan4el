<?php
if (file_exists('includes/db.php')) {
    include 'includes/db.php';
} else {
    include 'db.php';
}

if (file_exists('includes/header.php')) {
    include 'includes/header.php';
} else {
    include 'header.php';
}

$categories = $pdo->query("SELECT * FROM categories")->fetchAll();
$vendors = $pdo->query("SELECT * FROM vendors")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $desc = $_POST['description'];
    $price = $_POST['price'];
    $cat_id = $_POST['category_id'];
    $ven_id = $_POST['vendor_id'];
    $stock = $_POST['stock'];
    
    // Image Upload Logic
    $image_url = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "assets/products/";
        if (!file_exists($target_dir)) mkdir($target_dir, 0777, true);
        
        $file_name = time() . '_' . basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $file_name;
        
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image_url = $target_file;
        }
    }

    $stmt = $pdo->prepare("INSERT INTO products (name, description, price, category_id, vendor_id, image, stock) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$name, $desc, $price, $cat_id, $ven_id, $image_url, $stock]);
    
    header("Location: products.php?msg=added");
}
?>

<div class="animate-fade" style="max-width: 800px; margin: 0 auto;">
    <div style="margin-bottom: 2rem;">
        <h1 style="font-size: 1.75rem; font-weight: 700;">Add New Product</h1>
        <p style="color: var(--text-muted);">Fill in the details below to upload a new product to the store.</p>
    </div>

    <form action="" method="POST" enctype="multipart/form-data" class="card">
        <div class="grid-2" style="grid-template-columns: 1fr 1fr;">
            <div class="form-group">
                <label>Product Name</label>
                <input type="text" name="name" class="form-control" placeholder="Enter product name" required>
            </div>
            <div class="form-group">
                <label>Category</label>
                <select name="category_id" class="form-control" required>
                    <option value="">Select Category</option>
                    <?php foreach ($categories as $cat): ?>
                    <option value="<?php echo $cat['id']; ?>"><?php echo $cat['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label>Description</label>
            <textarea name="description" class="form-control" rows="4" placeholder="Describe the product..."></textarea>
        </div>

        <div class="grid-2" style="grid-template-columns: 1fr 1fr 1fr;">
            <div class="form-group">
                <label>Price (₹)</label>
                <input type="number" step="0.01" name="price" class="form-control" placeholder="0.00" required>
            </div>
            <div class="form-group">
                <label>Stock Quantity</label>
                <input type="number" name="stock" class="form-control" placeholder="0" required>
            </div>
            <div class="form-group">
                <label>Vendor</label>
                <select name="vendor_id" class="form-control">
                    <option value="">Admin (Self)</option>
                    <?php foreach ($vendors as $ven): ?>
                    <option value="<?php echo $ven['id']; ?>"><?php echo $ven['shop_name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label>Product Image</label>
            <div style="border: 2px dashed var(--border); padding: 2rem; border-radius: 15px; text-align: center; cursor: pointer;" onclick="document.getElementById('img-input').click()">
                <i class="fas fa-cloud-upload-alt" style="font-size: 2rem; color: var(--primary); margin-bottom: 10px; display: block;"></i>
                <span style="font-size: 0.9rem; color: var(--text-muted);">Click to upload or drag and drop</span>
                <input type="file" id="img-input" name="image" style="display: none;" onchange="previewImage(this)">
            </div>
            <div id="image-preview" style="margin-top: 15px; display: none;">
                <img id="preview-img" src="#" alt="Preview" style="max-width: 200px; border-radius: 10px; border: 1px solid var(--border);">
            </div>
        </div>

        <div style="display: flex; gap: 10px; justify-content: flex-end; margin-top: 1rem;">
            <a href="products.php" class="btn btn-outline">Cancel</a>
            <button type="submit" class="btn btn-primary">Save Product</button>
        </div>
    </form>
</div>

<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview-img').src = e.target.result;
            document.getElementById('image-preview').style.display = 'block';
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

<?php include 'includes/footer.php'; ?>
