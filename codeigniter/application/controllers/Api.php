<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('api_model');
		$this->load->library('form_validation');
	}

	function index()
	{
		$data = $this->api_model->fetch_all();
		echo json_encode($data->result_array());
	}

	function insert()
	{
		$this->form_validation->set_rules('class_code', 'Code', 'required');
		$this->form_validation->set_rules('class_name', 'Class Name', 'required');
		$this->form_validation->set_rules('class_description', 'Description', 'required');
		$this->form_validation->set_rules('no_of_students', 'Number of Students', 'required');

		
		if($this->form_validation->run())
		{
			$data = array(
				'class_code'	=>	preg_replace("/\s+/", "", $this->input->post('class_code')),
				'name'		=>	$this->input->post('class_name'),
				'description'		=>	$this->input->post('class_description'),
				'max_students'		=>	$this->input->post('no_of_students')
			);

			$this->api_model->insert_api($data);

			$array = array(
				'success'		=>	true
			);
		}
		else
		{
			$array = array(
				'error'					=>	true,
				'class_code_error'		=>	form_error('class_code'),
				'class_name_error'		=>	form_error('class_name'),
				'class_description_error'	=>	form_error('class_description'),
				'no_of_students_error'		=>	form_error('no_of_students')
			);
		}
		echo json_encode($array);
	}
	
	function fetch_single()
	{
		if($this->input->post('id'))
		{
			$data = $this->api_model->fetch_single_class($this->input->post('id'));

			foreach($data as $row)
			{
				$output['class_code'] = $row['class_code'];
				$output['class_name'] = $row['name'];
				$output['class_description'] = $row['description'];
				$output['no_of_students'] = $row['max_students'];
			}
			echo json_encode($output);
		}
	}

	function update()
	{
		$this->form_validation->set_rules('class_code', 'Code', 'required');
		$this->form_validation->set_rules('class_name', 'Class Name', 'required');
		$this->form_validation->set_rules('class_description', 'Description', 'required');
		$this->form_validation->set_rules('no_of_students', 'Number of Students', 'required');

		if($this->form_validation->run())
		{	
			$data = array(
				'class_code'	=>	preg_replace("/\s+/", "", $this->input->post('class_code')),
				'name'			=>	$this->input->post('class_name'),
				'description'		=>	$this->input->post('class_description'),
				'max_students'		=>	$this->input->post('no_of_students')
			);

			$this->api_model->update_api($this->input->post('class_id'), $data);

			$array = array(
				'success'		=>	true
			);
		}
		else
		{
			$array = array(
				'error'					=>	true,
				'class_code_error'		=>	form_error('class_code'),
				'class_name_error'		=>	form_error('class_name'),
				'class_description_error'	=>	form_error('class_description'),
				'no_of_students_error'		=>	form_error('no_of_students')
			);
		}
		echo json_encode($array);
	}

	function delete()
	{
		if($this->input->post('class_id'))
		{

			$fetchStudentsOnClass = $this->api_model->validate_max_students($this->input->post('class_id'));
			if(empty($fetchStudentsOnClass)) {
				if($this->api_model->delete_single_class($this->input->post('class_id')))
				{
					$array = array(
						'success'	=>	true,
						'existing_student' => false
					);
				}
				else
				{
					$array = array(
						'error'		=>	true
					);
				}
			} else {
				$array = array(
					'error'		=>	true,
					'existing_student' => true,
					'message'	=> 'You cannot delete - We have existing students on this Class'
				);
			}
			
			echo json_encode($array);
		}
	}

}


?>