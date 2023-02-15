@extends('layouts.app')

@section('content')
<style>
    /* Wallet new ... */

    .border-right {
        border-right: 3px solid #000;
    }

    .border-bottom {
        border-bottom: 1px solid #000;
        min-height: 70px;
        border-top: 1px solid #000;
    }

    .head {
        min-width: 130px;
    }

    .fb {
        font-weight: bold;
        font-size: 18px;
    }

    .col-md-12.mt-5 {
        margin-top: 60px;
    }

    .blue_col {
        color: #3f48cc;
        cursor: pointer;
        font-size: 14px;
    }

    span.cross {
        position: absolute;
        right: 25px;
        top: 10px;
        font-weight: bold;
        cursor: pointer;
    }

    .paye_article,
    .paye_article2 {
        cursor: pointer;
    }

    span.parcel_no_click {
        font-weight: bold;
        text-decoration: underline;
        cursor: pointer;
    }

    input.ajouter,
    input.client,
    input.re_client,
    input.date {
        border: unset;
        border-bottom: 1px solid #000;
        width: 90%;
    }

    .modal-body {
        width: 80%;
        margin: auto;
        height: 100px;
        border: 2px solid;
        border-radius: 32px;
    }

    .modal-body {
        padding: 15px 0;
        min-height: 250px;
    }

    .modal-header {
        border-bottom: unset;
    }

    #myModal .row,
    #myModal1 .row {
        margin: 0;
    }

    button#validate {
        float: right;
        margin-right: 30px;
        border: unset;
        font-weight: bold;
    }

    .modal-footer {
        border-top: unset;
    }

    h3.head.fb.pop_edit {
        cursor: pointer;
    }

    table.table-bordered th,
    table.table-bordered td {
        padding: 6px;
    }

    table.table-bordered {
        /*margin-left: 10px;*/
        margin-bottom: 10px;
    }

    /*h3.head {*/
    /*    font-size: 18px;*/
    /*}*/
    @media screen and (max-width: 768px) {
        div#stripe_payment .jumbotron.absPosition2.pd-5 {
            top: 0;
        }
    }

    /* End Wallet new... */
</style>
<?php
$id = $_GET['id_customer'];
$result = Helper::dbQuery("SELECT * FROM transaction WHERE id_customer = $id ORDER BY id DESC");

$result_cus = Helper::dbQuery("SELECT * FROM shopify_customers WHERE id_customer='$id'");
$get_data_cus = $result_cus[0];
?>
<div class="titles_div" style="background: #fff;position: fixed;top: 30%;left: 35%;width: 500px;height: 228px;z-index: 99;padding: 30px 10px;border: 3px solid #000;overflow-y: scroll;display: none">
    <span class="cross">X</span>
    <div class="inner"></div>
</div>
<div class="col-md-4 payes_box" style="position: fixed;right: 20px;top: 25%;border: 3px solid rgb(255, 105, 97);border-radius: 20px;z-index: 9;max-height: 400px;overflow-y: scroll;display: none">
    <span class="cross">X</span>
    <div style="display: flex;align-items: center;padding: 10px 20px;"><img src="https://cdn.shopify.com/s/files/1/0515/4927/4282/files/paye.png?v=1660712013" style="width: 40px;margin-right: 10px;">
        <p style="font-size: 15px;font-weight: bold;">vous avez déposé sur votre compte <span class="paye_price">345.50€</span>.</p>
    </div>
    <div style="display: flex;align-items: center;padding: 10px 20px;"><img src="https://cdn.shopify.com/s/files/1/0515/4927/4282/files/achats.png?v=1660712013" style="width: 40px;margin-right: 10px;">
        <p style="font-size: 15px;font-weight: bold;">vous avez demandé l'achat de <span class="paye_article" style="text-decoration: underline">22 articles</span> d'un montant total de 250.50€.</p>
    </div>
    <div style="display: flex;align-items: center;padding: 10px 20px;"><img src="https://cdn.shopify.com/s/files/1/0515/4927/4282/files/discount.png?v=1661750126" style="width: 40px;margin-right: 10px;">
        <p style="font-size: 15px;font-weight: bold;">vous avez acquitté toutes les taxes israéliennes à prix réduit 50€.</p>
    </div>
    <div style="display: flex;align-items: center;padding: 10px 20px;"><img src="https://cdn.shopify.com/s/files/1/0515/4927/4282/files/exped.png?v=1660712013" style="width: 40px;margin-right: 10px;">
        <p style="font-size: 15px;font-weight: bold;">vous avez prépayé 2 colis en mode Rapido (10kg au total soit 70€) at 1 colis en mode Expresso 5kg 60€.</p>
    </div>
