<style>
    /* Upload csv... */
    .alert.alert-success {
        text-align: center;
        font-weight: 600;
    }

    .tab-pane input[type="submit"] {
        color: #fff;
        border: none;
        background: blue;
        padding: 10px 30px;
        display: inline-block;
        border-radius: 3px;
    }

    form.flex-grid {
        display: flex;
        align-items: center;
        margin-bottom: 30px;
    }

    /* End Upload csv... */
</style>
<h3>upload Excel File</h3>
<br />
<form class="flex-grid" method="post" enctype="multipart/form-data" action='{{ env('APP_URL') }}/update_csv'>
    <input type="file" name="doc" /><br />
    <input type="submit" name="submit" />
</form>
<table id="dtBasicExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th class="th-sm">Sr.No.

            </th>
            <th class="th-sm">Poid en Kg

            </th>
            <th class="th-sm">Piano

            </th>
            <th class="th-sm">Rapido

            </th>
            <th class="th-sm">Expresso

            </th>

            <th class="th-sm">Created AT

            </th>
            <th class="th-sm">Updated AT

            </th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (count($uploadCSV['prices']) > 0) {
            $count = 1;
            foreach ($uploadCSV['prices'] as $result) {
        ?>
                <tr>
                    <td><?php echo  $count; ?></td>
                    <td><?php echo $result["weight"]; ?></td>

                    <td><?php echo $result["piano"]; ?></td>
                    <td><?php echo $result["colisrael_price"]; ?></td>
                    <td><?php echo $result["dhl_price"]; ?></td>
                    <td><?php echo $result["created_at"]; ?></td>
                    <td><?php echo $result["updated_at"]; ?></td>
                </tr>
        <?php $count++;
            }
        } ?>
    </tbody>
    <tfoot>

        <tr>
            <th>Sr.No.
            </th>
            <th>Poid en Kg
            </th>
            <th>Piano
            </th>
            <th>Rapido
            </th>
            <th>Expresso
            </th>
            <th>Created AT
            </th>
            <th>Updated AT
            </th>
        </tr>
    </tfoot>
</table>
<script>
    // Upload csv...
    $(document).ready(function() {
        $("#dtBasicExample").DataTable();
        $(".dataTables_length").addClass("bs-select");
    });
    // End Upload csv...
</script>
