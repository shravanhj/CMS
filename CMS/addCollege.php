<?php include 'header.php'; ?>
<?php
include 'dbconn.php';
if(isset($_SESSION['admin_id'])){
    $admin_id = $_SESSION['admin_id'];
    adminAddCollege();
}
elseif(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
    userAddCollege();
}
else{
    header('location:error.php');
}

?>
<?php
function adminAddCollege(){
    include 'dbconn.php';
    if(isset($_POST['add'])){
        $college_id = $_POST['college_code'];
        $college_name = $_POST['college_name'];
        $college_email = $_POST['college_email'];
        $college_phone = $_POST['college_phone'];
        $description = $_POST['description'];
        $address = $_POST['address'];
        $city = $_POST['city'];
        $district = $_POST['district'];
        $taluk = $_POST['taluk'];
        $description = $_POST['description'];
        $image_01 = $_FILES['image']['name'];
        $courses = implode(', ',$_POST['course']);
    
        $select_college = $conn->prepare("SELECT * FROM `colleges` WHERE college_code = ?");
        $select_college->execute([$college_id]);
        $row = $select_college->fetch(PDO::FETCH_ASSOC);
    
        if($select_college->rowCount() > 0){
            $message[] = 'College already exist with this ID';
        }
        else{
            if( $_FILES['image']['name'] != "" ) {
                $path=$_FILES['image']['name'];
                $pathto="collegeImage/".$path;
                move_uploaded_file( $_FILES['image']['tmp_name'],$pathto) or die( "Could not copy file!");
            }
            else {
                die("No file specified!");
            }
            $college = $conn->prepare("INSERT INTO `colleges` (college_code, name, email, phone, courses, description, Image_01) VALUE (?, ?, ?, ?, ?, ?, ?)");
            $college->execute([$college_id, $college_name, $college_email, $college_phone, $courses, $description, $image_01]);
            $course = $conn->prepare("INSERT INTO `location` (college_code, area, city, taluk, district) VALUE (?, ?, ?, ?, ?)");
            $course->execute([$college_id, $address, $city, $taluk, $district]);
            echo "<script type='text/javascript'>alert('College Added Successfully.');</script>";
        }
    }
    ?>
    <div class="container d-flex">
        <div class="container w-100">
                <div class=" text-center mt-4 ">
                    <h2>College Details</h2> 
                </div>
            <div class="row">
            <div class="mx-auto">
                <div class="card mt-2 mx-auto p-4">
                    <div class="card-body">
                    <div class = "container">
                        <form action="" method="post" enctype="multipart/form-data">
                        <div class="controls">
                        <?php
        if(isset($message)){
            foreach($message as $message){
                echo '
                <div class="alert shadow" style="background-color: black; padding: 10px;color:white;">
                    <span class="closebtn" onClick="this.parentElement.remove()">&times;</span>
                    '.$message.'
                    </div>';
            }
        }
        ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>College Code</label>
                                    <input type="text" name="college_code" class="form-control p-1 shadow-sm bg-white rounded shadow-sm bg-white rounded" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>College Name</label>
                                    <input type="text" name="college_name" class="form-control p-1 shadow-sm bg-white rounded" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>College Email</label>
                                    <input type="email" name="college_email" class="form-control p-1 shadow-sm bg-white rounded">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>College Phone No</label>
                                    <input type="tel" name="college_phone" class="form-control p-1 shadow-sm bg-white rounded" required>
                                </div>
                            </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label>College Short Description</label>
                                    <textarea name="description" class="form-control form-control p-1 shadow-sm bg-white rounded" rows="1"></textarea>
                                    </div>
                                </div>
                                <div class="col">
                                <div class="form-group mb-3">
                                    <label for="form_need">College Image</label>
                                    <input type="file" name="image" class="form-control p-1 shadow-sm bg-white rounded" required>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
        </div>
        </div>
        </div>
        </div>
        <div class="container">
                <div class=" text-center mt-4 ">
                    <h2>Course Details and College Location</h2> 
                </div>
            <div class="row">
                <div class="card mt-2 mx-auto p-4">
                    <div class="card-body">
                    <div class = "container">
                        <div class="controls">
                        <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label>College Address</label>
                                    <textarea name="address" class="form-control form-control p-1 shadow-sm bg-white rounded" rows="1"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                <div class="form-group">
                                    <label>City</label>
                                    <input type="text" name="city" class="form-control p-1 shadow-sm bg-white rounded" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>District</label>
                                    <select name="district" class="form-select form-select-sm p-1 shadow-sm bg-white rounded" required>
                                        <option selected disabled>Select</option>
                                        <option>Bagalkot</option>
                                        <option>Belagavi</option>
                                        <option>Dharwad</option>
                                        <option>Vijayapur</option>
                                        <option>Gadag</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>Taluk</label>
                                    <input type="text" name="taluk" class="form-control p-1 shadow-sm bg-white rounded shadow-sm bg-white rounded" required>
                                </div>
                            </div>
                        </div>
                        <label class="text-danger">U.G(Under Graguate)</label>
                        <div class="row">
                        <div class="mb-2 form-check">
                            <label class="form-check-label">Bachelor of Arts</label>
                            <input type="checkbox" class="form-check-input" id="Check1" name="course[]" value="B.A">
                        </div>
                        <div class="mb-2 form-check">
                            <label class="form-check-label">Bachelor of Business Administration</label>
                            <input type="checkbox" class="form-check-input" id="Check1" name="course[]" value="B.B.A">
                        </div>
                        <div class="mb-2 form-check">
                            <label class="form-check-label">Bachelor of Commerce</label>
                            <input type="checkbox" class="form-check-input" id="Check1" name="course[]" value="B.Com">
                        </div>
                        <div class="mb-2 form-check">
                            <label class="form-check-label">Bachelor of Computer Application</label>
                            <input type="checkbox" class="form-check-input" id="Check1" name="course[]" value="B.C.A">
                        </div>
                        <div class="mb-2 form-check">
                            <label class="form-check-label">Bachelor of Science</label>
                            <input type="checkbox" class="form-check-input" id="Check1" name="course[]" value="B.Sc">
                        </div>
                        </div>
                        <label class="text-danger">P.G(Post Graguate)</label>
                        <div class="row">
                        <div class="mb-2 form-check">
                            <label class="form-check-label">Master of Arts</label>
                            <input type="checkbox" class="form-check-input" id="Check1" name="course[]" value="M.A">
                        </div>
                        <div class="mb-2 form-check">
                            <label class="form-check-label">Master of Business Administration</label>
                            <input type="checkbox" class="form-check-input" id="Check1" name="course[]" value="M.B.A">
                        </div>
                        <div class="mb-2 form-check">
                            <label class="form-check-label">Master of Commerce</label>
                            <input type="checkbox" class="form-check-input" id="Check1" name="course[]" value="M.Com">
                        </div>
                        <div class="mb-2 form-check">
                            <label class="form-check-label">Master of Computer Application</label>
                            <input type="checkbox" class="form-check-input" id="Check1" name="course[]" value="M.C.A">
                        </div>
                        <div class="mb-2 form-check">
                            <label class="form-check-label">Master of Science</label>
                            <input type="checkbox" class="form-check-input" id="Check1" name="course[]" value="M.Sc">
                        </div>
                        </div>
                    <div class="col-md-12"> 
                        <input type="submit" name="add" class="btn btn-dark block" value="Add College" >
                    </div>
                </form>
            </div>
        </div>
        </div>
        </div>
        </div>
        </div>
        </div>
    <?php
}

