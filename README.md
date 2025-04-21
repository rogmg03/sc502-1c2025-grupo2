# SC502_Proyecto_Grupo2
# 👨‍🏭 FideEmpleate

Universidad Fidélitas.
Curso: Ambiente Web Cliente/Servidor.
Sistema de postulación y reclutamiento de estudiantes. Este proyecto permite a estudiantes registrase y subir su curriculum así como postularse a puestos de trabajo, también permite que empleadores se registren, creen empleos y busquen estudiantes según su perfil.

## 🚀 Instrucciones de instalación

Sigua los pasos para ejecutar el sistema de forma local:

### 1. Importar la base de datos

1. Abra **MySQL WorckBench**.
2. Autentiquese y cree una nueva conexión a su base de datos.
3. Abra el script `sistema_reclutamient.sql` que se encuentra en la carpeta `db/` y ejecute su contenido.
4. Ejecuta el script `funciones.sql` para crear las tablas, vistas, procedimientos e `inserts.sql` para cargar los datos necesarios.

### 2. Instalar servidor PHP

1. Descarga e instala [XAMPP](https://www.apachefriends.org/es/index.html).
2. Durante la instalación, asegúrese de seleccionar únicamente **Apache** como servicio a instalar (MySQL no es necesario).

### 2.  Habilitar MySQL en XAMPP

1. Abra el Panel de Control de XAMPP.

2. Haga clic en el botón Config al lado del módulo Apache y selecciona php.ini en el menú desplegable.

3. Se abrirá el archivo de configuración php.ini en su editor de texto predeterminado.

4. Presione Ctrl + F para abrir la búsqueda, y escriba por separado:
```bash
;extension=mysqli
;extension=pdo_mysql

```

5. Descomente la línea quitando el punto y coma (;) al inicio. Debería quedar así:
```bash
extension=mysqli
extension=pdo_mysql
```
6. Guarde los cambios (Ctrl + S) y cierra php.ini.

### 4. Importar el proyecto

1. Dentro de la carpeta `htdocs` ubicada en el directorio de instalación de XAMPP (por ejemplo: `C:\xampp\htdocs\`), cree una carpeta llamada `FideEmpleate`.
2. Una vez creada copie todo el contenido del repositorio dentro de la carpeta `FideEmpleate`.

### 5. Iniciar el servidor

1. Abra el **Panel de Control de XAMPP**.
2. Inicie solamente el servicio de **Apache**.
3. Asegúrese de que el puerto 80 (o el configurado) esté disponible.

### 6. Acceder al sistema

- Página inicial del sistema:
```bash
http://localhost/FideEmpleate/
```
## ✅ Credenciales de acceso

> estudiante1@ufide.ac.cr y agente1@empresa.com.
> 12345
