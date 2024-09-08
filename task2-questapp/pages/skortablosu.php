<?php
include('../utils/db.php');



try {
    $stmt = $db->prepare("
        SELECT s.user_id, COALESCE(SUM(s.puan), 0) AS toplam_puan
        FROM submissions s
        GROUP BY s.user_id
        ORDER BY toplam_puan DESC
    ");
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'Sorgu hatası: ' . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Scoreboard</title>
        <link rel="stylesheet" href="/web-server/stil.css">

    <style>
        table {
            width: 50%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: center;
        }
    </style>
</head>
<body>

    
    <div class="container">
    <h1>Scoreboard</h1>
    <table>
        <thead>
            <tr>
                <th>Öğrenci ID</th>
                <th>Toplam Puan</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($results as $row): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['user_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['toplam_puan']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    </div>
</body>
</html>
