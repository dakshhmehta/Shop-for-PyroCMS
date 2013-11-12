

<?php echo form_open(); ?>
    <fieldset>
        <legend>Customer</legend>
        <p>new custoemr description</p>

        <ul>
            <li class="<?php echo alternator('odd', 'even'); ?>">
                <div class="input">
                    <label><?php echo form_radio('customer', 'guest', set_radio('customer', 'guest')); ?>Continue as Guest</label>
                </div>
            </li>

            <li class="<?php echo alternator('odd', 'even'); ?>">
                <div class="input">
                    <label><?php echo form_radio('customer', 'register', set_radio('customer', 'register')); ?>Register then checkout</label>
                </div>
            </li>

        </ul>

        <div>    
             
            <?php echo anchor('shop/cart/', 'back to cart'); ?> | 
            <?php echo form_submit('submit', 'continue'); ?>
          
        </div>
    </fieldset>
<?php echo form_close(); ?>


<fieldset>
    <legend><?php echo lang('checkout:returning_customer_title'); ?></legend>
    <p><?php echo lang('checkout:returning_customer_desc'); ?></p>
    <?php echo form_open('users/login'); ?>
    <?php echo form_hidden('redirect_to', 'store/checkout/address'); ?>
    <ul>
        <li>
            <label><?php echo lang('email_label'); ?></label>
            <div class="input">
                <?php echo form_input('email', '', 'id="email" maxlength="120"'); ?>
            </div>
        </li>
        <li>
            <label><?php echo lang('password_label'); ?></label>
            <div class="input">
                <?php echo form_password('password', '', 'id="password" maxlength="20" '); ?>
            </div>
        </li>
        <li>
            <label><?php echo form_checkbox('remember', '1', FALSE); ?><?php echo lang('user_remember') ?></label>
        </li>
        <li class="links">
            <span id="reset_pass"><?php echo anchor('users/reset_pass', lang('forgot_password_label')); ?></span>
        </li>
    </ul>

    <div class="clear">&nbsp;</div>

    <div class="login-buttons">
        <button type="submit" class="login_submit">
            <?php echo lang('user_login_btn') ?>
        </button>
    </div>

    <div class="clear">&nbsp;</div>

    <?php echo form_close(); ?>
</fieldset>
