<h3>Paid PRODUCTS</h3>
<table id="example" class="display" style="width:100%">
	<thead>
	  <tr>
	    <th>Sr. no</th>
	    <th>Customer ID</th>
	    <th>Product Title</th>
	    <!-- <th>Product Price</th> -->
	    <!-- <th>Product Weight</th> -->
	    <!-- <th>Product URL</th> -->
	    <!-- <th>Product Length</th>
	    <th>Product Width</th>
	    <th>Product Height</th> -->
	    <!-- <th>Status</th> -->
	  </tr>
	</thead>
	<tbody>
	<?php
		$sql = 'SELECT * FROM customer_product_wishlist WHERE status = 2';
	$res = $con->query($sql);
	if ($res->num_rows > 0) {
		$counter = 1;
		foreach ($res as $result){ ?>
			<tr>
			    <td><?php echo $counter; ?></td>
			    <td><?php echo $result['id_customer']; ?></td>
			    <td><?php echo Helper::mysql_escape($result['title']); ?></td>
			    <!-- <td><?php echo $result['price']; ?></td> -->
			    <!-- <td><?php echo $result['weight']; ?></td> -->
			    <!-- <td><?php echo $result['product_url']; ?></td> -->
			    <!-- <td><?php echo $result['length']; ?></td> -->
			    <!-- <td><?php echo $result['width']; ?></td> -->
			    <!-- <td><?php echo $result['height']; ?></td> -->
			    <!-- <td><?php echo $result['status']; ?></td> -->
			</tr>
			<?php
			$counter++;
		}
	} ?>
	<tbody>
</table>
