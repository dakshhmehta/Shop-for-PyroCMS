<h2>Billing address</h2>

        {{if addresses}}
            <form name="form1" action="{{url:site}}shop/checkout2/billing/" method="POST">
                <input type='hidden' value='existing' name='selection'>
                <fieldset>
                    <h2>Select an existing address</h2>
                    <table>
                        {{addresses}}
                            <tr>
                                <td>
                                    <input type="radio" name="address_id" value="{{id}}">
                                </td> 
                                <td>
                                    {{address1}}, {{address2}}  
                                </td>  
                                <td>
                                    {{city}} {{country}}   
                                </td>  
                                <td>
                                    {{state}} {{zip}}   
                                </td>                                                                         
                            </tr>
                         {{/addresses}}  
                            <tr>
                                <td>
                                    <input type="checkbox" name="sameforshipping" value="1">
                                </td> 
                                <td colspan='3'>Same for shipping</td>                                                                         
                            </tr>       
                            <tr>
                                <td>
                                    <input type="checkbox" name="useragreement" value="1">
                                </td> 
                                <td colspan='3'>Agree to Terms as Conditions</td>                                                                         
                            </tr>                      
                    </table>
            </fieldset>
            <fieldset>
                <div> 
                    <span style="float: right;">
                        <a href='{{url:site}}shop/cart'>back to cart</a>
                        <input type='submit' name='submit' value='continue'>
                    </span>
                </div>
            </fieldset>
           </form>
        {{endif}}

<hr />
<form name="form2" action="{{url:site}}shop/checkout2/billing/" method="POST">
    <input type='hidden' value='new' name='selection'>
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
                    <input type="text" name="country" value="{{country}}">
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
                    <input type="checkbox" name="sameforshipping" value="1">Shipping address is the same ?
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
                <a href='{{url:site}}shop/cart'>back to cart</a> 
                <input type='submit' name='submit' value='continue'>
            </span>
        </div>

    </fieldset>

</form>