<?php

namespace Abnermouke\Supports\Frameworks\Hyperf\Modules;

use Abnermouke\Supports\Assists\Arr;
use Abnermouke\Supports\Assists\Str;
use Abnermouke\Supports\Library\HelperLibrary;
use Hyperf\DbConnection\Db as DB;

/**
 * 数据仓库模块
 */
class BaseRepository
{

    //默认数据模型实例
    protected $default_model;

    //数据模型实例
    protected $model;

    //表链接信息
    protected $connection;

    //表名
    protected $table_name;

    //是否调试SQL
    protected $debug_sql = false;

    /**
     * 构造函数
     * @param $model mixed 数据模型
     * @param $connection mixed 表链接名
     */
    public function __construct($model, $connection = null)
    {
        //设置信息
        $this->default_model = $model;
        //设置表名
        $this->table_name = $this->default_model::TABLE_NAME;
        //设置默认表链接信息
        $this->setConnection($connection);
    }

    /**
     * 设置表链接信息
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-26 23:33:30
     * @param $connection
     * @return $this
     */
    public function setConnection($connection = null)
    {
        // set current model connection
        $this->connection = $connection;
        // set current model connection to current model object
        $this->model= $this->default_model::on($connection);
        // return this
        return $this;
    }

    /**
     * 重置模型
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-20 15:28:49
     * @return $this
     */
    public function model()
    {
        //重新设置模型
        $this->setConnection($this->connection);
        //返回模型对象
        return $this->model;
    }

    /**
     * 设置调试打印结果（SQL语句）
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-20 14:22:54
     * @param $debug bool 是否开启调试
     * @return $this
     */
    public function setDebug($debug = true)
    {
        // 设置调试打印SQL
        $this->debug_sql = $debug;
        // return this
        return $this;
    }

    /**
     * 执行自定义语句
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-20 14:22:45
     * @param $sql string 执行SQL
     * @param $connection string 表链接信息
     * @return bool
     */
    public function sqlStatement($sql, $connection = null)
    {
        // 执行自定义语句
        return DB::connection($connection)->statement($sql);
    }

    /**
     * 转义内容，防止SQL注入
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-20 14:25:28
     * @param $value string 储存内容
     * @return mixed|string
     */
    private function addslashesValue($value)
    {
        //判断类型
        return !empty($value) && is_string($value) ? addslashes($value) : $value;
    }

    /**
     * 反转义内容，避免错误
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-20 14:29:19
     * @param $value string 返转义内容
     * @return mixed|string
     */
    private function stripslashesValue($value)
    {
        //判断类型
        return !empty($value) && is_string($value) ? stripslashes($value) : $value;
    }

    /**
     * 反转义系统实例返回对象
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-20 14:29:58
     * @param $values mixed 反转义内容
     * @return mixed|string
     */
    private function stripslashesResult($values)
    {
        //判断数据
        if (!empty($values) && is_array($values)) {
            //循环数据
            foreach ($values as $field => $value) {
                //初始化数据
                $values[$field] = is_array($value) ? $this->stripslashesResult($value) : $this->stripslashesValue((is_null($value) ? '' : $this->checkJsonValue($value, true)));
            }
        } elseif (is_string($values)) {
            //设置反转义
            $values = $this->stripslashesValue($values);
        }
        //返回数据
        return $values;
    }

    /**
     * 检测是否为json字符串系统值
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-20 14:30:37
     * @param $value mixed 数据库内容
     * @param $assoc bool json_decode第三个参数
     * @return array|mixed|string
     */
    private function checkJsonValue($value = '', $assoc = false)
    {
        //反json数据
        $data = json_decode($value, $assoc);
        //判断是否为json字符串
        if (($data && is_object($data)) || (is_array($data) && !empty($data))) {
            //返回反json数据
            return $data;
        }
        //返回愿数据
        return $value;
    }

    /**
     * 设置入库数据（入库前置）
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-20 14:31:23
     * @param $data array 查询结果
     * @return mixed
     */
    private function setData($data)
    {
        //循环数据
        foreach ($data as $field => $value)
        {
            //初始化数据信息
            $data[$field] = !is_array($value) ? $this->addslashesValue((is_null($value) ? '' : $value)) : json_encode($value);
        }
        //返回处理数据
        return $data;
    }

