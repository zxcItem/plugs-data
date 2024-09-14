<?php

use think\migration\Migrator;

class InstallData extends Migrator
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $this->_create_plugin_data_base();
    }

    /**
     * 插件-系统-字典
     * @class PluginDataBase
     * @table plugin_data_base
     * @return void
     */
    private function _create_plugin_data_base()
    {

        // 当前数据表
        $table = 'plugin_data_base';

        // 存在则跳过
        if ($this->hasTable($table)) return;

        // 创建数据表
        $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '插件-系统-字典',
        ])
            ->addColumn('type', 'string', ['limit' => 20, 'default' => '', 'null' => true, 'comment' => '数据类型'])
            ->addColumn('code', 'string', ['limit' => 100, 'default' => '', 'null' => true, 'comment' => '数据代码'])
            ->addColumn('name', 'string', ['limit' => 500, 'default' => '', 'null' => true, 'comment' => '数据名称'])
            ->addColumn('cate', 'integer', ['limit' => 1, 'default' => 1, 'null' => true, 'comment' => '数据类型'])
            ->addColumn('content', 'text', ['default' => NULL, 'null' => true, 'comment' => '数据内容'])
            ->addColumn('sort', 'biginteger', ['limit' => 20, 'default' => 0, 'null' => true, 'comment' => '排序权重'])
            ->addColumn('status', 'integer', ['limit' => 1, 'default' => 1, 'null' => true, 'comment' => '数据状态(0禁用,1启动)'])
            ->addColumn('deleted', 'integer', ['limit' => 1, 'default' => 0, 'null' => true, 'comment' => '删除状态(0正常,1已删)'])
            ->addColumn('deleted_by', 'biginteger', ['limit' => 20, 'default' => 0, 'null' => true, 'comment' => '删除用户'])
            ->addColumn('create_time', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => true, 'comment' => '创建时间'])
            ->addIndex('type', ['name' => 'i2a29c450f_type'])
            ->addIndex('code', ['name' => 'i2a29c450f_code'])
            ->addIndex('name', ['name' => 'i2a29c450f_name'])
            ->addIndex('sort', ['name' => 'i2a29c450f_sort'])
            ->addIndex('status', ['name' => 'i2a29c450f_status'])
            ->addIndex('deleted', ['name' => 'i2a29c450f_deleted'])
            ->create();

        // 修改主键长度
        $this->table($table)->changeColumn('id', 'integer', ['limit' => 11, 'identity' => true]);
    }
}
