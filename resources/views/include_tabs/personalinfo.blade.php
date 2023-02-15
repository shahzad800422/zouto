<h3>Customer Info</h3>
<table id="personalinfos" class="display" style="width:100%">
    <thead>
        <tr>
            <th>Sr. no</th>
            <th>Customer ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (count($customersInfo['list']) > 0) {
            $counter = 1;
            foreach ($customersInfo['list'] as $result) { ?>
                <tr>
                    <td><?php echo $counter; ?></td>
                    <td><?php echo $result['id_customer']; ?></td>
                    <td><?php echo $result['firstname'] . ' ' . $result['lastname']; ?></td>
                    <td><?php echo $result['email']; ?></td>
                    <td><?php echo $result['phone']; ?></td>
                </tr>
        <?php
                $counter++;
            }
        } ?>
    <tbody>
</table>
