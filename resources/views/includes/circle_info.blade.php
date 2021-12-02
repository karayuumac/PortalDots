<dl>
    @foreach ([
        'name' => '企画名',
        'name_yomi' => '企画名(よみ)',
        'group_name' => '企画を出店する団体の名称',
        'group_name_yomi' => '企画を出店する団体の名称(よみ)',
        ] as $field_name => $display_name)
        <dt>{{ $display_name }}
            @if (Auth::user()->isLeaderInCircle($circle) && Gate::allows('circle.update', $circle))
                — <a href="{{ route('circles.edit', ['circle' => $circle]) }}">変更</a>
            @endif
        </dt>
        <dd>{{ $circle->$field_name }}</dd>
    @endforeach
    <dt>メンバー
        @if (Auth::user()->isLeaderInCircle($circle) && Gate::allows('circle.update', $circle))
            — <a href="{{ route('circles.users.index', ['circle' => $circle]) }}">変更</a>
        @endif
    </dt>
    <dd>
        <ul>
            @foreach ($circle->users as $user)
                <li>
                    {{ $user->name }}
                    ({{ $user->student_id }})
                    @if ($user->pivot->is_leader)
                        <app-badge primary>責任者</app-badge>
                    @else
                        <app-badge muted>学園祭係(副責任者)</app-badge>
                    @endif
                </li>
            @endforeach
        </ul>
    </dd>
    @unless($circle->places->isEmpty())
        <dt>
            使用場所
        </dt>
        <dd>
            <ul>
                @foreach ($circle->places as $place)
                    <li>
                        {{ $place->name }}
                    </li>
                @endforeach
            </ul>
        </dd>
    @endunless
    @isset($questions)
        @foreach($questions as $question)
            {{-- heading はそもそも不要. upload は複雑なので後回し --}}
            @unless($question->type == 'upload' || $question->type == 'heading')
                {{-- 選択必須でない単一回答や複数回答に選択しなかった場合, answer_details が作成されないのでその対策 --}}
                @if(array_key_exists($question->id, $answer_details) && $answer_details[$question->id] != '')
                    <dt>
                        {{ $question->name }}
                    </dt>
                    @if(gettype($answer_details[$question->id]) == 'array')
                        <dd>
                            <ul>
                                @foreach($answer_details[$question->id] as $answer)
                                    <li>
                                        {{ $answer }}
                                    </li>
                                @endforeach
                            </ul>
                        </dd>
                    @else
                        <dd>
                            {{ $answer_details[$question->id] }}
                        </dd>
                    @endif
                @endunless
            @endunless
        @endforeach
    @endunless
</dl>
