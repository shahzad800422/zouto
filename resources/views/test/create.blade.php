@extends('layouts.app')

@section('content')

<?php
$keyword = "";
$value = "";
$keywor_err = "";
$value_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $input_keyword = trim($_POST["keyword"]);
    if (empty($input_keyword)) {
        $keyword_err = "Please enter a keyword.";
    } elseif (!filter_var($input_keyword, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
        $keyword_err = "Please enter a valid keyword.";
    } else {
        $keyword = $input_keyword;
    }
    $input_value = trim($_POST["value"]);
    if (empty($input_value)) {
        $value_err = "Please enter a value.";
    } elseif (!filter_var($input_value, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
        $value_err = "Please enter a valid vaue.";
    } else {
        $value = $input_value;
    }

    if (empty($keyword_err) && empty($value_err)) {

        $sql = Helper::dbQuery("INSERT INTO keyword (keyword , value) VALUES (?,?)");

        if ($sql) {
            // mysqli_stmt_bind_param($stmt, 'ss', $param_keyword, $param_value);

            $param_keyword = $keyword;
            $param_value = $value;
            if (mysqli_stmt_execute($stmt)) {
                header("location: keyword.php");
                exit();
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        mysqli_stmt_close($stmt);
    }

    mysqli_close($con);
}
?>
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="mt-5">Create keyword</h2>
                <p>Please fill this form and submit to add keywrod.</p>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group">
                        <label>keyword</label>
                        <input type="text" name="keyword" class="form-control <?php echo (!empty($keyword_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $keyword; ?>">
                        <span class="invalid-feedback"><?php echo $keyword_err; ?></span>
                    </div>
                    <div class="form-group">
                        <label>value</label>
                        <input type="text" name="value" class="form-control <?php echo (!empty($value_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $value; ?>">
                        <span class="invalid-feedback"><?php echo $value_err; ?></span>
                    </div>

                    <input type="submit" class="btn btn-primary" value="Submit">
                    <a href="keyword.php" class="btn btn-secondary ml-2">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
