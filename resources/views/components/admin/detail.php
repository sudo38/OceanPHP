<!-- Include header layout -->
@include('admin.layouts.header')

<!-- Include navbar layout -->
@include('admin.layouts.navbar')

<div class="container pt-5">
   <article class="blog-post">
      <!-- Section content-->
      @section('content')
      <p class="main-btn mt-5">
         <a href="{{ $_SERVER['HTTP_REFERER'] }}" style="color:#fff">
            {{ trans('admin.back') }}
         </a>
      </p>
   </article>
</div>

<!-- Include footer layout -->
@include('admin.layouts.footer')