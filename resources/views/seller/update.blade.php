@extends('layouts.app')
@section('content')
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="mt-5">Update Record</h2>
                <p>Please edit the input values and submit to update the seller record.</p>
                <form action="{{ env('APP_URL') }}/seller/update" method="post">
                    @csrf <!-- {{ csrf_field() }} -->
                    <div class="form-group">
                        <label>Seller Name</label>
                        <input type="text" name="seller_name" class="form-control <?php echo (!empty($seller_name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $seller_name; ?>">
                        <span class="invalid-feedback"><?php echo $seller_name_err; ?></span>
                    </div>
                    <div class="form-group">
                        <label>Discount Type</label>
                        <select name="discount_type" class="form-control">
                            <option value="Fixed" <?php if ($row['discount_type'] == 'Fixed') echo ' selected="selected"'; ?>>Fixed</option>
                            <option value="Percentage" <?php if ($row['discount_type'] == 'Percentage') echo ' selected="selected"'; ?>>Percentage</option>
                        </select>
                        <span class="invalid-feedback"><?php echo $discount_type_err; ?></span>
                    </div>
                    <div class="form-group">
                        <label>Discount Value</label>
                        <input type="text" name="discount_value" class="form-control <?php echo (!empty($discount_value_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $discount_value; ?>">
                        <span class="invalid-feedback"><?php echo $discount_value_err; ?></span>
                    </div>
                    <input type="hidden" name="id" value="<?php echo $id; ?>" />
                    <input type="submit" class="btn btn-primary" value="Submit">
                    <a href="{{ env('APP_URL') }}/seller" class="btn btn-secondary ml-2">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
