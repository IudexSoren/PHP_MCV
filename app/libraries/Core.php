<?php

// La clase CORE se encarga de manera las URLs
class Core {

  // Se establece por defecto el controlador PAGES
  protected $currentController = 'Pages';

  // Se establece por defecto el método INDEX del controlador PAGES
  protected $currentMethod = 'index';

  protected $params = [];

  /**
   * En base a los obtenido del URL, ejecuta el método con sus respectivos parámetros del controlador indicado
   */
  public function __construct()
  {
    $url = $this->getUrl();
    /**
     * Obtener controlador
     *
     * Buscar en la carpeta CONTROLLERS un archivo con el nombre del primer elemento del arreglo en la variable '$url'.
     * La ruta es '../app/cont...' porque el archivo es requerido desde 'public/index.php'.
     */
    if (file_exists('../app/controllers/' . ucwords($url[0]) . '.php')) {
      // Establecer el controlador actual de acuerdo al URL
      $this->currentController = ucwords($url[0]);
      unset($url[0]);
    }
    // Requerir el controllador
    require_once "../app/controllers/$this->currentController.php";
    // Instanciar el controllador
    $this->currentController = new $this->currentController;

    // Obtener método
    if (isset($url[1])) {
      // Buscar el método con el nombre del segundo elemento en el arreglo de la variable '$url'
      if (method_exists($this->currentController, $url[1])) {
        // Establecer el método actual de acuerdo al URL
        $this->currentMethod = $url[1];
        unset($url[1]);
      }
    }

    // Obtener parámetros
    $this->params = $url ? array_values($url) : [];

    // Ejecutar el método del controlador con sus respectivos parámetros
    call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
  }

  /**
   * Obtiene del URL los nombres del controllador, el método y los parámetros
   *
   * @return String[]
   */
  public function getUrl() {
    if (isset($_GET['url'])) {
      // Eliminar '/' del final del URL
      $url = rtrim($_GET['url'], '/');
      // Filtrar variables como string o number
      $url = filter_var($url, FILTER_SANITIZE_URL);
      // Converir el URL en un array
      $url = explode('/', $url);

      return $url;
    }
  }

}