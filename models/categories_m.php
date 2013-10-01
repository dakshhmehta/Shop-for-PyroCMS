<?php if (!defined('BASEPATH'))  exit('No direct script access allowed');
/*
 * NITRO-CART Developer Preview
 * 
 *
 *
 * Copyright (c) 2013, Salvatore Bordonaro
 * All rights reserved.
 *
 * Author: Salvatore Bordonaro
 * Version: 0.90.0.000
 *
 * Credits: - Salvatore Bordonaro (DB, Development, JavaScript)
 *
 * 			- Guido Grazioli (DB and Development)
 *
 *          - Alison McDonald (Usability, Language and Testing)
 *
 *
 *
 *
 *
 *
 *
 *
 *
 */

/**
 * NITRO CART	An explosive e-commerce solution for PyroCMS - ......and 'Open Source'
 *
 * @author		Salvatore Bordonaro
 * @version		0.90.0.000
 * @website		http://www.inspiredgroup.com.au/
 * @package		Categories Model Contoller for NITRO-CART
 * @system		PyroCMS 2.1.x
 *
 */
class Categories_m extends MY_Model 
{

	private $_description_tags = '<b><div><strong><em><i><u><ul><ol><li><p><span><a><br><br />';
    public $_table = 'shop_categories';
	
	public function __construct() 
	{
		parent::__construct();
	}


	public function get_plugin($id)
	{
		return (array) parent::get($id);
	}

	public function get_all_categories()
	{

		$categories = $this->order_by('order', 'asc')->where('parent_id',0)->get_all();


		foreach($categories as $parent)
		{
			$parent->categories = $this->get_children($parent->id);
		}


		return $categories;

	}

	public function get_children($id)
	{
		return $this->order_by('order', 'asc')->where('parent_id', $id)->get_all();
	}




	public function get_category_list()
	{
		// Get categories	
		$categories = $this->db->where('parent_id',0)->order_by('order', 'asc')->get($this->_table)->result();			

		// Built list
		foreach ($categories as $item)
		{
			$item->categories = $this->db->select('*')->where('parent_id', $item->id )->get($this->_table)->result();

		}

		return $categories;


	}


	
	public function create($input)
	{



		$slug = $this->_check_slug($input['slug']);


		//check if slug exist
		$category = $this->where('slug', $slug )->get_all();


		if(isset($category[0]))
		{
 			$suffix = $this->db->like('slug', $category[0]->slug)->get('shop_categories')->num_rows();
		}
		else
		{
			$suffix = '';
		}

		$to_insert = array(
			'name' => strip_tags($input['name']),
			'description' => strip_tags($input['description'], $this->_description_tags),
			'slug' => $slug.$suffix,
			'image_id' =>  $input['image_id'],
			'parent_id' => $input['parent_id'],
			'order' => $input['order'],
		);		

		return $this->insert($to_insert);

	}

	/**
	 *
	 * @return INT id of the updated row for success
	 * @access public
	 */
	public function edit($id, $input) 
	{
		// Prepare
		$to_update = array(
			'name' => strip_tags($input['name']),
			'description' => strip_tags($input['description'], $this->_description_tags),
			'slug' => $this->_check_slug($input['slug']),
			'image_id' =>  $input['image_id'],
			'parent_id' => $input['parent_id'],
			'order' => $input['order'],
		);
		
		return $this->update($id, $to_update);
	}


	
	/**
	 * make sure the slug is valid,Use the check_slug from the helper file
	 *
	 * @access public
	 */
	public function _check_slug($slug) 
	{
		$slug = strtolower($slug);
		$slug = preg_replace('/\s+/', '-', $slug);
		return $slug;
	}

	/**
	 * Builds
	 * @return [type] [description]
	 */
	public function build_data_tree()
	{


	}
	

	/**
	 *
	 * @chached yes
	 * @access public
	 */
	public function build_select_filter($optional = null) 
	{
		$array = $this->pyrocache->model('categories_m', 'get_all');//$array = $this->get_all();
		$ret[0] =  lang('global:select-all');
		 
		foreach ($array as $ar) 
		{
			$ret[$ar->id] = $ar->name;
		}
		return $ret;
	}

	/**
	 * @return Html select dropdown
	 * @access public
	 */
	public function build_tree_select($params =array() , $parent_name = '+') 
	{

		$params = array_merge(array(
				'tree' => array(),
				'parent_id' => 0,
				'current_parent' => 0,
				'current_id' => 0,
				'level' => 0
		), $params);
	
	
		extract($params);
	
		if (!$tree) 
		{
			if($cat_item = $this->pyrocache->model('categories_m', 'get_all') ) 
			{
				foreach ($cat_item as $c_item) 
				{
					$tree[$c_item->parent_id][] = $c_item;
				}
			}
		}
		if (!isset($tree[$parent_id]))
		{
			return;
		}

		$html = '';

		foreach ($tree[$parent_id] as $item) 
		{
			 
			if ($current_id == $item->id) 
			{
				continue;
			}
	
			$html .= '<option value="' . $item->id . '"';
	
			$html .= $current_parent == $item->id ? ' selected="selected">' : '>';
	
			if ($level > 0) 
			{
				for ($i = 0; $i < ($level * 2); $i++) 
				{
					$html .= '&nbsp;';
				}
				$html .= '&nbsp;&nbsp;';
			}
	

			$html .= $parent_name.' '.$item->name . '</option>';
			$html .= $this->build_tree_select(array(
					'tree' => $tree,
					'parent_id' => (int) $item->id,
					'current_parent' => $current_parent,
					'current_id' => $current_id,
					'level' => $level + 1
			), '- '.$item->name . ' \\' );
		}
	
		return $html;
	}	

	
	public function build_parent_dropdown($current_id = -1, $parent_id = 0) 
	{

		$items = array();
		$items['0']  = 'None';

		// Get categories	
		$categories = $this->db->where('parent_id',0)->order_by('name')->select('id, name')->get($this->_table)->result();			

		// Built list
		foreach ($categories as $item)
		{
			if($current_id == $item->id)
			{
				//do not add self
			}
			else
			{
				$items[$item->id] = $item->name;
			}
			
		}
		
		// Create the drop down
        $drop = form_dropdown('parent_id', $items, $parent_id );

        // Return it
        return $drop;	
	}

	//same as built dropbopdon but excludes self
	public function build_dropdown($current_id = 0) 
	{

		$items = array();
		$items['0']  = 'None';

		// Get categories	
		$categories = $this->db->order_by('name')->select('id, name')->get($this->_table)->result();			

		// Built list
		foreach ($categories as $item)
		{
			
			$items[$item->id] = $item->name;
			
			
		}
		
		// Create the drop down
        $drop = form_dropdown('category_id', $items, $current_id );

        // Return it
        return $drop;	
	}


}