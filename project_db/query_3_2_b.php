<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projects</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-light navbar-expand-md" id="nav-bar">
        <div id="navbar-div" class="container-fluid">
            <a id="navbar-items" href="/project_db/index.php/">
                <i class="fa fa-home "></i> Homepage
            </a>
        </div>
    </nav>

    <div class="container my-5">
        <h2>Έργα ανα ερευνητή</h2>
        <table class="table">
            <thead>
                <tr>
                  <th> ID Ερευνητή </th>
                  <th> Όνομα </th>
                  <th> Επίθετο </th>
                  <th> ID Έργου </th>
                  <th> Τίτλος </th>
                  <th> Ημερομηνία Έναρξης </th>
                  <th> Ημερομηνία Λήξης </th>
                </tr>
            </thead>
            <tbody>
                <?php
                include 'db_connect.php';

                // read all row from database table
                $sql = "SELECT res_id, first_name, last_name, project_id, title, start_date, end_date FROM researcher_project";
                $result = $connection->query($sql);

                if (!$result) {
                    die("Invalid query: " . $connection->error);
                }

                // read data of each row
                while($row = $result->fetch_assoc()) {
                    echo "
                    <tr>
                        <td> $row[res_id] </td>
                        <td> $row[first_name] </td>
                        <td> $row[last_name] </td>
                        <td> $row[project_id] </td>
                        <td> $row[title] </td>
                        <td> $row[start_date] </td>
                        <td> $row[end_date] </td>
                    </tr>
                    ";
                }

                ?>


            </tbody>
		</table>
    </div>
</body>
</html>
