<!-- Page title -->
@title('OceanPHP | {{ trans("admin.dashboard") }}')

<!-- Section content -->
@start('content')
<div class="row">
   <div class="card p-2 mt-2">
      <div class="card-body">
         <h5 class="mb-4">{{ trans('admin.add_new') }}</h5>
         <a href="{{ aurl('posts/add') }}" class="text-decoration-underline"><i class="fa-solid fa-pen me-1" style="font-size: 16px"></i> {{ trans('admin.add_post') }}</a>
         <br>
         <a href="{{ aurl('tags/add') }}" class="text-decoration-underline"><i class="fa-solid fa-pen me-1" style="font-size: 16px"></i> {{ trans('admin.add_tag') }}</a>
         <br>
         <a href="{{ aurl('categories/add') }}" class="text-decoration-underline"><i class="fa-solid fa-pen me-1" style="font-size: 16px"></i> {{ trans('admin.add_category') }}</a>
      </div>
   </div>
</div>
@end('content')

<!-- Extends dashboard component -->
@extends('components.admin.dash')

<!-- Import CSS link -->
@link('{{ asset("admin/css/dash.css") }}')

<!-- Import JS script -->
@script('{{ asset("admin/js/dash.js") }}')