@extends('layouts.app')

@section('content')

<?php

if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){


    $sql = Helper::dbQuery("SELECT * FROM keyword WHERE id = ?");
    
    if($stmt = mysqli_prepare($con, $sql)){
       
        mysqli_stmt_bind_param($stmt, "i", $param_id);
      
        $param_id = trim($_GET["id"]);
    
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
            if(mysqli_num_rows($result) == 1){
        
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                $keyword = $row["keyword"];
                $value = $row["value"];
              
            } else{
                header("location: error.php");
                exit();
            }
            
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($con);
} else{
    header("location: error.php");
    exit();
}
?>
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="mt-5 mb-3">View keyword</h1>
                    <div class="form-group">
                        <label>keyword</label>
                        <p><b><?php echo $row["keyword"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>value</label>
                        <p><b><?php echo $row["value"]; ?></b></p>
                    </div>
                    <p><a href="keyword.php" class="btn btn-primary">Back</a></p>
                </div>
            </div>        
        </div>
    </div>
@endsection