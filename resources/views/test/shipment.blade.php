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

    .box_par {
        /*display: flex;*/
        /*justify-content: space-between;*/
    }

    .col-md-12.boxes {
        border: 2px solid #000;
        display: flex;
        justify-content: center;
        padding: 20px;
        border-radius: 20px;
        min-height: 285px;
        margin-bottom: 10px !important;
        height: 285px;
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

    .btn-pdf {
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

    /* test shipment  */
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

    .pdf_count {
        display: none;
    }

    input.deleteMultiple {
        pointer-events: none;
    }

    @media (min-width: 1200px) {
        .container {
            width: 1450px;
        }
    }

    /* End test shipment */
</style>
<div class="container main_head">
    <div class="row box_par">
        <div>

            <div class="col-md-4">

                <button type="button" class="btn btn-pdf" name="button" style="display: none">Generate PDF</button>
                <div class="col-md-12 boxes" style="margin: unset">

                    <table id="example14" class="display" style="width:100%">
                        <thead>
                        </thead>
                        <tbody>
                            <?php
                            $domain_url = env('APP_URL');
                            $res = Helper::dbQuery('SELECT * FROM customer_product_wishlist WHERE parcel_number IS NOT NULL AND parcel_for=1 AND is_archived IS NULL GROUP BY parcel_number ORDER BY id DESC');

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
                                        foreach ($res2 as $result2) {
                                            $cstt = $result2['id_customer'];

                                            $result3 = Helper::dbQuery("SELECT * FROM shopify_customers WHERE id_customer='$cstt'");
                                            $get_data = $result3[0];

                                            $pri += $result2['price'];
                                            $tit[] = Helper::mysql_escape($result2['title']);
                                            $nam = Helper::mysql_escape($result2['title']);
                                            $ids[] = $result2['id'];
                                            if ($result2['net_price'] != null) {
                                                $prr = $result2['net_price'];
                                            } else {
                                                $prr = $result2['price'] - round((20 / 100 * $result['price']), 2);
                                            }
                                            $hs = $result2['hs_code'];
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
                                            $test .= "<span data-name='$nam' data-price='$prr' data-hs='$hs' data-qty='$qty' data-supp_tracking='$supplier_track_number' data-internal_tracking='$tracked_number' data-l='$parcel_l' data-b='$parcel_b' data-h='$parcel_h' data-weight='$weight'>$nam</span><br>";
                                        }
                                        $title = implode("<br>", $tit);
                                        $id = implode(",", $ids);
                                    }
                                    $p_w = $result['parcel_weight'];
                                    $p_v_w = $result['parcel_l'] * $result['parcel_b'] * $result['parcel_h'] / 5000;
                                    if ($p_w > $p_v_w) {
                                        $wgt = $p_w;
                                    } else {
                                        $wgt = $p_v_w;
                                    }
                            ?>
                                    <tr>
                                        <!--<td></td>-->
                                        <!--<td><?= $result['id_customer'] . " - " . $result['id']; ?></td>-->
                                        <th style="display: flex;align-items: center;justify-content: space-between">
                                            <div class="main" style="width: 190px">
                                                <input type="checkbox" class="checks" value="<?= $result['parcel_number'] ?>">
                                                <a href="javascript:void(0)" id="openModal6" style="cursor: pointer" value="<?php echo $id; ?>" data-supp_tracking="<?php echo $result['supplier_track_number'] ?>" weight="<?php echo $result['parcel_weight'] ?>" l="<?php echo $result['parcel_l'] ?>" b="<?php echo $result['parcel_b'] ?>" h="<?php echo $result['parcel_h'] ?>">
                                                    <?= $result['parcel_number'] . " - " . $wgt ?> kg (<?= $pri ?>€)
                                                </a>
                                                <div class="inside" style="display: none;position: absolute;background: #fff;box-shadow: 0 0 3px 1px #838282;height: 200px;overflow-y: scroll;width: 90%"><?= $test ?></div>
                                            </div>
                                            <select class="form-control" id="send_parcel" data-value="<?php echo $id; ?>" style="float:right;width: 90px;font-size: 13px;padding: 5px;">
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
                            } ?>
                        <tbody>
                    </table>
                </div>
                <h4 class="text-center pt-1">COLISRAEL</h4>
            </div>
            <div class="col-md-4">
                <div class="col-md-12 boxes" style="margin: unset">
                    <table id="example14" class="display" style="width:100%">
                        <thead>
                        </thead>
                        <tbody>
                            <?php
                            $domain_url = env('APP_URL');
                            $res = Helper::dbQuery('SELECT * FROM customer_product_wishlist WHERE parcel_number IS NOT NULL AND parcel_for=0 AND is_archived IS NULL GROUP BY parcel_number ORDER BY id DESC');

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
                                        foreach ($res2 as $result2) {
                                            $cstt = $result2['id_customer'];
                                            $result3 = Helper::dbQuery("SELECT * FROM shopify_customers WHERE id_customer='$cstt'");
                                            $get_data = $result3[0];
                                            $pri += $result2['price'];
                                            $tit[] = Helper::mysql_escape($result2['title']);
                                            $nam = Helper::mysql_escape($result2['title']);
                                            $ids[] = $result2['id'];
                                            if ($result2['net_price'] != null) {
                                                $prr = $result2['net_price'];
                                            } else {
                                                $prr = $result2['price'] - round((20 / 100 * $result['price']), 2);
                                            }
                                            $hs = $result2['hs_code'];
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
                                            $test .= "<span data-name='$nam' data-price='$prr' data-hs='$hs' data-qty='$qty' data-supp_tracking='$supplier_track_number' data-internal_tracking='$tracked_number' data-l='$parcel_l' data-b='$parcel_b' data-h='$parcel_h' data-weight='$weight'>$nam</span><br>";
                                        }
                                        $title = implode("<br>", $tit);
                                        $id = implode(",", $ids);
                                    }
                                    $p_w = $result['parcel_weight'];
                                    $p_v_w = $result['parcel_l'] * $result['parcel_b'] * $result['parcel_h'] / 5000;
                                    if ($p_w > $p_v_w) {
                                        $wgt = $p_w;
                                    } else {
                                        $wgt = $p_v_w;
                                    }
                            ?>
                                    <tr>
                                        <!--<td></td>-->
                                        <!--<td><?= $result['id_customer'] . " - " . $result['id']; ?></td>-->
                                        <th style="display: flex;align-items: center;justify-content: space-between">
                                            <div class="main" style="width: 190px">
                                                <!--<input type="checkbox" class="checks_pending" value="<?= $result['parcel_number'] ?>">-->
                                                <a href="javascript:void(0)" id="openModal6" style="cursor: pointer" value="<?php echo $id; ?>" data-supp_tracking="<?php echo $result['supplier_track_number'] ?>" weight="<?php echo $result['parcel_weight'] ?>" l="<?php echo $result['parcel_l'] ?>" b="<?php echo $result['parcel_b'] ?>" h="<?php echo $result['parcel_h'] ?>">
                                                    <?= $result['parcel_number'] . " - " . $wgt ?> kg (<?= $pri ?>€)
                                                </a>
                                                <div class="inside" style="display: none;position: absolute;background: #fff;box-shadow: 0 0 3px 1px #838282;height: 200px;overflow-y: scroll;width: 90%"><?= $test ?></div>
                                            </div>
                                            <select class="form-control" id="send_parcel" data-value="<?php echo $id; ?>" style="float:right;width: 90px;font-size: 13px;padding: 5px;">
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
                            } ?>
                        <tbody>
                    </table>
                </div>
                <h4 class="text-center pt-1">PENDING</h4>
            </div>
            <div class="col-md-4">
                <button type="button" class="btn btn-pdf_personal" name="button" style="display: none">Generate PDF</button>
                <div class="col-md-12 boxes" style="margin: unset">
                    <table id="example14" class="display" style="width:100%">
                        <thead>
                        </thead>
                        <tbody>
                            <?php
                            $domain_url = env('APP_URL');
                            $res = Helper::dbQuery('SELECT * FROM customer_product_wishlist WHERE parcel_number IS NOT NULL AND parcel_for=2 AND is_archived IS NULL GROUP BY parcel_number ORDER BY id DESC');

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
                                        foreach ($res2 as $result2) {
                                            $cstt = $result2['id_customer'];
                                            $result3 = Helper::dbQuery("SELECT * FROM shopify_customers WHERE id_customer='$cstt'");
                                            $get_data = $result3[0];
                                            $pri += $result2['price'];
                                            $tit[] = Helper::mysql_escape($result2['title']);
                                            $nam = Helper::mysql_escape($result2['title']);
                                            $ids[] = $result2['id'];
                                            if ($result2['net_price'] != null) {
                                                $prr = $result2['net_price'];
                                            } else {
                                                $prr = $result2['price'] - round((20 / 100 * $result['price']), 2);
                                            }
                                            $hs = $result2['hs_code'];
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
                                            $test .= "<span data-name='$nam' data-price='$prr' data-hs='$hs' data-qty='$qty' data-supp_tracking='$supplier_track_number' data-internal_tracking='$tracked_number' data-l='$parcel_l' data-b='$parcel_b' data-h='$parcel_h' data-weight='$weight'>$nam</span><br>";
                                        }
                                        $title = implode("<br>", $tit);
                                        $id = implode(",", $ids);
                                    }
                                    $p_w = $result['parcel_weight'];
                                    $p_v_w = $result['parcel_l'] * $result['parcel_b'] * $result['parcel_h'] / 5000;
                                    if ($p_w > $p_v_w) {
                                        $wgt = $p_w;
                                    } else {
                                        $wgt = $p_v_w;
                                    }
                            ?>
                                    <tr>
                                        <!--<td></td>-->
                                        <!--<td><?= $result['id_customer'] . " - " . $result['id']; ?></td>-->
                                        <th style="display: flex;align-items: center;justify-content: space-between">
                                            <div class="main" style="width: 190px">
                                                <input type="checkbox" class="checks_personal" value="<?= $result['parcel_number'] ?>">
                                                <a href="javascript:void(0)" id="openModal6" style="cursor: pointer" value="<?php echo $id; ?>" data-supp_tracking="<?php echo $result['supplier_track_number'] ?>" weight="<?php echo $result['parcel_weight'] ?>" l="<?php echo $result['parcel_l'] ?>" b="<?php echo $result['parcel_b'] ?>" h="<?php echo $result['parcel_h'] ?>">
                                                    <?= $result['parcel_number'] . " - " . $wgt ?> kg (<?= $pri ?>€)
                                                </a>
                                                <div class="inside" style="display: none;position: absolute;background: #fff;box-shadow: 0 0 3px 1px #838282;height: 200px;overflow-y: scroll;width: 90%"><?= $test ?></div>
                                            </div>
                                            <select class="form-control" id="send_parcel" data-value="<?php echo $id; ?>" style="float:right;width: 90px;font-size: 13px;padding: 5px;">
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
                            } ?>
                        <tbody>
                    </table>
                </div>
                <h4 class="text-center pt-1">PERSONEL</h4>
            </div>
            <!--<div class="col-md-8">-->
            <!--   <div class="col-md-12 boxes" style="margin: unset;display: block;padding: 40px;">-->
            <?php
            // $sql = "SELECT * FROM customer_product_wishlist INNER JOIN shopify_customers on (shopify_customers.id_customer = customer_product_wishlist.id_customer) WHERE customer_product_wishlist.status = 2 GROUP BY customer_product_wishlist.id_customer";
            $sql = "SELECT * FROM transaction INNER JOIN shopify_customers on (shopify_customers.id_customer = transaction.id_customer) ORDER BY transaction.id DESC";

            $res = $con->query($sql);
            if ($res->num_rows > 0) {
                $counter = 0;
                foreach ($res as $result) {
                    if ($counter < 5) {
            ?>
                        <!--<div class="row" style="display: flex;width: 100%;justify-content: space-between;">-->
                        <!--    <div class="col-md-5">-->
                        <!--        <h4><a href="{{ env('APP_URL') }}/index2_customer?id=<?php echo $result['id_customer']; ?>&cart=<?php echo $result['id_cart']; ?>&sum=<?php echo $result['paid_amount']; ?>" target="_blank" style="color: black"><?php echo $result['firstname'] . ' ' . $result['lastname']; ?></a></h4>-->
                        <!--    </div>-->
                        <!--    <div class="col-md-3">-->
                        <!--        <h4><?php echo $result['paid_amount']; ?>€</h4>-->
                        <!--    </div>-->
                        <!-- </div>-->
            <?php
                        $counter++;
                    }
                }
            }
            ?>
            <!--<div class="row" style="display: flex;width: 100%;justify-content: space-between;">-->
            <!--    <div class="col-md-3">-->
            <!--        <h4>Mikhael</h4>-->
            <!--    </div>-->
            <!--    <div class="col-md-3">-->
            <!--        <h4>100</h4>-->
            <!--    </div>-->
            <!-- </div>-->
            <!--   </div>-->
            <!--</div>-->
        </div>
        <!--<div class="col-md-8 table">-->

        <!--</div>-->

    </div>
    <!--<div class="row box_par">-->
    <!-- <div class="col-md-4">-->
    <!--     <div class="col-md-12 boxes" style="margin-left: 0">-->
    <!--       <img src="{{ env('APP_URL') }}/images/new_index/Screenshot_2.png"> -->
    <!--     </div>-->
    <!--     <h4 class="text-center pt-1"><a target="_blank" href="{{ env('APP_URL') }}/shipment?id=<?php echo $result['id_customer']; ?>" style="color: #000">CREATE A SHIPMENT</a></h4>-->
    <!-- </div>-->
    <!-- <div class="col-md-4">-->
    <!--     <div class="col-md-12 boxes">-->
    <!--       <img src="{{ env('APP_URL') }}/images/new_index/Screenshot_3.png"> -->
    <!--     </div>-->
    <!--     <h4 class="text-center pt-1">ZOUTO CLUB</h4>-->
    <!-- </div>-->
    <!-- <div class="col-md-4">-->
    <!--     <div class="col-md-12 boxes">-->
    <!--       <img src="{{ env('APP_URL') }}/images/new_index/Screenshot_4.png"> -->
    <!--     </div>-->
    <!--     <h4 class="text-center pt-1">MAINTENENCE</h4>-->
    <!-- </div>-->
    <!--</div>-->
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
<div class="modal" id="myModal6" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal6">&times;</button>
                <h4 class="modal-title">Update parcel weight</h4>
            </div>
            <div class="modal-body">
                <div class="info_message"></div>
                <form class="product_information01">
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
                    <button type="submit" class="btn btn-default" id="serial_number_submit6">Soumettre</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal6" id="closeid6">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
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
            url: "{{ env('APP_URL') }}/update_parcel_weight.php",
            data: $('.product_information01').serialize(),
            methos: "POST",
            dataType: 'html',
            success: function(data) {
                location.reload();
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
            url: '{{ env('
            APP_URL ') }}/change_parcel_type.php',
            data: {
                id: id,
                status: status
            },
            success: function(data) {
                // alert('Status updated Successfully');
                location.reload();
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
            url: '{{ env('
            APP_URL ') }}/update_invoice_status.php',
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

    $('.btn-pdf').click(function() {
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

        location.reload()
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

        location.reload()
        // window.location.href = window.location.origin+window.location.pathname+'?tab='+$('ul.nav.nav-tabs li.active').data('tab')
    })
</script>


@endsection
