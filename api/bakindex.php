<?php
$dataFile = __DIR__ . '/data.json';

var_dump(opcache_get_status());

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $note = $_POST['note'] ?? '';

    if (!empty($note)) {
        // Read existing notes
        $notes = json_decode(file_get_contents($dataFile), true);
        if ($notes === null) {
            $notes = [];
        }

        // Add new note
        $notes[] = [
            'note' => htmlspecialchars($note, ENT_QUOTES, 'UTF-8'),
            'date' => date('Y-m-d H:i:s')
        ];

        // Save notes
        file_put_contents($dataFile, json_encode($notes));
    }

    // Redirect to avoid form resubmission
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

// Read notes
$notes = json_decode(file_get_contents($dataFile), true);
if ($notes === null) {
    $notes = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }
        form {
            margin-bottom: 20px;
        }
        textarea {
            width: 300px;
            height: 100px;
            margin-bottom: 10px;
        }
        button {
            padding: 10px 20px;
            background-color: #4caf50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .notes {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        .note {
            background-color: #fff;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        .note h3 {
            margin: 0 0 10px;
            font-size: 1.2em;
            color: #333;
        }
        .note p {
            margin: 0;
            color: #666;
        }
    </style>
</head>
<body>
    <h1>Sticky Notes</h1>
    <form action="" method="post">
        <textarea name="note" placeholder="Write your note here..."></textarea>
        <br>
        <button type="submit">Save Note</button>
    </form>
    <div class="notes">
        <?php foreach ($notes as $note): ?>
            <div class="note">
                <h3>Note</h3>
                <p><?= $note['note'] ?></p>
                <p><small><?= $note['date'] ?></small></p>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
