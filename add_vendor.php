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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $shop = $_POST['shop_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $cert_num = 'GB-V-' . strtoupper(substr(uniqid(), -5));
    
    $stmt = $pdo->prepare("INSERT INTO vendors (name, shop_name, email, phone, address, certificate_number) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$name, $shop, $email, $phone, $address, $cert_num]);
    
    header("Location: vendors.php?msg=added");
}
?>

<div class="animate-fade" style="max-width: 700px; margin: 0 auto;">
    <div style="margin-bottom: 2rem;">
        <h1 style="font-size: 1.75rem; font-weight: 700;">Register Vendor</h1>
        <p style="color: var(--text-muted);">Onboard a new seller to the GramBazar platform.</p>
    </div>

    <form action="" method="POST" class="card">
        <div class="grid-2" style="grid-template-columns: 1fr 1fr;">
            <div class="form-group">
                <label>Shop Name</label>
                <input type="text" name="shop_name" class="form-control" placeholder="e.g. Fresh Mart" required>
            </div>
            <div class="form-group">
                <label>Owner Name</label>
                <input type="text" name="name" class="form-control" placeholder="Owner's full name" required>
            </div>
        </div>

        <div class="grid-2" style="grid-template-columns: 1fr 1fr;">
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" class="form-control" placeholder="vendor@example.com" required>
            </div>
            <div class="form-group">
                <label>Contact Number</label>
                <input type="text" name="phone" class="form-control" placeholder="Phone number" required>
            </div>
        </div>

        <div class="form-group">
            <label>Shop Address</label>
            <textarea name="address" class="form-control" rows="3" placeholder="Full business address..." required></textarea>
        </div>

        <div style="display: flex; gap: 10px; justify-content: flex-end; margin-top: 1rem;">
            <a href="vendors.php" class="btn btn-outline">Cancel</a>
            <button type="submit" class="btn btn-primary">Create Partnership</button>
        </div>
    </form>
</div>

<?php include 'includes/footer.php'; ?>
