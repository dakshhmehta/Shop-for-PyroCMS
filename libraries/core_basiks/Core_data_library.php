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
class Core_data_library extends Core_library
{


	protected $file_path = '';

	public function __construct($params = array())
	{
		
		parent::__construct();

		log_message('debug', "Class Initialized");

		$this->file_path = $this->core_basiks_path . '/trust_words.php';
		
	}




	public function write($table_data)
	{	

	}


	public function get_all()
	{
		$_untrusted_words = array();

		//
		// Commerce scores can vary based on the value as the shop is a commerce system
		//
		$_untrusted_words[] = array('score'=> 1, 'category' => 'commerce', 'word' => 'As seen on' );
		$_untrusted_words[] = array('score'=> 1, 'category' => 'commerce', 'word' => 'Buying judgments' );
		$_untrusted_words[] = array('score'=> 1, 'category' => 'commerce', 'word' => 'Order status' );
		$_untrusted_words[] = array('score'=> 1, 'category' => 'commerce', 'word' => 'buy' );
		$_untrusted_words[] = array('score'=> 1, 'category' => 'commerce', 'word' => 'clearance' );
		$_untrusted_words[] = array('score'=> 1, 'category' => 'commerce', 'word' => 'order shipped by' );
		$_untrusted_words[] = array('score'=> 1, 'category' => 'commerce', 'word' => 'buy direct' );
		$_untrusted_words[] = array('score'=> 1, 'category' => 'commerce', 'word' => 'clearance' );

		//
		// Persoinals get a high risk score
		//
		$_untrusted_words[] = array('score'=> 2, 'category' => 'personal', 'word' => 'Dig up dirt on friends' );
		$_untrusted_words[] = array('score'=> 2, 'category' => 'personal', 'word' => 'Meet singles' );
		$_untrusted_words[] = array('score'=> 2, 'category' => 'personal', 'word' => 'Score with babes' );

		//
		// Employment 
		//
		$_untrusted_words[] = array('score'=> 2, 'category' => 'employment ', 'word' => 'Additional Income' );
		$_untrusted_words[] = array('score'=> 2, 'category' => 'employment', 'word' => 'Be your own boss' );
		$_untrusted_words[] = array('score'=> 2, 'category' => 'employment', 'word' => 'Compete for your business' );		
		$_untrusted_words[] = array('score'=> 2, 'category' => 'employment ', 'word' => 'Double your');
		$_untrusted_words[] = array('score'=> 2, 'category' => 'employment', 'word' => 'earn $' );
		$_untrusted_words[] = array('score'=> 2, 'category' => 'employment', 'word' => 'Earn extra cash' );	
		$_untrusted_words[] = array('score'=> 2, 'category' => 'employment', 'word' => 'Earn per week' );
		$_untrusted_words[] = array('score'=> 2, 'category' => 'employment', 'word' => 'expect to earn' );
		$_untrusted_words[] = array('score'=> 2, 'category' => 'employment', 'word' => 'extra income ' );
		$_untrusted_words[] = array('score'=> 1, 'category' => 'employment', 'word' => 'home based' );		
		$_untrusted_words[] = array('score'=> 2, 'category' => 'employment', 'word' => 'homebased business' );
		$_untrusted_words[] = array('score'=> 1, 'category' => 'employment', 'word' => 'homebased' );
		$_untrusted_words[] = array('score'=> 2, 'category' => 'employment', 'word' => 'opportunity' );
		$_untrusted_words[] = array('score'=> 2, 'category' => 'employment', 'word' => 'work from home' );		


		//
		// Financial
		//
		$_untrusted_words[] = array('score'=> 2, 'category' => 'financial', 'word' => 'bargain' );
		$_untrusted_words[] = array('score'=> 2, 'category' => 'financial', 'word' => 'beneficiary' );
		$_untrusted_words[] = array('score'=> 2, 'category' => 'financial', 'word' => 'affordable' );
		$_untrusted_words[] = array('score'=> 2, 'category' => 'financial', 'word' => 'cash' );	
		$_untrusted_words[] = array('score'=> 2, 'category' => 'financial', 'word' => 'credit' );
		$_untrusted_words[] = array('score'=> 2, 'category' => 'financial', 'word' => 'free' );
		$_untrusted_words[] = array('score'=> 2, 'category' => 'financial', 'word' => 'f r e e' );
		$_untrusted_words[] = array('score'=> 2, 'category' => 'financial', 'word' => 'only' );	
		$_untrusted_words[] = array('score'=> 2, 'category' => 'financial', 'word' => 'o n l y' );	
		$_untrusted_words[] = array('score'=> 2, 'category' => 'financial', 'word' => 'save' );
		$_untrusted_words[] = array('score'=> 2, 'category' => 'financial', 'word' => 'us dollars' );	
		$_untrusted_words[] = array('score'=> 2, 'category' => 'financial', 'word' => 'why pay more' );		
		$_untrusted_words[] = array('score'=> 2, 'category' => 'financial', 'word' => 'investment' );		


		//
		// General
		//
		$_untrusted_words[] = array('score'=> 3, 'category' => 'general', 'word' => 'nigeria' );
		$_untrusted_words[] = array('score'=> 2, 'category' => 'general', 'word' => 'ukraine' );
		$_untrusted_words[] = array('score'=> 1, 'category' => 'general', 'word' => 'india' );
		$_untrusted_words[] = array('score'=> 1, 'category' => 'general', 'word' => 'china' );		
		$_untrusted_words[] = array('score'=> 1, 'category' => 'general', 'word' => 'us' );	

		return $_untrusted_words;			
	}
}
// END Cart Class
