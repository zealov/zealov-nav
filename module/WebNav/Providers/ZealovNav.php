<?php

use Module\WebNav\Models\Category;
use Module\WebNav\Models\Navigation;

class ZealovNav
{

    public static function CatgoryTree()
    {

        $categoryModel = new Category();

        $categoryData = $categoryModel->getList([]);

        return $categoryData['category'] ??[];
    }

    public static function navAll(){

        $categoryIds = Navigation::query()->groupBy('category_id')->pluck('category_id')->toArray();

        $categoryData = Category::query()->with('navigations')->whereIn('id',$categoryIds)->orderBy('sort')->get()->toArray();

        return $categoryData;
    }



}
