<?php
include 'dbconn.php';
include 'header.php';
?>

<?php
if(isset($_SESSION['admin_id'])){
    $select_admin = $conn->prepare("SELECT * FROM `admins` WHERE Admin_id = ?");
    $select_admin->execute([$_SESSION['admin_id']]);
    $single_admin = $select_admin->fetch(PDO::FETCH_ASSOC);

    $select_colleges = $conn->prepare("SELECT * FROM `colleges`");
    $select_colleges->execute();

    $select_request = $conn->prepare("SELECT * FROM `requests`");
    $select_request->execute();

    $select_add_request = $conn->prepare("SELECT * FROM `colleges` WHERE user_added != ' '");
    $select_add_request->execute();

    $select_request_pending = $conn->prepare("SELECT * FROM `requests`");
    $select_request_pending->execute();
    ?>
    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Total No. of Colleges Added : <?= $select_colleges->rowCount();?> </h4>
                <h4 class="card-text">Total No. of College Add Request : <?= $select_request->rowCount() + $select_add_request->rowCount();?></h4>
                <h4 class="card-title">No. of College Requests Approved : <?= $select_add_request->rowCount();?></h4>
                <h4 class="card-title">No. of College Requests Pending : <?= $select_request_pending->rowCount();?></h4>
                
            </div>
        </div>
    </div>
    <?php
}

