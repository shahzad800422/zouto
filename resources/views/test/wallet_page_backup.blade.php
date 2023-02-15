
@extends('layouts.app')

@section('content')

<?php
$id = $_GET['id_customer'];
$ris = Helper::dbQuery("SELECT transaction.created, transaction.id_customer, transaction.paid_amount FROM transaction INNER JOIN shopify_customers ON transaction.id_customer = shopify_customers.id_customer where shopify_customers.id_customer=$id GROUP BY transaction.id_cart");


$result = Helper::dbQuery("SELECT * FROM shopify_customers where id_customer=$id ORDER BY id DESC");
$get_data = $result[0];

$price_que = Helper::dbQuery('SELECT SUM(price) AS value_sum FROM customer_product_wishlist WHERE id_customer = "'.$id.'" AND product_status="4" AND is_archived IS NOT NULL  ORDER BY customer_product_wishlist.id DESC');
$credit_sum = number_format($price_que[0]['value_sum'],2);
$result3 = Helper::dbQuery('SELECT * FROM customer_product_wishlist where id_customer="'.$_GET['id_customer'].'" AND status = 1 and instock = 1 AND is_archived IS NULL');

$wish_price = 0;
foreach ($result3 as $res) {
    $wish_price +=  (float)$res['price'];
}
$id = $_GET['id_customer'];
$result_p = Helper::dbQuery("SELECT * FROM transaction WHERE id_customer = $id ORDER BY id DESC");

$pr = 0;
foreach($result_p as $rows_p)
{
    $ct = $rows_p['id_cart'];
    $result_w = Helper::dbQuery("SELECT * FROM transaction_wallet_info WHERE id_cart = $ct ORDER BY id DESC");

    if($rows_p['payment_type'] == 'products'){
            $pr += $rows_p['paid_amount'];
    }

        foreach($result_w as $rows_w)
    {
        if(!empty($rows_w['de_client'])){
            $pr -= $rows_w['de_client'];
        }
        if(!empty($rows_w['re_client'])){
            $pr += $rows_w['re_client'];
        }
    }
} ?>

<style>
    .row{
        margin: 0;
    }
    .date {
        width: 145px;
    }
    .stripe {
        width: 95px;
    }
    .type {
        width: 85px;
    }
    .amount {
        width: 100px;
    }
    .modal-body {
        width: 80%;
        margin: auto;
        height: 100px;
        border: 2px solid;
        border-radius: 32px;
    }
    .modal-header{
        border-bottom: unset;
    }
    .modal-footer{
        border-top: unset;
    }
    .modal-body{
        padding: 15px 0;
        min-height: 250px;
    }
    input.ajouter, input.client, input.re_client, input.date {
        border: unset;
        border-bottom: 1px solid #000;
        width: 90%;
    }
    button#validate {
        float: right;
        margin-right: 30px;
        border: unset;
        font-weight: bold;
    }
    button.pop_open {
        padding: unset;
        border: unset;
        background: unset;
    }
    th {
        /*border: 1px solid #000 !important;*/
    }
    .pros:hover .pro_name{
        display: block !important;
    }
