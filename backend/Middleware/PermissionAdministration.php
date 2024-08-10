<?php
namespace Middleware;

use Pecee\Http\Middleware\IMiddleware;
use Pecee\Http\Request;

class PermissionAdministration implements IMiddleware {


    public function handle(Request $request)  : void {

        if(!(new \Models\User)->hasPermission(['all', 'administration'])){
            redirect('/', 403);
        }
    }
}