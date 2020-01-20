<?php
    
    /*
     * @author LI Qi
     * This php just implements the function to show the PDF
     */
    
    //including the database connection file
    include("config.php");
    
    $id = $_GET['id'];
    
    $result = mysqli_query($mysqli, "SELECT * FROM Contracts WHERE id=$id");
    
    while($res = mysqli_fetch_array($result)){
        $description = $res['description'];
        $description_pdf = $res['description_pdf'];
    }
    
    // download the pdf;
    //header("Content-Disposition: attachment; filename=$description");
    
    // Read the PDF online;
    header("Content-Type: application/pdf");
    echo $description_pdf;
    ?>
