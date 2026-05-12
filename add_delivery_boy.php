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
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $id_num = 'DEL-' . strtoupper(substr(uniqid(), -6));
    
    $stmt = $pdo->prepare("INSERT INTO delivery_boys (name, email, phone, address, id_card_number) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$name, $email, $phone, $address, $id_num]);
    
    header("Location: delivery_boys.php?msg=added");
}
?>

<div class="animate-fade" style="max-width: 600px; margin: 0 auto;">
    <div style="margin-bottom: 2rem;">
        <h1 style="font-size: 1.75rem; font-weight: 700;">Add Delivery Boy</h1>
        <p style="color: var(--text-muted);">Register a new delivery partner to the fleet.</p>
    </div>

    <form action="" method="POST" class="card">
        <div class="form-group">
            <label>Full Name</label>
            <input type="text" name="name" class="form-control" placeholder="Enter full name" required>
        </div>

        <div class="grid-2" style="grid-template-columns: 1fr 1fr;">
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" class="form-control" placeholder="email@example.com" required>
            </div>
            <div class="form-group">
                <label>Phone Number</label>
                <input type="text" name="phone" class="form-control" placeholder="10-digit number" required>
            </div>
        </div>

        <div class="form-group">
            <label>Residential Address</label>
            <textarea name="address" class="form-control" rows="3" placeholder="Enter full address..." required></textarea>
        </div>

        <div style="display: flex; gap: 10px; justify-content: flex-end; margin-top: 1rem;">
            <a href="delivery_boys.php" class="btn btn-outline">Cancel</a>
            <button type="submit" class="btn btn-primary">Register Delivery Boy</button>
        </div>
    </form>
</div>

<?php include 'includes/footer.php'; ?>
