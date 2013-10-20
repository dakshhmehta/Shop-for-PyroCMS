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
class Options_m extends MY_Model
{


	//
	// Default database table for options
	//
	public $_table = 'shop_options';
	
	
	
	//
	// Array of option types
	//
	public $option_types = array('file' =>'File Upload', 'text'=>'TextBox', 'checkbox'=>'CheckBox','select'=>'Dropdown','radio'=>'RadioButton' ); 
	

	protected $option_operators = array(

			' ' => '-- No Action --', 
			
			'Standard' => array(
				'+' => 'Price &plus; Amount', 
				'-' => 'Price &minus; Amount', 
				//'*' => 'Price &times; Amount', 								
			),
			'Intermediate' => array(
				'+q' => 'Price &plus; (QTY &times; Amount)' , 
				'-q' => 'Price &minus; (QTY &times; Amount)' , 
				//'*q' => 'Price &times; (QTY &times; Amount)' , 	
			),
			'Advanced' => array(
				'=' => 'Price = Amount (!warning)' ,  
			)
		);

	

	
	public function __construct() 
	{
		parent::__construct();

		$this->load->model('shop/options_values_m');
	}
	
	


	/**
	 *
	 * 
	 * @param INT $id	The unique Option ID for the option
	 * @return Returns the option complete with the values associated with it
	 * @access public
	 */
	public function get($id) 
	{
	
		// Get option from shop_options where id = $id
		$option = parent::get($id); 			
		
		
		// Get the values associated with this option
		$option->values = $this->options_values_m->get_all_options($id);

	
		return $option;
		
	}

	
	
	/**
	 * get_options : get all options available by product id
	 *
	 *
	 * @param INT $id The product ID we are looking for associated options
	 * @return Array - All the options associated with a product complete with their values and modifiers
	 * @access public
	 */
	public function get_options($id) 
	{
	
		//
		// init the return array of optoins
		//
		$options_array = array();
		

		// 
		// get all the option id's assigned to the product
		//
		$items = $this->db->order_by('order','asc')->where('prod_id',$id)->get('shop_prod_options')->result(); 			
		

		
		foreach($items as $item)
		{
		
			//
			// Get the option from the option id and Assign it to the option array
			//
			$options_array[] = $this->get($item->option_id); 	

		
		}
		
		
		
		return $options_array;
	
	}
	

	

	
	
	/**
	 *
	 * @return Mixed (FALSE|Option)
	 * @access public
	 */
	public function get_by_slug($slug = '')
	{
	
		$option = $this->get( array('slug' => $slug) ); 			
		
		if(count($option))
		{
			//get the values
			$option->values =$this->options_values_m->get_all_options($option->id);   
			return $option;
		}
		
		return FALSE;
		
	}
	
	

	
	
	/** Create()
	 *
	 * @param Array $input User Input data
	 * @access public
	 */
	public function create($input) 
	{
		
		$this->db->trans_start();
		
		$update_array = array(
			'name' => strip_tags($input['name']),
			'title' => strip_tags($input['title']),
			'description' => strip_tags($input['description']),
			'slug' => sf_generate_slug($input['name']),
			'show_title' => 1, /*future enhancement will be to give option to NOT display the title/name */
			'type' => $input['type'],
		);

		$result = $this->insert($update_array);
		
		if (!$result)
			return FALSE;
	   
		$this->db->trans_complete();

		return ($this->db->trans_status() === FALSE) ? FALSE : $result;
	}
	


	
	/** Duplicate product option
	 *
	 *
	 * @param INT $id
	 * @return
	 * @access public
	 */
	public function duplicate($id) 
	{
		// Get the original product
		$option = $this->get($id);
		
		// This is to get bettwe slug and sku code field when duplicating
        $count = $this->db->like('name', $option->name)->get('shop_options')->num_rows();

		if ($option==NULL) return FALSE;
		
		$name = $option->name.' ('.( $count + 1 ).')';
		
		$to_insert = array(
				'name' => $name,
				'title' => $option->title,
				'description' => $option->description,
				'slug' => sf_generate_slug($name),				
				'type' => $option->type,
				'show_title' => $option->show_title,				
		);
		
		return $this->insert($to_insert); //returns id
		
	}
	

	
	
	/** edit product option
	 *
	 *
	 * @param INT $id
	 * @param Array $input
	 * @return
	 * @access public
	 */
	public function edit($id, $input) 
	{
		
		$this->db->trans_start();
		
		$update_array = array(
			'name' => strip_tags($input['name']),
			'title' => strip_tags($input['title']),
			'description' => strip_tags($input['description']),
			'slug' => sf_generate_slug($input['name']),
			'type' => $input['type'], 
			'show_title' => isset($input['show_title'])? 1 :0, 
		);

		$result = $this->update($id, $update_array);
		
		if (!$result)
			return FALSE;
	   
		$this->db->trans_complete();

		return ($this->db->trans_status() === FALSE) ? FALSE : $result;
	}
	
	
	
	
	
