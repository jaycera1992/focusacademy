<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test_api extends CI_Controller {

	function index()
	{
		$this->load->view('api_view');
	}

	function action()
	{
		if($this->input->post('data_action'))
		{
			$data_action = $this->input->post('data_action');

			if($data_action == "Delete")
			{
				$api_url = "http://localhost/focusacademy/codeigniter/api/delete";

				$form_data = array(
					'class_id'		=>	$this->input->post('class_id')
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
				$api_url = "http://localhost/focusacademy/codeigniter/api/update";

				$form_data = array(
					'class_id'				=>	$this->input->post('class_id'),
					'class_code'			=>	$this->input->post('class_code'),
					'class_name'			=>	$this->input->post('class_name'),
					'class_description'		=>	$this->input->post('class_description'),
					'no_of_students'		=>	$this->input->post('no_of_students')
				);

				$client = curl_init($api_url);

				curl_setopt($client, CURLOPT_POST, true);

				curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);

				curl_setopt($client, CURLOPT_RETURNTRANSFER, true);

				$response = curl_exec($client);

				curl_close($client);

				echo $response;







			}

			if($data_action == "fetch_single")
			{
				$api_url = "http://localhost/focusacademy/codeigniter/api/fetch_single";

				$form_data = array(
					'id'		=>	$this->input->post('class_id')
				);

				$client = curl_init($api_url);

				curl_setopt($client, CURLOPT_POST, true);

				curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);

				curl_setopt($client, CURLOPT_RETURNTRANSFER, true);

				$response = curl_exec($client);

				curl_close($client);

				echo $response;






			}

			if($data_action == "Insert")
			{
				$api_url = "http://localhost/focusacademy/codeigniter/api/insert";
			

				$form_data = array(
					'class_code'			=>	$this->input->post('class_code'),
					'class_name'			=>	$this->input->post('class_name'),
					'class_description'		=>	$this->input->post('class_description'),
					'no_of_students'		=>	$this->input->post('no_of_students')
				);

				$client = curl_init($api_url);

				curl_setopt($client, CURLOPT_POST, true);

				curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);

				curl_setopt($client, CURLOPT_RETURNTRANSFER, true);

				$response = curl_exec($client);

				curl_close($client);

				echo $response;


			}





			if($data_action == "fetch_all")
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
					foreach($result as $row)
					{
						$active = "Active";
						if($row->status == 0) {
							$active = "Not Active";
						}
						$output .= '
						<tr>
							<td>'.$row->class_code.'</td>
							<td>'.$row->name.'</td>
							<td>'.$row->max_students.'</td>
							<td>'.$row->description.'</td>
							<td>'.$active.'</td>
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
		}
	}
	
}

?>