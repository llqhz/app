<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/17
 * Time: 15:21
 */

namespace app\index\controller\v1;

use app\exception\category\CategoryMissException;
use app\index\model\Category as CategoryModel;

class Category
{
    public function getAllCategories()
    {
        $categories = CategoryModel::all([],['img']);
        if ( $categories->isEmpty() ) {
            throw new CategoryMissException();
        }
        return json($categories);
    }
}