</style>


    <section>

             <div class="row">
                 <div class="col-md-3" style="padding-top: 20px;text-align: center;">
                     <a href="{{ env('APP_URL') }}/index2_customer?id=<?php echo $_GET['id_customer']; ?>&cart=<?php echo $_GET['cart'] ?>&sum=<?php echo $_GET['sum'] ?>">< arrière</a>
                 </div>
                 <div class="col-md-6" style="margin: auto;float: unset;">
                     <?php
                    $sql_a = 'SELECT * FROM matching_cost where id_cart="'.$_GET['cart'].'" AND id_customer="'.$_GET['id_customer'].'" ORDER BY id DESC';
                    $result_a = $con->query($sql_a);
                    $get_data_a = mysqli_fetch_assoc($result_a);
                ?>
                <!--<div class="col-md-4" style="border: 2px solid;border-radius: 30px;padding-right: 50px;margin: 30px;">-->
                <!--    <div class="">-->
                <!--        <h4>User Paid<span class="user_paid" style="float: right">0€</span></h4>-->
                <!--        <h4 style="color: blue">Cost<span class="cost" style="float: right;color: #000"><?php echo $get_data_a['cost'] ?>€</span></h4>-->
                <!--        <hr style="border-top: 2px solid #000">-->
                <!--        <h4>Balance<span class="balance" style="float: right">-<?php echo $get_data_a['cost'] ?>€</span></h4>-->
                <!--    </div>-->
                <!--</div>-->
                 <div class="col-md-12" style="display: flex;justify-content: space-between">
                     <div style="padding: 10px 0"><?php echo $get_data['firstname'].' '.$get_data['lastname']; ?></div>
                     <div style="background: yellow;font-weight: bold;padding: 10px;"><?php echo $pr;?>€</div>
                 </div>
                 <div class="col-md-12">
                    <?php
                    $result2 = Helper::dbQuery("SELECT * FROM transaction WHERE id_customer = $id ORDER BY id DESC"); ?>
                     <table class="table">
                         <thead>
                             <th style="width: 145px;cursor: pointer" onclick="location.reload()">Transaction date</th>
                             <th style="width: 95px;">Stripe ID</th>
                             <th style="width: 85px;">Type</th>
                             <!--<th></th>-->
                             <th style="width: 100px;">Amount</th>
                             <th style="width: 100px;">Debit</th>
                             <th style="width: 100px;">Credit</th>
                             <!--<th></th>-->
                             <th>Balance</th>
                         </thead>
                         </table>
                         <div style="display: flex">
                         <div class="date">
                           <?php
                           $pri = 0;
                            foreach($result2 as $rows2){
                                $ct = $rows2['id_cart'];
                                $result_w = Helper::dbQuery("SELECT * FROM transaction_wallet_info WHERE id_cart = $ct ORDER BY transaction_date DESC"); ?>

                             <div style="display: flex">
                                 <div><button class="pop_open ddte" style="width: 145px;" data-cart="<?php echo $rows2['id_cart']; ?>" data-date="<?php echo date("d/m/Y", strtotime($rows2['created']));?>"><?php echo date("d/m/Y", strtotime($rows2['created']));?></button></div>
                                 <div><div style="width: 95px;"><?php echo $rows2['id_cart']; ?></div></div>
                                 <div><div style="width: 85px;"><?php echo $rows2['payment_type']; ?></div></div>

                                     <?php if($rows2['payment_type'] == 'products'){ ?>
                                     <div><div style="width: 200px"></div></div>
                                 <div>
                                     <div style="width: 100px;" class="amt" data-amt="<?php echo $rows2['paid_amount']; ?>"><?php echo $rows2['paid_amount']; ?>€</div></div>
                                     <?php }else{ ?>
                                     <div><div style="width: 100px"></div></div>
                                 <div>
                                     <div style="width: 200px;" <?php if($rows2['payment_type'] == 'products'){ ?>class="amt" data-amt="<?php echo $rows2['paid_amount']; ?>"<?php } ?>><?php echo $rows2['paid_amount']; ?>€</div></div>
                                     <?php } ?>
                                 <!--<div><div style="width: 100px;"></div></div>-->
                                 <!--<div><div style="width: 100px;"></div></div>-->
                                 <div class="pri"></div>
                             </div>

                             <?php
                             foreach($result_w as $rows_w)
                                {
                                    if(!empty($rows_w['de_client'])){
                                        $amt = $rows_w['de_client'];
                                    }else{
                                        $amt = $rows_w['re_client'];
                                    }
                                    ?>
                                    <div style="display: flex">
                                         <div><div style="width: 145px;text-align: center;cursor: pointer" data-id_cart="<?php echo $rows_w['id_cart']; ?>" data-date="<?php echo $rows_w['transaction_date'];?>" data-id="<?php echo $rows_w['id']; ?>" data-ajouter="<?php echo $rows_w['ajouter']; ?>" data-de_client="<?php echo $rows_w['de_client']; ?>" data-re_client="<?php echo $rows_w['re_client']; ?>" class="pop_edit ddte"><?php echo $rows_w['transaction_date'];?></div></div>
                                         <div><div style="width: 95px;"></div></div>
                                         <div><div class="pros" title="<?php echo $rows_w['ajouter']; ?>" data-id_cart="<?php echo $rows_w['id_cart']; ?>" data-date="<?php echo $rows_w['transaction_date'];?>" data-id="<?php echo $rows_w['id']; ?>" data-ajouter="<?php echo $rows_w['ajouter']; ?>" data-de_client="<?php echo $rows_w['de_client']; ?>" data-re_client="<?php echo $rows_w['re_client']; ?>" class="pop_edit" style="width: 85px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;cursor: pointer;"><?php echo $rows_w['ajouter']; ?>
                                         <?php if(!empty($rows_w['products'])){
                                            $pros = explode(",",$rows_w['products']);
                                            $pro_name = '';
                                            foreach($pros as $pr){
                                                $result_p = Helper::dbQuery("SELECT * FROM customer_product_wishlist where id=$pr ORDER BY id DESC");
                                                $get_data_p = $result_p[0];
                                                $product_name = $get_data_p['title'];
                                                $pro_name .= "<span>$product_name</span><br>";
                                            }
                                          ?>
                                         <div class="pro_name" style="display: none;position: absolute;margin-top: 20px;background: #fff;padding: 10px 20px;box-shadow: 0 0 4px 1px #838282;">
                                             <?php echo $pro_name; ?>
                                         </div>
                                         <?php

                                         }
                                         ?>
                                         </div></div>
                                         <div><div style="width: 100px;"></div></div>
                                         <?php if(!empty($rows_w['products'])){?>
                                              <div></div><div><div style="width: 200px;" class="amt sub" data-amt="<?php echo $amt; ?>"><?php echo $amt; ?>€</div></div>
                                         <?php }else if(!empty($rows_w['de_client'])){ ?>
                                         <div><div style="width: 200px;" class="amt sub" data-amt="<?php echo $amt; ?>"><?php echo $amt; ?>€</div></div>
                                         <?php }else if(!empty($rows_w['re_client'])){ ?>
                                         <div><div style="width: 100px;"></div></div><div><div style="width: 100px;" class="amt" data-amt="<?php echo $amt; ?>"><?php echo $amt; ?>€</div></div>
                                         <?php }else{ ?>
                                         <!--<div><div style="width: 100px;"></div></div>-->
                                         <?php } ?>
                                         <div class="pri"></div>
                                    </div>
                                    <?php
                                }
                                }
                                ?>
                            </div>
                            </div>

                 </div>
             </div>
             </div>
    </section>


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
                <h4><input class="date" name="transaction_date"></h4>
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

