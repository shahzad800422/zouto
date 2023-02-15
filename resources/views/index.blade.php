@extends('layouts.app')

@section('content')
<div class="container">
    <h2></h2>
</div>
<?php
if (isset($_GET['uploaded_csv_message'])) {
    if ($_GET['uploaded_csv_message'] == 'uploaded_csv') { ?>
        <div class="alert alert-success">Thank You! Your Data has been updated successfully!</div>
<?php }
} ?>
<div id="exTab2" class="container">
    <ul class="nav nav-tabs">
        <li class="active" data-tab='8'><a href="#8" data-toggle="tab">Wish-lists</a></li>
        <li data-tab='1'><a href="#1" data-toggle="tab">In Stock Products</a></li>
        <li data-tab='14'><a href="#14" data-toggle="tab">Parcel</a></li>
        <li data-tab='4'><a href="#4" data-toggle="tab">Shipped</a></li>
        <li data-tab='12'><a href="#12" data-toggle="tab">Upload EXCEL</a></li>
        <li data-tab='10'><a href="#10" data-toggle="tab">Customer Info</a></li>
        <li data-tab='21'><a href="#21" data-toggle="tab">Colisrael Parcels</a></li>
        <li data-tab='22'><a href="#22" data-toggle="tab">Personal Parcels</a></li>
        <li data-tab='23'><a href="#23" data-toggle="tab">Archived Products</a></li>
        <li data-tab='24'><a href="#24" data-toggle="tab">Wallet Info</a></li>
    </ul>
    <div class="tab-content ">
        <div class="tab-pane active" id="8">
            @include('include_tabs.instock_products')
        </div>
        <div class="tab-pane" id="1">
            @include('include_tabs.wish_lists_products')
        </div>
        <div class="tab-pane" id="14">
            <?php /* @include('include_tabs.parcel_products') */ ?>
        </div>

        <div class="tab-pane" id="4">
            @include('include_tabs.shipped_products')
        </div>
        <div class="tab-pane" id="12">
            @include('include_tabs.upload_csv')
        </div>
        <div class="tab-pane" id="10">
            @include('include_tabs.personalinfo')
        </div>
        <div class="tab-pane" id="21">
            @include('include_tabs.colisrael_parcel')
        </div>
        <div class="tab-pane" id="22">
            @include('include_tabs.personal_parcel')
        </div>
        <div class="tab-pane" id="23">
            @include('include_tabs.archived_products')
        </div>
        <div class="tab-pane" id="24">
            @include('include_tabs.wallet_info')
        </div>
    </div>
</div>

@endsection
