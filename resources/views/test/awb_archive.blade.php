@extends('layouts.app')

@section('content')

<style>
    td,
    th {
        border: 1px solid #dddddd;
    }

    .row {
        margin: 0;
    }

    a.arti {
        text-decoration: none;
        color: #555;
    }

    .box_par {
        /*display: flex;*/
        /*justify-content: space-between;*/
    }

    .col-md-12.boxes {
        border: 2px solid #000;
        display: flex;
        justify-content: center;
        padding: 20px;
        /*border-radius: 20px;*/
        /*min-height: 285px;*/
        margin-bottom: 10px !important;
        max-height: 80vh;
        overflow-y: scroll;
        border-bottom-right-radius: 0;
        border-top-right-radius: 0;
    }

    .container.main_head {
        padding-top: 60px;
        padding-bottom: 60px;
    }

    h4.text-center.pt-1 {
        font-weight: bold;
    }

    .main:hover .inside {
        display: block !important;
    }

    .btn-pdf,
    .btn-parcel,
    .btn-join-parcel,
    .btn-arc,
    .btn-update_product,
    .btn-update_hs_code,
    .btn-match {
        margin-bottom: 10px;
        display: none;
    }

    .fl-right {
        /*float: right;*/
    }

    .mb-0 {
        margin-bottom: 0;
    }

    .mt-0 {
        margin-top: 0;
    }

    .fw-b {
        font-weight: bold;
    }

    .row {
        margin: 0;
    }

    .back-col {
        background: #dfdddd;
        padding: 35px 16px;
    }

    .bord-col {
        padding: 44px 16px;
        border: 1px solid #000;
    }

    .col-md-6 {
        width: 50%;
    }

    .text-right {
        text-align: right;
    }

    .col-md-5 {
        width: 41.66666667%;
    }

    .col-md-7 {
        width: 58.33333333%;
    }

    .col-md-12 {
        width: 100%;
    }

    table {}

    tr:nth-child(even) {
        background-color: #dddddd;
    }

    th {
        padding: 5px;
    }

    .hiddendiv {
        display: block !important;
        font-weight: normal;
    }

    input.deleteMultiple {
        margin-right: 5px;
    }

    .cst-btn,
    .cst-btn2 {
        margin: 10px 0;
        min-width: 100px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .cst-btn.active {
        background: #000;
        color: #fff;
    }

    .new_price_img {
        width: 80px !important;
        height: 50px;
        border: 1px solid #000;
        cursor: pointer;
        opacity: .5;
    }

    .new_price_img.active {
        opacity: 1;
        border: 3px solid #000;
    }

    .new_price_img:hover {
        opacity: 1;
    }

    div#exampleModal .modal-dialog {
        margin: 200px auto;
    }

    div#exampleModal2 .modal-dialog {
        margin: 200px auto;
    }

    .pdf_count {
        display: none;
    }

    input.deleteMultiple {
        pointer-events: none
    }

    .no_border td {
        border: unset;
    }

    a.open_delivery {
        cursor: pointer;
    }

    .delivery {
        position: fixed;
        width: 575px;
        left: 40%;
        border: 2px solid #000;
        padding-left: 30px;
        padding-bottom: 20px;
        padding-top: 20px;
    }

    @media (min-width: 1200px) {
        .container {
            /*width: 1450px;*/
        }
    }
</style>

