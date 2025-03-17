@if($url)
   @php $rand = md5(rand(000, 999)); @endphp
   <!-- Button trigger modal -->
   <button data-bs-toggle="modal" data-bs-target="#deleteForm{{$rand}}" style="padding: 0; border: 0;">
      <i class="fa-solid fa-trash" style="color: rgb(13 110 253)"></i>
   </button>

   <!-- Modal -->
   <div class="modal fade" id="deleteForm{{$rand}}" tabindex="-1" aria-labelledby="deleteForm{{$rand}}Label" aria-hidden="true">
      <form action="{{ $url }}" method="POST">
            <div class="modal-dialog">
               <div class="modal-content">
                  <div class="modal-header">
                     <h1 class="modal-title fs-5" id="deleteForm{{$rand}}Label">{{ trans('admin.delete_record') }}</h1>
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body" style="text-align: center;">
                     <h5>{{ trans('admin.delete_message') }}</h5>
                  </div>
                  <div class="modal-footer">
                     <button type="submit" class="btn btn-danger">
                        {{ trans('admin.delete') }}
                     </button>
                     <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        {{ trans('admin.cancel') }}
                     </button>
                  </div>
               </div>
            </div>
      </form>
   </div>
@endif