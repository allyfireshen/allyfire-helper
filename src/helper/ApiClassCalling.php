<?php
// +----------------------------------------------------------------------
// | Alpicool [ WE MAKE YOU FEEL COOL ]
// +----------------------------------------------------------------------
// | Copyright (c) 2020-2021 http://alpicool.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: Allyfireshen <allyfireshen@alpicool.com>
// +----------------------------------------------------------------------

namespace allyfireshen\helper;


use Exception;

class ApiClassCalling
{
    public $message = [];
    public function __construct($message = [])
    {
        if ($message) {
            $this->message = $message;
        }
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     * @throws Exception
     */
    public static function __callStatic($name, $arguments)
    {
        // TODO: Implement __callStatic() method.
        $app = new self(...$arguments);
        return $app->create($name);
    }

    /**
     * 构建
     * @param $method
     * @return mixed
     * @throws Exception
     */
    public function create($method) {
        $message = $this->message;
        $type = $message['type'];
        if (!$type) {
            throw new Exception("未指定执行类型");
        }

        $class = '\\app\\' . $type . '\\worker\\' . ucwords($method);

        if (class_exists($class)) {
            return new $class($this->message);
        }

        throw new Exception("Class不存在！");
    }
}