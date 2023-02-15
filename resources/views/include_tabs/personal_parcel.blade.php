<style>
    /* Personal Parcel... */

    .btn-personal-pdf {
        margin-bottom: 10px;
        display: none;
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

    /* End Personal Parcel... */
</style>
<h3>Personal Products</h3>
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary btn-personal-pdf" data-toggle="modal" data-target="#exampleModal">
    Generate PDF
</button>
<!--<button type="button" class="btn btn-personal-pdf" name="button">Generate PDF</button>-->
<table id="example14" class="display" style="width:100%">
    <thead>
        <!-- <tr>
	    <th></th>
	    <th>AWB</th>
	    <th>Sent Date</th>
	    <th>Date today</th>
	    <th>Minimum delivery date</th>
	    <th>Maximum delivery date</th>
	    <th>Day in late</th>
	    <th>Integration dhl</th>
	    <th>Integration dhl date</th>
	  </tr> -->
        <!--<tr>-->
        <!--  <th>Product ID</th>-->
        <!--  <th>Parcel Number</th>-->
        <!--  <th>Product Title</th>-->
        <!--  <th>Shipped Staus</th>-->
        <!--  <th>Minimum delivery date</th>-->
        <!--  <th>Maximum delivery date</th>-->
        <!--  <th>Day in late</th>-->
        <!--  <th>Integration dhl</th>-->
        <!--  <th>Integration dhl date</th>-->
        <!--</tr>-->
    </thead>
    <tbody>
        <?php
        $domain_url = env('APP_URL');
        $logos = array(
            'conforama.fr' => asset('logos/conforama.fr.png'),
            'allobebe.fr' => asset('logos/allobebe.fr.png'),
            'leroymerlin.fr' => asset('logos/leroymerlin.fr.png'),
            'kiabi.com' => asset('logos/kiabi.com.png'),
            'tikamoon.com' => asset('logos/tikamoon.com.png'),
            'manomano.fr' => asset('logos/manomano.fr.png'),
            'zalando.fr' => asset('logos/zalando.fr.png'),
            'vente-unique.com' => asset('logos/vente-unique.com.png'),
            'darty.com' => asset('logos/darty_logo.png'),
            'ubaldi.com' => asset('logos/ubaldi_logo.png'),
            'cdiscount.com' => asset('logos/logo-cdiscount.png'),
            'amazon.fr' => asset('logos/amazon-fr-logo.jpg')
        );
        if (count($personalParcel['products']) > 0) {
            $counter = 1;
            foreach ($personalParcel['products'] as $result) {
                $pn = $result['parcel_number'];
                //  $sql2 = "SELECT id, title, id_customer, price, parcel_l, parcel_b, parcel_h, weight, tracked_number, parcel_number, net_price, qty, hs_code, supplier_track_number FROM customer_product_wishlist WHERE parcel_number='$pn' GROUP BY supplier_track_number";
                $res2 = Helper::dbQuery("SELECT id, title, id_customer, price, parcel_l, parcel_b, parcel_h, weight, tracked_number, parcel_number, net_price, qty, hs_code, supplier_track_number FROM customer_product_wishlist WHERE parcel_number='$pn' AND is_archived IS NULL");
                $tit = [];
                $ids = [];
                if (count($res2) > 0) {
                    $pri = 0;
                    $nam = '';
                    $test = '';
                    foreach ($res2 as $result2) {
                        $cstt = $result2['id_customer'];
                        $result3 = Helper::dbQuery("SELECT * FROM shopify_customers WHERE id_customer='$cstt'");
                        if (count($result3) > 0) {
                            $get_data = $result3[0];
                            $pri += $result2['price'];
                            $tit[] = Helper::mysql_escape($result2['title']);
                            $nam = Helper::mysql_escape($result2['title']);
                            $ids[] = $result2['id'];
                            if ($result2['net_price'] != null) {
                                $prr = $result2['net_price'];
                            } else {
                                $prr = $result['price'] - round((20 / 100 * $result['price']), 2);
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
                            $test .= "<span data-name='$nam' data-price='$prr' data-hs='$hs' data-qty='$qty' data-supp_tracking='$supplier_track_number' data-internal_tracking='$tracked_number' data-l='$parcel_l' data-b='$parcel_b' data-h='$parcel_h' data-weight='$weight'>$nam<b>&nbsp;($fname $lname - $idcs)</b></span><br>";
                        }
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
                    <th>
                        <div style="display: flex;align-items: center;justify-content: space-between;">
                            <input type="checkbox" class="checks" value="<?= $result['parcel_number'] ?>">
                            <a href="javascript:void(0)" id="openModal6" style="cursor: pointer" value="<?php echo $id; ?>" data-supp_tracking="<?php echo $result['supplier_track_number'] ?>" weight="<?php echo $result['parcel_weight'] ?>" l="<?php echo $result['parcel_l'] ?>" b="<?php echo $result['parcel_b'] ?>" h="<?php echo $result['parcel_h'] ?>"><?= $result['parcel_number'] . " - " . $wgt ?> kg (<?= $pri ?>€)</a>
                            <div style="display: flex;align-items: center;">
                                <!--<input type="text" class="form-control" name="supplier_tracking_number" id="supplier_tracking_number" data-value="<?php echo $id; ?>">-->
                                <span style="width: 220px;">Send Parcel to:</span>
                                <select class="form-control" id="send_parcel" data-value="<?php echo $id; ?>" style="float:right;margin-right: 50px;width: 150px;">
                                    <option value="0">Select</option>
                                    <option value="1" <?php if ($result['parcel_for'] == 1) {
                                                            echo 'selected';
                                                        } ?>>Colisrael</option>
                                    <option value="2" <?php if ($result['parcel_for'] == 2) {
                                                            echo 'selected';
                                                        } ?>>Personal</option>
                                </select>
                                <select class="form-control" id="parc_status" data-value="<?php echo $id; ?>" style="float:right;margin-right: 50px">
                                    <option value="0" <?php if ($result['parcel_status'] == 0) {
                                                            echo 'selected';
                                                        } ?>>En attente de livraison</option>
                                    <option value="1" <?php if ($result['parcel_status'] == 1) {
                                                            echo 'selected';
                                                        } ?>>Problème en livraison</option>
                                    <option value="2" <?php if ($result['parcel_status'] == 2) {
                                                            echo 'selected';
                                                        } ?>>Reçu</option>
                                </select>
                                <a href="javascript:void(0)" id="del" value="<?php echo $id; ?>" style="float:right">Delete</a>
                            </div>
                        </div>
                    </th>
                    <!--<td><?= $title ?></td>-->
                    <!--<td></td>-->
                    <!--<td></td>-->
                    <!--<td></td>-->
                    <!--<td></td>-->
                    <!--<td></td>-->
                    <!--<td></td>-->
                </tr>
                <tr>
                    <td><?= $test ?></td>
                </tr>
        <?php
                $counter++;
            }
        } ?>
    <tbody>
</table>
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
                <form class="product_information">
                    <input type="hidden" name="iddb" value="" id="iddbb">
                    <!--<div class="form-group">-->
                    <!--   <label for="hs_code">Internal Track Number :</label>-->
                    <!--   <input type="internal_serial_number" class="form-control" id="internal_serial_number" name="internal_serial_number" required="">-->
                    <!--   <span id="hsError"></span>-->
                    <!--</div>-->
                    <div class="row">
                        <h6>DÉTAILS D'EXPÉDITION </h6>
                        <div class="col-md-4 col-sm-12 fcHaveIcon">
                            <input class="pwiFormInput form-control noBorder" type="text" name="parcel_weight" id="product_weight" min="1" size="1" value="1" placeholder="Poids">
                        </div>
                        <div class="col-md-4 col-sm-12 fcHaveIcon">
                            <!--<span class="fcIcon" style="top: 0px;float: right !important;margin-left: 35px;">-->
                            <input class="pwiFormInput form-control noBorder" type="text" name="parcel_weight_type" id="product_weight_type" value="kg" placeholder="kg">
                            <!--</span>-->
                        </div>
                    </div>
                    <div class="row">
                        <div class="fcDimensions">
                            <h6>Dimensions du colis L x I x h (en cm)</h6>
                            <input class="pwiFormInput form-control" type="number" name="order_length" id="parcel_length" min="1" size="1" value="1" placeholder="10">
                            <input class="pwiFormInput form-control" type="number" name="order_width" id="parcel_width" min="1" size="1" value="1" placeholder="10">
                            <input class="pwiFormInput form-control" type="number" name="order_height" id="parcel_height" min="1" size="1" value="1" placeholder="10">
                            <h6 class="dimen-line">soit <span class="cal_wgt">20</span>kg calcul au volume</h6>
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
<script>
    // Personal Parcel...

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

        $("#iddbb").val($(this).attr("value"));
        $("[name='parcel_weight']").val($(this).attr("weight"));
        $("#parcel_length").val($(this).attr("l"));
        $("#parcel_width").val($(this).attr("b"));
        $("#parcel_height").val($(this).attr("h"));
        // $("#iddb").val($(this).attr('value'));
    });
    setInterval(function() {
        // $("#parcel_length, #parcel_width, #parcel_height").on("change keyup paste", function(){
        var cal_val =
            (parseFloat($("#parcel_length").val()) *
                parseFloat($("#parcel_width").val()) *
                parseFloat($("#parcel_height").val())) /
            5000;
        // console.log(cal_val)
        $(".cal_wgt").html(Math.round(cal_val));
        // })
    }, 100);

    $(document).on("click", "#supplier_tracking_number", function(e) {
        var sup_num = $(this).val();
        var id = $(this).attr("value");
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: APP_URL + "/update_supplier_track_number",
            data: {
                id: id,
                sup_num: sup_num
            },
            methos: "POST",
            dataType: "html",
            success: function(data) {
                // location.reload();
                window.location.href =
                    window.location.origin +
                    window.location.pathname +
                    "?tab=" +
                    $("ul.nav.nav-tabs li.active").data("tab");
                return false;
            },
        });
    });

    // $(document).on("click", "#serial_number_submit6" , function(e) {
    //   	e.preventDefault();
    //     $.ajax({
    //       type: "POST",
    //       url: APP_URL+"/update_parcel_weight",
    //       data: $('.product_information').serialize(),
    //       methos: "POST",
    //       dataType:'html',
    //       success: function (data) {
    //         // location.reload();
    //         window.location.href = window.location.origin+window.location.pathname+'?tab='+$('ul.nav.nav-tabs li.active').data('tab')
    //         return false;
    //       },
    //     });
    // });
    $(".shipped_status").on("change", function() {
        event.preventDefault();
        let status = $(this).val();
        let id = $(this).data("id");
        $.ajax({
            type: "POST",
            url: APP_URL + "/update_shipped_status",
            data: {
                id,
                status
            },
            success: function(data) {
                alert("status updated");
            },
            error: function(xhr, status, error) {
                console.error(xhr);
            },
        });
    });
    $(document).on("click", "#del", function() {
        var id = $(this).attr("value");
        var result = confirm("Are you sure?");
        if (result) {
            deleteData(id);
        }
    });
    $(document).on("change", "#send_parcel", function() {
        var id = $(this).data("value");
        var status = $(this).val();
        change_parcel_status(id, status);
    });
    $(document).on("change", "#parc_status", function() {
        var id = $(this).data("value");
        var status = $(this).val();
        update_status(id, status);
    });

    function change_parcel_status(id, status) {
        // console.log(id)
        // console.log(status)
        $.ajax({
            type: "POST",
            url: APP_URL + "/change_parcel_type",
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
            },
        });
    }

    function update_status(id, status) {
        // console.log(id)
        // console.log(status)
        $.ajax({
            type: "POST",
            url: APP_URL + "/update_parcel_status_backend",
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
            },
        });
    }

    function deleteData(id) {
        $.ajax({
            type: "POST",
            url: APP_URL + "/delete_parcel_backend",
            data: {
                id: id
            },
            success: function(data) {
                alert("Data Deleted Successfully");
                // location.reload();
                window.location.href =
                    window.location.origin +
                    window.location.pathname +
                    "?tab=" +
                    $("ul.nav.nav-tabs li.active").data("tab");
            },
            error: function(xhr, status, error) {
                console.error(xhr);
            },
        });
    }

    function updateStatus(id) {
        $.ajax({
            type: "POST",
            url: APP_URL + "/update_invoice_status",
            data: {
                id: id
            },
            success: function(data) {
                // alert('Data Deleted Successfully');
                // location.reload();
            },
            error: function(xhr, status, error) {
                console.error(xhr);
            },
        });
    }
    $(".checks").click(function() {
        if ($(".checks:checkbox:checked").length > 0) {
            $(".btn-personal-pdf").show();
        } else {
            $(".btn-personal-pdf").hide();
        }
    });

    function getCookie(cName) {
        console.log("get");
        const name = cName + "=";
        const cDecoded = decodeURIComponent(document.cookie); //to be careful
        const cArr = cDecoded.split("; ");
        let res;
        cArr.forEach((val) => {
            if (val.indexOf(name) === 0) res = val.substring(name.length);
        });
        return res;
    }
    // Set a Cookie
    function setCookie(cName, cValue, expDays) {
        console.log("set");
        let date = new Date();
        date.setTime(date.getTime() + expDays * 24 * 60 * 60 * 1000);
        const expires = "expires=" + date.toUTCString();
        document.cookie = cName + "=" + cValue + "; " + expires + "; path=/";
    }
    $(".btn-personal-pdf-print").click(function() {
        $(".name_pdf_print").html($("#name_pdf").val());
        $(".street_print").html($("#street").val());
        $(".city_print").html($("#city").val());
        $(".country_print").html($("#country").val());
        $(".vat_number_print").html($("#vat_number").val());
        $(".close_btn").click();
        var pdf_prints = "";
        var prints = getCookie("pdf_prints");
        console.log(prints);
        if (prints != undefined) {
            let pdf_prints = parseInt(prints) + 1;
            // Apply setCookie
            setCookie("pdf_prints", pdf_prints, 1);
            $(".pdf_count").html(pdf_prints);
        } else {
            let pdf_prints = 1;
            $(".pdf_count").html("1");
            // Apply setCookie
            setCookie("pdf_prints", pdf_prints, 1);
        }

        $(".pdf_body").html("");
        var tot_pri = 0;
        $(".checks").each(function() {
            if ($(this).is(":checked")) {
                var ids = $(this).next().attr("value");
                console.log(ids);
                $(this)
                    .closest("tr")
                    .next()
                    .find("td span")
                    .each(function() {
                        tot_pri += $(this).data("qty") * $(this).data("price");
                        $(".pdf_body").append(
                            "<tr><td>" +
                            $(this).data("internal_tracking") +
                            '</td><td style="font-size: 11px;">' +
                            $(this).data("hs") +
                            '</td><td style="font-size: 11px;">' +
                            $(this).data("name") +
                            '</td><td class="fl-right">' +
                            $(this).data("qty") +
                            '</td><td class="fl-right">' +
                            $(this).data("price") +
                            "</td><td>" +
                            (
                                $(this).data("qty") * $(this).data("price")
                            ).toFixed(2) +
                            "</td></tr>"
                        );
                        $(".packing_body").append(
                            "<tr><td>" +
                            $(this).data("supp_tracking") +
                            "</td><td>" +
                            $(this).data("l") +
                            "x" +
                            $(this).data("b") +
                            "x" +
                            $(this).data("h") +
                            "cm</td><td>" +
                            $(this).data("weight") +
                            'kg</td><td class="fl-right">' +
                            (
                                ($(this).data("l") *
                                    $(this).data("b") *
                                    $(this).data("h")) /
                                5000
                            ).toFixed(2) +
                            "kg</tr>"
                        );
                    });
            }
        });
        $(".pdf_body").append(
            "<tr><th>Total Price</th><th></th><th></th><th></th><th></th><th>" +
            tot_pri.toFixed(2) +
            "</th></tr>"
        );
        $("ul.nav.nav-tabs, h3, .btn-personal-pdf, #example14").hide();
        $(".pdf_container").show();
        window.print();
        $(".pdf_container").hide();
        $(".packing_container").show();
        //$('.tot_box').html($('.checks:checkbox:checked').length);
        window.print();
        window.location.href =
            window.location.origin +
            window.location.pathname +
            "?tab=" +
            $("ul.nav.nav-tabs li.active").data("tab");
        $("ul.nav.nav-tabs, h3, .btn-personal-pdf, #example14").show();

        //location.reload()
    });
    $(function() {
        // window.print()
        // setTimeout(function() {window.print()}, 100);
    });
    // End Personal Parcel...
</script>
