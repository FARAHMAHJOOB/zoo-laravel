<div class="width-16-rem">
    <form action="">
        <input type="text" wire:model="searchTerm" class="form-control form-control-sm form-text border-blue" placeholder="جستجو در حیوانات..." id="search" onblur="$('#searchResult').hide()" onclick="$('#searchResult').show()">
    </form>
    <ul class="searchBox list-group width-16-rem border" id="searchResult">
        @if($animals && $animals->count()>0)
        @foreach($animals as $animal)
        <li class="list-group-item px-1" title="جزییات {{$animal->name}}"><a href="{{route('admin.animal.show' , $animal->id)}}"> {{$animal->name . ' - ' . $animal->english_name}} </a> </li>
        @endforeach
        @elseif($searchTerm !== '')
        <li class="list-group-item p-1">حیوانی با این مشخصات یافت نشد</li>
        @endif
    </ul>
</div>