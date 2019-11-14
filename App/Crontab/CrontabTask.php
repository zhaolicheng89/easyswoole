<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 19-11-4
 * Time: 下午2:14
 */

namespace App\Crontab;


use EasySwoole\EasySwoole\Crontab\AbstractCronTask;
use App\Model\Admin\BannerModel;
use EasySwoole\Mysqli\QueryBuilder;
class CrontabTask extends AbstractCronTask
{

    public static function getRule(): string
    {
        // TODO: Implement getRule() method.
        return '*/1 * * * *';
    }

    public static function getTaskName(): string
    {
        // TODO: Implement getTaskName() method.
        return 'crontabTask';
    }

    function run(int $taskId, int $workerIndex)
    {
        // TODO: Implement run() method.
        $model = BannerModel::create([
            'bannerName' => 'siam',
            'bannerImg'  => 21,
        ]);
        $res = $model->save();
        var_dump($res);
        var_dump(date('Y-m-d H:i:s'));
        $builder = new QueryBuilder();
        $data=$builder->queryBuilder()->where('id', 1)->getOne('banner_list');
        var_dump($data);
    }

    function onException(\Throwable $throwable, int $taskId, int $workerIndex)
    {
        // TODO: Implement onException() method.
        return $throwable->getMessage();
    }
}