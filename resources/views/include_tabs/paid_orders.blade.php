<style>
    /* Paid Orders... */

    /* Modal Css Start */
    div.modal {
        z-index: 999;
    }

    .modal-backdrop {
        z-index: -1;
    }

    .modal {
        display: none;
        /* Hidden by default */
        position: fixed;
        /* Stay in place */
        z-index: 999999;
        /* Sit on top */
        left: 0;
        top: 0;
        opacity: 1;
        width: 100%;
        /* Full width */
        height: 100%;
        /* Full height */
        overflow: auto;
        /* Enable scroll if needed */
        background-color: rgb(0, 0, 0);
        /* Fallback color */
        background-color: rgba(0, 0, 0, 0.4);
        /* Black w/ opacity */
    }

    /* Modal Content/Box */
    .modal-content {
        background-color: #fefefe;
        margin: 25% auto;
        /* 15% from the top and centered */
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        /* Could be more or less, depending on screen size */
    }

    /* The Close Button */
    .close {
        color: #aaa;
        float: right;
        /* font-size: 28px; */
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    .modal-header {
        padding: 15px;
        border-bottom: 1px solid #e5e5e5;
    }

    .modal-body {
        position: relative;
        padding: 0px;
    }

    div#myModal .modal-dialog .modal-content .modal-body {
        display: inline-block;
        width: 100%;
    }

    div#myModal .modal-dialog .modal-header {
        background-color: #e58b97;
        text-align: center;
    }

    div#myModal .modal-dialog .modal-header h4.modal-title {
        margin: 0;
        color: #fff;
        font-size: 19px;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
        border: 0 !important;
        box-shadow: 0 0 0 transparent;
        outline: none;
    }

    div#myModal .modal-dialog .modal-header button.close {
        background-color: transparent;
        border: 0;
        color: #fff;
        font-size: 20px;
        top: -1px;
        margin-top: 0;
        position: relative;
        right: 0;
        line-height: normal;
        vertical-align: top;
        opacity: 1;
    }

    .choose-cake h5 {
        background-color: #a50202;
        width: 35px;
        margin: 6px auto 5px;
        height: 35px;
        border-radius: 90px;
        line-height: 35px;
        color: #ffff;
        font-size: 17px;
    }

    .choose-cake h6 {
        font-size: 14px;
    }

    .choose-cake p {
        color: #999;
        font-size: 12.9px;
        line-height: normal;
    }

    .choose-cake h6 {
        font-size: 14px;
        margin: 0 0 4px 0;
    }

    img.icon-imh {
        height: 28px;
    }

    .modal-footer {
        padding: 15px;
        text-align: center;
        border-top: 1px solid #e5e5e5;
        display: inline-block;
        width: 100%;
        margin-top: 10px;
    }

    div#myModal .modal-dialog .modal-content {
        width: 100%;
        text-align: center;
        padding: 0;
        border-radius: 0;
    }

    div#myModal .modal-dialog button.btn.btn-default {
        background-color: #393f52 !important;
        border-radius: 0;
        border: 0;
        color: #fff;
        padding: 10px 25px;
        font-size: 14px;
    }

    .pwiFormBox {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }

    .pwiFormLeft {
        width: 150px;
        font-size: 14px;
        font-weight: 600;
    }

    .pwiFormRight {
        width: calc(100% - 150px);
        padding-left: 5px;
    }

    .pwiFormRight input.pwiFormInput,
    .pwiFormRight select.pwiFormInput {
        height: 45px;
        width: 100%;
        padding: 10px;
        font-size: 16px;
        border: 1px solid #000;
    }

    .pwiFormRight.pwiFR2Input input.pwiFormInput:last-child {
        border-left: none;
    }

    .pwiFormRight.pwiFR2Input {
        display: flex;
    }

    .pwifrSubTitle {
        font-size: 12px;
    }

    .pwiFormRight .pwifrSubTitle {
        margin-bottom: 5px;
        display: inline-block;
    }

    .mb-0 {
        margin-bottom: 0 !important;
    }

    .taRight {
        text-align: right !important;
    }

    .pwiFormButton {
        background: #000;
        border: none;
        font-size: 14px;
        font-weight: 600;
        text-transform: uppercase;
        color: #fff;
        padding: 10px 20px;
        cursor: pointer;
    }

    .pwiFormButton:hover {
        background: #222;
    }

    /* color swatch start */
    .pwiColorBox input[type="radio"] {
        display: none;
    }

    .pwiColorBox input[type="radio"]:checked+label span {
        transform: scale(1);
        border: 5px solid rgba(0, 0, 0, 0.3);
    }

    .pwiColorBox label {
        display: inline-block;
        width: 45px;
        height: 45px;
        margin-right: 2px;
        cursor: pointer;
        margin-bottom: 0px;
    }

    .pwiColorBox label span {
        display: block;
        width: 100%;
        height: 100%;
    }

    .pwiColorBox label span.red {
        background: #db2828;
    }

    .pwiColorBox label span.orange {
        background: #f2711c;
    }

    .pwiColorBox label span.yellow {
        background: #fbbd08;
    }

    .pwiColorBox label span.olive {
        background: #b5cc18;
    }

    .pwiColorBox label span.green {
        background: #21ba45;
    }

    .pwiColorBox label span.teal {
        background: #00b5ad;
    }

    .pwiColorBox label span.blue {
        background: #2185d0;
    }

    .pwiColorBox label span.violet {
        background: #6435c9;
    }

    .pwiColorBox label span.purple {
        background: #a333c8;
    }

    .pwiColorBox label span.pink {
        background: #e03997;
    }

    div#myModal .modal-dialog .modal-content {
        text-align: inherit !important;
    }

    .all_table_data tr>th {
        background: #f0f0f0;
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

    td.app_price {
        text-align: right;
    }

    .leftSideBarMA .lsbMAtitle {
        font-size: 24px;
        margin-top: 0;
    }

    .leftSideBarMA ul>li>a {
        border-top: 1px solid #ddd;
        border-left: 1px solid #ddd;
        border-right: 1px solid #ddd;
        display: block;
        padding: 12px 15px;
        font-weight: 600;
        color: #333;
        text-decoration: none;
    }

    .leftSideBarMA ul>li:last-child>a {
        border-bottom: 1px solid #ddd;
    }

    .leftSideBarMA ul>li>a:hover,
    .leftSideBarMA ul>li.active>a {
        background: #f0f0f0;
    }

    .leftSideBarMA ul>li>a span {
        float: right;
        color: #8d8d8d;
    }

    .leftSideBarMA ul>li>a {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .all_table_data>tbody>tr>td:nth-child(2)>a {
        display: flex;
        white-space: normal;
        min-width: 190px;
        align-items: center;
    }

    .page-width {
        padding: 0px !important;
    }

    .one-quarter {
        width: 20%;
    }

    /*  New CSS */
    .wishlistproduct_container {
        padding-left: 15px;
        padding-right: 15px;
    }

    .wishlistproduct_container h6 {
        font-weight: bold;
        color: #666;
        margin-top: 10px;
        font-size: 12px;
    }

    .wishlistproduct_container .form-control {
        font-size: 12px;
    }

    .wishlistproduct_container .form-control.product_url {
        color: #d38e9b !important;
        font-weight: 400;
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

    .textFooterModel p {
        color: #3a3e53;
        font-size: 12px;
        line-height: normal;
        margin-bottom: 10px;
    }

    div#myModal .modal-dialog .modal-header h4.modal-title {
        font-weight: bold;
    }

    .wishlistproduct_container .form-control.product_url::placeholder {
        color: #d38e9b;
        opacity: 1;
    }

    .wishlistproduct_container .form-control.product_url:-ms-input-placeholder {
        color: #d38e9b;
    }

    .wishlistproduct_container .form-control.product_url::-ms-input-placeholder {
        color: #d38e9b;
    }

    .wishlistproduct_container .form-control::placeholder {
        font-weight: bold;
    }

    .wishlistproduct_container .form-control:-ms-input-placeholder {
        font-weight: bold;
    }

    .wishlistproduct_container .form-control::-ms-input-placeholder {
        font-weight: bold;
    }

    .fcHaveIcon {
        position: relative;
    }

    .fcHaveIcon .fcIcon {
        position: absolute;
        right: 7px;
        top: 10px;
        color: #666;
    }

    .fcDimensions {
        display: flex;
        margin-left: 20px;
        float: left;
        align-items: center;
    }

    .fcDimensions h6 {
        font-weight: normal;
        color: #666;
    }

    .fcDimensions input {
        width: 60px;
        margin-left: 10px;
    }

    .textFooterModel {
        margin-top: 15px;
    }

    .textFooterModel p i {
        background: #5f5f5f;
        padding: 4px 8px;
        border-radius: 20px;
        text-align: center;
        color: #fff;
    }

    .textFooterModel p a {
        color: #3a3e53;
        text-decoration: underline;
    }

    label.quantity_desiredtext {
        font-weight: 400;
        border-bottom: 1px solid;
        margin-bottom: 10px;
        padding-bottom: 10px;
    }

    /* End Paid Orders */
</style>
<h3>Paid ORDERS</h3>
<div class="tab">
    <button class="tablinks" onclick="openCity(event, 'by_customer')">By Customer</button>
    <button class="tablinks" onclick="openCity(event, 'by_order')">By Orders</button>
</div>

<div id="by_customer" class="tabcontent">
    <table id="example6" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer Name</th>
                <th>Product</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = 'SELECT cc.id_cart, sc.firstname, sc.lastname FROM customer_cart as cc INNER JOIN shopify_customers as sc ON (sc.id_customer=cc.id_customer) GROUP BY cc.id_cart';
            $res = $con->query($sql);
            if ($res->num_rows > 0) {
                foreach ($res as $k => $result) {
                    $pro_price = array();
                    $inner_join = 'SELECT cpw.id, cpw.product_url, cpw.product_image, cpw.title, cpw.price, cpw.qty, cpw.currency, cpw.length, cpw.width, cpw.height, cpw.id_customer FROM `customer_cart` as cc INNER JOIN `customer_product_wishlist` as cpw ON (cpw.id=cc.id_product) WHERE cc.id_cart = "' . $result['id_cart'] . '"';
                    $products = $con->query($inner_join);
                    if ($products->num_rows > 0) {
                        $counter = 1;
                        foreach ($products as $key => $product) {
                            $pro_price[] = $product['price'];    ?>
                            <tr>
                                <td><?php echo $result['id_cart']; ?></td>
                                <td><?php echo @$result['firstname'] . ' ' . @$result['lastname']; ?></td>
                                <td>
                                    <ul>
                                        <?php echo $product['title']; ?>
                                    </ul>
                                </td>
                                <td><?php echo $product['price'] . ' ' . $product['currency']; ?></td>
                                <td><a href="javascript:void(0)" id="update_product" value="<?php echo $product['id']; ?>" url="<?php echo $product['product_url']; ?>" logo="<?php echo $product['product_image']; ?>" title="<?php echo $product['title']; ?>" price="<?php echo $product['price']; ?>" qty="<?php echo $product['qty']; ?>" length="<?php echo $product['length']; ?>" width="<?php echo $product['width']; ?>" height="<?php echo $product['height']; ?>" customer_id="<?php echo $product['id_customer']; ?>">Update</a></td>
                            </tr>
            <?php
                        }
                    }
                    $counter++;
                }
            }
            ?>
        </tbody>
    </table>
</div>


<!-- weight="'.$billable_weight.'"
price="'.number_format($row['price'],2).'"
length="'.$row['length'].'"
width="'.$row['width'].'"
height="'.$row['height'].'" -->

<div id="by_order" class="tabcontent">
    <?php
    $join1 = 'SELECT sc.firstname, sc.lastname, cc.id_cart FROM `customer_cart` as cc INNER JOIN `shopify_customers` as sc ON (cc.id_customer=sc.id_customer AND cc.status="2") GROUP BY cc.id_cart';
    $res1 = $con->query($join1);
    if ($res1->num_rows > 0) {
        $counter = 1;
        foreach ($res1 as $result) {  ?> <br><br>
            <div class="col" style="border: 1px solid;width: 100%;max-width: 100%; margin-top: 60px;">Order ID : <?php echo $result['id_cart']; ?> | <a href="#">Mark order Shipped</a> &nbsp; &nbsp; &nbsp;<a href="#">Mark Order Delivered</a></div>
            <table class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Customer Name</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $join = 'SELECT sc.id, sc.title, sc.price, cc.id_cart FROM `customer_product_wishlist` as sc INNER JOIN `customer_cart` as cc ON (cc.id_product=sc.id AND cc.status="2") GROUP BY cc.id';
                    $res = $con->query($join);
                    if ($res->num_rows > 0) {
                        while ($row = $res->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $result['firstname'] . ' ' . $result['lastname']; ?></td>
                                <td>
                                    <ul>
                                        <li><?php echo $row['title']; ?></li>
                                    </ul>
                                </td>
                                <td><?php echo $row['price']; ?></td>
                                <td><a href="#">Update</a></td>
                            </tr>
                    <?php    }
                    }
                    ?>
                </tbody>
            </table>
    <?php
            $counter++;
        }
    } ?>
</div>
<div id="myModalUpdate" class="modal">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">MA DEMANDE D'AJOUT PRODUIT</h4>
            </div>
            <div class="col-md-12 choose-cake">
                <div class="modal-body">
                    <form class="product_info_edit">
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
                                        <input class="pwiFormInput form-control noBorder" type="text" name="product_color" placeholder="Informations supplémentaires (ex : couleur)" />
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
                                    <div class="col-lg-3 col-md-3 col-sm-12">
                                        <label class="quantity_desiredtext">Quantité désirée</label>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-12">
                                        <input class="form-control" type="number" name="product_qty" id="product_qty" min="1" size="1" value="1" placeholder="Quantité désirée" />
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-sm-12">
                                        <h6>DÉTAILS D'EXPÉDITION &nbsp; <i class="fa fa-caret-down" aria-hidden="true"></i></h6>
                                        <div class="row">
                                            <div class="col-md-2 col-sm-12 fcHaveIcon">
                                                <input class="pwiFormInput form-control noBorder" type="text" name="product_weight" min="1" size="1" value="1" placeholder="Poids" />
                                                <span class="fcIcon">kg</span>
                                            </div>
                                            <div class="fcDimensions">
                                                <h6>Dimensions du colis L x I x h (en cm)</h6>
                                                <input class="pwiFormInput form-control" type="number" name="order_length" id="product_length" min="1" size="1" value="1" placeholder="10" />
                                                <input class="pwiFormInput form-control" type="number" name="order_width" id="product_width" min="1" size="1" value="1" placeholder="10" />
                                                <input class="pwiFormInput form-control" type="number" name="order_height" id="product_height" min="1" size="1" value="1" placeholder="10" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 textFooterModel">
                                        <p>Retrouvez votre produit dans l'onglet <strong><em>Mes produits</em></strong></p>
                                        <p><i class="fa fa-info"></i> Pour ajouter directement vos produits depuis Ie web grace å '"extension Google, <a href="#">suivez Ie guide</a>.</p>
                                        <p>Besoin d'aide Q <a href="#">Contactez notre service client</a> et nous vous régx)ndrons dans les meilleurs délais.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="updateToWishlist()">METTRE À JOUR MON PRODUIT</button>
            </div>
        </div>
    </div>
</div>
<script>
    // Paid Orders...

    $(document).on("click", "#update_product", function() {
        console.log("Clicked..!");
        var modal = document.getElementById("myModalUpdate");
        modal.style.display = "block";
        var iD = $(this).attr("value");
        var product_url = $(this).attr("url");
        var product_logo = $(this).attr("logo");
        var product_title = $(this).attr("title");
        var product_weight = $(this).attr("weight");
        var product_price = $(this).attr("price");
        var product_qtYY = $(this).attr("qty");
        var length = $(this).attr("length");
        var width = $(this).attr("width");
        var height = $(this).attr("height");
        var id_customer = $(this).attr("customer_id");
        $("#product_url").val(product_url);
        $("#product_title").val(product_title);
        $("#product_qty").val(product_qtYY);
        $("#product_price").val(product_price);
        $("#hidden_val").val(iD);
        $("#product_length").val(length);
        $("#product_width").val(width);
        $("#product_height").val(height);
        $("#id_customer").val(id_customer);
    });
    $(".close").on("click", function() {
        console.log("CLose Clicked..!");
        $(".modal").css("display", "none");
    });

    function updateToWishlist() {
        $.ajax({
            type: "POST",
            url: APP_URL + "/update_customer_product_wishlist",
            data: $(".product_info_edit").serialize(),
            methos: "POST",
            dataType: "html",
            success: function(data) {
                //console.log(data)
                //return false;
                $(".all_wishlist_products").html(data);
                $('.product_info input[type="text"]').val("");
                $(".modal").css("display", "none");
                //location.reload();
                window.location.href =
                    window.location.origin +
                    window.location.pathname +
                    "?tab=" +
                    $("ul.nav.nav-tabs li.active").data("tab");
                return false;
            },
        });
    }
    // End Paid Orders...
</script>
