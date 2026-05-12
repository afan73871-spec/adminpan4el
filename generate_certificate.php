<?php
if (file_exists('includes/db.php')) {
    include 'includes/db.php';
} else {
    include 'db.php';
}

if (!isset($_GET['id'])) die("ID required");

$stmt = $pdo->prepare("SELECT * FROM vendors WHERE id = ?");
$stmt->execute([$_GET['id']]);
$vendor = $stmt->fetch();

if (!$vendor) die("Vendor not found");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Certificate - <?php echo $vendor['shop_name']; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; display: flex; justify-content: center; align-items: center; min-height: 100vh; background: #e2e8f0; margin: 0; padding: 20px; }
        .certificate {
            width: 800px;
            background: #fff;
            padding: 50px;
            border: 15px solid #1e293b;
            position: relative;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
            text-align: center;
        }
        .certificate::before {
            content: '';
            position: absolute;
            top: 5px; left: 5px; right: 5px; bottom: 5px;
            border: 2px solid #6366f1;
            pointer-events: none;
        }
        .logo { font-family: 'Playfair Display', serif; font-size: 2.5rem; color: #6366f1; margin-bottom: 20px; }
        .title { font-size: 3rem; font-weight: 700; color: #1e293b; text-transform: uppercase; letter-spacing: 5px; margin-bottom: 10px; }
        .subtitle { font-size: 1.2rem; color: #64748b; margin-bottom: 40px; text-transform: uppercase; letter-spacing: 2px; }
        
        .content { margin-bottom: 50px; line-height: 1.8; color: #334155; }
        .content p { font-size: 1.1rem; }
        .content .vendor-name { font-family: 'Playfair Display', serif; font-size: 2.2rem; color: #4f46e5; margin: 20px 0; display: block; border-bottom: 2px solid #f1f5f9; padding-bottom: 10px; }
        
        .footer-info { display: flex; justify-content: space-between; margin-top: 60px; text-align: left; }
        .signature { text-align: center; border-top: 2px solid #e2e8f0; padding-top: 10px; width: 200px; }
        .signature p { margin: 0; font-weight: 600; color: #1e293b; }
        .signature span { font-size: 0.8rem; color: #64748b; }
        
        .badge-seal { position: absolute; bottom: 40px; right: 40px; width: 120px; opacity: 0.8; }
        
        .cert-number { position: absolute; top: 40px; right: 40px; font-family: monospace; color: #94a3b8; font-size: 0.9rem; }

        @media print {
            body { background: none; padding: 0; }
            .certificate { box-shadow: none; border-width: 10px; }
            .no-print { display: none; }
        }
        
        .no-print {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #4f46e5;
            color: #fff;
            padding: 12px 24px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            z-index: 100;
        }
    </style>
</head>
<body>
    <a href="#" class="no-print" onclick="window.print()">Download/Print Certificate</a>
    
    <div class="certificate">
        <div class="cert-number">No: <?php echo $vendor['certificate_number']; ?></div>
        
        <div class="logo">GramBazar</div>
        <div class="title">Certificate</div>
        <div class="subtitle">of Partnership</div>
        
        <div class="content">
            <p>This is to certify that</p>
            <span class="vendor-name"><?php echo $vendor['shop_name']; ?></span>
            <p>managed by <strong><?php echo $vendor['name']; ?></strong> is an authorized partner of GramBazar E-Commerce platform. This partnership entitles the vendor to list and sell products under the GramBazar network, adhering to our quality and service standards.</p>
        </div>
        
        <div class="footer-info">
            <div style="text-align: left;">
                <p style="margin: 0; font-size: 0.9rem; color: #64748b;">Issued Date:</p>
                <p style="margin: 0; font-weight: 600; color: #1e293b;"><?php echo date('F d, Y', strtotime($vendor['created_at'])); ?></p>
            </div>
            
            <div class="signature">
                <p>Management</p>
                <span>GramBazar Pvt. Ltd.</span>
            </div>
        </div>
        
        <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=CERT-<?php echo $vendor['certificate_number']; ?>" class="badge-seal">
    </div>
</body>
</html>
