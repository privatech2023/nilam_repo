<div>
    <ul>
        @foreach($messagesL as $key => $value)
        @if($value['is_inbox'] == 1)
            <li class="replies">
        @else
            <li class="sent">
        @endif
                <p>{{ $value['body'] }}</p>
            </li>
    @endforeach
    </ul>
</div>
