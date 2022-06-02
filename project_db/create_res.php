<?php
include 'db_connect.php';

$org_id = "";
$first_name = "";
$last_name = "";
$date_of_birth = "";
$sex = "";
$works_date = "";

$errorMessage = "";
$successMessage = "";

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
    $org_id = $_POST["org_id"];
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $date_of_birth = $_POST["date_of_birth"];
    $sex = $_POST["sex"];
    $works_date = $_POST["works_date"];

    do {
        if ( empty($org_id) || empty($first_name) || empty($last_name) || empty($date_of_birth)
            || empty($sex) || empty($works_date) ) {
            $errorMessage = "All the fields are required";
            break;
        }

        // add new client to database
        $sql =  "INSERT INTO researcher (org_id, first_name, last_name, date_of_birth, sex, works_date) " .
                "VALUES ('$org_id', '$first_name', '$last_name', '$date_of_birth', '$sex', '$works_date')";
        $result = $connection->query($sql);

        if (!$result) {
            $errorMessage = "Invalid query: " . $connection->error;
            break;
        }

        $org_id = "";
        $first_name = "";
        $last_name = "";
        $date_of_birth = "";
        $sex = "";
        $works_date = "";

        $successMessage = "researcher added correctly";

        header("location: /project_db/res_list.php");
        exit;

    } while (false);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Shop</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container my-5">
        <h2>Εισαγωγή νέου ερευνητή</h2>

        <?php
        if ( !empty($errorMessage) ) {
            echo "
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong>$errorMessage</strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
            ";
        }
        ?>

        <form method="post">
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Δείκτης/ID Οργανισμού</label>
                <div class="col-sm-6">
                    <input type="int" class="form-control" name="org_id" value="<?php echo $org_id; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Όνομα</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="first_name" value="<?php echo $first_name; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Επίθετο</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="last_name" value="<?php echo $last_name; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Ημερομηνία Γέννησης</label>
                <div class="col-sm-6">
                    <input type="date" class="form-control" name="date_of_birth" value="<?php echo $date_of_birth; ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="category">Φύλο</label>
                <select class="form-control" name="sex">
                    <option value="">---</option>
                    <option value="M">Άρρεν</option>
                    <option value="F">Θηλυκό</option>
                </select>
            </div>
            <br>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Ημερομηνία Πρόσληψης</label>
                <div class="col-sm-6">
                    <input type="date" class="form-control" name="works_date" value="<?php echo $works_date; ?>">
                </div>
            </div>


            <?php
            if ( !empty($successMessage) ) {
                echo "
                <div class='row mb-3'>
                    <div class='offset-sm-3 col-sm-6'>
                        <div class='alert alert-success alert-dismissible fade show' role='alert'>
                            <strong>$successMessage</strong>
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>
                    </div>
                </div>
                ";
            }
            ?>

            <div class="row mb-3">
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-outline-primary" href="/project_db/res_list.php" role="button">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
