<?php
require_once "config.php";

$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

if ($_SERVER['REQUEST_METHOD'] == "POST")
{
    //Checking if username is empty
    if (empty(trim($_POST['username'])))
    {
        $username_err = "Username cannot be empty";
    }
    else
    {
        $sql = "SELECT id FROM users WHERE username =?";
        $stmt = mysqli_prepare($conn , $sql);
        if($stmt)
        {
            mysqli_stmt_bind_param($stmt, "s",$param_username);

            //setting param username value
            $param_username = trim($_POST['username']);

            //trying to execute this statement
            if (mysqli_stmt_execute($stmt))
            {
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) ==1)
                {
                    $username_err = "This username is already taken";

                }
                else
                {
                    $username = trim($_POST['username']); 
                }
            }
            else
            {
                echo "Something went wrong";
            }
        }
    }
    mysqli_stmt_close($stmt);




//Checking password
if((trim($_POST['password'])))
{
    $password_err = "Password cannot be blank";
}
elseif(strlen(trim($_POST['password'])) <5)
{
    $password_err = "Password cannot be less than 5 characters";
}
else
{
    $password = trim($_POST['password']);
}

//Checking for confirm password
if(trim($_POST['password']) == trim($_POST['confirm_password']))
{
    $password_err = "Passwords should match";
}


//NO errors
if(empty($username_err) && empty($$password_err) && empty($confirm_password_err))
{
    $sql = "INSERT INTO users (username ,password) VALUES (?,?)";
    $stmt = mysqli_prepare($conn, $sql);
    if($stmt)
    {
        mysqli_stmt_bind_param($stmt , "ss",$param_username,$param_password);


        //Setting these parameters
        $param_username = $username;
        $param_password = $password;

        //Trying to execute the query
        if (mysqli_stmt_execute($stmt))
        {
            header("location: login.php");            
        }
        else
        {
            echo "Something went wrong...cannot redirect!";
        }
     
    mysqli_stmt_close($stmt);
      }

  }
  mysqli_close($conn);
}
?>




<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
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
          <a class="nav-link active" aria-current="page" href="login.php">Login</a>
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
<h3>Please register here</h3>
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

  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Confirm Password</label>
    <input type="password" class="form-control" name ="confirm password" id="exampleInputPassword1" placeholder="Type password again">
  </div>
  
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>



    

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
    -->
  </body>
</html>