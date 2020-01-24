<?php
    
    /*
     * @author LI Qi
     * The main page with the table of contracts and some operation button
     * I use Bootstrap to design the item
     */
    
    //including the database connection file
    include_once("config.php");
    
    // select data in descending order
    
    $result = mysqli_query($mysqli, "SELECT * FROM Contracts ORDER BY id DESC");
    
    // search by sutudent's name
    if (isset($_POST['search_name'])){
        $student_name = mysqli_real_escape_string($mysqli, $_POST['student_name']);
        if(empty($student_name)){
            echo '<script>alert("Student Name field is empty.");</script>';
        }
        else{
            $result = mysqli_query($mysqli, "SELECT * FROM Contracts WHERE name='$student_name' ORDER BY id DESC");
            $num = mysqli_num_rows($result);
            if($num==0){
                echo '<script type="text/javascript"> alert("There is no such a Contract!")</script>';
                $result = mysqli_query($mysqli, "SELECT * FROM Contracts ORDER BY id DESC");
            }
        }
    }
    
    // search by company's name
    if (isset($_POST['search_company'])){
        $company_name = mysqli_real_escape_string($mysqli, $_POST['company_name']);
        if(empty($company_name)){
            echo '<script>alert("Company Name field is empty.");</script>';
        }
        else{
            $result = mysqli_query($mysqli, "SELECT * FROM Contracts WHERE company='$company_name' ORDER BY id DESC ");
            $num = mysqli_num_rows($result);
            if($num==0){
                echo '<script type="text/javascript"> alert("There is no such a Contract!")</script>';
                $result = mysqli_query($mysqli, "SELECT * FROM Contracts ORDER BY id DESC");
            }
        }
    }
    
    // search by keyword
    if (isset($_POST['search_keyword'])){
        $keyword = mysqli_real_escape_string($mysqli, $_POST['keyword']);
        if(empty($keyword)){
            echo '<script>alert("Keyword field is empty.");</script>';
        }
        else{
            //Break down keywords into words, then filter multiple spaces
            $arrayKeyWord_0 = explode(" ", $keyword);
            $arrayKeyWord_1 = array_filter($arrayKeyWord_0);
            foreach($arrayKeyWord_1 as $value)
            {
                $arrayKeyWord[] = $value;
            }
            
            //Splicing keywords
            $where_seq = "";
            for($i=0;$i<count($arrayKeyWord);$i++)
            {
                if($i==0)
                    $where_seq .= "description_text LIKE '%$arrayKeyWord[$i]%' ";
                else
                    $where_seq .= "or description_text LIKE '%$arrayKeyWord[$i]%' ";
            }
            
            //Set query statements, send query instructions to mysql
            $query = 'SELECT * FROM Contracts WHERE binary '.$where_seq.'';
            $result = mysqli_query($mysqli, $query);
            
            $num = mysqli_num_rows($result);
            
            if($num==0){
                echo '<script type="text/javascript"> alert("There is no such a Contract!")</script>';
                $result = mysqli_query($mysqli, "SELECT * FROM Contracts ORDER BY id DESC");
            }
        }
    }
    
    // show all the contracts
    if (isset($_POST['show_all'])){
        $result = mysqli_query($mysqli, "SELECT * FROM Contracts ORDER BY id DESC");
    }
    ?>


<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
            <title>Contracts</title>
            </head>
    
    <body>
        
        <div style="margin-left:30px;margin-top:30px;padding-right:80%">
            <form action="contract.php" method="post">
                <div class="input-group input-group-sm mb-3">
                    <div class="input-group-prepend">
                        <button class="btn btn-outline-secondary" type="submit" name="search_name">Search by Student</button>
                    </div>
                    <input type="text" class="form-control" aria-label="Example text with button addon" aria-describedby="button-addon1" name="student_name">
                        </div>
            </form>
            
            <form action="contract.php" method="post">
                <div class="input-group input-group-sm mb-3">
                    <div class="input-group-prepend">
                        <button class="btn btn-outline-secondary" type="submit" name="search_company">Search by Company</button>
                    </div>
                    <input type="text" class="form-control" aria-label="Example text with button addon" aria-describedby="button-addon1" name="company_name">
                        </div>
            </form>
            
            <form action="contract.php" method="post">
                <div class="input-group input-group-sm mb-3">
                    <div class="input-group-prepend">
                        <button class="btn btn-outline-secondary" type="submit" name="search_keyword">Search by Keyword</button>
                    </div>
                    <input type="text" class="form-control" aria-label="Example text with button addon" aria-describedby="button-addon1" name="keyword">
                        </div>
            </form>
            
            <tr>
                <form action="contract.php" method="post">
                    <button type="submit" class="btn btn-outline-secondary btn-sm" name="show_all">Show All</button>
                </form>
            </tr></br>
        </div>
        
        <h6 style="color:#003E3E;text-align:center;font-size:50px">Welcome to Contracts Systeme!
        </h6>
        <div style="text-align:center;font-family:arial;font-size:26px">
            <a href="add_contract.php" class="btn btn-primary active" tabindex="-1" role="button" aria-pressed="true">Add a New Contract</a><br/>
        </div>
        <hr>
        <div style="margin-left:20%;text-align: center;padding-right: 150px">
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Date</th>
                        <th scope="col">Company</th>
                        <th scope="col">Description</th>
                        <th scope="col">Comment</th>
                        <th scope="col">Update</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <?php
                        if(empty($result)){
                            $result = mysqli_query($mysqli, "SELECT * FROM Contracts ORDER BY id DESC");
                        }
                    else{
                        while($res = mysqli_fetch_array($result)) {
                            echo "<tr>";
                            echo "<td>".$res['name']."</td>";
                            echo "<td>".$res['date']."</td>";
                            echo "<td>".$res['company']."</td>";
                            echo "<td><a href=\"show_pdf.php?id=$res[id]\">".$res['description']."</a></td>";
                            echo "<td>".$res['comment']."</td>";
                            echo "<td>
                            <a href=\"edit_contract.php?id=$res[id]\">Edit</a> |
                            <a href=\"delete_contract.php?id=$res[id]\"
                            onClick=\"return confirm('Are you sure you want to delete this contract?')\">Delete</a>|
                            <a href=\"validate.php?id=$res[id]\"
                            onClick=\"return confirm('Are you sure you want to validate this contract?')\">Validate</a>
                            </td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                    
                </tbody>
            </table>
        </div>
        <div class="card-footer text-muted" style="text-align:center;margin-top:14%">
            <p>
            @ 2020  All Rights Reserved<br>
            Copyright ownership belongs to LI Qi, shall not be reproduced , copied, or used in other ways without permission.
            </p>
        </div>
        
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
</html>

