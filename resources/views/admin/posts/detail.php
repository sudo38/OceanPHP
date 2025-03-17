<!-- Page title -->
@title('OceanPHP | {{ $post["title"] }}')

<!-- Section content -->
@start('content')
<h2 class="display-5 link-body-emphasis mb-1">{{ $post['title'] }}</h2>
<div class="blog-post-meta">
   <p class="blog-post-date d-flex mb-0">
      <i class="fa-solid fa-clock"></i>
      {{ $created_at }}
   </p>
   <p class="blog-post-author d-flex mb-0">
      <i class="fa-solid fa-user"></i>
      {{ $user['name'] }}
   </p>
</div>
<hr>
<p class="my-4">
   {{ view_image($image) }}
</p>
<p class="mb-4">{{ $post['content'] }}</p>
<p>
   @foreach($tags as $tag_id => $tag_name)
      <a href="{{ aurl('posts?tag_id='.$tag_id) }}" class="tag">
         {{ $tag_name }}
      </a>
   @endforeach
</p>
@end('content')

<!-- Extends detail component -->
@extends('components.admin.detail')