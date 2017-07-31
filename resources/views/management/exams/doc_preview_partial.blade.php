{{ $exam }}
{{-- @foreach ($exam->slots as $slots)
  @foreach ($slots as $slot)
    <div class="panel">
      <div class="panel-heading">
        Slot
      </div>
      <div class="panel-body">
        @foreach ($slot as $key => $value)
           <p>{{ $key }}</p>
           @foreach ($value as $item)
             <p>{{ print_r($item) }}</p>
           @endforeach
        @endforeach
      </div>
    </div>
  @endforeach
@endforeach
 --}}