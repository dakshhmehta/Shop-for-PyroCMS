
<div id="ncNoUser" class="collapsable_checkout">	

	<h3>Login or Register</h3>		


	<?php echo form_open("users/login"); ?>

		<div id="ncLoginContainer">

			<fieldset>

				<p>Already have an account ? Login..</p>

				<?php echo form_hidden('redirect_to', 'shop/checkout'); ?>
				

				
				<label for="email">
					<?php echo lang('email'); ?>
				</label>


				<div class="">
					<?php echo form_input('email', '', 'id="email"'); ?>
				</div>



				<label for="password">
					<?php echo lang('password'); ?>
				</label>



				<div class="">
					<?php echo form_password('password', '', 'id="password"'); ?>
				</div>
			


				<button type="submit" class="login_submit">
					<?php echo lang('user_login_btn') ?>
				</button>


				<a href='{{site:url}}users/register'>Register now</a>
	
				<label style="display:none">
						 Or 
						<?php echo form_checkbox('user_type', 'guest'); ?>
						<?php echo lang('guest_customer'); ?>
				</label>
				
			</fieldset>


		</div>

	<?php echo form_close(); ?>


</div>
