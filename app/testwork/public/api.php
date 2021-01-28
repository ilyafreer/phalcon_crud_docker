<?php
declare(strict_types=1);

use Phalcon\Mvc\Micro;
use Phalcon\Di\FactoryDefault;
use Phalcon\Loader;

error_reporting(E_ALL);

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

try {
    $loader = new Loader();
    $loader->registerNamespaces(
        [
            'App\Models' => APP_PATH . '/models/',
        ]
    )->register();

    $di = new FactoryDefault();

    $di->setShared('config', function () {
        return include APP_PATH . "/config/config.php";
    });

    $di->setShared('db', function () {
        $config = $this->getConfig();

        $class = 'Phalcon\Db\Adapter\Pdo\\' . $config->database->adapter;
        $params = [
            'host'     => $config->database->host,
            'username' => $config->database->username,
            'password' => $config->database->password,
            'dbname'   => $config->database->dbname,
            'charset'  => $config->database->charset
        ];

        if ($config->database->adapter == 'Postgresql') {
            unset($params['charset']);
        }

        return new $class($params);
    });

    $app = new Micro($di);

    $app->get(
        '/api/user',
        function () use ($app) {
            $phql = 'SELECT did, name '
                . 'FROM App\Models\Users '
                . 'ORDER BY name'
            ;

            $users = $app
                ->modelsManager
                ->executeQuery($phql)
            ;

            $data = [];

            foreach ($users as $user) {
                $data[] = [
                    'id'   => $user->did,
                    'name' => $user->name,
                ];
            }

            echo json_encode($data);
        }
    );

    $app->get(
        '/api/user/search/{name}',
        function ($name) {
        }
    );

    $app->get(
        '/api/user/{id:[0-9]+}',
        function ($id) {
        }
    );

    $app->post(
        '/api/user',
        function () {
        }
    );

    $app->put(
        '/api/user/{id:[0-9]+}',
        function ($id) {
        }
    );

    $app->delete(
        '/api/user/{id:[0-9]+}',
        function ($id) {
        }
    );

    $app->handle(
        $_SERVER["REQUEST_URI"]
    );

} catch (\Exception $e) {
    echo $e->getMessage() . '<br>';
    echo '<pre>' . $e->getTraceAsString() . '</pre>';
}
