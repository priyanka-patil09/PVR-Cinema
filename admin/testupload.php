<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once '../db_scripts/login.php';

    //General details of the movie form
    $title = $_POST['title'];
    $description = $_POST['description'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $price = $_POST['Ticket_price'];




    //Uploading thumbnail and back-image
    $filename = $_FILES["thumbnail"]["name"];
    $tempname = $_FILES["thumbnail"]["tmp_name"];
    $folder = "../image/" . $filename;

    // $filename2 = $_FILES["backimage"]["name"];
    // $tempname2 = $_FILES["backimage"]["tmp_name"];
    // $folder2 = "../image/" . $filename2;

    

    //Move and rename the image file
    if (move_uploaded_file($tempname, $folder)) {
        //renaming the files
        $exten = substr($filename, stripos($filename, '.'));
        $movieThumb = $title.'thumb'.$exten;
        rename($folder, '../MovieImages/' . $movieThumb);

        // //back-image
        // $exten2 = substr($filename2, stripos($filename2, '.'));
        // $movieBack = $title.'back'.$exten2;
        // rename($folder2, '../MovieImages/' . $movieBack);

        $movieQuery = "INSERT INTO `movies`(`movie_name`, `status`, `start_date`, `end_date`) VALUES('$title','Active','$start_date','$end_date')";
        echo $movieQuery;
        mysqli_query($conn,$movieQuery);

        $movieIdQuery = "SELECT `movie_id` from `movies` where movie_name='$title'";
        $movieIdfetched = $conn->query($movieIdQuery);
        $movieID = mysqli_fetch_array($movieIdfetched);
        $finalMovieID = $movieID[0];

        $movieInfoQuery ="INSERT INTO `movie_info`() VALUES('$finalMovieID','$movieThumb','$description','$price')";
        mysqli_query($conn,$movieInfoQuery); 

        Redirect('adminpanel.html',true); // might change later to dashboard.php
    }
    else {
        Redirect('adminfrm.php',true);
    }

    
}
?>