<h2 id="page_title">
    Billing address
</h2>

<div class="address_info">

{{if addresses}}
    <form name="form1" action="{{url:site}}shop/checkout2/billing/" method="POST">
    <fieldset>
        <legend>Select an existing address</legend>

            <ul>
                {{addresses}}
                    <li>
                        <label class="radio">
                            <input type="radio" name="address_id" value="{{id}}"> {{address1}}, {{address2}}{{zip}}  {{city}} 
                        </label> 
                        <a href="{{ url:site }}shop/checkout2/delete_address/{{id}}"> Delete</a>
                    </li>
                 {{/addresses}}     
            </ul>


        <p>
            <label>
                <input type="checkbox" name="delivery" value="1">Same for shipping
            </label>

        </p>

    </fieldset>
    <fieldset>
        <div> 
            <span style="float: right;">
                <?php echo anchor('shop/cart/', 'back_to_cart'); ?> | 
                <?php echo form_submit('submit', 'continue'); ?>
            </span>
        </div>
    </fieldset>
   </form>
{{endif}}

<hr />
<form name="form2" action="{{url:site}}shop/checkout2/billing/" method="POST">

     <input type="hidden" name="user_id" value="<?php echo $this->session->userdata('user_id');?>">
    <fieldset>
        <legend>New Address</legend>
        <ul class="two_column">
            <li class="<?php echo alternator('odd', 'even'); ?>">
                <label>First name<span>*</span></label>
                <div class="input">
                    <input type="text" name="first_name" value="{{first_name}}">
                </div>
            </li>
            <li class="<?php echo alternator('odd', 'even'); ?>">
                <label>surname<span>*</span></label>
                <div class="input">
                    <input type="text" name="last_name" value="{{last_name}}">
                </div>
            </li>
            <li class="<?php echo alternator('odd', 'even'); ?>">
                <label>Email<span>*</span></label>
                <div class="input">
                     <input type="text" name="email" value="{{email}}">
                </div>
            </li>
            <li class="<?php echo alternator('odd', 'even'); ?>">
                <label>Company<span>*</span></label>
                <div class="input">
                     <input type="text" name="company" value="{{company}}">
                </div>
            </li>            
            <li class="<?php echo alternator('odd', 'even'); ?>">
                <label>Phone<span>*</span></label>
                <div class="input">
                    <?php echo form_input('phone', set_value('phone', $phone)); ?>
                </div>
            </li>
            <li class="<?php echo alternator('odd', 'even'); ?>">
                <label>address1<span>*</span></label>
                <div class="input">
                    <?php echo form_input('address1', set_value('address1', $address1)); ?>
                </div>
            </li>
            <li class="<?php echo alternator('odd', 'even'); ?>">
                <label>address2</label>
                <div class="input">
                    <?php echo form_input('address2', set_value('address2', $address2)); ?>
                </div>
            </li>
            <li class="<?php echo alternator('odd', 'even'); ?>">
                <label>City<span>*</span></label>
                <div class="input">
                    <?php echo form_input('city', set_value('city', $city)); ?>
                </div>
            </li>
            <li class="<?php echo alternator('odd', 'even'); ?>">
                <label>State</label>
                <div class="input">
                    <?php echo form_input('state', set_value('state', $state)); ?>
                </div>
            </li>
            <li class="<?php echo alternator('odd', 'even'); ?>">
                <label>Country</label>
                <div class="input">
                    <?php echo form_input('country', set_value('country', $country)); ?>
                </div>
            </li>
            <li class="<?php echo alternator('odd', 'even'); ?>">
                <label>ZIP/Postcode<span>*</span></label>
                <div class="input">
                    <?php echo form_input('zip', set_value('zip', $zip)); ?>
                </div>
            </li>
        </ul>
   
        <p>
            <label><?php echo form_checkbox('sameforshipping', 1, TRUE); ?>Same for shipping</label>
        </p>

    </fieldset>
    <fieldset>

        <div> 
            <label><input type="checkbox" name="agreement" value="1">Agree to Terms as Conditions</label>

            <span style="float: right;">
                <?php echo anchor('shop/cart/', 'back to cart'); ?> | 
                <?php echo form_reset('reset', 'reset'); ?>
                <?php echo form_submit('submit', 'continue'); ?>
            </span>
        </div>

    </fieldset>
    </div>

</form>