<?php
/**
 * 闭包使用测试
 * User: Administrator
 * Date: 2019/11/9 0009
 * Time: 13:27
 */

namespace EasySwoole\ORM\Tests;


use EasySwoole\Mysqli\QueryBuilder;
use EasySwoole\ORM\Db\Config;
use EasySwoole\ORM\Db\Connection;
use EasySwoole\ORM\DbManager;
use PHPUnit\Framework\TestCase;

class closureTest extends TestCase
{
    /**
     * @var $connection Connection
     */
    protected $connection;
    protected $tableName = 'user_test_list';
    protected function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $config = new Config(MYSQL_CONFIG);
        $this->connection = new Connection($config);
        DbManager::getInstance()->addConnection($this->connection);
        $connection = DbManager::getInstance()->getConnection();
        $this->assertTrue($connection === $this->connection);
    }

    public function testAdd()
    {
        $testUserModel = new TestUserModel();
        $testUserModel->state = 1;
        $testUserModel->name = 'Siam';
        $testUserModel->age = 100;
        $testUserModel->addTime = date('Y-m-d H:i:s');
        $data = $testUserModel->save();
        $this->assertIsInt($data);

        $testUserModel = new TestUserModel();
        $testUserModel->state = 1;
        $testUserModel->name = 'Siam222';
        $testUserModel->age = 100;
        $testUserModel->addTime = date('Y-m-d H:i:s');
        $data = $testUserModel->save();
        $this->assertIsInt($data);
    }

    public function testGet()
    {
        $user = TestUserModel::create()->get(function(QueryBuilder $queryBuilder){
           $queryBuilder->where('name', 'Siam222');
           $queryBuilder->fields(['name','age']);
        });

        $this->assertNotEmpty($user->age);
        $this->assertEmpty($user->state);
        $this->assertEmpty($user->addTime);
    }

    public function testDeleteAll()
    {
        $res = TestUserListModel::create()->destroy(null, true);
        $this->assertIsInt($res);

        $test = TestUserModel::create()->destroy(null, true);
        $this->assertIsInt($test);
    }

}