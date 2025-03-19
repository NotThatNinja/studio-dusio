<?php
require_once 'db.php';

header('Content-Type: application/json; charset=utf-8');

if (isset($_GET['what']) && $_GET['what'] === 'reviews') {
    // Return only approved reviews
    $stmt = $pdo->prepare('SELECT id, date, author, title, text FROM reviews WHERE approved = true ORDER BY date DESC');
    $stmt->execute();
    $reviews = $stmt->fetchAll();
    echo json_encode($reviews);
} else if (isset($_GET['what']) && $_GET['what'] === 'alerts') {
    // Return all alerts
    $stmt = $pdo->prepare('SELECT id, date, title, text FROM alerts ORDER BY date DESC');
    $stmt->execute();
    $notices = $stmt->fetchAll();
    echo json_encode($notices);
} else {
    echo json_encode(['error' => 'Invalid request']);
}
?>
