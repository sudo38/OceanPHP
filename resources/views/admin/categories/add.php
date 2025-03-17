<!-- Page title -->
@title('OceanPHP | {{ trans("categories.add") }}')

<!-- Section title -->
@start('title')
{{ trans('categories.add') }}
@end('title')

<!-- Section form -->
@start('form')
<form action="{{ aurl('categories/store') }}" method="POST">
   <div class="card mb-3">
      <div class="card-body">
         <label class="label">{{ trans('categories.name') }}</label>
         <input
            type="text"
            name="name"
            autocomplete="off"
            value="{{ old('name') }}"
            class="form-input  {{ error_msg('name') ? 'invalid' : '' }}"
         />
         @if(error_msg('name'))
            <p class="error">{{ error_msg('name') }}</p>
         @endif
      </div>
   </div>
   <div class="card mb-3">
      <div class="card-body">
         <label class="label">{{ trans('categories.desc') }}</label>
         <textarea
            rows="3"
            name="desc"
            class="form-input  {{ error_msg('desc') ? 'invalid' : '' }}"
         >{{ old('desc') }}</textarea>
         @if(error_msg('desc'))
            <p class="error">{{ error_msg('desc') }}</p>
         @endif
      </div>
   </div>
   <div class="d-flex flex-row-reverse mt-4 mb-2">
      <button type="button" class="main-btn ms-2" style="background: #6c757d">
         <a href="{{ aurl('categories') }}" style="color: #fff">
            {{ trans('admin.cancel') }}
         </a>
      </button>
      <button type="submit" class="main-btn">
         {{ trans('admin.add') }}
      </button>
   </div>
</form>
@end('form')

<!-- Extends form component -->
@extends('components.admin.form')