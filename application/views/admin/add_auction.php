
<div class="topPtion">
    <span style="color: orangered" >
        <?php echo validation_errors(); ?>
    </span>
</div>

<?php
//print_r($product);
?>

<?php echo form_open_multipart('admin/admin/addauction/'.$product->id) ?>

<input type="hidden" class="inputs" name="product_name" value="<?= $product->product_name ?>" />
<input type="hidden" name="product_id" value="<?= $product->id ?>" />


<input type="text" name="price" class="inputs" placeholder="Price" value="<?= set_value('price') ?>" />
<br />
<input type="number" name="bid_price" placeholder="number of bids" class="inputs" value="<?= set_value('bid_price') ?>" />
<br />
<input type="number" name="time_left" placeholder="time left ( in minutes )" class="inputs" value="<?= set_value('time_left') ?>" />
<br />
<input type="number" name="reset_time" placeholder="reset time ( in seconds )" class="inputs" value="<?= (set_value('reset_time') | 15) ?>" />
<br />

<input type="checkbox" style="width: 40px; height: 30px"  name="inc_price" value="1" <?= set_checkbox('inc_price', '1',true); ?> />
<label for="inc_price">increase price on bid</label>
<br />

<input type="checkbox"  name="buy_now" value="1" style="width: 40px; height: 30px"  <?= set_checkbox('buy_now', '1'); ?> />
<label for="buy_now">Enable "Buy It Now"</label>
<br />
<input type="text" class="inputs" name="delivery_time" placeholder="delivery time" value="<?= set_value('delivery_time') ?>" />
<br />
<input type="text" name="real_price" placeholder="real price" class="inputs" value="<?= set_value('real_price') ?>" />
<br />

<label for="tags">tags:</label>
<br>
<textarea name="tags"  class="inputs" ><?= set_value('tags') ?></textarea>
<br>

<input type="submit" class="addNew" value="Add this to Auction" style="width: 200px; height: 32px; cursor: pointer;" />

</form>