<style>
    /* instock_products css */

    div#myModalEdit {
        overflow: auto;
    }

    .swal-wide {
        width: 850px !important;
    }

    .col,
    .col-1,
    .col-2,
    .col-3,
    .col-4,
    .col-5,
    .col-6,
    .col-7,
    .col-8,
    .col-9,
    .col-10,
    .col-11,
    .col-12,
    .col-auto,
    .col-lg,
    .col-lg-1,
    .col-lg-2,
    .col-lg-3,
    .col-lg-4,
    .col-lg-5,
    .col-lg-6,
    .col-lg-7,
    .col-lg-8,
    .col-lg-9,
    .col-lg-10,
    .col-lg-11,
    .col-lg-12,
    .col-lg-auto,
    .col-md,
    .col-md-1,
    .col-md-2,
    .col-md-3,
    .col-md-4,
    .col-md-5,
    .col-md-6,
    .col-md-7,
    .col-md-8,
    .col-md-9,
    .col-md-10,
    .col-md-11,
    .col-md-12,
    .col-md-auto,
    .col-sm,
    .col-sm-1,
    .col-sm-2,
    .col-sm-3,
    .col-sm-4,
    .col-sm-5,
    .col-sm-6,
    .col-sm-7,
    .col-sm-8,
    .col-sm-9,
    .col-sm-10,
    .col-sm-11,
    .col-sm-12,
    .col-sm-auto,
    .col-xl,
    .col-xl-1,
    .col-xl-2,
    .col-xl-3,
    .col-xl-4,
    .col-xl-5,
    .col-xl-6,
    .col-xl-7,
    .col-xl-8,
    .col-xl-9,
    .col-xl-10,
    .col-xl-11,
    .col-xl-12,
    .col-xl-auto {
        padding: 6px 12px;
    }

    .modal {
        position: fixed;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        outline: 0;
        pacity: 1;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.4);
        z-index: 999;
        overflow: auto;
    }

    .col-sm-12.textFooterModel {
        padding-top: 15px;
    }

    .modal-dialog {
        position: relative;
    }

    .modal-content {
        position: relative;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #999;
        border: 1px solid rgba(0, 0, 0, 0.2);
        border-radius: 6px;
        -webkit-box-shadow: 0 3px 9px rgba(0, 0, 0, 0.5);
        box-shadow: 0 3px 9px rgba(0, 0, 0, 0.5);
        outline: 0;
        margin: 25% auto;
        padding: 20px;
        width: 90%;
        display: flex;
        flex-direction: column;
        pointer-events: auto;
    }

    .wishlistproduct_container .form-control.noBorder {
        border-left: none !important;
        border-right: none !important;
        border-radius: 0 !important;
        border-top: none !important;
        padding-left: 0 !important;
        margin-bottom: 5px;
        box-shadow: none !important;
    }

    .wishlistproduct_container .form-control.product_url {
        color: #d38e9b !important;
        font-weight: 400;
    }

    .wishlistproduct_container h6 {
        font-weight: 700;
        color: #666;
        margin-top: 10px;
        font-size: 11px;
    }

    .fcHaveIcon .fcIcon {
        position: absolute;
        right: 7px;
        top: 20px;
        color: #666;
        font-size: 11px;
    }

    label.quantity_desiredtext {
        border-bottom: none !important;
        margin-top: 7px !important;
        margin-right: 10px !important;
    }

    .product_info_edit label.quantity_desiredtext {
        padding: 2px 5px 5px 5px;
        font-size: 11px;
    }

    .fcDimensions {
        display: flex;
        align-items: center;
        margin: 0 0 10px;
        flex-wrap: wrap;
        text-align: center;
        width: 100%;
    }

    .fcDimensions input {
        width: 31.333%;
        float: left;
        border: 1px solid #ccc;
        margin: 1%;
        box-shadow: none;
    }

    .fcDimensions h6 {
        font-weight: 400;
        color: #666;
    }

    .fcDimensions h6 {
        width: 100%;
    }

    label {
        display: inline-block;
        max-width: 100%;
        margin-bottom: 5px;
        font-weight: 700;
    }

    .textFooterModel p {
        color: #3a3e53;
        font-size: 12px;
        line-height: normal;
        margin-bottom: 10px;
    }

    @media (min-width: 576px) {
        .modal-dialog {
            max-width: 500px;
            pointer-events: none;
        }
    }

    @media (min-width: 768px) {
        .modal-dialog {
            width: 600px;
            margin: 30px auto;
        }

        .modal-content {
            -webkit-box-shadow: 0 5px 15px rgb(0 0 0 / 50%);
            box-shadow: 0 5px 15px rgb(0 0 0 / 50%);
        }
    }

    .edit-track-number {
        color: blue;
        cursor: pointer;
    }

    .edit-track-number:hover {
        text-decoration: underline;
    }

    .update_track {
        font-size: 20px;
        color: green;
        font-weight: 900;
        margin-left: 10px;
        border: 1px solid;
        padding: 0px 3px;
        position: relative;
        top: 3px;
        cursor: pointer;
    }

    .cancel_track {
        border: 1px solid;
        color: red;
        padding: 6px;
        font-size: 11px;
        cursor: pointer;
    }

    .dimen-line {
        font-size: 14px !important;
        position: relative;
        right: -40px;
    }

    .select_div {
        text-align: center;
        width: 30%;
        display: flex;
        margin-left: auto;
        align-items: center;
        margin-bottom: 10px;
    }

    .btn-delete_with_cst {
        display: none;
    }

    /* end instock_products */
