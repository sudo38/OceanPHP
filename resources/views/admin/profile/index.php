<!-- Page title -->
@title('OceanPHP | {{ trans('profile.details') }}')

<!-- Section title -->
@start('title')
{{ trans('profile.details') }}
@end('title')

<!-- Section form -->
@start('form')
<form action="{{ aurl('profile/update') }}" method="POST">
   <div class="card mb-3">
      <div class="card-body">
         <label class="label">{{ trans('profile.name') }}</label>
         <input
            type="text"
            name="name"
            autocomplete="off"
            value="{{ $profile['name'] }}"
            class="form-input {{ error_msg('name') ? 'invalid' : '' }}"
         />
         @if(error_msg('name'))
            <p class="error">{{ error_msg('name') }}</p>
         @endif

         <br>

         <label class="label">{{ trans('profile.email') }}</label>
         <input
            type="text"
            name="email"
            autocomplete="off"
            value="{{ $profile['email'] }}"
            class="form-input mb-2 {{ error_msg('email') ? 'invalid' : '' }}"
         />
         @if(error_msg('email'))
            <p class="error">{{ error_msg('email') }}</p>
         @endif
      </div>
   </div>
   <div class="d-flex flex-row-reverse mt-4 mb-2">
      <button type="button" class="main-btn ms-2" style="background: #6c757d">
         <a href="{{ aurl('dashboard') }}" style="color: #fff">
         {{ trans('admin.back') }}</a>
      </button>
      <button type="submit" class="main-btn">
         {{ trans('admin.update') }}
      </button>
   </div>
</form>
@end('form')

<!-- Extends form component -->
@extends('components.admin.form')

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