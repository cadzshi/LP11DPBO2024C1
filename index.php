<?php

/******************************************
Asisten Pemrogaman 13
 ******************************************/

 include("model/Template.class.php");
 include("model/DB.class.php");
 include("model/Pasien.class.php");
 include("model/TabelPasien.class.php");
 include("view/TampilPasien.php");
 
 
 $tp = new TampilPasien();
 
 if (isset($_GET['action'])) {
     if ($_GET['action'] == "hapus") {
         $tp->deletePasien($_GET['id']);
         
     } elseif ($_GET['action'] == "edit") {
         
         $tp->formUpdate($_GET['id']);
     } elseif ($_GET['action'] == "add") {
         $tp->formAdd();
     }
 } elseif (isset($_POST['action'])) {
     if ($_POST['action'] == "addPasien") {
         $tp->addDataPasien($_POST['nik'], $_POST['nama'], $_POST['tempat'], $_POST['tl'], $_POST['gender'], $_POST['email'], $_POST['telp']);
     } elseif ($_POST['action'] == "editPasien") {
         $tp->editDataPasien($_POST['id'], $_POST['nik'], $_POST['nama'], $_POST['tempat'], $_POST['tl'], $_POST['gender'], $_POST['email'], $_POST['telp']);
     }
 } else {
 
     $data = $tp->tampil();
 }