    /**
     * 设置查询字段
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-20 14:31:37
     * @param $fields array|string 查询字段
     * @return array|mixed|string[]
     */
    private function setFields($fields = [])
    {
        //整理字段信息
        return $fields && !empty($fields) ? (is_string($fields) ? explode(',', $fields) : $fields) : ['*'];
    }

    /**
     * 设置group规则
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-20 14:35:41
     * @param $query mixed 数据模型
     * @param $group string group字段
     * @return mixed
     */
    private function setGroup($query, $group = '')
    {
        //判断group规则
        if (!empty($group)) {
            //设置group
            $query = $query->groupByRaw($group);
        }
        //返回实例对象
        return $query;
    }

    /**
     * 设置查询结果
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-20 14:33:03
     * @param $query mixed 数据模型
     * @param $conditions
     * @return mixed
     */
    private function setConditions($query, $conditions = [])
    {
        //判断条件
        if (empty($conditions)) {
            //返回请求实例
            return $query;
        }
        //循环信息
        foreach ($conditions as $field => $condition) {
            //判断条件类型
            if (is_array($condition)) {
                //整理规则信息
                $rule = Arr::first($condition);
                //整理数据信息
                $value = Arr::last($condition);
            } else {
                //整理规则信息
                $rule = '=';
                //设置处理数据
                $value = $this->addslashesValue($condition);
            }
            //根据处理规则处理
            switch (strtolower($rule)) {
                case 'or':
                    //初始化或者条件
                    $query = $query->orWhere($field, $value);
                    break;
                case 'or-not-between':
                    //初始化orWhereNotBetween查询条件
                    $query = $query->orWhereNotBetween($field, $value);
                    break;
                case 'or-between':
                    //初始化orWhereBetween查询条件
                    $query = $query->orWhereBetween($field, $value);
                    break;
                case 'or-in':
                    //初始化orWhereIn查询条件
                    $query = $query->orWhereIn($field, $value);
                    break;
                case 'or-not-in':
                    //初始化orWhereNotIn查询条件
                    $query = $query->orWhereNotIn($field, $value);
                    break;
                case 'or-null':
                    //初始化orWhereNull查询条件
                    $query = $query->orWhereNull($field);
                    break;
                case 'or-not-null':
                    //初始化orWhereNotNull查询条件
                    $query = $query->orWhereNotNull($field);
                    break;
                case 'column':
                    //判断类型
                    if (is_string($value)) {
                        //初始化whereColumn比较两个字段的值是否相等
                        $query = $query->whereColumn($field, $value);
                    } else {
                        //初始化whereColumn比较两个字段的值
                        $query = $query->whereColumn($field, Arr::first($value), Arr::last($value));
                    }
                    break;
                case 'or-column':
                    if (is_string($value)) {
                        //初始化whereColumn比较两个字段的值是否相等
                        $query = $query->orWhereColumn($field, $value);
                    } else {
                        //初始化whereColumn比较两个字段的值
                        $query = $query->orWhereColumn($field, Arr::first($value), Arr::last($value));
                    }
                    break;
                case 'between':
                    //初始化whereBetween查询条件
                    $query = $query->whereBetween($field, $value);
                    break;
                case 'not-between':
                    //初始化whereNotBetween查询条件
                    $query = $query->whereNotBetween($field, $value);
                    break;
                case 'in':
                    //初始化whereIn查询条件
                    $query = $query->whereIn($field, $value);
                    break;
                case 'not-in':
                    //初始化whereNotIn查询条件
                    $query = $query->whereNotIn($field, $value);
                    break;
                case 'null':
                    //初始化whereNull查询条件
                    $query = $query->whereNull($field);
                    break;
                case 'not-null':
                    //初始化whereNotNull查询条件
                    $query = $query->whereNotNull($field);
                    break;
                case 'select-raw':
                    //初始化selectRaw查询条件
                    $query = $query->selectRaw($value);
                    break;
                case 'date':
                    //初始化whereDate查询条件
                    $query = $query->whereDate($field, $value);
                    break;
                case 'month':
                    //初始化whereMonth查询条件
                    $query = $query->whereMonth($field, $value);
                    break;
                case 'day':
                    //初始化whereDay查询条件
                    $query = $query->whereDay($field, $value);
                    break;
                case 'year':
                    //初始化whereYear查询条件
                    $query = $query->whereYear($field, $value);
                    break;
                case 'time':
                    //初始化whereTime查询条件
                    $query = $query->whereTime($field, '=', $value);
                    break;
                case 'columns':
                    //初始化whereColumn查询条件
                    $query = $query->whereColumn($value);
                    break;
                case 'raw':
                    //初始化whereRaw查询条件
                    $query = $query->whereRaw($value);
                    break;
                case 'like':
                    //初始化查询字段信息
                    $fields = explode('|', $field);
                    //整理字段信息
                    foreach ($fields as $k => $field) {
                        //判断是否存在表名
                        $field = strstr($field, '.') ? ("`".Arr::first(explode('.', $field))."`.`".Arr::last(explode('.', $field))."`") : "`".$field."`";
                        //设置字段信息
                        $fields[$k] = "trim(replace(".$field.", ' ', ''))";
                    }
                    //初始化whereRaw查询条件
                    $query = $query->whereRaw("concat(".implode(',', $fields).") like trim(replace('".$value."', ' ', ''))");
                    break;
                case 'not-like':
                    //初始化查询字段信息
                    $fields = explode('|', $field);
                    //整理字段信息
                    foreach ($fields as $k => $field) {
                        //判断是否存在表名
                        $field = strstr($field, '.') ? ("`".Arr::first(explode('.', $field))."`.`".Arr::last(explode('.', $field))."`") : "`".$field."`";
                        //设置字段信息
                        $fields[$k] = "trim(replace(".$field.", ' ', ''))";
                    }
                    //初始化whereRaw查询条件
                    $query = $query->whereRaw("concat(".implode(',', $fields).") not like trim(replace('".$value."', ' ', ''))");
                    break;
                case 'json':
                    //初始化where(JSON 本特性仅支持 MySQL 5.7、PostgreSQL、SQL Server 2016 以及 SQLite 3.9.0)查询条件
                    $query = $query->where($field, $value);
                    break;
                case 'json-contains':
                    //初始化whereJsonContains(JSON 本特性仅支持 MySQL 5.7、PostgreSQL、SQL Server 2016 以及 SQLite 3.9.0)查询条件
                    $query = $query->whereJsonContains($field, $value);
                    break;
                case 'json-length':
                    //初始化whereJsonLength(JSON 本特性仅支持 MySQL 5.7、PostgreSQL、SQL Server 2016 以及 SQLite 3.9.0)查询条件
                    $query = $query->whereJsonLength($field, (int)($value));
                    break;
                case 'json-length-gt':
                    //初始化whereJsonLength(JSON 本特性仅支持 MySQL 5.7、PostgreSQL、SQL Server 2016 以及 SQLite 3.9.0)查询条件
                    $query = $query->whereJsonLength($field, '>', (int)($value));
                    break;
                case 'json-length-egt':
                    //初始化whereJsonLength(JSON 本特性仅支持 MySQL 5.7、PostgreSQL、SQL Server 2016 以及 SQLite 3.9.0)查询条件
                    $query = $query->whereJsonLength($field, '>=', (int)($value));
                    break;
                case 'json-length-lt':
                    //初始化whereJsonLength(JSON 本特性仅支持 MySQL 5.7、PostgreSQL、SQL Server 2016 以及 SQLite 3.9.0)查询条件
                    $query = $query->whereJsonLength($field, '<', (int)($value));
                    break;
                case 'json-length-elt':
                    //初始化whereJsonLength(JSON 本特性仅支持 MySQL 5.7、PostgreSQL、SQL Server 2016 以及 SQLite 3.9.0)查询条件
                    $query = $query->whereJsonLength($field, '<=', (int)($value));
                    break;
                case 'json-length-eq':
                    //初始化whereJsonLength(JSON 本特性仅支持 MySQL 5.7、PostgreSQL、SQL Server 2016 以及 SQLite 3.9.0)查询条件
                    $query = $query->whereJsonLength($field, '=', (int)($value));
                    break;
                default:
                    //初始化where查询条件
                    $query = $query->where($field, $rule, $value);
                    break;
            }
        }
        //返回实例对象
        return $query;
    }