</div>
<div class="col-md-4 payes_box2" style="position: fixed;right: 20px;top: 25%;border: 3px solid rgb(255, 105, 97);border-radius: 20px;z-index: 9;max-height: 400px;overflow-y: scroll;display: none">
    <span class="cross">X</span>
    <div style="display: flex;align-items: center;padding: 10px 20px;"><img src="https://cdn.shopify.com/s/files/1/0515/4927/4282/files/paye.png?v=1660712013" style="width: 40px;margin-right: 10px;">
        <p style="font-size: 15px;font-weight: bold;">vous avez déposé sur votre compte <span class="paye_price">345.50€</span>.</p>
    </div>
    <div style="display: flex;align-items: center;padding: 10px 20px;"><img src="https://cdn.shopify.com/s/files/1/0515/4927/4282/files/achats.png?v=1660712013" style="width: 40px;margin-right: 10px;">
        <p style="font-size: 15px;font-weight: bold;">vous avez ordonné l'achat <span class="paye_article" style="text-decoration: underline">22 articles</span> d'une valeur de 250.50€.</p>
    </div>
    <div style="display: flex;align-items: center;padding: 10px 20px;"><img src="https://cdn.shopify.com/s/files/1/0515/4927/4282/files/discount.png?v=1661750126" style="width: 40px;margin-right: 10px;">
        <p style="font-size: 15px;font-weight: bold;">vous avez acquittē les taxes ā prix rēduit 50€.</p>
    </div>
    <div style="display: flex;align-items: center;padding: 10px 20px;"><img src="https://cdn.shopify.com/s/files/1/0515/4927/4282/files/exped.png?v=1660712013" style="width: 40px;margin-right: 10px;">
        <p style="font-size: 15px;font-weight: bold;">vous avez prēpayē 2 colis en mode Rapido (10kg au total soit 70€) at 1 colis en mode Expresso 5kg 60€.</p>
    </div>
</div>
<h3 class="text-center"><?php echo $get_data_cus['firstname'] . ' ' . $get_data_cus['lastname']; ?></h3>
<?php
$result = Helper::dbQuery("SELECT * FROM transaction WHERE id_customer = $id ORDER BY id DESC");

