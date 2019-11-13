<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/11/13
 * Time: 15:09
 */
namespace App\Model;
use App\Utility\Pool\MysqlPoolObject;
use EasySwoole\ORM\AbstractModel;
class BaseModel extends AbstractModel
{
    private $db;
    function __construct(MysqlPoolObject $db)
    {
        $this->db = $db;
    }
    protected function getDb(): MysqlPoolObject {
        return $this->db;
    }
}