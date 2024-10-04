<?php
// Database configuration
include('dbh.inc.php');

$usernameError = $passwordError = $emailError = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

   
    if (strlen($username) < 2) {
        $usernameError = "Username must be at least 2 characters long.";
    }
    if (strlen($password) < 8) {
        $passwordError = "Password must be at least 8 characters long.";
    }

    // Check if there are no validation errors
    if (empty($usernameError) && empty($passwordError)) {
        // Hash the password for security
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Prepare an SQL statement to insert data
        $stmt = $conn->prepare("INSERT INTO users (name, username, password, email) VALUES (?, ?, ?, ?)");

        // Bind the parameters
        $stmt->bind_param('ssss', $name, $username, $hashedPassword, $email);

        // Execute the statement
        if ($stmt->execute()) {
            $newLocation = "ideaProfile.php";
            header("Location: ".$newLocation);
            exit();
        } else {
            $emailError = "Error occurred while signing up: " . $stmt->error;
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SignUp</title>
 
  <link rel ="stylesheet" href = "profileSignUp.css">
</head>
<body>
    <div class="popup">
        <div class="close-btn">&times;</div>
        <div class="form">
            <h1>💗</h1>
            <h2>Create Account</h2>
            <p>Are you ready to know more about us? We can't wait to be part of you. Please answer the required field and let's get the party started.</p>
            
            <form method="POST" action="profileSignUp.php">
            <div class="form-element">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" placeholder="Enter name" required>
                <span class="error"></span>
            </div>
            <div class="form-element">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Enter username" required>
                <span class="error"> <?php echo $usernameError;?></span>
            </div>
            <div class="form-element">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter password" required>
                <span class="error"> <?php echo $passwordError;?></span>
            </div>
            <div class="form-element">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter email" required>
                <span class="error"></span>
            </div>
            <div class="form-element">
                <button type="submit" name="submit">Sign up</button>
            </div>
            <div class="form-element">
                <input type="checkbox" id="remember-me">
            <label for="remember-me">Remember me</label>
            </div>
           <small>Already have an account?<a href="ideaProfile.php">Log in</a></small>
        </form>
            <!-- Form ends here -->
            <h2>˖⁺‧₊˚♡˚₊‧⁺˖♡︎˖⁺‧₊˚♡˚₊‧⁺˖</h2>
        </div>
    </div> 
</body>
</html>