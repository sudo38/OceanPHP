<div class="container">
   <header class="lh-1 py-3">
      <div class="row flex-nowrap justify-content-between align-items-center">
         <div class="col-4 pt-1">
            <a class="btn btn-sm btn-outline-secondary mx-3" href="{{ url('login') }}">{{ trans('login.sign_in') }}</a>
         </div>
         <div class="col-4 text-center">
            <a class="blog-header-logo text-body-emphasis text-decoration-none" href="{{ url('/') }}" style="font-size: 25px">Large</a>
         </div>
         <div class="col-4 d-flex justify-content-end align-items-center">
            <ul class="nav nav-pills">
               @if(session('locale') == 'ar')
                  <li class="nav-item">
                     <a href="{{ url('lang?lang=en') }}" class="btn btn-sm btn-outline-secondary">En</a>
                  </li>
               @else
                  <li class="nav-item">
                     <a href="{{ url('lang?lang=ar') }}" class="btn btn-sm btn-outline-secondary">ع</a>
                  </li>
               @endif
            </ul>
         </div>
      </div>
   </header>
   <nav class="nav nav-underline justify-content-center my-2">
      @php $categories = get_data('categories') @endphp
      @foreach($categories as $category)
         @php
            $active = (isset($id) && $id == $category['id']) ? 'active' : '';
            $link = url('categories/'.$category['id']);
            $category = $category['name'];
         @endphp
         
         <a
            href="{{ $link }}"
            class="nav-item nav-link link-body-emphasis mx-3 {{ $active }}"
         >{{ $category }}</a>
      @endforeach
   </nav>
</div>