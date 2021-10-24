<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Redis;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * set Redis with 2minutes expiration
     * @param $key
     * @param $hasKey
     * 
     * @return null
     */
    public function setRedis($key, $value) {
        Redis::set($key,json_encode($value));
        Redis::expire($key, 120);
    }

    /**
     * get Redis
     * 
     * @return string
     */
    public function getRedis($key) {
        $data = Redis::get($key);
        return empty($data) ? "" : json_decode($data);
    }
}
