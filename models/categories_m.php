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


require_once(dirname(__FILE__) . '/' .'shop_model.php');


class Categories_m extends Shop_model 
{

	private $_description_tags = '<b><div><strong><em><i><u><ul><ol><li><p><span><a><br><br />';
    public $_table = 'shop_categories';
	
	public function __construct() 
	{
		parent::__construct();

		$this->_pyrosearch_uri_edit = 'admin/shop/categories/edit/';
		$this->_pyrosearch_uri_delete = 'admin/shop/categories/delete/';
		$this->_pyrosearch_singular = 'category';
		$this->_pyrosearch_plural = 'categories';


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


		$_name = strip_tags($input['name']);

		$to_insert = array(
			'name' => $_name,
			'description' => strip_tags($input['description'], $this->_description_tags),
			'slug' => $slug.$suffix,
			'image_id' =>  $input['image_id'],
			'parent_id' => (isset($input['parent_id']))?$input['parent_id']:0,
			'order' => intval($input['order']),
			'user_data' => $input['user_data'],
		);		

		$id = $this->insert($to_insert);

		if($id)
		{
			$this->add_to_search($id, $_name, strip_tags($input['description']) );
		}

		return $id;

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
			'parent_id' =>(isset($input['parent_id']))?$input['parent_id']:0,
			'order' => intval($input['order']),
			'user_data' => $input['user_data'],
		);
		
		return $this->update($id, $to_update);
	}


	public function build_dropdown( $in_options = array() ) 
	{

		$options =array();
		$options['field_property_id'] = 'category_id';
		$options['current_id'] = -1;
		$options['parent_id'] = -1;
		$options['ommit_id'] = -1;
		$options['type'] = 'all';


		$options = array_merge($options,$in_options);

		$categories = $this->db->where('parent_id',0)->order_by('parent_id')->select('id, name, parent_id')->get($this->_table)->result();

		$new_list = array();


		if( ($options['type'] =='parent') && ($options['parent_id'] == 0) )
		{

		}
		else
		{

			foreach ($categories as $key => $category) 
			{ 
				switch( $options['type'] )
				{
					case 'all':
						$category->subs = $this->db->where('parent_id',$category->id)->order_by('name')->select('id, name,parent_id')->get($this->_table)->result();
						break;
					case 'parent':
						if($category->parent_id == 0)
							continue;
						break;
					default:
						$category->subs = array();
						break;
				}

				$category->name = "&raquo; " .  $category->name;
				$new_list[] = $category;

				foreach ($category->subs as $sub_key => $sub_category) 
				{
					$sub_category->name =  "&nbsp;&nbsp;". $category->name . " &rarr; " . $sub_category->name;
					$new_list[] = $sub_category;
				}


			}
		}

		return $this->_build_dropdown($new_list , $options );

	}




	public function replicate_to_child($parent_id = NULL,$field = NULL, $value = '')
	{

		$failed = FALSE;
		$count = 0;

		$children = $this->get_children($parent_id);

		foreach ($children as $key => $child) 
		{
			if($this->update_property($child->id, $field,$value))
			{
				$count++;
			}
			else
			{
				$failed = TRUE;
			}
		}

		return $count;
	}





}