<style>
    /* Wishlist Products... */

    div#myModal {
        overflow: auto;
    }

    .btn-delete,
    .btn-paid,
    .btn-parcel,
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

    /* End Wishlist Products... */
</style>
<h3>In Stock </h3>
<button type="button" class="btn btn-delete" name="button">Delete selected data</button>
<button type="button" class="btn btn-paid" name="button">Mark Paid selected</button>
<button type="button" class="btn btn-parcel" name="button">Create Parcel</button>
<button type="button" class="btn btn-join-parcel" name="button">Join Parcel</button>
<button type="button" class="btn btn-supp" name="button">Update Supplier Tracking</button>
<button type="button" class="btn btn-hs" name="button">Update HS Code</button>
<button type="button" class="btn btn-arc" name="button">Archive</button>
<div class="select_div">
    <label for="hs_code" style="width: 50%">Filter By Name:</label>
    <select class="cust_name form-control">
        <option value="">Select Name</option>
        <?php
        if (count($wishlistProducts['customers']) > 0) {
            foreach ($wishlistProducts['customers'] as $result) {
        ?>
                <option value="<?php echo $result['firstname'] . ' ' . $result['lastname']; ?>"><?php echo $result['firstname'] . ' ' . $result['lastname']; ?></option>
        <?php
            }
        }
        ?>
    </select>
