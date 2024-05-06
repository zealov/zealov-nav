<?php

use Module\WebNav\Models\Category;
use Module\WebNav\Models\Navigation;

class ZealovNav
{

    public static function CatgoryTree($place='sidebar')
    {

        $categoryModel = new Category();

        $categoryData = $categoryModel->getList(['place'=>$place]);

        return $categoryData['category'] ?? [];
    }

    public static function navAll($place = 'sidebar')
    {
        $categoryIds = Navigation::query()
            ->groupBy('category_id')
            ->pluck('category_id')
            ->toArray();
        $categoryModel = Category::query();
        $categoryModel = $categoryModel->when($place ?? NULL, function ($query) use ($place) {
            $query->where('place', $place);
        });
        $categoryData = $categoryModel
            ->with('navigations')
            ->whereIn('id', $categoryIds)
            ->orderBy('sort')
            ->get()
            ->toArray();

        return $categoryData;
    }


}
