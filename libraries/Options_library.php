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

		log_message('debug', "Options Library Class Initialized");
		
	}

	
	
	
	
	public static function Process( $options, $settings_in = array() )
	{

		$_settings['radioBR'] 		= '<br />';
		$_settings['radioLabel'] 	= ''; //before|after|<blank>|';
		$_settings['radioCLASS'] 	= '';
		$_settings['txtClass'] 		= '';

		//combine
		$_settings = array_merge($_settings,$settings_in);



		$file_count = 0;
		$text_count = 0;


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
								//var_dump($option_value);die;
								// old
								$str = ($option_value->default)? 'checked' :'';
								$string_builder .=  form_radio('prod_options_'.$option->id.'',$option_value->id, $str ).' '.$option_value->label. '<br />'; 
								
								//better
								$option_value->display = form_radio('prod_options_'.$option->id.'',$option_value->id, $str ); 

							}
							
							
						}
						
						$option->display = $string_builder;
						$option->label = '';
						$option->form = '';
						
						break;	
					case 'select':
						$items = array(); //reset
						foreach ($option->values as $option_value)
						{
							$items[$option_value->id] = $option_value->label;

						}													
						$option->display =  form_dropdown('prod_options_'.$option->id.'',$items); 
						
						break;	

					case 'file':
						$file_count++;
						$option->display = "<input type='file' name='prod_options_".$option->id."'>";								
						break;	


					case 'text':
						$text_count++;													
						$class = ' class="'.$_settings['txtClass'].'" ';					
						$option->display = "<input type='".$option->type."' name='prod_options_".$option->id."'  ".$class."  />";
						break;

			
					case 'checkbox':													
					case 'default':
						$class = ' class="" ';
						$option->display = "<input type='".$option->type."' name='prod_options_".$option->id."'  ".$class."  />";
						break;
				}
				
				
				

		
			}

		return $options;		
	
	
	}
	

	
	





}
// END Cart Class
