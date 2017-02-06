<?php //print_r($productDate)?>
<div class="topPtion">
    <span style="color: orangered" >
        <?= $error ?>

        <br>
        <?php echo validation_errors(); ?>
    </span>
</div>



<?php
if (isset($editable)){
    if ($editable == 1){
        echo form_open_multipart('admin/admin/editproduct/'.$productDate->id);
    } else {
        echo form_open_multipart('admin/admin/addproduct');
    }
} else {
    echo form_open_multipart('admin/admin/addproduct');
}
?>
<table style="width: 100%">
    <tr>
        <td>product name</td>
        <td><input type="text" name="name" class="inputs" value="<?= set_value('name') | isset($productDate->product_name)?$productDate->product_name:'' ?>" /></td>
    </tr>
    <tr>
        <td>stock price</td>
        <td><input type="text" name="original_price" class="inputs" value="<?= set_value('original_price') | isset($productDate->original_price)?$productDate->original_price:'' ?>" /></td>
    </tr>
    <tr>
        <td>category</td>
        <td>
            <select name="category_id" class="inputs" >
                <?php
                foreach( $categories as $cat ){
                    if ($cat->id == isset($productDate->category_id)?$productDate->category_id:''){
                        echo '<option value="'.$cat->id.'" selected>'.$cat->name.'</option>';
                    } else {
                        echo '<option value="'.$cat->id.'">'.$cat->name.'</option>';
                    }
                }
                ?>
            </select>
        </td>
    </tr>
    <tr>
        <td></td>
        <td><textarea id="description" style="width: 1045px" rows="10" cols="80" name="description" ><?= set_value('description') | isset($productDate->description)?$productDate->description:'' ?></textarea></td>
    </tr>
    <td>

        <td><textarea id="spec" style="width: 1045px" rows="10" cols="80" name="spec"><?= set_value('spec') | isset($productDate->spec)?$productDate->spec:'' ?></textarea></td>
    <td></td>
    </td>
    <tr>
        <td>keywords</td>
        <td><textarea class="inputs" style="height: 100px" name="keywords" ><?= set_value('keywords')  | isset($productDate->keywords)?$productDate->keywords:'' ?></textarea></td>
    </tr>
    <tr>
        <td>Photos</td>
        <td><input type="file" name="image1"  class="inputs" /><br>
            <input type="file" name="image2"  class="inputs" /><br>
            <input type="file" name="image3"  class="inputs" /><br>
            <input type="file" name="image4" class="inputs" /></td>
    </tr>
</table>


    <center><input type="submit" value="Add This Item" class="addNew" /></center>

</form>
<script src="//cdn.ckeditor.com/4.5.4/full/ckeditor.js"></script>
<script>
    $(function () {
        CKEDITOR.replace( 'description' );
        CKEDITOR.replace( 'spec' );
    })
</script>