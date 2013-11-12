<h2 id="page_title">Select payment method</h2>

<form action="{{url:site}}shop/checkout2/gateway" method="POST" name="form_gateways">

    <fieldset>
        <ul>
        {{gateways}}
            <!--img src="{{image}}"-->
           <li><input type="radio" value="{{id}}" name="gateway_id" checked>{{title}}</li>
        {{/gateways}}
        </ul>
    </fieldset>

    <fieldset>    
        <span style="float: right;">
            <?php echo anchor('shop/cart/', 'back to cart'); ?> | 
            <?php echo form_submit('submit', 'continue'); ?>
        </span>
    </fieldset>

</form>
