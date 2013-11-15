<h2>Create New address</h2>

	<ul id="menu">
		{{ shop:mylinks remove='shop messages' active='addresses' }}
			{{link}}
		{{ /shop:mylinks }}	
	</ul>

<form name="form2" action="{{url:site}}shop/my/address/" method="POST">

    <fieldset>
        <h2>New Address</h2>

        <ul class="two_column">
            <li>
                <label>First name<span>*</span></label>
                <div class="input">
                    <input type="text" name="first_name" value="{{first_name}}">
                </div>
            </li>
            <li>
                <label>surname<span>*</span></label>
                <div class="input">
                    <input type="text" name="last_name" value="{{last_name}}">
                </div>
            </li>
            <li>
                <label>Email<span>*</span></label>
                <div class="input">
                     <input type="text" name="email" value="{{email}}">
                </div>
            </li>
            <li>
                <label>Company<span>*</span></label>
                <div class="input">
                     <input type="text" name="company" value="{{company}}">
                </div>
            </li>            
            <li>
                <label>Phone<span>*</span></label>
                <div class="input">
                    <input type="text" name="phone" value="{{phone}}">
                </div>
            </li>
            <li>
                <label>address1<span>*</span></label>
                <div class="input">
                    <input type="text" name="address1" value="{{address1}}">
                </div>
            </li>
            <li>
                <label>address2</label>
                <div class="input">
                     <input type="text" name="address2" value="{{address2}}">
                </div>
            </li>
            <li>
                <label>City<span>*</span></label>
                <div class="input">
                    <input type="text" name="city" value="{{city}}">
                </div>
            </li>
            <li>
                <label>State</label>
                <div class="input">
                    <input type="text" name="state" value="{{state}}">
                </div>
            </li>
            <li>
                <label>Country</label>
                <div class="input">

                    <select name='country'>
                        {{countries}}
                            <option value='{{code}}'>{{name}}</option>
                        {{/countries}}
                    </select>

                </div>
            </li>
            <li>
                <label>ZIP/Postcode<span>*</span></label>
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