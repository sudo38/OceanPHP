<!-- Page title -->
@title('OceanPHP | {{ trans("register.register") }}')

<!-- Include header layout -->
@include('front.layouts.header')

<div class="container">
   <div class="row mx-auto mt-5 w-50">
      <div class="login-box bg-white pl-lg-5 pl-0">
         <div class="row no-gutters align-items-center">
            <div class="form-wrap bg-white">
               <form action="{{ url('do/register') }}" method="POST" class="form">
                  @if(session_has('login_failed'))
                     <div class="alert alert-danger  py-2">
                        {{ session_flash('login_failed') }}
                     </div>
                  @endif
                  <div class="row">
                     <div class="col-12 mb-2">
                        <div class="form-group position-relative">
                           <span class="zmdi zmdi-account">
                              <i class="fa-solid fa-user"></i>
                           </span>
                           <input
                              type="text"
                              name="name"
                              id="name"
                              value="{{ old('name') }}"
                              autocomplete="off"
                              placeholder="{{ trans('register.name') }}"
                              class="
                                 form-control
                                 {{ error_msg('name') ? 'invalid' : '' }}
                                 {{ setup()->lang == 'en' ? 'ps-60' : 'pe-60' }}
                              "
                           />
                        </div>
                        @if(error_msg('name'))
                           <p class="error">{{ error_msg('name') }}</p>
                        @endif
                     </div>
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
                              autocomplete="off"
                              placeholder="{{ trans('register.email') }}"
                              class="
                                 form-control
                                 {{ error_msg('email') ? 'invalid' : '' }}
                                 {{ setup()->lang == 'en' ? 'ps-60' : 'pe-60' }}
                              "
                           />
                        </div>
                        @if(error_msg('email'))
                           <p class="error">{{ error_msg('email') }}</p>
                        @endif
                     </div>
                     <div class="col-12 mb-2">
                        <div class="form-group position-relative">
                           <span class="zmdi zmdi-account">
                              <i class="fa-solid fa-lock"></i>
                           </span>
                           <input
                              type="password"
                              name="password"
                              id="password"
                              value="{{ old('password') }}"
                              placeholder="{{ trans('register.password') }}"
                              class="
                                 form-control
                                 {{ error_msg('password') ? 'invalid' : '' }}
                                 {{ setup()->lang == 'en' ? 'ps-60' : 'pe-60' }}
                              "
                           />
                        </div>
                        @if(error_msg('password'))
                           <p class="error">{{ error_msg('password') }}</p>
                        @endif
                     </div>
                     <div class="col-12 mb-4">
                        <div class="form-group position-relative">
                           <span class="zmdi zmdi-account">
                              <i class="fa-solid fa-key"></i>
                           </span>
                           <input
                              type="password"
                              name="conf_password"
                              id="conf_password"
                              value="{{ old('conf_password') }}"
                              class="
                                 form-control
                                 {{ error_msg('conf_password') ? 'invalid' : '' }}
                                 {{ setup()->lang == 'en' ? 'ps-60' : 'pe-60' }}
                              "
                              placeholder="{{ trans('register.conf_password') }}"
                           />
                        </div>
                        @if(error_msg('conf_password'))
                           <p class="error">{{ error_msg('conf_password') }}</p>
                        @endif
                     </div>
                     <div class="col-12 mb-2">
                        <button type="submit" id="submit" class="btn btn-custom btn-dark btn-block">
                           {{ trans('register.create_account') }}
                        </button>
                     </div>
                     <div class="col-12 text-lg-right">
                        <a href="{{ url('login') }}" class="c-black">{{ trans('login.sign_in') }} ?</a>
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