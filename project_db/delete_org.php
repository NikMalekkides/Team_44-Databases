<?php
if ( isset($_GET["id"]) ) {
    $id = $_GET["id"];

    include 'db_connect.php';

    $sql = "DELETE FROM organisation WHERE id = $id";
    $connection->query($sql);

}

header("location: /project_db/org_list.php");
exit;
?>
