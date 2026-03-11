<?php
include "db.php";

$id=$_GET['id'];

$res=$conn->query("SELECT * FROM inventory_history WHERE item_id=$id");

$d=[]; $q=[];

while($r=$res->fetch_assoc()){
$d[]=$r['date'];
$q[]=$r['quantity'];
}

echo json_encode(["dates"=>$d,"qty"=>$q]);
?>