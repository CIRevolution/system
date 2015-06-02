<?php namespace System\Core;
defined('BASEPATH') OR exit('No direct script access allowed');

class Smarty extends Loader {

	/**
	 * Replace the default $this->load->view() method
	 * with our own, so we can use Smarty!
	 *
	 * This method works identically to CodeIgniter's default method,
	 * in that you should pass parameters to it in the same way.
	 *
	 * @access	public
	 * @param	string	The template path name.
	 * @param	array	An array of data to convert to variables.
	 * @param	bool	Set to TRUE to return the loaded template as a string.
	 * @return	mixed	If $return is TRUE, returns string. If not, returns void.
	 */
	public function view($template, $data = array(), $return = false)
	{

		// Get the CodeIgniter super object, load related library.
		$CodeIgniter =& get_instance();
		$CodeIgniter->load->library('smartytpl');

		// Add extension to the filename if it's not there.
		$ext = '.' . $CodeIgniter->config->item('smarty_template_ext');

		if (substr($template, -strlen($ext)) !== $ext)
		{
			$template .= $ext;
		}

		// Make sure the file exists first.
		if ( ! $CodeIgniter->smartytpl->templateExists($template))
		{
			show_error('Unable to load the template file: ' . $template);
		}

		// Assign any variables from the $data array.
		$CodeIgniter->smartytpl->assign_variables($data);

		// Assign CodeIgniter instance to be available in templates as $ci
		$CodeIgniter->smartytpl->assignByRef('ci', $CodeIgniter);

		/*
			Smarty has two built-in functions to rendering templates: display()
			and fetch(). We're going to	use only fetch(), since we want to take
			the template contents and either return them or add them to
			CodeIgniter's output class. This lets us optionally take advantage
			of some of CodeIgniter's built-in output features.
		*/

		$output = $CodeIgniter->smartytpl->fetch($template);

		// Return the output if the return value is TRUE.
		if ($return === true) return $output;

		// Otherwise append to output just like a view.
		$CodeIgniter->output->append_output($output);
	}

}