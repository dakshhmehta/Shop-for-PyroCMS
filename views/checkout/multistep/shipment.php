<h2 id="page_title">Select Shipping options</h2>

<form action="{{url:site}}shop/checkout2/shipment" method="POST" name="">

    <fieldset>
        <ul>
        {{shipments}}
            <!--img src="{{image}}"-->
           <li><input type="radio" value="{{id}}" name="shipment_id" checked>{{title}} - {{shipping_cost}}</li>
        {{/shipments}}
        </ul>
    </fieldset>

    <fieldset>    
        <span style="float: right;">
            <?php echo anchor('shop/cart/', 'back to cart'); ?> | 
            <?php echo form_submit('submit', 'continue'); ?>
        </span>
    </fieldset>

</form>
