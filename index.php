<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mpesa STK-innit</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  </head>
  <body>
    <div class="container my-5">
        <h2>List of Students</h2>
        <a class="btn btn-primary" href="/mpesa/create.php" role="button">New Student</a> <br>
        <table class="table">
            <thead>
                <tr>
                    <th>Index No.</th>
                    <th>Name</th>
                    <th>School Code</th>
                    <th>Male</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $servername = "localhost";
                $username = "root";
                $password = "";
                $database = "examinations";

                //Create connection
                $connection = new mysqli($servername, $username, $password, $database);

                //Check connection
                if ($connection->connect_error) {
                    die("Connection failed: " . $connection->connect_error);
                }

                //read all row from the database table
                $sql = "SELECT * FROM students";
                $result = $connection->query($sql);

                if (!$result) {
                    die("Invalid query: " . $connection->error);
                }

                //read data of each row
                while($row = $result->fetch_assoc()) {

                    echo "
                    <tr>                        
                        <td>$row[IndexNo]</td>
                        <td>$row[Name]</td>
                        <td>$row[Schoolcode]</td>
                        <td>$row[Male]</td>
                        <td>
                            <a class='btn btn-primary btn-sm' href='/mpesa/edit.php?IndexNo=$row[IndexNo]'>Edit</a>
                            <a class='btn btn-danger btn-sm' href='/mpesa/delete.php?IndexNo=$row[IndexNo]'>Delete</a>                        
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