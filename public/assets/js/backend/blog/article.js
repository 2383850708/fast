define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'blog/article/index',
                    add_url: 'blog/article/add',
                    edit_url: 'blog/article/edit',
                    del_url: 'blog/article/del',
                    multi_url: 'blog/article/multi',
                    table: 'article',
                }
            });

            var table = $("#table");

		
            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
						{field: 'category.name', title: __('Category.name'),operate: false,searchList: $.getJSON("blog/article/get_category")},
                        {field: 'title', title: __('Title')},
                        {field: 'author', title: __('Author')},
                        {field: 'keyword', title: __('Keyword')},
						{field: 'flag', title: __('Flag'),searchList: {"hot": __('Flag hot'), "index": __('Flag index'), "recommend": __('Flag recommend')}, operate: 'FIND_IN_SET', formatter: Table.api.formatter.label, formatter: Table.api.formatter.flag},
                        {field: 'thumbimage', title: __('Thumbimage'), operate: false, formatter: Table.api.formatter.image},
						{field: 'hits', title: __('Hits')},
                        {field: 'pageviews', title: __('Pageviews')},
                        {field: 'comment_count', title: __('Comment_count')},
						{field: 'admin.username', title: __('Admin.username')},
                        {field: 'status', title: __('Status'),searchList: {"normal": __('Normal'), "hidden": __('Hidden')},operate: 'FIND_IN_SET',formatter: Table.api.formatter.status},
                        {field: 'createtime', title: __('Createtime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'updatetime', title: __('Updatetime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
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
        }
    };
    return Controller;
	
});