    /**
     * 设置表链接规则
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-20 14:37:53
     * @param $query mixed 数据模型
     * @param $joins array 表链接规则
     * @return mixed
     */
    private function setJoins($query, $joins = [])
    {
        // 判断表链接相关信息
        if (empty($joins)) {
            //返回请求实例
            return $query;
        }
        //循环表链接信息
        foreach ($joins as $join) {
            //获取链接规则：left right inner
            $join_rule = $join[0];
            //获取左表表名
            $join_left_table = $join[1];
            //获取左表关联字段
            $join_left_field = $join[2];
            //获取表链接条件
            $join_condition = $join[3];
            //获取右表表名与关联字段
            $join_right_field = $join[4];
            //判断处理方式
            switch (strtolower($join_rule)) {
                //执行左链接
                case 'left':
                    $query = $query->leftJoin($join_left_table, $join_left_field, $join_condition, $join_right_field);
                    break;
                //执行右链接
                case 'right':
                    $query = $query->rightJoin($join_left_table, $join_left_field, $join_condition, $join_right_field);
                    break;
                //执行inner链接
                default:
                    $query = $query->join($join_left_table, $join_left_field, $join_condition, $join_right_field);
                    break;
            }
        }
        //返回请求实例
        return $query;
    }

    /**
     * 设置排序规则
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-20 14:39:25
     * @param $query mixed 数据模型
     * @param $orders array 排序规则
     * @return mixed
     */
    private function setOrders($query, $orders = [])
    {
        //判断排序信息
        if (empty($orders)) {
            //返回请求实例
            return $query;
        }
        //循环排序方式
        foreach ($orders as $field => $order) {
            //根据类型处理
            switch ($order) {
                case BaseModel::LATEST_ORDER_BY:
                    //执行倒序排序
                    $query = $query->latest();
                    break;
                case BaseModel::OLDEST_ORDER_BY:
                    //执行正序排序
                    $query = $query->oldest();
                    break;
                case BaseModel::RANDOM_ORDER_BY:
                    //执行随机排序
                    $query = $query->inRandomOrder();
                    break;
                case BaseModel::RAW_ORDER_BY:
                    //执行自定义排序
                    $query = $query->orderByRaw($field);
                    break;
                default:
                    //执行指定排序
                    $query = $query->orderBy($field, strtolower($order));
                    break;
            }
        }
        //返回请求实例
        return $query;
    }

