<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_students extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('api_students_model');
		$this->load->library('form_validation');
	}

	function index()
	{
		$data = $this->api_students_model->fetch_all();
		echo json_encode($data->result_array());
    }
	
	function check_default_class($post_string)
	{
	return $post_string == '0' ? FALSE : TRUE;
	}

    function insert()
	{
		$this->form_validation->set_rules('first_name', 'First Name', 'required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'required');
		$this->form_validation->set_rules('date_of_birth', 'Date of Birth', 'required');

		$this->form_validation->set_rules('class', 'Class', 'required|callback_check_default_class');
		$this->form_validation->set_message('check_default_class', 'The Class field is required.');
		
		if($this->form_validation->run())
		{
			$data = array(
				'class_id'	        =>	$this->input->post('class'),
				'first_name'		=>	$this->input->post('first_name'),
				'last_name'		    =>	$this->input->post('last_name'),
				'date_of_birth'		=>	$this->input->post('date_of_birth')
			);

			$validateMaxStudents = $this->api_students_model->fetch_max_class_student($this->input->post('class'));
			$fetchStudentsOnClass = $this->api_students_model->validate_max_students($this->input->post('class'));
			
			if(!empty($validateMaxStudents)) {
				if($validateMaxStudents[0]['max_students'] != $fetchStudentsOnClass) {
					$this->api_students_model->insert_api($data);

					$array = array(
						'success'		=>	true
					);
				} else {
					$array = array(
						'error'				=>	true,
						'max_students'		=>	true,
						'message'			=> 'You cannot add students on '
					);
				}
			}

		}
		else
		{
			$array = array(
				'error'					=>	true,
				'student_class_error'		=>	form_error('class'),
				'student_first_name_error'	=>	form_error('first_name'),
				'student_last_name_error'	=>	form_error('last_name'),
				'student_date_of_birth'		=>	form_error('date_of_birth')
			);
		}
		echo json_encode($array);
    }

    function update()
	{
		$this->form_validation->set_rules('first_name', 'First Name', 'required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'required');
		$this->form_validation->set_rules('date_of_birth', 'Date of Birth', 'required');
		
		$this->form_validation->set_rules('class', 'Class', 'required|callback_check_default_class');
		$this->form_validation->set_message('check_default_class', 'The Class field is required.');

		if($this->form_validation->run())
		{	
			$data = array(
				'class_id'	        =>	$this->input->post('class'),
				'first_name'		=>	$this->input->post('first_name'),
				'last_name'		    =>	$this->input->post('last_name'),
				'date_of_birth'		=>	$this->input->post('date_of_birth')
			);

			$validateMaxStudents = $this->api_students_model->fetch_max_class_student($this->input->post('class'));
			$fetchStudentsOnClass = $this->api_students_model->validate_max_students($this->input->post('class'));
			
			if(!empty($validateMaxStudents)) {
				if($validateMaxStudents[0]['max_students'] != $fetchStudentsOnClass) {

					$this->api_students_model->update_api($this->input->post('student_id'), $data);

					$array = array(
						'success'		=>	true
					);
				} else {
					$array = array(
						'error'				=>	true,
						'max_students'		=>	true,
						'message'			=> 'You cannot edit students on '
					);
				}
			}
		}
		else
		{
			$array = array(
				'error'					=>	true,
				'student_class_error'		=>	form_error('class'),
				'student_first_name_error'	=>	form_error('first_name'),
				'student_last_name_error'	=>	form_error('last_name'),
				'student_date_of_birth'		=>	form_error('date_of_birth')
			);
		}
		echo json_encode($array);
	}
    
    function fetch_single()
	{
		if($this->input->post('id'))
		{
			$data = $this->api_students_model->fetch_single_class($this->input->post('id'));

			foreach($data as $row)
			{
				$output['class_id'] = $row['class_id'];
				$output['first_name'] = $row['first_name'];
				$output['last_name'] = $row['last_name'];
				$output['date_of_birth'] = date('Y-m-d', strtotime($row['date_of_birth']));
			}
			echo json_encode($output);
		}
    }
    
    function delete()
	{
		if($this->input->post('student_id'))
		{
			if($this->api_students_model->delete_single_student($this->input->post('student_id')))
			{
				$array = array(

					'success'	=>	true
				);
			}
			else
			{
				$array = array(
					'error'		=>	true
				);
			}
			echo json_encode($array);
		}
	}


}


?>