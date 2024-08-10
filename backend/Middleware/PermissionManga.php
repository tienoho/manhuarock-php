<?php
namespace Middleware;

use Pecee\Http\Middleware\IMiddleware;
use Pecee\Http\Request;

class PermissionManga implements IMiddleware {

    public function handle(Request $request)  : void {

        if(!(new \Models\User)->hasPermission(['all', 'manga'])){
            redirect('/', 403);
        }
    }
}