    /**
     * 设置结果集（出库后置操作）
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-20 14:40:30
     * @param $query_result
     * @return mixed|string
     */
    private function setResult($query_result)
    {
        //初始化返回数据
        $query_result = !empty($query_result) && is_object($query_result) ? json_decode($query_result, true) : $query_result;
        //初始化返回数据
        return $this->stripslashesResult($query_result);
    }

    /**
     * 获取列表（详细列表数据）
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-20 14:42:32
     * @param $conditions array 筛选条件
     * @param array $fields 查询字段
     * @param array $joins 表链接信息
     * @param array $orders 排序规则
     * @param string $group group规则
     * @param int $page 页码
     * @param int $page_size 每页条数
     * @param bool $selectRaw 自定义查询字段结构（涉及复杂结构时使用）
     * @return array
     */
    public function lists($conditions, $fields = [], $joins = [], $orders = [], $group = '', $page = 1, $page_size = 20, $selectRaw = false)
    {
        //查询总数量
        $total_count = $this->count();
        //查询匹配总数量
        $matched_count = $this->count($conditions, $joins, $group);
        //数据列表
        $lists = $this->limit($conditions, $fields, $joins, (!empty($orders) ? $orders : ['id' => 'desc']), $group, (int)$page, (int)$page_size, $selectRaw);
        //生成总页码
        $total_pages = (int)ceil($matched_count/$page_size);
        //返回数据
        return compact('total_count', 'matched_count', 'lists', 'total_pages', 'page', 'page_size');
    }

