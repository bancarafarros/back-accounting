<?php defined('BASEPATH') or exit('no access allowed');

class MY_Model extends CI_Model
{
	protected $table;
	protected $order_by;
	protected $order_by_type;
	protected $primary_filtered = 'intval';
	protected $primary_key;
	protected $type;
	/**
	 * summary
	 */
	public function __construct()
	{
		parent::__construct();
		$this->db->query("SET sql_mode = '' ");
		$dbUsername = getSession('dbUsername');
		if ($dbUsername) {
			$this->load->database($dbUsername, FALSE, TRUE);
		}
		$this->load->helper('function_helper');
	}

	public function insert($data, $batch = false)
	{
		if ($batch == true) {
			$this->db->insert($this->table, $data);
		} else {
			$this->db->set($data);
			$this->db->insert($this->table);
			if ($this->db->affected_rows()) {
				return true;
			} else {
				return false;
			}
		}
	}

	public function update($data, $where = array())
	{
		$this->db->set($data);
		$this->db->where($where);
		$this->db->update($this->table);
		if ($this->db->affected_rows()) {
			return true;
		} else {
			return false;
		}
	}

	public function get($id = null, $single = false, $object = false)
	{
		$methos = 'row_array';
		if ($id  != null) {
			$filter = $this->primary_filtered;
			$this->db->where($this->primary_key, $id);
		}

		if ($object) {
			if ($single) {
				$methos = 'row';
			} else {
				$methos = 'result';
			}
		} else {
			if ($single) {
				$methos = 'row_array';
			} else {
				$methos = 'result_array';
			}
		}

		if ($this->order_by_type) {
			$this->db->order_by($this->order_by, $this->order_by_type);
		} else {
			$this->db->order_by($this->order_by);
		}

		$data = $this->db->get($this->table);
		$return = null;
		if ($data->num_rows() > 0) {
			$return = $data->$methos();
		}
		return $return;
	}

	/**
	 * get_by
	 *
	 * @param  array/string $where
	 * @param  int $limit
	 * @param  int $offset
	 * @param  boolean $single
	 * @param  string $select
	 * @return array
	 */
	public function get_by($where = null, $limit = null, $offset = null, $single = false, $object = false, $select = null)
	{
		if ($select != null) {
			$this->db->select($select);
		}

		if ($where) {
			$this->db->where($where);
		}

		if (($limit) && ($offset)) {
			$this->db->limit($limit, $offset);
		} else if ($limit) {
			$this->db->limit($limit);
		}
		$return = null;
		$data = $this->db->get($this->table);
		if ($data->num_rows() > 0) {
			$methos = $this->method($object, $single) . '()';
			$return = $data->$methos;
		}

		return $return;
	}

	protected function method($object = false, $single = false)
	{
		$methos = 'row';
		if ($object) {
			if ($single) {
				$methos = 'row';
			} else {
				$methos = 'result';
			}
		} else {
			if ($single) {
				$methos = 'row_array';
			} else {
				$methos = 'result_array';
			}
		}
		return $methos;
	}


	public function delete($id)
	{
		$filter = $this->primary_filtered;
		// $id = $filter($id);

		// if (!$id) {
		// 	return false;
		// }

		$this->db->where($this->primary_key, $id);
		// $this->db->limit(1);
		$this->db->delete($this->table);
		if ($this->db->affected_rows()) {
			return true;
		} else {
			return false;
		}
	}

	public function delete_by($where = null)
	{
		if ($where) {
			$this->db->where($where);
		}

		$this->db->delete($this->table);
	}

	public function count($where = null)
	{
		if ($where) {
			$this->db->where($where);
		}

		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	protected function getIp()
	{
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED'])) {
			$ip = $_SERVER['HTTP_X_FORWARDED'];
		} elseif (!empty($_SERVER['HTTP_FORWARDED_FOR'])) {
			$ip = $_SERVER['HTTP_FORWARDED_FOR'];
		} elseif (!empty($_SERVER['HTTP_FORWARDED'])) {
			$ip = $_SERVER['HTTP_FORWARDED'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}

		return $ip;
	}

	protected function setReturn($data, $object = false, $single = false)
	{
		$return = null;
		if ($data->num_rows() > 0) {
			if ($object) {
				if ($single) {
					$return = $data->row();
				} else {
					$return = $data->result();
				}
			} else {
				if ($single) {
					$return = $data->row_array();
				} else {
					$return = $data->result_array();
				}
			}
		}

		return $return;
	}
}
