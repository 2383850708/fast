define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'shop/category/index',
                    add_url: 'shop/category/add',
                    edit_url: 'shop/category/edit',
                    del_url: 'shop/category/del',
                    multi_url: 'shop/category/multi',
                    table: 'product_cates',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                escape: false,
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'weigh',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'title', title: __('Title'), align: 'left'},
                        {field: 'weigh', title: __('Weigh')},
                        {field: 'stateswitch', title: __('Stateswitch'), formatter: Table.api.formatter.toggle},
                        {field: 'createtime', title: __('Createtime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'operate', title: __('Operate'), table: table,
                            buttons: [
                                {name: 'detail', text: '', title: '添加子类', icon: 'fa fa-plus', classname: 'btn btn-xs btn-success btn-dialog', url: 'shop/category/add'}
                            ], 
                         events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        add: function () {
            Controller.api.bindevent();
        },
        edit: function () {
            Controller.api.bindevent();
        },
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        },
       
    };

    return Controller;
});