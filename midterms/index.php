<?php
session_start();
include "db.php";

$msg = "";

if ($_POST) {
    $u=$_POST['username'];
    $p=md5($_POST['password']);

    $res=$conn->query("SELECT * FROM users WHERE username='$u' AND password='$p'");
    if($res->num_rows){
        $data=$res->fetch_assoc();
        $_SESSION['user']=$data;

        if($data['role']=='admin') header("Location: admin.php");
        else header("Location: user.php");
    } else $msg="Invalid login!";
}
?>

<html>
<head>
<title>Oven Fresh Delights</title>
<?php include "style.php"; ?>
</head>
<body>

<div class="container">
<div class="card">

<h2>Oven Fresh Delights</h2>

<?php if($msg) echo "<div class='notification'>$msg</div>"; ?>

<form method="POST">
<input name="username" required placeholder="Username">
<input type="password" name="password" required placeholder="Password">
<button>Login</button>
</form>
<p style="margin-top:15px; font-size14px; color:#5a3e25;">admin:qwerty123</p>
</div>
</div>

</body>
</html>