</div>
<table id="example2" class="display" style="width:100%">
    <thead>
        <th colspan="4">Products informations
        <th colspan="4">Shipment anticipation</th>
        <th colspan="4">In transit</th>
        <tr>
            <th class="sell">Select</th>
            <th>Action</th>
            <th>Supplier track number</th>
            <th>Parcel Number</th>
            <th style="display: none">Customer Name</th>
            <th>URL Product</th>
            <th>Name of product</th>

            <th>Units</th>
            <th>Total price</th>
            <th>Net Price</th>
            <th>Status</th>

            <th>Weight</th>
            <!--<th> Price without VAT </th>-->
            <th>Size</th>

            <th>Days</th>
            <th>Category</th>

            <th>HS Code</th>
            <th>Origin of goods</th>
            <th> Customs fees </th>
            <th>Limit </th>
            <th>Alert</th>
            <th>Invoiced weight</th>
            <th>Additional Information</th>

            <th>Numero suivi</th>


            <!-- <th>Payment</th> -->
        </tr>
        </th>
    </thead>
    <tbody>
        <?php
        if (count($wishlistProducts['products']) > 0) {
            foreach ($wishlistProducts['products'] as $result) {
                $hs_limit = $result['limit_product'];
                $date1_ts = date('Y-m-d H:i:s');
                $date2_ts = $result['days'];
                $diff = strtotime($date1_ts) - strtotime($date2_ts);
                $no_of_days = round($diff / 86400);
        ?>
                <tr class="close-<?= $result['id'] ?>">
                    <td><input type="checkbox" class="deleteMultiple" value="<?= $result['id'] ?>" name="select" units="<?php echo $result['qty']; ?>" price="<?php echo $result['price']; ?>"></td>
                    <td><a href="javascript:void(0)" id="openModal" value="<?php echo $result['id']; ?>" net_price="<?php echo (($result['net_price']) ? $result['net_price'] : ($result['price'] - round((20 / 100 * $result['price']), 2))); ?>" hscodev="<?php echo $result['hs_code']; ?>" limitv="<?php echo $result['limit_product']; ?>" originv="<?php echo $result['origin_good']; ?>" invoicedweight="<?php echo $result['invoiced_weight']; ?>" trnumberv="<?php echo $result['tracked_number']; ?>" status="<?php echo $result['product_status']; ?>" price="<?php echo $result['price']; ?>" sup_track_number="<?php echo $result['supplier_track_number']; ?>" warehouse_name="<?php echo $result['warehouse_name'] ?>">Update</a>
                        | &nbsp; <a class="delete_instock_product_data" href="javascript:void(0)" hidden_val="<?php echo $result['id']; ?>" id_customer="<?php echo $result['id_customer'] . '-' . sprintf("%03s", $result['id']); ?>">Delete</a>
                    </td>
                    <td><?php echo $result['supplier_track_number']; ?></td>
                    <td><?php echo $result['parcel_number']; ?></td>
                    <td style="display: none"><?php echo $result['firstname'] . ' ' . $result['lastname']; ?></td>
                    <td><a class="truncate" href="<?php echo $result['product_url']; ?>" target="_blank" title="<?php echo $result['product_url']; ?>"><?php echo $result['product_url']; ?></a></td>
                    <td><?php echo Helper::mysql_escape($result['title']); ?></td>

                    <td><?php echo $result['qty']; ?></td>
                    <td><?php echo $result['price'] . ' ' . $result['currency']; ?></td>
                    <td><?php if ($result['net_price']) {
                            echo $result['net_price'];
                        } else {
                            echo $result['price'] - round((20 / 100 * $result['price']), 2) . ' ' . $result['currency'];
                        } ?></td>
                    <td><?php if ($result['product_status'] == '0') {
                            echo 'Not Paid';
                        } else if ($result['product_status'] == '1') {
                            echo 'Paid';
                        } else if ($result['product_status'] == '2') {
                            echo 'To send back to supplier';
                        } else if ($result['product_status'] == '3') {
                            echo 'Sent back';
                        } else if ($result['product_status'] == '4') {
                            echo 'Indisponible';
                        } else if ($result['product_status'] == '5') {
                            echo 'Annulé';
                        } else {
                            echo '';
                        } ?></td>

                    <td><?php echo $result['weight'] . '' . $result['weight_type']; ?></td>
                    <!--<td><?php echo $result['price'] . ' ' . $result['currency']; ?></td>-->
                    <td><?php echo $result['length'] . 'x' . $result['width'] . 'x' . $result['height'] . '' . $result['weight_type']; ?></td>

                    <td><?= $no_of_days ?> Days</td>
                    <td></td>
                    <td><?php echo $result['hs_code']; ?></td>
                    <td><?php echo $result['origin_good']; ?></td>
                    <td></td>
                    <td><?php echo $result['limit_product']; ?></td>
                    <td <?php if ($hs_limit == $result['qty'] || $hs_limit < $result['qty']) { ?> style="background: green;" <?php } else if ($hs_limit > $result['qty']) { ?> style="background: orange;" <?php } else if ($hs_limit == 0) { ?> style="background: red;" <?php } ?>>
                    </td>
                    <td><?php echo $result['invoiced_weight']; ?></td>
                    <td><?php echo $result['additional_info']; ?></td>
                    <td>
                        <span class="edit-track-number hide-track-<?= $result['id']; ?>" data-id="<?= $result['id']; ?>"><?php echo $result['tracked_number']; ?></span>
                        <span class="show-edit-<?= $result['id']; ?>" style="display:none"> <input type="text" class="update_track_value-<?= $result['id']; ?>" value="<?= $result['tracked_number']; ?>">
                            <center> <span class="cancel_track" data-id="<?= $result['id']; ?>">&#10060;</span> <span class="update_track" data-id="<?= $result['id']; ?>">&#10003;</span></center>
                        </span>
                    </td>
                    <!-- <td>In Pending</td> -->
                </tr>
        <?php
            }
        }
        ?>
    </tbody>
</table>

