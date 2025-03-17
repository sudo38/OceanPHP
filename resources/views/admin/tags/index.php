<!-- Page title -->
@title('OceanPHP | {{ trans("admin.tags") }}')

<!-- Section title -->
@start('title')
{{ trans('admin.tags') }}
@end('title')

<!-- Section button -->
@start('button')
<a href="{{ aurl('tags/add') }}">
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
               <th scope="col">{{ trans('tags.name') }}</th>
               <th scope="col">{{ trans('tags.desc') }}</th>
               <th scope="col">{{ trans('admin.action') }}</th>
            </tr>
         </thead>
         <tbody>
            @foreach($tags as $i => $tag)
               <tr>
                  <td>{{ $i+1 }}</td>
                  <td>{{ $tag['name'] }}</td>
                  <td>{{ $tag['desc'] }}</td>
                  <td>
                     <a href="{{ aurl('tags/'.$tag['id']) }}">
                        <i class="fa-regular fa-eye"></i>
                     </a>
                     <a href="{{ aurl('tags/edit/'.$tag['id']) }}">
                        <i class="fa-solid fa-pen-to-square"></i>
                     </a>
                     {{ delete_record(aurl('tags/delete/'.$tag['id'])) }}
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
@extends('components.admin.list-1')

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