<?php
session_start();  // Always start the session at the top

include("connect.php");

$mobile = $_POST['mobile'];
$password = $_POST['password'];
$role = $_POST['role'];

// Use prepared statements to prevent SQL injection
$stmt = $connect->prepare("SELECT * FROM user WHERE mobile=? AND password=? AND role=?");
$stmt->bind_param("sss", $mobile, $password, $role);  // "sss" means three string parameters
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows > 0){
    $userdata = $result->fetch_array(MYSQLI_ASSOC);
    
    // Get groups for role 2
    $groups = mysqli_query($connect, "SELECT * FROM user WHERE role=2");
    $groupsdata = mysqli_fetch_all($groups, MYSQLI_ASSOC);

    // Store session data
    $_SESSION['userdata'] = $userdata;
    $_SESSION['groupsdata'] = $groupsdata;

    echo '
          <script>
              window.location = "../routes/dashboard.php";
          </script>
     ';
} else {
    echo '
          <script>
              alert("Invalid credentials or user not found!");
              window.location = "../";
          </script>
     ';
}
?>
