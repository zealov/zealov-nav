<?php

namespace Module\WebNav\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;


class Config extends Model
{
    use HasFactory;

    public $table = 'system_config';
    protected $fillable = ['name', 'key', 'value', 'type', 'group'];

    public static function getList($group)
    {

        $model = self::select(['*']);
        if ($group) {
            $model = $model->where('group', $group);
        }
        $config = $model->orderByDesc('created_at')->get()->toArray();

        return ['config' => $config];
    }

    public static function getGroup()
    {
        $model = self::select(['group']);

        $group = $model->groupBy('group')->get()->toArray();

        return ['group' => $group];
    }

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }


}
