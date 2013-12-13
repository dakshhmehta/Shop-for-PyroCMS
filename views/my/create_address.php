<h2>Create New address</h2>

	<ul id="menu">
		{{ shop:mylinks remove='shop messages' active='addresses' }}
			{{link}}
		{{ /shop:mylinks }}	
	</ul>

<form name="form2" action="{{url:site}}shop/my/addresses/create" method="POST">

    <fieldset>
        <h2>New Address</h2>

        <ul class="two_column">
            <li>
                <label><?php echo lang('shop:address:field:first_name');?><span>*</span></label>
                <div class="input">
                    <input type="text" name="first_name" value="{{first_name}}">
                </div>
            </li>
            <li>
                <label><?php echo lang('shop:address:field:last_name');?><span>*</span></label>
                <div class="input">
                    <input type="text" name="last_name" value="{{last_name}}">
                </div>
            </li>
            <li>
                <label><?php echo lang('shop:address:field:email');?><span>*</span></label>
                <div class="input">
                     <input type="text" name="email" value="{{email}}">
                </div>
            </li>
            <li>
                <label><?php echo lang('shop:address:field:company');?><span>*</span></label>
                <div class="input">
                     <input type="text" name="company" value="{{company}}">
                </div>
            </li>            
            <li>
                <label><?php echo lang('shop:address:field:phone');?><span>*</span></label>
                <div class="input">
                    <input type="text" name="phone" value="{{phone}}">
                </div>
            </li>
            <li>
                <label><?php echo lang('shop:address:field:address1');?><span>*</span></label>
                <div class="input">
                    <input type="text" name="address1" value="{{address1}}">
                </div>
            </li>
            <li>
                <label><?php echo lang('shop:address:field:address2');?></label>
                <div class="input">
                     <input type="text" name="address2" value="{{address2}}">
                </div>
            </li>
            <li>
                <label><?php echo lang('shop:address:field:city');?><span>*</span></label>
                <div class="input">
                    <input type="text" name="city" value="{{city}}">
                </div>
            </li>
            <li>
                <label><?php echo lang('shop:address:field:state');?></label>
                <div class="input">
                    <input type="text" name="state" value="{{state}}">
                </div>
            </li>
            <li>
                <label><?php echo lang('shop:address:field:country');?></label>
                <div class="input">

                    <select name='country'>
                        {{countries}}
                            <option value='{{code}}'>{{name}}</option>
                        {{/countries}}
                    </select>

                </div>
            </li>
            <li>
                <label><?php echo lang('shop:address:field:zip');?><span>*</span></label>
                <div class="input">
                    <input type="text" name="zip" value="{{zip}}">
                </div>
            </li>
            <li>
                <label></label>
                <div class="input">
                    <input type="checkbox" name="useragreement" value="1">Agree to Terms as Conditions
                </div>
            </li>                         
        </ul>
   


    </fieldset>


    <fieldset>

        <div> 
            <span style="float: right;">
                <input type='submit' name='submit' value='Save'>
            </span>
        </div>

    </fieldset>

</form>