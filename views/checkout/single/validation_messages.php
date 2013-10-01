

		<?php $message = $this->session->flashdata('error'); ?>
		<?php if ($message !=null): ?>
			<div class="error">
				<?php echo $message; ?>
			</div>
		<?php endif; ?>
		
		
		<?php if (validation_errors()) {  echo '<div class="error">'. validation_errors().'</div>'; } ?>