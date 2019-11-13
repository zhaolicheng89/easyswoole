<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/11/9
 * Time: 14:50
 */
namespace App\HttpController\Api\Common;

use App\Model\Admin\BannerBean;
use App\Model\Admin\BannerModel;
use EasySwoole\Http\Annotation\Param;
use EasySwoole\Http\Message\Status;
use EasySwoole\MysqliPool\Mysql;
use EasySwoole\Validate\Validate;
use EasySwoole\Mysqli\QueryBuilder;
use EasySwoole\ORM\Db\Connection;
use EasySwoole\ORM\DbManager;
use EasySwoole\Pool\Manager;
use App\Utility\Pool\MysqlPoolObject;
use EasySwoole\Mysqli\Mysqli;
/**
 * Class Banner
 * Create With Automatic Generator
 */
class Banner extends CommonBase
{
    /*
     * 调用默认数据库
     * */
    public function test()
    {
        //调用默认数据库
        $connection = DbManager::getInstance()->getConnection('mysql');
        $builder = new \EasySwoole\Mysqli\QueryBuilder();
        $builder->getOne('banner_list');
        $ret = $connection->query($builder, true);
        $data=$ret->getResult();
        $this->writeJson(Status::CODE_OK, $data, 'success');
    }
    /*
    * 调用多个数据库  查询
    * */
    public function test_select(){
        $connection = DbManager::getInstance()->getConnection('demo');
        $builder = new \EasySwoole\Mysqli\QueryBuilder();
        $builder->get('banner_list');
        $ret = $connection->query($builder, true);
        $data=$ret->getResult();
        $this->writeJson(Status::CODE_OK, $data, 'success');
    }
    /*
  * 调用多个数据库  查询
  * */
    public function test_add(){
        $connection = DbManager::getInstance()->getConnection('demo');
        $builder = new \EasySwoole\Mysqli\QueryBuilder();
        $data=[
            'bannerName'=>111,
            'bannerImg'=>2222,
        ];
        $builder->insert('banner_list',$data);
        $ret = $connection->query($builder, true);
        $data=$ret->getResult();
        $this->writeJson(Status::CODE_OK, $data, 'success');
    }
    /*
* 调用多个数据库  更新
* */
    public function test_update(){
        $request = $this->request();
        $id = $request->getRequestParam('id');
        $connection = DbManager::getInstance()->getConnection('demo');
        $builder = new \EasySwoole\Mysqli\QueryBuilder();
        $data=[
            'bannerName'=>111,
            'bannerImg'=>2222,
        ];
        $builder->where('bannerId',$id)->update('banner_list',$data);
        $ret = $connection->query($builder, true);
        $data=$ret->getResult();
        $this->writeJson(Status::CODE_OK, $data, 'success');
    }
    /*
    * 调用多个数据库  删除
   * */
    public function test_del(){
        $request = $this->request();
        $id = $request->getRequestParam('id');
        $connection = DbManager::getInstance()->getConnection('demo');
        $builder = new \EasySwoole\Mysqli\QueryBuilder();
        $builder->where('bannerId',$id)->delete('banner_list');
        $ret = $connection->query($builder, true);
        $data=$ret->getResult();
        $this->writeJson(Status::CODE_OK, $data, 'success');
    }
    public function test_demo(){
        $connection = DbManager::getInstance()->getConnection('demo');
        $builder = new \EasySwoole\Mysqli\QueryBuilder();
        $builder->get('banner_list');
        $ret = $connection->query($builder, true);
        $data=$ret->getResult();
        $this->writeJson(Status::CODE_OK, $data, 'success');
    }
    /*
     *使用连接池
     * */
    public function test3(){
        $db = Manager::getInstance()->get('mysql')->defer();
        $data=$db->getOne('banner_list');
        $this->writeJson(Status::CODE_OK, $data, 'success');
    }
}