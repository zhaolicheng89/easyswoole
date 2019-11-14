<?php
namespace EasySwoole\EasySwoole;
use App\Process\Inotify;
use App\Queue\Queue;
use App\Crontab\JdClient;
use App\Crontab\JdGoodClient;
use App\Template;
use App\Utility\Pool\MysqlPool;
use App\Utility\Pool\RedisPool;
use EasySwoole\Component\Timer;
use EasySwoole\EasySwoole\Swoole\EventRegister;
use EasySwoole\EasySwoole\AbstractInterface\Event;
use EasySwoole\Http\Request;
use EasySwoole\Http\Response;
use EasySwoole\Pool\Manager;
use EasySwoole\Template\Render;
use App\Crontab\CrontabTask;
use App\Crontab\TaskOne;
use EasySwoole\ORM\DbManager;
use EasySwoole\ORM\Db\Connection;
use EasySwoole\EasySwoole\Crontab\Crontab;
class EasySwooleEvent implements Event
{

    public static function initialize()
    {
        // TODO: Implement initialize() method.
         date_default_timezone_set('Asia/Shanghai');

        $config = new \EasySwoole\ORM\Db\Config(Config::getInstance()->getConf('MYSQL'));
        DbManager::getInstance()->addConnection(new Connection($config));

        $config1 = new \EasySwoole\ORM\Db\Config(Config::getInstance()->getConf('MYSQL1'));
        DbManager::getInstance()->addConnection(new Connection($config1), 'mysql')->getConnection("mysql");

        $config2 = new \EasySwoole\ORM\Db\Config(Config::getInstance()->getConf('MYSQL2'));
        DbManager::getInstance()->addConnection(new Connection($config2), 'demo')->getConnection("demo");
    }

    public static function mainServerCreate(EventRegister $register)
    {
        // TODO: Implement mainServerCreate() method.

        // 开始一个定时任务计划
//        Crontab::getInstance()->addTask(CrontabTask::class);
//        Crontab::getInstance()->addTask(TaskOne::class);
        // 开始一个Timer定时器 支持毫秒
//        \EasySwoole\Component\Timer::getInstance()->after(1 * 1000, function () {
//            echo "ten seconds later\n";
//        });
        $register->add(EventRegister::onWorkerStart, function (\swoole_server $server, $workerId) {
            //如何避免定时器因为进程重启而丢失
            //例如在第一个进程 添加一个10秒的定时器
            if ($workerId == 0) {
                \EasySwoole\Component\Timer::getInstance()->loop(1 * 1000, function () {
                    // 从数据库，或者是redis中，去获取下个就近10秒内需要执行的任务
                    // 例如:2秒后一个任务，3秒后一个任务 代码如下
                    \EasySwoole\Component\Timer::getInstance()->after(2 * 1000, function () {
                        //为了防止因为任务阻塞，引起定时器不准确，把任务给异步进程处理
                        echo "定时任务已开启！";
                        Logger::getInstance()->console("time 2", false);
                    });
                    \EasySwoole\Component\Timer::getInstance()->after(3 * 1000, function () {
                        //为了防止因为任务阻塞，引起定时器不准确，把任务给异步进程处理
                        Logger::getInstance()->console("time 3", false);
                    });
                });
            }
        });
        ################# tcp 服务器1 没有处理粘包 #####################
//        $tcp1ventRegister = $subPort1 = ServerManager::getInstance()->addServer('tcp1', 9502, SWOOLE_TCP, '127.0.0.1', [
//            'open_length_check' => false,//不验证数据包
//        ]);
//        $tcp1ventRegister->set(EventRegister::onConnect,function (\swoole_server $server, int $fd, int $reactor_id) {
//            echo "tcp服务1  fd:{$fd} 已连接\n";
//            $str = '恭喜你连接成功服务器1';
//            $server->send($fd, $str);
//        });
//        $tcp1ventRegister->set(EventRegister::onClose,function (\swoole_server $server, int $fd, int $reactor_id) {
//            echo "tcp服务1  fd:{$fd} 已关闭\n";
//        });
//        $tcp1ventRegister->set(EventRegister::onReceive,function (\swoole_server $server, int $fd, int $reactor_id, string $data) {
//            echo "tcp服务1  fd:{$fd} 发送消息:{$data}\n";
//        });

    }

    public static function onRequest(Request $request, Response $response): bool
    {
        // TODO: Implement onRequest() method.
        return true;
    }

    public static function afterRequest(Request $request, Response $response): void
    {
        // TODO: Implement afterAction() method.
    }
}