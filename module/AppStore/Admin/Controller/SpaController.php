<?php
/****************************************
 * Created by PhpStorm.
 * Author: 刘奇.
 * QQ: 921491025
 * Date: 2023/4/6.
 * Time: 14:44.
 *****************************************/

namespace Module\AppStore\Admin\Controller;

use Illuminate\Routing\Controller;

class SpaController extends Controller
{

    public function __invoke()
    {
        return view('module::AppStore.View.admin.spa.index');
    }
}
