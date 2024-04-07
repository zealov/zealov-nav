tinymce.PluginManager.add('wechat', function(editor, url) {
  var openDialog = function () {
    return editor.windowManager.open({
      title: '采集微信推文',
      body: {
        type: 'panel',
        items: [
          {
            type: 'input',
            name: 'url',
            placeholder:'请输入微信推文的网址',
            label: 'Url',
            text:'aaa'
          }
        ]
      },
      buttons: [
        {
          type: 'cancel',
          text: 'Close'
        },
        {
          type: 'submit',
          text: 'Collect',
          primary: true
        }
      ],
      initialData: {
      },
      onSubmit: function (api) {

        var data = api.getData();
        console.log('apidata',data);
        // 将输入框内容插入到内容区光标位置
        editor.insertContent('');
        api.close();
      }
    });
  };

  // 注册一个工具栏按钮名称
  editor.ui.registry.addButton('wechat', {
    text: '采集微信推文',
    tooltip: '采集微信推文',
    onAction: function () {
      openDialog();
    }
  });

  // 注册一个菜单项名称 menu/menubar
  editor.ui.registry.addMenuItem('wechat', {
    text: '采集微信推文',
    tooltip: '采集微信推文',
    onAction: function() {
      openDialog();
    }
  });

  return {
    getMetadata: function () {
      return  {
        //插件名和链接会显示在“帮助”→“插件”→“已安装的插件”中
        name: "采集微信推文",//插件名称
        url: "http://www.xiaohuang.cc", //作者网址
      };
    }
  };
});

