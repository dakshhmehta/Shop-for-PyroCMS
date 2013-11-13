<h2 id="page_title">Select Shipping options</h2>

<form action="{{url:site}}shop/checkout2/shipment" method="POST" name="">

    <fieldset>
        <table>
        {{shipments}}
            <!--img src="{{image}}"-->
           <tr>
                <td><input type="radio" value="{{id}}" name="shipment_id" checked></td>
                <td>{{title}}</td>
                <td>{{shop:currency}} {{shipping_cost}}</td>
            </tr>
        {{/shipments}}
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
