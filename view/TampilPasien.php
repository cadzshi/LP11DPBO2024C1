<?php


include("KontrakView.php");
include("presenter/ProsesPasien.php");

class TampilPasien implements KontrakView
{
	private $prosespasien; //presenter yang dapat berinteraksi langsung dengan view
	private $tpl;

	function __construct()
	{
		//konstruktor
		$this->prosespasien = new ProsesPasien();
	}

	function tampil()
	{
		$this->prosespasien->prosesDataPasien();
		$data = null;

		//semua terkait tampilan adalah tanggung jawab view
		for ($i = 0; $i < $this->prosespasien->getSize(); $i++) {
			$no = $i + 1;
			$data .= "<tr>
			<td>" . $no . "</td>
			<td>" . $this->prosespasien->getNik($i) . "</td>
			<td>" . $this->prosespasien->getNama($i) . "</td>
			<td>" . $this->prosespasien->getTempat($i) . "</td>
			<td>" . $this->prosespasien->getTl($i) . "</td>
			<td>" . $this->prosespasien->getGender($i) . "</td>
			<td>" . $this->prosespasien->getEmail($i) . "</td>
			<td>" . $this->prosespasien->getTelp($i) . "</td>
			<td>
			<a href='index.php?action=hapus&id=" . $this->prosespasien->getId($i) . "'><button type='button' class='btn btn-danger'>Delete</button></a>
			<a href='index.php?action=edit&id=" . $this->prosespasien->getId($i) . "'><button type='button' class='btn btn-info'>Edit</button></a>
		  </td>";
		}
		// Membaca template skin.html
		$this->tpl = new Template("templates/skin.html");

		// Mengganti kode Data_Tabel dengan data yang sudah diproses
		$this->tpl->replace("DATA_TABEL", $data);

		// Menampilkan ke layar
		$this->tpl->write();
	}

	function formAdd()
	{

		$form = null;
		$form .=
			"<input hidden name='action' value='addPasien'>
			<div class='form-group'>
			<label for='NIK'>NIK</label>
			<input type='text' class='form-control' name='nik' 
			</div>
			<div class='form-group'>
			<label for='Nama'>Nama</label>
			<input type='text' class='form-control' name='nama' >
			</div>
			<div class='form-group'>
			<label for='Tempat'>Tempat</label>
			<input type='text' class='form-control' name='tempat'>
			</div>
			<div class='form-group'>
			<label for='TL'>Tanggal Lahir</label>
			<input type='date' name='tl' class='form-control'>
			</div>
			<div class='form-group'>
				<label for='Gender'>Gender</label>
			<select name='gender' class='form-control' >
				<option>Laki-laki</option>
				<option>Perempuan</option>
			</select>
			</div>
			<div class='form-group'>
				<label for='Email'>Email</label>
				<input type='email' name='email' class='form-control' >
			</div>
			<div class='form-group'>
			<label for='Telp'>No. Telepon</label>
			<input type='text' name='telp' class='form-control' >
			</div>";


		// Membaca template form.html
		$this->tpl = new Template("templates/form.html");

		$this->tpl->replace("FORM", $form);
		$this->tpl->replace("BUTTON", "Add");

		// Menampilkan ke layar
		$this->tpl->write();
	}

	function formUpdate($id)
	{
		$form = null;
		$this->prosespasien->prosesDataPasien();
		for ($i = 0; $i < $this->prosespasien->getSize(); $i++) {
			if ($id == $this->prosespasien->getId($i)) {
				$form .=
					"<input hidden name='action' value='editPasien'>
		<input hidden name='id' value='" . $this->prosespasien->getId($i) . "'>
		<div class='form-group'>
		<label for='NIK'>NIK</label>
		<input type='text' class='form-control' name='nik' value='" . $this->prosespasien->getNik($i) . "'>
		</div>
		<div class='form-group'>
		  <label for='Nama'>Nama</label>
		  <input type='text' class='form-control' name='nama'  value='" . $this->prosespasien->getNama($i) . "'>
		  </div>
		  <div class='form-group'>
		  <label for='Tempat'>Tempat</label>
		  <input type='text' class='form-control' name='tempat' value='" . $this->prosespasien->getTempat($i) . "'>
		  </div>
		  <div class='form-group'>
		  <label for='TL'>Tanggal Lahir</label>
		  <input type='date' name='tl' class='form-control' value='" . $this->prosespasien->getTl($i) . "'>
		  </div>
		  <div class='form-group'>
		  <label for='Gender'>Gender</label>
		  <select name='gender' class='form-control' >
		  <option selected hidden>" . $this->prosespasien->getGender($i) . "</option>
		  <option>Laki-laki</option>
		  <option>Perempuan</option>
		  </select>
		  </div>
		<div class='form-group'>
			<label for='Email'>Email</label>
			<input type='email' name='email' class='form-control'  value='" . $this->prosespasien->getEmail($i) . "'>
		</div>
		<div class='form-group'>
		<label for='telp'>No. Telepon</label>
		<input type='text' name='telp' class='form-control'  value='" . $this->prosespasien->getTelp($i) . "'>
		</div>";
				break;
			}
		}
		// Membaca template form.html
		$this->tpl = new Template("templates/form.html");

		$this->tpl->replace("FORM", $form);
		$this->tpl->replace("BUTTON", "Update");

		// Menampilkan ke layar
		$this->tpl->write();
	}


	function addDataPasien($nik, $nama, $tempat, $tl, $gender, $email, $telp)
	{
		$this->prosespasien->addData($nik, $nama, $tempat, $tl, $gender, $email, $telp);
		header("location:index.php");
	}

	function editDataPasien($id, $nik, $nama, $tempat, $tl, $gender, $email, $telp)
	{
		$this->prosespasien->editData($id, $nik, $nama, $tempat, $tl, $gender, $email, $telp);
		header("location:index.php");
	}

	function deletePasien($id)
	{
		$this->prosespasien->deleteData($id);
		header("location:index.php");
	}
}