<!-- Page title -->
@title('OceanPHP | {{ trans("login.sign_in") }}')

<!-- Include header layout -->
@include('front.layouts.header')

<div class="container">
   <div class="row mx-auto mt-5 w-50">
      <div class="login-box bg-white pl-lg-5 pl-0">
         <div class="row no-gutters align-items-center">
            <div class="form-wrap bg-white">
               <form action="{{ url('do/login') }}" method="POST" class="form">
                  <div class="row">
                     <div class="col-12 mb-2">
                        <div class="form-group position-relative">
                           <span class="zmdi zmdi-account">
                              <i class="fa-solid fa-envelope"></i>
                           </span>
                           <input
                              type="text"
                              name="email"
                              id="email"
                              value="{{ old('email') }}"
                              class="
                                 form-control
                                 {{ error_msg('email') ? 'invalid' : '' }}
                                 {{ setup()->lang == 'en' ? 'ps-60' : 'pe-60' }}
                              "
                              placeholder="{{ trans('login.email') }}"
                              autocomplete="off"
                           />
                        </div>
                        @if(error_msg('email'))
                           <p class="error">{{ error_msg('email') }}</p>
                        @endif
                     </div>
                     <div class="col-12 mb-4">
                        <div class="form-group position-relative">
                           <span class="zmdi zmdi-account">
                              <i class="fa-solid fa-key"></i>
                           </span>
                           <input
                              type="password"
                              name="password"
                              id="password"
                              class="
                                 form-control
                                 {{ error_msg('password') ? 'invalid' : '' }}
                                 {{ setup()->lang == 'en' ? 'ps-60' : 'pe-60' }}
                              "
                              placeholder="{{ trans('login.password') }}"
                           />
                        </div>
                        @if(error_msg('password'))
                           <p class="error">{{ error_msg('password') }}</p>
                        @endif
                     </div>
                     <div class="col-12 mb-2">
                        <button type="submit" id="submit" class="btn btn-custom btn-dark btn-block">
                           {{ trans('login.sign_in') }}
                        </button>
                     </div>
                     <div class="col-12 text-lg-right">
                        <a href="{{ url('register') }}" class="c-black">{{ trans('register.create_account') }} ?</a>
                     </div>
                     <p class="mt-2 mb-0 text-body-secondary">
                        @if(session('locale') == 'ar')
                           <a href="{{ url('lang?lang=en') }}" class="nav-link">En</a></li>
                        @else
                           <a href="{{ url('lang?lang=ar') }}" class="nav-link">ع</a></li>
                        @endif
                        </p>
                  </div>
                  @php
                     session_forget('old');
                     session_forget('validations');
                  @endphp
               </form>
            </div>
         </div>
      </div>
   </div>
</div>

<!-- Import CSS link -->
@link('{{ asset("front/css/login.css") }}')

<!-- Include footer layout -->
@include('front.layouts.footer')


<!-- Using sweetalert2 -->
@if (session_has('login_failed'))
   {{ "<script>
      Swal.fire({
         icon: 'error',
         text: '".session_flash('login_failed')."',
         showCloseButton: true,
         showConfirmButton: false,
      });
   </script>" }}
@endif