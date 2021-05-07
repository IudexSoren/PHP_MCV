<?php

// Provee a los controladores que heredan de esta clase, las funcionalidades de cargar la vista y el modelo
class Controller {

  public function model($model) {
    // Requerir el modelo
    require_once "../app/models/$model.php";

    // Instanciar y retornar el modelo
    return new $model();
  }

  // Cargar la vista
  public function view($view, $data = []) {
    // Buscar el archivo en la carpeta 'views'
    if (file_exists("../app/views/$view.php")) {
      // Requerir la vista
      require_once "../app/views/$view.php";
    } else {
      die("La vista no existe");
    }
  }

}