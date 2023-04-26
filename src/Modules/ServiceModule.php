<?php

namespace Abnermouke\Supports\Modules;

use Abnermouke\Supports\Library\CodeLibrary;

/**
 * 逻辑服务容器模块
 */
class ServiceModule
{
// 逻辑状态（成功｜失败）
    private $state = false;

    // 处理结果集合
    private $result = [];

    // 提示信息
    private $msg = '';

    // 逻辑结果编码
    private $code = 0;

    // 附带数据
    private $extra = [];

    // 是否直接返回状态｜结果集（成功返回result结果集，失败返回false）
    private $pass = false;

    /**
     * 构造函数
     * @param $pass bool 是否直接获取结果
     */
    public function __construct($pass = false)
    {
        //配置是否直接返回
        $this->pass = (bool)$pass;
    }

    /**
     * 设置直接返回结果
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 22:16:02
     * @param $pass bool 是否直接返回结果
     * @return $this
     */
    public function pass($pass = false)
    {
        //设置是否直接返回
        $this->pass = (bool)$pass;
        //返回当前实例
        return $this;
    }

    /**
     * 获取结果集
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 22:16:20
     * @return array
     */
    public function getResult()
    {
        //返回结果集
        return $this->result;
    }

    /**
     * 获取逻辑处理编码
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 22:16:27
     * @return int
     */
    public function getCode()
    {
        //返回操作编码
        return (int)$this->code;
    }

    /**
     * 获取提示信息
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 22:16:34
     * @return string
     */
    public function getMessage()
    {
        //返回错误信息
        return $this->msg;
    }

    /**
     * 获取额外参数
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 22:16:45
     * @return array
     */
    public function getExtra()
    {
        //返回额外参数
        return $this->extra;
    }

    /**
     * 获取逻辑处理状态
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 22:16:51
     * @return bool
     */
    public function getState()
    {
        //返回处理状态
        return (bool)$this->state;
    }

    /**
     * 设置逻辑处理成功
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 22:17:03
     * @param $result array 返回数据
     * @param $extra array 附带参数
     * @return array|bool
     */
    protected function success($result = [], $extra = [])
    {
        //设置成功
        $this->code = CodeLibrary::CODE_SUCCESS;
        //设置处理状态
        $this->state = true;
        //设置结果集
        $this->result = $result;
        //设置额外参数
        $this->extra = $extra;
        //返回结果
        return $this->pass ? $this->getResult() : true;
    }

    /**
     * 设置逻辑处理失败
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 22:17:28
     * @param $code int 错误编码（除200外）
     * @param $message string 提示信息
     * @param $extra array 附带参数
     * @return false
     */
    protected function fail($code = CodeLibrary::CODE_ERROR, $message = '', $extra = [])
    {
        //设置处理状态
        $this->state = false;
        //设置处理编码
        $this->code = (int)($code);
        //设置提示信息
        $this->msg = $message;
        //设置额外参数
        $this->extra = $extra;
        //返回结果
        return false;
    }
}