$wallet_amount = 0;
$wallet_amount_n = 0;
$wallet_amt = 0;
foreach ($result as $rows) {
    $wallet_amount = (float)chop($rows['paid_amount'], '€');
    $wallet_amount_n += (float)chop($rows['paid_amount'], '€');
    $id_cart = $rows['id_cart'];
    $result_parcel = Helper::dbQuery("SELECT * FROM customer_product_wishlist INNER JOIN customer_cart on (customer_cart.id_product = customer_product_wishlist.id) where customer_cart.id_cart=$id_cart and customer_product_wishlist.is_archived IS NULL GROUP BY master_weight");

    $parcel_weight = 0;
    foreach ($result_parcel as $resss) {
        if ($resss['master_weight'] == '1') {
            $parcel_weight += (float)$resss['master_weight'];
        } else {
            $parcel_weight += (float)chop($resss['master_weight'], '(1)');
        }
    }
    //  print_r($parcel_weight);die;
    $result_n = Helper::dbQuery("SELECT * FROM customer_product_wishlist INNER JOIN customer_cart on (customer_cart.id_product = customer_product_wishlist.id) where customer_cart.id_cart=$id_cart and customer_product_wishlist.is_archived IS NULL");

    $count = 0;
    $wish_price = 0;
    $exp = 0;
    $titles = '';
    $discounted_price = 0;
    $discc = 0;
    foreach ($result_n as $ress) {
        $wish_price +=  (float)$ress['price'] * $ress['qty'];
        $titles .= str_replace('"', '', $ress['title']) . ' x ' . $ress['qty'] . ' - ' . (float)$ress['price'] * $ress['qty'] . '<br><br>';
        $result_d = Helper::dbQuery('SELECT * FROM seller where seller_name LIKE  "%' . $ress['source'] . '%"');
        if (!empty($result_d)) {
            $get_data_d = $result_d[0];
            if ($get_data_d['discount_type'] == 'Percentage') {
                $pro_price = ($ress['price'] * $ress['qty']);
                $discounted_price += ($get_data_d['discount_value'] / 100) * $pro_price;
                $dis_p = ($get_data_d['discount_value'] / 100) * $ress['price'];
            } else {
                $pro_price = ($ress['price'] * $ress['qty']);
                $discounted_price += $get_data_d['discount_value'];
            }
        } else {
            $discounted_price += 0;
        }
        $pro_price2 = ($ress['price'] * $ress['qty']);
        $discc += number_format(($pro_price2 * 17) / 100, 2);
        // $tax += (($wish_price) - $discounted_price + ($wish_price * 0.17)) - ($wish_price);
        $exp += $ress['selected_shipping_price'];
        $count++;
    }
    $locked_status = $rows['locked_status'];
    if ($locked_status == '1') {
        $class = 'lockedd';
    } else {
        $class = '';
    }

    if ($ress['selected_shipping'] == 'colisrael_price') {
        //  $shipp_price = $piano;
        $selected_shippp = 'Piano';
    } else if ($ress['selected_shipping'] == 'dhl_price') {
        //  $shipp_price = $colisrael_price;
        $selected_shippp = 'Rapido';
    } else {
        //  $shipp_price = $dhl_price;
        $selected_shippp = 'Expresso';
    }

?>
    <div class="parent <?php echo $class; ?>">
        <div class="col-md-12 mt-5" style="display: flex;align-items: center">

            <div class="col-md-1 fb"><button class="btn pop_open2" data-cart="<?php echo $id_cart; ?>" style="margin-bottom: 10px;<?php if ($locked_status == '1') { ?>visibility: hidden;<?php } ?>">+</button>
                <br><?php echo date("d/m/Y", strtotime($rows['created'])); ?>
                <br>
                <?php if ($rows['locked_status'] == '1') {
                ?>
                    <img src="https://cdn.shopify.com/s/files/1/0515/4927/4282/files/lock.png?v=1662446743" style="width: 50px;margin-top: 10px;position: absolute;cursor: pointer;z-index: 9" class="locked" data-cart="<?php echo $id_cart; ?>">
                <?php
                } else {
                ?>
                    <img src="https://cdn.shopify.com/s/files/1/0515/4927/4282/files/unlock.png?v=1662446743" style="width: 50px;margin-top: 10px;position: absolute;cursor: pointer;z-index: 9" class="unlocked" data-cart="<?php echo $id_cart; ?>">
                <?php } ?>


            </div>
            <div class="col-md-3 border-right border-bottom">
                <div style="display: flex;align-items: center;justify-content: space-evenly">
                    <h3 class="head fb">Payé</h3>
                    <img src="https://cdn.shopify.com/s/files/1/0515/4927/4282/files/paye.png?v=1660712013" style="width: 50px">
                    <div>
                        <h3 class="fb" style="margin-bottom: 0"><?php echo chop($rows['paid_amount'], '€'); ?>€</h3>
                        <span class="fb blue_col paye_click" cart="<?php echo $id_cart; ?>" price="<?php echo chop($rows['paid_amount'], '€'); ?>" articles="<?php echo $count; ?>" discount="<?php echo number_format($discounted_price, 2); ?>" discount2="<?php echo $discc; ?>" articles_price="<?php echo $wish_price; ?>" id_cart="<?php echo $id_cart; ?>" parcel="<?php echo $exp; ?>" parcel_weight="<?php echo ceil($parcel_weight); ?>" titles="<?php echo $titles; ?>" selected_shipping="<?php echo $selected_shippp; ?>">voir le contenu</span>
                        <div class="titles" style="display: none">
                            <?php echo $titles; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 border-bottom">
                <h3 class="fb"><?php echo $wallet_amount; ?>€</h3>
            </div>
        </div>
        <?php
        $id_cart = $rows['id_cart'];
        $result_m = Helper::dbQuery("SELECT * FROM matching_cost WHERE id_cart = $id_cart ORDER BY id DESC");

        $achats = 0;
        foreach ($result_m as $rows_m) {
            $achats += (float) $rows_m['cost'];
        }


        $result_e = Helper::dbQuery("SELECT * FROM transaction_wallet_info WHERE id_cart = $id_cart ORDER BY id DESC");

        $pro_ids = [];
        foreach ($result_e as $rows_e) {
            if (!empty($rows_e['products'])) {
                $pro_ids[] = $rows_e['products'];
            }
        }

        $product_ids = implode(',', $pro_ids);
        if ($product_ids) {
            $result_c = Helper::dbQuery("SELECT * FROM customer_product_wishlist WHERE id IN ($product_ids) and is_archived IS NULL GROUP BY parcel_number ORDER BY id DESC");
        } else {
            $result_c = [];
        }
        $parcels = '';
        $parcel_number = [];
        // $parcel_pro = '';
        $parcel_html = '';
        $wish_disc = 0;
        $wish_disc2 = 0;
        if (count($result_c) > 0) {
            foreach ($result_c as $rows_c) {
                $seller = explode('.', $rows_c['source']);
                $p_n = $rows_c['parcel_number'];
                $result_p = Helper::dbQuery("SELECT * FROM customer_product_wishlist WHERE parcel_number = '$p_n' and is_archived IS NULL ORDER BY id ASC");

                $parcel_pro = '';
                $count = 0;
                $parcel_tot = 0;
                $titles = '';
                $wish_price = 0;
                $pro_price = 0;
                $discounted_price = 0;
                $discc = 0;
                $pro_price2 = 0;
                $dis_show = 0;
                // $wish_disc = 0;
                $pro_idd = [];
                $discount_val = '';
                foreach ($result_p as $rows_p) {
                    $pro_idd[] = $rows_p['id'];
                    $wish_price +=  (float)$rows_p['price'] * $rows_p['qty'];
                    $titles .= $rows_p['title'] . ' x ' . $rows_p['qty'] . ' - ' . (float)$rows_p['price'] * $rows_p['qty'] . '<br><br>';
                    $result_d = Helper::dbQuery('SELECT * FROM seller where seller_name LIKE  "%' . $rows_p['source'] . '%"');
                    if (!empty($result_d)) {
                        $get_data_d = $result_d[0];
                        if ($get_data_d['discount_type'] == 'Percentage') {
                            $discount_val = 'Percentage';
                            $discount_value = $get_data_d['discount_value'];
                            $pro_price = ($rows_p['price'] * $rows_p['qty']);
                            $discounted_price += ($get_data_d['discount_value'] / 100) * $pro_price;
                            $dis_p = ($get_data_d['discount_value'] / 100) * $rows_p['price'];
                        } else {
                            $discount_val = 'Fixed';
                            $discount_value = $get_data_d['discount_value'];
                            $pro_price = ($rows_p['price'] * $rows_p['qty']);
                            $discounted_price += $get_data_d['discount_value'];
                        }
                    } else {
                        $discounted_price += 0;
                    }
                    $pro_price2 = ($rows_p['price'] * $rows_p['qty']);
                    $parcel_pro .= $rows_p['title'] . '<br><br>';
                    $count++;
                    $parcel_tot += $rows_p['price'];
                }

                $pro_ids = implode(',', $pro_idd);
                $result_pr = Helper::dbQuery('SELECT * FROM transaction_wallet_info where products = "' . $pro_ids . '"');
                $show_pr = 0;
                $gt_price = 0;
                $discounted_amt = 0;
                if (!empty($result_pr)) {
                    $get_data_pr = $result_pr[0];
                    $gt_price = (float)$get_data_pr['de_client'];
                    if ($discount_val == 'Percentage') {
                        $discounted_amt = ($discount_value / 100) * $gt_price;
                    } else if ($discount_val == 'Fixed') {
                        $discounted_amt = $discount_value;
                    }
                    $discc = number_format(($gt_price * 17) / 100, 2);
                    $dis_show = $discc - number_format($discounted_amt, 2);
                    $wish_disc = $gt_price + $dis_show;
                    $show_pr = $gt_price;
                    $wish_disc2 += $gt_price + $dis_show;
                }

                $txt = "Valeur Ma'am";
                if ($rows_c['parcel_number']) {
                    $parcels .= '<span class="parcel_no_click" amount="' . $achats . '" articles="' . $count . '" discount="' . number_format($discounted_price, 2) . '" discount2="' . $discc . '" articles_data="' . $titles . '">' . $rows_c['parcel_number'] . '</span><br><br>';
                    $parcel_html .= '<p><strong class="achat_show_tit" ids="' . $pro_ids . '" id_cart="' . $id_cart . '" style="cursor: pointer;text-decoration: underline" price="' . $wish_price . '" discount="' . $discounted_price . '">' . $rows_c['parcel_number'] . '</strong><br><table class="table-bordered"><thead><tr><th>Marchand</th><th>Montant</th><th>' . $txt . '</th><th>Total Colis</th></tr></thead><tbody><tr><td>' . $seller[0] . '</td><td>' . $show_pr . '€</td><td>' . $dis_show . '€</td><td>' . $wish_disc . '€</td></tr></tbody></table><span class="achat_tit" data_pro_ids="' . $pro_ids . '">' . $parcel_pro . '</span></p></p>';
                }
            }
        }
        $wallet_amount -= (float)$wish_disc2;
        $wallet_amount_n -= (float)$wish_disc2;
        ?>
        <div class="col-md-12" style="display: flex;align-items: center">
            <div class="col-md-1 fb" style="visibility: hidden">19/02</div>
            <div class="col-md-3 border-right border-bottom">
                <div style="display: flex;align-items: center;justify-content: space-evenly">
                    <h3 class="head fb">Achats</h3>
                    <img src="https://cdn.shopify.com/s/files/1/0515/4927/4282/files/achats.png?v=1660712013" style="width: 50px">
                    <div>
                        <h3 class="fb" style="margin-bottom: 0"><?php echo $wish_disc2; ?>€</h3>
                        <span class="fb blue_col achatss" cart="<?php echo $id_cart; ?>">voir le contenu</span>
                        <div class="parcel_numbers" style="display: none">
                            <?php echo $parcel_html; ?>
                        </div>
                        <div class="titles" style="display: none"><?php echo $titles; ?></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 border-bottom">
                <h3 class="fb"><?php echo $wallet_amount; ?>€</h3>
            </div>
        </div>
        <?php

        $id_cart = $rows['id_cart'];
        $result_e = Helper::dbQuery("SELECT * FROM customer_cart WHERE id_cart = $id_cart ORDER BY id DESC");

        $pro_ids = [];
        foreach ($result_e as $rows_e) {
            $pro_ids[] = $rows_e['id_product'];
        }

        $product_ids = implode(',', $pro_ids);
        if ($product_ids) {
            $ressult_c = Helper::dbQuery("SELECT * FROM customer_product_wishlist WHERE id IN ($product_ids) and parcel_weight IS NOT NULL and parcel_weight != '' and parcel_locked_price != '' GROUP BY parcel_weight ORDER BY id DESC");
        } else {
            $ressult_c = [];
        }
        if (count($result_c) > 0) {
            foreach ($result_c as $rows_c) {
                $wgt = (float) $rows_c['parcel_weight'];
                $vol_wgt = ((float) $rows_c['parcel_l'] * (float) $rows_c['parcel_b'] * (float) $rows_c['parcel_h']) / 5000;
                if (round($vol_wgt) > round($wgt)) {
                    $show_wgt = $vol_wgt;
                } else {
                    $show_wgt = $wgt;
                }
                $result_weight = Helper::dbQuery('SELECT dhl_price,colisrael_price, piano FROM shipping_weight_prices where weight="' . round($show_wgt) . '"');
                $get_data_weight = $result_weight[0];

                $colisrael_price = $get_data_weight['colisrael_price'];
                $dhl_price = $get_data_weight['dhl_price'];
                if (!empty($get_data_weight['piano'])) {
                    $piano = $get_data_weight['piano'];
                } else {
                    $piano = 0;
                }

                if ($rows_c['selected_shipping'] == 'colisrael_price') {
                    $shipp_price = $piano;
                    $selected_ship = 'Piano';
                } else if ($rows_c['selected_shipping'] == 'dhl_price') {
                    $shipp_price = $colisrael_price;
                    $selected_ship = 'Rapido';
                } else {
                    $shipp_price = $dhl_price;
                    $selected_ship = 'Expresso';
                }

                if ($rows_c['parcel_locked_price']) {
                    $shipp_price = $rows_c['parcel_locked_price'];
                } else {
                    $shipp_price = 0;
                }

                $wallet_amount -= (float)$shipp_price;
                $wallet_amount_n -= (float)$shipp_price;
        ?>
                <div class="col-md-12" style="display: flex;align-items: center" data-amt="<?php echo $wallet_amount; ?>">
                    <div class="col-md-1 fb" style="visibility: hidden">19/02</div>
                    <div class="col-md-3 border-right border-bottom">
                        <div style="display: flex;align-items: center;justify-content: space-evenly">
                            <h3 class="head fb">Expédition</h3>
                            <a href="{{ env('APP_URL') }}/shipment_new"><img src="https://cdn.shopify.com/s/files/1/0515/4927/4282/files/exped.png?v=1660712013" style="width: 50px"></a>
                            <div>
                                <h3 class="fb" style="margin-bottom: 0"><?php echo $shipp_price; ?>€</h3><span class="fb blue_col exped_click" amount="<?php echo $shipp_price; ?>" selected_shipping="<?php echo $selected_ship; ?>" weight="<?php echo round($wgt); ?>" show_weight="<?php echo round($show_wgt); ?>" length="<?php echo $rows_c['parcel_l'] ? $rows_c['parcel_l'] : '0'; ?>" width="<?php echo $rows_c['parcel_b'] ? $rows_c['parcel_b'] : '0'; ?>" height="<?php echo $rows_c['parcel_h'] ? $rows_c['parcel_h'] : '0'; ?>">voir le contenu</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 border-bottom">
                        <h3 class="fb"><?php echo $wallet_amount; ?>€</h3>
                    </div>
                </div>
            <?php
            }
        }
        $result_m = Helper::dbQuery("SELECT * FROM transaction_wallet_info WHERE id_cart = $id_cart AND products IS NULL ORDER BY id DESC");
        $credit_value = 0;
        foreach ($result_m as $rows_m) {
            if ($rows_m['de_client'] != '') {
                $credit_value -= number_format($rows_m['de_client'], 2);
                $vll = number_format($rows_m['de_client'], 2);
                if ($rows_m['ajouter'] != 'Used Credit') {
                    $wallet_amount -= (float)number_format($rows_m['de_client'], 2);
                    $wallet_amount_n -= (float)number_format($rows_m['de_client'], 2);
                }
            } else {
                $credit_value += number_format($rows_m['re_client'], 2);
                $vll = number_format($rows_m['re_client'], 2);
                $wallet_amount += (float)number_format($rows_m['re_client'], 2);
                $wallet_amount_n += (float)number_format($rows_m['re_client'], 2);
            }
            $wallet_amount_new = $wallet_amount_n - $wallet_amount;


            ?>
            <div class="col-md-12" style="display: flex;align-items: center" data-amt="<?php echo $wallet_amount; ?>">
                <div class="col-md-1 fb" style="visibility: hidden">19/02</div>
                <div class="col-md-3 border-right border-bottom">
                    <div style="display: flex;align-items: center;justify-content: space-evenly">
                        <h3 class="head fb <?php if ($locked_status == '0') { ?>pop_edit<?php } ?>" data-id_cart="<?php echo $id_cart; ?>" data-date="<?php echo $rows_m['transaction_date']; ?>" data-id="<?php echo $rows_m['id']; ?>" data-ajouter="<?php echo $rows_m['ajouter']; ?>" data-de_client="<?php echo $rows_m['de_client']; ?>" data-re_client="<?php echo $rows_m['re_client']; ?>">
                            <?php echo $rows_m['ajouter']; ?>
                        </h3>
                        <img src="https://cdn.shopify.com/s/files/1/0515/4927/4282/files/exped.png?v=1660712013" style="width: 50px;visibility: hidden">
                        <div>
                            <h3 class="fb" style="margin-bottom: 0"><?php echo $vll; ?>€</h3><span class="fb blue_col" style="visibility: hidden">voir le contenu</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 border-bottom">
                    <h3 class="fb"><?php echo number_format($wallet_amount, 2); ?>€</h3>
                </div>
            </div>
        <?php
        }
        if ($locked_status == '1') {
            $wallet_amt += $wallet_amount;
        }
        ?>
    </div>
<?php
}
?>

