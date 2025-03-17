<!-- Page title -->
@title('OceanPHP | {{ trans("posts.add") }}')

<!-- Section title -->
@start('title')
{{ trans('posts.add') }}
@end('title')

<!-- Section form -->
@start('form')
<form action="{{ aurl('posts/store') }}" method="POST" enctype="multipart/form-data">
   <div class="row">
      <div class="col-md-9">
         <div class="card mb-3">
            <div class="card-body">
               <label class="label">{{ trans('posts.title') }}</label>
               <input
                  type="text"
                  name="title"
                  autocomplete="off"
                  value="{{ old('title') }}"
                  class="form-input {{ error_msg('title') ? 'invalid' : '' }}"
               />
               @if(error_msg('title'))
                  <p class="error">{{ error_msg('title') }}</p>
               @endif
            </div>
         </div>
         <div class="card mb-3">
            <div class="card-body">
               <label class="label">{{ trans('posts.image') }}</label>
               <input
                  type="file"
                  name="image"
                  class="form-input {{ error_msg('image') ? 'invalid' : '' }}"
               />
               @if(error_msg('image'))
                  <p class="error">{{ error_msg('image') }}</p>
               @endif
            </div>
         </div>
         <div class="card mb-3">
            <div class="card-body">
               <label class="label">{{ trans('posts.intro') }}</label>
               <textarea
                  rows="3"
                  name="intro"
                  class="form-input {{ error_msg('intro') ? 'invalid' : '' }}"
               >{{ old('intro') }}</textarea>
               @if(error_msg('intro'))
                  <p class="error">{{ error_msg('intro') }}</p>
               @endif
            </div>
         </div>
         <div class="card mb-3">
            <div class="card-body">
               <label class="label">{{ trans('posts.content') }}</label>
               <textarea
                  rows="5"
                  name="content"
                  class="form-input {{ error_msg('content') ? 'invalid' : '' }}"
               />{{ old('content') }}</textarea>
               @if(error_msg('content'))
                  <p class="error">{{ error_msg('content') }}</p>
               @endif
            </div>
         </div>
      </div>
      <div class="col-md-3">
         <div class="card mb-3">
            <div class="card-body">
               <label class="label">{{ trans('posts.category') }}</label>
               <div class="form">
                  @if($categories)
                     @foreach($categories as $category)
                        <div class="d-flex mb-1">
                           <input
                              type="radio"
                              name="category_id"
                              id="{{ $category['id'] }}"
                              value="{{ $category['id'] }}"
                              class="me-2"
                              {{ ($category['id'] == old('category_id')) ? 'checked' : '' }}
                           />
                           <label for="{{ $category['id'] }}">
                              {{ $category['name'] }}
                           </label>
                           <br>
                        </div>
                     @endforeach
                  @endif
               </div>
               @if(error_msg('category_id'))
                  <p class="error">{{ error_msg('category_id') }}</p>
               @endif
            </div>
         </div>
         <div class="card">
            <div class="card-body">
               <label class="label">{{ trans('posts.tags') }}</label>
               @if($tags)
                  @foreach($tags as $tag)
                     <input
                        type="checkbox"
                        name="tags[]"
                        id="{{ $tag['id'] }}"
                        value="{{ $tag['id'] }}"
                        {{ (old('tags') && in_array($tag['id'], old('tags'))) ? 'checked' : '' }}
                     />
                     <label class="mb-2" for="{{ $tag['id'] }}">
                        {{ $tag['name'] }}
                     </label>
                     <br>
                  @endforeach
               @endif
               @if(error_msg('tags'))
                  <p class="error">{{ error_msg('tags') }}</p>
               @endif
            </div>
         </div>
      </div>
   </div>
   <div class="d-flex flex-row-reverse mt-4 mb-2">
      <button type="button" class="main-btn ms-2" style="background: #6c757d">
         <a href="{{ aurl('posts') }}" style="color: #fff">
         {{ trans('admin.cancel') }}</a>
      </button>
      <button type="submit" class="main-btn">
         {{ trans('admin.add') }}
      </button>
   </div>
</form>
@end('form')

<!-- Extends form component -->
@extends('components.admin.form')