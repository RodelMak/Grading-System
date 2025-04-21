<?php
session_start();
include("connection.php");
include("functions.php");

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $user_name = $_POST['user_name'];
    $password = $_POST['password'];

    if(!empty($user_name) && !empty($password) && !is_numeric($user_name)){
        $user_id = random_num(20);
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        //Use prepared statement to prevent SQL injection
        $stmt = $con->prepare("INSERT INTO users (user_id, user_name, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $user_id, $user_name, $hashed_password);
        $stmt->execute();
        $stmt->close();

        header("Location: index.php");
        die;
    }else{
        echo "Please enter some valid information!";
    }
}
?>


<?php include 'includes/header.php' ?>

<div class="container d-flex bg-dark justify-content-center align-items-center vh-100">
    <div class="form-register bg-success text-white p-4 rounded " style="width: 100%; max-width: 400px;">
      <form method="post">
         <h1>Register Form</h1>


         <div class="mb-3">
            <input type="text" class="form-control" placeholder="UserName" name="user_name" required>
            
         </div>

         <div class="mb-3">
            <input type="password" class="form-control" placeholder="Password" name="password" required> 
         </div>

         <div class="d-grid mb-3">
            <button type="submit" name="submit" class="btn btn-primary bg-info">Register</button>
         </div>

         <div class="text-center mb-3">
            <p>Already have an Account?<a href="index.html" class="text-info"><a href="index.php" >Log-in</a></p>
         </div>

      </form>
    </div>
</div>


	<?php include 'includes/footer.php'  ?>