<?php
//Handling login
session_start();

//checking if user is already logged in
if (isset($_SESSION['username']))
{
    header("location: welcome.php");
    exit;
}

require_once "config.php";

$username = $password = "";
$username_err = $password_err = "";

//if request method is post
if ($_SERVER['REQUEST_METHOD'] == "POST")
{
    if(empty(trim($_POST['username'])))
    {
        $username_err = "Please enter username";
    }
    else if(empty(trim($_POST['password'])))
    {
        $password_err =  "Please enter password";
    }
    else
    {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

    }

  if(empty($username_err) && empty($password_err))
  {
    
      $sql = "SELECT id,username,password FROM users WHERE username = ?";
      $stmt =mysqli_prepare($conn,$sql);
      mysqli_stmt_bind_param($stmt,"s",$param_username);
      $param_username = $username;
      //trying to execute
      if(mysqli_stmt_execute($stmt))
      {
          mysqli_stmt_store_result($stmt);
          if(mysqli_stmt_num_rows($stmt) == 1)
          {
              mysqli_stmt_bind_result($stmt,$id,$username,$hashed_password);
              if(mysqli_stmt_fetch($stmt))
              {
                  if(password_verify($password,$hashed_password))
                  {
                      //correct password
                      //allow login
                      session_start();
                      $_SESSION['username']=$username;
                      $_SESSION['id'] = $id;
                      $_SESSION['loggedin'] = true;

                      //redirect user to welcome page
                      header("location: welcome.php");

                  }
              }
          }
      }
  }  

}
?>




<!doctype html>
<html lang="en">
  <head>
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

    <title>Login System</title>
  </head>
  <body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">PHP LOGIN</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="register.php">Register</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="login.php">Logout</a>
        </li>
         
      </ul>
      <form class="d-flex">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>

<div class="conatiner mt-3">
<h3>Please login here</h3>
<hr>
<form action="" method="POST">
  <div class="mt-2 mb-3">
    <label for="exampleInputEmail1" class="form-label">Username</label>
    <input type="text" class="form-control" id="exampleInputEmail1" name ="username" aria-describedby="emailHelp" placeholder="Username">
    
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Password</label>
    <input type="password" class="form-control" name ="password" id="exampleInputPassword1" placeholder="Password">
  </div>

  
  
  
  <button type="submit" class="btn btn-primary" >Submit</button>
</form>
</div>



    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

    
  </body>
</html>