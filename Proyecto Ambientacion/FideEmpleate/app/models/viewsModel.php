<?php
	
	namespace app\models;

	class viewsModel{

		/*---------- Modelo obtener vista ----------*/
		protected function obtenerVistasModelo($vista){

			$listaBlanca=["a-add-job","a-chat","a-home","a-student-list","s-home","a-view-jobs", "a-edit-job", "a-modify-job", "a-delete-job", "a-student-list", "userPhoto","logOut", "register", "s-view-cv", "s-add-cv", "s-view-jobs","s-apply-to-job", "s-my-applications", "s-view-job", "s-edit-cv", "s-delete-cv", "s-view-job-application", "s-view-job-application-student", "s-view-job-application-employer", "s-chat", "login", "index"];

			if(in_array($vista, $listaBlanca)){
				if(is_file("./app/views/content/".$vista."-view.php")){
					$contenido="./app/views/content/".$vista."-view.php";
				}else{
					$contenido="404";
				}
			} elseif ($nombreVista == "login" || $nombreVista == "index") {
				return "login";
			} else {
				return "404";
			}
		}
		
	}