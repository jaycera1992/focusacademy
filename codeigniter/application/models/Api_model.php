<?php
class Api_model extends CI_Model
{
	function fetch_all()
	{
		$this->db->order_by('id', 'DESC');
		$this->db->from('classes');
		return $this->db->get();
	}

	function insert_api($data)
	{
		$this->db->insert('classes', $data);
	}

	function validate_max_students($class_id)
	{
		$this->db->where('class_id', $class_id);
		$query = $this->db->get('students');
		return $query->num_rows();
	}
	
	function fetch_single_class($class_id)
	{
		$this->db->where('id', $class_id);
		$query = $this->db->get('classes');
		return $query->result_array();
	}

	function update_api($class_id, $data)
	{
		$this->db->where('id', $class_id);
		$this->db->update('classes', $data);
	}

	function delete_single_class($class_id)
	{
		$this->db->where('id', $class_id);
		$this->db->delete('classes');
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}

?>