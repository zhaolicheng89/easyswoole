<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/11/9
 * Time: 14:47
 */
namespace App\HttpController;


use EasySwoole\EasySwoole\ServerManager;
use EasySwoole\Http\AbstractInterface\AnnotationController;
use App\Utility\Pool\MysqlPoolObject;
use EasySwoole\ORM\DbManager;
use EasySwoole\Pool\Manager;
use EasySwoole\MysqliPool\Mysql;
use EasySwoole\Http\Annotation\Param;
use EasySwoole\Http\Message\Status;
use EasySwoole\Validate\Validate;
use EasySwoole\Mysqli\QueryBuilder;
use EasySwoole\ORM\Db\Connection;
class BaseController extends AnnotationController
{

    function index()
    {
        $this->actionNotFound('index');
    }
    /**
     * 获取用户的真实IP
     * @param string $headerName 代理服务器传递的标头名称
     * @return string
     */
    protected function clientRealIP($headerName = 'x-real-ip')
    {
        $server = ServerManager::getInstance()->getSwooleServer();
        $client = $server->getClientInfo($this->request()->getSwooleRequest()->fd);
        $clientAddress = $client['remote_ip'];
        $xri = $this->request()->getHeader($headerName);
        $xff = $this->request()->getHeader('x-forwarded-for');
        if ($clientAddress === '127.0.0.1') {
            if (!empty($xri)) {  // 如果有xri 则判定为前端有NGINX等代理
                $clientAddress = $xri[0];
            } elseif (!empty($xff)) {  // 如果不存在xri 则继续判断xff
                $list = explode(',', $xff[0]);
                if (isset($list[0])) $clientAddress = $list[0];
            }
        }
        return $clientAddress;
    }

    protected function input($name, $default = null) {
        $value = $this->request()->getRequestParam($name);
        return $value ?? $default;
    }
}