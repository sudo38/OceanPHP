<!-- Include header layout -->
@include('admin.layouts.header')

<!-- Include navbar layout -->
@include('admin.layouts.navbar')

<div class="container-fluid">
   <div class="row">
      <!-- Include sidebar layout -->
      @include('admin.layouts.sidebar')
      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
         <!-- Section content-->
         @section('content')
      </main>
   </div>
</div>

<!-- Include footer layout -->
@include('admin.layouts.footer')