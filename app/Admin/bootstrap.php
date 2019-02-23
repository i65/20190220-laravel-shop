<?php

/**
 * Laravel-admin - admin builder based on Laravel.
 * @author z-song <https://github.com/z-song>
 *
 * Bootstraper for Admin.
 *
 * Here you can remove builtin form field:
 * Encore\Admin\Form::forget(['map', 'editor']);
 *
 * Or extend custom form field:
 * Encore\Admin\Form::extend('php', PHPEditor::class);
 *
 * Or require js and css assets:
 * Admin::css('/packages/prettydocs/css/styles.css');
 * Admin::js('/packages/prettydocs/js/main.js');
 *
 */

// Laravel-Admin 为了避免加载太多前端静态文件，
// 默认禁用了 editor 这个表单组件，我们可以在 app/Admin/bootstrap.php 中把这个禁用解除：
// Encore\Admin\Form::forget(['map', 'editor']);

Encore\Admin\Form::forget(['map']);
