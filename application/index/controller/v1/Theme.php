<?php

namespace app\index\controller\v1;

use app\exception\ProcessException;
use app\exception\theme\ThemeMissException;
use app\index\validate\IdCollection;
use app\index\validate\IdMustBePositiveInt;
use think\Controller;
use app\index\model\Theme as ThemeModel;


class Theme extends Controller
{


    /**
     * @url /theme?ids=1,2,3,...
     */
    public function getSimpleList($ids='')
    {
        (new IdCollection()) ->goCheck();
        $ids = explode(',',$ids);
        $themes = ThemeModel::with(['topicImg','headImg'])->select($ids);
        if ( $themes->isEmpty() ) {
            throw new ProcessException('ThemeMiss');
        }
        return json($themes);
    }


    /**
     * @url /index/v1/theme/:id
     * @param string $id
     * @return \think\response\Json
     * @throws ThemeMissException
     * @throws \app\exception\ValidateException
     */
    public function getComplexOne($id='')
    {
        (new IdMustBePositiveInt())->goCheck();
        $theme = ThemeModel::getThemeWithProducts($id);
        if (!$theme) {
            throw new ProcessException('ThemeMiss');
        }
        return json($theme);
    }
    
    
}