elseif(isset($_SESSION['user_id'])){
    $select_student = $conn->prepare("SELECT * FROM `users` WHERE user_id = ?");
    $select_student->execute([$_SESSION['user_id']]);
    $single_student = $select_student->fetch(PDO::FETCH_ASSOC)
    ?>
    <div class="card col-sm-4 mt-2 mx-auto shadow p-3">
    <h5 class="text-danger" style="text-transform:captialize">Hi, <?= $single_student['Name'];?>(Student)</h5>

        <form method="post">
            <h4 style="padding:5px; text-align:left; border-bottom:2px solid black; ">Search Your Desired Colleges</h4>
            <div class="mb-2">
                <label class="form-label">Search by College Name</label>
                <input type="text" name="college_name" class="form-control p-1 shadow-sm bg-white rounded">
            </div>
            <button type="submit" name="name_search" class="btn btn-dark">Search</button>
            <p class="card-text">OR</p>
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label>Search by Location</label>
                    <select name="college_location" class="form-select form-select-sm p-1 shadow-sm bg-white rounded" required>
                        <option selected disabled>Select</option>
                        <option>Bagalkot</option>
                        <option>Belagavi</option>
                        <option>Dharwad</option>
                        <option>Vijayapur</option>
                        <option>Gadag</option>
                    </select>
                </div>
            </div>
            <button type="submit" name="location_search" class="btn btn-dark">Search</button>
        </form>
        </div>

        <?php
        if(isset($_POST['name_search'])){
        $college_name = $_POST['college_name'];
        $clg_name = substr($college_name, 0, 3);

        $select_college = $conn->prepare("SELECT * FROM `colleges` WHERE name LIKE '%{$clg_name}%'");
        $select_college->execute();

        if($select_college->rowCount() > 0){
            while($single_college = $select_college->fetch(PDO::FETCH_ASSOC)){
                $college_code = $single_college['college_code'];
                ?>
                <div class="container">
                    <div class="card mb-3">
                    <img class="rounded-circle" width="150px" src="collegeImage/<?= $single_college['Image_01'];?>">
                        <div class="card-body">
                            <h2 class="card-title"><?= $single_college['name'];?>(College Code: <?= $single_college['college_code'];?>)</h2>
                            <h6 class="card-text">About</h6>
                            <p class="card-text"><?= $single_college['description'];?></p>
                            <p class="card-text"><b>Contact : </b>Email : <?= $single_college['email'];?>, Phone No : <?= $single_college['phone'];?></p>
                            <h6 class="card-text"> </h6>
                            <p class="card-text"><b>Courses : </b><?= implode(" ", array($single_college['courses'])) ;?></p>
                <?php
                            $select_locaation = $conn->prepare("SELECT * FROM `location` WHERE college_code = ?");
                            $select_locaation->execute([$college_code]);
                            
                            while($single_location = $select_locaation->fetch(PDO::FETCH_ASSOC)){
                                ?>
                                <p class="card-text"><b>College Location : </b><?= $single_location['area'] ;?>, <?= $single_location['city'] ;?>, <b>Tq : </b><?= $single_location['taluk'];?>, <b>Dist : </b><?= $single_location['district'] ;?>.</p>
                                <p class="card-text"></p>
                                <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                            </div>
                            </div>
                        </div>
                    </div>
                                <?php
                            }
            }
        }
        }

        elseif(isset($_POST['location_search'])){
        $college_location = $_POST['college_location'];

        $select_locaation = $conn->prepare("SELECT * FROM `location` WHERE district = ?");
        $select_locaation->execute([$college_location]);

        while($single_location = $select_locaation->fetch(PDO::FETCH_ASSOC)){
            $college_code = $single_location['college_code'];
            ?>
            <div class="container mt-4">
            <div class="card"></div>
            <?php
            $select_college = $conn->prepare("SELECT * FROM `colleges` WHERE college_code = ?");
            $select_college->execute([$college_code]);
            while($single_college = $select_college->fetch(PDO::FETCH_ASSOC)){
                ?>
                    <img class="rounded-circle" width="150px" src="collegeImage/<?= $single_college['Image_01'];?>">
                        <div class="card-body">
                            <h2 class="card-title"><?= $single_college['name'];?>(College Code: <?= $single_college['college_code'];?>)</h2>
                            <h6 class="card-text mt-4">About</h6>
                            <p class="card-text"><?= $single_college['description'];?></p>
                            <p class="card-text"><b>Contact : </b>Email : <?= $single_college['email'];?>, Phone No : <?= $single_college['phone'];?></p>
                            <h6 class="card-text"> </h6>
                            <p class="card-text"><b>Courses : </b><?= implode(" ", array($single_college['courses'])) ;?></p>
                            <p class="card-text"><b>College Location : </b><?= $single_location['area'] ;?>, <?= $single_location['city'] ;?>, <b>Tq : </b><?= $single_location['taluk'];?>, <b>Dist : </b><?= $single_location['district'] ;?>.</p>
                            <p class="card-text"></p>
                            <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                <?php
            }
            ?>
                </div>
            </div>
            <?php
        }
        }
        ?>
            <?php
        }

        else{
            ?>
            <div id="features" class="container w-50 p-4 text-light bg-danger mt-5">
                <h3 class="text-center ">What is Course Management System</h3>
                <p class="card-text">A course management system (CMS) is an enterprise software system dedicated to automating and optimizing Instructor-Led Training and virtual Instructor-Led Training (ILT/vILT) management. </p>
            </div>
            <div id="features" class="container w-50 p-4 text-light bg-dark mt-5">
                <h3 class="text-center ">Features Course Management System</h3>
                <p class="card-text">A course management system (CMS) is an enterprise software system dedicated to automating and optimizing Instructor-Led Training and virtual Instructor-Led Training (ILT/vILT) management. </p>
            </div>
            <div class="container mt-5 mx-auto">
                <div class="row">
                    <div class="col-sm-5">
                        <div class="card">
                        <div class="card-body">
                            <h5 class="card-head text-danger">Admin</h5>
                            <p class="card-text">Click below button to Login As Admin</p>
                            <a href="adminLogin.php" class="btn btn-dark">Admin Login</a>
                            <p class="card-text">Click below button to Register As Admin</p>
                            <a href="adminSignup.php" class="btn btn-dark">Admin Registration</a>
                        </div>
                        </div>
                    </div>


                    <div class="col-sm-5">
                        <div class="card">
                        <div class="card-body">
                            <h5 class="card-head text-danger">Student</h5>
                            <p class="card-text">Click below button to Login</p>
                            <a href="login.php" class="btn btn-dark">Login</a>
                            <p class="card-text">Click below button to Register</p>
                            <a href="signup.php" class="btn btn-dark">Registration</a>
                        </div>
                        </div>
                    </div>

                </div>
            <?php
        }
        ?>
<?php include 'footer.php'; ?>