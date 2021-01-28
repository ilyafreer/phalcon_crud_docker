<?php
declare(strict_types=1);
namespace App\Controllers\Admin;

use App\Models\Users;

class UserController extends ControllerBase
{
    public function indexAction()
    {
        echo __CLASS__.' '.__FUNCTION__;die;
    }

    public function infoAction(){
        echo phpinfo();die;
    }
}