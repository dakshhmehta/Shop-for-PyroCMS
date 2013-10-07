<!--- FILE.START:VIEW.PRODUCTS.SINGLE.PHP -->
<div id="" itemscope itemtype="http://schema.org/Product">

	<?php echo form_open('shop/cart/add'); ?>
	<?php echo form_hidden('id', $product->id); ?>

	

			<!--  
			   -
			   - Display Product Images:note that cover image does not sit in the images array 
			   -
			   -->
			<img itemprop="image" src="{{ url:site }}files/large/{{product:cover_id}}/50/" alt="" />

			{{product:images}}
				<img itemprop="image" src="{{ url:site }}files/large/{{file_id}}/80/" alt="" />
			{{/product:images}}




			<!--  
			   -
			   - Do somethiong special if the product is marked as special
			   -
			   -->
			{{ if product:featured == 1}}
				this product is featured
			{{endif}}



			<!--  
			   -
			   - Here is the common product data
			   -
			   -->
			   <table>
			   		<tr>
				   		<td style="width:200px;">
				   			Name
				   		</td>
				   		<td>
				   			{{product:name}}
				   		</td>				   		
			   		</tr>
			   		<tr>
						<!--  
						   -
						   - Price AT is After tax, we also have price_bt and price but this is variable.
						   -
						   -->			   		
				   		<td>
				   			Price
				   		</td>
				   		<td>
				   			{{product:price_at}} - we can also format the price like so
				   			{{shop:pricer price="{{product:price_at}}" }} 
				   		</td>				   		
			   		</tr>			   		
			   		<tr>
				   		<td>
				   			Meta Desc
				   		</td>
				   		<td>
				   			{{product:meta_desc}}
				   		</td>				   		
			   		</tr>	
			   		<tr>
				   		<td>
				   			Category Data
				   		</td>
				   		<td>
				   			{{product:category}}
				   				{{slug}} {{name}}
				   			{{/product:category}}
				   		</td>				   		
			   		</tr>	

			   		<tr>
				   		<td>
				   			 Status
				   		</td>
				   		<td>
				   			{{product:status}}
				   		</td>				   		
			   		</tr>


			   		<tr>
				   		<td>
				   			 Inv QTY
				   		</td>
				   		<td>
				   			{{product:inventory_on_hand}}
				   		</td>				   		
			   		</tr>	


			   		<tr>
				   		<td>
				   			 Visitor Views
				   		</td>
				   		<td>
				   			{{product:views}}
				   		</td>				   		
			   		</tr>	


			   </table>


			<!--  
			   -
			   - Here how we can show the prodct options
			   -
			   -->								
				{{ shop:options id="<?php echo $product->id;?>"  txtBoxClass="txtForms" }}	
				<tr>
					<th>{{ title }}</th>
					
					{{ if has_values }}							
						<td>
						{{ values}}
							{{display}} {{label}}<br />
						{{/values}}
						</td>	
					{{ else }}
						<td>	
						{{display}}
						</td>		
					{{ endif }}
							
					<br />

				</tr>
				{{ /shop:options }}
										
	
						


				<input class="" type="submit" value='Add to cart' /> 

				
				<a href="{{ url:site }}shop/my/wishlist/add/{{ product:id }}" >
					Add to wishlist
				</a>

				<table>

			   		<tr>
				   		<td>
				   			 description
				   		</td>
				   		<td>
				   			{{product:description}}
				   		</td>				   		
			   		</tr>	


			   		<tr>
				   		<td>
				   			 SKU Code
				   		</td>
				   		<td>
				   			{{product:code}}
				   		</td>				   		
			   		</tr>


			   		<tr>
				   		<td>
				   			 Keywords
				   		</td>
				   		<td>
				   			
				   		</td>				   		
			   		</tr>
		

			   		{{product:attributes}}
			   		<tr>
				   		<td>
				   			{{name}}
				   		</td>
				   		<td>
				   			{{value}}
				   		</td>				   		
			   		</tr>	
			   		{{/product:attributes}}



<?php echo form_close(); ?>
