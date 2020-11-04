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


class ApiResponse
{
    const SUCCESS_CODE = 200;
    const FAIL_CODE = 405;
    const NO_RESOURCE_CODE = 404;
    const SUCCESS = 1;
    const ERROR = 0;
    const UPLOAD_SUCCESS = 0;

    protected $code;

    private $message, $info, $results;

    public function __construct($code = null, $message = '', $info = null, $results = null) {
        $this->setCode($code);
        $this->setMessage($message);
        $this->setInfo($info);
        $this->setResults($results);
    }

    protected function output($data): string {
        return $this->toJSONString();
    }

    public function setCode($code) {
        $this->code = !is_null($code) ? $code : self::SUCCESS_CODE;
    }

    public function getInfo() {
        return $this->info;
    }

    public function setInfo($info) {
        $this->info = (is_array($info) || is_object($info)) ? (object) $info : new \stdClass();
    }

    public function getResults() {
        return $this->results;
    }

    public function setResults($results) {
        $this->results = is_array($results) ? array_values($results) : array();
    }

    public function getMessage() {
        return $this->message;
    }

    public function setMessage($message) {
        $this->message = $message ? $message : '';
    }

    public function __toString() {
        return $this->toJSONString();
    }

    public function toJSONString() {
        $json = array(
            'code' => $this->code ? $this->code : self::SUCCESS_CODE,
            'message' => $this->message ? $this->message : '',
            'info' => (object) $this->info,
            'results' => $this->results
        );

        if (!empty($_GET['callback']) && preg_match('/^[A-Za-z0-9_]+$/', $_GET['callback'])) {
            $callback = $_GET['callback'];
            return $callback . '(' . json_encode($json) . ')';
        } else {
            return json_encode($json);
        }
    }
}