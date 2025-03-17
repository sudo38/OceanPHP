<!-- Page title -->
@title('OceanPHP | {{ trans("admin.categories") }}')

<!-- Section title -->
@start('title')
{{ trans('admin.categories') }}
@end('title')

<!-- Section button -->
@start('button')
<a href="{{ aurl('categories/add') }}">
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
               <th scope="col">{{ trans('categories.name') }}</th>
               <th scope="col">{{ trans('categories.desc') }}</th>
               <th scope="col">{{ trans('admin.action') }}</th>
            </tr>
         </thead>
         <tbody>
            @foreach ($categories as $i => $category)
               <tr>
                  <td>{{ $i+1 }}</td>
                  <td>{{ $category['name'] }}</td>
                  <td>{{ $category['desc'] }}</td>
                  <td>
                     <a href="{{ aurl('categories/view?id='.$category['id']) }}">
                        <i class="fa-regular fa-eye"></i>
                     </a>
                     <a href="{{ aurl('categories/edit?id='.$category['id']) }}">
                        <i class="fa-solid fa-pen-to-square"></i>
                     </a>
                     {{ delete_record(aurl('categories/delete?id='.$category['id'])) }}
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
      })
   </script>" }}
@endif