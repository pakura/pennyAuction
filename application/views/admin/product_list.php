<?php //print_r($products) ?>
<div class="topPtion">
    <a href="/admin/admin/addproduct" ><div class="addNew">Add New Product</div> </a>
</div>
<div style="font-family: Myup">
<table id="dataTable" class="display" cellspacing="0" width="100%">
    <thead>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Date</th>
        <th>Price</th>
        <th>Option</th>
    </tr>
    </thead>

    <tfoot>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Date</th>
        <th>Price</th>
        <th>Option</th>
    </tr>
    </tfoot>

    <tbody>
    <?php foreach( $products as $prod ): ?>

        <tr id="<?= $prod->id ?>">
            <td><?= $prod->id ?></td>
            <td class="titleM" onmouseenter="showPoster(this, '<?= $prod->thumbnail ?>')" onmouseout="hidePoster()">
                <b><?= $prod->product_name ?></b>
            </td>
            <td><?= $prod->autodate ?></td>
            <td><?= $prod->original_price ?></td>
            <td style="text-align: right">
                <a href="/admin/admin/deleteproduct/<?= $prod->id ?>">
                    <span class="deleteicon option"><img src="/assets/imgs/delete.png" /></span>
                </a>
                <a href="/admin/admin/editproduct/<?= $prod->id ?>">
                    <span class="editicon option"><img src="/assets/imgs/edit.png" /></span>
                </a>
                <a href="/admin/admin/addauction/<?= $prod->id ?>">
                    <span class="addicon option"><img src="/assets/imgs/add.png" /></span>
                </a>


            </td>
        </tr>

    <?php endforeach; ?>
    </tbody>
</table>
</div>
<div id="poster"></div>

<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            'iDisplayLength': 30,
            "order": [[ 0, "desc" ]]
        });
        $('.titleM').click(function(){
            $('#poster').fadeOut();
        });
    });
</script>
