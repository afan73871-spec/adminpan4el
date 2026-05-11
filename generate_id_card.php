<?php
include 'includes/db.php';

if (!isset($_GET['id'])) die("ID required");

$stmt = $pdo->prepare("SELECT * FROM delivery_boys WHERE id = ?");
$stmt->execute([$_GET['id']]);
$boy = $stmt->fetch();

if (!$boy) die("Delivery boy not found");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ID Card - <?php echo $boy['name']; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; display: flex; justify-content: center; align-items: center; min-height: 100vh; background: #f0f2f5; margin: 0; }
        .id-card {
            width: 350px;
            height: 550px;
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            position: relative;
            text-align: center;
        }
        .header {
            background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
            height: 180px;
            padding: 20px;
            color: #fff;
        }
        .header h2 { margin: 0; font-size: 1.5rem; letter-spacing: 1px; }
        .header p { margin: 5px 0 0; font-size: 0.8rem; opacity: 0.8; }
        
        .photo-container {
            width: 130px;
            height: 130px;
            background: #fff;
            border-radius: 50%;
            margin: -65px auto 15px;
            padding: 8px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            position: relative;
            z-index: 10;
        }
        .photo-container img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
        }
        
        .content { padding: 0 30px 30px; }
        .content h1 { font-size: 1.5rem; color: #1e293b; margin: 0 0 5px; }
        .content .designation { color: #6366f1; font-weight: 600; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 25px; display: block; }
        
        .info-row { display: flex; flex-direction: column; gap: 15px; text-align: left; }
        .info-item { border-bottom: 1px solid #f1f5f9; padding-bottom: 8px; }
        .info-item label { display: block; font-size: 0.7rem; color: #94a3b8; text-transform: uppercase; font-weight: 700; margin-bottom: 2px; }
        .info-item span { color: #1e293b; font-weight: 600; font-size: 0.95rem; }
        
        .footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            padding: 15px;
            background: #f8fafc;
            font-size: 0.75rem;
            color: #64748b;
            border-top: 1px solid #e2e8f0;
        }
        
        .qr-code { position: absolute; bottom: 80px; right: 20px; width: 60px; height: 60px; opacity: 0.5; }
        
        @media print {
            body { background: none; }
            .id-card { box-shadow: none; border: 1px solid #e2e8f0; }
            .no-print { display: none; }
        }
        
        .no-print {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #4f46e5;
            color: #fff;
            padding: 10px 20px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
        }
    </style>
</head>
<body>
    <a href="#" class="no-print" onclick="window.print()">Print ID Card</a>
    
    <div class="id-card">
        <div class="header">
            <h2>GRAMBAZAR</h2>
            <p>Official Delivery Partner</p>
        </div>
        
        <div class="photo-container">
            <img src="<?php echo $boy['profile_pic'] ? $boy['profile_pic'] : 'https://ui-avatars.com/api/?name='.urlencode($boy['name']).'&background=6366f1&color=fff'; ?>" alt="Profile">
        </div>
        
        <div class="content">
            <h1><?php echo $boy['name']; ?></h1>
            <span class="designation">Delivery Executive</span>
            
            <div class="info-row">
                <div class="info-item">
                    <label>Employee ID</label>
                    <span><?php echo $boy['id_card_number']; ?></span>
                </div>
                <div class="info-item">
                    <label>Phone Number</label>
                    <span><?php echo $boy['phone']; ?></span>
                </div>
                <div class="info-item">
                    <label>Blood Group</label>
                    <span>O+ (Default)</span>
                </div>
            </div>
        </div>
        
        <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=<?php echo $boy['id_card_number']; ?>" class="qr-code">
        
        <div class="footer">
            If found, please return to GramBazar Hub or contact Support.
        </div>
    </div>
</body>
</html>
