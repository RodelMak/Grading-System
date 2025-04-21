<?php
session_start();
include("connection.php");
include("functions.php");

$error_message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_name = $_POST['user_name'];
    $password = $_POST['password'];

    if (!empty($user_name) && !empty($password) && !is_numeric($user_name)) {
        // Use prepared statements to prevent SQL injection
        $stmt = $con->prepare("SELECT * FROM users WHERE user_name = ? LIMIT 1");
        $stmt->bind_param("s", $user_name);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && mysqli_num_rows($result) > 0) {
            $user_data = mysqli_fetch_assoc($result);
            if (password_verify($password, $user_data['password'])) {
                $_SESSION['user_id'] = $user_data['user_id'];
                header("Location: account.php");
                die;
            } else {
                $error_message = "Incorrect password.";
            }
        } else {
            $error_message = "User not found.";
        }
        $stmt->close();
    } else {
        $error_message = "Please fill in all fields correctly.";
    }
}

?>

<?php include 'includes/header.php' ?>

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="form-register bg-success text-white p-4 rounded " style="width: 100%; max-width: 400px;">
      <form method="post">
         <h1>Log-In Form</h1>


         <div class="mb-3">
            <input type="text" class="form-control" placeholder="UserName" name="user_name" required>
            
         </div>

         <div class="mb-3">
            <input type="password" class="form-control" placeholder="Password" name="password" required> 
         </div>

        

        

         <div class="d-grid mb-3">
            <button type="submit" name="submit" class="btn btn-primary bg-info">Log-In</button>
         </div>

         <div class="text-center mb-3">
            <p>Dont Have an account?<a href="index.html" class="text-info"><a href="register.php" >Register</a></p>
         </div>

      </form>
    </div>
</div>



 <?php include 'includes/footer.php'  ?>