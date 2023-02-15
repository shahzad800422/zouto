<style>
    /* archived products... */
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

    /* end archived products.. */
</style>
<h3>Archived Product </h3>
<div class="select_div">
    <label for="hs_code" style="width: 50%">Filter By Name:</label>
    <select class="cust_name form-control">
        <option value="">Select Name</option>
        <?php
        if (count($archivedProducts['customers']) > 0) {
            foreach ($archivedProducts['customers'] as $result) {
        ?>
                <option value="<?php echo $result['firstname'] . ' ' . $result['lastname']; ?>"><?php echo $result['firstname'] . ' ' . $result['lastname']; ?></option>
        <?php
            }
        }
        ?>
    </select>
</div>
<table id="example23" class="display" style="width:100%">
    <thead>
        <th colspan="4">Products informations
        <th colspan="4">Shipment anticipation</th>
        <th colspan="4">In transit</th>
        <tr>
            <th class="sell">Select</th>
            <th>Action</th>
            <th>Customer Name</th>
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
        </tr>
        </th>
    </thead>
    <tbody>
        <?php

        if (count($archivedProducts['products']) > 0) {
            foreach ($archivedProducts['products'] as $result) {
                $hs_limit = $result['limit_product'];
                $date1_ts = date('Y-m-d H:i:s');
                $date2_ts = $result['days'];
                $diff = strtotime($date1_ts) - strtotime($date2_ts);
                $no_of_days = round($diff / 86400);
        ?>
                <tr class="close-<?= $result['id'] ?>">
                    <td><input type="checkbox" class="deleteMultiple" value="<?= $result['id'] ?>" name="select" units="<?php echo $result['qty']; ?>" price="<?php echo $result['price']; ?>"></td>
                    <td><a href="javascript:void(0)" id="openModal" value="<?php echo $result['id']; ?>" net_price="<?php if ($result['net_price']) {
                                                                                                                        echo $result['net_price'];
                                                                                                                    } else {
                                                                                                                        echo $result['price'] - round((20 / 100 * $result['price']), 2);
                                                                                                                    } ?>" hscodev="<?php echo $result['hs_code']; ?>" limitv="<?php echo $result['limit_product']; ?>" originv="<?php echo $result['origin_good']; ?>" invoicedweight="<?php echo $result['invoiced_weight']; ?>" trnumberv="<?php echo $result['tracked_number']; ?>" status="<?php echo $result['product_status']; ?>" price="<?php echo $result['price']; ?>" sup_track_number="<?php echo $result['supplier_track_number']; ?>" warehouse_name="<?php echo $result['warehouse_name'] ?>">Update</a>
                        | &nbsp; <a class="delete_instock_product_data" href="javascript:void(0)" hidden_val="<?php echo $result['id']; ?>" id_customer="<?php echo $result['id_customer'] . '-' . sprintf("%03s", $result['id']); ?>">Delete</a>
                    </td>
                    <td><?php echo $result['firstname'] . ' ' . $result['lastname']; ?></td>
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
                <form class="product_information tsttt">
                    @csrf <!-- {{ csrf_field() }} -->
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
                    @csrf <!-- {{ csrf_field() }} -->

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
