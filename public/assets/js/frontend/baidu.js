define([], function () {
    require.config({
    paths: {
        'baidueditor': '../addons/baidueditor/ueditor.all',
        'ZeroClipboard' : "../addons/baidueditor/third-party/zeroclipboard/ZeroClipboard"
    },
    shim: {
        'baidueditor': ['../addons/baidueditor/ueditor.config'],
    }
});
require(['ZeroClipboard'],function(ZeroClipboard){
    window['ZeroClipboard'] = ZeroClipboard;
});

require(['form', 'upload'], function (Form, Upload) {
    var baidu;
    require(['baidueditor'], function () {
        $(".editor").each(function () {
            $(this).hide();
            var id = $(this).attr("id");
            var name = $(this).attr("name");
            $("<scrpit />").attr({'id' : 'baidu-' + id, 'name' : name}).insertAfter(this);
            baidu = UE.getEditor('baidu-' + id);
        });
    });
    
});

});