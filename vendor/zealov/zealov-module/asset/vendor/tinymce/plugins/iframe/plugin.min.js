tinymce.PluginManager.add('iframe', function(editor, url) {
  var openDialog = function () {
    return editor.windowManager.open({
      title: '添加Iframe',
      body: {
        type: 'panel',
        items: [
          {
            type: 'urlinput',
            name: 'url',
            filetype: 'file',
            label: 'Url',
            placeholder: '请填入网页网址或上传PDF文件'
          },
          {
            type: 'input',
            name: 'width',
            label: 'Width'
          },
          {
            type: 'input',
            name: 'height',
            label: 'Height'
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
          text: 'Save',
          primary: true
        }
      ],
      initialData: { 
        // url: editor.selection.getNode()
        width: '800',
        height: '600'
      },
      onSubmit: function (api) {
        var data = api.getData();
        // 将输入框内容插入到内容区光标位置
        editor.insertContent('<iframe src="'+data.url.value+'" width="'+data.width+'" height="'+data.height+'"  frameborder="0" scrolling="no" border="0"></iframe>');
        api.close();
      }
    });
  };
  
  // 注册一个工具栏按钮名称
  editor.ui.registry.addButton('iframe', {
    text: 'Iframe',
    tooltip: 'Insert iframe',
    onAction: function () {
      openDialog();
    }
  });

  // 注册一个菜单项名称 menu/menubar
  editor.ui.registry.addMenuItem('iframe', {
    text: 'Iframe',
    tooltip: 'Insert iframe',
    onAction: function() {
      openDialog();
    }
  });

  return {
    getMetadata: function () {
      return  {
        //插件名和链接会显示在“帮助”→“插件”→“已安装的插件”中
        name: "Iframe",//插件名称
        url: "http://www.xiaohuang.cc", //作者网址
      };
    }
  };
});

