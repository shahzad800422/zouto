@extends('layouts.app')
@section('content')
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="mt-5 mb-3">Delete Record</h2>
                <form action="{{ env('APP_URL') }}/seller/delete" method="post">
                    @csrf <!-- {{ csrf_field() }} -->
                    <div class="alert alert-danger">
                        <input type="hidden" name="id" value="<?php echo trim($_GET["id"]); ?>" />
                        <p>Are you sure you want to delete this seller record?</p>
                        <p>
                            <input type="submit" value="Yes" class="btn btn-danger">
                            <a href="{{ env('APP_URL') }}/seller" class="btn btn-secondary">No</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
