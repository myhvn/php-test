<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];

    $data = [
        'firstName' => $firstName,
        'lastName' => $lastName,
        'phone' => $phone,
        'email' => $email,
        'countryCode' => 'GB',
        'box_id' => 28,
        'offer_id' => 5,
        'landingUrl' => $_SERVER['HTTP_REFERER'],
        'ip' => $_SERVER['REMOTE_ADDR'],
        'password' => 'qwerty12',
        'language' => 'en'
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://crm.belmar.pro/api/v1/addlead');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'token: ba67df6a-a17c-476f-8e95-bcdb75ed3958'
    ]);
    $response = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($response, true);
    if (isset($result['status']) && $result['status'] == true) {
        $message = 'Lead added successfully! ID: ' . $result['id'] . ', Email: ' . $result['email'];
    } else {
        $message = 'Error: ' . $result['error'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lead Form</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <nav>
        <ul>
            <li><a href="index.php">Add Lead</a></li>
            <li><a href="statuses.php">Lead Statuses</a></li>
        </ul>
    </nav>

    <h1>Add Lead</h1>

    <?php if (isset($message)): ?>
        <div class="message"><?= $message ?></div>
    <?php endif; ?>

    <form method="POST" action="index.php">
        <label for="firstName">First Name:</label>
        <input type="text" id="firstName" name="firstName" required>
        <label for="lastName">Last Name:</label>
        <input type="text" id="lastName" name="lastName" required>
        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone" required>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <button type="submit">Submit</button>
    </form>
</body>
</html>
