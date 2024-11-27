<!doctype html>
<html lang="en" data-bs-theme="cyan">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link rel="stylesheet" href="login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>

    <div class="alert alert-danger" role="alert" id="alert_danger_custom" name="alrt_danger" style="display: none;">
        <button type="button" class="btn-close" aria-label="Close" id="close_danger"></button>
        Invalid Username/Password!
    </div>

    <div class="alert alert-success" role="alert" id="alert_success_custom" name="alrt_success" style="display: none;">
        <button type="button" class="btn-close" aria-label="Close" id="close_success"></button>
        Welcome to the System: <?php $email = $_POST['floatingInput'] ?? ''; echo "$email"; ?>
    </div>

    <div class="round-container text-center" id="cntnr">

        <div class="mb-4">
            <img src="blank.png" alt="Profile Picture" class="profile-pic">
        </div>

        
        <form method="post" id="loginForm">
            <div class="mb-3">
                <select class="form-select" name="options" aria-label="Default select example">
                    <option value="admin" selected>Admin</option>
                    <option value="Content Manager">Content Manager</option>
                    <option value="System User">System User</option>
                </select>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="floatingInput" id="floatingInput" placeholder="Username"
                    required>
                <label for="floatingInput">User Name</label>
            </div>

            <div class="form-floating mb-4">
                <input type="password" class="form-control" name="floatingPassword" id="floatingPassword"
                    placeholder="Password" required>
                <label for="floatingPassword">Password</label>
            </div>

            <button type="submit" class="btn btn-primary" name="sbtn">SIGN IN</button>
        </form>

    </div>

    

    <script>

        document.getElementById('close_danger')?.addEventListener('click', function () {
            document.getElementById('alert_danger_custom').style.display = 'none';
        });

        document.getElementById('close_success')?.addEventListener('click', function () {
            document.getElementById('alert_success_custom').style.display = 'none';
        });


        document.getElementById('loginForm').addEventListener('submit', function () {
            document.getElementById('alert_danger_custom').style.display = 'none';
            document.getElementById('alert_success_custom').style.display = 'none';
        });
    </script>

</body>

</html>

<?php
// Define accounts with hashed passwords
$accounts = [
    "admin" => [
        "admin1" => password_hash("admin123", PASSWORD_DEFAULT),
        "admin2" => password_hash("admin123", PASSWORD_DEFAULT),
    ],
    "content_manager" => [
        "manager1" => password_hash("manager123", PASSWORD_DEFAULT),
        "manager2" => password_hash("manager123", PASSWORD_DEFAULT),
    ],
    "system_user" => [
        "user1" => password_hash("user123", PASSWORD_DEFAULT),
        "user2" => password_hash("user123", PASSWORD_DEFAULT),
    ],
];

$alert = ''; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $options = $_POST['options'] ?? '';
    $email = $_POST['floatingInput'] ?? '';
    $password = $_POST['floatingPassword'] ?? '';

    // Function to validate user credentials
    function validateUser ($accounts, $userType, $email, $password) {
        if (isset($accounts[$userType][$email]) && password_verify($password, $accounts[$userType][$email])) {
            return true;
        }
        return false;
    }

    // Check user credentials based on selected user type
    if (validateUser ($accounts, strtolower(str_replace(" ", "_", $options)), $email, $password)) {
        $alert = 'success';
    } else {
        $alert = 'danger';
    }
}

if ($alert === 'success') {
    echo '<script>document.getElementById("alert_success_custom").style.display = "block";</script>';
} elseif ($alert === 'danger') {
    echo '<script>document.getElementById("alert_danger_custom").style.display = "block";</script>';
}
?>