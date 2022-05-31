<?php
include 'db_connect.php';

$org_name = "";
$abbreviation = "";
$category = "";
$street = "";
$street_no = "";
$postal_code = "";
$city = "";

$errorMessage = "";
$successMessage = "";

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
    $org_name = $_POST["org_name"];
    $abbreviation = $_POST["abbreviation"];
    $category = $_POST["category"];
    $street = $_POST["street"];
    $street_no = $_POST["street_no"];
    $postal_code = $_POST["postal_code"];
    $city = $_POST["city"];

    do {
        if ( empty($org_name) || empty($abbreviation) || empty($category) || empty($street)
            || empty($street_no) || empty($postal_code) || empty($city) ) {
            $errorMessage = "All the fields are required";
            break;
        }

        // add new client to database
        $sql =  "INSERT INTO organisation (org_name, abbreviation, category, street, street_no, postal_code, city) " .
                "VALUES ('$org_name', '$abbreviation', '$category', '$street', '$street_no', '$postal_code', '$city')";
        $result = $connection->query($sql);

        if (!$result) {
            $errorMessage = "Invalid query: " . $connection->error;
            break;
        }

        $org_name = "";
        $abbreviation = "";
        $category = "";
        $street = "";
        $street_no = "";
        $postal_code = "";
        $city = "";

        $successMessage = "organisation added correctly";

        header("location: /project_db/org_list.php");
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
        <h2>Εισαγωγή νέου οργανισμού</h2>

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
                <label class="col-sm-3 col-form-label">Όνομα</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="org_name" value="<?php echo $org_name; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Συντομογραφία</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="abbreviation" value="<?php echo $abbreviation; ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="category">Κατηγορία</label>
                <select class="form-control" name="category">
                    <option value="">---</option>
                    <option value="University">Πανεπιστήμιο</option>
                    <option value="Research Center">Ερευνητικό Κέντρο</option>
                    <option value="Company">Εταιρεία</option>
                </select>
            </div>
            <br>
            <fieldset class="border p-2">
                <legend class="w-auto">Διεύθυνση Οργανισμού</legend>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Οδός</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="street" value="<?php echo $street; ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Αριθμός</label>
                    <div class="col-sm-6">
                        <input type="number" class="form-control" name="street_no" value="<?php echo $street_no; ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Ταχυδρομικός Κώδικας</label>
                    <div class="col-sm-6">
                        <input type="number" class="form-control" name="postal_code" value="<?php echo $postal_code; ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Πόλη</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="city" value="<?php echo $city; ?>">
                    </div>
                </div>
            </fieldset>

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
                    <a class="btn btn-outline-primary" href="/project_db/org_list.php" role="button">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
