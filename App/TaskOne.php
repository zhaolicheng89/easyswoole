<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/11/11
 * Time: 11:09
 */
namespace App;
use EasySwoole\EasySwoole\Crontab\AbstractCronTask;
use EasySwoole\EasySwoole\Task\TaskManager;
use App\Model\Admin\BannerModel;
class TaskOne extends AbstractCronTask
{

    public static function getRule(): string
    {
        return '*/1 * * * *';
    }

    public static function getTaskName(): string
    {
        return  'TaskOne';
    }

    function run(int $taskId, int $workerIndex)
    {
        var_dump(date('Y-m-d H:i:s'));
        $model = BannerModel::create([
            'name' => 'siam',
            'age'  => 21,
        ]);

        $res = $model->save();
//        var_dump('run once every two minutes');
//        var_dump('c');
//        TaskManager::getInstance()->async(function (){
//            var_dump('r');
//        });
    }

    function onException(\Throwable $throwable, int $taskId, int $workerIndex)
    {
        echo $throwable->getMessage();
    }
}