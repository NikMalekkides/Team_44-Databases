<?php
if ( isset($_GET["id"]) ) {
    $id = $_GET["id"];

    include 'db_connect.php';

    $sql = "DELETE FROM researcher WHERE id = $id";
    $connection->query($sql);

}

header("location: /project_db/res_list.php");
exit;
?>
