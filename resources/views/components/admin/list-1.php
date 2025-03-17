<!-- Include header layout -->
@include('admin.layouts.header')

<!-- Include navbar layout -->
@include('admin.layouts.navbar')

<div class="container-fluid">
   <div class="row">
      <!-- Include sidebar layout -->
      @include('admin.layouts.sidebar')
      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
         <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
            <h1 class="h2">
               <!-- Section title -->
               @section('title')
            </h1>
            <!-- Section button -->
            @section('button')
         </div>
         <!-- Section content -->
         @section('content')
      </main>
   </div>
</div>

<!-- Include footer layout -->
@include('admin.layouts.footer')