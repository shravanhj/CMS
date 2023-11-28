<?php include 'header.php'; ?>
<?php
include 'dbconn.php';
if(isset($_SESSION['admin_id'])){
    $admin_id = $_SESSION['admin_id'];
    $select_user = $conn->prepare("SELECT * FROM `admins` WHERE Admin_id = ?");
    $select_user->execute([$admin_id]);
    $row = $select_user->fetch(PDO::FETCH_ASSOC);
    ?>
    <div class="container rounded border mt-5  mx-auto">
        <div class="row">
            <div class="col-md-5 mx-auto border-right align-center">
            <div class="card">
    <div class="card-header">
        <h4>Admin Profile</h4>
    </div>
    <div class="card-body">
        <div class="col-md-12 mb-2"><label class="labels me-5">Name&emsp; &emsp; &emsp;</label>: <b style="text-transform: capitalize;"><?= $row['Name'] ;?></b></div>
            <div class="col-md-12 mb-2"><label class="labels me-5">Mobile No&emsp;&ensp;</label>: <b style="text-transform: capitalize;"><?= $row['Phone_No'] ;?></b></div>
            <div class="col-md-12 mb-2"><label class="labels me-5">Email&emsp; &emsp; &ensp; &ensp;</label>: <b style="text-transform: capitalize;"><?= $row['Email'] ;?></b></div>
            <div class="mt-2"><a class="btn btn-dark" href="changePassword.php">Change Password</a></div>
        </div>
    </div>
</div>
</div>
</div>

<?php
}
elseif(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
    $select_user = $conn->prepare("SELECT * FROM `users` WHERE user_id = ?");
    $select_user->execute([$user_id]);
    $row = $select_user->fetch(PDO::FETCH_ASSOC);
    ?>
    <div class="container rounded border mt-5  mx-auto">
        <div class="row">
            <div class="col-md-5 mx-auto border-right align-center">
            <div class="card">
    <div class="card-header">
        <h4>My Profile</h4>
    </div>
    <div class="card-body">
        <div class="col-md-12 mb-2"><label class="labels me-5">Name&emsp; &emsp; &emsp;</label>: <b style="text-transform: capitalize;"><?= $row['Name'] ;?></b></div>
                        <div class="col-md-12 mb-2"><label class="labels me-5">Mobile No&emsp;&ensp;</label>: <b style="text-transform: capitalize;"><?= $row['Phone_No'] ;?></b></div>
                        <div class="col-md-12 mb-2"><label class="labels me-5">Email&emsp; &emsp; &ensp; &ensp;</label>: <b style="text-transform: capitalize;"><?= $row['Email'] ;?></b></div>
                        <div class="mt-2"><a class="btn btn-dark" href="changePassword.php">Change Password</a></div>
    </div>
    </div>
            </div>
            </div>
            
        </div>
        <?php

}
else{
    header('location:error.php');
}

?>

<?php include 'footer.php'; ?>