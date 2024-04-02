<?php
/**
 * Power by abnermouke/supports.
 * User: {__AUTHOR__} <{__AUTHOR_CONTACT_EMAIL}>
 * Originate in {__ORIGINATE__}
 * Date: {__DATE__}
 * Time: {__TIME__}
*/

namespace App\Interfaces{__DICTIONARY__}\Services;

use Abnermouke\Supports\Frameworks\Hyperf\Modules\BaseService;
use Hyperf\HttpServer\Contract\RequestInterface as Request;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Validation\ValidatorFactory;

/**
 * {__DATA_NAME__}接口逻辑服务容器
 * Class {__LOWER_CASE_NAME__}Service
 * @package App\Interfaces{__DICTIONARY__}\Services
*/
class {__LOWER_CASE_NAME__}InterfaceService extends BaseService
{

    #[Inject(required: false)]
    protected ValidatorFactory $validatorFactory;

    /**
    * 引入父级构造
    * {__LOWER_CASE_NAME__}InterfaceService constructor.
    * @param bool $pass 是否直接获取结果
    */
    public function __construct($pass = false) { parent::__construct($pass); }

    //
}