<div style="position: absolute;right: 30%;top: 5%;border: 3px solid #000;padding: 0 15px;padding-bottom: 10px;" class="locked_amt">
    <h3><?php echo number_format($wallet_amt, 2); ?>€</h3>
</div>
<!-- Modal -->
<div class="modal" id="myModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <!--<h4 class="modal-title">Update Product</h4>-->
            </div>
            <div class="modal-body">
                <form class="wallet_form">
                    <input type="hidden" name="id_cart" id="id_cart">
                    <div>
                        <div class="row">
                            <div class="col-md-4" style="padding-right: 0">
                                <h4>Ajouter une ligne</h4>
                            </div>
                            <div class="col-md-8" style="padding-left: 0">
                                <h4><input name="ajouter" class="ajouter"></h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4" style="padding-right: 0">
                                <h4>Dépense client</h4>
                            </div>
                            <div class="col-md-4" style="padding-left: 0">
                                <h4 style="display: flex"><input name="de_client" class="client">€</h4>
                            </div>
                            <div class="col-md-4" style="padding-left: 0">
                                <h5 style="color: red">negative operation</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4" style="padding-right: 0">
                                <h4>Remboursement client</h4>
                            </div>
                            <div class="col-md-4" style="padding-left: 0">
                                <h4 style="display: flex"><input name="re_client" class="re_client">€</h4>
                            </div>
                            <div class="col-md-4" style="padding-left: 0">
                                <h5 style="color: green">positive operation</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2" style="padding-right: 0">
                                <h4>Date</h4>
                            </div>
                            <div class="col-md-3" style="padding: 0">
                                <h4><input class="date transaction_date" name="transaction_date" value="24/03/2022"></h4>
                            </div>
                        </div>

                        <div>

                        </div>
                    </div>
                    <button type="submit" class="btn btn-default" id="validate">Valider</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default close" data-dismiss="modal" id="closeid">Close</button>
            </div>
        </div>
    </div>
