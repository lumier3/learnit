<?php
  session_start();

  if (isset($_SESSION['id'])) {
      header("Location:../index.php");
  }

  // Include database connectivity
    include "../config/db_connect.php";    

  if (isset($_POST['submit'])) {

      $errorMsg = "";

      $email    = mysqli_real_escape_string($db, $_POST['email']);
      $password = mysqli_real_escape_string($db, $_POST['password']); 
      
  if (!empty($email) || !empty($password)) {
        $query  = "SELECT * FROM students WHERE email = '$email'";
        $result = mysqli_query($db, $query);
        if(mysqli_num_rows($result) == 1){
          while ($row = mysqli_fetch_assoc($result)) {
            if (password_verify($password, $row['password'])) {
                $_SESSION['id'] = $row['id'];
                $_SESSION['name'] = $row['name'];

                
                
                // When setting the cookie during login
                setcookie('userId', $row["id"], time() + (86400 * 30), "/"); // 30 days expiration
                // setcookie('pass', $row["password"], time() + (86400 * 30), "/"); // 30 days expiration
                header("Location:../index.php");
                exit();
            }else{
                $errorMsg = "Email or Password is invalid";
            }    
          }
        }else{
          $errorMsg = "No user found on this email";
        } 
    }else{
      $errorMsg = "Email and Password is required";
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
    <?php include "../includes/cdn.php"; ?>
</head>
<body>
    <div class="w-[90%] md:max-w-[400px]  mx-auto mt-48 md:mt-20">
    <?php
           if (isset($errorMsg)) {
            echo '<div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                <span class="font-medium">' . $errorMsg . '</span>
            </div>';
        }
        
        ?>
    <form action=""  method="POST">
        <div class="mb-6">
            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email address</label>
            <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="john.doe@company.com" required>
        </div> 
        <div class="mb-6">
            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
            <input type="password" name="password" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="•••••••••" required>
        </div>
        <div class="mb-6">
                <p>If you don't have an account , <a href="./register.php" class="text-blue-500">Register here.</a></p>
        </div>
        <button type="submit" name="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>

    </form>
    </div>


    <?php include "../includes/scripts.php"; ?>
</body>
</html>