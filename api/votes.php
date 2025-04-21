<?php
session_start();
include("connect.php");

if (!isset($_POST['gvotes']) || !isset($_POST['gid'])) {
    echo "<script>
        alert('Invalid group selected!');
        window.location = '../routes/dashboard.php';
    </script>";
    exit();
}

$votes = (int)$_POST['gvotes'];
$gid = (int)$_POST['gid'];

if (!isset($_SESSION['userdata'])) {
    echo "<script>
        alert('User not logged in!');
        window.location = '../';
    </script>";
    exit();
}

$uid = $_SESSION['userdata']['id'];
$total_votes = $votes + 1;

// Update group votes
$update_votes = mysqli_query($connect, "UPDATE user SET votes = '$total_votes' WHERE id = '$gid'");

// Update user status
$update_user_status = mysqli_query($connect, "UPDATE user SET status = 1 WHERE id = '$uid'");

if ($update_votes && $update_user_status) {
    $_SESSION['userdata']['status'] = 1;

    // Update group votes in session
    if (isset($_SESSION['groupsdata'])) {
        foreach ($_SESSION['groupsdata'] as &$group) {
            if ($group['id'] == $gid) {
                $group['votes'] = $total_votes;
                break;
            }
        }
    }

    echo "<script>
        alert('Voted successfully.');
        window.location = '../routes/dashboard.php';
    </script>";
} else {
    echo "<script>
        alert('Voting failed. Try again.');
        window.location = '../routes/dashboard.php';
    </script>";
}
?>
