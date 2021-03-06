<?php
class Entree extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("EntreeModel");
        $this->load->model("DetailsModel");
    }

    public function index(){
        $data = array('content'=>'Entree');
        $data["id"] = $_GET["id"];
        $data["name"] = $this->DetailsModel->getName($_GET["id"]);
        if(isset($_GET["mois"]) && isset($_GET["annee"])){
            $data["mois_selected"] = (int)$_GET["mois"];
            $data["annee_selected"] = $_GET["annee"];
        }
        $this->load->view('layout',$data);
    }

    public function addAllEntries(){
        if($_POST["id"] != "" && $_POST["description"] != "" && $_POST["prix"] != "" && $_POST["date"] != ""){
            $this->EntreeModel->addAllEntriestoDB($_POST["id"], $_POST["description"], $_POST["prix"], $_POST["date"]);
        }
        else{
            show_error("Champs requis", 500);
        }
    }

    public function getAllEntries(){
        $table_entries = "";
        $mois_now = (int)$_GET["mois"];
        $year_now = (int)$_GET["annee"];
        if(!isset($_GET["page"])){
            $page = 1;
        }else{
            $page = $_GET["page"];
        }
        if(isset($_GET["keyword"]) && $_GET["keyword"] != ""){
            $keyword = $_GET["keyword"];
        }else{
            $keyword = "";
        }
        $data = $this->EntreeModel->getEntreeByIDandMY($_GET["id"], $keyword, $mois_now, $year_now, $page);
        $nbpage = $data[count($data)-1];
        unset($data[count($data)-1]);
        foreach($data as $dt){
            $id_entries = $dt["id_entree"];
            $date = dt($dt["date"]);
            $desc = $dt["description"];
            $prix = $dt["prix"];
            
            if($id_entries == $data[0]["id_entree"]){
                $table_entries .= "<tr>
                <td>$date</td>
                <td>$desc</td>
                <td>$prix</td>
                <td><button class=\"btn btn-link btn-sm m-0\" data-toggle=\"modal\" data-id=\"$id_entries\" data-target=\"#deleteModal\"><i class=\"fas fa-trash\"></i></button></td>
                <td hidden><input id=\"inputnbpage\" type=\"text\" value=\"$nbpage\" /></td>
                </tr>";
            }
            else{
                
                $table_entries .= "<tr>
                <td>$date</td>
                <td>$desc</td>
                <td>$prix</td>
                <td><button class=\"btn btn-link btn-sm m-0\" data-toggle=\"modal\" data-id=\"$id_entries\" data-target=\"#deleteModal\"><i class=\"fas fa-trash\"></i></button></td>
                </tr>";
            }
        }
        
        if($table_entries != ""){
            echo $table_entries;
        }else{
            echo "<tr>
            <td></td>
            <td class=\"text-center\">Aucun entrée</td>
            <td></td></tr>";
        }
    }

    public function delete(){
        if(isset($_POST["id_entries"]) && isset($_POST["id"]) && $_POST["id_entries"] != ""){
            $this->EntreeModel->deletefromdb($_POST["id_entries"], $_POST["id"]);
        }
    }

}