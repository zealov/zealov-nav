<?php

namespace Module\WebNav\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Navigation extends Model
{

    use HasFactory;
    use SoftDeletes;

    public $table = 'navigations';
    protected $fillable = [
        'parent_id',
        'name',
        'image_path',
        'url',
        'target',
        'sort',
        'published',
        'description',
        'category_id'
    ];

    public static function getList(array $validated)
    {

        $model = self::query();

        $model->when($validated['category_id']??NULL,function($query) use($validated){

            return $query->where('category_id',$validated['category_id']);

        });

        $navigation = $model->with('category')->orderBy('sort')->get()->toArray();

        return ['navigation' => $navigation];
    }

    public function category(){
        return $this->hasOne(Category::class,'id','category_id');
    }



    public static function create(array $attributes)
    {
        return static::query()->create($attributes);
    }

    public static function updateSave($attributes)
    {
        $navigation = Navigation::find($attributes['id']);
        unset($attributes['id']);

        return [
            'result'     => $navigation->update($attributes),
            'navigation' => $navigation
        ];
    }



}
