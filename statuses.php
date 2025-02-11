<?php
$dateFrom = isset($_POST['dateFrom']) ? $_POST['dateFrom'] : '2020-12-01 00:00:00';
$dateTo = isset($_POST['dateTo']) ? $_POST['dateTo'] : date('Y-m-d H:i:s');

$data = [
    'date_from' => $dateFrom,
    'date_to' => $dateTo,
    'page' => 0,
    'limit' => 200
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://crm.belmar.pro/api/v1/getstatuses');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'token: ba67df6a-a17c-476f-8e95-bcdb75ed3958'
]);
$response = curl_exec($ch);
curl_close($ch);

$statuses = json_decode($response, true);

$statusesData = isset($statuses['data']) ? $statuses['data'] : [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lead Statuses</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <nav>
        <ul>
            <li><a href="index.php">Add Lead</a></li>
            <li><a href="statuses.php">Lead Statuses</a></li>
        </ul>
    </nav>

    <h1>Lead Statuses</h1>

    <form method="POST" action="statuses.php">
        <label for="dateFrom">Date from:</label>
        <input type="date" id="dateFrom" name="dateFrom" value="<?= $dateFrom ?>">
        <label for="dateTo">Date to:</label>
        <input type="date" id="dateTo" name="dateTo" value="<?= $dateTo ?>">
        <button type="submit">Filter</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Status</th>
                <th>FTD</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($statusesData as $status): ?>
                <tr>
                    <td><?= htmlspecialchars($status['id']) ?></td>
                    <td><?= htmlspecialchars($status['email']) ?></td>
                    <td><?= htmlspecialchars($status['status']) ?></td>
                    <td><?= htmlspecialchars($status['ftd']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
