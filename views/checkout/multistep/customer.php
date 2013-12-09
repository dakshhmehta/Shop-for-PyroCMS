

<form name="" method="post" action="{{url:site}}shop/checkout/">
    <fieldset>
        <p>Continue as guest or register a user account</p><br />

        <ul>
            <li class="<?php echo alternator('odd', 'even'); ?>">
                <div class="input">
                    <label><?php echo form_radio('customer', 'guest', set_radio('customer', 'guest')); ?>Continue as Guest</label>
                </div>
            </li>

            <li class="<?php echo alternator('odd', 'even'); ?>">
                <div class="input">
                    <label>
                        <input type='radio' name='customer' value='register'>
                        Register then checkout
                    </label>
                </div>
            </li>

        </ul>

        <div> 
            <span>
                <a href='{{url:site}}shop/cart'>back to cart</a> 
                <input type='submit' name='submit' value='continue'>
            </span>         
        </div>        

    </fieldset>
</form>

<hr />


<fieldset>

    <p>Or if you a a returning customer, login here</p> <br />


    <form name="logincheckout" method="post" action="{{url:site}}users/login">

        <input type='hidden' name='redirect_to' value='shop/checkout'>

        <ul>
            <li>
                <label>email</label>
                <div class="input">
                    <input type='text' name='email' value='' style='' id="email" maxlength="120">
                </div>
            </li>
            <li>
                <label>password</label>
                <div class="input">
                    <input type='text' name='password' value='' style='' id="password" maxlength="20">
                </div>
            </li>
            <li>
                <label>
                    <input type='checkbox' name='remember' value='1'>
                    Remember Me
                </label>
            </li>

            <li class="links">
                <span id="reset_pass">
                     <a href='{{url:site}}users/reset_pass'>forgot your password ?</a> 
                </span>
            </li>

        </ul>



        <div class="login-buttons">
            <button type="submit" class="login_submit">
                Login
            </button>
        </div>  
    </form>
</fieldset>
