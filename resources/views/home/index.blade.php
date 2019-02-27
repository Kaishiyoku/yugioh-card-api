@extends('layouts.app')

@section('content')
    <p class="lead">Available API endpoints:</p>

    <p>Cards</p>

    <ul>
        <li>
            {{ Html::linkRoute('api.cards.index', route('api.cards.index', null, false)) }}
        </li>
        <li>
            {{ Html::linkRoute('api.cards.get_card_from_set', route('api.cards.get_card_from_set', ['srl-g029'], false), ['srl-g029']) }}
        </li>
        <li>
            {{ Html::linkRoute('api.cards.image', route('api.cards.image', ['srl-g029'], false), ['srl-g029']) }}
        </li>
        <li>
            {{ Html::linkRoute('api.cards.search', route('api.cards.search', ['relinquished'], false), ['relinquished']) }}
        </li>
    </ul>

    <p>Sets</p>

    <ul>
        <li>
            {{ Html::linkRoute('api.sets.index', route('api.sets.index', null, false)) }}
        </li>
        <li>
            {{ Html::linkRoute('api.sets.show', route('api.sets.show', ['srl'], false), ['srl']) }}
        </li>
        <li>
            {{ Html::linkRoute('api.sets.search', route('api.sets.search', ['srl'], false), ['srl']) }}
        </li>
    </ul>

    <p>Miscellaneous</p>

    <ul>
        <li>
            {{ Html::linkRoute('api.statistics.index', route('api.statistics.index', null, false)) }}
        </li>

        <li>
            {{ Html::linkRoute('api.home.version', route('api.home.version', null, false)) }}
        </li>

        <li>{{ Html::linkRoute('api.home.health_check', route('api.home.health_check', null, false)) }}</li>
    </ul>
@endsection
