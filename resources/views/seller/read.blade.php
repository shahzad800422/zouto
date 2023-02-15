@extends('layouts.app')
@section('content')
<?php
if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    $param_id = trim($_GET["id"]);
    $result = Helper::dbQuery("SELECT * FROM seller WHERE id = $param_id");
    if ($result) {
        if (count($result) == 1) {
            $row = $result[0];
            $seller_name = $row["seller_name"];
            $discount_type = $row["discount_type"];
            $discount_value = $row["discount_value"];
        } else {
            header("location: error");
            exit();
        }
    } else {
        echo "Oops! Something went wrong. Please try again later.";
    }
} else {
    header("location: error");
    exit();
}
?>
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h1 class="mt-5 mb-3">View Record</h1>
                <div class="form-group">
                    <label>Seller Name</label>
                    <p><b><?php echo $row["seller_name"]; ?></b></p>
                </div>
                <div class="form-group">
                    <label>Discount Type</label>
                    <p><b><?php echo $row["discount_type"]; ?></b></p>
                </div>
                <div class="form-group">
                    <label>Discount Value</label>
                    <p><b><?php echo $row["discount_value"]; ?></b></p>
                </div>
                <p><a href="{{ env('APP_URL') }}/seller" class="btn btn-primary">Back</a></p>
            </div>
        </div>
    </div>
</div>
@endsection
