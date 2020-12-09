<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Students_api extends CI_Controller {

    function index()
	{
		$this->load->view('api_students');
    }
    
    function action()
	{
		if($this->input->post('data_action'))
		{
			$data_action = $this->input->post('data_action');

			if($data_action == "fetch_all")
			{
				$api_url = "http://localhost/focusacademy/codeigniter/api_students";

				$client = curl_init($api_url);

				curl_setopt($client, CURLOPT_RETURNTRANSFER, true);

				$response = curl_exec($client);

				curl_close($client);

				$result = json_decode($response);

				$output = '';

				if(count($result) > 0)
				{
					foreach($result as $row)
					{
						$output .= '
						<tr>
							<td>'.$row->class_code.'</td>
							<td>'.$row->name.'</td>
							<td>'.$row->first_name.'</td>
							<td>'.$row->last_name.'</td>
							<td>'.$row->date_of_birth.'</td>
							<td><button type="button" name="edit" class="btn btn-warning btn-xs edit" id="'.$row->id.'">Edit</button></td>
							<td><button type="button" name="delete" class="btn btn-danger btn-xs delete" id="'.$row->id.'">Delete</button></td>
						</tr>

						';
					}
				}
				else
				{
					$output .= '
					<tr>
						<td colspan="4" align="center">No Data Found</td>
					</tr>
					';
				}

				echo $output;
            }
            
            if($data_action == "Insert")
			{
				$api_url = "http://localhost/focusacademy/codeigniter/api_students/insert";
			

				$form_data = array(
					'first_name'		=>	$this->input->post('first_name'),
					'last_name'			=>	$this->input->post('last_name'),
					'date_of_birth'	    =>	$this->input->post('date_of_birth'),
					'class'		        =>	$this->input->post('class')
				);

				$client = curl_init($api_url);

				curl_setopt($client, CURLOPT_POST, true);

				curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);

				curl_setopt($client, CURLOPT_RETURNTRANSFER, true);

				$response = curl_exec($client);

				curl_close($client);

				echo $response;


			}
			
			if($data_action == "fetch_all_class")
			{
				$api_url = "http://localhost/focusacademy/codeigniter/api";

				$client = curl_init($api_url);

				curl_setopt($client, CURLOPT_RETURNTRANSFER, true);

				$response = curl_exec($client);

				curl_close($client);

				$result = json_decode($response);

				$output = '';

				if(count($result) > 0)
				{	
					$output = "<option value=0>Select class</option>";
					foreach($result as $row)
					{
						$output .= '
						<option value='.$row->id.'>'.$row->name.'</option>
						';
					}
				}
				else
				{
					$output .= '
						<option>No Class Found!</option>
					';
				}

				echo $output;
			}
			
			
            if($data_action == "fetch_single")
			{
				$api_url = "http://localhost/focusacademy/codeigniter/api_students/fetch_single";

				$form_data = array(
					'id'		=>	$this->input->post('student_id')
				);

				$client = curl_init($api_url);

				curl_setopt($client, CURLOPT_POST, true);

				curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);

				curl_setopt($client, CURLOPT_RETURNTRANSFER, true);

				$response = curl_exec($client);

				curl_close($client);

                echo $response;
                
            }
            
            if($data_action == "Edit")
			{
				$api_url = "http://localhost/focusacademy/codeigniter/api_students/update";

				$form_data = array(
                    'student_id'			=>	$this->input->post('student_id'),
                    'class'			=>	$this->input->post('class'),
                    'first_name'			=>	$this->input->post('first_name'),
					'last_name'		    =>	$this->input->post('last_name'),
					'date_of_birth'		    =>	$this->input->post('date_of_birth')
				);

				$client = curl_init($api_url);

				curl_setopt($client, CURLOPT_POST, true);

				curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);

				curl_setopt($client, CURLOPT_RETURNTRANSFER, true);

				$response = curl_exec($client);

				curl_close($client);

				echo $response;


            }
            
            if($data_action == "Delete")
			{
				$api_url = "http://localhost/focusacademy/codeigniter/api_students/delete";

				$form_data = array(
					'student_id'		=>	$this->input->post('student_id')
				);

				$client = curl_init($api_url);

				curl_setopt($client, CURLOPT_POST, true);

				curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);

				curl_setopt($client, CURLOPT_RETURNTRANSFER, true);

				$response = curl_exec($client);

				curl_close($client);

				echo $response;

			}
		}
	}
}

?>