</style>
<h3>Wish-lists</h3>
<button type="button" class="btn btn-delete_with_cst" name="button" style="display: none">Delete Articles</button>
<div class="select_div">
    <label for="hs_code" style="width: 50%">Filter By Name:</label>
    <select class="cust_name2 form-control">
        <option value="">Select Name</option>
        <?php
        if (count($inStockProducts['customers']) > 0) {
            foreach ($inStockProducts['customers'] as $result) {
        ?>
                <option data-id="<?php echo $result['id_customer']; ?>" value="<?php echo $result['firstname'] . ' ' . $result['lastname']; ?>"><?php echo $result['firstname'] . ' ' . $result['lastname']; ?></option>
        <?php
            }
        }
        ?>
    </select>
</div>
<table id="example6" class="display" style="width:100%">
    <thead>
        <th>Select</th>
        <th>ID PRODUCT</th>
        <th>Customer Name</th>
        <th>Official product name</th>
        <th>Units</th>
        <th>Limit</th>
        <th></th>
        <th> Price without VAT </th>
        <th>No of parcels</th>
        <th>Invoiced weight</th>
        <th>Payment</th>
        <th>Shipper choice</th>
        <th>Zouto Choice</th>
        <th>Packing</th>
        <th>AWB</th>
        <th>Transit invoice number</th>
        <th>Action</th>


    </thead>
    <tbody>
        <?php
        if (count($inStockProducts['products']) > 0) {
            foreach ($inStockProducts['products'] as $result) {
                $cstt = $result['id_customer'];
                $result3 = Helper::dbQuery("SELECT * FROM shopify_customers WHERE id_customer='$cstt'");
                if (count($result3) > 0) {
                    $get_data = $result3[0];
                    $fname = $get_data['firstname'];
                    $lname = $get_data['lastname'];
        ?>
                    <tr>
                        <td><input type="checkbox" name="select"></td>
                        <td><?php echo $result['id_customer'] . '-' . sprintf("%03s", $result['id']); ?></td>
                        <td><?php echo $fname . ' ' . $lname; ?></td>
                        <td><?php echo Helper::mysql_escape($result['title']); ?></td>
                        <td><?php echo $result['qty']; ?></td>
                        <td><?php echo $result['limit_product']; ?></td>
                        <td></td>
                        <td><?php echo $result['price'] . ' ' . $result['currency']; ?></td>
                        <td></td>
                        <td><?php echo $result['invoiced_weight']; ?></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>

                        <td><a href="javascript:void(0)" hidden_val="<?php echo $result['id']; ?>" id_customer="<?php echo $result['id_customer'] . '-' . sprintf("%03s", $result['id']); ?>" product_title="<?php echo Helper::mysql_escape($result['title']); ?>" id="openModal" value="<?php echo $result['id']; ?>" product_url="<?php echo $result['product_url']; ?>" product_price="<?php echo $result['price']; ?>" product_qty="<?php echo $result['qty']; ?>" product_weight="<?php echo $result['weight']; ?>" product_weight_type="<?php echo $result['weight_type']; ?>" product_length="<?php echo $result['length']; ?>" product_width="<?php echo $result['width']; ?>" product_height="<?php echo $result['height']; ?>" product_attributes="<?php echo $result['attributes']; ?>" additional_info="<?php echo $result['additional_info']; ?>" product_col="<?php echo $result['product_color']; ?>" product_size="<?php echo $result['product_size']; ?>">Update</a>
                            | &nbsp; <a class="delete_instock_product" href="javascript:void(0)" hidden_val="<?php echo $result['id']; ?>" id_customer="<?php echo $result['id_customer'] . '-' . sprintf("%03s", $result['id']); ?>">Delete</a>
                        </td>

                    </tr>
        <?php
                }
            }
        }
        ?>
    </tbody>
</table>

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
<script>
    // instock products ...

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

    $(document).on("click", ".delete_instock_product", function() {
        var id_customer = $(this).attr("hidden_val");
        var btn = this;
        var result = confirm("Want to delete?");

        if (result) {
            $.ajax({
                type: "POST",
                url: APP_URL + "/delete_wishlist_products_backend",
                data: {
                    id_customer: id_customer,
                },
                success: function(data) {
                    alert("Data Deleted Successfully");
                    $(btn).closest("tr").fadeOut("slow");
                    setTimeout(example6, 3000);
                },
                error: function(xhr, status, error) {
                    console.error(xhr);
                },
            });
        }
        // $.ajax({

        //     type: "POST",
        //     //data: {id_customer:id_customer},
        //     url: APP_URL+"/delete_wishlist_products_backenp"

        //     success: function(data){

        //         alert(data);
        //     }
        // });
    });

    $("select.cust_name2.form-control").on("change", function() {
        if ($(this).val().trim() != "") {
            $(".btn-delete_with_cst").show();
        } else {
            $(".btn-delete_with_cst").hide();
        }
        $("div#example6_filter input").val($(this).val()).trigger("keyup");
    });
    $(document).on("click", ".btn-delete_with_cst", function() {
        $.ajax({
            type: "POST",
            url: APP_URL + "/delete_wishlist_customer",
            data: "id=" + $(".cust_name2 option:selected").attr("data-id"),
            methos: "POST",
            dataType: "html",
            success: function(data) {
                if (window.location.search != "") {
                    window.location.href = window.location.href + "&nocache";
                } else {
                    window.location.href = window.location.href + "?nocache";
                }
            },
        });
    });
    // end instock products ...
</script>
