<?php

declare(strict_types=1);

/**
 * 响应逻辑服务结果
 * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
 * @Company Chongqing Yunni Network Technology Co., Ltd.
 * @Time 2024-04-02 01:10:30
 * @param \Abnermouke\Supports\Modules\ServiceModule $service
 * @return \Psr\Http\Message\ResponseInterface
 * @throws Exception
 */
function responseService(\Abnermouke\Supports\Modules\ServiceModule $service): \Psr\Http\Message\ResponseInterface
{
    //判断信息
    if ($service->getState()) {
        //响应成功
        return responseSuccess($service->getResult(), $service->getMessage(), $service->getExtra());
    }
    //响应失败
    return responseError($service->getCode(), $service->getMessage(), $service->getResult(), $service->getExtra());
}


/**
 * 响应失败
 * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
 * @Company Chongqing Yunni Network Technology Co., Ltd.
 * @Time 2024-04-02 01:08:58
 * @param int $code
 * @param string $message
 * @param array $data
 * @param array $extras
 * @return \Psr\Http\Message\ResponseInterface
 */
function responseError(int $code, string $message = '', array $data = [], array $extras = []): \Psr\Http\Message\ResponseInterface
{
    //判断信息
    if (empty($message)) {
        //返回默认提示信息
        $message = '[ERROR:'.(int)$code.']';
    }
    //判断是否存在验证错误信息
    if (data_get($extras, 'validations', false)) {
        //设置提示错误
        $code = \Abnermouke\Supports\Library\CodeLibrary::VALIDATE_FAILED;
    }
    //响应返回信息
    return responseReturn($code, $message, $data, $extras);
}


/**
 * 响应成功
 * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
 * @Company Chongqing Yunni Network Technology Co., Ltd.
 * @Time 2024-04-02 01:06:29
 * @param array $data
 * @param string $message
 * @param array $extras
 * @return \Psr\Http\Message\ResponseInterface
 */
function responseSuccess(array $data, string $message = '', array $extras = []): \Psr\Http\Message\ResponseInterface
{
    //响应返回信息
    return responseReturn(\Abnermouke\Supports\Library\CodeLibrary::CODE_SUCCESS, $message, $data, $extras);
}

/**
 * 响应返回
 * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
 * @Company Chongqing Yunni Network Technology Co., Ltd.
 * @Time 2024-04-02 01:05:09
 * @param int $code
 * @param string $message
 * @param array $data
 * @param array $extras
 * @return \Psr\Http\Message\ResponseInterface
 */
function responseReturn(int $code, string $message, array $data, array $extras = []): \Psr\Http\Message\ResponseInterface
{
    //默认处理状态
    $state = (int)$code === \Abnermouke\Supports\Library\CodeLibrary::CODE_SUCCESS;
    //整理基础返回数据
    $result = compact('state', 'code', 'message', 'data');
    //判断额外的数据返回
    if ($extras && is_array($extras)) {
        //整理返回数据
        $result['extras'] = $extras;
    }
    //判断信息
    if ((int)($logic_request_log_time = get_global_data('__LOGIC_REQUEST_LOG_TIME__', 0)) > 0) {
        //设置基础数据
        $result['consuming'] = (((int)(microtime(true)*1000) - (int)$logic_request_log_time * 1000)).'ms';
    }

    //获取处理中间件
//    $current_middlewares = get_global_data('__MIDDLEWARES__', []);


    //返回响应结果
    return \Hyperf\Context\Context::get(\Hyperf\HttpServer\Contract\ResponseInterface::class)->json($result);
}