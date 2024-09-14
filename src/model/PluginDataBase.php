<?php

declare (strict_types=1);

namespace plugin\data\model;

use think\admin\Model;

class PluginDataBase extends Model
{
    /**
     * 日志名称
     * @var string
     */
    protected $oplogName = '数据字典';

    /**
     * 日志类型
     * @var string
     */
    protected $oplogType = '数据字典管理';

    /**
     * 获取指定数据列表
     * @param string $type 数据类型
     * @param array $data 外围数据
     * @param string $field 外链字段
     * @param string $bind 绑定字段
     * @return array
     */
    public static function items(string $type, array &$data = [], string $field = 'base_code', string $bind = 'base_info'): array
    {
        $map = ['type' => $type, 'status' => 1, 'deleted' => 0];
        $bases = static::mk()->where($map)->order('sort desc,id asc')->column('code,name,content', 'code');
        if (count($data) > 0) foreach ($data as &$vo) $vo[$bind] = $bases[$vo[$field]] ?? [];
        return $bases;
    }

    /**
     * 获取所有数据类型
     * @param boolean $simple 加载默认值
     * @return array
     */
    public static function types(bool $simple = false): array
    {
        $types = static::mk()->where(['deleted' => 0])->distinct()->column('type');
        if (empty($types) && empty($simple)) $types = ['身份权限'];
        return $types;
    }

    /**
     * 格式化创建时间
     * @param mixed $value
     * @return string
     */
    public function getCreateAtAttr($value): string
    {
        return format_datetime($value);
    }
}