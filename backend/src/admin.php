<?php
session_start();
require_once 'db.php';

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

// Fetch unapproved reviews
$stmt = $pdo->prepare('SELECT id, date, author, title, text FROM reviews WHERE approved = 0 ORDER BY date DESC');
$stmt->execute();
$unapproved_reviews = $stmt->fetchAll();

// Fetch already approved reviews (for the deletion feature)
$stmt = $pdo->prepare('SELECT id, date, author, title, text FROM reviews WHERE approved = 1 ORDER BY date DESC');
$stmt->execute();
$all_reviews = $stmt->fetchAll();

// Fetch all alerts
$stmt = $pdo->prepare('SELECT id, date, title, text FROM alerts ORDER BY date DESC');
$stmt->execute();
$alerts = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: system-ui, sans-serif;
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
        }
        .container {
            margin-bottom: 40px;
        }
        .card {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 15px;
        }
        .actions {
            margin-top: 10px;
        }
        .actions button, .actions a {
            margin-right: 10px;
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
        }
        .approve {
            background-color: #4CAF50;
            color: white;
        }
        .delete {
            background-color: #f44336;
            color: white;
        }
        h2 {
            border-bottom: 2px solid #ddd;
            padding-bottom: 10px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"], textarea {
            width: calc(100% - 20px);
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        textarea {
            height: 100px;
        }
        .submit-btn {
            background-color: #2196F3;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .logout {
            float: right;
            background-color: #f44336;
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <header>
        <h1>Admin Dashboard</h1>
        <a href="login.php?action=logout" class="logout">Logout</a>
    </header>

    <!-- Recensioni da approvare -->
    <div class="container">
        <h2>Recensioni da approvare</h2>
        <?php if (count($unapproved_reviews) > 0): ?>
            <?php foreach ($unapproved_reviews as $review): ?>
                <div class="card">
                    <h3><?php echo htmlspecialchars($review['title']); ?></h3>
                    <p><strong>Autore:</strong> <?php echo htmlspecialchars($review['author']); ?></p>
                    <p><strong>Data:</strong> <?php echo htmlspecialchars($review['date']); ?></p>
                    <p><?php echo nl2br(htmlspecialchars($review['text'])); ?></p>
                    <div class="actions">
                        <form method="post" action="post.php" style="display: inline;">
                            <input type="hidden" name="action" value="approve_review">
                            <input type="hidden" name="review_id" value="<?php echo $review['id']; ?>">
                            <button type="submit" class="approve">Approva</button>
                        </form>
                        <form method="post" action="post.php" style="display: inline;">
                            <input type="hidden" name="action" value="delete_review">
                            <input type="hidden" name="review_id" value="<?php echo $review['id']; ?>">
                            <button type="submit" class="delete" onclick="return confirm('Sei sicuro di voler eliminare questa recensione?')">Elimina</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Nessuna recensione non ancora approvata al momento.</p>
        <?php endif; ?>
    </div>
    
    <!-- Recensioni già approvate -->
    <div class="container">
        <h2>Recensioni già approvate</h2>
        <?php if (count($all_reviews) > 0): ?>
            <?php foreach ($all_reviews as $review): ?>
                <div class="card">
                    <h3><?php echo htmlspecialchars($review['title']); ?></h3>
                    <p><strong>Autore:</strong> <?php echo htmlspecialchars($review['author']); ?></p>
                    <p><strong>Data:</strong> <?php echo htmlspecialchars($review['date']); ?></p>
                    <p><?php echo nl2br(htmlspecialchars($review['text'])); ?></p>
                    <div class="actions">
                        <form method="post" action="post.php" style="display: inline;">
                            <input type="hidden" name="action" value="delete_review">
                            <input type="hidden" name="review_id" value="<?php echo $review['id']; ?>">
                            <button type="submit" class="delete" onclick="return confirm('Sei sicuro di voler eliminare questa recensione?')">Elimina</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Nessuna recensione al momento.</p>
        <?php endif; ?>
    </div>

    <!-- Avvisi -->
    <div class="container">
        <h2>Avvisi</h2>
        <?php if (count($alerts) > 0): ?>
            <?php foreach ($alerts as $alert): ?>
                <div class="card">
                    <h3><?php echo htmlspecialchars($alert['title']); ?></h3>
                    <p><strong>Data:</strong> <?php echo htmlspecialchars($alert['date']); ?></p>
                    <p><?php echo nl2br(htmlspecialchars($alert['text'])); ?></p>
                    <div class="actions">
                        <form method="post" action="post.php" style="display: inline;">
                            <input type="hidden" name="action" value="delete_alert">
                            <input type="hidden" name="alert_id" value="<?php echo $alert['id']; ?>">
                            <button type="submit" class="delete" onclick="return confirm('Sei sicuro di voler eliminare questo avviso?')">Elimina</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Nessun avviso.</p>
        <?php endif; ?>
    </div>

    <div class="container">
        <h2>Crea Nuovo Alert</h2>
        <form method="post" action="post.php">
            <input type="hidden" name="action" value="create_alert">
            
            <div class="form-group">
                <label for="title">Titolo:</label>
                <input type="text" id="title" name="title" required>
            </div>
            
            <div class="form-group">
                <label for="text">Testo:</label>
                <textarea id="text" name="text" required></textarea>
            </div>
            
            <button type="submit" class="submit-btn">Crea Avviso</button>
        </form>
    </div>
</body>
</html>
