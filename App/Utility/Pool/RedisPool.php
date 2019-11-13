<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 18-9-25
 * Time: 下午4:41
 */

namespace App\Utility\Pool;

use EasySwoole\EasySwoole\Config;
use EasySwoole\Pool\AbstractPool;

class RedisPool extends AbstractPool
{
    /**
     * 创建redis连接池对象
     */
    protected function createObject()
    {
        // TODO: Implement createObject() method.
        if (!extension_loaded('redis')) {
            throw new \BadFunctionCallException('not support: redis');
        }
        $conf = Config::getInstance()->getConf('REDIS');
        $redis = new RedisObject();
        $connected = $redis->connect($conf['host'], $conf['port']);
        if($connected){
            if(!empty($conf['auth'])){
                $redis->auth($conf['auth']);
            }
            return $redis;
        }else{
            return null;
        }
    }
}