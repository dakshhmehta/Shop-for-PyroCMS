	<?php
	case '1.0.0.0509':

				$tbls = $this->install_tables( 

					array('shop_trust_data' => array(
						'id' => array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE, 'auto_increment' => TRUE, 'primary' => TRUE),
						'score' =>  array('type' => 'INT', 'constraint' => '1', 'default' => 1), /*product group */
						'category' => array('type' => 'VARCHAR', 'constraint' => '50', 'default' => ''),   /*user group*/
						'word' => array('type' => 'VARCHAR', 'constraint' => '200', 'default' => ''), /*product group */
						'count' => array('type' => 'INT', 'constraint' => '1', 'unsigned' => TRUE, 'default' => 1),  /*times used*/
						'enabled' => array('type' => 'INT', 'constraint' => '1', 'unsigned' => TRUE, 'default' => 1),  
					)) 

				);
			

				$data = array();

				foreach($this->details_library->get_array('trust_score') as $key => $value)
				{
					$data[] = array(
							'score' => $value['score'],
							'category' => $value['category'],
							'word' => $value['word'],
							'count' => 0,
							'enabled' => 1,
							);
				}

				$this->db->insert_batch('shop_trust_data', $data);


				break;
			case '1.0.0.0508':
				$tbls = $this->install_tables( 

					array('shop_group_prices' => array(
						'id' => array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE, 'auto_increment' => TRUE, 'primary' => TRUE),
						'pgroup_id' => array('type' => 'VARCHAR', 'constraint' => '150'), /*product group */
						'ugroup_id' => array('type' => 'VARCHAR', 'constraint' => '2'),  /*user group*/
						'min_qty' => array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE, 'default' => 0),  
						'price' => array('type' => 'DECIMAL(10,2)', 'null' => TRUE, 'default' => 0),
					)) 

				);
				break;
			case '1.0.0.0507':

					$this->db->insert('email_templates', array(
						'slug' => 'sf_admin_blacklist',
						'name' => 'Shop: An attempt to place order was blocked',
						'description' => 'This email will be sent to Administrators when an attempt to place an order for a user or group that has been blacklisted',
						'subject' => 'An attempt to place order was blocked',
						'body' => '<h1>Details</h1>
							<b>Date:</b> {{ date }}<br />
							<b>User Email:</b> {{ email }}<br />
							<b>IP Address:</b> {{ ip_address }}<br /><br />
							<p><b>Order Total:</b>{{ cost_total }}</p><br />		
							<p><b>Shipping Address:</b>{{ shipping_address }}</p><br />		
							',
						'lang' => 'en',
						'is_default' => 1,
						'module' => 'shop'
					));
				break;

			case '1.0.0.0506':

				$data = array();

				foreach($this->countryList as $key => $value)
				{
					$data[] = array(
							'name' => $value,
							'code2' => $key,
							'code3' => '',
							'enabled' => 0,
							);
				}

				$this->db->insert_batch('shop_countries', $data);
				break;


			case '1.0.0.0505':
				$tbls = $this->install_tables( 

				
					array('shop_countries' => array(
						'id' => array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE, 'auto_increment' => TRUE, 'primary' => TRUE),
						'name' => array('type' => 'VARCHAR', 'constraint' => '150'),
						'code2' => array('type' => 'VARCHAR', 'constraint' => '2'), 
						'code3' => array('type' => 'VARCHAR', 'constraint' => '3', 'default' => ''), /*not used in this ver*/
						'enabled' => array('type' => 'INT', 'constraint' => '1', 'default' => 0),
					)) 

				);
				break;


			case '1.0.0.0504':
				$tbls = $this->install_tables( 

				
					array('shop_blacklist' => array(
						'id' => 			array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE, 'auto_increment' => TRUE, 'primary' => TRUE),
						'name' => 			array('type' => 'VARCHAR', 'constraint' => '200'),
						'method' => 		array('type' => 'INT', 'constraint' => '4', 'default' => 2), 
						'value' => 			array('type' => 'VARCHAR', 'constraint' => '300', 'default' => ''), 
						'enabled' => 		array('type' => 'INT', 'constraint' => '1', 'default' => 1), 
					)) );

				break;