<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inventory extends CI_Controller {
	function __construct(){
		parent::__construct();
	
		if($this->session->userdata('status') != "login"){
			redirect(base_url("login"));
		}
	}

	public function index()
	{
		$this->load->model('M_barang');

		$data['barang'] = $this->M_barang->get();
		/*$data['q_datas'] = $this->M_barang->get_qty('all');
		$data['o_datas'] = $this->M_barang->get_out('all');*/

		$this->load->view('dashboard',$data);
	}

	public function add_user(){
		$this->load->view('input_user');
	}

	public function adduser(){
		$this->load->model('M_barang');
		$data = array(
				'id' => '',
				'username' => $this->input->post('username'),
				'password' => md5($this->input->post('password')),
				'name'     => $this->input->post('fullname'),
				'level'    => 	$this->input->post('level')
			);
		$insert = $this->M_barang->saveuser($data);
		echo json_encode(array("status" => TRUE));
	}

	public function data_user(){
		$this->load->model('M_barang');
		$data['datas'] = $this->M_barang->getUserAll();
		$this->load->view('data_user',$data);
	}

	public function add_barang(){
		$this->load->model('M_barang');

		$data['barang'] = $this->M_barang->get();

		$this->load->view('input_barang',$data);
	}

	public function out_barang(){
		$this->load->model('M_barang');

		$data['barang'] = $this->M_barang->get();

		$this->load->view('output_barang',$data);
	}
	public function master_data(){
		$this->load->model('M_barang');
		$data['datas'] = $this->M_barang->getAll();
		$this->load->view('data_master',$data);
	}

	public function u_user($id)
	{

		$this->load->model('M_barang');

		$datas = $this->M_barang->get_user_id($id);

		if ($datas) {

			echo '
			<div class="x_panel">
                  <div class="x_title">
                   <h2>update Data<small> User Account</small></h2>
                   <div class="clearfix"></div>
                  </div>
			<form class="form-horizontal" id="form_transaksi" role="form">
	      	<div id="pesan">
	      	<div class="col-md-8">
			    <div class="form-group">
			      <label class="control-label col-md-3" 
			      	for="tgl_transaksi">Username :</label>
			      <div class="col-md-5">
			      	<input type="hidden" id="id_user" name="id_user" value="'.$datas->id.'">
			        <input type="text" class="form-control" id="username"
			        	name="username" placeholder="Username" value="'.$datas->username.'">
			      </div>
			    </div>
			    <div class="form-group">
			      <label class="control-label col-md-3" 
			      	for="id_barang">Password :</label>
			      <div class="col-md-5">
			        <input type="password" list="list_barang" class="form-control reset" 
			        	placeholder="Password" name="password" id="password" 
			        	autocomplete="off">
			      </div>
			    </div>
				    <div class="form-group">
				      <label class="control-label col-md-3" 
				      	for="nama_barang">Full Name :</label>
				      <div class="col-md-8">
				        <input type="text" class="form-control reset" 
				        	name="fullname" id="fullname" placeholder="Full Name" value="'.$datas->name.'">
				      </div>
				    </div>
				    <div class="form-group">
				      <label class="control-label col-md-3" 
				      	for="nama_barang">Hak Akses :</label>
				      <div class="col-md-8">
				        <select name="level" id="level" class="btn btn-default dropdown-toggle">Hak Akses
				        <option>'.$datas->level.'</option>
				        </select>

				      </div>
				    </div>
			    <div class="form-group">
			    	<div class="col-md-offset-3 col-md-3">
			      		<button type="button" class="btn btn-primary" 
			      		id="update" onclick="upduser()">
			      		  <i class="fa fa-cart-plus"></i> Update</button>
			    	</div>
			    </div>
	      	</div><!-- end col-md-8 -->
	      	</div>
	      	</form>
	      	</div>';
	    }else{
	    }

	}

	public function getreportbm($month){
		$this->load->model('M_barang');
		$results['datas'] = $this->M_barang->getMBulanan($month);
		$result= $this->M_barang->getMBulanan($month);
		if( !empty($results['datas']) ) {
			echo '<div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                  <input type="hidden" id="status" name="status" value="1">
                    <table id="datatable-buttons" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Tanggal</th>
                          <th>Barcode</th>
                          <th>Nama Barang</th>
                          <th>Jenis</th>
                          <th>Quantity</th>
                          <th>Status</th>
                          <th>Username</th>
                        </tr>
                      </thead>
                      <tbody>'; 
                        $c=1;
                        foreach($result as $data){ 
                        echo '<tr>
                          <td>'.$c.'
                          <td>'.$data['tanggal'].'</td>
                          <td>'.$data['barcode'].'</td>
                          <td>'.$data['n_barang'].'</td>
                          <td>'.$data['j_barang'].'</td>
                          <td>'.$data['qty'].'</td>
                     	  <td>'.$data{'status'}.'</td>
                     	  <td>'.$data['name'].'</td>';
                     	 $c=$c+1;
                     	};
                     	echo'
                        </tr>
                      </tbody>
                    </table>
                  </div>';

		}else{
			echo '
                   <div class="clearfix"></div>
                  <div class="x_content">
                  <input type="hidden" id="status" name="status" value="0">
                    <table id="datatable-buttons" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Tanggal</th>
                          <th>Barcode</th>
                          <th>Nama Barang</th>
                          <th>Quantity</th>
                          <th>Status</th>
                          <th>Username</th>
                        </tr>
                      </thead>
                      <tbody>
                      	<tr class="odd">
                          <td valgin="top" colspan="7" class="dataTables_empty">No matching records found</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>';
		}
	}

	public function getreportbk($month){
		$this->load->model('M_barang');
		$results['datas'] = $this->M_barang->getKBulanan($month);
		$result= $this->M_barang->getKBulanan($month);
		if( !empty($results['datas']) ) {
			echo '<div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                  <input type="hidden" id="status" name="status" value="1">
                    <table id="datatable-buttons" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Tanggal</th>
                          <th>Barcode</th>
                          <th>Nama Barang</th>
                          <th>Jenis</th>
                          <th>Quantity</th>
                          <th>Status</th>
                          <th>Username</th>
                        </tr>
                      </thead>
                      <tbody>'; 
                        $c=1;
                        foreach($result as $data){ 
                        echo '<tr>
                          <td>'.$c.'
                          <td>'.$data['tanggal'].'</td>
                          <td>'.$data['barcode'].'</td>
                          <td>'.$data['n_barang'].'</td>
                          <td>'.$data['j_barang'].'</td>
                     	  <td>'.$data{'q_barang'}.'</td>
                     	  <td>';
                     	  if($data['q_barang']==0){
                     	  	echo 'Stok Habis';
                     	  }else {
                     	  	echo 'Stok Tersedia';	
                     	  }
                     	  echo '</td>
                     	  <td>'.$data['name'].'</td>';
                     	 $c=$c+1;
                     	};
                     	echo'
                        </tr>
                      </tbody>
                    </table>
                  </div>';

		}else{
			echo '
                   <div class="clearfix"></div>
                  <div class="x_content">
                  <input type="hidden" id="status" name="status" value="0">
                    <table id="datatable-buttons" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Tanggal</th>
                          <th>Barcode</th>
                          <th>Nama Barang</th>
                          <th>Quantity</th>
                          <th>Status</th>
                          <th>Username</th>
                        </tr>
                      </thead>
                      <tbody>
                      	<tr class="odd">
                          <td valgin="top" colspan="7" class="dataTables_empty">No matching records found</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>';
		}
	}
	
	public function getbaranglist($field,$id)
	{

		$this->load->model('M_barang');
		$new_string = str_replace('+', '%2B', $id);
		$renew=rawurldecode($id);
		$datas = $this->M_barang->get_by_what($field,$renew);

		if ($datas) {

			/*$data['datas'] = $barang;
			$this->load->view('var_dump',$data);
			*/
			echo '<div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                   <h2>Result<small></small></h2>
                   <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                  <input type="hidden" id="status" name="status" value="1">
                    <table id="datatable-buttons" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Barcode</th>
                          <th>Nama Barang</th>
                          <th>Jenis</th>
                          <th>Quantity</th>
                        </tr>
                      </thead>
                      <tbody>
                      	';
                      	foreach ($datas as $data) {
                          echo 
                          '<tr>
                          <td>'.$data->barcode.'</td>
                          <td>'.$data->n_barang.'</td>
                          <td>'.$data->j_barang.'</td>
                          <td>'.$data->q_barang.'</td>
                          </tr>';
                         }
                        echo'
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>';
	    }else{

	    	echo '<div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                   <h2>Result<small></small></h2>
                   <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <table id="datatable-buttons" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Barcode</th>
                          <th>Nama Barang</th>
                          <th>Jenis</th>
                          <th>Quantity</th>
                        </tr>
                      </thead>
                      <tbody>
                      	<tr class="odd">
                          <td valgin="top" colspan="4" class="dataTables_empty">No matching records found</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>';
	    }

	}
	public function getbarang($id)
	{

		$this->load->model('M_barang');

		$barang = $this->M_barang->get_by_id($id);

		if ($barang) {

			if ($barang->q_barang <='0') {
				$disabled = '';
				$info_stok = '<span class="help-block badge" id="reset" 
					          style="background-color: #d9534f;">Stok Habis
					          </span>';
			}else{
				$disabled = '';
				$info_stok = '<span class="help-block badge" id="reset" 
					          style="background-color: #5cb85c;"> Stok Tersedia</span>';
			}

			echo '<div class="form-group">
				      <label class="control-label col-md-3" 
				      	for="nama_barang">Nama Barang :</label>
				      <div class="col-md-8">
				        <input type="text" class="form-control reset" 
				        	name="nama_barang" id="nama_barang" placeholder="Nama barang"
				        	value="'.$barang->n_barang.'">
				      </div>
				    </div>
				    <div class="form-group">
				      <label class="control-label col-md-3" 
				      	for="nama_barang">Jenis :</label>
				      <div class="col-md-8">
				        <input type="text" class="form-control reset" 
				        	name="jenis_barang" id="jenis_barang" placeholder="e.g -1.25" value="'.$barang->j_barang.'">
				      </div>
				    </div>
				    <div class="form-group">
				      <label class="control-label col-md-3" 
				      	for="qty">Quantity Stock:</label>
				      <div class="col-md-4">
				        <input type="number" class="form-control reset" 
				        	autocomplete="off" id="qty" min="0"
				        	name="qty" placeholder="Quantity." readonly="readonly" value="'.$barang->q_barang.'">
				      </div>'.$info_stok.'
				    </div>
				    <div class="form-group">
				      <label class="control-label col-md-3" 
				      	for="qty">Quantity Masuk:</label>
				      <div class="col-md-4">
				        <input type="number" class="form-control reset" 
				        	name="qty_m" placeholder="Quantity." autocomplete="off" 
				        	id="qty_m" min="0"  
				        		'.$disabled.'>
				      </div>
				    </div>
				    <div class="form-group">
			    	<div class="col-md-offset-3 col-md-3">
			      		<button type="button" class="btn btn-primary" 
			      		id="tambah" onclick="updbarang()">
			      		  <i class="fa fa-cart-plus"></i> Tambah</button>
			    	</div>
			    </div>';
	    }else{

	    	echo '<div class="form-group">
				      <label class="control-label col-md-3" 
				      	for="nama_barang">Nama Barang :</label>
				      <div class="col-md-8">
				        <input type="text" class="form-control reset" 
				        	name="nama_barang" id="nama_barang" placeholder="Nama barang">
				      </div>
				    </div>
				    <div class="form-group">
				      <label class="control-label col-md-3" 
				      	for="nama_barang">Jenis :</label>
				      <div class="col-md-8">
				        <input type="text" class="form-control reset" 
				        	name="jenis_barang" id="jenis_barang" placeholder="e.g -1.25">
				      </div>
				    </div>
				    <div class="form-group">
				      <label class="control-label col-md-3" 
				      	for="qty">Quantity:</label>
				      <div class="col-md-4">
				        <input type="number" class="form-control reset" 
				        	autocomplete="off" id="qty_m" min="0" 
				        	name="qty_m" placeholder="Quantity.">
				      </div>
				    </div>
				   	<div class="form-group">
			    	<div class="col-md-offset-3 col-md-3">
			      		<button type="button" class="btn btn-primary" 
			      		id="tambah" onclick="addbarang()">
			      		  <i class="fa fa-cart-plus"></i> Tambah</button>
			    	</div>
			    	</div><!-- end id barang -->';
	    }

	}

	public function getbarangout($id)
	{

		$this->load->model('M_barang');

		$barang = $this->M_barang->get_by_id($id);

		if ($barang) {

			if ($barang->q_barang <= '0') {
				$disabled = 'disabled';
				$info_stok = '<span class="help-block badge" id="reset" 
					          style="background-color: #d9534f;">Stok Tidak Tersedia
					          </span>';
			}else{
				$disabled = '';
				$info_stok = '<span class="help-block badge" id="reset" 
					          style="background-color: #5cb85c;"> Stok Tersedia</span>';
			}

			echo '<div class="form-group">
				      <label class="control-label col-md-3" 
				      	for="nama_barang">Nama Barang :</label>
				      <div class="col-md-8">
				        <input type="text" class="form-control reset" 
				        	name="nama_barang" id="nama_barang" 
				        	readonly="readonly" value="'.$barang->n_barang.'">
				      </div>
				    </div>
				    <div class="form-group">
				      <label class="control-label col-md-3" 
				      	for="nama_barang">Jenis :</label>
				      <div class="col-md-8">
				        <input type="text" class="form-control reset" 
				        	name="jenis_barang" id="jenis_barang" placeholder="e.g -1.25" readonly="readonly" value="'.$barang->j_barang.'">
				      </div>
				    </div>
				    <div class="form-group">
				      <label class="control-label col-md-3" 
				      	for="qty">Quantity Stock:</label>
				      <div class="col-md-4">
				        <input type="number" class="form-control reset" 
				        	autocomplete="off" id="qty" min="0"
				        	name="qty" placeholder="Quantity." readonly="readonly" value="'.$barang->q_barang.'">
				      </div>'.$info_stok.'
				    </div>
				    <div class="form-group">
				      <label class="control-label col-md-3" 
				      	for="qty">Quantity Keluar:</label>
				      <div class="col-md-4">
				        <input type="number" class="form-control reset" 
				        	name="qty_m" placeholder="Quantity." autocomplete="off" 
				        	id="qty_m" min="0"  
				        		'.$disabled.'>
				      </div>
				    </div>
				    <div class="form-group">
			    	<div class="col-md-offset-3 col-md-3">
			      		<button type="button" class="btn btn-primary" 
			      		id="tambah" onclick="dwnbarang()">
			      		  <i class="fa fa-cart-plus"></i> Save</button>
			    	</div>
			    </div>';
	    }else{

	    	echo '<div id="barang">
				    <div class="form-group">
				      <label class="control-label col-md-3" 
				      	for="nama_barang">Nama Barang :</label>
				      <div class="col-md-8">
				        <input type="text" class="form-control reset" 
				        	name="nama_barang" id="nama_barang" placeholder="Nama barang" readonly="readonly">
				      </div>
				    </div>
				    <div class="form-group">
				      <label class="control-label col-md-3" 
				      	for="nama_barang">Jenis :</label>
				      <div class="col-md-8">
				        <input type="text" class="form-control reset" 
				        	name="jenis_barang" id="jenis_barang" placeholder="e.g -1.25" readonly="readonly">
				      </div>
				    </div>
				   <div class="form-group">
				      <label class="control-label col-md-3" 
				      	for="qty">Quantity Stock:</label>
				      <div class="col-md-4">
				        <input type="number" class="form-control reset" 
				        	autocomplete="off" id="qty" min="0"
				        	name="qty" placeholder="Quantity." readonly="readonly">
				      </div>
				    </div>
				    <div class="form-group">
				      <label class="control-label col-md-3" 
				      	for="qty_m">Quantity Keluar:</label>
				      <div class="col-md-4">
				        <input type="number" class="form-control reset" 
				        	autocomplete="off" id="qty" min="0" 
				        	name="qty" placeholder="Quantity.">
				      </div>
				    </div>
			    <div class="form-group">
			    	<div class="col-md-offset-3 col-md-3">
			      		<button type="button" class="btn btn-primary" 
			      		id="tambah" onclick="dwnbarang()">
			      		  <i class="fa fa-cart-plus"></i> Save</button>
			    	</div>
			    </div><!-- end id barang -->';
	    }}

	public function ajax_list_transaksi()
	{

		$data = array();

		$no = 1; 
        
        foreach ($this->cart->contents() as $items){
        	
			$row = array();
			$row[] = $no;
			$row[] = $items["id"];
			$row[] = $items["name"];
			$row[] = 'Rp. ' . number_format( $items['price'], 
                    0 , '' , '.' ) . ',-';
			$row[] = $items["qty"];
			$row[] = 'Rp. ' . number_format( $items['subtotal'], 
					0 , '' , '.' ) . ',-';

			//add html for action
			$row[] = '<a 
				href="javascript:void()" style="color:rgb(255,128,128);
				text-decoration:none" onclick="deletebarang('
					."'".$items["rowid"]."'".','."'".$items['subtotal'].
					"'".')"> <i class="fa fa-close"></i> Delete</a>';
		
			$data[] = $row;
			$no++;
        }

		$output = array(
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function addbarang()
	{
		$this->load->model('M_barang');
		$data = array(
				'tanggal' => $this->input->post('tgl_transaksi'),
				'barcode' => $this->input->post('id_barang'),
				'n_barang' => $this->input->post('nama_barang'),
				'j_barang' => $this->input->post('jenis_barang'),
				'q_barang' 	=> 	$this->input->post('qty_m')
			);
		$in = array(
				'id'	  => '',
				'tanggal' => $this->input->post('tgl_transaksi'),
				'barcode' => $this->input->post('id_barang'),
				'qty'	  => $this->input->post('qty_m'),
				'status'  => "Insert",
				'id_user' => $this->input->post('id_user')
			);
		$insert = $this->M_barang->save($data);
		$inbarang = $this->M_barang->updatein($in);
		echo json_encode(array("status" => TRUE));
	}

	public function updbarang()
	{
		$this->load->model('M_barang');
		$data = array(
				'tanggal' => $this->input->post('tgl_transaksi'),
				'n_barang' => $this->input->post('nama_barang'),
				'j_barang' => $this->input->post('jenis_barang'),
				'q_barang' 	=> 	($this->input->post('qty_m')+$this->input->post('qty'))
			);
		$in = array(
				'id'	  => '',
				'tanggal' => $this->input->post('tgl_transaksi'),
				'barcode' => $this->input->post('id_barang'),
				'qty'	  => $this->input->post('qty_m'),
				'status'  => "Update",
				'id_user' => $this->input->post('id_user')
			);
		$insert = $this->M_barang->update(array('barcode' => $this->input->post('id_barang')),$data);
		$inbarang = $this->M_barang->updatein($in);
		echo json_encode(array("status" => TRUE));
	}

	public function dwnbarang(){
		$this->load->model('M_barang');
		$data = array(
				'tanggal' => $this->input->post('tgl_transaksi'),
				'n_barang' => $this->input->post('nama_barang'),
				'j_barang' => $this->input->post('jenis_barang'),
				'q_barang' 	=> 	($this->input->post('qty')-$this->input->post('qty_m'))
			);
		$out = array(
				'id'	  => '',
				'tanggal' => $this->input->post('tgl_transaksi'),
				'barcode' => $this->input->post('id_barang'),
				'qty'	  => $this->input->post('qty_m'),
				'id_user'	  => $this->input->post('id_user')
			);
		$insert = $this->M_barang->update(array('barcode' => $this->input->post('id_barang')),$data);
		$outbarang = $this->M_barang->updateout($out);
		echo json_encode(array("status" => TRUE));	
	}

	public function r_user($rowid) 
	{
		$this->load->model('M_barang');
		$this->M_barang->r_user($rowid);
		//echo json_encode(array("status" => TRUE));
	}

	public function upduser()
	{
		$this->load->model('M_barang');
		$data = array(
				'username' => $this->input->post('username'),
				'password' => md5($this->input->post('password')),
				'name' => $this->input->post('fullname'),
				'level' 	=> 	$this->input->post('level')
			);
		$insert = $this->M_barang->updateusr(array('id' => $this->input->post('id_user')),$data);
		echo json_encode(array("status" => TRUE));
	}

	public function r_b_masuk(){
		$data['datas']='';
		$this->load->view('report_barang_masuk',$data);
	}

	public function r_b_keluar(){
		$data['datas']='';
		$this->load->view('report_barang_keluar',$data);
	}

	public function about(){
		$this->load->view('about');
	}
}