<!--Edit Name-->
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
      <button type="button" class="btn btn-default close" data-dismiss="modal" id="closeid1">Close</button>
    </div>
  </div>
</div>
</div>


@endsection

<script>
$(document).ready(function(){
    var price = 0;
    $($(".amt").get().reverse()).each(function() {
        if($(this).hasClass('sub')){
            price -= parseFloat($(this).data('amt'));
        }else{
            price += parseFloat($(this).data('amt'));
        }
        // console.log(price)
        $(this).parent().next().html(price.toFixed(2)+'€')
    });
})
$('#validate').click(function(e){
	e.preventDefault();
    $.ajax({
      type: "POST",
      url: "{{ env('APP_URL') }}/wallet_submit.php",
      data: $('.wallet_form').serialize(),
      methos: "POST",
      dataType:'html',
      success: function (data) {
        // alert('Information added successfully.')
        $('#myModal').hide()
        $('[name="id_cart"]').val('')
        $('[name="ajouter"]').val('')
        $('[name="de_client"]').val('')
        $('[name="re_client"]').val('')
        location.reload()
      },
    });
})
$('#edit_validate').click(function(e){
	e.preventDefault();
    $.ajax({
      type: "POST",
      url: "{{ env('APP_URL') }}/wallet_submit_update.php",
      data: $('.wallet_form_update').serialize(),
      methos: "POST",
      dataType:'html',
      success: function (data) {
        location.reload();
      },
    });
})
$(document).on('click', '.pop_open', function(){
    $('.date').val($(this).data('date'))
    $('#id_cart').val($(this).data('cart'))
    var modal = document.getElementById("myModal");
    modal.style.display = "block";
})
$(document).on("click", ".close" , function(e) {
	e.preventDefault();
	var modal = document.getElementById("myModal");
    modal.style.display = "none";
});
</script>

<script>
// $('#delete').click(function(){
$(document).on('click', '#delete', function(){
    // console.log('weazds')
    // e.preventDefault();
    $.ajax({
      type: "POST",
      url: "{{ env('APP_URL') }}/wallet_submit_delete.php",
      data: {id: $('#delete').data('id')},
      methos: "POST",
      dataType:'html',
      success: function (data) {
        location.reload();
      },
    });
})
$(document).on('click', '.pop_edit', function(){
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
$(document).on("click", "#closeid1" , function(e) {
	e.preventDefault();
	var modal = document.getElementById("myModal1");
    modal.style.display = "none";
});
</script>

<div class="col-md-12" style="text-align: center;padding: 30px 0;font-size: 18px;font-weight: bold;">
    <!--<a href="{{APP_URL}}/index2_customer?id=<?php echo $_GET['id_customer']; ?>&cart=<?php echo $_GET['cart'] ?>&sum=<?php echo $_GET['sum'] ?>">< arrière</a>-->
</div>
