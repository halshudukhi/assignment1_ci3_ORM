<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
		$parents = Category::where('isParent', 1)->get();

		$this->load->view('index', ['parents' => $parents]);
	}
}
