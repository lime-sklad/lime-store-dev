<?php
namespace Core\Classes\System;

class SystemConfig 
{

    public function loadAssets() 
    {
        return [
            'css' => [
                'css/fonts.css',
                'css/style_var.css',
                'css/template.css',
                'css/animate.min.css',
                'lib/css_lib/line-awesome/css/line-awesome.min.css',
                'css/new.style.css',
                'css/responsive.css',
                'css/dark.theme.css',
                'css/network-status.css',
             ],
            'script' => [
                'lib/js_lib/jquery-3.3.1.min.js',
                'lib/js_lib/jquery.pos.js',
                'js/hotkey.js',
                'js/upd.function.js',
                'js/upd.ajax.js',
                
                
                'js/main/stock.function.js',
                'js/main/report.function.js',
                'js/main/cart.js',
                'js/main/arrival.function.js',
                'js/main/write-off.function.js',
                'js/main/transfer.function.js',
                
                'js/dark-theme.js',
                // 'js/network-status.js',
                'lib/xlsx-convert/xlsx.full.min.js',
                'lib/chart/chart.min.js'
                ]
        ];
    }

}