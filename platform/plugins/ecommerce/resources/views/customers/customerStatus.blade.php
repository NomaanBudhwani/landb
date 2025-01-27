<link media="all" type="text/css" rel="stylesheet" href="{{asset('vendor/core/core/base/libraries/bootstrap3-editable/css/bootstrap-editable.css')}}">
<script src="{{asset('vendor/core/core/base/libraries/bootstrap3-editable/js/bootstrap-editable.min.js')}}"></script>


<a data-type="select"
   data-source="{{ json_encode(\Botble\Base\Enums\BaseStatusEnum::$CUSTOMERS) }}"
   data-pk="{{ $item->id }}"
   data-url="{{ route('customers.changeStatus') }}"
   data-value="{{ strtolower($item->status) }}"
   data-title="Change Status"
   class="editable"
   href="#">
    {{ strtoupper($item->status) }}
</a>
