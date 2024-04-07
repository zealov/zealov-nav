tinymce.PluginManager.add('imagefit', function(editor, url) {
	var openDialog = function() {
		return editor.windowManager.open({
			title: '图片统一格式',
			body: {
				type: 'panel',
				items: [
					{
						type: 'listbox', // component type
						name: 'align', // identifier
						label: '对齐方式',
						items: [
							// { text: '默认', value: '' },
							{ text: '居中对齐', value: 'center' },
						],
					},
					{
						type: 'sizeinput', // component type
						name: 'size', // identifier
						label: 'Dimensions',
					},
				],
			},
			buttons: [
				{
					type: 'cancel',
					text: 'Close',
				},
				{
					type: 'submit',
					text: 'Save',
					primary: true,
				},
			],
			initialData: {},
			onSubmit: function(api) {
				var data = api.getData()
				var editorContent = editor.getContent({ source_view: true })
				const { width, height } = data.size
				let styleStr = `${width ? `width="${width}"` : ''}${
					height ? ` height="${height}"` : ''
				}`
				const content = editorContent
					.replaceAll(
						'<p><img',
						`<p style="text-align: center;"><img ${styleStr}`
					)
					.replaceAll(
						'<p style="text-align: center;"><img',
						`<p style="text-align: center;"><img ${styleStr}`
					)
					.replaceAll(
						'<p style="text-align: left;"><img',
						`<p style="text-align: center;"><img ${styleStr}`
					)
					.replaceAll(
						'<p style="text-align: right;"><img',
						`<p style="text-align: center;"><img ${styleStr}`
					)
				editor.setContent(content)
				api.close()
			},
		})
	}

	// 注册一个工具栏按钮名称
	editor.ui.registry.addButton('imagefit', {
		text: '图片统一格式',
		tooltip: '图片统一格式',
		onAction: function() {
			openDialog()
		},
	})
})
