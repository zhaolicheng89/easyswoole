<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/11/9
 * Time: 14:49
 */
namespace App\HttpController\Api;


use App\HttpController\BaseController;
use EasySwoole\EasySwoole\Core;
use EasySwoole\EasySwoole\Trigger;
use EasySwoole\Http\Exception\ParamAnnotationValidateError;
use EasySwoole\Http\Message\Status;

abstract class ApiBase extends BaseController
{
    function index()
    {
        // TODO: Implement index() method.
        $this->actionNotFound('index');
    }

    protected function actionNotFound(?string $action): void
    {
        $this->writeJson(Status::CODE_NOT_FOUND);
    }

    function onRequest(?string $action): ?bool
    {
        if (!parent::onRequest($action)) {
            return false;
        };
        return true;
    }

    protected function onException(\Throwable $throwable): void
    {
        if ($throwable instanceof ParamAnnotationValidateError) {
            $msg = $throwable->getValidate()->getError()->getErrorRuleMsg();
            $this->writeJson(400, null, "{$msg}");
        } else {
            if (Core::getInstance()->isDev()) {
                $this->writeJson(500, null, $throwable->getMessage());
            } else {
                Trigger::getInstance()->throwable($throwable);
                $this->writeJson(500, null, '系统内部错误，请稍后重试');
            }
        }
    }
}