	/**
	 * Delete
	 *
	 * @param INT $id
	 * @access public
	 */
	public function delete($id)
	{
	
		$this->db->trans_start();
		
		
		//
		// Checking to see if the oprion is assigned to products
		//
		$items = $this->db->where('option_id',$id)->get('shop_prod_options')->result(); 	
	

		//
		// Cant delete is a product has been assined
		//
		if(count($items))
		{
			$del = FALSE;
		}
		else
		{
			//
			// First lets delete all values
			//
			$this->db->where('shop_options_id',$id)->delete('shop_option_values'); 
			
			
			$del = TRUE;
			
			//Now delete this
			parent::delete($id);
		}
		
		
		$this->db->trans_complete();
		
		
		return $del;
	
	}

		
	
	
	public function get_option_by_id( $id , $value)
	{
		$this->load->model('options_values_m');
	
		//
		// Get the option
		//
		$option = parent::get($id); 

		//
		// If we dont have an option lets return false
		//
		if(!$option) return FALSE;


		//
		// Depending on the option type we have diff actions
		//
		switch($option->type)
		{
			case 'file':
			case 'hidden':				
			case 'text':
				break;
			default:
				//$option->values = $this->db->where('value',$value)->where('shop_options_id', $id )->get('shop_option_values')->result();
				$option->values = $this->options_values_m->get_by('id',$value);
				break;


		}

		return $option;
	}
	
	/**
	 * @deprecated
	 * 
	 * @param  [type] $slug  [description]
	 * @param  [type] $value [description]
	 * @return [type]        [description]
	 */
	public function get_option_value_by_slug( $slug, $value)
	{
	
	
		$option = $this->where( array('slug' => $slug) )->get_all(); 			
		
		if(count($option))
		{

			switch($option[0]->type)
			{
				case 'file':
				case 'hidden':				
				case 'text':
					return $option[0];
					break;
				default:
					$values = $this->db->where('value',$value)->where('shop_options_id',$option[0]->id)->get('shop_option_values')->result();
					break;


			}


			//get the values //get first in the stack
			$option[0]->values =  $values[0];
			
		
			return $option[0];
		}
		
		return FALSE;
		
	}
	
	


	
	
	/**
	 * Build a dropdown of the available options
	 * This is used in product edit to select a option to assign to it.
	 *
	 * @param
	 * @return
	 * @access public
	 */
	public function build_dropdown($current_id = 0) 
	{
		// Prepare
		$items = array();
		$items['0']  = 'None';

		// Get options	
		$options = $this->order_by('name')->select('id, slug, name')->get_all();			

		// Built list
		foreach ($options as $item)
			$items[$item->id] = $item->name;
		
		// Create the drop down
        $drop = form_dropdown('option_id', $items, $current_id );

        // Return it
        return $drop;		
	}
	
	
	
	
	public function get_option_operators()
	{


		return $this->option_operators;
	
	}

	
	/**
	 *
	 *
	 * NOT READY YET
	 */
	public function build_operators_dropdown($current_id = 0) 
	{

		// Create the drop down
        $drop = form_dropdown('option_id', $this->option_operators , $current_id );

        // Return it
        return $drop;		
	}


	
	
	/** build_option_types_dropdown
	 *
	 * @param String $current_id The key value (option type) that is selected. 
	 * @param bool $readonly If this is set then only the text value of the selected option is selected.
	 * @return Mixed (String|Dropdown) Either the String value for readonly or a dropdown value of all option types
	 * @access public
	 */
	public function build_option_types_dropdown($current_id = 'radio', $readonly = FALSE) 
	{
			
		// Create the drop down
		if(!$readonly)
		{
			$drop = form_dropdown('type', $this->option_types , $current_id );
		}
		else
		{
			$drop = form_hidden('type', $current_id ).$this->option_types[$current_id];
		}	

        // Return it
        return $drop;		
	}


	
	
	
	/**
	 * @return validation rules
	 *
	 * @access public
	 */
	public function get_validation_rules($mode = 'create')
	{
		if( $mode =='create' )
		{
			return array(
				
				array(
					'field' => 'name',
					'label' => 'lang:name',
					'rules' => 'trim|required|max_length[100]'
				),					
				array(
					'field' => 'title',
					'label' => 'lang:title',
					'rules' => 'trim|max_length[100]'
				),		
				array(
					'field' => 'description',
					'label' => 'lang:description',
					'rules' => 'trim|required|max_length[100]'
				),				
				array(
					'field' => 'type',
					'label' => 'lang:type',
					'rules' => 'trim|required|max_length[100]'
				)
				
			);
		}
		else
		{
			return array(
				
				array(
					'field' => 'name',
					'label' => 'lang:name',
					'rules' => 'trim|required|max_length[100]'
				),					
				array(
					'field' => 'title',
					'label' => 'lang:title',
					'rules' => 'trim|max_length[100]'
				),		
				array(
					'field' => 'description',
					'label' => 'lang:description',
					'rules' => 'trim|required|max_length[100]'
				),				
				
			);

		
		}
		
	
	}

	
	
	/**
	 * @return validation rules
	 *
	 *
	 */
	public function get_value_validation_rules()
	{
	
		return array(

			array(
				'field' => 'value',
				'label' => 'lang:value',
				'rules' => 'trim|required|max_length[100]'
			),
			array(
				'field' => 'operator',
				'label' => 'lang:operator',
				'rules' => 'trim|max_length[2]'
			),
			array(
				'field' => 'operator_value',
				'label' => 'lang:operator_value',
				'rules' => 'trim|required|numeric'
			),		
			array(
				'field' => 'max_qty',
				'label' => 'lang:max_qty',
				'rules' => 'trim|required|numeric'
			),				
		);
		
	
	}

	
}


