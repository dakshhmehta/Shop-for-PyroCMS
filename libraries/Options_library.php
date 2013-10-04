<?php if (!defined('BASEPATH'))  exit('No direct script access allowed');
/*
 * SHOP for PyroCMS
 * 
 * Copyright (c) 2013, Salvatore Bordonaro
 * All rights reserved.
 *
 * Author: Salvatore Bordonaro
 * Version: 1.0.0.051
 *
 *
 *
 * 
 * See Full license details on the License.txt file
 */
 
/**
 * SHOP			A full featured shopping cart system for PyroCMS
 *
 * @author		Salvatore Bordonaro
 * @version		1.0.0.051
 * @website		http://www.inspiredgroup.com.au/
 * @system		PyroCMS 2.1.x
 *
 */
class Options_library 
{




	// Private variables.  Do not change!
	private $CI;
	



	public function __construct($params = array())
	{
	
		// Set the super object to a local variable for use later
		$this->CI =& get_instance();


		// Load the Sessions class
		//$this->CI->load->library('session', $config);


		log_message('debug', "Options Library Class Initialized");
		
	}

	
	
	
	
	public static function Process( $options, $txtClass = '' )
	{


			foreach($options as $option)
			{
						

				
				$option->title = ($option->show_title)? $option->title : "" ;
				
				switch($option->type)
				{

					case 'radio':
						$string_builder = "";
						if($option->values != NULL ) 
						{
							
							foreach($option->values as $option_value) 
							{
								
								// old
								$str = ($option_value->default)? 'checked' :'';
								$string_builder .=  form_radio('prod_options['.$option->slug.']',$option_value->value, $str ).' '.$option_value->value; 
								
								//better
								$option_value->display = form_radio('prod_options['.$option->slug.']',$option_value->value, $str ); 

							}
							

						}
						
						$option->display = $string_builder;
						
						break;	
					case 'select':
						$items = array(); //reset
						foreach ($option->values as $option_value)
						{
							$items[$option_value->value] = $option_value->value;

						}													
						$option->display =  form_dropdown('prod_options['.$option->slug.']',$items); 
						
						break;	
						
					case 'text':													
					case 'checkbox':													
					case 'default':
						$class = ($option->type == "text")? $txtClass : '';
						$class = ($option->type == "checkbox")? '' : $txtClass ;
						$class = ' class="'.$class.'" ';
						
						$option->display = "<input type='".$option->type."' name='prod_options[".$option->slug."]'  ".$class."  />";
						break;
				}
				
				
				

		
			}

		return $options;		
	
	
	}
	

	
	





}
// END Cart Class
