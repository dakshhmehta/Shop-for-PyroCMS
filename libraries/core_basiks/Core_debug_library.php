<?php if (!defined('BASEPATH'))  exit('No direct script access allowed');

/**
 * 
 * CoreBasiks::Debug Library gives us some extra tools to help debug our application
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
class Core_debug_library extends Core_library
{


	protected $file_path = '';

	public function __construct($params = array())
	{
		
		parent::__construct();

		log_message('debug', "Class Initialized");


		$this->file_path = $this->core_basiks_path . '/output.txt';
		
	}


	public function re_index_search()
	{	

		$this->load->model('search/search_index_m');

		//
		// Delete all from db where == shop
		//
		$this->db->where(array(
				'module'     => 'shop'
			))
			->delete('search_index');

		//now go through all items and index
		
		$this->load->model('products_front_m');

		$results = $this->products_front_m->get_all();
		
		$count =0;
		
		foreach($results as $product)
		{
			$this->add_to_search($product->id, $product->name, $product->description, $product->keywords) ;
			$count++;
		}


		return $count;
	}


	private function add_to_search($id, $name,$desc,$keywords)
	{
		// Load the search index model
		$this->load->model('search/search_index_m');


		$this->search_index_m->index(
		    'shop', 
		    'shop:product', 
		    'shop:products', 
		    $id,
		    'shop/product/'.$id,
		    $name,
		    $desc, 
		    array(
		        'cp_edit_uri'   => 'admin/shop/product/edit/'.$id,
		        'cp_delete_uri' => 'admin/shop/product/delete/'.$id,
		        'keywords'      => NULL,
		    )
		);

		return TRUE;

	}



}
// END Cart Class
