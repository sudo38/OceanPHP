<!-- Page title -->
@title('OceanPHP | {{ trans("admin.posts") }}')

<!-- Section title -->
@start('title')
{{ trans('admin.posts') }}
@end('title')

<!-- Section button -->
@start('button')
<a href="{{ aurl('posts/add') }}">
   <i class="fa-solid fa-square-plus"></i>
</a>
@end('button')

<!-- Section content -->
@start('content')
<div class="card mb-4">
   <div class="card-body table-responsive fixed-table-container p-0">
      <table class="table table-hover m-0">
         <thead>
            <tr>
               <th scope="col">#</th>
               <th scope="col">{{ trans('posts.title') }}</th>
               <th scope="col">{{ trans('posts.author') }}</th>
               <th scope="col">{{ trans('posts.category') }}</th>
               <th scope="col">{{ trans('posts.tags') }}</th>
               <th scope="col">{{ trans('admin.action') }}</th>
            </tr>
         </thead>
         <tbody>
            @foreach($posts as $i => $post)
               <tr>
                  <td>{{ $i+1 }}</td>
                  <td>{{ $post['title'] }}</td>
                  <td>
                     <a href="{{ aurl('posts?user_id='.$post['user_id']) }}">
                     {{ $post['author'] }}
                     </a>
                  </td>
                  <td>
                     <a href="{{ aurl('posts?category_id='.$post['category_id']) }}">
                     {{ $post['category'] }}
                     </a>
                  </td>
                  <td>
                     @php $tags = tags_related_post('posts', $post['id']) @endphp
                     @foreach($tags as $tag_id => $tag_name)
                        <a href="{{ aurl('posts?tag_id='.$tag_id) }}">
                           {{ $tag_name.$comma }}
                        </a>
                     @endforeach
                  </td>
                  <td>
                     <a href="{{ aurl('posts/view?id='.$post['id']) }}">
                        <i class="fa-regular fa-eye"></i>
                     </a>
                     <a href="{{ aurl('posts/edit?id='.$post['id']) }}">
                        <i class="fa-solid fa-pen-to-square"></i>
                     </a>
                     {{ delete_record(aurl('posts/delete?id='.$post['id'])) }}
                  </td>
               </tr>
            @endforeach
         </tbody>
      </table>
   </div>
</div>
<nav>
   {{ $links }}
</nav>
@end('content')

<!-- Extends list component -->
@extends('components.admin.list-2')

<!-- Display alert message -->
@if (session_has('message'))
   {{ "<script>
      Swal.fire({
         icon: 'success',
         text: '".session_flash('message')."',
         showCloseButton: true,
         showConfirmButton: false,
      });
   </script>" }}
@endif