<!-- Modal -->
<div class="modal" id="myModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Update Product</h4>
            </div>
            <div class="modal-body">
                <div class="form-group" style="width: 50%">
                    <label for="paid_price" style="display: flex;width: 100%;max-width: 100%;align-items: center;">
                        <div style="width: 50%">Paid Price : </div><input type="paid_price" class="form-control" id="paid_price" name="paid_price" required="" style="pointer-events: none;user-select: none;width: 50%;border: none;">
                    </label>

                    <span id="hsError"></span>
                </div>
                <div class="info_message"></div>
                <form class="product_information tstttt">
                    <input type="hidden" name="iddbs" value="" id="iddb">
                    <div class="form-group">
                        <label for="net_price">Net Price:</label>
                        <input type="text" class="form-control" id="net_price" name="net_price" required="">
                        <span id="hsError"></span>
                    </div>
                    <div class="form-group">
                        <label for="hs_code">HS Code:</label>
                        <input type="hs_code" class="form-control" id="hs_code" name="hs_code" required="">
                        <span id="hsError"></span>
                    </div>

                    <div class="form-group" style="display:none">
                        <label for="origin_good">Origin of goods:</label>
                        <input type="origin_good" class="form-control" id="origin_good" name="origin_good" required="">
                        <span id="hsError"></span>
                    </div>

                    <div class="form-group" style="display:none">
                        <label for="limit">Limit :</label>
                        <input type="limit" class="form-control" id="limit" name="limit" required="">
                        <span id="hsError"></span>
                    </div>


                    <div class="form-group">
                        <label for="invoiced_weight">Invoiced weight :</label>
                        <input type="invoiced_weight" class="form-control" id="invoiced_weight" name="invoiced_weight" required="">
                        <span id="hsError"></span>
                    </div>

                    <div class="form-group" style="display:none">
                        <label for="tracked_number">Tracked number :</label>
                        <input type="tracked_number" class="form-control" id="tracked_number" name="tracked_number" required="">
                        <span id="hsError"></span>
                    </div>
                    <div class="form-group">
                        <label for="status">Status :</label>
                        <select class="form-control" name="status" id="status">
                            <option value="1">Paid</option>
                            <option value="0">Not Paid</option>
                            <option value="4">Indisponible</option>
                            <option value="5">Annulé</option>
                            <option value="2">To send back to supplier</option>
                            <option value="3">Sent back</option>
                        </select>
                        <span id="hsError"></span>
                    </div>
                    <div class="form-group" style="display: flex;justify-content: space-between;">

                        <div class="form-group" style="width: 48%">
                            <label for="next_tab">Next Tab :</label>
                            <input type="next_tab" class="form-control" id="next_tab" name="next_tab" required="">
                            <span id="hsError"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="sup_track_number">Supplier track number :</label>
                        <input type="text" class="form-control" id="sup_track_number" name="sup_track_number" required="">
                        <span id="hsError"></span>
                    </div>
                    <div class="form-group">
                        <label for="origin_good">Warehouse Name :</label>
                        <input type="text" class="form-control" id="warehouse_name" name="warehouse_name" required="">
                        <span id="hsError"></span>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" name="instock" id="instock" checked />
                            <label class="form-check-label" for="instock">
                                In Stock
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-default" id="whislist_update">Soumettre</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="closeid">Close</button>
            </div>
        </div>
    </div>
</div>


<!--code for new instock logic -->

