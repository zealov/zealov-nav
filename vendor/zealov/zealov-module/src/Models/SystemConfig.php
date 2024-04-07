<?php
/****************************************
 * Created by PhpStorm.
 * Author: 刘奇.
 * QQ: 921491025
 * Date: 2023/6/5.
 * Time: 16:40.
 *****************************************/

namespace Zealov\Models;

use Illuminate\Database\Eloquent\Model;

class SystemConfig extends Model
{
    public $table = 'system_config';

    public function value($key){
        return self::query()->where('key',$key)->value('value');
    }
}
