<?php

namespace Module\WebNav\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $table = 'categories';
    protected $fillable = ['name', 'sort', 'parent_id', 'label', 'published', 'description', 'image_path'];

    public static function getList(array $validated)
    {
        $parent_id = $validated['parent_id'] ?? 0;
        $categories = [];
        $model = self::select(['*']);

        $t = $model->orderBy('sort')->get()->toArray();
        $label = $validated['label'] ?? 0;
        if ($label) {
            $parent_id = Category::where('label', $label)->value('id');
        }
        if (!empty($t)) {
            $categories = self::tree_page($t, 'id', 'parent_id', 'children', $parent_id);
        }
        return ['category' => $categories];
    }

    /**
     * 创建
     *
     * @param array $attributes
     * @return Builder|Model
     */
    public static function create(array $attributes)
    {
        return static::query()->create($attributes);
    }

    public static function updateSave(array $attributes)
    {
        $category = Category::find($attributes['id']);
        unset($attributes['id']);

        return [
            'result'   => $category->update($attributes),
            'category' => $category
        ];
    }


    //子分类
    public function childs()
    {
        return $this->hasMany('App\Models\Category', 'parent_id', 'id');
    }

    public function parent()
    {
        return $this->hasOne('App\Models\Category', 'id', 'parent_id');
    }

    //所有子类
    public function allChilds()
    {
        return $this->childs()->with('allChilds');
    }

    //所有子类
    public function children()
    {
        return $this->childs()->with('children');
    }

    /**
     * 获取分类下所有的文章
     */
    public function posts()
    {
        return $this->morphedByMany('App\Models\Post', 'relation_ship');
    }

    public static function tree_page($list = [], $pk = 'id', $pid = 'parent_id', $child = '_child', $root = 0)
    {
        if (empty($list)) {
            return [];
        }
        // 创建Tree
        $tree = array();
        if (is_array($list)) {
            // 创建基于主键的数组引用
            $refer = array();
            foreach ($list as $key => $data) {
                $refer[$data[$pk]] =& $list[$key];
            }
            foreach ($list as $key => $data) {
                // 判断是否存在parent
                $parentId = $data[$pid];
                if ($root == $parentId) {
                    $tree[] =& $list[$key];
                } else {
                    if (isset($refer[$parentId])) {
                        $parent =& $refer[$parentId];
                        $parent[$child][] =& $list[$key];
                    }
                }
            }
        }
        return $tree;
    }

    public function navigations(){
        return $this->hasMany(Navigation::class,'category_id','id')->orderBy('sort');
    }

}
