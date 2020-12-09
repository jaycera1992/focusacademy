<?php
class Api_students_model extends CI_Model
{
	function fetch_all()
	{
		$this->db->select('students.*,classes.class_code, classes.name');    
        $this->db->from('students');
        $this->db->join('classes', 'students.class_id = classes.id');
        $this->db->order_by('students.id', 'DESC');
		return $this->db->get();
    }
    
    function insert_api($data)
	{
		$this->db->insert('students', $data);
	}
	
	function validate_max_students($class_id)
	{
		$this->db->where('class_id', $class_id);
		$query = $this->db->get('students');
		return $query->num_rows();
	}
	
	function fetch_max_class_student($class_id)
	{
		$this->db->select('max_students');
		$this->db->where('id', $class_id);
		$query = $this->db->get('classes');
		return $query->result_array();
    }
    
    function fetch_single_class($student_id)
	{
		$this->db->where('id', $student_id);
		$query = $this->db->get('students');
		return $query->result_array();
    }
    
    function update_api($student_id, $data)
	{
		$this->db->where('id', $student_id);
		$this->db->update('students', $data);
    }
    
    function delete_single_student($student_id)
	{
		$this->db->where('id', $student_id);
		$this->db->delete('students');
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