    /**
     * 获取一条信息
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-20 15:10:18
     * @param array $conditions 查询条件
     * @param string[] $fields 查询字段
     * @param string[] $orders 排序条件
     * @return mixed|string
     */
    public function row($conditions = [], $fields = ['*'], $orders = ['created_at' => 'desc'])
    {
        //初始化请求
        $query = $this->setConditions($this->model(), $conditions);
        //设置排序惠泽
        $query = $this->setOrders($query, $orders);
        //调试sql
        $this->debug_sql && $query->dd();
        //返回第一条相关信息
        return $this->setResult($query->first($this->setFields($fields)));
    }

    /**
     * 获取某个字段信息
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-20 15:41:31
     * @param $conditions array 筛选条件
     * @param $field string 获取字段
     * @return mixed|string
     */
    public function find($conditions, $field)
    {
        //初始化请求
        $query = $this->setConditions($this->model(), $conditions);
        //获取信息
        $data = $query->first($this->setFields([$field]));
        //返回查询数据
        return $this->setResult(data_get($data, $field, false));
    }

    /**
     * 返回单独某字段的值集合
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-20 15:42:20
     * @param $field string 获取字段
     * @param array $conditions 筛选条件
     * @return mixed|string
     */
    public function pluck($field, $conditions = [])
    {
        //初始化请求
        $query = $this->setConditions($this->model(), $conditions);
        //调试SQL
        $this->debug_sql && $query->dd();
        //继续查询
        return $this->setResult($query->pluck($field));
    }

    /**
     * 获取全部数据
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-20 15:42:20
     * @param array $conditions 筛选条件
     * @param array $fields 查询字段
     * @param array $joins 表链接信息
     * @param array $orders 排序规则
     * @param string $group group规则
     * @param bool $selectRaw 自定义查询字段结构（涉及复杂结构时使用）
     * @return mixed
     * @throws \Exception
     */
    public function get($conditions = [], $fields = [], $joins = [], $orders = [], $group = '', $selectRaw = false)
    {
        //初始化请求
        $query = $this->setConditions($this->model(), $conditions);
        //初始化表链接信息
        $query = $this->setJoins($query, $joins);
        //初始化排序信息
        $query = $this->setOrders($query, $orders);
        //初始化group
        $query = $this->setGroup($query, $group);
        //判断是否自定义查询字段结构
        if ($selectRaw) {
            //初始化请求
            $query = $query->selectRaw($fields);
        }
        //调试SQL
        $this->debug_sql && $query->dd();
        //获取全部信息
        return $this->setResult($query->get($selectRaw ? [] : $this->setFields($fields)));
    }

    /**
     * 获取限制条数数据
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-20 14:43:43
     * @param array $conditions 筛选条件
     * @param array $fields 查询字段
     * @param array $joins 表链接信息
     * @param array $orders 排序规则
     * @param string $group group规则
     * @param int $page 页码
     * @param int $page_size 每页条数
     * @param bool $selectRaw 自定义查询字段结构（涉及复杂结构时使用）
     * @return mixed|string
     */
    public function limit($conditions, $fields = [], $joins = [], $orders = [], $group = '', $page = 1, $page_size = 20, $selectRaw = false)
    {
        //初始化请求
        $query = $this->setConditions($this->model(), $conditions);
        //初始化表链接信息
        $query = $this->setJoins($query, $joins);
        //初始化排序信息
        $query = $this->setOrders($query, $orders);
        //初始化group
        $query = $this->setGroup($query, $group);
        //判断是否自定义查询字段结构
        if ($selectRaw) {
            //初始化请求
            $query = $query->selectRaw($fields);
        }
        //调试SQL
        $this->debug_sql && $query->dd();
        //获取全部信息
        return $this->setResult($query->offset(($page - 1) * $page_size)->limit((int)($page_size))->get($selectRaw ? [] : $this->setFields($fields)));
    }


