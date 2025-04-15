<?php

namespace app\controllers;
use app\models\mainModel;

class loginController extends mainModel
{

	/*----------  Controlador iniciar sesión  ----------*/
	public function iniciarSesionControlador()
	{
		$usuario = $this->limpiarCadena($_POST['usuario']);
		$clave = $this->limpiarCadena($_POST['contrasena']);
		$hash = password_hash("12345", PASSWORD_DEFAULT);

		if ($usuario == "" || $clave == "") {

		} else {

			// Verificar si el usuario existe en la base de datos
			$check_usuario = $this->ejecutarConsulta("SELECT * FROM usuarios WHERE correo_electronico = '$usuario'");
			

			if ($check_usuario->rowCount() == 1) {
				$check_usuario = $check_usuario->fetch();
				
				// Verificar contraseña
				if ($check_usuario['correo_electronico'] == $usuario && password_verify($clave, $check_usuario['contrasena'])) {
					// Iniciar sesión
					$_SESSION['id'] = $check_usuario['id_usuario'];
					$_SESSION['nombre'] = $check_usuario['nombre_completo'];
					$_SESSION['correo'] = $check_usuario['correo_electronico'];
					$_SESSION['rol'] = $check_usuario['rol'];
					//$_SESSION['foto'] = $check_usuario['usuario_foto'];

					$_SESSION['usuario'] = $check_usuario['correo_electronico'];

					if (headers_sent()) {
						if ($_SESSION['rol'] == 'Estudiante') {
							echo "<script> window.location.href='" . APP_URL . "s-home/'; </script>";
						} else {
							echo "<script> window.location.href='" . APP_URL . "a-home/'; </script>";
						}
					} else {
						if ($_SESSION['rol'] == 'Estudiante') {
							header("Location: " . APP_URL . "s-home/");
						} else {
							header("Location: " . APP_URL . "a-home/");
						}
					}
				} else {
					echo "<script>
                                Swal.fire({
                                  icon: 'error',
                                  title: 'Ocurrió un error inesperado',
                                  text: 'Usuario o clave incorrectos'
                                });
                              </script>";
				}
			} else {
				echo "<script>
                            Swal.fire({
                              icon: 'error',
                              title: 'Ocurrió un error inesperado',
                              text: 'Usuario o clave incorrectos'
                            });
                          </script>";
			}
		}

	}

	/*----------  Controlador cerrar sesión  ----------*/
	public function cerrarSesionControlador()
	{
		session_destroy();
		if (headers_sent()) {
			echo "<script> window.location.href='" . APP_URL . "login/'; </script>";
		} else {
			header("Location: " . APP_URL . "login/");
		}
	}
}
