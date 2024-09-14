<?php

declare(strict_types=1);

namespace plugin\data\controller;

use think\admin\Controller;
use think\admin\helper\QueryHelper;
use plugin\data\model\PluginDataBase;

/**
 * 数据字典管理
 * @class Base
 * @package plugin\data\controller
 */
class Base extends Controller
{
    /**
     * 数据字典管理
     * @auth true
     * @menu true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        PluginDataBase::mQuery()->layTable(function () {
            $this->title = '数据字典管理';
            $this->types = PluginDataBase::types();
            $this->type = $this->get['type'] ?? ($this->types[0] ?? '-');
        }, static function (QueryHelper $query) {
            $query->where(['deleted' => 0])->equal('type');
            $query->like('code,name,status')->dateBetween('create_at');
        });
    }

    /**
     * 添加数据字典
     * @auth true
     */
    public function add()
    {
        PluginDataBase::mForm('form');
    }

    /**
     * 编辑数据字典
     * @auth true
     */
    public function edit()
    {
        PluginDataBase::mForm('form');
    }

    /**
     * 表单数据处理
     * @param array $data
     * @throws \think\db\exception\DbException
     */
    protected function _form_filter(array &$data)
    {
        if ($this->request->isGet()) {
            $this->types = PluginDataBase::types();
            $this->types[] = '--- ' . lang('新增类型') . ' ---';
            $this->type = $this->get['type'] ?? ($this->types[0] ?? '-');
        } else {
            $map = [];
            $map[] = ['deleted', '=', 0];
            $map[] = ['code', '=', $data['code']];
            $map[] = ['type', '=', $data['type']];
            $map[] = ['id', '<>', $data['id'] ?? 0];
            if (PluginDataBase::mk()->where($map)->count() > 0) {
                $this->error("数据编码已经存在！");
            }
        }
    }

    /**
     * 修改数据状态
     * @auth true
     */
    public function state()
    {
        PluginDataBase::mSave($this->_vali([
            'status.in:0,1'  => '状态值范围异常！',
            'status.require' => '状态值不能为空！',
        ]));
    }

    /**
     * 删除数据记录
     * @auth true
     */
    public function remove()
    {
        PluginDataBase::mDelete();
    }
}