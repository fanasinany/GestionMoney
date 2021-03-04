<?php 
    $mois_fr = ["Janvier","Février","Mars","Avril","Mai","Juin",
	"Juillet","Aout","Septembre","Octobre","Novembre","Decembre"];
	if(isset($mois_selected) && isset($annee_selected)){
		$moisnb = $mois_selected;
		$anneenb = $annee_selected;
	}
	else{
		$moisnb = (int)date("m");
		$anneenb= (int)date("Y");
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="<?= base_url('/assets/img/money.png') ?>" type="image/x-icon">
    <link href="<?= base_url('/assets/css/material-dashboard.min.css') ?>" rel="stylesheet" />
    <link href="<?= base_url('/assets/fontawesome/css/all.css') ?>" rel="stylesheet" />
    <script src="<?= base_url('assets/js/core/jquery.min.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/js/core/popper.min.js') ?>" type="text/javascript"></script>
	<script src="<?= base_url('assets/js/plugins/sweetalert2.js') ?>" type="text/javascript"></script>
	<script src="<?= base_url('assets/js/plugins/jquery.dataTables.min.js') ?>" type="text/javascript"></script>
	<script src="<?= base_url('assets/js/chartjs/Chart.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/js/core/bootstrap-material-design.min.js') ?>" type="text/javascript"></script>
    <script type="text/javascript">
      var site_url = "<?= base_url();?>";
    </script>
	<title><?= isset($content) ? "GesMon - $content" : "Gestion Money" ?></title>
	<style>
		@font-face {
			font-family: 'Barlow';
			src: url("<?= base_url('/assets/fonts/Barlow-Regular.ttf') ?>") format("opentype");
		}

		body{
			font-family: "Barlow";
		}

		#space{
			height: 80px;
		}	

		@media only screen and (max-width: 734px) {
			#space{
				height: 120px;
			}
		}
	</style>
</head>
<body>
	<nav class="navbar fixed-top" style="background-color: #eee!important;">
		<div class="container-fluid">
			<a class="navbar-brand" href="<?= base_url() ?>"><img src="<?= base_url('/assets/img/money.png') ?>" alt="" width="25">  GESTION MONEY <?= isset($name) ? "| $name" : "" ?></a>
			<?php if(isset($name)): ?>
			<form class="form-inline" method="get" action="<?= base_url("index.php/Details?id=$id") ?>">
				<input type="text" name="id" value="<?= $id ?>" hidden>
				<select style="width: 100px;" class="form-control" name="mois" id="mois_select">
					<?php foreach($mois_fr as $key=>$mf): ?>
						<option value="<?= $key+1 ?>" <?= ($key+1) == $moisnb ? "selected" : "" ?>><?= $mois_fr[$key] ?></option>
					<?php endforeach?>
				</select>
				<select style="width: 50px;" class="form-control ml-2" name="annee" id="annee_select">
					<option value="<?= $anneenb ?>"><?= $anneenb ?></option>
					<option value="2019">2019</option>
					<option value="2018">2018</option>
				</select>
				<button type="submit" class="btn btn-sm btn-default ml-2"><i class="fas fa-search"></i> Recherche</button>
			</form>
			<?php endif ?>
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link" style="font-size:14px;" href="<?= base_url() ?>">Comptes</a>
				</li>
			</ul>
		</div>
	</nav>
	<div class="container-fluid">
		<div id="space"></div>
		<?php $this->load->view($content); ?>
	</div>
	<script type="text/javascript">

	function getSolde(){
		$.ajax({
			type: "GET",
			url: site_url + "index.php/Details/getSolde",
			data: {
				id: <?= isset($id) ? $id : 0 ?>
			},
			success: function (data) {
				$("solde").html(data)
			}
		})
	}

	function testBtnPrevDisabled($pg){
		
		if($pg != 1){
			$("#btnPrev").prop("disabled", false)
		}
		else{
			$("#btnPrev").prop("disabled", true)
			return $page_actif = 1
		}
	}

	function testBtnNextDisabled($pg){

		if($pg == $totalpage || $totalpage == 1 || $totalpage == undefined){
			$("#btnNext").prop("disabled", true)    
		}
		else{
			$("#btnNext").prop("disabled", false)
		}
	}

	</script>
</body>
</html>