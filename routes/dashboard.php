<?php
session_start();

if (!isset($_SESSION['userdata'])) {
    header("Location: ../");
    exit();
}

$userdata = $_SESSION['userdata'];
$groupsdata = isset($_SESSION['groupsdata']) ? $_SESSION['groupsdata'] : [];

$status = ($userdata['status'] == 0)
    ? '<b style="color:red">Not Voted</b>'
    : '<b style="color:green">Voted</b>';
?>
<html>
<head>
    <title>Online Voting System - Dashboard</title>
    <link rel="stylesheet" href="../css/stylesheet.css">
    <style>
        #backbutton {
            padding: 10px;
            border-radius: 5px;
            background-color: #793e58;
            color: white;
            float: left;
            margin: 10px;
            font-size: 15px;
        }

        #logoutbutton {
            padding: 5px;
            border-radius: 5px;
            background-color: #793e58;
            color: white;
            float: right;
            font-size: 15px;
            margin: 10px;
        }

        #Profile {
            background-color: white;
            width: 30%;
            padding: 20px;
            float: left;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-sizing: border-box;
        }

        #Group {
            background-color: white;
            width: 60%;
            padding: 20px;
            float: right;
            border: 1px solid #ccc;
            border-radius: 10px;
            min-height: 250px;
            box-sizing: border-box;
        }

        #votebtn {
            padding: 5px;
            font-size: 15px;
            background-color: #793e58;
            color: white;
            border-radius: 5px;
            border: none;
            cursor: pointer;
        }

        .voted-btn {
            background-color: gray;
            color: white;
            padding: 5px;
            border-radius: 5px;
            border: none;
        }

        #mainpanel {
            padding: 10px;
            overflow: hidden;
        }

        .group-box {
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #ccc;
        }
    </style>
</head>
<body>
    <div id="mainsection">
        <center>
            <div id="headersection">
                <a href="../"><button id="backbutton">Back</button></a>
                <a href="logout.php"><button id="logoutbutton">Logout</button></a>
                <h1>Online Voting System</h1>
            </div>
        </center>
        <hr>

        <div id="mainpanel">
            <!-- Profile Section -->
            <div id="Profile">
                <center>
                    <?php
                    $user_photo = isset($userdata['photo']) && $userdata['photo'] != '' ? $userdata['photo'] : 'default_profile.jpg';
                    echo "<img src='../uploads/" . htmlspecialchars($user_photo) . "' height='100' width='100'><br><br>";
                    ?>
                </center>
                <?php
                if (isset($userdata['name'])) {
                    echo "<b>Name:</b> " . htmlspecialchars($userdata['name']) . "<br><br>";
                }
                if (isset($userdata['mobile'])) {
                    echo "<b>Mobile:</b> " . htmlspecialchars($userdata['mobile']) . "<br><br>";
                }
                if (isset($userdata['address'])) {
                    echo "<b>Address:</b> " . htmlspecialchars($userdata['address']) . "<br><br>";
                }
                ?>
                <b>Status:</b> <?php echo $status; ?><br><br>
            </div>

            <!-- Groups Section -->
            <div id="Group">
                <h2>Groups</h2>
                <?php
                if (!empty($groupsdata)) {
                    foreach ($groupsdata as $group) {
                        if (empty($group['name']) || !isset($group['votes']) || empty($group['id'])) {
                            continue;
                        }

                        $group_name = htmlspecialchars($group['name']);
                        $group_votes = (int)$group['votes'];
                        $group_id = (int)$group['id'];
                        $group_photo = isset($group['photo']) && !empty($group['photo']) ? $group['photo'] : 'default_group.jpg';
                        ?>
                        <div class="group-box">
                            <img style="float: right" src="../uploads/<?php echo htmlspecialchars($group_photo); ?>" height="100" width="100">
                            <b>Group:</b> <?php echo $group_name; ?><br><br>
                            <b>Votes:</b> <?php echo $group_votes; ?><br><br>

                            <?php if ($userdata['status'] == 0) { ?>
                                <form action="../api/votes.php" method="POST">
                                    <input type="hidden" name="gvotes" value="<?php echo $group_votes; ?>">
                                    <input type="hidden" name="gid" value="<?php echo $group_id; ?>">
                                    <input type="submit" name="votebtn" value="Vote" id="votebtn">
                                </form>
                            <?php } else { ?>
                                <button class="voted-btn" disabled>Voted</button>
                            <?php } ?>
                        </div>
                        <?php
                    }
                } else {
                    echo "No groups available.";
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>
