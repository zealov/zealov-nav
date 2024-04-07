<?php

namespace Module\WebNav\Models;


use Illuminate\Database\Eloquent\Model as BaseModel;

class Model extends BaseModel
{

    const tableMap = [
        'navigations' => [
            'table' => 'pages',
            'name'  => '导航',
            'model' => 'Module\WebNav\Models\Navigation',
        ],
        'categories' => [
            'table' => 'categories',
            'name'  => '分类',
            'model' => 'Module\WebNav\Models\Category',
        ],

    ];

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public static function navigation(){

    }
}
