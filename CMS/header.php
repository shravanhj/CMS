<?php
include 'dbconn.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>CSM | College Stream Managemnt</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"">
    </head>
    <body>
<?php
 if(session_id() == '') {
    session_start();
}
if(isset($_SESSION['admin_id'])){
    echo '
        <h1 class="text-center fw-bold p-3">College Stream Management System</h1>
        <nav class="navbar navbar-expand-lg  navbar-dark p-1" style="background: linear-gradient(to right, #28313B , #485461);">
        <div class="container-fluid ">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="home.php">Home</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="requests.php">Add College Requests</a>
                </li>
                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Manage Colleges
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <li><a class="dropdown-item" href="colleges.php">List of Colleges</a></li>
                    <li><a class="dropdown-item" href="addCollege.php">Add New College</a></li>
                </ul>
                </li>
                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Account
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <li><a class="dropdown-item" href="dashboard.php">My Account</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                </ul>
                </li>
            </ul>
            </div>
        </div>
    </nav>
    ';
}

elseif(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
    echo '
    <h1 class="text-center fw-bold p-3">College Stream Management System</h1>
    <nav class="navbar navbar-expand-lg  navbar-dark p-1" style="background: linear-gradient(to right, #28313B , #485461);">
        <div class="container-fluid ">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="home.php">Home</a>
                </li>
                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Requests
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <li><a class="dropdown-item" href="addCollege.php">Create New request</a></li>
                    <li><a class="dropdown-item" href="requests.php">Request Status</a></li>
                    <li><a class="dropdown-item" href="colleges.php">Colleges Added by you</a></li>
                </ul>
                </li>
                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Account
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <li><a class="dropdown-item" href="dashboard.php">My Account</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                </ul>
                </li>
            </ul>
            </div>
        </div>
    </nav>
    ';
}

else{
    $admin_id = '';
    $user_id = '';
    echo '
        <h1 class="text-center fw-bold p-3">College Stream Management System</h1>
        <nav class="navbar navbar-expand-lg  navbar-dark p-1" style="background: linear-gradient(to right, #28313B , #485461);">
        <div class="container-fluid ">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="home.php">Home</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="#features">Features</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="#about">About</a>
                </li>
                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Account
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <li><a class="dropdown-item" href="signup.php">Create Account</a></li>
                    <li><a class="dropdown-item" href="login.php">Login</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="adminLogin.php">Admin Login</a></li>
                    <li><a class="dropdown-item" href="adminSignup.php">Admin Registration</a></li>
                </ul>
                </li>
            </ul>
            </div>
        </div>
    </nav>
    ';
}
?>
