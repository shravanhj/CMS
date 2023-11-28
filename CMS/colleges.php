<?php include 'header.php'; ?>
<?php
include 'dbconn.php';
if(isset($_SESSION['admin_id'])){
    $admin_id = $_SESSION['admin_id'];
    adminArea();
}
elseif(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
    userArea();
}
else{
    header('location:error.php');
}

?>
<?php
function adminArea(){
    include 'dbconn.php';
    $select_admin = $conn->prepare("SELECT * FROM `admins` WHERE Admin_id = ?");
    $select_admin->execute([$_SESSION['admin_id']]);
    $single_admin = $select_admin->fetch(PDO::FETCH_ASSOC);
    
    ?>
    <div class="container">
    <h5 class="text-danger" style="text-transform:captialize">Hi, <?= $single_admin['Name'];?>(Admin)</h5>
    </div>
    <?php

    $select_college = $conn->prepare("SELECT * FROM `colleges`");
    $select_college->execute();

    if($select_college->rowCount() > 0){
        ?>
        <div class="container">
        <h4>List of Colleges added to Database : </h4>
        <table class="table table-striped">
        <thead>
        <tr>
            <th>College Code</th>
            <th>College Image</th>
            <th>College Name</th>
            <th>About</th>
            <th>Email</th>
            <th>Phone No</th>
            <th>Courses</th>
            <th>Location</th>
            <th>Added by the User</th>
        </tr>
        </thead>
        <?php
        while($single_college = $select_college->fetch(PDO::FETCH_ASSOC)){
            $college_code = $single_college['college_code'];
            ?>
            
                <tr>
                    <td><?= $single_college['college_code'];?></td>
                    <td><img class="rounded-circle" width="50px" src="collegeImage/<?= $single_college['Image_01'];?>"></td>
                    <td><?= $single_college['name'];?>(College Code: <?= $single_college['college_code'];?>)</td>
                    <td><?= $single_college['description'];?></td>
                    <td><?= $single_college['email'];?></td>
                    <td><?= $single_college['phone'];?></td>
                    <td><?= implode(" ", array($single_college['courses'])) ;?></td>
            <?php
                        $select_locaation = $conn->prepare("SELECT * FROM `location` WHERE college_code = ?");
                        $select_locaation->execute([$college_code]);
                        
                        while($single_location = $select_locaation->fetch(PDO::FETCH_ASSOC)){
                            ?>
                            <td><?= $single_location['area'] ;?>, <?= $single_location['city'] ;?>,</br> <b>Tq : </b><?= $single_location['taluk'];?>, </br><b>Dist : </b><?= $single_location['district'] ;?>.</td>
                            <td><?= $single_college['user_added'];?></td>
                        </tr>
            <?php
            }
        }
    }
    ?>
    </table>
</div>
    <?php
}

function userArea(){
    include 'dbconn.php';
    $select_user = $conn->prepare("SELECT * FROM `users` WHERE user_id = ?");
    $select_user->execute([$_SESSION['user_id']]);
    $single_user = $select_user->fetch(PDO::FETCH_ASSOC);
    
    ?>
    <div class="container">
    <h5 class="text-danger" style="text-transform:captialize">Hi, <?= $single_user['Name'];?>(Student)</h5>
    </div>
    <?php

    $select_college = $conn->prepare("SELECT * FROM `colleges` WHERE user_added = ?");
    $select_college->execute([$_SESSION['user_id']]);

    if($select_college->rowCount() > 0){
        ?>
        <div class="container">
        <h4>List of Colleges added to Database : </h4>
        <table class="table table-striped">
        <thead>
        <tr>
            <th>College Code</th>
            <th>College Image</th>
            <th>College Name</th>
            <th>About</th>
            <th>Email</th>
            <th>Phone No</th>
            <th>Courses</th>
            <th>Location</th>
            <th>Added by the User</th>
        </tr>
        </thead>
        <?php
        while($single_college = $select_college->fetch(PDO::FETCH_ASSOC)){
            $college_code = $single_college['college_code'];
            ?>
            
                <tr>
                    <td><?= $single_college['college_code'];?></td>
                    <td><img class="rounded-circle" width="50px" src="collegeImage/<?= $single_college['Image_01'];?>"></td>
                    <td><?= $single_college['name'];?>(College Code: <?= $single_college['college_code'];?>)</td>
                    <td><?= $single_college['description'];?></td>
                    <td><?= $single_college['email'];?></td>
                    <td><?= $single_college['phone'];?></td>
                    <td><?= implode(" ", array($single_college['courses'])) ;?></td>
            <?php
                        $select_locaation = $conn->prepare("SELECT * FROM `location` WHERE college_code = ?");
                        $select_locaation->execute([$college_code]);
                        
                        while($single_location = $select_locaation->fetch(PDO::FETCH_ASSOC)){
                            ?>
                            <td><?= $single_location['area'] ;?>, <?= $single_location['city'] ;?>,</br> <b>Tq : </b><?= $single_location['taluk'];?>, </br><b>Dist : </b><?= $single_location['district'] ;?>.</td>
                            <td><?= $single_college['user_added'];?></td>
                        </tr>
            <?php
            }
        }
    }
    ?>
    </table>
</div>
    <?php
}
?>

<?php include 'footer.php'; ?>