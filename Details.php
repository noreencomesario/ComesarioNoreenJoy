<?php
session_start();

if (!isset($_SESSION['user_data'])) {
    header("Location: index.php"); 
    exit();
}

$user_data = $_SESSION['user_data'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>User Details</h2>
    <ul class="list-group">
        <li class="list-group-item"><strong>Name:</strong> <?php echo htmlspecialchars($user_data['name']); ?></li>
        <li class="list-group-item"><strong>Email:</strong> <?php echo htmlspecialchars($user_data['email']); ?></li>
        <li class="list-group-item"><strong>Facebook URL:</strong> <a href="<?php echo htmlspecialchars($user_data['facebook_url']); ?>" target="_blank"><?php echo htmlspecialchars($user_data['facebook_url']); ?></a></li>
        <li class="list-group-item"><strong>Phone Number:</strong> <?php echo htmlspecialchars($user_data['phone']); ?></li>
        <li class="list-group-item"><strong>Gender:</strong> <?php echo htmlspecialchars($user_data['gender']); ?></li>
        <li class="list-group-item"><strong>Country:</strong> <?php echo htmlspecialchars($user_data['country']); ?></li>
        <li class="list-group-item"><strong>Skills:</strong> <?php echo implode(', ', array_map('htmlspecialchars', $user_data['skills'])); ?></li>
        <li class="list-group-item"><strong>Biography:</strong> <?php echo htmlspecialchars($user_data['biography']); ?></li>
    </ul>

    <a href="index.php" class="btn btn-primary mt-3">Go Back</a>
</div>
</body>
</html>