    /**
     * 创建数据并返回自增ID
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-20 14:43:43
     * @param $data array 处理数据
     * @return mixed
     * @throws \Exception
     */
    public function insertGetId($data)
    {
        //整理数据
        $data = $this->setData($data);
        //新增信息
        return $this->setResult($this->model->insertGetId($data));
    }

    /**
     * 批量导入数据（任意失败不成立）
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-20 14:43:43
     * @param $data array 处理数据
     * @param int $chunk 分割数据条数
     * @return mixed
     * @throws \Exception
     */
    public function insertAll($data)
    {
        //开始事务处理
        DB::beginTransaction();
        //尝试开始操作
        try {
            //循环数据组
            foreach ($data as $num => $group) {
                //正常插入数据
                $this->insertGetId($group);
            }
            //提交事务
            DB::commit();
        } catch (\Exception $exception) {
            //回滚事物
            DB::rollBack();
            //返回失败
            return $this->setResult(false);
        }
        //返回提交的数据
        return $this->setResult($data);
    }

    /**
     * 更新数据
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-20 14:43:43
     * @param $conditions array 筛选条件
     * @param $data array 更新数据集
     * @return mixed
     * @throws \Exception
     */
    public function update($conditions, $data)
    {
        //整理更新数据
        $data = $this->setData($data);
        //初始化请求
        $query = $this->setConditions($this->model(), $conditions);
        //继续查询
        return $this->setResult($query->update($data));
    }

    /**
     * 删除数据
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-20 14:43:43
     * @param $conditions array 筛选条件
     * @return mixed
     * @throws \Exception
     */
    public function delete($conditions)
    {
        //初始化请求
        $query = $this->setConditions($this->model(), $conditions);
        //继续查询
        return $this->setResult($query->delete());
    }

    /**
     * 聚合查询总数量
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-20 14:43:09
     * @param array $conditions 查询条件
     * @param mixed $joins join查询条件
     * @param mixed $group group查询条件
     * @return mixed|string
     */
    public function count($conditions = [], $joins = false, $group = '')
    {
        //初始化请求
        $query = $this->setConditions($this->model(), $conditions);
        //设置join条件
        $query = $this->setJoins($query, $joins);
        //设置group条件
        $query = $this->setGroup($query, $group);
        //继续查询
        return $this->setResult($query->count());
    }

    /**
     * 更新或新增数据
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-20 14:43:09
     * @param $condition array 判断数据是否存在的条件
     * @param $data array 需要新增/更新的数据
     * @return mixed
     * @throws \Exception
     */
    public function updateOrInsert($condition, $data)
    {
        //整理条件
        $condition = $this->setData($condition);
        //整理更新数据
        $data = $this->setData($data);
        //更新或新增数据
        return $this->model->updateOrInsert($condition, $data);
    }

    /**
     * 自增字段数据
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-20 14:43:09
     * @param $field string 自增数据名
     * @param array $conditions 查询条件
     * @param int|float $inc 自增值
     * @return mixed
     * @throws \Exception
     */
    public function increment($field, $conditions = [], $inc = 1)
    {
        //初始化请求
        $query = $this->setConditions($this->model(), $conditions);
        //自增数据
        return $this->setResult($query->increment($field, $inc));
    }

    /**
     * 自减字段数据
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-20 14:43:09
     * @param $field string 自增数据名
     * @param array $conditions 查询条件
     * @param int|float $dec 自减值
     * @return mixed
     * @throws \Exception
     */
    public function decrement($field, $conditions = [], $dec = 1)
    {
        //初始化请求
        $query = $this->setConditions($this->model(), $conditions);
        //自增数据
        return $this->setResult($query->decrement($field, $dec));
    }

    /**
     * 获取某字段最大值
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-20 14:43:09
     * @param $field string 获取指定字段名称
     * @param array $conditions 查询条件
     * @return mixed
     * @throws \Exception
     */
    public function max($field, $conditions = [])
    {
        //初始化请求
        $query = $this->setConditions($this->model(), $conditions);
        //继续查询
        return $this->setResult($query->max($field));
    }

