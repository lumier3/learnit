<?php 

// Include database connectivity
      
include "../config/db_connect.php";
  
if (isset($_POST['submit'])) {
    
    $errorMsg = "";
    
    $name = mysqli_real_escape_string($db, $_POST['name']);
    $email    = mysqli_real_escape_string($db, $_POST['email']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
    $cpassword = mysqli_real_escape_string($db, $_POST['confirm_password']);
    
    
    $sql = "SELECT * FROM students WHERE email = '$email'";
    $execute = mysqli_query($db, $sql);
      
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMsg = "Email in not valid try again";
    }else if(strlen($password) < 6) {
        $errorMsg  = "Password should be six digits";
    } else if($execute->num_rows == 1){
        $errorMsg = "This Email is already exists";
    }else{
        if($password!= $cpassword) {
            $errorMsg = "Passwords do not match";
        } else {
            $password = password_hash($password, PASSWORD_DEFAULT);
            $query= "INSERT INTO students(name,email,password) 
                    VALUES('$name', '$email','$password')";
            $result = mysqli_query($db, $query);
        }
    
    if ($result == true) {
        header("Location:login.php");
    }else{
        $errorMsg  = "You are not Registred..Please Try again";
    }
  }
}


?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles.css">
    <?php include '../includes/cdn.php';?>
</head>
<body>
        <?php
            if (isset($errorMsg)) {
                 echo "<div class='alert alert-danger alert-dismissible'>
                        <button type='button' class='close' data-dismiss='alert'>&times;</button>
                                $errorMsg
                        </div>";
                }
        ?>

<form class="max-w-[400px] mx-auto mt-20" method="POST">
        <div class="mb-6">
            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
            <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="John" required>
        </div>
        <div class="mb-6">
            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email address</label>
            <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="john.doe@company.com" required>
        </div> 
        <div class="mb-6">
            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
            <input type="password" name="password" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="•••••••••" required>
        </div> 
        <div class="mb-6">
            <label for="confirm_password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Confirm password</label>
            <input type="password" name="confirm_password" id="confirm_password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="•••••••••" required>
        </div> 
        <div class="mb-6">
                <p>If you have an account , <a href="./login.php" class="text-blue-500">Login here</a></p>
        </div>
        <button type="submit" name="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Register</button>
</form>
<?php include '../includes/scripts.php';?>

</body>
</html>