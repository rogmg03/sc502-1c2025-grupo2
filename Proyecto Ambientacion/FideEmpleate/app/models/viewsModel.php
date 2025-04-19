<?php
	
	namespace app\models;

	class viewsModel{

		/*---------- Modelo obtener vista ----------*/
		protected function obtenerVistasModelo($vista){

			$listaBlanca=["a-add-job","a-chat","a-home","a-student-list","s-home","a-view-jobs","s-view-jobs", "a-edit-job", "a-modify-job", "a-delete-job", "a-student-list", "userPhoto","logOut", "register", "s-view-cv", "s-add-cv","s-apply-to-job"];

			if(in_array($vista, $listaBlanca)){
				if(is_file("./app/views/content/".$vista."-view.php")){
					$contenido=$vista;
				}else{
					$contenido="404";
				}
			}elseif($vista=="login" || $vista=="index"){
				$contenido="login";
			}else{
				$contenido="404";
			}
			return $contenido;
		}

	}