    /**
     * 获取某字段最小值
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-20 14:43:09
     * @param $field string 获取指定字段名称
     * @param array $conditions 查询条件
     * @return mixed
     * @throws \Exception
     */
    public function min($field, $conditions = [])
    {
        //初始化请求
        $query = $this->setConditions($this->model(), $conditions);
        //继续查询
        return $this->setResult($query->min($field));
    }

    /**
     * 获取某字段平均值
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-20 14:43:09
     * @param $field string 获取指定字段名称
     * @param array $conditions 查询条件
     * @return mixed
     * @throws \Exception
     */
    public function avg($field, $conditions = [])
    {
        //初始化请求
        $query = $this->setConditions($this->model(), $conditions);
        //继续查询
        return $this->setResult($query->avg($field));
    }

    /**
     * 获取某字段和
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-20 14:43:09
     * @param $field string 获取指定字段名称
     * @param array $conditions 查询条件
     * @return mixed
     * @throws \Exception
     */
    public function sum($field, $conditions = [])
    {
        //初始化请求
        $query = $this->setConditions($this->model(), $conditions);
        //继续查询
        return $this->setResult($query->sum($field));
    }

    /**
     * 判断查询条件对应的数据是否存在
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-20 14:43:09
     * @param array $conditions 查询条件
     * @return mixed
     * @throws \Exception
     */
    public function exists($conditions = [])
    {
        //初始化请求
        $query = $this->setConditions($this->model(), $conditions);
        //继续查询
        return $this->setResult($query->exists());
    }

    /**
     * 判断查询条件对应的数据是否不存在
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-20 14:43:09
     * @param array $conditions 查询条件
     * @return mixed
     * @throws \Exception
     */
    public function doesntExists($conditions = [])
    {
        //初始化请求
        $query = $this->setConditions($this->model(), $conditions);
        //继续查询
        return $this->setResult($query->doesntExist());
    }

    /**
     * 设置自增ID
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-20 14:43:09
     * @param int $auto_increment 自增ID值
     * @param null $connection current model connection
     * @return bool
     * @throws \Exception
     */
    public function setIncrementId($auto_increment = 1, $connection = null)
    {
        //整理设置自增ID语句
        $sql = "ALTER TABLE `$this->table_name` auto_increment = $auto_increment";
        //开始执行
        return $this->sqlStatement($sql, $connection);
    }

    /**
     * 设置表注释
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-20 14:43:09
     * @param string $comment 注释内容
     * @param null $connection current model connection
     * @return bool
     * @throws \Exception
     */
    public function setTableComment($comment = '', $connection = null)
    {
        //整理设置表注释
        $sql = "ALTER TABLE `$this->table_name` comment '$comment'";
        //开始执行
        return $this->sqlStatement($sql, $connection);
    }

    /**
     * 生成唯一编码
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-20 14:43:09
     * @param $field string 字段
     * @param string $type 生成类型（md5、su <string upper>、sl <string lower>、number）
     * @param int $length 生成长度 （md5固定为32位，其他有效）
     * @param bool $upper 是否改为大写
     * @return false|string
     * @throws \Exception
     */
    public function uniqueCode($field, $type = 'md5', $length = 8, $upper = false, $prefix = '')
    {
        //根据类型生成对应编码
        switch ($type) {
            case 'md5':
                //生成加密字符串
                $code = md5(HelperLibrary::createSn().Str::random($length));
                break;
            case 'sup':      //string upper
                //生成加密字符串（大写）
                $code = strtoupper(Str::random($length));
                break;
            case 'slo':      //string lower
                //生成加密字符串（小写）
                $code = strtolower(Str::random($length));
                break;
            case 'number':
                //生成加密数字
                $code = HelperLibrary::getNumber($length);
                break;
            default:
                //生成加密字符串
                $code = Str::random($length);
                break;
        }
        //判断是否需要大写
        $upper && $code = strtoupper($code);
        //初始化信息
        $prefix && $code = $prefix.$code;
        //判断数据是否存在
        if ($this->exists([$field => $code])) {
            //重新生成
            return $this->uniqueCode($field, $type, $length);
        }
        //返回编码
        return $code;
    }

}
