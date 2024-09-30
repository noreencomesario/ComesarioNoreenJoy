<?php
session_start();

$errors = [];
$fields = [
    'name' => '',
    'email' => '',
    'password' => '',
    'confirm_password' => '',
    'gender' => '',
    'country' => '',
    'skills' => [],
    'biography' => '',
    'phone' => '',
    'facebook_url' => ''
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fields['name'] = trim($_POST['name']);
    if (!preg_match("/^[a-zA-Z\s]+$/", $fields['name'])) {
        $errors['name'] = "Name is required and can only contain letters and spaces.";
    }

    $fields['email'] = trim($_POST['email']);
    if (!filter_var($fields['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Valid email is required.";
    }

    $fields['facebook_url'] = trim($_POST['facebook_url']);
    if (!filter_var($fields['facebook_url'], FILTER_VALIDATE_URL)) {
        $errors['facebook_url'] = "Valid Facebook URL is required.";
    }

    $fields['password'] = trim($_POST['password']);
    if (!preg_match("/^(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$/", $fields['password'])) {
        $errors['password'] = "Password must be at least 8 characters long and contain at least 1 uppercase letter.";
    }

    $fields['confirm_password'] = trim($_POST['confirm_password']);
    if ($fields['confirm_password'] !== $fields['password']) {
        $errors['confirm_password'] = "Passwords do not match.";
    }

    $fields['phone'] = trim($_POST['phone']);
    if (!preg_match("/^\d+$/", $fields['phone'])) {
        $errors['phone'] = "Valid phone number is required.";
    }

    $fields['gender'] = isset($_POST['gender']) ? $_POST['gender'] : '';
    if (empty($fields['gender'])) {
        $errors['gender'] = "Gender is required.";
    }

    $fields['country'] = $_POST['country'];
    if ($fields['country'] === '') {
        $errors['country'] = "Country is required.";
    }

    if (isset($_POST['skills'])) {
        $fields['skills'] = $_POST['skills'];
    } else {
        $errors['skills'] = "At least one skill must be selected.";
    }

    $fields['biography'] = trim($_POST['biography']);
    if (strlen($fields['biography']) > 200) {
        $errors['biography'] = "Biography must not exceed 200 characters.";
    }

    if (empty($errors)) {
        $_SESSION['user_data'] = $fields;
        header("Location: about.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Registration Form</h2>
    <form method="POST" action="">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($fields['name']); ?>">
            <div class="text-danger"><?php echo $errors['name'] ?? ''; ?></div>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($fields['email']); ?>">
            <div class="text-danger"><?php echo $errors['email'] ?? ''; ?></div>
        </div>

        <div class="mb-3">
            <label for="facebook_url" class="form-label">Facebook URL</label>
            <input type="url" class="form-control" name="facebook_url" value="<?php echo htmlspecialchars($fields['facebook_url']); ?>">
            <div class="text-danger"><?php echo $errors['facebook_url'] ?? ''; ?></div>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" name="password">
            <div class="text-danger"><?php echo $errors['password'] ?? ''; ?></div>
        </div>

        <div class="mb-3">
            <label for="confirm_password" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" name="confirm_password">
            <div class="text-danger"><?php echo $errors['confirm_password'] ?? ''; ?></div>
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Phone Number</label>
            <input type="text" class="form-control" name="phone" value="<?php echo htmlspecialchars($fields['phone']); ?>">
            <div class="text-danger"><?php echo $errors['phone'] ?? ''; ?></div>
        </div>

        <div class="mb-3">
            <label class="form-label">Gender</label><br>
            <input type="radio" name="gender" value="male" <?php echo ($fields['gender'] === 'male') ? 'checked' : ''; ?>> Male
            <input type="radio" name="gender" value="female" <?php echo ($fields['gender'] === 'female') ? 'checked' : ''; ?>> Female
            <div class="text-danger"><?php echo $errors['gender'] ?? ''; ?></div>
        </div>

        <div class="mb-3">
            <label for="country" class="form-label">Country</label>
            <select class="form-select" name="country">
                <option value="">Select your country</option>
                <option value="Philippines" <?php echo ($fields['country'] === 'Philippines') ? 'selected' : ''; ?>>Philippines</option>
                <option value="Canada" <?php echo ($fields['country'] === 'Canada') ? 'selected' : ''; ?>>Canada</option>
                <option value="Switzeland" <?php echo ($fields['country'] === 'Switzerland') ? 'selected' : ''; ?>>Switzerland</option>
                <option value="France" <?php echo ($fields['country'] === 'France') ? 'selected' : ''; ?>>France</option>
                <option value="Japan" <?php echo ($fields['country'] === 'Japan') ? 'selected' : ''; ?>>Japan</option>
                <option value="UAE" <?php echo ($fields['country'] === 'UAE') ? 'selected' : ''; ?>>UAE</option>
                <option value="Taiwan" <?php echo ($fields['country'] === 'Taiwan') ? 'selected' : ''; ?>>Taiwan</option>
            </select>
            <div class="text-danger"><?php echo $errors['country'] ?? ''; ?></div>
        </div>

        <div class="mb-3">
            <label class="form-label">Skills</label><br>
            <input type="checkbox" name="skills[]" value="HTML" <?php echo in_array('HTML', $fields['skills']) ? 'checked' : ''; ?>> HTML
            <input type="checkbox" name="skills[]" value="CSS" <?php echo in_array('CSS', $fields['skills']) ? 'checked' : ''; ?>> CSS
            <input type="checkbox" name="skills[]" value="JavaScript" <?php echo in_array('JavaScript', $fields['skills']) ? 'checked' : ''; ?>> JavaScript
            <input type="checkbox" name="skills[]" value="C++" <?php echo in_array('C++', $fields['skills']) ? 'checked' : ''; ?>> C++
            <input type="checkbox" name="skills[]" value="Python" <?php echo in_array('Python', $fields['skills']) ? 'checked' : ''; ?>> Python
            <div class="text-danger"><?php echo $errors['skills'] ?? ''; ?></div>
        </div>

        <div class="mb-3">
    <label for="biography" class="form-label">Biography</label>
    <textarea class="form-control" name="biography" maxlength="300"><?php echo htmlspecialchars($fields['biography']); ?></textarea>
    <div class="text-danger"><?php echo $errors['biography'] ?? ''; ?></div>
</div>


        <button type="submit" class="btn btn-primary">Register</button>
    </form>
</div>
</body>
</html>
 