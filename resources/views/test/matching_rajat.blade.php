<?php
header('Access-Control-Allow-Origin: *');
include('../connection.php');

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

// capture amount
if (isset($_POST['matching_capture_max_amount']) && (isset($_POST['is_ajax'])) ) {

    $id = (isset($_POST['id'])) ? $_POST['id'] : '';
    $pi_id = (isset($_POST['pi_id'])) ? $_POST['pi_id'] : '';
    $paid_amount = (isset($_POST['paid_amount'])) ? $_POST['paid_amount'] : 0;
    $matching_capture_max_amount = (isset($_POST['matching_capture_max_amount'])) ? $_POST['matching_capture_max_amount'] : 0;
    $paid_amount = ( $paid_amount > $matching_capture_max_amount ) ? $matching_capture_max_amount : $paid_amount;

    require_once('../stripe-php-master/init.php');

    //set stripe secret key and publishable key
    $stripe = array(
        "secret_key" => "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",
        "publishable_key" => "pk_live_51IJyM5EyZ6v0AHKDkUva2mpmvMjIzma2wD94qrEWpGwmqUd4IvZ0OAXDo8J8hL9Hv5ImFXhoHW8LHYs6oisjCofJ00gCXZ5qyt"
    );

    // for localhost
    if ($_SERVER['SERVER_NAME'] == 'localhost') {
        $stripe = array(
            "secret_key" => "sk_test_39dKrhpTK1xhgFjroapGN7P6",
            "publishable_key" => "pk_test_XCdFmeLCT7XkNSC5lXtQpgwi"
        );
    }
    \Stripe\Stripe::setApiKey($stripe['secret_key']);

    try {

        $intent = \Stripe\PaymentIntent::retrieve($pi_id);
        $intent->capture(['amount_to_capture' => ($paid_amount*100)]);

        if( isset($intent->id) ){

            $paid_amount = ( $intent->status == 'succeeded' ) ? $paid_amount : $matching_capture_max_amount;
            $txn_id = ( isset( $intent->charges->data[0]->balance_transaction ) )? ($intent->charges->data[0]->balance_transaction):'';
            $amount_refunded = ( isset( $intent->charges->data[0]->amount_refunded ) )? (($intent->charges->data[0]->amount_refunded)) / 100 :0;

            $update_sql = "UPDATE transaction SET
                            paid_amount = '$paid_amount',
                            payment_status = '{$intent->status}',
                            txn_id = '{$txn_id}',
                            amount_refunded = '{$amount_refunded}'
                            WHERE `transaction`.`id` = '{$id}'";
            $result = $con->query($update_sql);
            echo json_encode([
                'succeeded' => true,
                'succeeded_data' => $intent,
                'amount_received' => ($intent->amount_received/100),
                'amount_refunded' => $amount_refunded,
            ]);
        }else{
            echo json_encode([
                'error' => true,
                'error_msg' => 'Something went wrong.',
            ]);
        }
    } catch (Exception $ex) {
        echo json_encode([
            'error' => true,
            'error_msg' => $ex->getMessage(),
        ]);
    }
    // echo '<pre>'; print_r( $_SERVER ); echo '</pre>';
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Matching Page</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

		<link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/dataTables.jqueryui.min.css">
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/scroller/2.0.3/css/scroller.jqueryui.min.css">

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<style>
		table {
		  font-family: arial, sans-serif;
		  border-collapse: collapse;
		  width: 100%;
		}

		td, th {
		  border: 1px solid #dddddd;
		  text-align: left;
		  padding: 8px;
		}

		tr:nth-child(even) {
		  background-color: #dddddd;
		}
		</style>
	</head>
<body>
	<div class="container"><h2></h2></div>
	<?php
	  if(isset($_GET['uploaded_csv_message'])) {
        if( $_GET['uploaded_csv_message'] == 'uploaded_csv') { ?>
            <div class="alert alert-success">Thank You! Your Data has been updated successfully!</div>
        <?php } }?>
	<div id="exTab2" class="container">
		<ul class="nav nav-tabs" style="display: none">
			<li class="active" data-tab='8'><a href="#8" data-toggle="tab">Wish-lists</a></li>
			<li data-tab='1'><a  href="#1" data-toggle="tab">In Stock Products</a></li>
			<li data-tab='14'><a href="#14" data-toggle="tab">Parcel</a></li>
			<!--<li><a href="#20" data-toggle="tab">Invoiced Parcel</a></li>-->
			<li data-tab='4'><a href="#4" data-toggle="tab">Shipped</a></li>
			<li data-tab='12'><a href="#12" data-toggle="tab">Upload EXCEL</a></li>
			<li data-tab='10'><a href="#10" data-toggle="tab">Customer Info</a></li>
			<li data-tab='21'><a href="#21" data-toggle="tab">Colisrael Parcels</a></li>
			<li data-tab='22'><a href="#22" data-toggle="tab">Personal Parcels</a></li>
			<li data-tab='23'><a href="#23" data-toggle="tab">Archived Products</a></li>
			<li data-tab='24'><a href="#24" data-toggle="tab">Wallet Info</a></li>
		</ul>


		<div class="tab-content ">
			<div class="tab-pane active" id="1">
				<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

                <style>
                  div#myModal {
                    overflow: auto;
                }
                .btn-delete, .btn-paid, .btn-parcel, .btn-join-parcel, .btn-supp, .btn-hs, .btn-arc{
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
                    display:flex;
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
                @media (min-width: 1200px){
                    .container {
                        width: 100%;
                    }
                }
                .matching_capture_process_info{
                    width: 100%;
                    height: 15px;
                    font-style: italic;
                    clear: both;
                    text-align: -webkit-center;
                }
                .matching_capture_process_info p{
                    color: #585858;
                    width: fit-content;
                    background: #ffeb3b;
                    padding: 1px 6px;
                    border-radius: 4px;
                    border: 1px solid #d1ca8f;
                }
                .matching_capture_process_info p[data-type="error"]{
                  color: black;
                  background: #ffe0e0;
                }
                .matching_capture_process_info p[data-type="succeeded"]{
                  color: black;
                  background: #dbffdb;
                }

                </style>
                <div class="col-md-12" style="text-align: center;padding: 0;font-size: 18px;font-weight: bold;">
                   <a href="{{ env('APP_URL') }}/wallet_new?id_customer=<?php echo $_GET['id']; ?>">Go to Wallet</a>
                </div>
                <?php
                    $sql = 'SELECT * FROM matching_cost where id_cart="'.$_GET['cart'].'" AND id_customer="'.$_GET['id'].'" ORDER BY id DESC';
                    $result = $con->query($sql);
                    $get_data = mysqli_fetch_assoc($result);
                ?>
                <div class="col-md-2" style="border: 2px solid;border-radius: 30px;padding-right: 50px;margin: 30px;">
                    <div class="">
                        <h4>User Paid<span class="user_paid" style="float: right">0€</span></h4>
                        <h4 style="color: blue">Cost<span class="cost" style="float: right;color: #000"><?php echo $get_data['cost'] ?>€</span></h4>
                        <hr style="border-top: 2px solid #000">
                        <h4>Balance<span class="balance" style="float: right">-<?php echo $get_data['cost'] ?>€</span></h4>
                    </div>
                </div>

                <button type="button" class="btn btn-parcel" name="button" style="background: #fff"><img src="{{ env('APP_URL') }}/images/new_index/link.png"></button>
                <button type="button" class="btn btn-join-parcel" name="button">Join Parcel</button>

                <div style="float:right"><button type="button" class="btn" id="cost_btn" style="border: 1px solid">cost</button></div>

                <?php
                $sql_2 = 'SELECT * FROM transaction where id_cart="'.$_GET['cart'].'" AND id_customer="'.$_GET['id'].'" ORDER BY id DESC LIMIT 1';
                $result_2 = $con->query($sql_2);
                $get_data_2 = mysqli_fetch_assoc($result_2);
                if( $get_data_2 && ($get_data_2['amount_capturable'] > '0')){ ?>

                  <div style="float: left;width: 100%;padding: 20px 0;text-align: center;">
                    <form id="matching_capture_amount_form" action="<?= $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] ?>" method="POST">
                      <input type="hidden" name="id" value="<?=$get_data_2['id']?>">
                      <input type="hidden" name="pi_id" value="<?=$get_data_2['pi_id']?>">
                      <input type="hidden" name="payment_status" value="<?=$get_data_2['payment_status']?>">
                      <input type="hidden" name="matching_capture_max_amount" value="<?=$get_data_2['amount_capturable']?>">
                      <div class="form-group" style="display: inline-flex;height: 34px;margin: 5px 0;">
                        <label style="line-height: 34px;">Amount to capture: </label>
                        <input style="width: fit-content;margin: 0 5px;" class="form-control" type="number" name="paid_amount" step="0.01" min="0" max="<?=$get_data_2['amount_capturable']?>" value="<?=$get_data_2['amount_capturable']?>" <?php if($get_data_2['payment_status'] != 'requires_capture'){ echo 'readonly'; } ?> >
                        <input class="btn btn-primary" type="submit" value="Capture" <?php if($get_data_2['payment_status'] != 'requires_capture'){ echo 'disabled'; } ?>>
                      </div>
                      <div class="matching_capture_process_info">
                          <?php if( ($get_data_2['payment_status'] == 'succeeded') && ($get_data_2['amount_capturable'] > '0') && ( $get_data_2['payment_status'] != 'requires_capture' )){ ?>
                            <p data-type="succeeded">Captured Amount: <strong><?=($get_data_2['amount_capturable']-$get_data_2['amount_refunded'])?></strong>, Refund Amount: <strong><?=$get_data_2['amount_refunded']?></strong></p>
                          <?php } ?>
                      </div>
                    </form>
                  </div>
                  <?php
                  // echo '<pre>'; print_r( $_SERVER ); echo '</pre>';
//                   echo '<pre>'; print_r( $get_data_2 ); echo '</pre>';
                  ?>

                <?php } ?>

                <table id="example2" class="display" style="width:100%">
                	<thead>
                	    <!--<th colspan="4">Products informations-->
                	    <!--	<th colspan="4">Shipment anticipation</th>-->
                	    <!--	<th colspan="4">In transit</th>-->
                				<tr>
                					<th class="sell">Select</th>
                                    <th>Action</th>
                					<!--<th>Supplier track number</th>-->
                					<!--<th>Parcel Number</th>-->
                					<th style="display: none">Customer Name</th>
                					<th>URL Product</th>
                					<th>Name of product</th>
                					<th>Color</th>
                					<th>Size</th>

                					<th>Units</th>
                                    <th>Total price</th>
                                    <!--<th>Net Price</th>-->
                                    <!--<th>Status</th>-->

                                    <!--<th>Weight</th>-->
                                    <!--<th> Price without VAT </th>-->
                     <!--               <th>Size</th>-->

                     <!--               <th>Days</th>-->
                					<!--<th>Category</th>-->

                					<!--<th>HS Code</th>-->
                					<!--<th>Origin of goods</th>-->
                					<!--<th> Customs fees </th>-->
                					<!--<th>Limit </th>-->
                					<!--<th>Alert</th>-->
                     <!--               <th>Invoiced weight</th>-->
                     <!--               <th>Additional Information</th>-->

                     <!--               <th>Numero suivi</th>-->


                					<!-- <th>Payment</th> -->
                					</tr>
                				<!--</th>-->
                	</thead>
                	<tbody>
                		<?php
                		$cart = $_GET['cart'];
                		$cst = $_GET['id'];
                		$sql = "SELECT shopify_customers.firstname, shopify_customers.lastname, customer_product_wishlist.* FROM customer_product_wishlist INNER JOIN shopify_customers on (shopify_customers.id_customer = customer_product_wishlist.id_customer) INNER JOIN customer_cart on (customer_cart.id_customer = customer_product_wishlist.id_customer) WHERE customer_product_wishlist.status = 2 AND customer_product_wishlist.is_archived IS NULL AND customer_product_wishlist.parcel_number IS NULL AND customer_product_wishlist.id_customer=$cst GROUP BY customer_product_wishlist.id";
                		$res = $con->query($sql);
                			if ($res->num_rows > 0) {
                				foreach ($res as $result){
                				$hs_limit = $result['limit_product'];
                                $date1_ts = date('Y-m-d H:i:s');
                                $date2_ts = $result['days'];
                                $diff = strtotime($date1_ts) - strtotime($date2_ts);
                                $no_of_days = round($diff / 86400);
                		?>
                		<tr class="close-<?= $result['id'] ?>">
                      <td><input type="checkbox" class="deleteMultiple" value="<?= $result['id'] ?>" name="select" units="<?php echo $result['qty']; ?>" price="<?php echo $result['price']; ?>"></td>
                      <td><a href="javascript:void(0)" id="openModal" product_color="<?php echo $result['product_color']; ?>" product_size="<?php echo $result['product_size']; ?>" value="<?php echo $result['id']; ?>" quantity="<?php echo $result['qty'] ?>" net_price="<?php if($result['net_price']){ echo $result['net_price'];}else{ echo $result['price'] - round((20/100 * $result['price']), 2); }?>" hscodev="<?php echo $result['hs_code']; ?>" limitv="<?php echo $result['limit_product']; ?>" originv="<?php echo $result['origin_good']; ?>" invoicedweight="<?php echo $result['invoiced_weight']; ?>" trnumberv="<?php echo $result['tracked_number']; ?>" status="<?php echo $result['product_status']; ?>" price="<?php echo $result['price']; ?>" sup_track_number="<?php echo $result['supplier_track_number']; ?>" warehouse_name="<?php echo $result['warehouse_name'] ?>">Update</a>
                        | &nbsp; <a class="delete_instock_product_data" href="javascript:void(0)" hidden_val="<?php echo $result['id'];?>" id_customer="<?php echo $result['id_customer'].'-'.sprintf("%03s", $result['id']); ?>">Delete</a>
                      </td>
                			<!--<td><?php echo $result['supplier_track_number']; ?></td>-->
                			<!--<td><?php echo $result['parcel_number']; ?></td>-->
                			<td style="display: none"><?php echo $result['firstname']. ' ' . $result['lastname']; ?></td>
                      <td><a class="truncate" href="<?php if($result['source'] == 'cdiscount.com'){}else{if($result['source'] != 'zara.com' || $result['source'] != 'amazon.fr'){ ?>http://<?php }}echo $result['product_url']; ?>" target="_blank" title="<?php echo $result['product_url']; ?>"><?php echo $result['product_url']; ?></a></td>
                			<td><?php echo Helper::mysql_escape($result['title']); ?></td>
                			<td><?php echo $result['product_color']; ?></td>
                			<td><?php echo $result['product_size']; ?></td>

                			<td><?php echo $result['qty']; ?></td>
                      <td><?php echo $result['price'].' '.$result['currency']; ?></td>
                   <!--   <td><?php if($result['net_price']){ echo $result['net_price'];}else{ echo $result['price'] - round((20/100 * $result['price']), 2).' '.$result['currency']; }?></td>-->
                   <!--   <td><?php if($result['product_status'] == '0'){echo 'Not Paid';}else if($result['product_status'] == '1'){ echo 'Paid';}else if($result['product_status'] == '2'){ echo 'To send back to supplier';}else if($result['product_status'] == '3'){ echo 'Sent back';}else if($result['product_status'] == '4'){ echo 'Indisponible';}else if($result['product_status'] == '5'){ echo 'Annulé';}else{echo'';} ?></td>-->

                			<!--<td><?php echo $result['weight'].''.$result['weight_type']; ?></td>-->
                			<!--<td><?php echo $result['price'].' '.$result['currency']; ?></td>-->
                			<!--<td><?php echo $result['length'].'x'.$result['width'].'x'.$result['height'].''.$result['weight_type']; ?></td>-->

                   <!--       <td><?= $no_of_days ?> Days</td>-->
                			<!--<td></td>-->
                			<!--<td><?php echo $result['hs_code']; ?></td>-->
                			<!--<td><?php echo $result['origin_good']; ?></td>-->
                			<!--<td></td>-->
                			<!--<td><?php echo $result['limit_product']; ?></td>-->
                			<!--<td <?php if($hs_limit == $result['qty'] || $hs_limit < $result['qty']){ ?> style="background: green;" <?php } else if($hs_limit > $result['qty']){ ?> style="background: orange;" <?php } else if($hs_limit == 0){ ?> style="background: red;" <?php } ?>>-->
                			<!--</td>-->
                			<!--<td><?php echo $result['invoiced_weight']; ?></td>-->
                			<!--<td><?php echo $result['additional_info']; ?></td>-->
                			<!--<td>-->
                   <!--         <span class="edit-track-number hide-track-<?= $result['id']; ?>" data-id="<?= $result['id']; ?>"><?php echo $result['tracked_number']; ?></span>-->
                   <!--         <span class="show-edit-<?= $result['id']; ?>" style="display:none"> <input type="text" class="update_track_value-<?= $result['id']; ?>" value="<?= $result['tracked_number']; ?>"><center> <span class="cancel_track" data-id="<?= $result['id']; ?>">&#10060;</span> <span class="update_track" data-id="<?= $result['id']; ?>">&#10003;</span></center> </span>-->
                   <!--       </td>-->
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
                    <div class="info_message"></div>
                    <form class="product_information tstttt">
                        <div class="form-group" style="width: 50%">
                    	       <label for="paid_price" style="display: flex;width: 100%;max-width: 100%;align-items: center;">
                    	           <div style="width: 50%">Paid Price : </div><input type="paid_price" class="form-control" id="paid_price" name="paid_price" required="" style="pointer-events: none;user-select: none;width: 50%;border: none;"></label>

                    	       <span id="hsError"></span>
                	       </div>
                    	<input type="hidden" name="iddbs" value="" id="iddb">
                    	<div class="form-group">
                	       <label for="net_price">Net Price:</label>
                	       <input type="text" class="form-control" id="net_price" name="net_price" required="">
                	       <span id="hsError"></span>
                	    </div>
                    	<div class="form-group">
                	       <label for="quantity">Quantity:</label>
                	       <input type="text" class="form-control" id="quantity" name="quantity" required="">
                	       <span id="hsError"></span>
                	    </div>
                	    <div class="form-group">
                	       <label for="hs_code">HS Code:</label>
                	       <input type="hs_code" class="form-control" id="hs_code" name="hs_code" required="">
                	       <span id="hsError"></span>
                	    </div>
                	    <div class="form-group">
                	       <label for="color">Color:</label>
                	       <input type="text" class="form-control" id="product_color" name="product_color" required="">
                	       <span id="hsError"></span>
                	    </div>
                	    <div class="form-group">
                	       <label for="size">Size:</label>
                	       <input type="text" class="form-control" id="product_size" name="product_size" required="">
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
                  				<input class="form-check-input" type="checkbox" value="1" name="instock" id="instock" checked/>
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
                        		$sql = "SELECT * FROM customer_product_wishlist WHERE parcel_number IS NOT NULL AND parcel_for=0 GROUP BY parcel_number";
                        		$res = $con->query($sql);
                        			if ($res->num_rows > 0) {
                        				foreach ($res as $result){
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

                <div class="modal" id="myModal03" role="dialog">
                <div class="modal-dialog">
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal03">&times;</button>
                      <h4 class="modal-title">Cost</h4>
                    </div>
                    <div class="modal-body">
                    <div class="info_message"></div>
                    <form class="cost_product">
                    	<!--<input type="hidden" name="iddb" value="" id="iddb">-->
                    	<div class="form-group">
                	       <label for="hs_code">Cost :</label>
                	       <input type="hidden" name="id_customer" value="<?php echo $_GET['id'] ?>">
                	       <input type="hidden" name="id_cart" value="<?php echo $_GET['cart'] ?>">
                	       <input class="form-control" name="cost" id="cost">
                	       <span id="hsError"></span>
                	    </div>
                      <button type="submit" class="btn btn-default" id="cost_submit">Soumettre</button>
                    </form>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal02" id="closeid03">Close</button>
                    </div>
                  </div>
                </div>
                </div>


                <div class="modal" id="myModal04" role="dialog">
                <div class="modal-dialog">
                  <!-- Modal content-->
                  <form class="cst_parcel_form">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal04">&times;</button>
                      <h4 class="modal-title">Create Parcel</h4>
                    </div>

                    <div class="modal-body">
                    <div class="info_message"></div>

                    	<input type="hidden" name="id_customer" value="" id="idcst">
                    	<input type="hidden" name="id_cart" value="<?php echo $_GET['cart']; ?>" id="cart_for_wallet">
                    	<input type="hidden" name="cost" value="" id="cost_for_wallet">
                    	<input type="hidden" name="action" value="single">
                    	<div class="form-group">
                	       <label for="hs_code">Create parcel and apply to :</label>

                	       <select class="form-control" name="parcel">
                	           <option value="0" selected>
                	               Pending
                	           </option>
                	           <option value="1">
                	               Colisrael
                	           </option>
                	           <option value="2">
                	               Personal
                	           </option>
                	       </select>
                	      <span id="hsError"></span>
                	    </div>

                      <button type="submit" class="btn btn-default" id="cst_parcel_submit">Soumettre</button>


                    </div>
                    <div class="modal-footer">
                        <div style="float:left">
                	       <input type="checkbox" name="is_mail" value="not_send">
                	       <label for="hs_code" style="margin-left: 15px">Ne pas avertir le client par email</label>
                	       <span id="hsError"></span>
                	    </div>
                      <button type="button" class="btn btn-default" data-dismiss="modal04" id="closeid04">Close</button>
                    </div>
                    </form>
                  </div>
                </div>
                </div>

                <script>
                $('#supplier_submit').click(function(e){
                	e.preventDefault();
                    	let idObject = [];
                          $('.deleteMultiple:checkbox:checked').each(function(){
                            idObject.push(this.value);
                          })
                    $.ajax({
                      type: "POST",
                      url: "{{ env('APP_URL') }}/supplier_tracking.php",
                      data: {id: idObject,form_data: $('#supp_tracking_number').val()},
                      methos: "POST",
                      dataType:'html',
                      success: function (data) {
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
                        if(window.location.search != ''){
                            window.location.href = window.location.href+'&nocache';
                        }else{
                            window.location.href = window.location.href+'?nocache';
                        }
                        // window.location.href = window.location.origin+window.location.pathname+'?tab='+$('ul.nav.nav-tabs li.active').data('tab')
                    	// setTimeout(function(){
                    	//  	var modal = document.getElementById("myModal");
                    	// 	modal.style.display = "none";
                    	// }, 2000);
                        return false;
                      },
                    });
                })
                $('#hs_code_submit').click(function(e){
                	e.preventDefault();
                    	let idObject = [];
                          $('.deleteMultiple:checkbox:checked').each(function(){
                            idObject.push(this.value);
                          })
                    $.ajax({
                      type: "POST",
                      url: "{{ env('APP_URL') }}/update_hs_code.php",
                      data: {id: idObject,form_data: $('#up_hs_code').val()},
                      methos: "POST",
                      dataType:'html',
                      success: function (data) {
                        // $(".info_message").html('<h3>'+data+'</h3>');
                        // console.log(data,'data');
                        // var parseData = JSON.parse(data);
                        // console.log(parseData,'parseData');
                        // alert(parseData.msg);
                        // $('#warehouse_name').val('')
                        // if (parseData.code == 200) {
                        //   $('.close-'+parseData.id).fadeOut("slow");
                        // }
                        window.location.href = window.location.origin+window.location.pathname+'?tab='+$('ul.nav.nav-tabs li.active').data('tab')
                    	// setTimeout(function(){
                    	//  	var modal = document.getElementById("myModal");
                    	// 	modal.style.display = "none";
                    	// }, 2000);
                        return false;
                      },
                    });
                })
                $('#parcel_submit').click(function(e){
                	e.preventDefault();
                    	let idObject = [];
                          $('.deleteMultiple:checkbox:checked').each(function(){
                            idObject.push(this.value);
                          })
                    $.ajax({
                      type: "POST",
                      url: "{{ env('APP_URL') }}/join_parcel.php",
                      data: {id: idObject,form_data: $('#parcel').val()},
                      methos: "POST",
                      dataType:'html',
                      success: function (data) {
                        // $(".info_message").html('<h3>'+data+'</h3>');
                        // console.log(data,'data');
                        // var parseData = JSON.parse(data);
                        // console.log(parseData,'parseData');
                        // alert(parseData.msg);
                        // $('#warehouse_name').val('')
                        // if (parseData.code == 200) {
                        //   $('.close-'+parseData.id).fadeOut("slow");
                        // }
                        //  location.reload();
                        //window.location.href = window.location.origin+window.location.pathname+'?tab='+$('ul.nav.nav-tabs li.active').data('tab')
                    	// setTimeout(function(){
                    	//  	var modal = document.getElementById("myModal");
                    	// 	modal.style.display = "none";
                    	// }, 2000);
                        return false;
                      },
                    });
                })
                $(document).on('click', '.btn-join-parcel', function(){
                    var modal = document.getElementById("myModal3");
                    modal.style.display = "block";
                })
                $(document).on('click', '.btn-supp', function(){
                    var modal = document.getElementById("myModal01");
                    modal.style.display = "block";
                })
                $(document).on('click', '.btn-hs', function(){
                    var modal = document.getElementById("myModal02");
                    modal.style.display = "block";
                })
                $(document).on("click", "#openModal" , function(e) {
                	e.preventDefault();
                    var modal = document.getElementById("myModal");
                    // var modal = document.getElementById("myModal2");
                    modal.style.display = "block";
                    $("#iddb").val($(this).attr('value'));

                    $("#hs_code").val($(this).attr('hscodev'));
                   	$("#limit").val($(this).attr('limitv'));
                   	$("#origin_good").val($(this).attr('originv'));
                   	$("#invoiced_weight").val($(this).attr('invoicedweight'));
                   	$("#tracked_number").val($(this).attr('trnumberv'));
                   	$("#net_price").val($(this).attr('net_price'));
                   	$("#quantity").val($(this).attr('quantity'));
                   	$("#product_color").val($(this).attr('product_color'));
                   	$("#product_size").val($(this).attr('product_size'));
                   	if($(this).attr('status')){
                       	$("#status").val($(this).attr('status'));
                   	}else{
                   	    $("#status").val('0');
                   	}
                   	$("#paid_price").val($(this).attr('price'));
                   	$("#sup_track_number").val($(this).attr('sup_track_number'));
                   	$("#warehouse_name").val($(this).attr('warehouse_name'));
                });


                $(document).on("click", ".close, #closeid, #closeid2, #closeid01, #closeid02, #closeid04" , function(e) {
                	e.preventDefault();
                	var modal = document.getElementById("myModal");
                    modal.style.display = "none";
                    	var modal = document.getElementById("myModal3");
                    modal.style.display = "none";
                    var modal = document.getElementById("myModal01");
                    modal.style.display = "none";
                    var modal = document.getElementById("myModal02");
                    modal.style.display = "none";
                    var modal = document.getElementById("myModal03");
                    modal.style.display = "none";
                    var modal = document.getElementById("myModal04");
                    modal.style.display = "none";
                });
                $('#cost_submit').click(function(){
                    event.preventDefault();
                    $('#cost_for_wallet').val($('#cost').val())
                    if($('[name="cost"]').val() == ''){
                        alert("Can't have empty cost");
                        return false;
                    }
                    $.ajax({
                      type: "POST",
                      url: "{{ env('APP_URL') }}/add_matching_cost.php",
                      data: $('.cost_product').serialize(),
                      methos: "POST",
                      dataType:'html',
                      success: function (data) {
                          $('#myModal04').show();
                        return false;
                      },
                    });
                    return false;
                })


                $('#cost_btn').click(function(){
                    var modal = document.getElementById("myModal03");
                    modal.style.display = "block";
                })
                $(document).on("click", "#whislist_update" , function(e) {
                   	e.preventDefault();
                    $.ajax({
                      type: "POST",
                      url: "{{ env('APP_URL') }}/update_wishlist_products.php",
                      data: $('.product_information.tstttt').serialize(),
                      methos: "POST",
                      dataType:'html',
                      success: function (data) {
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
                        if(window.location.search != ''){
                            window.location.href = window.location.href+'&nocache';
                        }else{
                            window.location.href = window.location.href+'?nocache';
                        }
                        // window.location.href = window.location.origin+window.location.pathname+'?tab='+$('ul.nav.nav-tabs li.active').data('tab')
                    	// setTimeout(function(){
                    	//  	var modal = document.getElementById("myModal");
                    	// 	modal.style.display = "none";
                    	// }, 2000);
                        return false;
                      },
                    });
                });
                $(document).on("click", ".delete_instock_product_data" , function() {
                   var id_customer  = $(this).attr("hidden_val");
                   var result = confirm("Are you sure?");
                   if (result) {
                     deleteData(id_customer,'single',this)
                   }
                });
                $('#example2 tr').click(function(event) {
                    setTimeout(function(){
                        var pri = 0;
                        $('.deleteMultiple').each(function(){
                            if($(this).is(':checked')){
                                pri += parseFloat($(this).attr('price')) * parseFloat($(this).attr('units'))
                            }
                        })
                        console.log(pri)
                        $('.user_paid').html(pri.toFixed(2)+'€')
                        var cos = ($('.cost').html()).replace('€', '')
                        console.log(pri-parseFloat(cos))
                        bal = pri-parseFloat(cos);
                        $('.balance').html(bal.toFixed(2)+'€')
                    }, 100);
                  if (event.target.type !== 'checkbox') {
                      $(':checkbox', this).trigger('click');
                  }
                  if ($('.deleteMultiple:checkbox:checked').length > 1) {
                    $('.btn-delete').show();
                    $('.btn-paid').show();
                    $('.btn-supp').show()
                    $('.btn-hs').show()
                  }else if($('.deleteMultiple:checkbox:checked').length > 0){
                      $('.btn-parcel').show();
                      $('.btn-arc').show();
                    //   $('.btn-join-parcel').show()
                  }else {
                    $('.btn-delete').hide();
                    $('.btn-paid').hide();
                    $('.btn-parcel').hide();
                    $('.btn-arc').hide();
                    $('.btn-join-parcel').hide()
                    $('.btn-supp').hide()
                    $('.btn-hs').hide()
                  }
                });
                $('.btn-delete').click(function(){
                  let idObject = [];
                  let thisObject = [];
                  $('.deleteMultiple:checkbox:checked').each(function(){
                    idObject.push(this.value);
                    thisObject.push(this);
                  })
                  var result = confirm("Are you sure?");
                  if (result) {
                    deleteData(idObject,'single',thisObject)
                  }
                })
                $('.btn-paid').click(function(){
                  let idObject = [];
                  let thisObject = [];
                  $('.deleteMultiple:checkbox:checked').each(function(){
                    idObject.push(this.value);
                    thisObject.push(this);
                  })
                  var result = confirm("Want to mark products as paid?");
                  if (result) {
                    paidData(idObject,'single',thisObject)
                  }
                })
                $('.btn-parcel').click(function(){
                  let idObject = [];
                  let thisObject = [];
                  $('.deleteMultiple:checkbox:checked').each(function(){
                    idObject.push(this.value);
                    thisObject.push(this);
                  })
                  $('.cst_parcel_form #idcst').val(idObject);
                  $('#cost_btn').click()

                //   var result = confirm("Want to create parcel?");
                //   if (result) {
                //     createparcelData(idObject,'single',thisObject)
                //   }
                })
                $('.btn-arc').click(function(){
                  let idObject = [];
                  let thisObject = [];
                  $('.deleteMultiple:checkbox:checked').each(function(){
                    idObject.push(this.value);
                    thisObject.push(this);
                  })
                  var result = confirm("Want to archive product?");
                  if (result) {
                    archiveProductData(idObject,'single',thisObject)
                  }
                })
                function archiveProductData(id,action,object) {
                  $.ajax({
                     type: "POST",
                     url: '{{ env('APP_URL') }}/archive_backend.php',
                     data: {id_customer: id,action:action},
                     success: function(data){
                        // alert('Archived Successfully');
                        // location.reload();
                        if(window.location.search != ''){
                            window.location.href = window.location.href+'&nocache';
                        }else{
                            window.location.href = window.location.href+'?nocache';
                        }
                        // window.location.href = window.location.origin+window.location.pathname+'?tab='+$('ul.nav.nav-tabs li.active').data('tab')
                        // if (action == 'single') {
                        //   $(object).closest('tr').fadeOut("slow");
                        // }else {
                        //   for (let value of object) {
                        //     $(value).closest('tr').fadeOut("slow");
                        //   }
                        // }
                     },
                     error: function(xhr, status, error){
                     console.error(xhr);
                     }
                   });
                }

                $('#cst_parcel_submit').click(function(){
                    event.preventDefault();
                    $('#validate').click(function(e){
                    	e.preventDefault();
                    })
                    $.ajax({
                     type: "POST",
                     url: '{{ env('APP_URL') }}/create_parcel_backend.php',
                     data: $('.cst_parcel_form').serialize(),
                     success: function(data){
                        // alert('Parcel created Successfully');
                        if(window.location.search != ''){
                            window.location.href = window.location.href+'&nocache';
                        }else{
                            window.location.href = window.location.href+'?nocache';
                        }
                        // location.reload();
                        //window.location.href = window.location.origin+window.location.pathname+'?tab='+$('ul.nav.nav-tabs li.active').data('tab')
                        // if (action == 'single') {
                        //   $(object).closest('tr').fadeOut("slow");
                        // }else {
                        //   for (let value of object) {
                        //     $(value).closest('tr').fadeOut("slow");
                        //   }
                        // }
                     },
                     error: function(xhr, status, error){
                     console.error(xhr);
                     }
                  });
                })

                function createparcelData(id,action,object) {
                  $.ajax({
                     type: "POST",
                     url: '{{ env('APP_URL') }}/create_parcel_backend.php',
                     data: {id_customer: id,action:action},
                     success: function(data){
                        // alert('Parcel created Successfully');
                        // location.reload();
                        window.location.href = window.location.origin+window.location.pathname+'?tab='+$('ul.nav.nav-tabs li.active').data('tab')
                        // if (action == 'single') {
                        //   $(object).closest('tr').fadeOut("slow");
                        // }else {
                        //   for (let value of object) {
                        //     $(value).closest('tr').fadeOut("slow");
                        //   }
                        // }
                     },
                     error: function(xhr, status, error){
                     console.error(xhr);
                     }
                   });
                }
                function deleteData(id,action,object) {
                  $.ajax({
                     type: "POST",
                     url: '{{ env('APP_URL') }}/delete_instock_products_backend.php',
                     data: {id_customer: id,action:action},
                     success: function(data){
                        // alert('Data Deleted Successfully');
                        if (action == 'single') {
                          $(object).closest('tr').fadeOut("slow");
                        }else {
                          for (let value of object) {
                            $(value).closest('tr').fadeOut("slow");
                          }
                        }
                     },
                     error: function(xhr, status, error){
                     console.error(xhr);
                     }
                   });
                }
                function paidData(id,action,object) {
                  $.ajax({
                     type: "POST",
                     url: '{{ env('APP_URL') }}/paid_products_backend.php',
                     data: {id_customer: id,action:action},
                     success: function(data){
                        // alert('Data updated Successfully');
                        // if (action == 'single') {
                        //   $(object).closest('tr').fadeOut("slow");
                        // }else {
                        //   for (let value of object) {
                        //     $(value).closest('tr').fadeOut("slow");
                        //   }
                        // }
                     },
                     error: function(xhr, status, error){
                     console.error(xhr);
                     }
                   });
                }
                </script>
                <script>
                 $('.edit-track-number').on('click',function(){
                   let id = $(this).data('id');
                   $('.hide-track-'+id).hide();
                   $('.show-edit-'+id).show();
                 })
                 $('.cancel_track').on('click',function(){
                   let id = $(this).data('id');
                   $('.hide-track-'+id).show();
                   $('.show-edit-'+id).hide();
                 })
                 $('.update_track').on('click',function(){
                   let id = $(this).data('id');
                   let trackid = $('.update_track_value-'+id).val();
                   $.ajax({
                      type: "POST",
                      url: '{{ env('APP_URL') }}/update_track_number.php',
                      data: {id,trackid},
                      success: function(data){
                        //  alert('Track ID updated successfully');
                         $('.update_track_value-'+id).val(trackid);
                         $('.hide-track-'+id).text(trackid);
                         $('.hide-track-'+id).show();
                         $('.show-edit-'+id).hide();
                      },
                      error: function(xhr, status, error){
                      console.error(xhr);
                      }
                   });
                 })
                 $('#example6 tr').click(function(event) {
                   if (event.target.type !== 'checkbox') {
                       $(':checkbox', this).trigger('click');
                   }
                });

                // $("#example6 tr").click(function(){
                //     $(this).addClass('selected').siblings().removeClass('selected');
                // });

                //logic for b4,b5,b6,b7


                $html = '<div class="row" id="b4_row"> <div class="form-group"> <label for="origin_good">B4</label> <input type="text" class="form-control" id="b4" name="b4" required="" value="0"> <span id="hsError"></span> </div><div class="form-group"> <label for="origin_good">B5</label> <input type="text" class="form-control" id="b5" name="b5" required="" value="0"> <span id="hsError"></span> </div><div class="form-group"> <label for="origin_good">B6</label> <input type="text" class="form-control" id="b6" name="b6" required="" value="0"> <span id="hsError"></span> </div><div class="form-group"> <label for="origin_good">B7</label> <input type="text" class="form-control" id="b7" name="b7" required="" value="0"> <span id="hsError"></span> </div><div class="form-group"> <label for="origin_good">B8</label> <input type="text" class="form-control" id="b8" name="b8" required="" value="0"> <span id="hsError"></span> </div><div> <button class="minus_btn" type="button">-</button> </div></div>';
                $(".plus_btn").click(function(){
                   $(this).parents(".b4_wrapper").append($html);
                });
                $(document).on("click",".minus_btn", function(){
                   $(this).parents("#b4_row").remove();
                });
                //setup before functions
                var typingTimer;                //timer identifier
                var doneTypingInterval = 1000;  //time in ms, 5 second for example
                var $input = $('div#b4_row input');

                //on keyup, start the countdown
                $(document).on('keyup','div#b4_row input', function () {
                  clearTimeout(typingTimer);
                  typingTimer = setTimeout(doneTyping, doneTypingInterval);
                });

                //on keydown, clear the countdown
                $(document).on('keyup','div#b4_row input', function () {
                  clearTimeout(typingTimer);
                });

                //user is "finished typing," do something
                function doneTyping () {
                   $("div#b4_row").each(function(){
                        var b4 = parseFloat($(this).find("#b4").val());
                        var b5 = parseFloat($(this).find("#b5").val());
                        var b6 = parseFloat($(this).find("#b6").val());
                        var b7 = parseFloat($(this).find("#b7").val());

                        var newresult = (b5 * b6 * b7);
                        var result = parseFloat(newresult/5000);
                        // console.log(result);
                        $(this).find("#b8").val(result);
                        // $(this).find("#b8").each(function(){
                        //     var total = parseFloat($("#b9").val());
                        //     total += parseFloat($(this).val());
                        //     console.log("hello total "+total);
                        // });
                    });
                }
                $(function(){
                    var check = setInterval(function () {
                        if($('ul.nav.nav-tabs li:nth-child(2)').hasClass('active')){
                            setTimeout(function() {
                              $('.sell').click()
                            }, 100);
                            clearInterval(check);
                        }
                    }, 100);
                })
                $('select.cust_name.form-control').on('change', function(){
                    $('div#example2_filter input').val($(this).val()).trigger('keyup')
                })
                </script>

			</div>
		</div>
  	</div>

  	<!-- Bootstrap core JavaScript -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

	<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
	<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.24/js/dataTables.jqueryui.min.js"></script>
	<script src="https://cdn.datatables.net/scroller/2.0.3/js/dataTables.scroller.min.js"></script>
	<script >
		$(document).ready(function() {
		    if($('.deleteMultiple').length == 0){
                $('.cost').html(0+'€')
                $('.balance').html(0+'€')
            }
		     if (window.location.href.indexOf("?tab") > -1) {
    	       // $('ul.nav.nav-tabs li').removeClass('active')
            //     $('ul.nav.nav-tabs li[data-tab="'+(window.location.search).replace('?tab=', '')+'"]').addClass('active')
            //     $('.tab-content .tab-pane').removeClass('active')
            //     $('.tab-content .tab-pane#'+(window.location.search).replace('?tab=', '')+'').addClass('active')
            }
			console.log('ready..!');
			setTimeout(function() {
              $('#example2').DataTable({
        	    	"scrollX": true,
        	    	"pageLength": 100
        	    });
            }, 103);
		});


	</script>
<div class="col-md-12" style="text-align: center;padding: 30px 0;font-size: 18px;font-weight: bold;">
   <a href="{{ env('APP_URL') }}/index2_customer?id=<?php echo $_GET['id']; ?>&cart=<?php echo $_GET['cart']; ?>">< arrière</a>
   <a href="{{ env('APP_URL') }}/index_new">next ></a>
</div>

<script type="text/javascript" src="https://js.stripe.com/v3"></script>
<script type="text/javascript" src="../js/product_payment_new.js"></script>

</body>
</html>
