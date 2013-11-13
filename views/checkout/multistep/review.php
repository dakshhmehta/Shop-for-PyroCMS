<h2>Review your order</h2>

    <h2>Shopping cart</h2>
    <table>
        <thead>
            <tr>
                <td>Details</td>
                <td>Qty</td>
                <td style="text-align:right">Subtotal</td>
            </tr>
        </thead>
        <tbody>
            {{cart}}
                <tr>
                    <td>{{name}}</td>
                    <td>{{qty}}</td>
                    <td>{{shop:currency}}{{subtotal}}</td>
                </tr>
            {{/cart}} 
                <tr>
                    <td>Shipping</td>
                    <td></td>
                    <td>{{shop:currency}} {{shipping_cost}}</td>
                </tr>   

                <tr>
                    <td>Total</td>
                    <td></td>
                    <td>{{shop:currency}} {{order_total}}</td>
                </tr>   
                         
        </tbody>
    </table>

    <br/><br />

    <h2>Shipping Information</h2>
    <table>
        <tbody>
                <tr>
                    <td> 
                        {{shipping_address.address1}}, {{shipping_address.address2}} {{shipping_address.city}}
                        {{shipping_address.country}}, {{shipping_address.state}}  {{shipping_address.zip}}
                    </td>
                </tr>                
        </tbody>
    </table>


<form method='post' action='{{url:site}}shop/checkout2/review'>
    <fieldset>
            <div> 
                <span style="float: right;">
                    <a href='{{url:site}}shop/cart'>back to cart</a> 
                    <input type='submit' name='submit' value='continue'>
                </span>
            </div>
    </fieldset>
</form>

