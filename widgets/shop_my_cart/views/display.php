{{# #}}
{{# Here you have access to everything in the cart - uing the cart variables #}}
{{# #}}

<ul>

	{{ contents }} 
		<li>
			{{name}} - {{price}} - {{ qty }}
		</li>
	{{ /contents }} 

	<li> Total: {{ total }} </li>

	<li> Total Items: {{ items_count }} </li>

	
</ul>