function userAddCollege(){
    include 'dbconn.php';
    if(isset($_POST['add'])){
        $college_id = $_POST['college_code'];
        $college_name = $_POST['college_name'];
        $college_email = $_POST['college_email'];
        $college_phone = $_POST['college_phone'];
        $description = $_POST['description'];
        $address = $_POST['address'];
        $city = $_POST['city'];
        $district = $_POST['district'];
        $taluk = $_POST['taluk'];
        $description = $_POST['description'];
        $image_01 = $_FILES['image']['name'];
        $courses = implode(', ',$_POST['course']);
    
        $select_college = $conn->prepare("SELECT * FROM `colleges` WHERE college_code = ?");
        $select_college->execute([$college_id]);
        $row = $select_college->fetch(PDO::FETCH_ASSOC);
    
        if($select_college->rowCount() > 0){
            $message[] = 'College already exist with this ID';
        }
        else{
            if( $_FILES['image']['name'] != "" ) {
                $path=$_FILES['image']['name'];
                $pathto="collegeImage/".$path;
                move_uploaded_file( $_FILES['image']['tmp_name'],$pathto) or die( "Could not copy file!");
            }
            else {
                die("No file specified!");
            }
            $college = $conn->prepare("INSERT INTO `requests` (college_code, name, email, phone, courses, description, Image_01, requested_by) VALUE (?, ?, ?, ?, ?, ?, ?, ?)");
            $college->execute([$college_id, $college_name, $college_email, $college_phone, $courses, $description, $image_01, $_SESSION['user_id']]);
            $course = $conn->prepare("INSERT INTO `request_location` (college_code, area, city, taluk, district) VALUE (?, ?, ?, ?, ?)");
            $course->execute([$college_id, $address, $city, $taluk, $district]);
            echo "<script type='text/javascript'>alert('College Add Requested Successfully.');</script>";
        }
    }
    ?>
        <div class="container d-flex">
        <div class="container w-100">
                <div class=" text-center mt-4 ">
                    <h2>College Details</h2> 
                </div>
            <div class="row">
            <div class="mx-auto">
                <div class="card mt-2 mx-auto p-4">
                    <div class="card-body">
                    <div class = "container">
                        <form action="" method="post" enctype="multipart/form-data">
                        <div class="controls">
                        <?php
        if(isset($message)){
            foreach($message as $message){
                echo '
                <div class="alert shadow" style="background-color: black; padding: 10px;color:white;">
                    <span class="closebtn" onClick="this.parentElement.remove()">&times;</span>
                    '.$message.'
                    </div>';
            }
        }
        ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>College Code</label>
                                    <input type="text" name="college_code" class="form-control p-1 shadow-sm bg-white rounded shadow-sm bg-white rounded" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>College Name</label>
                                    <input type="text" name="college_name" class="form-control p-1 shadow-sm bg-white rounded" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>College Email</label>
                                    <input type="email" name="college_email" class="form-control p-1 shadow-sm bg-white rounded">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>College Phone No</label>
                                    <input type="tel" name="college_phone" class="form-control p-1 shadow-sm bg-white rounded" required>
                                </div>
                            </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label>College Short Description</label>
                                    <textarea name="description" class="form-control form-control p-1 shadow-sm bg-white rounded" rows="1"></textarea>
                                    </div>
                                </div>
                                <div class="col">
                                <div class="form-group mb-3">
                                    <label for="form_need">College Image</label>
                                    <input type="file" name="image" class="form-control p-1 shadow-sm bg-white rounded" required>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
        </div>
        </div>
        </div>
        </div>
        <div class="container">
                <div class=" text-center mt-4 ">
                    <h2>Course Details and College Location</h2> 
                </div>
            <div class="row">
                <div class="card mt-2 mx-auto p-4">
                    <div class="card-body">
                    <div class = "container">
                        <div class="controls">
                        <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label>College Address</label>
                                    <textarea name="address" class="form-control form-control p-1 shadow-sm bg-white rounded" rows="1"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                <div class="form-group">
                                    <label>City</label>
                                    <input type="text" name="city" class="form-control p-1 shadow-sm bg-white rounded" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>District</label>
                                    <select name="district" class="form-select form-select-sm p-1 shadow-sm bg-white rounded" required>
                                        <option selected disabled>Select</option>
                                        <option>Bagalkot</option>
                                        <option>Belagavi</option>
                                        <option>Dharwad</option>
                                        <option>Vijayapur</option>
                                        <option>Gadag</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>Taluk</label>
                                    <input type="text" name="taluk" class="form-control p-1 shadow-sm bg-white rounded shadow-sm bg-white rounded" required>
                                </div>
                            </div>
                        </div>
                        <label class="text-danger">U.G(Under Graguate)</label>
                        <div class="row">
                        <div class="mb-2 form-check">
                            <label class="form-check-label">Bachelor of Arts</label>
                            <input type="checkbox" class="form-check-input" id="Check1" name="course[]" value="B.A">
                        </div>
                        <div class="mb-2 form-check">
                            <label class="form-check-label">Bachelor of Business Administration</label>
                            <input type="checkbox" class="form-check-input" id="Check1" name="course[]" value="B.B.A">
                        </div>
                        <div class="mb-2 form-check">
                            <label class="form-check-label">Bachelor of Commerce</label>
                            <input type="checkbox" class="form-check-input" id="Check1" name="course[]" value="B.Com">
                        </div>
                        <div class="mb-2 form-check">
                            <label class="form-check-label">Bachelor of Computer Application</label>
                            <input type="checkbox" class="form-check-input" id="Check1" name="course[]" value="B.C.A">
                        </div>
                        <div class="mb-2 form-check">
                            <label class="form-check-label">Bachelor of Science</label>
                            <input type="checkbox" class="form-check-input" id="Check1" name="course[]" value="B.Sc">
                        </div>
                        </div>
                        <label class="text-danger">P.G(Post Graguate)</label>
                        <div class="row">
                        <div class="mb-2 form-check">
                            <label class="form-check-label">Master of Arts</label>
                            <input type="checkbox" class="form-check-input" id="Check1" name="course[]" value="M.A">
                        </div>
                        <div class="mb-2 form-check">
                            <label class="form-check-label">Master of Business Administration</label>
                            <input type="checkbox" class="form-check-input" id="Check1" name="course[]" value="M.B.A">
                        </div>
                        <div class="mb-2 form-check">
                            <label class="form-check-label">Master of Commerce</label>
                            <input type="checkbox" class="form-check-input" id="Check1" name="course[]" value="M.Com">
                        </div>
                        <div class="mb-2 form-check">
                            <label class="form-check-label">Master of Computer Application</label>
                            <input type="checkbox" class="form-check-input" id="Check1" name="course[]" value="M.C.A">
                        </div>
                        <div class="mb-2 form-check">
                            <label class="form-check-label">Master of Science</label>
                            <input type="checkbox" class="form-check-input" id="Check1" name="course[]" value="M.Sc">
                        </div>
                        </div>
                    <div class="col-md-12"> 
                        <input type="submit" name="add" class="btn btn-dark block" value="Add College" >
                    </div>
                </form>
            </div>
        </div>
        </div>
        </div>
        </div>
        </div>
        </div>
    <?php
}

?>
<?php include 'footer.php'; ?>