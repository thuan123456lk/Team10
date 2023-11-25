<?php
require("../ketnoi.php");
$id = (int)$_GET["id"];
$sql = "DELETE FROM Full_Contract WHERE ID = ?";
$params = array($id);
$query = sqlsrv_query($conn, $sql, $params);

if($query === false) {
    die(print_r(sqlsrv_errors(), true));
} else {
    header("location:../trangchu.php");
}
?>