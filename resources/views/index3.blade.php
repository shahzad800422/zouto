@extends('layouts.app')

@section('content')
<div class="bootstrap-iso">

    <style>
        /* test matching... */
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }

        div#myModal {
            overflow: auto;
        }

        .btn-delete,
        .btn-paid,
        .btn-parcel,
        .btn-parcel1,
        .btn-join-parcel,
        .btn-supp,
        .btn-hs,
        .btn-arc {
            margin-bottom: 10px;
            display: none;
        }

        .truncate {
            width: 250px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            display: inline-block;
        }

        .product_information .row {
            display: flex;
            margin: auto;
            gap: 10px;
            align-items: center;
        }

        .select_div {
            text-align: center;
            width: 30%;
            display: flex;
            margin-left: auto;
            align-items: center;
            margin-bottom: 10px;
        }

        @media (min-width: 1200px) {
            .container {
                width: 100%;
            }
        }

        .matching_capture_process_info {
            width: 100%;
            height: 15px;
            font-style: italic;
            clear: both;
            text-align: -webkit-center;
        }

        .matching_capture_process_info p {
            color: #585858;
            width: fit-content;
            background: #ffeb3b;
            padding: 1px 6px;
            border-radius: 4px;
            border: 1px solid #d1ca8f;
        }

        .matching_capture_process_info p[data-type="error"] {
            color: black;
            background: #ffe0e0;
        }

        .matching_capture_process_info p[data-type="succeeded"] {
            color: black;
            background: #dbffdb;
        }

        .cart_footer {
            text-align: right;
            font-weight: bold;
        }

        .all_table_data tr>th {
            background: #F0F0F0;
            border-bottom: none !important;
            height: 50px;
            vertical-align: middle !important;
            padding: 15px !important;
        }

        .all_table_data tr td {
            padding: 20px !important;
        }

        .all_table_data {
            margin-top: 20px;
        }

        .myaccount__order-history button.make_payment {
            float: right;
            background: #3a3a3a;
            color: #fff;
            padding: 10px 30px;
            border: none;
            text-transform: uppercase;
        }

        .myaccount__order-history button.make_payment:hover {
            background: #000;
        }

        td.numerice_data {
            text-align: right;
        }

        /*New Css*/
        .mainaccountgrid {
            max-width: 100% !important;
            padding-left: 55px !important;
            padding-right: 55px !important;
        }

        .all_table_data tr>th {
            background: #3b3f54;
            border-bottom: none !important;
            height: auto;
            vertical-align: middle !important;
            padding: 15px !important;
            color: #fff;
        }

        .wphInnerL1 h2 {
            margin: 0;
            color: #e48b97;
            font-size: 20px;
            letter-spacing: normal;
            font-weight: bold;
            text-transform: capitalize;
        }

        .mainaccountgrid {
            margin-top: 55px;
        }

        .payment_section {
            width: 100%;
            padding-left: 0;
            padding-right: 0;
        }

        .payment_section .col-xs-12.col-md-4 {
            padding: 0 !important;
            width: 100% !important;
            float: none !important;
        }

        .payment_section .col-xs-12.col-md-4 .panel-default {
            border: 1px solid #ddd;
            background: #fff;
            border-radius: 0;
            margin-top: 35px;
        }

        .payment_section .panel-body {
            padding: 30px;
        }

        .payment_section label {
            font-weight: normal;
            font-size: 13px;
            text-transform: uppercase;
            color: #3b3f54;
            letter-spacing: 1px;
        }

        .payment_section input {
            height: 40px;
            background: #f1f1f1;
        }

        .payment_section label {
            width: 100% !important;
        }

        .zoutoBtn:hover {
            background: #3b3f54;
            color: #fff;
            box-shadow: 0px 0px 0 0 #3b3f54;
        }

        .zoutoBtn {
            margin: 0 !important;
            background: #e48b97 !important;
            color: #3b3f54 !important;
            letter-spacing: normal;
            font-weight: bold;
            font-size: 15px !important;
            border-radius: 0 !important;
            box-shadow: 5px 5px 0 0 #3b3f54;
            padding: 6px 14px !important;
            border: none !important;
            transition: all ease-in-out 0.3s;
        }

        .numerice_data {
            background: #3b3f54;
            color: #fff !important;
            font-weight: bold;
        }

        .cart_footer {
            background: #f1f1f1;
        }

        /* End test matching... */
    </style>
    <style>
        div#myModalEdit {
            overflow: auto;
        }

        .product_information .row {
            display: flex;
            margin: auto;
            gap: 10px;
            align-items: center;
        }

        .custom-border {
            border: 3px solid gray;
            border-radius: 30px;
        }

        .customBox-red {
            width: 10px;
            height: 10px;
            border: 1px solid;
            display: inline-block;
            border-color: red;
            margin: 2px;
        }

        .customBox-orange {
            width: 20px;
            height: 20px;
            border: 1px solid;
            display: inline-block;
            border-color: orange;
            margin: 2px;
        }

        .customBox-darkgreen {
            width: 30px;
            height: 30px;
            border: 1px solid;
            display: inline-block;
            border-color: darkgreen;
            margin: 2px;
        }

        .text-grey {
            color: gray;
        }

        .right-border-red {
            border-right: 20px solid red;
        }

        .right-border-orange {
            border-right: 20px solid orange;
        }

        .right-border-darkgreen {
            border-right: 10px solid darkgreen;
        }

        .container1 {
            margin-left: 2% !important;
            margin-right: 2% !important;
        }

        /* tbody.otherTable tr td:nth-child(1) {
            display: none;
        } */

        /* tbody.otherTable tr td:nth-child(2) {
            display: none;
        } */

        td,
        th {
            text-align: center;
        }

        .truncate {
            width: 200px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            display: inline-block;
        }
    </style>
    <section class="mt-5 container1">
        <div class="row form-group">
            <div class="col-md-4 custom-border p-3">
                <div class="form-group">
                    <label><input type="checkbox" name="warehouse"> warehouse 1</label>
                    <label><input type="checkbox" name="warehouse"> warehouse 1</label>
                    <label><input type="checkbox" name="warehouse"> warehouse 1</label>
                </div>
                <div class="form-group pl-3">
                    Select per HS
                    <span class="customBox-red"></span>
                    <span class="customBox-orange"></span>
                    <span class="customBox-darkgreen"></span>
                </div>
                <div class="form-group">
                    <label><input type="checkbox" name="ETA"> ETA</label>
                    <input type="date" name="date" />
                </div>
            </div>
            <div class="col-md-4 p-2">
                <div class="container">
                    <h2>JESSICA COHEN</h2>
                    <select name="dropdownByCustomer" id="dropdownByCustomer">
                        <option value="">Dropdown by Customer</option>
                        <?php
                        foreach (array_slice($customers, 0, 5) as $result) {
                        ?>
                            <option value="{{ $domain_url }}/index3?id=<?php echo $result['id_customer']; ?>&cart=<?php echo $result['id_cart']; ?>&sum=<?php echo $result['paid_amount']; ?>" <?php echo (int)$result['id_customer'] === (int)$cst ? 'selected' :  '' ?>><?php echo Helper::mysql_escape($result['firstname'] . ' ' . $result['lastname'] . ' ' . $result['payment_type']); ?></option>
                        <?php
                        } ?>
                    </select>
                    <br>
                    <button type="button" class="btn btn-parcel" name="button" style="background: #fff;display: none;"><img src="{{ env('APP_URL') }}/images/new_index/link.png"></button>
                    <button type="button" class="btn btn-parcel1 m-5" name="button" style="background: #fff;display: none;"><i class="fa fa-camera fa-5x"></i></button>
                    <div style="float:right;display:none;"><button type="button" class="btn" id="cost_btn" style="border: 1px solid">cost</button></div>

                </div>
            </div>
            <div class="col-md-4 custom-border p-3">
                <h3>colis scannes <input type="text" /></h3>
                <p class="text-grey">
                    EA45DDEAG5633 </br>
                    EA45DDEAG5633 </br>
                    EA45DDEAG5633 </br>
                </p>
            </div>
        </div>
        <div class="row mb-5 mt-5">
            <div class="col-md-12">
                <table class="table table-striped table-bordered table-hover display" id="example" style="width:100%">
                    <thead>
                        <tr>
                            <th colspan="5"></th>
                            <th colspan="3">
                                <h2>HS CODE</h1>
                            </th>
                            <th colspan="4">
                                <h2>ESTIMATIONS</h2>
                            </th>
                            <th>
                                <h2>SUM</h2>
                            </th>
                            <th>
                                <h2>ACTION REQUISE</h2>
                            </th>
                        </tr>
                        <tr>
                            <th> <input type="checkbox" name="selectAll" id="selectAllRow" /> </th>
                            <th>Action</th>
                            <th> URL Product</th>
                            <th>Image of product</th>
                            <th> Name of Product</th>

                            <th><b>Categorie</b></th>
                            <th><b>Categorie</b></th>
                            <th><b>HS Code</b></th>

                            <th><b>Weight</b></th>
                            <th><b>Dimensions</b></th>
                            <th><b>Taxable</b></th>
                            <th><b>Extra</b></th>

                            <th><b>Tracking number</b></th>

                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="mainTable">
                        @foreach ($products as $result)
                        <tr class="checkRow" data-id="{{ $result['id'] }}">
                            <td><input type="checkbox" name="productCheckbox" class="checkProd deleteMultiple" value="<?= $result['id'] ?>" name="select" units="<?php echo $result['qty']; ?>" price="<?php echo $result['price']; ?>" /></td>
                            <td>
                                <a href="javascript:void(0)" hidden_val="<?php echo $result['id']; ?>" id_customer="<?php echo $result['id_customer'] . '-' . sprintf("%03s", $result['id']); ?>" product_title="<?php echo Helper::mysql_escape($result['title']); ?>" id="openModal" value="<?php echo $result['id']; ?>" product_url="<?php echo $result['product_url']; ?>" product_price="<?php echo $result['price']; ?>" product_qty="<?php echo $result['qty']; ?>" product_weight="<?php echo $result['weight']; ?>" product_weight_type="<?php echo $result['weight_type']; ?>" product_length="<?php echo $result['length']; ?>" product_width="<?php echo $result['width']; ?>" product_height="<?php echo $result['height']; ?>" product_attributes="<?php echo $result['attributes']; ?>" additional_info="<?php echo $result['additional_info']; ?>" product_col="<?php echo $result['product_color']; ?>" product_size="<?php echo $result['product_size']; ?>">Update</a>
                            </td>
                            <td><a class="truncate" href="<?php if ($result['source'] == 'cdiscount.com') {
                                                            } else {
                                                                if ($result['source'] != 'zara.com' || $result['source'] != 'amazon.fr') { ?>http://<?php }
                                                                                                                                            }
                                                                                                                                            echo $result['product_url']; ?>" target="_blank" title="<?php echo $result['product_url']; ?>"><?php echo $result['product_url']; ?></a></td>
                            <td style="text-align: center"><img src="<?php echo $result['product_image']; ?>" style="width: 100px"></td>
                            <td class="right-border-red">{{Helper::mysql_escape($result['title'])}}</td>

                            <td><b></b></td>
                            <td><b></b></td>
                            <td><b><?php echo $result['hs_code']; ?></b></td>

                            <td><b><?php echo $result['weight'] . '' . $result['weight_type']; ?></b></td>
                            <td><b><?php echo $result['length'] . 'x' . $result['width'] . 'x' . $result['height'] . '' . $result['weight_type']; ?></b></td>
                            <td><b></b></td>
                            <td><b></b></td>

                            <td><b><input type="text" name="updateTrackingNumber" class="updateTrackingNumber" value="<?php echo $result['supplier_track_number']; ?>" data-id="<?php echo $result['id']; ?>"></b></td>

                            <td><b></b></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row mb-5">
            <div class="col-md-12">
                <table class="table table-striped table-bordered table-hover display" id="example1" style="width:100%">
                    <thead>
                        <tr>
                            <th colspan="5"></th>
                            <th colspan="3">
                                <h2>HS CODE</h1>
                            </th>
                            <th colspan="4">
                                <h2>ESTIMATIONS</h2>
                            </th>
                            <th>
                                <h2>SUM</h2>
                            </th>
                            <th>
                                <h2>ACTION REQUISE</h2>
                            </th>
                        </tr>
                        <tr>
                            <th> <input type="checkbox" name="selectAll" id="selectAllRow1" /> </th>
                            <th>Action</th>
                            <th> URL Product</th>
                            <th>Image of product</th>
                            <th> Name of Product</th>

                            <th><b>Categorie</b></th>
                            <th><b>Categorie</b></th>
                            <th><b>HS Code</b></th>

                            <th><b>Weight</b></th>
                            <th><b>Dimensions</b></th>
                            <th><b>Taxable</b></th>
                            <th><b>Extra</b></th>

                            <th><b>Tracking number</b></th>

                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="otherTable">
                        @foreach (array_reverse($products1) as $result)
                        <tr class="checkRow" data-id="{{ $result['id'] }}">
                            <td><input type="checkbox" name="productCheckbox" class="checkProd deleteMultiple" value="<?= $result['id'] ?>" name="select" units="<?php echo $result['qty']; ?>" price="<?php echo $result['price']; ?>" /></td>
                            <td>

                                <a href="javascript:void(0)" hidden_val="<?php echo $result['id']; ?>" id_customer="<?php echo $result['id_customer'] . '-' . sprintf("%03s", $result['id']); ?>" product_title="<?php echo Helper::mysql_escape($result['title']); ?>" id="openModal" value="<?php echo $result['id']; ?>" product_url="<?php echo $result['product_url']; ?>" product_price="<?php echo $result['price']; ?>" product_qty="<?php echo $result['qty']; ?>" product_weight="<?php echo $result['weight']; ?>" product_weight_type="<?php echo $result['weight_type']; ?>" product_length="<?php echo $result['length']; ?>" product_width="<?php echo $result['width']; ?>" product_height="<?php echo $result['height']; ?>" product_attributes="<?php echo $result['attributes']; ?>" additional_info="<?php echo $result['additional_info']; ?>" product_col="<?php echo $result['product_color']; ?>" product_size="<?php echo $result['product_size']; ?>">Update</a>
                            </td>
                            <td><a class="truncate" href="<?php if ($result['source'] == 'cdiscount.com') {
                                                            } else {
                                                                if ($result['source'] != 'zara.com' || $result['source'] != 'amazon.fr') { ?>http://<?php }
                                                                                                                                            }
                                                                                                                                            echo $result['product_url']; ?>" target="_blank" title="<?php echo $result['product_url']; ?>"><?php echo $result['product_url']; ?></a></td>
                            <td style="text-align: center"><img src="<?php echo $result['product_image']; ?>" style="width: 100px"></td>
                            <td class="right-border-red">{{Helper::mysql_escape($result['title'])}}</td>

                            <td><b></b></td>
                            <td><b></b></td>
                            <td><b><?php echo $result['hs_code']; ?></b></td>

                            <td><b><?php echo $result['weight'] . '' . $result['weight_type']; ?></b></td>
                            <td><b><?php echo $result['length'] . 'x' . $result['width'] . 'x' . $result['height'] . '' . $result['weight_type']; ?></b></td>
                            <td><b></b></td>
                            <td><b></b></td>

                            <td><b><input type="text" name="updateTrackingNumber" class="updateTrackingNumber" value="<?php echo $result['supplier_track_number']; ?>" data-id="<?php echo $result['id']; ?>"></b></td>

                            <td><b></b></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>


        <div class="row mb-5">
            <div class="col-md-12">
                <table class="table table-striped table-bordered table-hover display" id="example3" style="width:100%">
                    <thead>
                        <tr>
                            <th colspan="5"></th>
                            <th colspan="3">
                                <h2>HS CODE</h1>
                            </th>
                            <th colspan="4">
                                <h2>ESTIMATIONS</h2>
                            </th>
                            <th>
                                <h2>SUM</h2>
                            </th>
                            <th>
                                <h2>ACTION REQUISE</h2>
                            </th>
                        </tr>
                        <tr>
                            <th> <input type="checkbox" name="selectAll" id="selectAllRow2" /> </th>
                            <th>Action</th>
                            <th> URL Product</th>
                            <th>Image of product</th>
                            <th> Name of Product</th>

                            <th><b>Categorie</b></th>
                            <th><b>Categorie</b></th>
                            <th><b>HS Code</b></th>

                            <th><b>Weight</b></th>
                            <th><b>Dimensions</b></th>
                            <th><b>Taxable</b></th>
                            <th><b>Extra</b></th>

                            <th><b>Tracking number</b></th>

                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="otherTable1">
                        @foreach (array_reverse($products2) as $result)
                        <tr class="checkRow" data-id="{{ $result['id'] }}">
                            <td><input type="checkbox" name="productCheckbox" class="checkProd deleteMultiple" value="<?= $result['id'] ?>" name="select" units="<?php echo $result['qty']; ?>" price="<?php echo $result['price']; ?>" /></td>
                            <td>

                                <a href="javascript:void(0)" hidden_val="<?php echo $result['id']; ?>" id_customer="<?php echo $result['id_customer'] . '-' . sprintf("%03s", $result['id']); ?>" product_title="<?php echo Helper::mysql_escape($result['title']); ?>" id="openModal" value="<?php echo $result['id']; ?>" product_url="<?php echo $result['product_url']; ?>" product_price="<?php echo $result['price']; ?>" product_qty="<?php echo $result['qty']; ?>" product_weight="<?php echo $result['weight']; ?>" product_weight_type="<?php echo $result['weight_type']; ?>" product_length="<?php echo $result['length']; ?>" product_width="<?php echo $result['width']; ?>" product_height="<?php echo $result['height']; ?>" product_attributes="<?php echo $result['attributes']; ?>" additional_info="<?php echo $result['additional_info']; ?>" product_col="<?php echo $result['product_color']; ?>" product_size="<?php echo $result['product_size']; ?>">Update</a>
                            </td>
                            <td><a class="truncate" href="<?php if ($result['source'] == 'cdiscount.com') {
                                                            } else {
                                                                if ($result['source'] != 'zara.com' || $result['source'] != 'amazon.fr') { ?>http://<?php }
                                                                                                                                            }
                                                                                                                                            echo $result['product_url']; ?>" target="_blank" title="<?php echo $result['product_url']; ?>"><?php echo $result['product_url']; ?></a></td>
                            <td style="text-align: center"><img src="<?php echo $result['product_image']; ?>" style="width: 100px"></td>
                            <td class="right-border-red">{{Helper::mysql_escape($result['title'])}}</td>

                            <td><b></b></td>
                            <td><b></b></td>
                            <td><b><?php echo $result['hs_code']; ?></b></td>

                            <td><b><?php echo $result['weight'] . '' . $result['weight_type']; ?></b></td>
                            <td><b><?php echo $result['length'] . 'x' . $result['width'] . 'x' . $result['height'] . '' . $result['weight_type']; ?></b></td>
                            <td><b></b></td>
                            <td><b></b></td>

                            <td><b><input type="text" name="updateTrackingNumber" class="updateTrackingNumber" value="<?php echo $result['supplier_track_number']; ?>" data-id="<?php echo $result['id']; ?>"></b></td>

                            <td><b></b></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                show all customers
                <table class="table table-striped table-bordered table-hover dataTable display" style="width:100%">
                    <thead>
                        <tr>
                            <th> <input type="checkbox" name="selectAll" /> </th>
                            <th> EA789546123FR</th>
                            <th class="right-border-red"> ACTION REQUISE</th>

                            <th><b></b></th>
                            <th><b>5kg 20x30x50cm 7kg (E)</b></th>
                            <th>barcode</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (array_slice($customers, 0, 5) as $result)
                        <tr>
                            <td><input type="checkbox" name="productCheckbox" /></td>
                            <td><a href="{{ $domain_url }}/index2_customer?id={{ $result['id_customer']}}&cart={{ $result['id_cart']}}&sum={{ $result['paid_amount']}}" target="_blank">{{ $result['firstname'] . ' ' . $result['lastname']}}</a></td>

                            <td class="right-border-red"></td>

                            <td><b></b></td>
                            <td><b></b></td>
                            <td><b></b></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

<!-- Modal -->
<div id="myModalEdit" class="modal">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">MA DEMANDE D'AJOUT PRODUIT</h4>
            </div>
            <div class="col-md-12 choose-cake">
                <div class="modal-body">
                    <div class="info_message"></div>
                    <form class="product_info_edit" enctype="multipart/form-data" id="editInfoForm">
                        <input type="hidden" name="id" value="" id="hidden_val">
                        <div class="popupWindowInner">
                            <div class="wishlistproduct_container">
                                <input type="hidden" name="id_customer" value="" id="id_customer">
                                <br />

                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <h6>INFORMATIONS PRODUIT</h6>
                                    </div>
                                    <!--  <div class="pwiFormLeft">
               URL du produit*
              </div> -->
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <input class="form-control product_url noBorder" name="product_url" id="product_url" type="text" placeholder="URL du produit*" />
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- <div class="pwiFormLeft">
                Nom du produit
              </div> -->
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <input class="pwiFormInput form-control noBorder" type="text" name="product_title" id="product_title" placeholder="Nom du produit" />
                                    </div>
                                    <!-- <div class="pwiFormLeft">
                Informations supplémentaires (ex : couleur)

              </div> -->
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <input class="pwiFormInput form-control noBorder" type="text" name="product_color" placeholder="Informations supplémentaires (ex : couleur)" id="additional_info" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <input class="pwiFormInput form-control noBorder" type="text" name="product_col" id="product_col" placeholder="Product Color" />
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <input class="pwiFormInput form-control noBorder" type="text" name="product_size" placeholder="Product Size" id="product_size" />
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <h6>DÉTAILS DE LA COMMANDE</h6>
                                    </div>
                                    <!-- <div class="pwiFormLeft">
                Prix du produit en ligne
              </div> -->
                                    <div class="col-lg-4 col-md-4 col-sm-12 fcHaveIcon">
                                        <input class="pwiFormInput form-control noBorder" type="text" name="price" id="product_price" min="0.01" size="0.01" placeholder="Prix du produit en ligne" />
                                        <span class="fcIcon">&#128;</span>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <label class="quantity_desiredtext">Quantité désirée</label>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <input class="form-control" type="number" name="product_qty" id="product_qty" min="1" size="1" value="1" placeholder="Quantité désirée" />
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-sm-12">
                                        <h6>DÉTAILS D'EXPÉDITION &nbsp; <i class="fa fa-caret-down" aria-hidden="true"></i></h6>
                                        <div class="row">
                                            <div class="col-md-4 col-sm-12 fcHaveIcon">
                                                <input class="pwiFormInput form-control noBorder" type="text" name="product_weight" id="product_weight" min="1" size="1" value="1" placeholder="Poids" />
                                            </div>
                                            <div class="col-md-4 col-sm-12 fcHaveIcon">
                                                <span class="fcIcon" style="top: 0px;float: right !important;margin-left: 35px;">
                                                    <input class="pwiFormInput form-control noBorder" type="text" name="product_weight_type" id="product_weight_type" value="" placeholder="kg" />
                                                </span>
                                            </div>
                                            <div class="fcDimensions">
                                                <h6>Dimensions du colis L x I x h (en cm)</h6>
                                                <input class="pwiFormInput form-control" type="number" name="order_length" id="product_length" min="1" size="1" value="1" placeholder="10" />
                                                <input class="pwiFormInput form-control" type="number" name="order_width" id="product_width" min="1" size="1" value="1" placeholder="10" />
                                                <input class="pwiFormInput form-control" type="number" name="order_height" id="product_height" min="1" size="1" value="1" placeholder="10" />
                                                <h6 class="dimen-line">soit 20kg calcul au volume</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <input class="form-control product_attributes noBorder" name="product_attributes" id="product_attributes" type="text" placeholder="Attributs du produit">
                                    </div>

                                    <label> Télécharger l'image du produit : </label>
                                    <input type="file" id="file" name="file">
                                </div>


                                <div class="row">
                                    <div class="col-sm-12 textFooterModel">
                                        <p>Retrouvez votre produit dans l'onglet <strong><em>Ma liste d'achats</em></strong></p>
                                        <p><i class="fa fa-info"></i> Pour ajouter vos produits directement depuis les boutiques web automatiquement, installez l'extension Chrome, <a href="#">Zouto Assistant, </a>suivez le guide.</p>
                                        <p><a href="#">Besoin d’aide ?</a> Contactez le service client et nous vous répondrons dans les meilleurs délais.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" id="updateToWishlist_product_list">METTRE À JOUR MON PRODUIT</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="myModal03">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close closeModal3" data-dismiss="modal" data-bs-dismiss="modal">&times;</button>
                <h4 class="modal-title">Cost</h4>
            </div>
            <div class="modal-body">
                <div class="info_message"></div>
                <form class="cost_product">
                    <!--<input type="hidden" name="iddb" value="" id="iddb">-->
                    <div class="form-group">
                        <label for="hs_code">Cost :</label>
                        <input type="hidden" name="id_customer" value="<?php echo @$_GET['id'] ?>">
                        <input type="hidden" name="id_cart" value="<?php echo @$_GET['cart'] ?>">
                        <input class="form-control" name="cost" id="cost">
                        <span id="hsError"></span>
                    </div>
                    <button type="submit" class="btn btn-default" id="cost_submit">Soumettre</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default closeModal3" data-dismiss="modal" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<div class="modal" id="myModal04">
    <div class="modal-dialog">
        <!-- Modal content-->
        <form class="cst_parcel_form">
            <div class="modal-content">
                <div class="modal-header" style="padding-bottom: 0px;">
                    <button type="button" class="close closeModal4" data-dismiss="modal" data-bs-dismiss="modal">&times;</button>
                    <div style="display: flex;align-items: center;padding-bottom: 10px;">
                        <div>
                            <h4 class="modal-title">Warehouse </h4>
                        </div>
                        <div class="form-group" style="margin-left: 50px;margin-bottom: 4px;">

                            <div style="display: flex;justify-content: center;align-items: center;">

                                <?php for ($i = 1; $i <= 3; $i++) {
                                    $vals = 'warehouse' . $i; ?>

                                    <input type="checkbox" name="warehouse[]" <?php echo (in_array($i, $array_warehouse)) ? 'checked' : ''; ?> value="<?php echo $i; ?>" style="margin-right: 5px;"> <span style="margin-right: 10px;">Warehouse <?php echo $i; ?></span> <br>

                                <?php } ?>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-body" style="padding-bottom: 50px;">
                    <div class="info_message"></div>

                    <input type="hidden" name="id_customer" value="" id="idcst">
                    <input type="hidden" name="id_cart" value="<?php echo @$_GET['cart']; ?>" id="cart_for_wallet">
                    <input type="hidden" name="cost" value="" id="cost_for_wallet">
                    <input type="hidden" name="action" value="single">

                    <div class="form-group">
                        <label for="hs_code">Estimation de livraison</label>

                        <input type="date" name="date" value="" class="form-control setDate">
                        <span id="hsError"></span>
                    </div>

                    <div class="form-group">
                        <label for="hs_code">Create parcel and apply to</label>

                        <select class="form-control" name="parcel">
                            <option value="0" selected>
                                Pending
                            </option>
                            <option value="1">
                                Colisrael
                            </option>
                            <option value="2">
                                Personal
                            </option>
                        </select>
                        <span id="hsError"></span>
                    </div>

                    <div style="float:left;">
                        <input type="checkbox" name="is_mail" value="not_send">
                        <label for="hs_code" style="margin-left: 15px">Ne pas avertir le client par email</label>
                        <span id="hsError"></span>
                    </div>
                    <button type="submit" style="float:right" class="btn btn-default" id="cst_parcel_submit">Soumettre</button>
                </div>
        </form>
    </div>
</div>
<script>
    $(document).ready(function() {
        if ($('.deleteMultiple').length == 0) {
            $('.cost').html(0 + '€')
            $('.balance').html(0 + '€')
        }
        $('.otherTable .checkProd').change(function() {
            if (this.checked) {
                $(this).parent('td').parent('tr').attr('isCheck', true);
            } else {
                $(this).parent('td').parent('tr').attr('isCheck', false);
            }
            if ($('.otherTable .deleteMultiple:checkbox:checked').length > 0) {
                $('.btn-parcel1').show();
            } else {
                $('.btn-parcel1').hide();
            }
        });
        $('.mainTable .checkProd').change(function() {
            if (this.checked) {
                $(this).parent('td').parent('tr').attr('isCheck', true);
            } else {
                $(this).parent('td').parent('tr').attr('isCheck', false);
            }
            if ($('.mainTable .deleteMultiple:checkbox:checked').length > 0) {
                $('.btn-parcel').show();
            } else {
                $('.btn-parcel').hide();
            }
            // $('.otherTable').html('');
            // $('.mainTable .checkRow[ischeck="true"]').each((i, x) => {
            //     $('.otherTable').append('<tr>' + $(x).html() + '</tr>');
            // });
        });
        $('#selectAllRow').change(function() {
            $('.mainTable .checkProd').prop('checked', this.checked);
            $('.mainTable .checkRow').attr('isCheck', this.checked);
            if ($('.mainTable .deleteMultiple:checkbox:checked').length > 0) {
                $('.btn-parcel').show();
            } else {
                $('.btn-parcel').hide();
            }
            // $('.otherTable').html('');
            // $('.mainTable .checkRow[ischeck="true"]').each((i, x) => {
            //     $('.otherTable').append('<tr>' + $(x).html() + '</tr>');
            // });
        });
        $('#selectAllRow1').change(function() {
            $('.otherTable .checkProd').prop('checked', this.checked);
            $('.otherTable .checkRow').attr('isCheck', this.checked);
            if ($('.otherTable .deleteMultiple:checkbox:checked').length > 0) {
                $('.btn-parcel1').show();
            } else {
                $('.btn-parcel1').hide();
            }
        });

        $('body').on('change', '#dropdownByCustomer', () => {
            const href = $('#dropdownByCustomer').val();
            if (href !== '') {
                window.location.replace(href);
            }
        });

        $('body').on("keyup", ".updateTrackingNumber", function(e) {
            var supplier_track_number = $(this).val();
            var id = $(this).attr("data-id");
            $.ajax({
                type: "POST",
                url: APP_URL + "/update_supplier_track_number",
                data: {
                    id,
                    supplier_track_number,
                },
                methos: "POST",
                dataType: "html",
                success: function(data) {
                    // location.reload();
                    // alert('updated successfully!');
                },
            });
        });
    });

    $(document).on("click", "#openModal", function(e) {
        e.preventDefault();
        var modal = document.getElementById("myModalEdit");
        modal.style.display = "block";
        $("#hidden_val").val($(this).attr("hidden_val"));
        $("#id_customer").val($(this).attr("id_customer"));
        $("#product_url").val($(this).attr("product_url"));
        $("#product_title").val($(this).attr("product_title"));
        $("#additional_info").val($(this).attr("additional_info"));

        $("#product_price").val($(this).attr("product_price"));
        $("#product_qty").val($(this).attr("product_qty"));
        $("#product_weight").val($(this).attr("product_weight"));
        $("#product_weight_type").val($(this).attr("product_weight_type"));

        $("#product_length").val($(this).attr("product_length"));
        $("#product_width").val($(this).attr("product_width"));
        $("#product_height").val($(this).attr("product_height"));
        $("#product_attributes").val($(this).attr("product_attributes"));
        $("#product_size").val($(this).attr("product_size"));
        $("#product_col").val($(this).attr("product_col"));
    });

    $(document).on("click", ".close, #closeid", function(e) {
        e.preventDefault();
        var modal = document.getElementById("myModalEdit");
        modal.style.display = "none";
    });

    $(document).on("click", "#updateToWishlist_product_list", function() {
        var fdata = new FormData();
        var myform = $(".product_info_edit"); // specify the form element
        var idata = myform.serializeArray();
        var document = $('input[type="file"]')[0].files[0];
        fdata.append("documents", document);
        $.each(idata, function(key, input) {
            fdata.append(input.name, input.value);
        });
        //var formData = jQuery('#editInfoForm').serialize();
        $.ajax({
            url: APP_URL + "/update_wishlist_products_backend",
            cache: false,
            enctype: "multipart/form-data",
            processData: false,
            contentType: false,
            data: fdata,
            type: "POST",
            success: function(data) {
                //$(".all_wishlist_products").html(data);

                setTimeout(function() {
                    $(".modal").css("display", "none");
                    $("#myModalEdit").css("display", "none");

                    Swal.fire({
                        title: "Product Updated Successfully!",
                        html: true,
                        type: "info",
                        customClass: "swal-wide",
                        showConfirmButton: true,
                    });
                    setTimeout(function() {
                        setTimeout("window.location = APP_URL", 100);
                    }, 3000);
                }, 2000);
            },
        });
    });

    $('.btn-parcel1').click(function() {
        let idObject = [];
        $('.otherTable .deleteMultiple:checkbox:checked').each(function() {
            idObject.push(this.value);
        })
        $.ajax({
            type: "POST",
            url: APP_URL + "/scan_products",
            data: {
                ids: idObject
            },
            methos: "POST",
            dataType: 'html',
            success: function(data) {
                alert('Scanned Successfully!');
                window.location.reload();
            },
        });
    });

    $('.btn-parcel').click(function() {
        let idObject = [];
        let thisObject = [];
        $('.mainTable .deleteMultiple:checkbox:checked').each(function() {
            idObject.push(this.value);
            thisObject.push(this);
        })
        $('.cst_parcel_form #idcst').val(idObject);
        $('#cost_btn').click()

        //   var result = confirm("Want to create parcel?");
        //   if (result) {
        //     createparcelData(idObject,'single',thisObject)
        //   }
    })
    $('#cost_btn').click(function() {
        var modal = document.getElementById("myModal03");
        modal.style.display = "block";
    });
    $('#cost_submit').click(function() {
        event.preventDefault();
        $('#cost_for_wallet').val($('#cost').val())
        if ($('[name="cost"]').val() == '') {
            alert("Can't have empty cost");
            return false;
        }
        $.ajax({
            type: "POST",
            url: APP_URL + "/add_matching_cost",
            data: $('.cost_product').serialize(),
            methos: "POST",
            dataType: 'html',
            success: function(data) {
                $('#myModal04').show();
                return false;
            },
        });
        return false;
    });
    $(document).on("click", ".closeModal3", function(e) {
        e.preventDefault();
        var modal = document.getElementById("myModal03");
        modal.style.display = "none";
    });

    $(document).on("click", ".closeModal4", function(e) {
        e.preventDefault();
        var modal = document.getElementById("myModal04");
        modal.style.display = "none";
    });


    $('#cst_parcel_submit').click(function() {
        event.preventDefault();
        $('#validate').click(function(e) {
            e.preventDefault();
        })
        $.ajax({
            type: "POST",
            url: APP_URL + '/create_parcel_backend',
            data: $('.cst_parcel_form').serialize(),
            success: function(data) {
                alert(data);
                // alert('Parcel created Successfully');
                if (window.location.search != '') {
                    // window.location.href = window.location.href+'&nocache';
                } else {
                    // window.location.href = window.location.href+'?nocache';
                }
                // location.reload();
                //window.location.href = window.location.origin+window.location.pathname+'?tab='+$('ul.nav.nav-tabs li.active').data('tab')
                // if (action == 'single') {
                //   $(object).closest('tr').fadeOut("slow");
                // }else {
                //   for (let value of object) {
                //     $(value).closest('tr').fadeOut("slow");
                //   }
                // }
            },
            error: function(xhr, status, error) {
                console.error(xhr);
            }
        });
    })
</script>
@endsection
