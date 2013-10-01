<ul>
	<?php foreach($categories as $category): ?>
		<li><a href='{{url:site}}shop/category/<?php echo $category->slug; ?>'><?php echo $category->name; ?></a></li>
	<?php endforeach; ?>
</ul>