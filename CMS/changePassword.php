<?php include 'header.php'; ?>
<?php
include 'dbconn.php';

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
    changeUserPassword();
}
elseif(isset($_SESSION['admin_id'])){
    $admin_id = $_SESSION['admin_id'];
    changeAdminPassword();
}
else{
    header('Location:error.php');
}

?>
<?php

function changeUserPassword(){
    include 'dbconn.php';
    ?>
    <div class="card col-sm-4 mt-2 mx-auto shadow p-3">
<div class="container-sm ">
<form method="post">
    <h4 style="padding:5px; text-align:left; border-bottom:2px solid black; ">Change Password</h4>
    <div class="mb-2">
        <label for="InputPassword1" class="form-label">Current Password</label>
        <input type="password" name="current_password" class="form-control p-1 shadow-sm bg-white rounded" onchange="onChange()" id="InputPassword2" required>
    </div>
    <div class="mb-2">
        <label for="InputPassword1" class="form-label">Password</label>
        <input type="password" name="password" class="form-control p-1 shadow-sm bg-white rounded" onchange="onChange()" id="InputPassword1" required>
    </div>
    <div class="mb-2">
        <label for="InputPassword1" class="form-label">Confirm Password</label>
        <input type="password" name="confirm_password" class="form-control p-1 shadow-sm bg-white rounded" onchange="onChange()" id="InputPassword2" required>
    </div>
    <button type="submit" name="change_password" class="btn btn-dark">Change Password</button>
</form>
</div>
</div>
<script>
    function onChange() {
  const password = document.querySelector('input[name=password]');
  const confirm = document.querySelector('input[name=confirm_password]');
  if (confirm.value === password.value) {
    confirm.setCustomValidity('');
  } else {
    confirm.setCustomValidity('Passwords do not match');
  }
}
    </script>
    <?php
    $select_user = $conn->prepare("SELECT * FROM `users` WHERE user_id = ?");
    $select_user->execute([$_SESSION['user_id']]);
    if($select_user->rowCount() > 0){
     $row = $select_user->fetch(PDO::FETCH_ASSOC);
    }
    if(isset($_POST['change_password'])){
     $current_password = sha1($_POST['current_password']);
     $password = sha1($_POST['password']);
    
     if($current_password == $row['Password']){
         $update_password = $conn->prepare("UPDATE `users` SET Password = ? WHERE user_id = ?");
         $update_password->execute([$password, $_SESSION['user_id']]);
         echo "<script type='text/javascript'>alert('Password Changed Successfully.');</script>";
     }
     else{
        echo "<script type='text/javascript'>alert('Wrong Password Entered.');</script>";;
     }
    }
}


function changeAdminPassword(){
    include 'dbconn.php';
    ?>
    <div class="card col-sm-4 mt-2 mx-auto shadow p-3">
<div class="container-sm ">
<form method="post">
    <h4 style="padding:5px; text-align:left; border-bottom:2px solid black; ">Change Password</h4>
    <div class="mb-2">
        <label for="InputPassword1" class="form-label">Current Password</label>
        <input type="password" name="current_password" class="form-control p-1 shadow-sm bg-white rounded" onchange="onChange()" id="InputPassword2" required>
    </div>
    <div class="mb-2">
        <label for="InputPassword1" class="form-label">Password</label>
        <input type="password" name="password" class="form-control p-1 shadow-sm bg-white rounded" onchange="onChange()" id="InputPassword1" required>
    </div>
    <div class="mb-2">
        <label for="InputPassword1" class="form-label">Confirm Password</label>
        <input type="password" name="confirm_password" class="form-control p-1 shadow-sm bg-white rounded" onchange="onChange()" id="InputPassword2" required>
    </div>
    <button type="submit" name="change_password" class="btn btn-dark">Change Password</button>
</form>
</div>
</div>
<script>
    function onChange() {
  const password = document.querySelector('input[name=password]');
  const confirm = document.querySelector('input[name=confirm_password]');
  if (confirm.value === password.value) {
    confirm.setCustomValidity('');
  } else {
    confirm.setCustomValidity('Passwords do not match');
  }
}
    </script>
    <?php
    $select_user = $conn->prepare("SELECT * FROM `admins` WHERE Admin_id = ?");
    $select_user->execute([$_SESSION['admin_id']]);
    if($select_user->rowCount() > 0){
     $row = $select_user->fetch(PDO::FETCH_ASSOC);
    }
    if(isset($_POST['change_password'])){
     $current_password = sha1($_POST['current_password']);
     $password = sha1($_POST['password']);
    
     if($current_password == $row['Password']){
         $update_password = $conn->prepare("UPDATE `admins` SET Password = ? WHERE Admin_id = ?");
         $update_password->execute([$password, $_SESSION['admin_id']]);
         echo "<script type='text/javascript'>alert('Password Changed Successfully.');</script>";
     }
     else{
        echo "<script type='text/javascript'>alert('Wrong Password Entered.');</script>";;
     }
    }
}


?>

<?php include 'footer.php'; ?>