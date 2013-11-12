<h2 id="page_title"><?php echo lang('store:summary_title'); ?></h2>
<?php
if (validation_errors()) {
    echo '<div class="error">';
    echo validation_errors();
    echo '</div>';
}
?>
<fieldset>
    <legend>Items</legend>
    <table cellpadding="0" cellspacing="0" style="width:100%" border="0" id="cart-table">
        <thead>
            <tr>
                <th class="quantity"><?php echo lang('store:quantity'); ?></th>
                <th class="desc"><?php echo lang('store:item'); ?></th>
                <th style="text-align:right" class="subtotal"><?php echo lang('store:subtotal'); ?></th>
            </tr>
        </thead>
        <?php $i = 1; ?>
        <?php foreach ($cart as $items): ?>
            <tr>
                <td class="quantity">
                    <?php
                    echo $items['qty'];
                    ?>x
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
                <td colspan="1"> </td>
                <td class="right"><strong>Total</strong></td>
                <td class="right"><?php echo $this->cart->total(); ?> {{ settings:currency }}</td>
            </tr>
        </tfoot>

    </table>
</fieldset>
<?php echo form_open(); ?>
<?php echo form_hidden('customer_id', $this->session->userdata('customer_id')); ?>
<?php echo form_hidden('total', $this->cart->total()); ?>
<?php echo form_hidden('shipping', $this->session->userdata('shipment')); ?>
<?php echo form_hidden('shipping_id', $this->session->userdata('shipping_id')); ?>
<?php echo form_hidden('invoice_id', $this->session->userdata('invoice_id')); ?>
<fieldset>
    <legend>Shipment</legend>
    <ul>
        <li><b>Payment:</b> <?php echo $this->session->userdata('payment'); ?></li>
        <li><b>Shipment Cost:</b> <?php echo $this->session->userdata('shipment'); ?> {{ settings:currency }}</li>
        <li><b>Shipment Address:</b> <?php echo $shipment_address; ?></li>
    </ul>
</fieldset>

<?php if ($this->session->userdata('payment') == 'front'): ?>
    <fieldset>
        <legend>Payment Method</legend>
        <ul>
            <li>
                <label for="payment_method">Select preferable payment method: </label><br />
                <div class="input">
                    <label><?php echo form_radio('payment_method', 'traditional'); ?> Traditional Transfer Method </label><br />
                    <label><?php echo form_radio('payment_method', 'digital'); ?> Digital Transfer Method </label><br />
                </div>
            </li>
            <li><hr /></li>
            <li>
                <label for="payment_provider">Select preferable payment provider: </label><br />
                <div class="input">
                    <label><?php echo form_radio('payment_provider', 'none', TRUE); ?> -- none -- </label><br />
                    <label><?php echo form_radio('payment_provider', 'paypal'); ?> Paypal </label><br />
                    <label><?php echo form_radio('payment_provider', 'payu'); ?> PayU </label><br />
                    <label><?php echo form_radio('payment_provider', 'dotpay'); ?> DotPay </label><br />
                    <label><?php echo form_radio('payment_provider', 'stripe'); ?> Stripe </label><br />
                    <label><?php echo form_radio('payment_provider', 'authorize'); ?> Authorize.NET </label><br />
                </div>
            </li>
        </ul>
    </fieldset>
<?php endif; ?>

<fieldset>
    <div>    
        <span style="float: right;">
            <?php echo anchor('store/cart/', 'Back to your cart', 'class=""'); ?> | 
            <?php echo form_submit('submit', 'Continue', 'class="orange"'); ?>
        </span>
    </div>
</fieldset>

<?php echo form_close(); ?>