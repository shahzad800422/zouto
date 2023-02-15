@extends('layouts.app')
@section('content')
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="mt-5 mb-3 clearfix">
                    <h2 class="pull-left">Sellers Details</h2>
                    <a href="{{ env('APP_URL') }}/seller/create" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add New Seller</a>
                </div>
                <?php
                $result = Helper::dbQuery("SELECT * FROM seller");
                if (count($result) > 0) {
                    echo '<table class="table table-bordered table-striped">';
                    echo "<thead>";
                    echo "<tr>";
                    echo "<th>SNo.</th>";
                    echo "<th>Seller Name</th>";
                    echo "<th>Discount Type</th>";
                    echo "<th>Discount Value</th>";
                    echo "<th>Action</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";
                    foreach ($result as $row) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['seller_name'] . "</td>";
                        echo "<td>" . $row['discount_type'] . "</td>";
                        echo "<td>" . $row['discount_value'] . "</td>";
                        echo "<td>";
                        echo '<a href="' . env('APP_URL') . '/seller/read?id=' . $row['id'] . '" class="mr-3" title="View Record" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
                        echo '<a href="' . env('APP_URL') . '/seller/update?id=' . $row['id'] . '" class="mr-3" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                        echo '<a href="' . env('APP_URL') . '/seller/delete?id=' . $row['id'] . '" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                        echo "</td>";
                        echo "</tr>";
                    }
                    echo "</tbody>";
                    echo "</table>";
                } else {
                    echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                }
                ?>
            </div>
        </div>
    </div>
</div>
@endsection
