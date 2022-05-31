<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Researchers</title>
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
        <h2>Ερευνητές</h2>
        <br>
        <table class="table">
            <thead>
                <tr>
                    <th> ID </th>
                    <th> Δείκτης/ID Οργανισμού </th>
                    <th> Όνομα </th>
                    <th> Επίθετο </th>
                    <th> Ημερομηνία Γέννησης </th>
                    <th> Φύλο </th>
                    <th> Ημερομηνία Πρόσληψης </th>
                </tr>
            </thead>
            <tbody>
                <?php
                include 'db_connect.php';

                // read all row from database table
                $sql = "SELECT * FROM researcher";
                $result = $connection->query($sql);

                if (!$result) {
                    die("Invalid query: " . $connection->error);
                }

                // read data of each row
                while($row = $result->fetch_assoc()) {
                    echo "
                    <tr>
                        <td>$row[id]</td>
                        <td>$row[org_id]</td>
                        <td>$row[first_name]</td>
                        <td>$row[last_name]</td>
                        <td>$row[date_of_birth]</td>
                        <td>$row[sex]</td>
                        <td>$row[works_date]</td>
                    </tr>
                    ";
                }

                ?>


            </tbody>
		</table>
    </div>
</body>
</html>
