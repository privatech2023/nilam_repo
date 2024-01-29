<div>
    <ul>
        @foreach($messagesL as $key => $value)
        <li class="sent">
            <p>{{$value}}</p>
        </li>
        {{-- <li class="replies">
            <img src="#" alt="" />
            <p>Hka</p>
        </li>
        <li class="sent">
            <img src="#" alt="" />
            <p>okay !</p>
        </li> --}}
        @endforeach
    </ul>
</div>