<div class="container main_head">
    <div class="row box_par">
        <?php
        $res_awb = Helper::dbQuery("SELECT customer_product_wishlist.id, customer_product_wishlist.id_customer, customer_product_wishlist.parcel_status, customer_product_wishlist.invoice_number, awb.awb_number FROM customer_product_wishlist INNER JOIN awb on (awb.invoice_number = customer_product_wishlist.invoice_number) where customer_product_wishlist.awb_archive = 1 GROUP BY awb.awb_number");

        ?>
        <div class="col-md-3">
            <table>
                <thead>
                    <tr>
                        <th>Un Archive</th>
                        <th>AWB</th>
                        <th>Invoice</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (count($res_awb) > 0) {
                        foreach ($res_awb as $result_awb) {
                    ?>

                            <tr>
                                <td style="text-align: center"><img title="Move to archive" class="move_to_archive" data-awb="<?php echo $result_awb['awb_number']; ?>" data-invoice="<?php echo $result_awb['invoice_number']; ?>" src="https://cdn.shopify.com/s/files/1/0515/4927/4282/files/icons8-share-24.png?v=1648125534" style="width: 20px;margin-right: 5px;cursor: pointer"></td>
                                <td><a class="open_delivery" data-id="<?php echo $result_awb['awb_number']; ?>"><?php echo $result_awb['awb_number']; ?></a></td>
                                <td><?php echo $result_awb['invoice_number']; ?></td>
                                <td>
                                    <select class="form-control pro_stat" data-invoice="<?php echo $result_awb['invoice_number']; ?>" data-customer_id="<?php echo $result_awb['id_customer']; ?>" data-awb="<?php echo $result_awb['awb_number']; ?>" style="width: 145px">
                                        <option>Select</option>
                                        <option value="3" <?php if ($result_awb['parcel_status'] == '3') {
                                                                echo 'selected';
                                                            } ?>>En bon chemin</option>
                                        <option value="4" <?php if ($result_awb['parcel_status'] == '4') {
                                                                echo 'selected';
                                                            } ?>>Dédouanné</option>
                                        <option value="5" <?php if ($result_awb['parcel_status'] == '5') {
                                                                echo 'selected';
                                                            } ?>>Disponible</option>
                                        <option value="6" <?php if ($result_awb['parcel_status'] == '6') {
                                                                echo 'selected';
                                                            } ?>>En livraison</option>
                                        <option value="7" <?php if ($result_awb['parcel_status'] == '7') {
                                                                echo 'selected';
                                                            } ?>>Livré</option>
                                        <option value="8" <?php if ($result_awb['parcel_status'] == '7') {
                                                                echo 'selected';
                                                            } ?>>aaa</option>
                                    </select>
                                </td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <?php
        if (count($res_awb) > 0) {
            foreach ($res_awb as $result_awb) {
                $awb = $result_awb['awb_number'];
        ?>
                <div class="col-md-6 delivery" id="<?php echo $awb; ?>" style="display: none">
                    <?php
                    $res_sup = Helper::dbQuery("SELECT customer_product_wishlist.id, customer_product_wishlist.id_customer, customer_product_wishlist.selected_shipping, customer_product_wishlist.parcel_status, customer_product_wishlist.invoice_number, customer_product_wishlist.supplier_track_number, customer_product_wishlist.parcel_weight, customer_product_wishlist.parcel_l, customer_product_wishlist.parcel_b, customer_product_wishlist.parcel_h, customer_product_wishlist.source, awb.awb_number FROM customer_product_wishlist INNER JOIN awb on (awb.invoice_number = customer_product_wishlist.invoice_number) where customer_product_wishlist.awb = $awb GROUP BY customer_product_wishlist.supplier_track_number");

                    if (count($res_sup)) {
                        foreach ($res_sup as $result_sup) {
                            if (!empty($result_sup['supplier_track_number'])) {
                    ?>
                                <div>
                                    <table class="no_border">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div style="min-width: 150px" id="openModal6" value="<?php echo $result_sup['id']; ?>" data-supp_tracking="<?php echo $result_sup['supplier_track_number']; ?>" weight="<?php echo $result_sup['parcel_weight']; ?>" l="<?php echo $result_sup['parcel_l']; ?>" b="<?php echo $result_sup['parcel_b']; ?>" h="<?php echo $result_sup['parcel_h']; ?>" selected_shipping="<?php echo $result_sup['selected_shipping']; ?>" style="cursor: pointer"><?php echo $result_sup['supplier_track_number']; ?></div>
                                                </td>
                                                <td>
                                                    <div style="min-width: 100px"><b><?php echo $result_sup['source']; ?></b></div>
                                                </td>
                                                <td>
                                                    <div style="min-width: 120px"><?php if (!empty($result_sup['parcel_weight']) && !empty($result_sup['parcel_l'])) {
                                                                                        echo $result_sup['parcel_l'] . 'x' . $result_sup['parcel_b'] . 'x' . $result_sup['parcel_h'] . 'cm';
                                                                                    } ?></div>
                                                </td>
                                                <td>
                                                    <div style="min-width: 50px"><?php echo $result_sup['parcel_weight'];
                                                                                    if (!empty($result_sup['parcel_weight'])) {
                                                                                        echo 'kg';
                                                                                    } ?></div>
                                                </td>
                                                <td>
                                                    <select class="form-control pro_statt" data-invoice="<?php echo $result_awb['invoice_number']; ?>" data-customer_id="<?php echo $result_awb['id_customer']; ?>" data-awb="<?php echo $result_awb['awb_number']; ?>" data-supplier_track_number="<?php echo $result_sup['supplier_track_number']; ?>">
                                                        <option>Select</option>
                                                        <option value="3" <?php if ($result_sup['parcel_status'] == '3') {
                                                                                echo 'selected';
                                                                            } ?>>En bon chemin</option>
                                                        <option value="4" <?php if ($result_sup['parcel_status'] == '4') {
                                                                                echo 'selected';
                                                                            } ?>>Dédouanné</option>
                                                        <option value="5" <?php if ($result_sup['parcel_status'] == '5') {
                                                                                echo 'selected';
                                                                            } ?>>Disponible</option>
                                                        <option value="6" <?php if ($result_sup['parcel_status'] == '6') {
                                                                                echo 'selected';
                                                                            } ?>>En livraison</option>
                                                        <option value="7" <?php if ($result_sup['parcel_status'] == '7') {
                                                                                echo 'selected';
                                                                            } ?>>Livré</option>
                                                        <!--<option value="8" <?php if ($result_sup['parcel_status'] == '7') {
                                                                                    echo 'selected';
                                                                                } ?>>aaa</option>-->
                                                    </select>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                    <?php
                            }
                        }
                    }
                    ?>
                </div>
        <?php
            }
        }
        ?>

    </div>

    <!--  <div class="col-md-12" style="padding: 30px 0;font-size: 18px;font-weight: bold;">-->
    <!--    <a href="{{ env('APP_URL') }}/shipment_archive">Archive</a>-->
    <!--</div>-->
    <!--  <div class="col-md-12" style="text-align: center;padding: 30px 0;font-size: 18px;font-weight: bold;">-->
    <!--    <a href="{{ env('APP_URL') }}/index_new">< arrière</a>-->
    <!--</div>-->
</div>

<div class="pdf_container" style="display:none">
    <div class="row pdf">
        <table style="margin-bottom: 20px;">
            <thead>
                <tr>
                    <th style="font-size: 30px;border:unset">Electro Trade</th>
                    <th style="font-size: 30px;border:unset;text-align: right;">Facture<br><span style="font-weight: normal !important;font-size: 20px !important">INV <span class="inv_number"></span><span class="pdf_count"></span></span></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="border:unset;padding: 20px;padding-bottom: 10px;">Émetteur</td>
                    <td style="border:unset;padding: 20px;padding-bottom: 10px;">Adressé à</td>
                </tr>
                <tr>
                    <td style="background: #dddddd;">
                        <div style="padding: 20px;">
                            <span style="font-weight: bold;font-size: 18px">Electro Trade</span><br>
                            6 rue d'Armaillé<br>75017 Paris<br>France<br><br>Tél.: 0755549247
                        </div>
                    </td>
                    <td style="background: #fff;border: unset;">
                        <div style="padding: 20px;background: #fff;margin: 0 20px;">
                            <span style="font-weight: bold;font-size: 18px">Colisrael</span><br>
                            Yeshuat David 12<br>Modiin Ilit 7180602<br>Israel<br><br>VAT Number 328871694
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <table>
            <thead>
                <tr>
                    <th>Internal Ref.</th>
                    <th>Description</th>
                    <th>Product Name</th>
                    <th>Qty</th>
                    <th>Unit Price</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody class="pdf_body">
                <!--<tr>-->
                <!--    <td>Product 1</td>-->
                <!--    <td>ABC</td>-->
                <!--    <td>1</td>-->
                <!--    <td>10</td>-->
                <!--</tr>-->
            </tbody>
        </table>
        <div style="margin-top: 50px">
            <p style="text-align: center;">The exporter of the products covered by this document declares that except where otherwise clearly indicated these products are of EU Preferential origin.</p>
            <p style="text-align: center;margin-bottom: 0">Capital de 100 € - SIREN: 891920084</p>
            <p style="text-align: center">Numéro TVA: FR35891920084 </p>
        </div>
    </div>
</div>
<div class="packing_container" style="display:none">
    <div class="row packing">
        <table style="margin-bottom: 20px;">
            <thead>
                <tr>
                    <th style="font-size: 30px;border:unset">Packing list<br><span style="font-size: 20px !important">for INV-<span class="inv_number"></span></span></th>
                    <th style="font-size: 30px;border:unset;text-align: right;">
                        <!--Facture<br><span style="font-weight: normal !important;font-size: 15px !important">INV<?php echo date("ymd"); ?> - <span class="pdf_count"></span></span>-->
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="border:unset;padding: 20px;padding-bottom: 10px;">Émetteur</td>
                    <td style="border:unset;padding: 20px;padding-bottom: 10px;">Adressé à</td>
                </tr>
                <tr>
                    <td style="background: #dddddd;">
                        <div style="padding: 20px;">
                            <span style="font-weight: bold;font-size: 18px">Electro Trade</span><br>
                            6 rue d'Armaillé<br>75017 Paris<br>France<br><br>Tél.: 0755549247
                        </div>
                    </td>
                    <td style="background: #fff;border: unset;">
                        <div style="padding: 20px;background: #fff;margin: 0 20px;">
                            <span style="font-weight: bold;font-size: 18px">Colisrael</span><br>
                            Yeshuat David 12<br>Modiin Ilit 7180602<br>Israel<br><br>VAT Number 328871694
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <table>
            <thead>
                <tr>
                    <th>Marchand</th>
                    <th>Supplier Track Number</th>
                    <th>Dimensions</th>
                    <th>Weight</th>
                    <th>Volumetric weight 1:5000</th>
                    <!--<th>Unit Price</th>-->
                    <!--<th>Total Price</th>-->
                </tr>
            </thead>
            <tbody class="packing_body">

            </tbody>
        </table>
        <div style="margin-top: 50px">
            <div style="border: 1px solid;width: 40%;padding: 10px;">
                Total <span class="tot_box"></span> boxes
            </div>
        </div>
    </div>
</div>



<div class="pdf_container2" style="display:none">
    <div class="row pdf">
        <table style="margin-bottom: 20px;">
            <thead>
                <tr>
                    <th style="font-size: 30px;border:unset">Electro Trade</th>
                    <th style="font-size: 30px;border:unset;text-align: right;">Facture<br><span style="font-weight: normal !important;font-size: 20px !important">INV <span class="inv_number"></span> <span class="pdf_count"></span></span></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="border:unset;padding: 20px;padding-bottom: 10px;">Émetteur</td>
                    <td style="border:unset;padding: 20px;padding-bottom: 10px;">Adressé à</td>
                </tr>
                <tr>
                    <td style="background: #dddddd;">
                        <div style="padding: 20px;">
                            <span style="font-weight: bold;font-size: 18px">Electro Trade</span><br>
                            6 rue d'Armaillé<br>75017 Paris<br>France<br><br>Tél.: 0755549247
                        </div>
                    </td>
                    <td style="background: #fff;border: unset;">
                        <div style="padding: 20px;background: #fff;margin: 0 20px;">
                            <span style="font-weight: bold;font-size: 18px"><span class="name_pdf_print"></span></span><br>
                            <span class="street_print"></span><br><span class="city_print"></span><br><span class="country_print"></span><br><br><span class="vat_number_print"></span>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <table>
            <thead>
                <tr>
                    <th>Internal Ref.</th>
                    <th>Description</th>
                    <th>Product Name</th>
                    <th>Qty</th>
                    <th>Unit Price</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody class="pdf_body2">
                <!--<tr>-->
                <!--    <td>Product 1</td>-->
                <!--    <td>ABC</td>-->
                <!--    <td>1</td>-->
                <!--    <td>10</td>-->
                <!--</tr>-->
            </tbody>
        </table>
        <div style="margin-top: 50px">
            <p style="text-align: center;">The exporter of the products covered by this document declares that except where otherwise clearly indicated these products are of EU Preferential origin.</p>
            <p style="text-align: center;margin-bottom: 0">Capital de 100 € - SIREN: 891920084</p>
            <p style="text-align: center">Numéro TVA: FR35891920084 </p>
        </div>
    </div>
</div>
<div class="packing_container2" style="display:none">
    <div class="row packing">
        <table style="margin-bottom: 20px;">
            <thead>
                <tr>
                    <th style="font-size: 30px;border:unset">Packing list<br><span style="font-size: 20px !important">for INV-<span class="inv_number"></span></span></th>
                    <th style="font-size: 30px;border:unset;text-align: right;">
                        <!--Facture<br><span style="font-weight: normal !important;font-size: 15px !important">INV<?php echo date("ymd"); ?> - <span class="pdf_count"></span></span>-->
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="border:unset;padding: 20px;padding-bottom: 10px;">Émetteur</td>
                    <td style="border:unset;padding: 20px;padding-bottom: 10px;">Adressé à</td>
                </tr>
                <tr>
                    <td style="background: #dddddd;">
                        <div style="padding: 20px;">
                            <span style="font-weight: bold;font-size: 18px">Electro Trade</span><br>
                            6 rue d'Armaillé<br>75017 Paris<br>France<br><br>Tél.: 0755549247
                        </div>
                    </td>
                    <td style="background: #fff;border: unset;">
                        <div style="padding: 20px;background: #fff;margin: 0 20px;">
                            <span style="font-weight: bold;font-size: 18px"><span class="name_pdf_print"></span></span><br>
                            <span class="street_print"></span><br><span class="city_print"></span><br><span class="country_print"></span><br><br><span class="vat_number_print"></span>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <table>
            <thead>
                <tr>
                    <th>Marchand</th>
                    <th>Supplier Track Number</th>
                    <th>Dimensions</th>
                    <th>Weight</th>
                    <th>Volumetric weight 1:5000</th>
                    <!--<th>Unit Price</th>-->
                    <!--<th>Total Price</th>-->
                </tr>
            </thead>
            <tbody class="packing_body2">

            </tbody>
        </table>
        <div style="margin-top: 50px">
            <div style="border: 1px solid;width: 40%;padding: 10px;">
                Total <span class="tot_box"></span> boxes
            </div>
        </div>
    </div>
</div>

<div class="modal" id="myModal6" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal6">&times;</button>
                <h4 class="modal-title">Update parcel weight</h4>
            </div>
            <form class="product_information01">
                <div class="modal-body">
                    <div class="info_message"></div>

                    <input type="hidden" name="iddb" value="" id="iddbb">
                    <!--<div class="form-group">-->
                    <!--   <label for="hs_code">Internal Track Number :</label>-->
                    <!--   <input type="internal_serial_number" class="form-control" id="internal_serial_number" name="internal_serial_number" required="">-->
                    <!--   <span id="hsError"></span>-->
                    <!--</div>-->
                    <div class="row">
                        <div class="row">
                            <h6>SUPPLIER TRACKING NUMBER </h6>
                            <div class="col-md-6 col-sm-12 fcHaveIcon">
                                <input class="pwiFormInput form-control noBorder" type="text" name="supplier_tracking" id="supplier_tracking" placeholder="Supplier tracking number">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <h6>DÉTAILS D'EXPÉDITION </h6>
                                <div class="col-md-6 col-sm-12 fcHaveIcon" style="display: flex">
                                    <input class="pwiFormInput form-control noBorder" type="text" name="parcel_weight" id="product_weight" min="1" size="1" value="1" placeholder="Poids">
                                    <input class="pwiFormInput form-control noBorder" type="text" name="parcel_weight_type" id="product_weight_type" value="kg" placeholder="kg" style="pointer-events: none;border: unset;box-shadow: unset">
                                </div>
                                <!--<div class="col-md-4 col-sm-12 fcHaveIcon">-->
                                <!--<span class="fcIcon" style="top: 0px;float: right !important;margin-left: 35px;">-->

                                <!--</span>-->
                                <!--</div>-->
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="fcDimensions">
                                    <h6>Dimensions du colis L x I x h (en cm)</h6>
                                    <div style="display: flex">
                                        <input class="pwiFormInput form-control" type="number" name="order_length" id="parcel_length" min="1" size="1" value="1" placeholder="Length">
                                        <input class="pwiFormInput form-control" type="number" name="order_width" id="parcel_width" min="1" size="1" value="1" placeholder="Breadth">
                                        <input class="pwiFormInput form-control" type="number" name="order_height" id="parcel_height" min="1" size="1" value="1" placeholder="Height">
                                    </div>
                                    <h6 class="dimen-line">soit <span class="cal_wgt">20</span>kg calcul au volume</h6>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-default" id="serial_number_submit6">Soumettre</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal" id="myModal3" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal3">&times;</button>
                <h4 class="modal-title">Join Parcel</h4>
            </div>
            <div class="modal-body">
                <div class="info_message"></div>
                <form class="parcel_information">
                    <!--<input type="hidden" name="iddb" value="" id="iddb">-->
                    <div class="form-group">
                        <label for="hs_code">Parcel Number :</label>
                        <select class="form-control" name="parcel" id="parcel">
                            <?php
                            $res = Helper::dbQuery("SELECT * FROM customer_product_wishlist WHERE parcel_number IS NOT NULL GROUP BY parcel_number");
                            if (count($res) > 0) {
                                foreach ($res as $result) {
                                    $hs_limit = $result['limit_product'];
                                    $date1_ts = date('Y-m-d H:i:s');
                                    $date2_ts = $result['days'];
                                    $diff = strtotime($date1_ts) - strtotime($date2_ts);
                                    $no_of_days = round($diff / 86400);
                            ?>
                                    <option value="<?php echo $result['parcel_number']; ?>"><?php echo $result['parcel_number']; ?></option>
                            <?php
                                }
                            }
                            ?>
                        </select>
                        <span id="hsError"></span>
                    </div>
                    <button type="submit" class="btn btn-default" id="parcel_submit">Soumettre</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal3" id="closeid2">Fermer</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade naming_popup" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Address</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label>Name : </label>
                <input class="form-control" name="name" id="name_pdf">
                <label>Street : </label>
                <input class="form-control" name="street" id="street">
                <label>City With pincode : </label>
                <input class="form-control" name="city" id="city">
                <label>Country : </label>
                <input class="form-control" name="country" id="country">
                <label>VAT Number : </label>
                <input class="form-control" name="vat_number" id="vat_number">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close_btn" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary btn-personal-pdf-print">Save changes</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->

<div class="modal fade naming_popup" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Address</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label>Name : </label>
                <input class="form-control" name="name" id="name_pdf2">
                <label>Street : </label>
                <input class="form-control" name="street" id="street2">
                <label>City With pincode : </label>
                <input class="form-control" name="city" id="city2">
                <label>Country : </label>
                <input class="form-control" name="country" id="country2">
                <label>VAT Number : </label>
                <input class="form-control" name="vat_number" id="vat_number2">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close_btn" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary btn-personal-pdf-print2">Save changes</button>
            </div>
        </div>
    </div>
</div>

<div id="flipFlop" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    &times;</button>
                <h4 class="modal-title">
                    Greetings
                </h4>
            </div>
            <div class="modal-body">
                Welcome
            </div>
            <div class="modal-footer">
                <input type="button" id="btnClosePopup" value="Close" class="btn btn-danger" data-dismiss="modal" />
            </div>
        </div>
    </div>
</div>


<!-- AWB POPUP -->
<div class="modal" id="myModalawb" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modalawb">&times;</button>
                <h4 class="modal-title">AWB</h4>
            </div>
            <div class="modal-body">
                <div class="info_message"></div>
                <form class="parcel_information">
                    <!--<input type="hidden" name="iddb" value="" id="iddb">-->
                    <div class="form-group">
                        <label for="hs_code">Invoice Number :</label>
                        <select class="form-control" name="invoice" id="invoice">
                            <?php
                            $res = Helper::dbQuery("SELECT * FROM customer_product_wishlist WHERE parcel_number IS NOT NULL AND is_archived IS NULL AND parcel_archived = 0 GROUP BY invoice_number");
                            if (count($res) > 0) {
                                foreach ($res as $result) {
                                    if ($result['invoice_number']) {
                            ?>
                                        <option value="<?php echo $result['invoice_number']; ?>">INV-<?php echo $result['invoice_number']; ?></option>
                            <?php
                                    }
                                }
                            }
                            ?>
                        </select>
                        <span id="hsError"></span>
                    </div>
                    <div class="form-group">
                        <label for="hs_code">Awb Number :</label>
                        <input type="text" class="form-control" name="awb" id="awb">
                        <span id="hsError"></span>
                    </div>
                    <button type="submit" class="btn btn-default" id="awb_submit">Soumettre</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modalawb" id="closeidawb">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- UPDATE POPUP -->
<div class="modal" id="myModalupdate" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modalupdate">&times;</button>
                <h4 class="modal-title">Update Product</h4>
            </div>
            <div class="modal-body">
                <div class="info_message"></div>
                <form class="parcel_information update">
                    <div class="form-group">
                        <label for="hs_code">Title :</label>
                        <input type="hidden" name="id" id="update_id">
                        <input type="text" class="form-control" name="title" id="update_title">
                        <span id="hsError"></span>
                    </div>
                    <div class="form-group">
                        <label for="hs_code">HS Code :</label>
                        <input type="text" class="form-control" name="hs_code" id="update_hs_code">
                        <span id="hsError"></span>
                    </div>
                    <div class="form-group">
                        <label for="hs_code">Quantity :</label>
                        <input type="text" class="form-control" name="quantity" id="update_quantity">
                        <span id="hsError"></span>
                    </div>
                    <div class="form-group">
                        <label for="hs_code">Price :</label>
                        <input type="text" class="form-control" name="price" id="update_price">
                        <span id="hsError"></span>
                    </div>
                    <button type="submit" class="btn btn-default" id="update_submit">Soumettre</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modalupdate" id="closeidupdate">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- UPDATE POPUP -->
<div class="modal" id="myModalhs_code" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modalhs_code">&times;</button>
                <h4 class="modal-title">Update Product</h4>
            </div>
            <div class="modal-body">
                <div class="info_message"></div>
                <!--<form class="parcel_information">-->
                <div class="form-group">
                    <label for="hs_code">HS Code :</label>
                    <input type="text" class="form-control" name="hs_code" id="hs_code_all">
                    <span id="hsError"></span>
                </div>
                <button type="submit" class="btn btn-default" id="hs_code_submit">Soumettre</button>
                <!--</form>-->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modalhs_code" id="closeidhs_code">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        $('.open_delivery').click(function() {
            event.preventDefault();
            $('.delivery').hide();
            $('#' + $(this).data('id')).show()
        })
        $('.cst-btn').removeClass('active')
        $('.cst-btn2').addClass('active')
        $('button.cst-btn2').click()
        //$('.deleteMultiple').click()
    })
    $('a.arti').click(function() {
        // $(document).on('click', 'a.arti', function(){
        event.preventDefault();
        if ($(this).find('.deleteMultiple').is(':checked')) {
            $(this).find('.deleteMultiple').prop('checked', false)
        } else {
            $(this).find('.deleteMultiple').prop('checked', true)
        }
        if ($('.deleteMultiple:checkbox:checked').length > 0) {
            //   $('.btn-parcel').show();
            //   $('.btn-join-parcel').show()
            //   $('.btn-match').show()
            $('.btn-update_product').show()
            $('.btn-update_hs_code').show()
            $('.btn-arc').show();
        } else {
            $('.btn-parcel').hide();
            $('.btn-join-parcel').hide()
            // $('.btn-match').hide()
            $('.btn-update_product').hide()
            $('.btn-update_hs_code').hide()
            $('.btn-arc').hide();
        }
        if ($('.deleteMultiple:checkbox:checked').length > 1) {
            $('.btn-update_product').hide()
        }
    })
    $('.awb_pop').click(function() {
        $('#myModalawb').show()
    })
    // $('.btn-update_product').click(function(){
    $(document).on('click', '.btn-update_product', function() {
        $('#update_title').val($('.deleteMultiple:checked').attr('product_name'))
        $('#update_hs_code').val($('.deleteMultiple:checked').attr('hs_code'))
        $('#update_quantity').val($('.deleteMultiple:checked').attr('units'))
        $('#update_price').val($('.deleteMultiple:checked').attr('price'))
        $('#update_id').val($('.deleteMultiple:checked').val())
        $('#myModalupdate').show()
    })
    $(document).on('click', '.btn-update_hs_code', function() {
        $('#myModalhs_code').show()
    })
    $('#closeidawb, .close, #closeidupdate, #closeidhs_code').click(function() {
        $('#myModalawb').hide()
        $('#myModalupdate').hide()
        $('#myModalhs_code').hide()
    })
    setInterval(function() {
        if ($('.checks:checkbox:checked').length > 0) {
            $('.col_img').hide()
            $('.col_img_with_checks').show()
            $('.per_img').hide()
            $('.per_img_with_checks').show()
        }
    }, 100);
    $('.new_price_img').click(function() {
        var $this = $(this);
        $('.new_price_img').removeClass('active')
        $(this).addClass('active')
        $('.col-md-12.boxes tr').hide()
        $('.user_shipping').each(function(i) {
            // console.log()
            if ($('button.cst-btn.active').data('val') == '1') {
                if ($(this).data('ship') == $this.data('type') && $(this).parents('tr').find('.parcel_statuss').val() != '2') {
                    $(this).parents('tr').show()
                }
            } else if ($('button.cst-btn.active').data('val') == '2') {
                if ($(this).data('ship') == $this.data('type') && $(this).parents('tr').find('.parcel_statuss').val() == '2') {
                    $(this).parents('tr').show()
                }
            } else {
                if ($(this).data('ship') == $this.data('type')) {
                    $(this).parents('tr').show()
                }
            }

        })
        // $('.parcel_statuss').each(function(){
        //     if($(this).val() == $('button.cst-btn.active').data('val')){
        //         $(this).parents('tr').show()
        //     }
        // })
    })
    $('button.cst-btn2').click(function() {
        window.history.replaceState(null, null, "?open_all");
        $('.main').click()
    })
    $('button.cst-btn').click(function() {
        var $this = $(this);
        $('button.cst-btn').removeClass('active')
        $(this).addClass('active')
        $('.col-md-12.boxes tr').hide()
        $('.parcel_statuss').each(function() {
            if ($this.data('val')) {
                if ($('.new_price_img.active').data('type') == 'colisrael') {
                    if ($(this).val() == $this.data('val') && $(this).parents('tr').find('.user_shipping').data('ship') == 'colisrael') {
                        $(this).parents('tr').show()
                    }
                } else if ($('.new_price_img.active').data('type') == 'dhl') {
                    if ($(this).val() == $this.data('val') && $(this).parents('tr').find('.user_shipping').data('ship') == 'dhl') {
                        $(this).parents('tr').show()
                    }
                } else {
                    if ($this.data('val') == '1') {
                        if ($(this).val() != '2') {
                            $(this).parents('tr').show()
                        }
                    } else {
                        if ($(this).val() == $this.data('val')) {
                            $(this).parents('tr').show()
                        }
                    }
                }
                // if($this.data('val') == '1'){
                //     if($(this).val() != '2'){
                //         $(this).parents('tr').show()
                //     }
                // }else{
                //     if($(this).val() == $this.data('val')){
                //         $(this).parents('tr').show()
                //     }
                // }
            } else {
                $(this).parents('tr').show()
            }
        })
        // $('.user_shipping').each(function(){
        //     if($(this).data('ship') == $('.new_price_img.active').data('type')){
        //         $(this).parents('tr').show()
        //     }
        // })
    })
    // $('#hs_code_submit').click(function(){
    $(document).on('click', '#hs_code_submit', function(event) {
        // $('#hs_code_submit').triggerHandler('click');
        event.preventDefault();
        let idObject = [];
        let thisObject = [];
        $('.deleteMultiple:checkbox:checked').each(function() {
            idObject.push(this.value);
            thisObject.push(this);
        })
        console.log(idObject)
        update_hs_code(idObject)
    })

    function update_hs_code(id) {
        $.ajax({
            type: "POST",
            url: APP_URL + '/update_hs_code_all',
            data: {
                id_customer: id,
                hs_code: $('#hs_code_all').val()
            },
            success: function(data) {
                // location.reload();
                if (window.location.search != '') {
                    window.location.href = window.location.href + '&nocache';
                } else {
                    window.location.href = window.location.href + '?nocache';
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr);
            }
        });
    }
    $('.btn-parcel').click(function() {
        let idObject = [];
        let thisObject = [];
        $('.deleteMultiple:checkbox:checked').each(function() {
            idObject.push(this.value);
            thisObject.push(this);
        })
        var result = confirm("Want to create parcel?");
        if (result) {
            createparcelData(idObject, 'single', thisObject)
        }
    })

    function createparcelData(id, action, object) {
        $.ajax({
            type: "POST",
            url: APP_URL + '/create_parcel_backend',
            data: {
                id_customer: id,
                action: action
            },
            success: function(data) {
                // location.reload();
                if (window.location.search != '') {
                    window.location.href = window.location.href + '&nocache';
                } else {
                    window.location.href = window.location.href + '?nocache';
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr);
            }
        });
    }
    $('.move_to_archive').click(function() {
        var invoice = $(this).attr('data-invoice');
        var awb = $(this).attr('data-awb');
        $.ajax({
            type: "POST",
            url: APP_URL + "/move_awb_to_unarchive",
            data: {
                awb: awb,
                invoice: invoice
            },
            methos: "POST",
            dataType: 'html',
            success: function(data) {
                // location.reload();
                if (window.location.search != '') {
                    window.location.href = window.location.href + '&nocache';
                } else {
                    window.location.href = window.location.href + '?nocache';
                }
                // return false;
            },
        });
    })
    $('.pro_stat').change(function(e) {
        var vl = $(this).val();
        var invoice = $(this).attr('data-invoice');
        var awb = $(this).attr('data-awb');
        var customer = $(this).attr('data-customer_id');
        $.ajax({
            type: "POST",
            url: APP_URL + "/update_product_status",
            data: {
                status: vl,
                invoice: invoice,
                awb: awb,
                customer: customer
            },
            methos: "POST",
            dataType: 'html',
            success: function(data) {
                // location.reload();
                if (window.location.search != '') {
                    window.location.href = window.location.href + '&nocache';
                } else {
                    window.location.href = window.location.href + '?nocache';
                }
                // return false;
            },
        });
    })
    $('.pro_statt').change(function(e) {
        var vl = $(this).val();
        var invoice = $(this).attr('data-invoice');
        var awb = $(this).attr('data-awb');
        var customer = $(this).attr('data-customer_id');
        var supplier_track_number = $(this).attr('data-supplier_track_number');
        $.ajax({
            type: "POST",
            url: APP_URL + "/update_product_status2",
            data: {
                status: vl,
                invoice: invoice,
                awb: awb,
                customer: customer,
                supplier_track_number: supplier_track_number
            },
            methos: "POST",
            dataType: 'html',
            success: function(data) {
                // location.reload();
                if (window.location.search != '') {
                    window.location.href = window.location.href + '&nocache';
                } else {
                    window.location.href = window.location.href + '?nocache';
                }
                // return false;
            },
        });
    })
    $('#parcel_submit').click(function(e) {
        e.preventDefault();
        let idObject = [];
        $('.deleteMultiple:checkbox:checked').each(function() {
            idObject.push(this.value);
        })
        $.ajax({
            type: "POST",
            url: APP_URL + "/join_parcel",
            data: {
                id: idObject,
                form_data: $('#parcel').val()
            },
            methos: "POST",
            dataType: 'html',
            success: function(data) {
                // location.reload();
                if (window.location.search != '') {
                    window.location.href = window.location.href + '&nocache';
                } else {
                    window.location.href = window.location.href + '?nocache';
                }
                return false;
            },
        });
    })
    $('#awb_submit').click(function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: APP_URL + "/add_awb_number",
            data: {
                awb_number: $('[name="awb"]').val(),
                invoice_number: $('[name="invoice"]').val()
            },
            methos: "POST",
            dataType: 'html',
            success: function(data) {
                // location.reload();
                if (window.location.search != '') {
                    window.location.href = window.location.href + '&nocache';
                } else {
                    window.location.href = window.location.href + '?nocache';
                }
                return false;
            },
        });
    })
    $('#update_submit').click(function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: APP_URL + "/update_new",
            data: $('.parcel_information.update').serialize(),
            methos: "POST",
            dataType: 'html',
            success: function(data) {
                // location.reload();
                if (window.location.search != '') {
                    window.location.href = window.location.href + '&nocache';
                } else {
                    window.location.href = window.location.href + '?nocache';
                }
                return false;
            },
        });
    })
    $(document).on('click', '.btn-join-parcel', function() {
        var modal = document.getElementById("myModal3");
        modal.style.display = "block";
    })
    $(document).on("click", ".close, #closeid2", function(e) {
        e.preventDefault();
        var modal = document.getElementById("myModal3");
        modal.style.display = "none";
    });
    $('.deleteMultiple').click(function(event) {
        if ($('.deleteMultiple:checkbox:checked').length > 0) {
            //   $('.btn-parcel').show();
            //   $('.btn-join-parcel').show()
            //   $('.btn-match').show()
            $('.btn-update_product').show()
            $('.btn-update_hs_code').show()
            $('.btn-arc').show();
        } else {
            $('.btn-parcel').hide();
            $('.btn-join-parcel').hide()
            // $('.btn-match').hide()
            $('.btn-update_product').hide()
            $('.btn-update_hs_code').hide()
            $('.btn-arc').hide();
        }
        if ($('.deleteMultiple:checkbox:checked').length > 1) {
            $('.btn-update_product').hide()
        }
    });
    $('.checks').click(function() {
        if ($('.checks:checkbox:checked').length == 1) {
            $('.btn-match').show()
        } else {
            $('.btn-match').hide()
        }
    })

    $('.btn-match').click(function() {
        //   let idObject = [];
        //   let thisObject = [];
        var ids = $('.checks:checkbox:checked').parent().next().find('.parent_ids').attr('data-pro-ids');
        var result = confirm("Want to move into Matching?");
        if (result) {
            moveToMatch(ids, 'single')
        }
    })
    $('.btn-arc').click(function() {
        let idObject = [];
        let thisObject = [];
        $('.deleteMultiple:checkbox:checked').each(function() {
            idObject.push(this.value);
            thisObject.push(this);
        })
        var result = confirm("Want to archive product?");
        if (result) {
            archiveProductData(idObject, 'single', thisObject)
        }
    })
    $('img.set_archive').click(function() {
        var number = $(this).data('parcel')
        $.ajax({
            type: "POST",
            url: APP_URL + '/update_archive_status',
            data: {
                parcel_number: number
            },
            success: function(data) {
                // location.reload();
                if (window.location.search != '') {
                    window.location.href = window.location.href + '&nocache';
                } else {
                    window.location.href = window.location.href + '?nocache';
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr);
            }
        });
    })

    function archiveProductData(id, action) {
        $.ajax({
            type: "POST",
            url: APP_URL + '/update_archive_status',
            data: {
                id_customer: id,
                action: action
            },
            success: function(data) {
                // location.reload();
                if (window.location.search != '') {
                    window.location.href = window.location.href + '&nocache';
                } else {
                    window.location.href = window.location.href + '?nocache';
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr);
            }
        });
    }

    function moveToMatch(id, action, object) {
        $.ajax({
            type: "POST",
            url: APP_URL + '/move_to_matching_all',
            data: {
                id_customer: id,
                action: action
            },
            success: function(data) {
                // location.reload();
                if (window.location.search != '') {
                    window.location.href = window.location.href + '&nocache';
                } else {
                    window.location.href = window.location.href + '?nocache';
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr);
            }
        });
    }
    $(document).on("change", "#parc_status", function() {
        var id = $(this).data("value");
        var status = $(this).val();
        var cst = $(this).data('customer');
        var parcel_no = $(this).data('parcel_no');
        var titles = $(this).data('titles');
        var weight = $(this).data('weight');
        var volume = $(this).data('volume');
        var shipping = $(this).data('shipping');
        update_status(id, status, cst, parcel_no, titles, weight, volume, shipping)
    });

    function update_status(id, status, cst, parcel_no, titles, weight, volume, shipping) {
        // console.log(id)
        // console.log(status)
        $.ajax({
            type: "POST",
            url: APP_URL + '/update_parcel_status_backend',
            data: {
                id: id,
                status: status,
                customer: cst,
                parcel_number: parcel_no,
                titles: titles,
                shipping: shipping,
                weight: weight,
                volume: volume,
                type: 'email_also'
            },
            success: function(data) {
                // alert('Status updated Successfully');
                // location.reload();
                if (window.location.search != '') {
                    window.location.href = window.location.href + '&nocache';
                } else {
                    window.location.href = window.location.href + '?nocache';
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr);
            }
        });
    }
    $('.main').click(function() {
        $(this).parent().next().toggleClass('hiddendiv')
    })
    $(document).ready(function() {
        // setInterval(function () {
        //     // $("#parcel_length, #parcel_width, #parcel_height").on("change keyup paste", function(){
        //     var cal_val = parseFloat($('#parcel_length').val()) * parseFloat($('#parcel_width').val()) * parseFloat($('#parcel_height').val()) / 5000;
        //     // console.log(cal_val)
        //     $('.cal_wgt').html(Math.round(cal_val))
        // // })
        // }, 100);
    })
    $(document).on("click", "#serial_number_submit6", function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: APP_URL + "/update_parcel_weight",
            data: $('.product_information01').serialize(),
            methos: "POST",
            dataType: 'html',
            success: function(data) {
                // location.reload();
                if (window.location.search != '') {
                    window.location.href = window.location.href + '&nocache';
                } else {
                    window.location.href = window.location.href + '?nocache';
                }
                // window.location.href = window.location.origin+window.location.pathname+'?tab='+$('ul.nav.nav-tabs li.active').data('tab')
                return false;
            },
        });
    });
    $(document).on("click", ".close, #closeid6", function(e) {
        e.preventDefault();
        var modal = document.getElementById("myModal6");
        modal.style.display = "none";
    });
    $(document).on("click", "#openModal6", function(e) {
        e.preventDefault();
        var modal = document.getElementById("myModal6");
        // var modal = document.getElementById("myModal2");
        modal.style.display = "block";

        $("#iddbb").val($(this).attr('value'));
        $("[name='parcel_weight']").val($(this).attr('weight'));
        $("#parcel_length").val($(this).attr('l'));
        $("#parcel_width").val($(this).attr('b'));
        $("#parcel_height").val($(this).attr('h'));
        $('#supplier_tracking').val($(this).data('supp_tracking'))
        // $("#iddb").val($(this).attr('value'));
    })
    setInterval(function() {
        // $("#parcel_length, #parcel_width, #parcel_height").on("change keyup paste", function(){
        var cal_val = parseFloat($('#parcel_length').val()) * parseFloat($('#parcel_width').val()) * parseFloat($('#parcel_height').val()) / 5000;
        // console.log(cal_val)
        if ($('#product_weight').val() > cal_val) {
            cal_val = $('#product_weight').val()
        } else {
            cal_val = cal_val;
        }
        $('.cal_wgt').html(Math.round(cal_val))
        // })
    }, 100);
    $(document).on("change", "#send_parcel", function() {
        var id = $(this).data("value");
        var status = $(this).val();
        change_parcel_status(id, status)
    });

    function change_parcel_status(id, status) {
        // console.log(id)
        // console.log(status)
        $.ajax({
            type: "POST",
            url: APP_URL + '/change_parcel_type',
            data: {
                id: id,
                status: status
            },
            success: function(data) {
                // alert('Status updated Successfully');
                // location.reload();
            },
            error: function(xhr, status, error) {
                console.error(xhr);
            }
        });
    }
    $('.checks').click(function() {
        if ($('.checks:checkbox:checked').length > 0) {
            $('.btn-pdf').show();
        } else {
            $('.btn-pdf').hide();
        }
    })
    $('.checks_personal').click(function() {
        if ($('.checks_personal:checkbox:checked').length > 0) {
            $('.btn-pdf_personal').show();
        } else {
            $('.btn-pdf_personal').hide();
        }
    })

    function getCookie(cName) {
        console.log('get')
        const name = cName + "=";
        const cDecoded = decodeURIComponent(document.cookie); //to be careful
        const cArr = cDecoded.split('; ');
        let res;
        cArr.forEach(val => {
            if (val.indexOf(name) === 0) res = val.substring(name.length);
        })
        return res;
    }
    // Set a Cookie
    function setCookie(cName, cValue, expDays) {
        console.log('set')
        let date = new Date();
        date.setTime(date.getTime() + (expDays * 24 * 60 * 60 * 1000));
        const expires = "expires=" + date.toUTCString();
        document.cookie = cName + "=" + cValue + "; " + expires + "; path=/";
    }

    function updateStatus(id) {
        $.ajax({
            type: "POST",
            url: APP_URL + '/update_invoice_status',
            data: {
                id: id
            },
            success: function(data) {
                // alert('Data Deleted Successfully');
                // location.reload();
            },
            error: function(xhr, status, error) {
                console.error(xhr);
            }
        });
    }

    function updateInv(id, inv) {
        $.ajax({
            type: "POST",
            url: APP_URL + '/update_invoice_number',
            data: {
                id: id,
                inv: inv
            },
            success: function(data) {
                // alert('Data Deleted Successfully');
                // location.reload();
            },
            error: function(xhr, status, error) {
                console.error(xhr);
            }
        });
    }

    $('.col_img').click(function() {
        var pdf_prints = '';
        var prints = getCookie('pdf_prints');
        var tdate = new Date();
        var dd = tdate.getDate(); //yields day
        var MM = tdate.getMonth(); //yields month
        var yyyy = tdate.getFullYear().toString().substr(-2); //yields year
        if (dd.toString().length == 1) {
            var dd = '0' + dd;
        }
        if (MM.toString().length == 1) {
            var MM = '0' + (MM + 1);
        } else {
            var MM = (MM + 1);
        }
        var currentDate = yyyy + '' + (MM) + '' + dd;



        console.log(prints)
        if (prints != undefined) {
            let pdf_prints = parseInt(prints) + 1;
            // Apply setCookie
            setCookie('pdf_prints', pdf_prints, 1);
            $('.pdf_count').html(pdf_prints);
            $('.inv_number').html(currentDate + '-' + pdf_prints)
            var currentDate = currentDate + '-' + pdf_prints;
        } else {
            let pdf_prints = 1;
            $('.pdf_count').html('1');
            $('.inv_number').html(currentDate + '- 1')
            var currentDate = currentDate + '- 1';
            // Apply setCookie
            setCookie('pdf_prints', pdf_prints, 1);
        }




        $('.pdf_body').html('');
        var tot_pri = 0;
        $('.send_parcell').each(function() {
            if ($(this).parents('tr').is(':visible')) {
                if ($(this).val() == '1') {
                    var ids = $(this).attr('data-value');
                    console.log(ids)
                    updateInv(ids, currentDate);
                    $(this).closest('tr').next().find('td span').each(function() {
                        tot_pri += $(this).data('qty') * $(this).data('price');
                        console.log(tot_pri)
                        $('.pdf_body').append('<tr><td>' + $(this).data('internal_tracking') + '</td><td style="font-size: 11px;">' + $(this).data('hs') + '</td><td style="font-size: 11px;width: 400px">' + $(this).data('name') + '</td><td class="fl-right">' + $(this).data('qty') + '</td><td class="fl-right">' + $(this).data('price').toFixed(2) + '</td><td>' + ($(this).data('qty') * $(this).data('price')).toFixed(2) + '</td></tr>')

                    })
                    $(this).closest('tr').next().next().find('td span').each(function() {
                        tot_pri += $(this).data('qty') * $(this).data('price');
                        console.log(tot_pri)
                        $('.packing_body').append('<tr><td>' + $(this).data('source') + '</td><td>' + $(this).data('supp_tracking') + '</td><td>' + $(this).data('l') + 'x' + $(this).data('b') + 'x' + $(this).data('h') + 'cm</td><td>' + $(this).data('weight') + 'kg</td><td class="fl-right">' + ($(this).data('l') * $(this).data('b') * $(this).data('h') / 5000).toFixed(2) + 'kg</tr>')
                    })

                }
            }
        })
        $('.pdf_body').append('<tr><th>Total Price</th><th></th><th></th><th></th><th></th><th>' + tot_pri.toFixed(2) + '</th></tr>')
        $('.container.main_head').hide()
        $('.pdf_container').show()
        window.print();
        $('.pdf_container').hide();
        $('.packing_container').show()
        $('.tot_box').html($('.checks:checkbox:checked').length);
        window.print();
        $('.container.main_head').show()

        //location.reload()
        if (window.location.search != '') {
            window.location.href = window.location.href + '&nocache';
        } else {
            window.location.href = window.location.href + '?nocache';
        }
        // window.location.href = window.location.origin+window.location.pathname+'?tab='+$('ul.nav.nav-tabs li.active').data('tab')
    })
    $('.btn-personal-pdf-print2').click(function() {
        $('.name_pdf_print').html($('#name_pdf2').val())
        $('.street_print').html($('#street2').val())
        $('.city_print').html($('#city2').val())
        $('.country_print').html($('#country2').val())
        $('.vat_number_print').html($('#vat_number2').val())
        $('.close_btn').click()
        var pdf_prints = '';
        var prints = getCookie('pdf_prints');
        console.log(prints)
        var tdate = new Date();
        var dd = tdate.getDate(); //yields day
        var MM = tdate.getMonth(); //yields month
        var yyyy = tdate.getFullYear().toString().substr(-2); //yields year
        if (dd.toString().length == 1) {
            var dd = '0' + dd;
        }
        if (MM.toString().length == 1) {
            var MM = '0' + (MM + 1);
        } else {
            var MM = (MM + 1);
        }
        var currentDate = yyyy + '' + (MM) + '' + dd;
        //   $('.inv_number').html(currentDate)

        if (prints != undefined) {
            let pdf_prints = parseInt(prints) + 1;
            // Apply setCookie
            setCookie('pdf_prints', pdf_prints, 1);
            $('.pdf_count').html(pdf_prints);
            $('.inv_number').html(currentDate + '-' + pdf_prints)
            var currentDate = currentDate + '-' + pdf_prints;
        } else {
            let pdf_prints = 1;
            $('.pdf_count').html('1');
            $('.inv_number').html(currentDate + '- 1')
            var currentDate = currentDate + '- 1';
            // Apply setCookie
            setCookie('pdf_prints', pdf_prints, 1);
        }




        $('.pdf_body2').html('');
        var tot_pri = 0;
        $('.send_parcell').each(function() {
            if ($(this).parents('tr').is(':visible')) {
                if ($(this).val() == '2') {
                    var ids = $(this).parents('tr').find('.send_parcell').attr('data-value');
                    console.log(ids)
                    //   updateStatus(ids);
                    updateInv(ids, currentDate);
                    $(this).closest('tr').next().find('td span').each(function() {
                        tot_pri += $(this).data('qty') * $(this).data('price');
                        console.log(tot_pri)
                        $('.pdf_body2').append('<tr><td>' + $(this).data('internal_tracking') + '</td><td style="font-size: 11px;">' + $(this).data('hs') + '</td><td style="font-size: 11px;width: 400px">' + $(this).data('name') + '</td><td class="fl-right">' + $(this).data('qty') + '</td><td class="fl-right">' + $(this).data('price').toFixed(2) + '</td><td>' + ($(this).data('qty') * $(this).data('price')).toFixed(2) + '</td></tr>')
                        // $('.packing_body2').append('<tr><td>'+$(this).data('supp_tracking')+'</td><td>'+$(this).data('l')+'x'+$(this).data('b')+'x'+$(this).data('h')+'cm</td><td>'+$(this).data('weight')+'kg</td><td class="fl-right">'+($(this).data('l') * $(this).data('b') * $(this).data('h') / 5000).toFixed(2)+'kg</tr>')
                    })
                    $(this).closest('tr').next().next().find('td span').each(function() {
                        tot_pri += $(this).data('qty') * $(this).data('price');
                        console.log(tot_pri)
                        $('.packing_body2').append('<tr><td>' + $(this).data('source') + '</td><td>' + $(this).data('supp_tracking') + '</td><td>' + $(this).data('l') + 'x' + $(this).data('b') + 'x' + $(this).data('h') + 'cm</td><td>' + $(this).data('weight') + 'kg</td><td class="fl-right">' + ($(this).data('l') * $(this).data('b') * $(this).data('h') / 5000).toFixed(2) + 'kg</tr>')
                    })

                }
            }
        })
        $('.pdf_body2').append('<tr><th>Total Price</th><th></th><th></th><th></th><th></th><th>' + tot_pri.toFixed(2) + '</th></tr>')
        $('.container.main_head').hide()
        $('.pdf_container2').show()
        window.print();
        $('.pdf_container2').hide();
        $('.packing_container2').show()
        $('.tot_box').html($('.checks:checkbox:checked').length);
        window.print();
        $('.container.main_head').show()

        //location.reload()
        if (window.location.search != '') {
            window.location.href = window.location.href + '&nocache';
        } else {
            window.location.href = window.location.href + '?nocache';
        }
        // window.location.href = window.location.origin+window.location.pathname+'?tab='+$('ul.nav.nav-tabs li.active').data('tab')
    })
    $('.btn-pdf_personal').click(function() {
        var pdf_prints = '';
        var prints = getCookie('pdf_prints');
        console.log(prints)
        if (prints != undefined) {
            let pdf_prints = parseInt(prints) + 1;
            // Apply setCookie
            setCookie('pdf_prints', pdf_prints, 1);
            $('.pdf_count').html(pdf_prints);
        } else {
            let pdf_prints = 1;
            $('.pdf_count').html('1');
            // Apply setCookie
            setCookie('pdf_prints', pdf_prints, 1);
        }



        $('.pdf_body').html('');
        var tot_pri = 0;
        $('.checks_personal').each(function() {
            if ($(this).is(':checked')) {
                var ids = $(this).next().attr('value');
                console.log(ids)
                //   updateStatus(ids);
                $(this).closest('tr').next().find('td span').each(function() {
                    tot_pri += $(this).data('qty') * $(this).data('price');
                    $('.pdf_body').append('<tr><td>' + $(this).data('internal_tracking') + '</td><td style="font-size: 11px;">' + $(this).data('hs') + '</td><td style="font-size: 11px;width: 400px">' + $(this).data('name') + '</td><td class="fl-right">' + $(this).data('qty') + '</td><td class="fl-right">' + $(this).data('price').toFixed(2) + '</td><td>' + ($(this).data('qty') * $(this).data('price')).toFixed(2) + '</td></tr>')
                    // $('.packing_body').append('<tr><td>'+$(this).data('supp_tracking')+'</td><td>'+$(this).data('l')+'x'+$(this).data('b')+'x'+$(this).data('h')+'cm</td><td>'+$(this).data('weight')+'kg</td><td class="fl-right">'+($(this).data('l') * $(this).data('b') * $(this).data('h') / 5000).toFixed(2)+'kg</tr>')
                })
                $(this).closest('tr').next().next().find('td span').each(function() {
                    tot_pri += $(this).data('qty') * $(this).data('price');
                    console.log(tot_pri)
                    $('.packing_body').append('<tr><td>' + $(this).data('source') + '</td><td>' + $(this).data('supp_tracking') + '</td><td>' + $(this).data('l') + 'x' + $(this).data('b') + 'x' + $(this).data('h') + 'cm</td><td>' + $(this).data('weight') + 'kg</td><td class="fl-right">' + ($(this).data('l') * $(this).data('b') * $(this).data('h') / 5000).toFixed(2) + 'kg</tr>')
                })

            }
        })
        $('.pdf_body').append('<tr><th>Total Price</th><th></th><th></th><th></th><th></th><th>' + tot_pri.toFixed(2) + '</th></tr>')
        $('.container.main_head').hide()
        $('.pdf_container').show()
        window.print();
        $('.pdf_container').hide();
        $('.packing_container').show()
        $('.tot_box').html($('.checks_personal:checkbox:checked').length);
        window.print();
        $('.container.main_head').show()

        // location.reload()
        if (window.location.search != '') {
            window.location.href = window.location.href + '&nocache';
        } else {
            window.location.href = window.location.href + '?nocache';
        }
        // window.location.href = window.location.origin+window.location.pathname+'?tab='+$('ul.nav.nav-tabs li.active').data('tab')
    })

    $('img.per_img_with_checks').click(function() {
        $('#exampleModal').show()
        $('#exampleModal').css('opacity', '1')
    })
    $('img.per_img').click(function() {
        $('#exampleModal2').show()
        $('#exampleModal2').css('opacity', '1')
    })
    $('.col_img_with_checks').click(function() {
        var pdf_prints = '';
        var prints = getCookie('pdf_prints');
        console.log(prints)
        var tdate = new Date();
        var dd = tdate.getDate(); //yields day
        var MM = tdate.getMonth(); //yields month
        var yyyy = tdate.getFullYear().toString().substr(-2); //yields year
        if (dd.toString().length == 1) {
            var dd = '0' + dd;
        }
        if (MM.toString().length == 1) {
            var MM = '0' + (MM + 1);
        } else {
            var MM = (MM + 1);
        }
        var currentDate = yyyy + '' + (MM) + '' + dd;

        //   $('.inv_number').html(currentDate)
        if (prints != undefined) {
            let pdf_prints = parseInt(prints) + 1;
            // Apply setCookie
            setCookie('pdf_prints', pdf_prints, 1);
            $('.pdf_count').html(pdf_prints);
            $('.inv_number').html(currentDate + '-' + pdf_prints)
            var currentDate = currentDate + '-' + pdf_prints;
        } else {
            let pdf_prints = 1;
            $('.pdf_count').html('1');
            $('.inv_number').html(currentDate + '- 1')
            var currentDate = currentDate + '- 1';
            // Apply setCookie
            setCookie('pdf_prints', pdf_prints, 1);
        }




        $('.pdf_body').html('');
        var tot_pri = 0;
        $('.checks').each(function() {
            if ($(this).is(':checked')) {
                var ids = $(this).parents('tr').find('.send_parcell').attr('data-value');
                console.log(ids)
                //   updateStatus(ids);

                updateInv(ids, currentDate);
                $(this).closest('tr').next().find('td span').each(function() {
                    tot_pri += $(this).data('qty') * $(this).data('price');
                    $('.pdf_body').append('<tr><td>' + $(this).data('internal_tracking') + '</td><td style="font-size: 11px;">' + $(this).data('hs') + '</td><td style="font-size: 11px;width: 400px">' + $(this).data('name') + '</td><td class="fl-right">' + $(this).data('qty') + '</td><td class="fl-right">' + $(this).data('price').toFixed(2) + '</td><td>' + ($(this).data('qty') * $(this).data('price')).toFixed(2) + '</td></tr>')
                    // $('.packing_body').append('<tr><td>'+$(this).data('supp_tracking')+'</td><td>'+$(this).data('l')+'x'+$(this).data('b')+'x'+$(this).data('h')+'cm</td><td>'+$(this).data('weight')+'kg</td><td class="fl-right">'+($(this).data('l') * $(this).data('b') * $(this).data('h') / 5000).toFixed(2)+'kg</tr>')
                })
                $(this).closest('tr').next().next().find('td span').each(function() {
                    tot_pri += $(this).data('qty') * $(this).data('price');
                    console.log(tot_pri)
                    $('.packing_body').append('<tr><td>' + $(this).data('source') + '</td><td>' + $(this).data('supp_tracking') + '</td><td>' + $(this).data('l') + 'x' + $(this).data('b') + 'x' + $(this).data('h') + 'cm</td><td>' + $(this).data('weight') + 'kg</td><td class="fl-right">' + ($(this).data('l') * $(this).data('b') * $(this).data('h') / 5000).toFixed(2) + 'kg</tr>')
                })

            }
        })
        $('.pdf_body').append('<tr><th>Total Price</th><th></th><th></th><th></th><th></th><th>' + tot_pri.toFixed(2) + '</th></tr>')
        $('.container.main_head').hide()
        $('.pdf_container').show()
        window.print();
        $('.pdf_container').hide();
        $('.packing_container').show()
        $('.tot_box').html($('.checks:checkbox:checked').length);
        window.print();
        $('.container.main_head').show()

        // location.reload()
        if (window.location.search != '') {
            window.location.href = window.location.href + '&nocache';
        } else {
            window.location.href = window.location.href + '?nocache';
        }
        // window.location.href = window.location.origin+window.location.pathname+'?tab='+$('ul.nav.nav-tabs li.active').data('tab')
    })
    $('.close_btn, .close').click(function() {
        $('#exampleModal').hide()
        $('#exampleModal2').hide()
    })
    $('.btn-personal-pdf-print').click(function() {
        $('.name_pdf_print').html($('#name_pdf').val())
        $('.street_print').html($('#street').val())
        $('.city_print').html($('#city').val())
        $('.country_print').html($('#country').val())
        $('.vat_number_print').html($('#vat_number').val())
        $('.close_btn').click()
        var pdf_prints = '';
        var prints = getCookie('pdf_prints');
        console.log(prints)
        var tdate = new Date();
        var dd = tdate.getDate(); //yields day
        var MM = tdate.getMonth(); //yields month
        var yyyy = tdate.getFullYear().toString().substr(-2); //yields year
        if (dd.toString().length == 1) {
            var dd = '0' + dd;
        }
        if (MM.toString().length == 1) {
            var MM = '0' + (MM + 1);
        } else {
            var MM = (MM + 1);
        }
        var currentDate = yyyy + '' + (MM) + '' + dd;
        // console.log(currentDate)
        //   $('.inv_number').html(currentDate)

        if (prints != undefined) {
            let pdf_prints = parseInt(prints) + 1;
            // Apply setCookie
            setCookie('pdf_prints', pdf_prints, 1);
            $('.pdf_count').html(pdf_prints);
            $('.inv_number').html(currentDate + '-' + pdf_prints)
            var currentDate = currentDate + '-' + pdf_prints;
        } else {
            let pdf_prints = 1;
            $('.pdf_count').html('1');
            $('.inv_number').html(currentDate + '- 1')
            var currentDate = currentDate + '- 1';
            // Apply setCookie
            setCookie('pdf_prints', pdf_prints, 1);
        }




        $('.pdf_body2').html('');
        var tot_pri = 0;
        $('.checks').each(function() {
            if ($(this).is(':checked')) {
                var ids = $(this).parents('tr').find('.send_parcell').attr('data-value');
                console.log(ids)
                //   updateStatus(ids);
                updateInv(ids, currentDate);
                $(this).closest('tr').next().find('td span').each(function() {
                    tot_pri += $(this).data('qty') * $(this).data('price');
                    $('.pdf_body2').append('<tr><td>' + $(this).data('internal_tracking') + '</td><td style="font-size: 11px;">' + $(this).data('hs') + '</td><td style="font-size: 11px;width: 400px">' + $(this).data('name') + '</td><td class="fl-right">' + $(this).data('qty') + '</td><td class="fl-right">' + $(this).data('price').toFixed(2) + '</td><td>' + ($(this).data('qty') * $(this).data('price')).toFixed(2) + '</td></tr>')
                    // $('.packing_body2').append('<tr><td>'+$(this).data('supp_tracking')+'</td><td>'+$(this).data('l')+'x'+$(this).data('b')+'x'+$(this).data('h')+'cm</td><td>'+$(this).data('weight')+'kg</td><td class="fl-right">'+($(this).data('l') * $(this).data('b') * $(this).data('h') / 5000).toFixed(2)+'kg</tr>')
                })
                $(this).closest('tr').next().next().find('td span').each(function() {
                    tot_pri += $(this).data('qty') * $(this).data('price');
                    console.log(tot_pri)
                    $('.packing_body2').append('<tr><td>' + $(this).data('source') + '</td><td>' + $(this).data('supp_tracking') + '</td><td>' + $(this).data('l') + 'x' + $(this).data('b') + 'x' + $(this).data('h') + 'cm</td><td>' + $(this).data('weight') + 'kg</td><td class="fl-right">' + ($(this).data('l') * $(this).data('b') * $(this).data('h') / 5000).toFixed(2) + 'kg</tr>')
                })

            }
        })
        $('.pdf_body2').append('<tr><th>Total Price</th><th></th><th></th><th></th><th></th><th>' + tot_pri.toFixed(2) + '</th></tr>')
        $('.container.main_head').hide()
        $('.pdf_container2').show()
        // $('#exampleModal').hide()
        window.print();
        $('.pdf_container2').hide();
        $('.packing_container2').show()
        $('.tot_box').html($('.checks:checkbox:checked').length);
        window.print();
        $('.container.main_head').show()

        // location.reload()
        if (window.location.search != '') {
            window.location.href = window.location.href + '&nocache';
        } else {
            window.location.href = window.location.href + '?nocache';
        }
        // window.location.href = window.location.origin+window.location.pathname+'?tab='+$('ul.nav.nav-tabs li.active').data('tab')
    })
    $(document).ready(function() {

        $(function() {
            $("a[class='arti']").dblclick(function() {
                $("#flipFlop").modal("show");

            });
        });
    })
</script>

@endsection
