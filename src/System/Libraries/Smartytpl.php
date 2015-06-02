<?php namespace System\Libraries;
defined('BASEPATH') OR exit('No direct script access allowed');

require_once ROOTPATH . 'vendor/smarty/libs/Smarty.class.php';

class Smartytpl extends Smarty {

	/**
	 * Constructor!
	 *
	 * @access	public
	 * @return	void
	 */
	public function __construct()
	{
		parent::__construct();

		// Get CodeIgniter super object.
		$CodeIgniter =& get_instance();

		// Get Smarty config items.
		$CodeIgniter->load->config('smarty');

		// Set appropriate paths.
		$this->setTemplateDir($CodeIgniter->config->item('smarty_template_dir'));
		$this->setCompileDir($CodeIgniter->config->item('smarty_compile_dir'));
	}

	// ------------------------------------------------------------------------------
	/**
	 * Takes the data array passed as the second parameter of
	 * CodeIgniter's $this->load->view() function, and assigns
	 * data to Smarty.
	 */
	public function assign_variables($variables = array())
	{
		if (is_array($variables))
		{
			foreach ($variables as $name => $val)
			{
				$this->assign($name, $val);
			}
		}
	}

}