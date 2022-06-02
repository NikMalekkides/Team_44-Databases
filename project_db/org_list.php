<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organisations</title>
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
        <h2>Οργανισμοί</h2>
        <a class="btn btn-primary" href="/project_db/create_org.php" role="button">Νέος Οργανισμός</a>
        <br>
        <table class="table">
            <thead>
                <tr>
                    <th> ID </th>
                    <th> Όνομα </th>
                    <th> Συντομογραφία </th>
                    <th> Κατηγορία </th>
                    <th> Οδός </th>
                    <th> Αριθμός </th>
                    <th> Ταχυδρομικός Κώδικας </th>
                    <th> Πόλη </th>
                    <th> Ενέργεια </th>
                </tr>
            </thead>
            <tbody>
                <?php
                include 'db_connect.php';

                // read all row from database table
                $sql = "SELECT * FROM organisation";
                $result = $connection->query($sql);

                if (!$result) {
                    die("Invalid query: " . $connection->error);
                }

                // read data of each row
                while($row = $result->fetch_assoc()) {
                    echo "
                    <tr>
                        <td>$row[id]</td>
                        <td>$row[org_name]</td>
                        <td>$row[abbreviation]</td>
                        <td>$row[category]</td>
                        <td>$row[street]</td>
                        <td>$row[street_no]</td>
                        <td>$row[postal_code]</td>
                        <td>$row[city]</td>
                        <td>
                            <a class='btn btn-primary btn-sm' href='/project_db/edit_org.php?id=$row[id]'> Edit </a>
                            <a class='btn btn-danger btn-sm' href='/project_db/delete_org.php?id=$row[id]'> Delete </a>
                        </td>
                    </tr>
                    ";
                }

                ?>


            </tbody>
		</table>
    </div>
</body>
</html>
