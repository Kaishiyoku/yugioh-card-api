@extends('layouts.app')

@section('content')
    <p class="lead">Available API endpoints:</p>

    <p>Cards</p>

    <ul>
        <li>
            {{ Html::linkRoute('api.cards.index') }}
        </li>
        <li>
            {{ Html::linkRoute('api.cards.get_card_from_set', null, ['srl-g029']) }}
        </li>
        <li>
            {{ Html::linkRoute('api.cards.search', null, ['relinquished']) }}
        </li>
    </ul>

    <p>Sets</p>

    <ul>
        <li>
            {{ Html::linkRoute('api.sets.index') }}
        </li>
        <li>
            {{ Html::linkRoute('api.sets.search', null, ['srl']) }}
        </li>
    </ul>

    <p>Miscellaneous</p>

    <ul>
        <li>
            {{ Html::linkRoute('api.statistics.index') }}
        </li>

        <li>
            {{ Html::linkRoute('api.home.version') }}
        </li>

        <li>{{ Html::linkRoute('api.home.health_check') }}</li>
    </ul>
@endsection
