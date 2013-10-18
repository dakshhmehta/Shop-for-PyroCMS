	<?php echo $this->load->view('admin/options/edit/edit_common'); ?>

	<?php

	switch($type)
	{
		case 'text':
		case 'file':
		case 'checkbox':
			echo $this->load->view('admin/options/edit/edit_info');
			break;		
		case 'select':
		case 'radio':
		default:
			echo $this->load->view('admin/options/edit/edit_values');
			break;
	}


	?>

	