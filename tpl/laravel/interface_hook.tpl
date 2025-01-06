<?php
/**
 * Power by abnermouke/supports.
 * User: {__AUTHOR__} <{__AUTHOR_CONTACT_EMAIL}>
 * Originate in {__ORIGINATE__}
 * Date: {__DATE__}
 * Time: {__TIME__}
*/

namespace App\Hooks{__DICTIONARY__};

/**
 * {__DATA_NAME__}事件钩子
 * Class {__LOWER_CASE_NAME__}Hook
 * @package App\Hooks{__DICTIONARY__}
*/
class {__LOWER_CASE_NAME__}Hook
{

    /**
     * 创建事件钩子
     * @Author {__AUTHOR__} <{__AUTHOR_CONTACT_EMAIL}>
     * @Originate in {__ORIGINATE__}
     * @Time {__DATE__} {__TIME__}
     * @param mixed $unique_key
     * @param array $extras
     * @return bool
     * @throws \Exception
    */
    public static function create(mixed $unique_key, array $extras = []): bool
    {

        //TODO : 创建事件钩子

        //返回成功
        return true;
    }

    /**
     * 更新事件钩子
     * @Author {__AUTHOR__} <{__AUTHOR_CONTACT_EMAIL}>
     * @Originate in {__ORIGINATE__}
     * @Time {__DATE__} {__TIME__}
     * @param mixed $unique_key
     * @param array $extras
     * @return bool
     * @throws \Exception
    */
    public static function update(mixed $unique_key, array $extras = []): bool
    {

        //TODO : 更新事件钩子

        //返回成功
        return true;
    }

    /**
     * 删除事件钩子
     * @Author {__AUTHOR__} <{__AUTHOR_CONTACT_EMAIL}>
     * @Originate in {__ORIGINATE__}
     * @Time {__DATE__} {__TIME__}
     * @param mixed $unique_key
     * @param array $extras
     * @return bool
     * @throws \Exception
    */
    public static function delete(mixed $unique_key, array $extras = []): bool
    {

        //TODO : 删除事件钩子

        //返回成功
        return true;
    }

}
