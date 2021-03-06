<?php
class Route
{
    public static function start()
    {
        // defailt controller and actiom
        $controller_name = 'login';
        $action_name = 'login';
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            //This is an AJAX request, do AJAX specific stuff
        }
        $dir = $_SERVER['REQUEST_URI'];
        $dir = (strpos($dir, "?") !== false) ? substr($dir, 0, strpos($dir, "?")) : $dir;
        $curdir = str_replace("/CancerCurationView/public", "", $dir);
        $routes = explode('/', $curdir);
        // get controller name
        if (!empty($routes[1])) {
            $controller_name = $routes[1];
        }
        // get name action
        if (!empty($routes[2])) {
            $action_name = $routes[2];
        }
        $model_name = 'model_' . $controller_name;
        $controller_name = 'controller_' . $controller_name;
        //$viewname='Controller_'.$controller_name;
        $action_name = 'action_' . $action_name;
        //echo $action_name;
        //echo "<br>";
        //echo $controller_name;
        // load file with model
        $model_file = strtolower($model_name) . '.php';
        //echo $model_file;
        $model_path = MODEL_PATH . $model_file;
        if (file_exists($model_path)) {
            include MODEL_PATH . $model_file;
        }
        // load file this controller class
        $controller_file = strtolower($controller_name) . '.php';
        //echo $controller_file;
        $controller_path = CONTROLLER_PATH . $controller_file;
        if (file_exists($controller_path)) {
            include CONTROLLER_PATH . $controller_file;
        } else {
            // redirect to 404 page
           // echo "error1";
            // Route::ErrorPage404();
		return;
        }

        // create controller
        $controller = new $controller_name;
        $action = $action_name;
        if (method_exists($controller, $action)) {
            // call action of controller
            $controller->$action();
        } else {
            echo "error2";
            // redirect to 404 page
            //Route::ErrorPage404();
        }
    }
    public function ErrorPage404()
    {
        $host = 'http://' . $_SERVER['HTTP_HOST'] . '/';
        header('HTTP/1.1 404 Not Found');
        header("Status: 404 Not Found");
        header('Location:' . $host . '404');
    }
}
