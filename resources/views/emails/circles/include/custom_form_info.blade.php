@isset($questions)
@foreach($questions as $question)
{{-- heading はそもそも不要. upload は複雑なので後回し --}}
@unless($question->type == 'upload' || $question->type == 'heading')
{{-- 選択必須でない単一回答や複数回答に選択しなかった場合, answer_details が作成されないのでその対策 --}}
@if(array_key_exists($question->id, $answer_details) && $answer_details[$question->id] != '')
@if(gettype($answer_details[$question->id]) == 'array')
- {{ $question->name }}
@foreach($answer_details[$question->id] as $answer)
  - {{ $answer }}
@endforeach
@else
- {{ $question->name }}：{{ $answer_details[$question->id] }}
@endif
@endif
@endunless
@endforeach
@endunless
