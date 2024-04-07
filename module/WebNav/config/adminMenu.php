<?php

return [
    [
        "sort"      => 1,
        "label"     => "webnav",
        "path"      => "/admin/home",
        "component" => "basic",
        "name"      => "home",
        "hidden"    => false,
        "redirect"  => "",
        "meta"      => [
            "title" => "首页",
            "icon"  => "el-icon-house",
            "roles" => [
                1
            ],
        ],
        "children"  => [
            [
                "label"     => "webnav",
                "path"      => "/admin/home",
                "component" => "home",
                "name"      => "admin.home",
                "hidden"    => false,
                "redirect"  => "",
                "meta"      => [
                    "title" => "首页",
                    "icon"  => "el-icon-house",
                    "roles" => [
                        1
                    ],
                ],

            ],
        ],
    ],
    [
        "sort"      => 2,
        "label"     => "webnav",
        "path"      => "/admin/webnav/navigation",
        "component" => "basic",
        "name"      => "webnav.navigation.index",
        "hidden"    => false,
        "redirect"  => "",
        "meta"      => [
            "title" => "导航菜单",
            "icon"  => "el-icon-position",
            "roles" => [
                'admin'
            ],
        ],
        "children"  => [
            [
                "label"     => "webnav",
                "path"      => "/admin/webnav/navigation",
                "component" => "navigation/navigation",
                "name"      => "webnav.navigation.index",
                "hidden"    => false,
                "redirect"  => "",
                "meta"      => [
                    "title" => "导航菜单",
                    "icon"  => "el-icon-position",
                    "roles" => [
                        'admin'
                    ],
                ],
            ],
        ],
    ],


    [
        "sort"      => 3,
        "label"     => "webnav",
        "path"      => "/admin/webnav/site",
        "component" => "basic",
        "name"      => "webnav.site",
        "hidden"    => false,
        "redirect"  => "noRedirect",
        "meta"      => [
            "title" => "系统设置",
            "icon"  => "el-icon-s-tools",
            "roles" => [
                'admin'
            ],
        ],
        "children"  => [
            [
                "label"     => "webnav",
                "path"      => "/admin/webnav/siteConfig",
                "component" => "site_config",
                "name"      => "webnav.site.index",
                "hidden"    => false,
                "redirect"  => "",
                "meta"      => [
                    "title" => "站点设置",
                    "icon"  => "el-icon-setting",
                    "roles" => [
                        'admin'
                    ],
                ],
            ],
        ],
    ],
];
