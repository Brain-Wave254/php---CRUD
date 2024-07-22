<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "examinations";

//Create connection
$connection = new mysqli($servername, $username, $password, $database);

$IndexNo = "";
$Name = "";
$Schoolcode = "";
$Male = "";

$errorMessage = "";
$successMessage = "";

if ( $_SERVER['REQUEST_METHOD'] == 'GET' ) {
    // Ensure IndexNo is provided and numeric
    if (!isset($_GET["IndexNo"]) || !is_numeric($_GET["IndexNo"])) {
        header("location: /mpesa/index.php");
        exit;
    }

    $IndexNo = $_GET["IndexNo"];

    // Fetch the specific student record based on IndexNo
    $sql = "SELECT * FROM students WHERE IndexNo = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $IndexNo);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a row is found
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $IndexNo = $row["IndexNo"];
        $Name = $row["Name"];
        $Schoolcode = $row["Schoolcode"];
        $Male = $row["Male"];
    } else {
        // Redirect if no record found
        header("location: /mpesa/index.php");
        exit;
    }
}
else {
    // POST Method: Show the data of the students

    $IndexNo = $_POST["IndexNo"];
    $Name = $_POST["Name"];
    $Schoolcode = $_POST["Schoolcode"];
    $Male = $_POST["Male"];

    do {
        if ( empty($IndexNo) || empty($Name) || empty($Schoolcode) || empty($Male) ) {
            $errorMessage = "All the Fields are Required!";
            break;
        }

        $sql = "UPDATE students" . " SET IndexNo = '$IndexNo', Name = '$Name', Schoolcode='$Schoolcode', Male='$Male'" . "WHERE IndexNo = $IndexNo";
        $result = $connection->query($sql);

        if (!$result) {
            $errorMessage = "Invalid query: " . $connection->error;
            break;
        }

        $successMessage = "Student details updated Successfully!";

        header("location: /mpesa/index.php");
        exit;

    } while (true);
}
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Mpesa STK-innit-new</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </head>
    <body>
        <div class="container my-5">
            <h2>New Student</h2>

            <?php
            if (!empty($errorMessage) ) {
                echo "
                <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                    <strong>$errorMessage</strong>
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='close'></button>
                </div>
                ";
            }
            ?>

            <form method="post" action="">
                <input type="hidden" name="IndexNo" value="<?php echo $IndexNo; ?>">
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Index No.</label>
                    <div class="col-sm-6">
                        <input type="number" class="form-control" name="IndexNo" value="<?php echo $IndexNo; ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Name</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="Name" value="<?php echo $Name; ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">School Code</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="Schoolcode" value="<?php echo $Schoolcode; ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Male</label>
                    <div class="col-sm-6">
                        <select class="form-control" id="male" name="Male" value="<?php echo $Male; ?>">
                            <option value="" disabled selected>Select Yes or No</option>
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                        </select>
                    </div>
                </div>

                <?php
                if (!empty($successMessage) ) {
                    echo "
                    <div class='row mb-3'>
                        <div class='alert alert-success alert-dismissible fade show' role='alert'>
                            <strong>$successMessage</strong>
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='close'></button>
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
                        <a class="btn btn-outline-primary" href="/mpesa/index.php" role="button">Cancel</a>
                    </div>
                </div>
            </form>
        </div>        
    </body>
  </html>