@extends('v2.layouts.app')

@section('title', __('申請'))

@section('content')
@if(empty($circle))
    <header class="header">
        <app-container>
            <h1 class="header__title">
                団体参加登録が未完了です
            </h1>
        </app-container>
    </header>
    <app-container>
        <p>団体参加登録が済んでいないため、申請を行うことができません</p>
        <p>詳細については「{{ config('portal.admin_name') }}」までお問い合わせください</p>
        <p>※ すでに団体参加登録を行った場合でも反映に時間がかかることがあります</p>
        <p><a href="{{ url('/') }}" class="btn is-primary is-block">ホームに戻る</a></p>
    </app-container>
@else
    <div class="tab_strip">
        <a
            href="{{ route('forms.index', ['circle' => $circle]) }}"
            class="tab_strip-tab{{ Route::currentRouteName() === 'forms.index' ? ' is-active' : '' }}"
        >
            {{ __('受付中') }}
        </a>
        <a
            href="{{ route('forms.closed', ['circle' => $circle]) }}"
            class="tab_strip-tab{{ Route::currentRouteName() === 'forms.closed' ? ' is-active' : '' }}"
        >
            {{ __('受付終了') }}
        </a>
        <a
            href="{{ route('forms.all', ['circle' => $circle]) }}"
            class="tab_strip-tab{{ Route::currentRouteName() === 'forms.all' ? ' is-active' : '' }}"
        >
            {{ __('全て') }}
        </a>
    </div>
    <app-container>
        <list-view>
            @foreach ($forms as $form)
            <list-view-item
                href="{{ route('forms.answers.create', ['form' => $form, 'circle' => $circle]) }}"
            >
                <template v-slot:title>
                    {{ $form->name }}
                    @if ($form->answered($circle))
                        <span class="badge is-success">{{ __('提出済') }}</span>
                    @endif
                    @if ($form->yetOpen())
                        <span class="badge is-muted">{{ __('受付開始前') }}</span>
                    @endif
                </template>
                <template v-slot:meta>
                    @if ($form->yetOpen())
                        {{ __('受付開始') }}
                        @datetime($form->open_at)
                    @else
                        {{ __('締切') }}
                        :
                        @datetime($form->close_at)
                    @endif
                    @if ($form->max_answers > 1)
                    • {{ __('このフォームは1団体あたり :max_answers つ回答可能', ['max_answers' => $form->max_answers]) }}
                    @endif
                </template>
                @summary($form->description)
            </list-view-item>
            @endforeach
        </list-view>
    </app-container>
@endif
@endsection