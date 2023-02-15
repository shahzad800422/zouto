@extends('layouts.app')
@section('content')
<style>
    /* shipment new with user... */

    td,
    th {
        border: 1px solid #dddddd;
    }

    .row {
        margin: 0;
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
    .btn-arc {
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

    table {
        width: 99%;
    }

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
        opacity: 0.5;
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

    @media (min-width: 1200px) {
        .container {
            width: 1450px;
        }
    }

    /* End shipment new with user... */
</style>
<div class="container main_head">
    <div class="row box_par">
        <div>

            <div class="col-md-11">
                <div class="after_boxes_images" style="width: 250px;margin: auto;padding: 15px 0;" data-colisrael_price="0" data-dhl_price="0" data-piano_price="0">
                    <img class="new_price_img" data-type="colisrael" src="https://cdn.shopify.com/s/files/1/0515/4927/4282/files/Screenshotturtle.png?v=1647864323">
                    <img class="new_price_img" data-type="dhl" src="https://cdn.shopify.com/s/files/1/0515/4927/4282/files/camel.png?v=1647864167">
                    <img class="new_price_img" data-type="piano" src="https://cdn.shopify.com/s/files/1/0515/4927/4282/files/leapord.png?v=1647864179">
                </div>
                <div style="width: 520px;margin: auto;padding: 15px 0;padding-top: 0;display: flex;justify-content: space-between;">
                    <img class="col_img" src="https://cdn.shopify.com/s/files/1/0515/4927/4282/files/logo.jpg?v=1649404887" style="width: 250px;cursor: pointer">
                    <img class="col_img_with_checks" src="https://cdn.shopify.com/s/files/1/0515/4927/4282/files/logo.jpg?v=1649404887" style="width: 250px;cursor: pointer;display: none">
                    <img class="per_img" data-toggle="modal" data-target="#exampleModal" src="https://cdn.shopify.com/s/files/1/0515/4927/4282/files/Pasted_File_at_April_8_2022_12_29_PM.png?v=1649410643" style="width: 250px;cursor: pointer">
                    <img class="per_img_with_checks" data-toggle="modal" data-target="#exampleModal" src="https://cdn.shopify.com/s/files/1/0515/4927/4282/files/Pasted_File_at_April_8_2022_12_29_PM.png?v=1649410643" style="width: 250px;cursor: pointer;display: none">
                </div>
                <button type="button" class="btn btn-parcel" name="button">Create Parcel</button>
                <button type="button" class="btn btn-join-parcel" name="button">Join Parcel</button>
                <!--<button type="button" class="btn btn-arc" name="button">Archive</button>-->
                <!--<button type="button" class="btn btn-pdf" name="button" style="display: none">Generate PDF</button>-->
                <div class="col-md-12 boxes" style="margin: unset">

                    <table id="example14" class="display" style="width:100%">
                        <thead>
                        </thead>
                        <tbody>
                            <?php
                            $domain_url = env('APP_URL');
                            $idd = @$_GET['id'];
                            if ($idd) {
                                $res = Helper::dbQuery('SELECT * FROM customer_product_wishlist WHERE parcel_number IS NOT NULL AND parcel_archived=0 AND id_customer=' . $idd . ' AND is_archived IS NULL GROUP BY parcel_number ORDER BY id DESC');

                                if (count($res) > 0) {
                                    $counter = 1;
                                    foreach ($res as $result) {
                                        $pn = $result['parcel_number'];
                                        //  $sql2 = "SELECT id, title, id_customer, price, parcel_l, parcel_b, parcel_h, weight, net_price, tracked_number, parcel_number, qty, hs_code, supplier_track_number FROM customer_product_wishlist WHERE parcel_number='$pn' GROUP BY supplier_track_number";

                                        $res2 = Helper::dbQuery("SELECT id, title, id_customer, price, parcel_l, parcel_b, parcel_h, weight, net_price, tracked_number, parcel_number, qty, hs_code, supplier_track_number FROM customer_product_wishlist WHERE parcel_number='$pn' AND is_archived IS NULL ORDER BY id DESC");

                                        $tit = [];
                                        $ids = [];
                                        if (count($res2) > 0) {

                                            $pri = 0;
                                            $nam = '';
                                            $test = '';
                                            $test2 = '';
                                            foreach ($res2 as $result2) {
                                                $cstt = $result2['id_customer'];

                                                $result3 = Helper::dbQuery("SELECT * FROM shopify_customers WHERE id_customer='$cstt'");
                                                $get_data = $result3[0];

                                                $pri += (float) $result2['price'];
                                                $tit[] = Helper::mysql_escape($result2['title']);
                                                $nam = Helper::mysql_escape($result2['title']);
                                                $pricee = $result2['price'];
                                                $ids[] = $result2['id'];
                                                if ($result2['net_price'] != null) {
                                                    $prr = $result2['net_price'];
                                                } else {
                                                    $prr = $result2['price'] - round((20 / 100 * $result['price']), 2);
                                                }
                                                $hs = $result2['hs_code'];
                                                $iddd = $result2['id'];
                                                $qty = $result2['qty'];
                                                $supplier_track_number = $result2['supplier_track_number'];
                                                $parcel_l = $result2['parcel_l'];
                                                $parcel_b = $result2['parcel_b'];
                                                $parcel_h = $result2['parcel_h'];
                                                $weight = $result2['weight'];
                                                $tracked_number = $result2['parcel_number'];
                                                if ($weight) {
                                                    $weight = $weight;
                                                } else {
                                                    $weight = 0;
                                                }
                                                if ($parcel_l) {
                                                    $parcel_l = $parcel_l;
                                                } else {
                                                    $parcel_l = 0;
                                                }
                                                if ($parcel_b) {
                                                    $parcel_b = $parcel_b;
                                                } else {
                                                    $parcel_b = 0;
                                                }
                                                if ($parcel_h) {
                                                    $parcel_h = $parcel_h;
                                                } else {
                                                    $parcel_h = 0;
                                                }
                                                if ($tracked_number) {
                                                    $tracked_number = $tracked_number;
                                                } else {
                                                    $tracked_number = 0;
                                                }
                                                $fname = $get_data['firstname'];
                                                $lname = $get_data['lastname'];
                                                $idcs = $get_data['id_customer'];
                                                $test .= "<span data-name='$nam' data-price='$prr' data-hs='$hs' data-qty='$qty' data-supp_tracking='$supplier_track_number' data-internal_tracking='$tracked_number' data-l='$parcel_l' data-b='$parcel_b' data-h='$parcel_h' data-weight='$weight'>$nam&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$pricee €</span><br>";
                                                $test2 .= "<span data-name='$nam' data-price='$prr' data-hs='$hs' data-qty='$qty' data-supp_tracking='$supplier_track_number' data-internal_tracking='$tracked_number' data-l='$parcel_l' data-b='$parcel_b' data-h='$parcel_h' data-weight='$weight'><input type='checkbox' class='deleteMultiple' value='$iddd' name='select' units='$qty' price='$pricee'>$nam&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$pricee €</span><br>";
                                            }
                                            $title = implode("<br>", $tit);
                                            $id = implode(",", $ids);
                                        }
                                        $p_w = $result['parcel_weight'];
                                        $p_v_w = (float) $result['parcel_l'] * (float) $result['parcel_b'] * (float) $result['parcel_h'] / 5000;
                                        if ($p_w > $p_v_w) {
                                            $wgt = $p_w;
                                        } else {
                                            $wgt = $p_v_w;
                                        }
                            ?>
                                        <tr>
                                            <!--<td></td>-->
                                            <!--<td><?= $result['id_customer'] . " - " . $result['id']; ?></td>-->
                                            <th style="">

                                                <div style="display: flex;align-items: center">
                                                    <input type="checkbox" class="checks" value="<?= $result['parcel_number'] ?>" style="margin-right: 5px">
                                                    <div style="min-width: 120px">
                                                        <?php echo $fname . ' ' . $lname; ?>
                                                    </div>
                                                    <div class="main" style="min-width: 120px;cursor: pointer">
                                                        <?php if (!empty($result['source'])) { ?>+<?php } ?> <?php echo $result['source']; ?>

                                                    </div>
                                                    <div style="min-width: 120px;cursor: pointer" id="openModal6" value="<?php echo $id; ?>" data-supp_tracking="<?php echo $result['supplier_track_number'] ?>" weight="<?php echo $result['parcel_weight'] ?>" l="<?php echo $result['parcel_l'] ?>" b="<?php echo $result['parcel_b'] ?>" h="<?php echo $result['parcel_h'] ?>">
                                                        <?php echo $result['parcel_number']; ?>
                                                    </div>
                                                    <div title="<?php echo $result['supplier_track_number']; ?>" style="width: 120px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">
                                                        <?php echo $result['supplier_track_number']; ?>
                                                    </div>
                                                    <div style="min-width: 120px;text-align: right;padding-right: 10px;">
                                                        <?php echo $result['parcel_weight'];
                                                        if (!empty($result['parcel_weight'])) {
                                                            echo 'kg';
                                                        } ?>
                                                    </div>
                                                    <div style="min-width: 120px">
                                                        <?php if (!empty($result['parcel_weight']) && !empty($result['parcel_l'])) {
                                                            echo $result['parcel_l'] . 'x' . $result['parcel_b'] . 'x' . $result['parcel_h'] . 'cm';
                                                        } ?>
                                                    </div>
                                                    <div style="min-width: 120px">
                                                        <select class="form-control parcel_statuss" id="parc_status" data-value="<?php echo $id; ?>">
                                                            <option value="0" <?php if ($result['parcel_status'] == 0) {
                                                                                    echo 'selected';
                                                                                } ?>>En attente de livraison</option>
                                                            <option value="1" <?php if ($result['parcel_status'] == 1) {
                                                                                    echo 'selected';
                                                                                } ?>>Livraison retardée</option>
                                                            <option value="2" <?php if ($result['parcel_status'] == 2) {
                                                                                    echo 'selected';
                                                                                } ?>>Reçu</option>
                                                        </select>
                                                    </div>
                                                    <div style="min-width: 120px">
                                                        <select class="form-control send_parcell" id="send_parcel" data-value="<?php echo $id; ?>">
                                                            <option value="0">Select</option>
                                                            <option value="1" <?php if ($result['parcel_for'] == 1) {
                                                                                    echo 'selected';
                                                                                } ?>>Colisrael</option>
                                                            <option value="2" <?php if ($result['parcel_for'] == 2) {
                                                                                    echo 'selected';
                                                                                } ?>>Personal</option>
                                                        </select>
                                                    </div>
                                                    <div class="user_shipping" data-ship="<?php if (!empty($result['selected_shipping'])) {
                                                                                                echo str_replace($result['selected_shipping'], '_price', '');
                                                                                            } else {
                                                                                                echo 'dhl';
                                                                                            } ?>" style="min-width: 120px;display: flex;justify-content: center;align-items: center;">
                                                        <?php if (!empty($result['selected_shipping'])) {
                                                            echo str_replace($result['selected_shipping'], '_price', '');
                                                        } else {
                                                            echo 'dhl';
                                                        } ?>
                                                    </div>
                                                    <!--<a href="javascript:void(0)" id="openModal6" style="cursor: pointer" value="<?php echo $id; ?>" data-supp_tracking="<?php echo $result['supplier_track_number'] ?>" weight="<?php echo $result['parcel_weight'] ?>" l="<?php echo $result['parcel_l'] ?>" b="<?php echo $result['parcel_b'] ?>" h="<?php echo $result['parcel_h'] ?>">-->
                                                    <!--    <?= $result['parcel_number'] . " - " . $wgt ?> kg (<?= $pri ?>€)-->
                                                    <!--    </a>-->
                                                    <div><img title="Archive parcel" class="set_archive" data-parcel="<?= $result['parcel_number'] ?>" src="https://cdn.shopify.com/s/files/1/0515/4927/4282/files/icons8-share-24.png?v=1648125534" style="width: 20px;margin-right: 5px;cursor: pointer"></div>
                                                </div>
                                                <div class="inside" style="display: none;background: #fff;width: 100%">
                                                    <div style="width: 120px"></div>
                                                    <?= $test2 ?>
                                                </div>

                                                <select class="form-control" class="send_parcell" id="send_parcel" data-value="<?php echo $id; ?>" style="float:right;width: 90px;font-size: 13px;padding: 5px;display: none">
                                                    <option value="0">Pending</option>
                                                    <option value="1" <?php if ($result['parcel_for'] == 1) {
                                                                            echo 'selected';
                                                                        } ?>>Colisrael</option>
                                                    <option value="2" <?php if ($result['parcel_for'] == 2) {
                                                                            echo 'selected';
                                                                        } ?>>Personal</option>
                                                </select>
                                            </th>
                                        </tr>

                                        <tr style="display: none">
                                            <td><?= $test ?></td>
                                        </tr>
                            <?php
                                        $counter++;
                                    }
                                }
                            } ?>
                        <tbody>
                    </table>
                </div>

                <!--<h4 class="text-center pt-1">COLISRAEL</h4>-->
            </div>
            <div class="col-md-1" style="margin-top: 200px">
                <button class="cst-btn" data-val="2">Received</button>
                <button class="cst-btn" data-val="1">Unreceived</button>
                <button class="cst-btn active" data-val="">All</button>
                <button class="cst-btn2">Open all</button>
            </div>
        </div>

    </div>

    <div class="col-md-12" style="padding: 30px 0;font-size: 18px;font-weight: bold;">
        <a href="{{ env('APP_URL') }}/shipment_archive">Archive</a>
    </div>
    <div class="col-md-12" style="text-align: center;padding: 30px 0;font-size: 18px;font-weight: bold;">
        <a href="{{ env('APP_URL') }}/index_new">
            < arrière</a>
    </div>
</div>

<div class="pdf_container" style="display:none">
    <div class="row pdf">
        <table style="margin-bottom: 20px;">
            <thead>
                <tr>
                    <th style="font-size: 30px;border:unset">Electro Trade</th>
                    <th style="font-size: 30px;border:unset;text-align: right;">Facture<br><span style="font-weight: normal !important;font-size: 20px !important">INV<?php echo date("ymd"); ?> - <span class="pdf_count"></span></span></th>
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
                    <th style="font-size: 30px;border:unset">Packing list<br><span style="font-size: 20px !important">for INV-<?php echo date("ymd"); ?></span></th>
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
                    <th style="font-size: 30px;border:unset;text-align: right;">Facture<br><span style="font-weight: normal !important;font-size: 20px !important">INV<?php echo date("ymd"); ?> - <span class="pdf_count"></span></span></th>
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
                    <th style="font-size: 30px;border:unset">Packing list<br><span style="font-size: 20px !important">for INV-<?php echo date("ymd"); ?></span></th>
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
                                    $no_of_days = round($diff / 86400); ?>

                                    <option value="<?php echo $result['parcel_number']; ?>"><?php echo $result['parcel_number']; ?></option> <?php
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
                <button type="button" class="btn btn-default" data-dismiss="modal3" id="closeid2">Close</button>
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

<script>
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
        $('.user_shipping').each(function() {
            if ($(this).data('ship') == $this.data('type')) {
                $(this).parents('tr').show()
            }
        })
    })
    $('button.cst-btn2').click(function() {
        $('.main').click()
    })
    $('button.cst-btn').click(function() {
        var $this = $(this);
        $('button.cst-btn').removeClass('active')
        $(this).addClass('active')
        $('.col-md-12.boxes tr').hide()
        $('.parcel_statuss').each(function() {
            if ($this.data('val')) {
                if ($(this).val() == $this.data('val')) {
                    $(this).parents('tr').show()
                }
            } else {
                $(this).parents('tr').show()
            }
        })
    })
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
            $('.btn-parcel').show();
            $('.btn-join-parcel').show()
            $('.btn-arc').show();
        } else {
            $('.btn-parcel').hide();
            $('.btn-join-parcel').hide()
            $('.btn-arc').hide();
        }
    });
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

    function archiveProductData(id, action, object) {
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
    $(document).on("change", "#parc_status", function() {
        var id = $(this).data("value");
        var status = $(this).val();
        update_status(id, status)
    });

    function update_status(id, status) {
        // console.log(id)
        // console.log(status)
        $.ajax({
            type: "POST",
            url: APP_URL + '/update_parcel_status_backend',
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

    $('.col_img').click(function() {
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
        $('.send_parcell').each(function() {
            if ($(this).val() == '1') {
                var ids = $(this).parents('tr').next().attr('value');
                console.log(ids)
                //   updateStatus(ids);
                $(this).closest('tr').next().find('td span').each(function() {
                    tot_pri += $(this).data('qty') * $(this).data('price');
                    console.log(tot_pri)
                    $('.pdf_body').append('<tr><td>' + $(this).data('internal_tracking') + '</td><td style="font-size: 11px;">' + $(this).data('hs') + '</td><td style="font-size: 11px;width: 400px">' + $(this).data('name') + '</td><td class="fl-right">' + $(this).data('qty') + '</td><td class="fl-right">' + $(this).data('price') + '</td><td>' + ($(this).data('qty') * $(this).data('price')).toFixed(2) + '</td></tr>')
                    $('.packing_body').append('<tr><td>' + $(this).data('supp_tracking') + '</td><td>' + $(this).data('l') + 'x' + $(this).data('b') + 'x' + $(this).data('h') + 'cm</td><td>' + $(this).data('weight') + 'kg</td><td class="fl-right">' + ($(this).data('l') * $(this).data('b') * $(this).data('h') / 5000).toFixed(2) + 'kg</tr>')
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

        //location.reload()
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



        $('.pdf_body2').html('');
        var tot_pri = 0;
        $('.send_parcell').each(function() {
            if ($(this).val() == '2') {
                var ids = $(this).parents('tr').next().attr('value');
                console.log(ids)
                //   updateStatus(ids);
                $(this).closest('tr').next().find('td span').each(function() {
                    tot_pri += $(this).data('qty') * $(this).data('price');
                    console.log(tot_pri)
                    $('.pdf_body2').append('<tr><td>' + $(this).data('internal_tracking') + '</td><td style="font-size: 11px;">' + $(this).data('hs') + '</td><td style="font-size: 11px;width: 400px">' + $(this).data('name') + '</td><td class="fl-right">' + $(this).data('qty') + '</td><td class="fl-right">' + $(this).data('price') + '</td><td>' + ($(this).data('qty') * $(this).data('price')).toFixed(2) + '</td></tr>')
                    $('.packing_body2').append('<tr><td>' + $(this).data('supp_tracking') + '</td><td>' + $(this).data('l') + 'x' + $(this).data('b') + 'x' + $(this).data('h') + 'cm</td><td>' + $(this).data('weight') + 'kg</td><td class="fl-right">' + ($(this).data('l') * $(this).data('b') * $(this).data('h') / 5000).toFixed(2) + 'kg</tr>')
                })

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
                    $('.pdf_body').append('<tr><td>' + $(this).data('internal_tracking') + '</td><td style="font-size: 11px;">' + $(this).data('hs') + '</td><td style="font-size: 11px;width: 400px">' + $(this).data('name') + '</td><td class="fl-right">' + $(this).data('qty') + '</td><td class="fl-right">' + $(this).data('price') + '</td><td>' + ($(this).data('qty') * $(this).data('price')).toFixed(2) + '</td></tr>')
                    $('.packing_body').append('<tr><td>' + $(this).data('supp_tracking') + '</td><td>' + $(this).data('l') + 'x' + $(this).data('b') + 'x' + $(this).data('h') + 'cm</td><td>' + $(this).data('weight') + 'kg</td><td class="fl-right">' + ($(this).data('l') * $(this).data('b') * $(this).data('h') / 5000).toFixed(2) + 'kg</tr>')
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
        $('.checks').each(function() {
            if ($(this).is(':checked')) {
                var ids = $(this).next().attr('value');
                console.log(ids)
                //   updateStatus(ids);
                $(this).closest('tr').next().find('td span').each(function() {
                    tot_pri += $(this).data('qty') * $(this).data('price');
                    $('.pdf_body').append('<tr><td>' + $(this).data('internal_tracking') + '</td><td style="font-size: 11px;">' + $(this).data('hs') + '</td><td style="font-size: 11px;width: 400px">' + $(this).data('name') + '</td><td class="fl-right">' + $(this).data('qty') + '</td><td class="fl-right">' + $(this).data('price') + '</td><td>' + ($(this).data('qty') * $(this).data('price')).toFixed(2) + '</td></tr>')
                    $('.packing_body').append('<tr><td>' + $(this).data('supp_tracking') + '</td><td>' + $(this).data('l') + 'x' + $(this).data('b') + 'x' + $(this).data('h') + 'cm</td><td>' + $(this).data('weight') + 'kg</td><td class="fl-right">' + ($(this).data('l') * $(this).data('b') * $(this).data('h') / 5000).toFixed(2) + 'kg</tr>')
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



        $('.pdf_body2').html('');
        var tot_pri = 0;
        $('.checks').each(function() {
            if ($(this).is(':checked')) {
                var ids = $(this).next().attr('value');
                console.log(ids)
                //   updateStatus(ids);
                $(this).closest('tr').next().find('td span').each(function() {
                    tot_pri += $(this).data('qty') * $(this).data('price');
                    $('.pdf_body2').append('<tr><td>' + $(this).data('internal_tracking') + '</td><td style="font-size: 11px;">' + $(this).data('hs') + '</td><td style="font-size: 11px;width: 400px">' + $(this).data('name') + '</td><td class="fl-right">' + $(this).data('qty') + '</td><td class="fl-right">' + $(this).data('price') + '</td><td>' + ($(this).data('qty') * $(this).data('price')).toFixed(2) + '</td></tr>')
                    $('.packing_body2').append('<tr><td>' + $(this).data('supp_tracking') + '</td><td>' + $(this).data('l') + 'x' + $(this).data('b') + 'x' + $(this).data('h') + 'cm</td><td>' + $(this).data('weight') + 'kg</td><td class="fl-right">' + ($(this).data('l') * $(this).data('b') * $(this).data('h') / 5000).toFixed(2) + 'kg</tr>')
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
</script>
@endsection
