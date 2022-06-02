<?php
if ( isset($_GET["id"]) ) {
    $id = $_GET["id"];

    include 'db_connect.php';

    $sql = "DELETE FROM field WHERE project_id = $id";
    $connection->query($sql);
    $sql = "DELETE FROM project WHERE id = $id";
    $connection->query($sql);


}

header("location: /project_db/project_list.php");
exit;
?>
