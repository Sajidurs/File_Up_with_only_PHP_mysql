<?php

// Connect to the database
$conn = mysqli_connect('localhost', 'root', '', 'images');
if (!$conn) {
    echo mysqli_connect_error();
}

if (isset($_POST['submit'])) {
    $filename = $_FILES['theimg']['name'];
    $tmploc = $_FILES['theimg']['tmp_name'];
    $filetype = $_FILES['theimg']['type'];
    $filesize = $_FILES['theimg']['size'];

    $uploc = "images/" . $filename;

    if ($filesize < 100000) {
        if ($filetype == 'image/jpeg') {
            if (file_exists($uploc)) {
                echo "File already exists. trying uploading another image";
            } else {
                if (move_uploaded_file($tmploc, $uploc)) {
                    $sql = "INSERT INTO imagetable(imagename) VALUES('$filename')";
                    if (mysqli_query($conn, $sql)) {
                        echo "Success";
                    } else {
                        echo "Image upload failed";
                    }
                    echo "Upload";
                } else {
                    echo "File is not selected";
                }
            }
        } else {
            echo "Try to upload a Jpeg file";
        }
    } else {
        echo "The image size must be less than 100000 bytes";
    }


}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <link
        href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i&display=swap"
        rel="stylesheet">

    <title>File Uploading with PHP</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        img {
            max-width: 10%;
        }
    </style>
</head>

<body class="bg-light">




    <div class="section_wrapper">
        <div class="container section">
            <div class="row">
                <div class="col-mad-12">
                    <div class="file_uploading_area">
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" method="post"
                            id="form">
                            <input type="file" name="theimg" id="theimg">
                            <input type="submit" name="submit" id="submit" value="Upload">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php

    $sql = "SELECT * FROM imagetable";
    $query = mysqli_query($conn, $sql);

    while (
        $data = mysqli_fetch_assoc($query)
    ) {
        $imagename = $data['imagename'];

        echo "<img src='images/$imagename' class='image'>";
    }
    ?>



    <!-- Custom JS -->
    <script src="/assets/js/custom.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>