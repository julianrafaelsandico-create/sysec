<?php
session_start();
include "db.php";

// Only allow admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header("Location: index.php");
    exit;
}

$msg = "";
$user = $_SESSION['user']['username'];

/* CREATE USER */
if (isset($_POST['create'])) {
    $u = $_POST['username'];
    $p = md5($_POST['password']);

    if ($conn->query("INSERT INTO users(username,password) VALUES('$u','$p')")) {
        $conn->query("INSERT INTO logs(user,action) VALUES('$user','Created user $u')");
        $msg = "User created!";
    } else {
        $msg = "Error creating user!";
    }
}

/* DELETE USER */
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $check = $conn->query("SELECT * FROM users WHERE id=$id")->fetch_assoc();

    if ($check['is_main_admin']) {
        $msg = "Main admin protected!";
    } else {
        $conn->query("DELETE FROM users WHERE id=$id");
        $conn->query("INSERT INTO logs(user,action) VALUES('$user','Deleted ".$check['username']."')");
        $msg = "Deleted!";
    }
}

/* ELEVATE USER */
if (isset($_GET['elevate'])) {
    $id = $_GET['elevate'];
    $conn->query("UPDATE users SET role='admin' WHERE id=$id");
    $u = $conn->query("SELECT username FROM users WHERE id=$id")->fetch_assoc();
    $conn->query("INSERT INTO logs(user,action) VALUES('$user','Elevated ".$u['username']."')");
    $msg = "Elevated!";
}

/* CHANGE PASSWORD */
if (isset($_POST['changepass'])) {
    $id = $_SESSION['user']['id'];
    $new = md5($_POST['newpass']);
    $conn->query("UPDATE users SET password='$new' WHERE id=$id");
    $msg = "Password updated!";
}

$users = $conn->query("SELECT * FROM users");
$logs = $conn->query("SELECT * FROM logs ORDER BY id DESC");
?>

<html>
<head>
<title>Admin Dashboard</title>
<?php include "style.php"; ?>
</head>
<body>
<div class="container">
<div class="card">

<h2>Admin Dashboard</h2>
<a href="logout.php"><button>Logout</button></a>

<?php if($msg) echo "<div class='notification'>$msg</div>"; ?>

<h3>Change Password</h3>
<form method="POST">
    <input name="newpass" required placeholder="New Password">
    <button name="changepass">Change Password</button>
</form>

<h3>Create User</h3>
<form method="POST">
    <input name="username" required placeholder="Username">
    <input name="password" required placeholder="Password">
    <button name="create">Create User</button>
</form>

<h3>User List</h3>
<table width="100%">
<tr><th>ID</th><th>Username</th><th>Role</th><th>Actions</th></tr>
<?php while($row=$users->fetch_assoc()){ ?>
<tr>
<td><?= $row['id'] ?></td>
<td><?= $row['username'] ?></td>
<td><?= $row['role'] ?></td>
<td>
<?php if(!$row['is_main_admin']){ ?>
    <a href="?delete=<?= $row['id'] ?>"><button>Delete</button></a>
<?php } else echo "Protected"; ?>
<?php if($row['role'] != 'admin'){ ?>
    <a href="?elevate=<?= $row['id'] ?>"><button>Elevate</button></a>
<?php } ?>
</td>
</tr>
<?php } ?>
</table>

<h3>Activity Logs</h3>
<table width="100%">
<tr><th>User</th><th>Action</th><th>Date</th></tr>
<?php while($l=$logs->fetch_assoc()){ ?>
<tr>
<td><?= $l['user'] ?></td>
<td><?= $l['action'] ?></td>
<td><?= $l['date'] ?></td>
</tr>
<?php } ?>
</table>

</div>
</div>
</body>
</html>