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
class BannerOrm extends CommonBase
{
    /**
     * getOne
     * @Param(name="bannerId", alias="主键id", required="", integer="")
     * @throws \EasySwoole\ORM\Exception\Exception
     * @throws \Throwable
     * @author Tioncico
     * Time: 14:03
     *  查询单条数据
     */
    public function getOne()
    {
        $param = $this->request()->getRequestParam();
        $model = new BannerModel();
        $model->bannerId = $param['bannerId'];
        $bean = $model->get();
        if ($bean) {
            $this->writeJson(Status::CODE_OK, $bean, "success");
        } else {
            $this->writeJson(Status::CODE_BAD_REQUEST, [], 'fail');
        }
    }

    /**
     * getAll
     * @Param(name="page", alias="页数", optional="", integer="")
     * @Param(name="limit", alias="每页总数", optional="", integer="")
     * @Param(name="keyword", alias="关键字", optional="", lengthMax="32")
     * @author Tioncico
     * Time: 14:02
     *  查询所有数据
     */
    public function getAll()
    {
        $param = $this->request()->getRequestParam();
        $page = $param['page']??1;
        $limit = $param['limit']??20;
        $model = new BannerModel();
        $data = $model->getAll($page, 1,$param['keyword']??null, $limit);
        $this->writeJson(Status::CODE_OK, $data, 'success');
    }
    /*
 * 调用多个数据库  添加
 * */
    public function test_add(){

        $model = BannerModel::create([
            'bannerName' => '11111',
            'bannerImg'  => 21,
        ])->connection('demo',true);
        $res = $model->save();
        $this->writeJson(Status::CODE_OK, $res, 'success');
    }
    /*
* 调用多个数据库  更新
* */
    public function test_update(){
        $request = $this->request();
        $id = $request->getRequestParam('id');
        $res = BannerModel::create()->connection('demo',true)->update([
            'bannerName' => '666666666'
        ], ['bannerId' => $id]);
        $this->writeJson(Status::CODE_OK, $res, 'success');
    }

    /*
* 调用多个数据库  更新
* */
    public function test_del(){
        $request = $this->request();
        $id = $request->getRequestParam('id');
        $res = BannerModel::create()->connection('demo',true)->destroy(['bannerId' => $id]);//数组指定 where 条件结果来删除
        $this->writeJson(Status::CODE_OK, $res, 'success');
    }
    /*
     *通过原生sql执行 方法1
     * */
    public function test_sql()
    {
        $queryBuild = new QueryBuilder();
        $queryBuild->raw("select * from banner_list");
        $ret = DbManager::getInstance()->query($queryBuild, true, 'demo');
        $data=$ret->getResult();
        $this->writeJson(Status::CODE_OK, $data, 'success');
    }
    /*
     *通过原生sql执行 方法2
     * */
    public function test_sql2()
    {
        $data = BannerModel::create()->get(function ($queryBuild){
            $queryBuild->raw("select * from banner_list");
        });
        $this->writeJson(Status::CODE_OK, $data, 'success');
    }


}