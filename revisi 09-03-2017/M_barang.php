<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_barang extends CI_Model{

	private $primary_key = 'barcode';
	private $table_name	= 'tb_barang';
	private $table_in = 'tb_in_barang';
	private $table_out = 'tb_out_barang';
	private $table_user='admin';

	public function __construct()
	{
	
		parent::__construct();
	
	}

	public function get() 
	{
	  	
	  	$this->db->select('barcode,n_barang');

		return $this->db->get($this->table_name)->result();
	
	}

	public function getAll(){
		$this->db->select('*');

		return $this->db->get($this->table_name)->result();	
	}

	public function getUserAll(){
		$this->db->select('*');
		$this->db->order_by('username','asc');
		return $this->db->get($this->table_user)->result();	
	}

	public function get_qty($id){
		if($id=='all'){
		return 
		   $this->db
				->select('sum(q_barang) as Qty')
				->from($this->table_name)
				->get()
				->result();
		}
			return $this->db->select($id)->from($this->$table_name)->get()->result_array();
	}

	public function get_out($id){
		if($id=='all'){
		return 
		   $this->db
				->select('sum(qty) as Qty')
				->from($this->table_out)
				->get()
				->result();
		}
			return $this->db->select($id)->from($this->$table_name)->get()->result_array();	
	}
	public function save($data)
    {
        $this->db->insert($this->table_name, $data);
        return $this->db->insert_id();
    }

    public function saveuser($data){
    	$this->db->insert($this->table_user, $data);
        return $this->db->insert_id();	
    }

    public function update($where,$data){
    	$this->db->update($this->table_name,$data,$where);
    	return $this->db->affected_rows();
    }
    
    public function updateusr($where,$data){
    	$this->db->update($this->table_user,$data,$where);
    	return $this->db->affected_rows();
    }
    public function updatein($data){
    	$this->db->insert($this->table_in, $data);
        return $this->db->insert_id();
    }
    public function updateout($data){
    	$this->db->insert($this->table_out, $data);
        return $this->db->insert_id();
    }

	public function get_by_id($id)
	{
	  
	  	$this->db->where($this->primary_key,$id); 
	  
	  	return $this->db->get($this->table_name)->row();
	
	}

	public function get_user_id($id)
	{
	  
	  	$this->db->where('id',$id); 
	  
	  	return $this->db->get($this->table_user)->row();
	
	}

	public function get_by_what($field,$id)
	{
	  
	  	$this->db->where($field,$id); 
	  
	  	return $this->db->get($this->table_name)->result();
	
	}
	public function r_user($id){
		$this->db->where('id',$id);
		return $this->db->delete($this->table_user);
	}

	public function getMBulanan($month){
		$query = $this->db->query("select tb_in_barang.id,tb_in_barang.tanggal,tb_in_barang.qty,tb_in_barang.status,tb_barang.barcode,tb_barang.n_barang,tb_barang.j_barang,admin.name from tb_in_barang
			join tb_barang on tb_barang.barcode = tb_in_barang.barcode
			join admin on admin.id = tb_in_barang.id_user
			where month(tb_in_barang.tanggal) = ".$month."
			order by tb_in_barang.id asc");
		return $query->result_array();
		/*$this->db->select('*');
		$this->db->from($this->table_in);
		$this->db->join($this->table_name,'tb_barang.barcode = tb_in_barang.barcode');
		$this->db->join($this->table_user,'admin.id = tb_in_barang.id_user');
		$this->db->where('month(tb_in_barang.tanggal)',$month);
		$this->db->order_by('tb_in_barang.tanggal','asc');
		$this->db->get();*/
	}

	public function getKBulanan($month){
		$query = $this->db->query("select tb_out_barang.id,tb_out_barang.tanggal,tb_barang.q_barang,tb_barang.barcode,tb_barang.n_barang,tb_barang.j_barang,admin.name from tb_out_barang
			join tb_barang on tb_barang.barcode = tb_out_barang.barcode
			join admin on admin.id = tb_out_barang.id_user
			where month(tb_out_barang.tanggal) = ".$month."
			order by tb_out_barang.id asc");
		return $query->result_array();

	}
}