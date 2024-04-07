<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Module\WebNav\Models\Category;
use Module\WebNav\Models\Navigation;
use Zealov\Models\Admin;
use Zealov\Models\SystemConfig;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //后台管理账户
        $data = [
            'name'      => 'admin',
            'nick_name' => '管理员',
            'status'    => 1,
            'email'     => '921491025@qq.com',
            'salt'      => uniqid(),
            'password'  => Hash::make('123456')
        ];
        Admin::query()->updateOrCreate(['name' => 'admin'], $data);
        //初始化分类
        $category_data = [
            [
                'name'      => '平面素材',
                'label'     => 'pingmiansucai',
                'parent_id' => 0,
                'published' => 1,
                'sort'      => 5
            ],
            [
                'name'      => '常用工具',
                'label'     => 'changyonggongju',
                'parent_id' => 0,
                'published' => 1,
                'sort'      => 8
            ],
            [
                'name'      => '在线工具',
                'label'     => 'zaixiangongju',
                'parent_id' => 2,
                'published' => 1,
                'sort'      => 4
            ],
            [
                'name'      => '常用推荐',
                'label'     => 'chuangyongtuijian',
                'parent_id' => 0,
                'published' => 1,
                'sort'      => 1
            ],
            [
                'name'      => '二次元',
                'label'     => 'erciyuan',
                'parent_id' => 0,
                'published' => 1,
                'sort'      => 2
            ],
            [
                'name'      => '配色方案',
                'label'     => 'peisefangan',
                'parent_id' => 2,
                'published' => 1,
                'sort'      => 7
            ],
            [
                'name'      => '视频教程',
                'label'     => 'shipinjiaocheng',
                'parent_id' => 0,
                'published' => 1,
                'sort'      => 6
            ],
        ];
        foreach ($category_data as $value) {
            Category::query()->updateOrCreate(['label' => $value['label']], $value);
        }
        //分类
        $navigations = [
            [
                'category_label' => 'pingmiansucai',
                'name'           => '咕噜素材',
                'url'            => 'https://www.gulusucai.com/',
                'description'    => '质量很高的设计素材网站（推荐）',
                'image_path'     => '/storage/navigation/gulusucai.png'
            ],
            [
                'category_label' => 'pingmiansucai',
                'name'           => '90设计',
                'url'            => 'http://90sheji.com/',
                'description'    => '电商设计（淘宝美工）千图免费淘宝素材库',
                'image_path'     => '/storage/navigation/90sheji.png'
            ],
            [
                'category_label' => 'pingmiansucai',
                'name'           => '昵图网',
                'url'            => 'http://www.nipic.com/',
                'description'    => '原创素材共享平台',
                'image_path'     => '/storage/navigation/90sheji.png'
            ],
            [
                'category_label' => 'pingmiansucai',
                'name'           => '懒人图库',
                'url'            => 'http://www.lanrentuku.com/',
                'description'    => '懒人图库专注于提供网页素材下载',
                'image_path'     => '/storage/navigation/lanrentuku.png'
            ],
            [
                'category_label' => 'pingmiansucai',
                'name'           => '素材搜索',
                'url'            => 'http://so.ui001.com/',
                'description'    => '设计素材搜索聚合',
                'image_path'     => '/storage/navigation/sousucai.png'
            ],
            [
                'category_label' => 'pingmiansucai',
                'name'           => 'PS饭团网',
                'url'            => 'http://psefan.com/',
                'description'    => '不一样的设计素材库！让自己的设计与众不同！',
                'image_path'     => '/storage/navigation/psefan.png'
            ],
            [
                'category_label' => 'pingmiansucai',
                'name'           => '素材中国',
                'url'            => 'http://www.sccnn.com/',
                'description'    => '免费素材共享平台',
                'image_path'     => '/storage/navigation/sccnn.png'
            ],
            [
                'category_label' => 'pingmiansucai',
                'name'           => 'freepik',
                'url'            => 'https://www.freepik.com/',
                'description'    => 'More than a million free vectors, PSD, photos and free icons.',
                'image_path'     => '/storage/navigation/freepik.png'
            ],
            [
                'category_label' => 'zaixiangongju',
                'name'           => '稿定抠图',
                'url'            => 'https://www.gaoding.com/',
                'description'    => '免费在线抠图软件,图片快速换背景-抠白底图',
                'image_path'     => '/storage/navigation/测试头像图片.jpg'
            ],
            [
                'category_label' => 'zaixiangongju',
                'name'           => 'tinypng',
                'url'            => 'https://tinypng.com/',
                'description'    => 'Optimize your images with a perfect balance in quality and file size.',
                'image_path'     => '/storage/navigation/tinypng.png'
            ],
            [
                'category_label' => 'zaixiangongju',
                'name'           => 'svgomg',
                'url'            => 'https://jakearchibald.github.io/svgomg/',
                'description'    => 'SVG在线压缩平台',
                'image_path'     => '/storage/navigation/svgomg.png'
            ],
            [
                'category_label' => 'chuangyongtuijian',
                'name'           => '设计周刊',
                'url'            => 'https://www.shejizhoukan.com/',
                'description'    => '最新设计资讯（每天更新）',
                'image_path'     => '/storage/navigation/shejizhoukan.png'
            ],
            [
                'category_label' => 'chuangyongtuijian',
                'name'           => '字体仓库',
                'url'            => 'https://www.ziticangku.com/',
                'description'    => '最全的免费商用字体库',
                'image_path'     => '/storage/navigation/ziticangku.png'
            ],
            [
                'category_label' => 'chuangyongtuijian',
                'name'           => '电鸭社区',
                'url'            => 'https://eleduck.com/',
                'description'    => '国内最早的远程工作社区，也是互联网工作者们的聚集地，非常适合设计开发小伙伴关注',
                'image_path'     => '/storage/navigation/eleduck.png'
            ],
            [
                'category_label' => 'chuangyongtuijian',
                'name'           => '花瓣',
                'url'            => 'https://huaban.com/',
                'description'    => '收集灵感,保存有用的素材',
                'image_path'     => '/storage/navigation/huaban.png'
            ],
            [
                'category_label' => 'chuangyongtuijian',
                'name'           => 'Google',
                'url'            => 'https://www.google.com/',
                'description'    => '全球最大的搜索引擎',
                'image_path'     => '/storage/navigation/google.png'
            ],
            [
                'category_label' => 'chuangyongtuijian',
                'name'           => '站酷',
                'url'            => 'https://www.zcool.com.cn/',
                'description'    => '中国人气设计师互动平台',
                'image_path'     => '/storage/navigation/zcool.png'
            ],
            [
                'category_label' => 'chuangyongtuijian',
                'name'           => 'youtube',
                'url'            => 'https://www.youtube.com/',
                'description'    => '全球最大的学习分享平台',
                'image_path'     => '/storage/navigation/youtube.png'
            ],
            [
                'category_label' => 'erciyuan',
                'name'           => 'B站',
                'url'            => 'https://www.bilibili.com/',
                'description'    => '国内知名视频弹幕网站，有最及时的动漫新番',
                'image_path'     => '/storage/navigation/hao-nav-bilibili.png'
            ],
            [
                'category_label' => 'erciyuan',
                'name'           => '腾讯动漫',
                'url'            => 'https://ac.qq.com/',
                'description'    => '中国最大最权威的正版动漫网站',
                'image_path'     => '/storage/navigation/hao-nav-acqq.png'
            ],
            [
                'category_label' => 'erciyuan',
                'name'           => 'B站漫画',
                'url'            => 'https://manga.bilibili.com/',
                'description'    => '二次元动漫迷的追漫神器',
                'image_path'     => '/storage/navigation/hao-nav-bzmh.png'
            ],
            [
                'category_label' => 'erciyuan',
                'name'           => '斗鱼',
                'url'            => 'https://www.douyu.com/',
                'description'    => '知名弹幕式直播平台',
                'image_path'     => '/storage/navigation/hao-nav-douyu.png'
            ],
            [
                'category_label' => 'erciyuan',
                'name'           => '动漫之家',
                'url'            => 'https://www.idmzj.com/',
                'description'    => '国内最全最专业的在线漫画',
                'image_path'     => '/storage/navigation/hao-nav-dmzj.png'
            ],
            [
                'category_label' => 'shipinjiaocheng',
                'name'           => 'Photoshop Lady',
                'url'            => 'http://www.photoshoplady.com/',
                'description'    => 'Your Favourite Photoshop Tutorials in One Place',
                'image_path'     => '/storage/navigation/PhotoshopLady.png'
            ],
            [
                'category_label' => 'shipinjiaocheng',
                'name'           => 'doyoudo',
                'url'            => 'http://doyoudo.com/',
                'description'    => '创意设计软件学习平台',
                'image_path'     => '/storage/navigation/doyoudo.png'
            ],
            [
                'category_label' => 'shipinjiaocheng',
                'name'           => '没位道',
                'url'            => 'http://www.c945.com/web-ui-tutorial/',
                'description'    => 'WEB UI免费视频公开课',
                'image_path'     => '/storage/navigation/web_ui_tutorial.png'
            ],
            [
                'category_label' => 'shipinjiaocheng',
                'name'           => '慕课网',
                'url'            => 'https://www.imooc.com/',
                'description'    => '程序员的梦工厂（有UI课程）',
                'image_path'     => '/storage/navigation/imooc.png'
            ],
            [
                'category_label' => 'peisefangan',
                'name'           => 'Adobe Color',
                'url'            => 'https://color.adobe.com/zh/',
                'description'    => '网页设计师配色的最佳之选',
                'image_path'     => '/storage/navigation/hao-nav-adobecolor (1).png'
            ],
            [
                'category_label' => 'peisefangan',
                'name'           => 'Coolors',
                'url'            => 'https://coolors.co/',
                'description'    => '实用！成千上万的配色方案',
                'image_path'     => '/storage/navigation/hao-nav-coolors.png'
            ],
            [
                'category_label' => 'peisefangan',
                'name'           => '漂亮的渐变颜色',
                'url'            => 'https://uigradients.com/',
                'description'    => '今年流行的渐变！点击屏幕两侧按钮可选更多色彩',
                'image_path'     => '/storage/navigation/hao-nav-uigradients.png'
            ],
            [
                'category_label' => 'peisefangan',
                'name'           => 'CssWinner网页色彩分类',
                'url'            => 'https://www.csswinner.com/',
                'description'    => 'CSS画廊，可根据右侧颜色块展现最流行的网页',
                'image_path'     => '/storage/navigation/hao-nav-csswinner.png'
            ],
            [
                'category_label' => 'peisefangan',
                'name'           => '色彩猎人',
                'url'            => 'https://colorhunt.co/',
                'description'    => '每天收集并策划发布美丽的配色方案',
                'image_path'     => '/storage/navigation/hao-nav-colorhunt.png'
            ],
            [
                'category_label' => 'peisefangan',
                'name'           => '中国色彩大辞典',
                'url'            => 'https://hao.uisdc.com/',
                'description'    => '传统色彩命名，点击色彩可直接吸取色值',
                'image_path'     => '/storage/navigation/hao-nav-china.png'
            ],
            [
                'category_label' => 'peisefangan',
                'name'           => '配色导航',
                'url'            => 'https://hao.uisdc.com/color/pick/',
                'description'    => '推荐！流行配色方案，可一键复制喜欢的颜色',
                'image_path'     => '/storage/navigation/hao-nav-ainav.png'
            ],
            [
                'category_label' => 'peisefangan',
                'name'           => 'Fashion Trendsetter',
                'url'            => 'https://www.fashiontrendsetter.com/',
                'description'    => '帮你关注每年最流行的颜色搭配',
                'image_path'     => '/storage/navigation/hao-nav-fashiontrendsetter.png'
            ],
            [
                'category_label' => 'peisefangan',
                'name'           => 'DopelyColors',
                'url'            => 'https://colors.dopely.top/',
                'description'    => '一款实用的获取漂亮渐变方案的工具',
                'image_path'     => '/storage/navigation/hao-nav-DopelyColors.png'
            ],
            [
                'category_label' => 'peisefangan',
                'name'           => 'ColorDrop',
                'url'            => 'https://colordrop.io/',
                'description'    => '让寻找配色方案成为信手拈来的事情',
                'image_path'     => '/storage/navigation/hao-nav-colordrop.png'
            ],
            [
                'category_label' => 'peisefangan',
                'name'           => 'MaterialUI',
                'url'            => 'https://www.materialui.co/',
                'description'    => '推荐！帮助设计师们快速选到自己喜爱的配色方案',
                'image_path'     => '/storage/navigation/hao-nav-materialui.png'
            ],
        ];
        foreach ($navigations as $value) {
            $value['category_id'] = Category::query()->where('label', $value['category_label'])->value('id');
            unset($value['category_label']);
            Navigation::query()->updateOrCreate(['name' => $value['name'], 'category_id' => $value['category_id']], $value);

        }
        //系统设置
        $system_config = [
            [
                'name'  => '网站名称',
                'key'   => 'siteName',
                'value' => '网址导航',
                'type'  => 'string',
                'group' => '网站信息',
            ],
            [
                'name'  => '网站关键词',
                'key'   => 'siteKeywords',
                'value' => 'UI设计,UI设计素材,设计导航,网址导航,设计资源,创意导航,创意网站导航,设计师网址大全,设计素材大全,设计师导航,UI设计资源,优秀UI设计欣赏,设计师导航,设计师网址大全,设计师网址导航,产品经理网址导航,交互设计师网址导航',
                'type'  => 'string',
                'group' => '网站信息',
            ],
            [
                'name'  => '网站描述',
                'key'   => 'siteDescription',
                'value' => '收集国内外优秀设计网站、UI设计资源网站、灵感创意网站、素材资源网站，定时更新分享优质产品设计书签',
                'type'  => 'string',
                'group' => '网站信息',
            ],
            [
                'name'  => 'ICP备案编号',
                'key'   => 'siteBeian',
                'value' => '沪ICP备921491025号-1',
                'type'  => 'string',
                'group' => '网站信息',
            ],
            [
                'name'  => '公安备案链接',
                'key'   => 'siteBeianGonganLink',
                'value' => 'https://beian.miit.gov.cn/',
                'type'  => 'string',
                'group' => '网站信息',
            ],
            [
                'name'  => '网站标题',
                'key'   => 'siteTitle',
                'value' => '网址导航',
                'type'  => 'string',
                'group' => '网站信息',
            ],
            [
                'name'  => '已安装模块',
                'key'   => 'ModuleList',
                'value' => '{"WebNav":{"enable":true,"isSystem":false},"AppStore":{"enable":true,"isSystem":false}}',
                'type'  => 'json',
                'group' => '系统设置',
            ],
            [
                'name'  => '默认模板',
                'key'   => 'webNavTemplate',
                'value' => 'default',
                'type'  => 'string',
                'group' => '系统设置',
            ],
        ];
        foreach ($system_config as $value) {
            SystemConfig::query()->updateOrCreate(['key' => $value['key']], $value);
        }
    }
}
