@extends('layouts.app')

@section('content')
    <team-table team-slug="{{ $teamSlug }}"></team-table>
@endsection
