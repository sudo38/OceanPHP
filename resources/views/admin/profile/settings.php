<!-- Page title -->
@title('OceanPHP | {{ trans('settings.account_settings') }}')

<!-- Section title -->
@start('title')
{{ trans('settings.account_settings') }}
@end('title')

<!-- Section form -->
@start('form')
<form action="{{ aurl('settings/update') }}" method="POST">
   <div class="card mb-3">
      <div class="card-body">
         <label class="label">{{ trans('settings.old_password') }}</label>
         <input
            type="password"
            name="old_password"
            autocomplete="off"
            value="{{ old('old_password') }}"
            class="form-input {{ error_msg('old_password') ? 'invalid' : '' }}"
         />
         @if(error_msg('old_password'))
            <p class="error">{{ error_msg('old_password') }}</p>
         @endif

         <br>

         <label class="label">{{ trans('settings.new_password') }}</label>
         <input
            type="password"
            name="new_password"
            autocomplete="off"
            value="{{ old('new_password') }}"
            class="form-input {{ error_msg('new_password') ? 'invalid' : '' }}"
         />
         @if(error_msg('new_password'))
            <p class="error">{{ error_msg('new_password') }}</p>
         @endif

         <br>

         <label class="label">{{ trans('settings.conf_new_password') }}</label>
         <input
            type="password"
            name="conf_new_password"
            autocomplete="off"
            value="{{ old('conf_new_password') }}"
            class="form-input  mb-2 {{ error_msg('conf_new_password') ? 'invalid' : '' }}"
         />
         @if(error_msg('conf_new_password'))
            <p class="error">{{ error_msg('conf_new_password') }}</p>
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