</div>



<!-- Modal -->
<div class="modal" id="myModal1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" id="delete" data-id="" data-dismiss="modal">Supprimer &times;</button>
                <!--<h4 class="modal-title">Update Product</h4>-->
            </div>
            <div class="modal-body">
                <form class="wallet_form_update">
                    <input type="hidden" name="id_cart" id="id_cart_edit">
                    <input type="hidden" name="id" id="id">
                    <div>
                        <div class="row">
                            <div class="col-md-4" style="padding-right: 0">
                                <h4>Ajouter une ligne</h4>
                            </div>
                            <div class="col-md-8" style="padding-left: 0">
                                <h4><input name="ajouter" class="ajouter" id="ajouter_edit"></h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4" style="padding-right: 0">
                                <h4>Dépense client</h4>
                            </div>
                            <div class="col-md-4" style="padding-left: 0">
                                <h4 style="display: flex"><input name="de_client" class="client" id="de_client_edit">€</h4>
                            </div>
                            <div class="col-md-4" style="padding-left: 0">
                                <h5 style="color: red">negative operation</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4" style="padding-right: 0">
                                <h4>Remboursement client</h4>
                            </div>
                            <div class="col-md-4" style="padding-left: 0">
                                <h4 style="display: flex"><input name="re_client" class="re_client" id="re_client_edit">€</h4>
                            </div>
                            <div class="col-md-4" style="padding-left: 0">
                                <h5 style="color: green">positive operation</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2" style="padding-right: 0">
                                <h4>Date</h4>
                            </div>
                            <div class="col-md-3" style="padding: 0">
                                <h4><input class="date" name="transaction_date" id="transaction_date_edit"></h4>
                            </div>
                        </div>

                        <div>

                        </div>
                    </div>
                    <button type="submit" class="btn btn-default" id="edit_validate" style="float: right;margin-right: 40px;">Mettre à jour</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default close" data-dismiss="modal" id="closeid1">Fermer</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        // var amt = 0;
        // $('.parent.locked').each(function(){
        //     amt += parseFloat($(this).find('.col-md-12:last-child').attr('data-amt'));
        // })
        // $('.locked_amt').html('<h3>'+amt+'€</h3>')

        $('.paye_click').click(function() {
            $('.payes_box2').hide()
            $('.titles_div .inner').html($(this).next().html())
            var total = $(this).attr('price')
            var selected_shipping = $(this).attr('selected_shipping')
            var articles = $(this).attr('articles')
            if (articles > 1) {
                articles = articles + ' articles'
            } else {
                articles = articles + ' article'
            }
            var articles_price = $(this).attr('articles_price')
            var discount = $(this).attr('discount')
            var discount2 = $(this).attr('discount2')
            var parcel_weight = $(this).attr('parcel_weight')
            var parcel_price = $(this).attr('parcel')
            var diff = discount2 - discount;
            var txt = "d'une";
            $('.payes_box').html('<span class="cross">X</span><div style="display: flex;align-items: center;padding: 10px 20px;"><img src="https://cdn.shopify.com/s/files/1/0515/4927/4282/files/paye.png?v=1660712013" style="width: 40px;margin-right: 10px;"><p style="font-size: 15px;font-weight: bold;">vous avez dēposē sur votre compte <span class="paye_price">' + total + '€</span>.</p></div><div style="display: flex;align-items: center;padding: 10px 20px;"><img src="https://cdn.shopify.com/s/files/1/0515/4927/4282/files/achats.png?v=1660712013" style="width: 40px;margin-right: 10px;"><p style="font-size: 15px;font-weight: bold;">vous avez payē <span class="paye_article" style="text-decoration: underline">' + articles + '</span> ' + txt + ' valeur de ' + articles_price + '€.</p></div><p class="titss" style="display: none;padding-left: 70px;padding-right: 20px;">' + $(this).attr('titles') + '</p><div style="display: flex;align-items: center;padding: 10px 20px;"><img src="https://cdn.shopify.com/s/files/1/0515/4927/4282/files/discount.png?v=1661750126" style="width: 40px;margin-right: 10px;"><p style="font-size: 15px;font-weight: bold;">vous avez acquittē toutes les taxes israēliennes ā prix rēduit ' + diff.toFixed(2) + '€ (' + discount + '€ de rēduction au lieu de ' + discount2 + '€).</p></div><div style="display: flex;align-items: center;padding: 10px 20px;"><img src="https://cdn.shopify.com/s/files/1/0515/4927/4282/files/exped.png?v=1660712013" style="width: 40px;margin-right: 10px;"><p style="font-size: 15px;font-weight: bold;">vous avez prēpayē ' + parcel_weight + 'kg en mode ' + selected_shipping + ' au total soit ' + parcel_price + '€.</p></div>')
            $('.payes_box').show('slow')
        })
        $('.exped_click').click(function() {
            $('.payes_box').html('<span class="cross">X</span><div style="display: flex;align-items: center;padding: 10px 20px;"><img src="https://cdn.shopify.com/s/files/1/0515/4927/4282/files/exped.png?v=1660712013" style="width: 40px;margin-right: 10px;"><p style="font-size: 15px;font-weight: bold;">1 colis ' + $(this).attr('weight') + 'kg ' + $(this).attr('length') + ' X ' + $(this).attr('width') + ' X ' + $(this).attr('height') + 'cm a ētē expēdiē en mode<br>' + $(this).attr('selected_shipping') + '. Poids facturable ' + $(this).attr('weight') + 'kg soit ' + $(this).attr('amount') + '€</p></div>')
            $('.payes_box').show('slow')
        })

    })
    //   $('.achatss').click(function(){
    $(document).on('click', '.achat_show_tit', function() {
        var ids = $(this).attr('ids');
        var id_cart = $(this).attr('id_cart');
        var result = confirm("Want to move into Matching?");
        if (result) {
            moveToMatch(ids, 'single', id_cart)
        }
        // $(this).parent().parent().find('.table-bordered').toggle()
        // $(this).parent().parent().find('.achat_tit').toggle()
    })

    function moveToMatch(id, action, id_cart) {
        $.ajax({
            type: "POST",
            url: APP_URL + '/move_to_matching_all.php',
            data: {
                id_customer: id,
                action: action
            },
            success: function(data) {
                // location.reload();
                window.location.href = "{{ env('APP_URL') }}/matching?id=<?php echo $_GET['id_customer']; ?>&cart=" + id_cart;
            },
            error: function(xhr, status, error) {
                console.error(xhr);
            }
        });
    }
    $(document).on('click', '.achatss', function() {
        event.preventDefault()
        console.log('ws')
        $('.payes_box').html('<span class="cross">X</span><div style="padding: 10px 20px;padding-top: 30px"><p>' + $(this).next().html() + '</p></div>')
        $('.payes_box').show('slow')
        $('.payes_box2').hide('slow')
    })
    $(document).on('click', '.cross', function() {
        $(this).parent().hide('slow')
    })
    $(document).on('click', '.paye_article', function() {
        $(this).parent().parent().next().toggle('slow')
    })

    $(document).on('click', 'span.paye_article2', function() {
        $('.titles_div').html('<span class="cross">X</span>' + $(this).attr('articles_data'))
        $('.titles_div').show('slow')
    })
    $(document).on('click', 'span.parcel_no_click', function() {
        $('.payes_box').hide()
        var total = $(this).attr('amount')
        var articles = $(this).attr('articles')
        if (articles > 1) {
            articles = articles + ' articles'
        } else {
            articles = articles + ' article'
        }
        var discount = $(this).attr('discount')
        var discount2 = $(this).attr('discount2')
        var parcel_weight = $(this).attr('parcel_weight')
        var parcel_price = $(this).attr('parcel')
        var articles_data = $(this).attr('articles_data')
        var diff = discount2 - discount;
        var txt = "d'une";
        $('.payes_box2').html('<span class="cross">X</span><div style="display: flex;align-items: center;padding: 10px 20px;"><img src="https://cdn.shopify.com/s/files/1/0515/4927/4282/files/achats.png?v=1660712013" style="width: 40px;margin-right: 10px;"><p style="font-size: 15px;font-weight: bold;">vous avez payē <span class="paye_article2" style="text-decoration: underline" articles_data="' + articles_data + '">' + articles + '</span> ' + txt + ' valeur de ' + total + '€.</p></div><div style="display: flex;align-items: center;padding: 10px 20px;"><img src="https://cdn.shopify.com/s/files/1/0515/4927/4282/files/discount.png?v=1661750126" style="width: 40px;margin-right: 10px;"><p style="font-size: 15px;font-weight: bold;">vous avez acquittē toutes les taxes israēliennes ā prix rēduit ' + diff.toFixed(2) + '€ (' + discount + '€ de rēduction au lieu de ' + discount2 + '€).</p></div>')
        $('.payes_box2').show('slow')
    })
    $(document).on('click', '.pop_open2', function() {
        $('#id_cart').val($(this).data('cart'))
        var modal = document.getElementById("myModal");
        modal.style.display = "block";
    })
    $(document).on("click", ".close", function(e) {
        e.preventDefault();
        var modal = document.getElementById("myModal");
        modal.style.display = "none";
    });
    $('#validate').click(function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: APP_URL + "/wallet_submit.php",
            data: $('.wallet_form').serialize(),
            methos: "POST",
            dataType: 'html',
            success: function(data) {
                // alert('Information added successfully.')
                $('#myModal').hide()
                $('[name="id_cart"]').val('')
                $('[name="ajouter"]').val('')
                $('[name="de_client"]').val('')
                $('[name="re_client"]').val('')
                if (window.location.search != '') {
                    window.location.href = window.location.href + '&nocache';
                } else {
                    window.location.href = window.location.href + '?nocache';
                }
                // location.reload()
            },
        });
    })
    $(document).on('click', '.pop_edit', function() {
        $('#transaction_date_edit').val($(this).data('date'))
        $('#id').val($(this).data('id'))
        $('#delete').attr('data-id', $(this).data('id'))
        $('#id_cart_edit').val($(this).data('id_cart'))
        $('#ajouter_edit').val($(this).data('ajouter'))
        $('#de_client_edit').val($(this).data('de_client'))
        $('#re_client_edit').val($(this).data('re_client'))
        var modal = document.getElementById("myModal1");
        modal.style.display = "block";
    })
    $(document).on("click", "#closeid1", function(e) {
        e.preventDefault();
        var modal = document.getElementById("myModal1");
        modal.style.display = "none";
    });
    $(document).on('click', '#delete', function() {
        // console.log('weazds')
        // e.preventDefault();
        $.ajax({
            type: "POST",
            url: APP_UR + "/wallet_submit_delete.php",
            data: {
                id: $('#delete').data('id')
            },
            methos: "POST",
            dataType: 'html',
            success: function(data) {
                if (window.location.search != '') {
                    window.location.href = window.location.href + '&nocache';
                } else {
                    window.location.href = window.location.href + '?nocache';
                }
                // location.reload();
            },
        });
    })
    $('#edit_validate').click(function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: APP_URL + "/wallet_submit_update.php",
            data: $('.wallet_form_update').serialize(),
            methos: "POST",
            dataType: 'html',
            success: function(data) {
                if (window.location.search != '') {
                    window.location.href = window.location.href + '&nocache';
                } else {
                    window.location.href = window.location.href + '?nocache';
                }
                // location.reload();
            },
        });
    })

    $('.unlocked').click(function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: APP_URL + "/update_locked_status.php",
            data: {
                id_cart: $(this).attr('data-cart')
            },
            methos: "POST",
            dataType: 'html',
            success: function(data) {
                if (window.location.search != '') {
                    window.location.href = window.location.href + '&nocache';
                } else {
                    window.location.href = window.location.href + '?nocache';
                }
                // location.reload();
            },
        });
    })
    $('.locked').click(function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: APP_URL + "/update_unlocked_status.php",
            data: {
                id_cart: $(this).attr('data-cart')
            },
            methos: "POST",
            dataType: 'html',
            success: function(data) {
                if (window.location.search != '') {
                    window.location.href = window.location.href + '&nocache';
                } else {
                    window.location.href = window.location.href + '?nocache';
                }
                // location.reload();
            },
        });
    })
    $(document).ready(function() {
        var d = new Date();

        var month = d.getMonth() + 1;
        var day = d.getDate();

        $('.transaction_date').val((day < 10 ? '0' : '') + day + '/' + (month < 10 ? '0' : '') + month + '/' + d.getFullYear());
    })
</script>

@endsection
