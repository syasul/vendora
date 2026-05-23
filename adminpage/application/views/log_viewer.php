<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Viewer</title>
    <style>
        body { font-family: Arial, sans-serif; }
        pre { background-color: #f8f8f8; padding: 10px; border: 1px solid #ddd; overflow: auto; }
        h2 { color: #333; }
    </style>
</head>
<body>
    <h1>Log Viewer</h1>
    <?php if (empty($log_contents)): ?>
        <p>Tidak ada log yang tersedia.</p>
    <?php else: ?>
        <?php foreach ($log_contents as $filename => $content): ?>
            <h2>File: <?php echo $filename; ?></h2>
            <pre><?php echo htmlspecialchars($content); ?></pre>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>
