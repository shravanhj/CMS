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
    $admin_id = '';
    $user_id = '';
    header('location:error.php');
}

?>
<?php
function adminArea(){
include 'dbconn.php';
$select_college = $conn->prepare("SELECT * FROM `requests`");
$select_college->execute();
if($select_college->rowCount() > 0){
    ?>
    <div class="container">
    <h4>List of Colleges Requested to Add : </h4>
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
        <th>Action</th>
    </tr>
    </thead>
    <?php
    while($single_college = $select_college->fetch(PDO::FETCH_ASSOC)){
        $college_code = $single_college['college_code'];
        ?>
        <form method="post">
            <input type="hidden" name="college_code" value="<?=$single_college['college_code'];?>">
            <input type="hidden" name="name" value="<?=$single_college['name'];?>">
            <input type="hidden" name="email" value="<?=$single_college['email'];?>">
            <input type="hidden" name="phone" value="<?=$single_college['phone'];?>">
            <input type="hidden" name="course" value="<?=$single_college['courses'];?>">
            <input type="hidden" name="description" value="<?=$single_college['description'];?>">
            <input type="hidden" name="image" value="<?=$single_college['Image_01'];?>">
            <input type="hidden" name="requested_by" value="<?=$single_college['requested_by'];?>">
            <input type="hidden" name="request_id" value="<?=$single_college['request_id'];?>">
        <tr>
            <td><?= $single_college['college_code'];?></td>
            <td><img class="rounded-circle" width="50px" src="collegeImage/<?= $single_college['Image_01'];?>"></td>
            <td><?= $single_college['name'];?>(College Code: <?= $single_college['college_code'];?>)</td>
            <td><?= $single_college['description'];?></td>
            <td><?= $single_college['email'];?></td>
            <td><?= $single_college['phone'];?></td>
            <td><?= implode(" ", array($single_college['courses'])) ;?></td>
            <?php
            $select_locaation = $conn->prepare("SELECT * FROM `request_location` WHERE college_code = ?");
            $select_locaation->execute([$college_code]);
            if($select_locaation->rowCount() > 0){
                while($single_location = $select_locaation->fetch(PDO::FETCH_ASSOC)){
                    ?>
                    <input type="hidden" name="address" value="<?=$single_location['area'];?>">
                    <input type="hidden" name="city" value="<?=$single_location['city'];?>">
                    <input type="hidden" name="taluk" value="<?=$single_location['taluk'];?>">
                    <input type="hidden" name="district" value="<?=$single_location['district'];?>">
                    <input type="hidden" name="request_location" value="<?=$single_location['request_id'];?>">
                    <td><?= $single_location['taluk'] ;?>, <?= $single_location['district'] ;?>,</br> <b>Tq : </b><?= $single_location['taluk'];?>, </br><b>Dist : </b><?= $single_location['district'] ;?>.</td>
                    <?php
                }
            }
            ?>
            <td><input  type="submit" name="approve" value="Approve" class="btn"></td>
        </tr>
        </form>
        <?php
    }
}

else{
    ?>
    <h2 class="text-center">No Requests found at the Movement</h2>
    <?php
}

if(isset($_POST['approve'])){
    $college_id = $_POST['college_code'];
    $college_name = $_POST['name'];
    $college_email = $_POST['email'];
    $college_phone = $_POST['phone'];
    $description = $_POST['description'];
    $image_01 = $_POST['image'];
    $courses = $_POST['course'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $taluk = $_POST['taluk'];
    $district = $_POST['district'];
    $requested_by = $_POST['requested_by'];
    $request_id = $_POST['request_id'];
    $request_location = $_POST['request_location'];


    $college = $conn->prepare("INSERT INTO `colleges` (college_code, name, email, phone, courses, description, Image_01, user_added) VALUE (?, ?, ?, ?, ?, ?, ?, ?)");
    $college->execute([$college_id, $college_name, $college_email, $college_phone, $courses, $description, $image_01, $requested_by]);
    $course = $conn->prepare("INSERT INTO `location` (college_code, area, city, taluk, district) VALUE (?, ?, ?, ?, ?)");
    $course->execute([$college_id, $address, $city, $taluk, $district]);

    $delete_request = $conn->prepare("DELETE FROM `requests` WHERE request_id = ?");
    $delete_request->execute([$request_id]);

    $delete_request_location = $conn->prepare("DELETE FROM `request_location` WHERE request_id = ?");
    $delete_request_location->execute([$request_location]);
    echo "<script type='text/javascript'>confirm('College Add Request will be Approved.');</script>";
}
}

function userArea(){
    include 'dbconn.php';
$select_college = $conn->prepare("SELECT * FROM `requests` WHERE requested_by = ?");
$select_college->execute([$_SESSION['user_id']]);
if($select_college->rowCount() > 0){
    ?>
    <div class="container">
    <h4>List of Colleges Requested to Add : </h4>
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
        <th>Action</th>
    </tr>
    </thead>
    <?php
    while($single_college = $select_college->fetch(PDO::FETCH_ASSOC)){
        $college_code = $single_college['college_code'];
        ?>
        <form method="post">
            <input type="hidden" name="college_code" value="<?=$single_college['college_code'];?>">
            <input type="hidden" name="name" value="<?=$single_college['name'];?>">
            <input type="hidden" name="email" value="<?=$single_college['email'];?>">
            <input type="hidden" name="phone" value="<?=$single_college['phone'];?>">
            <input type="hidden" name="course" value="<?=$single_college['courses'];?>">
            <input type="hidden" name="description" value="<?=$single_college['description'];?>">
            <input type="hidden" name="image" value="<?=$single_college['Image_01'];?>">
            <input type="hidden" name="requested_by" value="<?=$single_college['requested_by'];?>">
            <input type="hidden" name="request_id" value="<?=$single_college['request_id'];?>">
        <tr>
            <td><?= $single_college['college_code'];?></td>
            <td><img class="rounded-circle" width="50px" src="collegeImage/<?= $single_college['Image_01'];?>"></td>
            <td><?= $single_college['name'];?>(College Code: <?= $single_college['college_code'];?>)</td>
            <td><?= $single_college['description'];?></td>
            <td><?= $single_college['email'];?></td>
            <td><?= $single_college['phone'];?></td>
            <td><?= implode(" ", array($single_college['courses'])) ;?></td>
            <?php
            $select_locaation = $conn->prepare("SELECT * FROM `request_location` WHERE college_code = ?");
            $select_locaation->execute([$college_code]);
            if($select_locaation->rowCount() > 0){
                while($single_location = $select_locaation->fetch(PDO::FETCH_ASSOC)){
                    ?>
                    <input type="hidden" name="address" value="<?=$single_location['area'];?>">
                    <input type="hidden" name="city" value="<?=$single_location['city'];?>">
                    <input type="hidden" name="taluk" value="<?=$single_location['taluk'];?>">
                    <input type="hidden" name="district" value="<?=$single_location['district'];?>">
                    <input type="hidden" name="request_location" value="<?=$single_location['request_id'];?>">
                    <td><?= $single_location['taluk'] ;?>, <?= $single_location['district'] ;?>,</br> <b>Tq : </b><?= $single_location['taluk'];?>, </br><b>Dist : </b><?= $single_location['district'] ;?>.</td>
                    <?php
                }
            }
            ?>
            <td><input  type="submit" name="approve" value="Approve" class="btn"></td>
        </tr>
        </form>
        <?php
    }
}

else{
    ?>
    <h2 class="text-center">No Requests found at the Movement</h2>
    <?php
}

if(isset($_POST['approve'])){
    $college_id = $_POST['college_code'];
    $college_name = $_POST['name'];
    $college_email = $_POST['email'];
    $college_phone = $_POST['phone'];
    $description = $_POST['description'];
    $image_01 = $_POST['image'];
    $courses = $_POST['course'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $taluk = $_POST['taluk'];
    $district = $_POST['district'];
    $requested_by = $_POST['requested_by'];
    $request_id = $_POST['request_id'];
    $request_location = $_POST['request_location'];


    $college = $conn->prepare("INSERT INTO `colleges` (college_code, name, email, phone, courses, description, Image_01, user_added) VALUE (?, ?, ?, ?, ?, ?, ?, ?)");
    $college->execute([$college_id, $college_name, $college_email, $college_phone, $courses, $description, $image_01, $requested_by]);
    $course = $conn->prepare("INSERT INTO `location` (college_code, area, city, taluk, district) VALUE (?, ?, ?, ?, ?)");
    $course->execute([$college_id, $address, $city, $taluk, $district]);

    $delete_request = $conn->prepare("DELETE FROM `requests` WHERE request_id = ?");
    $delete_request->execute([$request_id]);

    $delete_request_location = $conn->prepare("DELETE FROM `request_location` WHERE request_id = ?");
    $delete_request_location->execute([$request_location]);
    echo "<script type='text/javascript'>confirm('College Add Request will be Approved.');</script>";
}
}
?>

<?php include 'footer.php';?>