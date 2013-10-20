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
 *
 *
 *
 * Any model extending this must have a $this->_table field
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 * 
 *
 * @author		Salvatore Bordonaro
 * @version		1.0.0.051
 * @website		http://www.inspiredgroup.com.au/
 * @system		PyroCMS 2.1.x
 *
 */
class Shop_model extends MY_Model 
{

	protected $_pyrosearch_uri_edit = 'admin/shop/product/edit/';
	protected $_pyrosearch_uri_delete = 'admin/shop/product/delete/';
	protected $_pyrosearch_singular = 'product';
	protected $_pyrosearch_plural = 'products';
	

	protected function add_to_search($id, $name,$desc)
	{
		// Load the search index model
		$this->load->model('search/search_index_m');


		$this->search_index_m->index(
		    'shop', 
		    'shop:'.$this->_pyrosearch_singular, 
		    'shop:'.$this->_pyrosearch_plural,  
		    $id,
		    $this->_pyrosearch_uri_edit.$id,
		    $name,
		    $desc, 
		    array(
		        'cp_edit_uri'   => $this->_pyrosearch_uri_edit.$id,
		        'cp_delete_uri' => $this->_pyrosearch_uri_delete.$id,
		        'keywords'      => NULL,
		    )
		);

		return TRUE;

	}



	/**
	 * 
	 * @param  [type]  $slug   [description]
	 * @param  integer $id     [description]
	 * @param  string  $prefix Prefix is only used if the slug is blank, usually we pass the product name
	 * @return [type]          [description]
	 */
	protected function get_unique_slug($slug, $id = -1, $prefix = '')
	{

		//
		// now make sure slug isn not blank
		// we want to pass the name into prefix rather than a random string so it has more contextual meaning
		//
		if(trim($slug) == "")
		{
			$slug = $prefix.$slug; 
		}

		//
		// We want to ommit the current record if we are editing.
		//
		$slug_count = $this->db->where('id !=',$id)->where('slug', $slug )->get( $this->_table )->num_rows();

		if($slug_count > 0)
		{

			$new_slug = $slug.'-'.$slug_count;

			return $this->get_unique_slug($new_slug, $id, $prefix);

		}

		return $slug;

	}	


	/**
	 * make sure the slug is valid,Use the check_slug from the helper file
	 *
	 * @access public
	 */
	protected function _check_slug($slug) 
	{
		$slug = strtolower($slug);
		$slug = preg_replace('/\s+/', '-', $slug);
		return $slug;
	}


	/**
	 * 
	 * @param  [type] $id    [description]
	 * @param  [type] $field [description]
	 * @param  [type] $value [description]
	 * @return [type]        [description]
	 */
	public function update_property($id, $field, $value) 
	{
		// Prepare
		$to_update = array(
			$field => $value,
		);
		
		return $this->update($id, $to_update);
	}	





	protected function _build_dropdown( $data_list = array() , $options_array = array() ) 
	{

		// Prepare
		$items = array();
		$items['0']  = 'None';

		$options = array();

		$options['id_field'] = 'id';
		$options['text_field'] = 'name';
		$options['field_property_id'] = 'brand_id';
		$options['current_id'] = -1;
		$options['ommit_id'] = -1;

		$_opt = array_merge($options,$options_array);


		// Built list
		foreach ($data_list as $item)
		{
	 
			if($_opt['ommit_id'] == $item->$_opt['id_field'])
			{
				//do not add self
				continue;
			}

			$items[$item->$_opt['id_field']] = $item->$_opt['text_field'];
		}
		
		// Create the drop down
        $drop = form_dropdown($_opt['field_property_id'], $items, $_opt['current_id'] );

        // Return it
        return $drop;		
	}




}