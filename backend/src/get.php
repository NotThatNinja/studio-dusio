<?php
// Enable CORS TODO: Remove this in production
header("Access-Control-Allow-Origin: http://localhost:4321");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

header('Content-Type: application/json; charset=utf-8');

if (isset($_GET['what'])) {
    require_once 'db.php';

    switch ($_GET['what']) {
        case 'reviews':
            // Return only approved reviews
            $stmt = $pdo->prepare('SELECT id, date, name, surname, text FROM reviews WHERE approved = true ORDER BY date DESC');
            $stmt->execute();
            $reviews = $stmt->fetchAll();
            echo json_encode($reviews);
            break;
        case 'alerts':
            // Return all alerts
            $stmt = $pdo->prepare('SELECT id, date, title, text FROM alerts ORDER BY date DESC');
            $stmt->execute();
            $notices = $stmt->fetchAll();
            echo json_encode($notices);
            break;
    }
}
?>
