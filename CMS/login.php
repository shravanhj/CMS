<?php 
include 'header.php'; 
include 'dbconn.php';
?>

<?php

if(isset($_SESSION['user_id'])){
    $user_id = 'user_id';
    header('location:index.php');
}

else{
    $admin_id = '';
}


if(isset($_POST['submit'])){
    $email = $_POST['email'];
    $password = sha1($_POST['password']);

    $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
    $select_user->execute([$email, $password]);
    $row = $select_user->fetch(PDO::FETCH_ASSOC);

    if($select_user->rowCount() > 0){
        $_SESSION['user_id'] = $row['user_id'];
        header('location:home.php');
    }
    else{
        $message[] = 'User not Registered';
    }
}
?>



<div class="card col-sm-4 mt-2 mx-auto shadow p-3">
<div class="container-sm ">
<form method="post">
<?php
   if(isset($message)){
      foreach($message as $message){
         echo '
         <div class="alert" style="background-color: black; padding:10px; color:white;">
            <span class="closebtn" onClick="this.parentElement.remove()">&times;</span>
            '.$message.'
            </div>';
      }
   }
?>
    <h4 style="padding:5px; text-align:left; border-bottom:2px solid black; ">CSM User Login</h4>
    <div class="mb-2">
        <label for="InputEmail1" class="form-label">Email address</label>
        <input type="email" name="email" class="form-control p-1 shadow-sm bg-white rounded" id="InputEmail1" required>
    </div>
    <div class="mb-2">
        <label for="InputPassword1" class="form-label">Password</label>
        <input type="password" name="password" class="form-control p-1 shadow-sm bg-white rounded" id="InputPassword1" required>
    </div>
    <div class="mb-2 form-check">
        <input type="checkbox" class="form-check-input" id="Check1">
        <label class="form-check-label">Keep me Logged In</a></label>
    </div>
    <button type="submit" name="submit" class="btn btn-dark">Login</button>
</form>
<label for="logIn" class="label">Student Registration <a href="signup.php" style="text-decoration:none;">Click Here.</a></label>
</div>
</div>

<?php include 'footer.php'; ?>