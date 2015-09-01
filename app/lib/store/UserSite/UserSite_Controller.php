<?php
class UserSite_Controller extends Controller {

	public function __construct($GET, $POST, $FILES) {
		parent::__construct($GET, $POST, $FILES);
	}

	public function controlActions(){
		switch ($this->action) {
			default:
				return parent::controlActions();
			break;
			case 'export':
				$this->mode = 'ajax';
				$query = 'SELECT 
							DATE_FORMAT(created, "%d-%m-%Y") AS Fecha_de_creacion,
							name AS Nombre,
							email AS Email,
							telephone AS Telefono,
							password AS Contrasena,
							active AS Activo
						FROM '.Db::prefixTable('UserSite').'
						ORDER BY name';
				$items = Db::returnAll($query);
				$this->content = Csv::renderItemsCsv($items);
				$nameFile = 'usuarios.csv';
				File::download($nameFile, array('content'=>$this->content, 'contentType'=>'application/vnd.ms-excel'));
			break;
		}
	}
	
}
?>