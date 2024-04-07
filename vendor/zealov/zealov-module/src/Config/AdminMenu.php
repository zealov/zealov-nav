<?php

return [
    [
        "sort"      => 999,
        "label"     => "system",
        "path"      => "/admin/personal",
        "component" => "personal",
        "name"      => "personal",
        "hidden"    => true,
        "redirect"  => "",
        "meta"      => [
            "title" => "个人信息",
            "icon"  => "el-icon-files",
            "roles" => [
                'admin'
            ],
        ],
    ],
    [
        "sort"      => 999,
        "label"     => "blog",
        "path"      => "/admin/iframe/personal",
        "component" => "basic",
        "name"      => "admin.iframe.personal",
        "hidden"    => true,
        "redirect"  => "",
        "meta"      => [
            "title" => "iframe",
            "icon"  => "el-icon-files",
            "roles" => [
                'admin'
            ],
        ],
        "children"  => [
            [
                "label"     => "blog",
                "path"      => "/admin/iframe/personal",
                "component" => "iframe",
                "name"      => "admin.iframe.personal.index",
                "hidden"    => false,
                "redirect"  => "",
                "meta"      => [
                    "title" => "个人信息",
                    "icon"  => "el-icon-goods",
                    "roles" => [
                        'admin'
                    ],
                    "iframe"=>"/admin/personal"
                ],
            ]
        ],
    ],
];
