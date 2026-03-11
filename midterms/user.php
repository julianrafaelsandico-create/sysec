<?php
session_start();
include "db.php";

if ($_SESSION['user']['role'] != 'user') header("Location:index.php");

$msg="";
$currentUser=$_SESSION['user']['username'];

/* ADD ITEM */
if(isset($_POST['add'])){
    $name=$_POST['item'];
    $qty=$_POST['qty'];

    $conn->query("INSERT INTO inventory(item_name,quantity) VALUES('$name','$qty')");
    $item_id=$conn->insert_id;

    $conn->query("INSERT INTO inventory_history(item_id,quantity) VALUES($item_id,$qty)");
    $conn->query("INSERT INTO logs(user,action) VALUES('$currentUser','Added item $name')");
    $msg="Item added!";
}

/* UPDATE */
if(isset($_POST['update'])){
    $id=$_POST['id'];
    $qty=$_POST['qty'];

    $conn->query("UPDATE inventory SET quantity=$qty WHERE id=$id");
    $conn->query("INSERT INTO inventory_history(item_id,quantity) VALUES($id,$qty)");
    $conn->query("INSERT INTO logs(user,action) VALUES('$currentUser','Updated item ID $id')");
    $msg="Updated!";
}

$items=$conn->query("SELECT * FROM inventory");
?>

<html>
<head>
<title>User</title>
<?php include "style.php"; ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
<div class="container">
<div class="card">

<h2>Inventory</h2>
<a href="logout.php"><button>Logout</button></a>

<?php if($msg) echo "<div class='notification'>$msg</div>"; ?>

<h3>Add Item</h3>
<form method="POST">
<input name="item" required placeholder="Item name">
<input type="number" name="qty" required placeholder="Quantity">
<button name="add">Add</button>
</form>

<h3>Inventory</h3>

<table width="100%">
<tr><th>Item</th><th>Qty</th><th>Action</th></tr>

<?php while($row=$items->fetch_assoc()){ ?>
<tr>
<td><?= $row['item_name'] ?></td>
<td><?= $row['quantity'] ?></td>
<td>
<button onclick="showEdit(<?= $row['id'] ?>)">Edit</button>
</td>
</tr>

<tr id="edit<?= $row['id'] ?>" style="display:none;">
<td colspan="3">
<form method="POST">
<input type="hidden" name="id" value="<?= $row['id'] ?>">
<input type="number" name="qty" required>
<button name="update">Save</button>
</form>

<canvas id="chart<?= $row['id'] ?>"></canvas>

<script>
fetch('get_history.php?id=<?= $row['id'] ?>')
.then(res=>res.json())
.then(data=>{
new Chart(document.getElementById('chart<?= $row['id'] ?>'),{
type:'line',
data:{
labels:data.dates,
datasets:[{label:'Quantity',data:data.qty}]
}
});
});
</script>

</td>
</tr>
<?php } ?>

</table>

</div>
</div>

<script>
function showEdit(id){
document.getElementById('edit'+id).style.display='table-row';
}
</script>

</body>
</html>