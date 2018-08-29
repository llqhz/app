<?php
/**
 * @Author: .筱怪  llqhz@qq.com
 * @Created time:  2018-08-29 09:08
 * @Last Modified: 2018-08-29 09:08
 * @version v1.0.0
 */

namespace app\index\controller\traits;


trait Mended
{
    /**
     * 前置操作
     * @access protected
     * @param  string $method  前置操作方法名
     * @param  array  $options 调用参数 ['only'=>[...]] 或者 ['except'=>[...]]
     * @return void
     */
    protected function beforeAction($method, $options = [])
    {
        if (isset($options['only'])) {
            if (is_array($options['only'])) {
                $options['only'] = implode(',', $options['only']);
            }
            $options['only'] = explode(',', strtolower($options['only']));
            if (!in_array(strtolower($this->request->action()), $options['only'])) {
                return;
            }
        } elseif (isset($options['except'])) {
            if (is_array($options['except'])) {
                $options['except'] = implode(',', $options['except']);
            }
            $options['except'] = explode(',', strtolower($options['except']));
            if (in_array(strtolower($this->request->action()), $options['except'])) {
                return;
            }
        }

        call_user_func([$this, $method]);
    }
}