<div class="modal" id="myModal2" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Update Product</h4>
            </div>
            <div class="modal-body">
                <div class="info_message"></div>
                <form class="product_information">
                    <input type="hidden" name="iddb" value="" id="iddb">
                    <div class="row" style="display:none">
                        <div class="form-group">
                            <label for="b9">B9</label>
                            <input type="text" class="form-control" id="b9" name="b9" required="" value="0">
                            <span id="hsError"></span>
                        </div>
                    </div>
                    <div class="row" style="display:none">
                        <div class="form-group">
                            <label for="hs_code">A1</label>
                            <input type="text" class="form-control" id="paid_price" name="paid_price" required="">
                            <span id="hsError"></span>
                        </div>

                        <div class="form-group">
                            <label for="origin_good">A2</label>
                            <input type="text" class="form-control" id="is_paid" name="is_paid" required="">
                            <span id="hsError"></span>
                        </div>

                        <div class="form-group">
                            <label for="origin_good">A6</label>
                            <input type="text" class="form-control" id="a6" name="a6" required="">
                            <span id="hsError"></span>
                        </div>
                    </div>
                    <div class="row" style="display:none">
                        <div class="form-group">
                            <label for="hs_code">A3</label>
                            <input type="text" class="form-control" id="" name="" required="">
                            <span id="hsError"></span>
                        </div>

                        <div class="form-group">
                            <label for="origin_good">A4</label>
                            <input type="text" class="form-control" id="track_number" name="track_number" required="">
                            <span id="hsError"></span>
                        </div>

                        <div class="form-group">
                            <label for="origin_good">A5</label>
                            <input type="text" class="form-control" id="warehouse_name" name="warehouse_name" required="">
                            <span id="hsError"></span>
                        </div>
                    </div>
                    <div class="b4_wrapper">
                        <div class="row" id="b4_row">
                            <div class="form-group">
                                <label for="origin_good">B4</label>
                                <input type="text" class="form-control" id="b4" name="b4" required="" value="0">
                                <span id="hsError"></span>
                            </div>
                            <div class="form-group">
                                <label for="origin_good">B5</label>
                                <input type="text" class="form-control" id="b5" name="b5" required="" value="0">
                                <span id="hsError"></span>
                            </div>
                            <div class="form-group">
                                <label for="origin_good">B6</label>
                                <input type="text" class="form-control" id="b6" name="b6" required="" value="0">
                                <span id="hsError"></span>
                            </div>
                            <div class="form-group">
                                <label for="origin_good">B7</label>
                                <input type="text" class="form-control" id="b7" name="b7" required="" value="0">
                                <span id="hsError"></span>
                            </div>
                            <div class="form-group">
                                <label for="origin_good">B8</label>
                                <input type="text" class="form-control" id="b8" name="b8" required="" value="0">
                                <span id="hsError"></span>
                            </div>
                            <div>
                                <button class="plus_btn" type="button">+</button>
                            </div>
                        </div>
                    </div>
                    <!--<button type="submit" class="btn btn-default" id="whislist_update">Soumettre</button>-->
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="closeid">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- end code -->

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
                            if (count($wishlistProducts['parcels']) > 0) {
                                foreach ($wishlistProducts['parcels'] as $result) {
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
                <button type="button" class="btn btn-default" data-dismiss="modal3" id="closeid2">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="myModal01" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal01">&times;</button>
                <h4 class="modal-title">Supplier Tracking Number</h4>
            </div>
            <div class="modal-body">
                <div class="info_message"></div>
                <!--<form class="supp_information">-->
                <!--<input type="hidden" name="iddb" value="" id="iddb">-->
                <div class="form-group">
                    <label for="hs_code">Supplier Tracking Number :</label>
                    <input class="form-control" name="supp_tracking_number" id="supp_tracking_number">
                    <span id="hsError"></span>
                </div>
                <button type="submit" class="btn btn-default" id="supplier_submit">Soumettre</button>
                <!--</form>-->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal01" id="closeid01">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="myModal02" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal02">&times;</button>
                <h4 class="modal-title">HS Code</h4>
            </div>
            <div class="modal-body">
                <div class="info_message"></div>
                <!--<form class="supp_information">-->
                <!--<input type="hidden" name="iddb" value="" id="iddb">-->
                <div class="form-group">
                    <label for="hs_code">HS Code :</label>
                    <input class="form-control" name="hs_code" id="up_hs_code">
                    <span id="hsError"></span>
                </div>
                <button type="submit" class="btn btn-default" id="hs_code_submit">Soumettre</button>
                <!--</form>-->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal02" id="closeid02">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    // Wishlist Products...

    $("#supplier_submit").click(function(e) {
        e.preventDefault();
        let idObject = [];
        $(".deleteMultiple:checkbox:checked").each(function() {
            idObject.push(this.value);
        });
        $.ajax({
            type: "POST",
            url: APP_URL + "/supplier_tracking",
            data: {
                id: idObject,
                form_data: $("#supp_tracking_number").val(),
            },
            methos: "POST",
            dataType: "html",
            success: function(data) {
                // $(".info_message").html('<h3>'+data+'</h3>');
                // console.log(data,'data');
                // var parseData = JSON.parse(data);
                // console.log(parseData,'parseData');
                // alert(parseData.msg);
                // $('#warehouse_name').val('')
                // if (parseData.code == 200) {
                //   $('.close-'+parseData.id).fadeOut("slow");
                // }
                // location.reload();
                window.location.href =
                    window.location.origin +
                    window.location.pathname +
                    "?tab=" +
                    $("ul.nav.nav-tabs li.active").data("tab");
                // setTimeout(function(){
                //  	var modal = document.getElementById("myModal");
                // 	modal.style.display = "none";
                // }, 2000);
                return false;
            },
        });
    });
    $("#hs_code_submit").click(function(e) {
        e.preventDefault();
        let idObject = [];
        $(".deleteMultiple:checkbox:checked").each(function() {
            idObject.push(this.value);
        });
        $.ajax({
            type: "POST",
            url: APP_URL + "/update_hs_code",
            data: {
                id: idObject,
                form_data: $("#up_hs_code").val(),
            },
            methos: "POST",
            dataType: "html",
            success: function(data) {
                // $(".info_message").html('<h3>'+data+'</h3>');
                // console.log(data,'data');
                // var parseData = JSON.parse(data);
                // console.log(parseData,'parseData');
                // alert(parseData.msg);
                // $('#warehouse_name').val('')
                // if (parseData.code == 200) {
                //   $('.close-'+parseData.id).fadeOut("slow");
                // }
                window.location.href =
                    window.location.origin +
                    window.location.pathname +
                    "?tab=" +
                    $("ul.nav.nav-tabs li.active").data("tab");
                // setTimeout(function(){
                //  	var modal = document.getElementById("myModal");
                // 	modal.style.display = "none";
                // }, 2000);
                return false;
            },
        });
    });
    $("#parcel_submit").click(function(e) {
        e.preventDefault();
        let idObject = [];
        $(".deleteMultiple:checkbox:checked").each(function() {
            idObject.push(this.value);
        });
        $.ajax({
            type: "POST",
            url: APP_URL + "/join_parcel",
            data: {
                id: idObject,
                form_data: $("#parcel").val(),
            },
            methos: "POST",
            dataType: "html",
            success: function(data) {
                // $(".info_message").html('<h3>'+data+'</h3>');
                // console.log(data,'data');
                // var parseData = JSON.parse(data);
                // console.log(parseData,'parseData');
                // alert(parseData.msg);
                // $('#warehouse_name').val('')
                // if (parseData.code == 200) {
                //   $('.close-'+parseData.id).fadeOut("slow");
                // }
                // location.reload();
                window.location.href =
                    window.location.origin +
                    window.location.pathname +
                    "?tab=" +
                    $("ul.nav.nav-tabs li.active").data("tab");
                // setTimeout(function(){
                //  	var modal = document.getElementById("myModal");
                // 	modal.style.display = "none";
                // }, 2000);
                return false;
            },
        });
    });
    $(document).on("click", ".btn-join-parcel", function() {
        var modal = document.getElementById("myModal3");
        modal.style.display = "block";
    });
    $(document).on("click", ".btn-supp", function() {
        var modal = document.getElementById("myModal01");
        modal.style.display = "block";
    });
    $(document).on("click", ".btn-hs", function() {
        var modal = document.getElementById("myModal02");
        modal.style.display = "block";
    });
    $(document).on("click", "#openModal", function(e) {
        e.preventDefault();
        var modal = document.getElementById("myModal");
        // var modal = document.getElementById("myModal2");
        modal.style.display = "block";
        $("#iddb").val($(this).attr("value"));

        $("#hs_code").val($(this).attr("hscodev"));
        $("#limit").val($(this).attr("limitv"));
        $("#origin_good").val($(this).attr("originv"));
        $("#invoiced_weight").val($(this).attr("invoicedweight"));
        $("#tracked_number").val($(this).attr("trnumberv"));
        $("#net_price").val($(this).attr("net_price"));
        if ($(this).attr("status")) {
            $("#status").val($(this).attr("status"));
        } else {
            $("#status").val("0");
        }
        $("#paid_price").val($(this).attr("price"));
        $("#sup_track_number").val($(this).attr("sup_track_number"));
        $("#warehouse_name").val($(this).attr("warehouse_name"));
    });

    $(document).on(
        "click",
        ".close, #closeid, #closeid2, #closeid01, #closeid02",
        function(e) {
            e.preventDefault();
            var modal = document.getElementById("myModal");
            modal.style.display = "none";
            var modal = document.getElementById("myModal3");
            modal.style.display = "none";
            var modal = document.getElementById("myModal01");
            modal.style.display = "none";
            var modal = document.getElementById("myModal02");
            modal.style.display = "none";
        }
    );

    $(document).on("click", "#whislist_update", function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: APP_URL + "/update_wishlist_products",
            data: $(".product_information.tstttt").serialize(),
            methos: "POST",
            dataType: "html",
            success: function(data) {
                // $(".info_message").html('<h3>'+data+'</h3>');
                // console.log(data,'data');
                var parseData = JSON.parse(data);
                // console.log(parseData,'parseData');
                // alert(parseData.msg);
                // $('#warehouse_name').val('')
                // if (parseData.code == 200) {
                //   $('.close-'+parseData.id).fadeOut("slow");
                // }
                // location.reload();
                window.location.href =
                    window.location.origin +
                    window.location.pathname +
                    "?tab=" +
                    $("ul.nav.nav-tabs li.active").data("tab");
                // setTimeout(function(){
                //  	var modal = document.getElementById("myModal");
                // 	modal.style.display = "none";
                // }, 2000);
                return false;
            },
        });
    });
    $(document).on("click", ".delete_instock_product_data", function() {
        var id_customer = $(this).attr("hidden_val");
        var result = confirm("Are you sure?");
        if (result) {
            deleteData(id_customer, "single", this);
        }
    });
    $("#example2 tr").click(function(event) {
        if (event.target.type !== "checkbox") {
            $(":checkbox", this).trigger("click");
        }
        if ($(".deleteMultiple:checkbox:checked").length > 1) {
            $(".btn-delete").show();
            $(".btn-paid").show();
            $(".btn-supp").show();
            $(".btn-hs").show();
        } else if ($(".deleteMultiple:checkbox:checked").length > 0) {
            $(".btn-parcel").show();
            $(".btn-arc").show();
            $(".btn-join-parcel").show();
        } else {
            $(".btn-delete").hide();
            $(".btn-paid").hide();
            $(".btn-parcel").hide();
            $(".btn-arc").hide();
            $(".btn-join-parcel").hide();
            $(".btn-supp").hide();
            $(".btn-hs").hide();
        }
    });
    $(".btn-delete").click(function() {
        let idObject = [];
        let thisObject = [];
        $(".deleteMultiple:checkbox:checked").each(function() {
            idObject.push(this.value);
            thisObject.push(this);
        });
        var result = confirm("Are you sure?");
        if (result) {
            deleteData(idObject, "single", thisObject);
        }
    });
    $(".btn-paid").click(function() {
        let idObject = [];
        let thisObject = [];
        $(".deleteMultiple:checkbox:checked").each(function() {
            idObject.push(this.value);
            thisObject.push(this);
        });
        var result = confirm("Want to mark products as paid?");
        if (result) {
            paidData(idObject, "single", thisObject);
        }
    });
    $(".btn-parcel").click(function() {
        let idObject = [];
        let thisObject = [];
        $(".deleteMultiple:checkbox:checked").each(function() {
            idObject.push(this.value);
            thisObject.push(this);
        });
        var result = confirm("Want to create parcel?");
        if (result) {
            createparcelData(idObject, "single", thisObject);
        }
    });
    $(".btn-arc").click(function() {
        let idObject = [];
        let thisObject = [];
        $(".deleteMultiple:checkbox:checked").each(function() {
            idObject.push(this.value);
            thisObject.push(this);
        });
        var result = confirm("Want to archive product?");
        if (result) {
            archiveProductData(idObject, "single", thisObject);
        }
    });

    function archiveProductData(id, action, object) {
        $.ajax({
            type: "POST",
            url: APP_URL + "/archive_backend",
            data: {
                id_customer: id,
                action: action,
            },
            success: function(data) {
                // alert('Archived Successfully');
                // location.reload();
                window.location.href =
                    window.location.origin +
                    window.location.pathname +
                    "?tab=" +
                    $("ul.nav.nav-tabs li.active").data("tab");
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
            },
        });
    }

    function createparcelData(id, action, object) {
        $.ajax({
            type: "POST",
            url: APP_URL + "/create_parcel_backend",
            data: {
                id_customer: id,
                action: action,
            },
            success: function(data) {
                // alert('Parcel created Successfully');
                // location.reload();
                window.location.href =
                    window.location.origin +
                    window.location.pathname +
                    "?tab=" +
                    $("ul.nav.nav-tabs li.active").data("tab");
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
            },
        });
    }

    function deleteData(id, action, object) {
        $.ajax({
            type: "POST",
            url: APP_URL + "/delete_instock_products_backend",
            data: {
                id_customer: id,
                action: action,
            },
            success: function(data) {
                // alert('Data Deleted Successfully');
                if (action == "single") {
                    $(object).closest("tr").fadeOut("slow");
                } else {
                    for (let value of object) {
                        $(value).closest("tr").fadeOut("slow");
                    }
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr);
            },
        });
    }

    function paidData(id, action, object) {
        $.ajax({
            type: "POST",
            url: APP_URL + "/paid_products_backend",
            data: {
                id_customer: id,
                action: action,
            },
            success: function(data) {
                // alert('Data updated Successfully');
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
            },
        });
    }
    $(".edit-track-number").on("click", function() {
        let id = $(this).data("id");
        $(".hide-track-" + id).hide();
        $(".show-edit-" + id).show();
    });
    $(".cancel_track").on("click", function() {
        let id = $(this).data("id");
        $(".hide-track-" + id).show();
        $(".show-edit-" + id).hide();
    });
    $(".update_track").on("click", function() {
        let id = $(this).data("id");
        let trackid = $(".update_track_value-" + id).val();
        $.ajax({
            type: "POST",
            url: APP_URL + "/update_track_number",
            data: {
                id,
                trackid,
            },
            success: function(data) {
                //  alert('Track ID updated successfully');
                $(".update_track_value-" + id).val(trackid);
                $(".hide-track-" + id).text(trackid);
                $(".hide-track-" + id).show();
                $(".show-edit-" + id).hide();
            },
            error: function(xhr, status, error) {
                console.error(xhr);
            },
        });
    });
    $("#example6 tr").click(function(event) {
        if (event.target.type !== "checkbox") {
            $(":checkbox", this).trigger("click");
        }
    });

    // $("#example6 tr").click(function(){
    //     $(this).addClass('selected').siblings().removeClass('selected');
    // });

    //logic for b4,b5,b6,b7

    $html =
        '<div class="row" id="b4_row"> <div class="form-group"> <label for="origin_good">B4</label> <input type="text" class="form-control" id="b4" name="b4" required="" value="0"> <span id="hsError"></span> </div><div class="form-group"> <label for="origin_good">B5</label> <input type="text" class="form-control" id="b5" name="b5" required="" value="0"> <span id="hsError"></span> </div><div class="form-group"> <label for="origin_good">B6</label> <input type="text" class="form-control" id="b6" name="b6" required="" value="0"> <span id="hsError"></span> </div><div class="form-group"> <label for="origin_good">B7</label> <input type="text" class="form-control" id="b7" name="b7" required="" value="0"> <span id="hsError"></span> </div><div class="form-group"> <label for="origin_good">B8</label> <input type="text" class="form-control" id="b8" name="b8" required="" value="0"> <span id="hsError"></span> </div><div> <button class="minus_btn" type="button">-</button> </div></div>';
    $(".plus_btn").click(function() {
        $(this).parents(".b4_wrapper").append($html);
    });
    $(document).on("click", ".minus_btn", function() {
        $(this).parents("#b4_row").remove();
    });
    //setup before functions
    var typingTimer; //timer identifier
    var doneTypingInterval = 1000; //time in ms, 5 second for example
    var $input = $("div#b4_row input");

    //on keyup, start the countdown
    $(document).on("keyup", "div#b4_row input", function() {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(doneTyping, doneTypingInterval);
    });

    //on keydown, clear the countdown
    $(document).on("keyup", "div#b4_row input", function() {
        clearTimeout(typingTimer);
    });

    //user is "finished typing," do something
    function doneTyping() {
        $("div#b4_row").each(function() {
            var b4 = parseFloat($(this).find("#b4").val());
            var b5 = parseFloat($(this).find("#b5").val());
            var b6 = parseFloat($(this).find("#b6").val());
            var b7 = parseFloat($(this).find("#b7").val());

            var newresult = b5 * b6 * b7;
            var result = parseFloat(newresult / 5000);
            // console.log(result);
            $(this).find("#b8").val(result);
            // $(this).find("#b8").each(function(){
            //     var total = parseFloat($("#b9").val());
            //     total += parseFloat($(this).val());
            //     console.log("hello total "+total);
            // });
        });
    }
    $(function() {
        var check = setInterval(function() {
            if ($("ul.nav.nav-tabs li:nth-child(2)").hasClass("active")) {
                setTimeout(function() {
                    $(".sell").click();
                }, 100);
                clearInterval(check);
            }
        }, 100);
    });
    $("select.cust_name.form-control").on("change", function() {
        $("div#example2_filter input").val($(this).val()).trigger("keyup");
    });
    // End Wishlist Products...
</script>
