<h2 id="page_title"><?php echo lang('store:payment_title'); ?></h2>
<?php
if (validation_errors()) {
    echo '<div class="error">';
    echo validation_errors();
    echo '</div>';
}
?>

<fieldset>
    <legend><?php echo lang('store:cart_contents'); ?></legend>
    <table cellpadding="0" cellspacing="0" style="width:100%" border="0" id="cart-table">
        <thead>
            <tr>
                <th class="quantity"><?php echo lang('store:quantity'); ?></th>
                <th class="desc"><?php echo lang('store:item'); ?></th>
                <th style="text-align:right" class="subtotal"><?php echo lang('store:subtotal'); ?></th>
            </tr>
        </thead>
        <?php $i = 1; ?>
        <?php foreach ($this->cart->contents() as $items): ?>
            <tr>
                <td class="quantity">
                    <?php
                    echo $items['qty'];
                    ?>&times;
                </td>
                <td>
                    <?php echo $items['name']; ?>
                </td>
                <td class="right subtotal"><?php echo $items['subtotal']; ?> {{ settings:currency }}</td>
            </tr>

            <?php $i++; ?>

        <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td class="quantity">&nbsp;</td>
                <td><strong><?php echo $shipping->name; ?></strong></td>
                <td class="right subtotal"><?php echo $shipping->price; ?> {{ settings:currency }}</td>
            </tr>
            <tr>
                <td colspan="1"> </td>
                <td class="right"><strong><?php echo lang('store:total'); ?></strong></td>
                <td class="right"><?php echo ($this->cart->total() + $shipping->price); ?> {{ settings:currency }}</td>
            </tr>
        </tfoot>

    </table>
</fieldset>
<?php echo form_open(); ?>

<?php echo form_hidden('user_id', $this->session->userdata('user_id')); ?>
<?php echo form_hidden('total', $this->cart->total()); ?>
<?php echo form_hidden('shipment_method_id', $this->session->userdata('shipment_id')); ?>
<?php echo form_hidden('shipping', $this->session->userdata('shipping_cost')); ?>
<?php echo form_hidden('billing_address_id', $this->session->userdata('billing')); ?>
<?php echo form_hidden('delivery_address_id', $this->session->userdata('delivery')); ?>
<fieldset>
    <legend><?php echo lang('store:payment_method'); ?></legend>
    <ul>
        <?php foreach ($payments as $item): ?>
            <li class="<?php echo alternator('even', 'odd'); ?>">
                <label class="radio">
                    <?php echo form_radio('payment_method', $item->id, set_radio('payment_method', $item->id, FALSE)) . $item->name; ?>
                    <?php echo $item->image ? '<img src="'.$item->image.'" alt="'.$item->name.'" style="float:right;" /><br class="clear" />' : ''; ?>
                </label>
                <small><?php echo $item->desc; ?></small>
                <hr />
            </li>
        <?php endforeach; ?>
    </ul>
</fieldset>
<fieldset>    
    <span style="float: right;">
        <?php echo anchor('store/cart/', lang('store:back_to_cart')); ?> | 
        <?php echo form_submit('submit', lang('checkout:place_order')); ?>
    </span>
</fieldset>


<?php echo form_close(); ?>
