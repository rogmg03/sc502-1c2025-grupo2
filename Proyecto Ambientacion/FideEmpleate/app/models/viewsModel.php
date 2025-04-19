<?php
	
	namespace app\models;

	class viewsModel{

		/*---------- Modelo obtener vista ----------*/
		protected function obtenerVistasModelo($vista) {
			$partes = explode("/", $vista);
			$nombreVista = $partes[0];
		
			$listaBlanca = [
				"a-add-job", "a-chat", "a-home", "a-student-list", "s-home",
				"a-view-jobs", "s-view-jobs", "a-edit-job", "a-modify-job",
				"a-delete-job", "userPhoto", "logOut", "register",
				"s-view-cv", "s-add-cv", "s-apply-to-job", "s-edit-cv"
			];
		
			if (in_array($nombreVista, $listaBlanca)) {
				// Siempre busca el archivo con -view.php
				$archivo = "./app/views/content/" . $nombreVista . "-view.php";
		
				if (file_exists($archivo)) {
					return $nombreVista . "-view.php";
				} else {
					return "404";
				}
			} elseif ($nombreVista == "login" || $nombreVista == "index") {
				return "login";
			} else {
				return "404";
			}
		}
		
	}