<?php

declare (strict_types=1);

namespace plugin\data;

use think\admin\Plugin;

/**
 * 组件注册服务
 * @class Service
 * @package plugin\data
 */
class Service extends Plugin
{
    /**
     * 定义插件名称
     * @var string
     */
    protected $appName = '基础配置';

    /**
     * 定义安装包名
     * @var string
     */
    protected $package = 'xiaochao/plugs-data';


    /**
     * 签到模块菜单配置
     * @return array[]
     */
    public static function menu(): array
    {
        // 设置插件菜单
        $code = app(static::class)->appCode;
        // 设置插件菜单
        return [
            [
                'name' => '基础管理',
                'subs' => [
                    ['name' => '数据字典管理', 'icon' => 'layui-icon layui-icon-table', 'node' => "{$code}/base/index"],
                ],
            ]
        ];
    }
}