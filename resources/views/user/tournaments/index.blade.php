@extends('user.layouts.app')

@section('title', 'Tournaments')

@section('content')
    <div class="container mt-5">
        <div class="text-center mb-4">
            <h2>Tournaments</h2>
        </div>

        <div class="card border-0 shadow">
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                <ul class="list-group">
                    @forelse ($tournaments as $tournament)
                        <li class="list-group-item">
                            <strong>Tournament Name:</strong> {{ $tournament->name }}
                            <br>
                            <strong>Description:</strong> {{ $tournament->description }}
                            <br>
                            <strong>Location:</strong> {{ $tournament->location }}
                            <br>
                            <strong>Start Date:</strong> {{ $tournament->start_date }}
                            <br>
                            <strong>End Date:</strong> {{ $tournament->end_date }}

                            <br>

                            @if($tournament->teams->count() < 5)
                                {{-- Allow team to join if there is room --}}
                                <form action="{{ route('user.tournaments.join', ['tournament' => $tournament->id]) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success">Join Tournament</button>
                                </form>

                                <a href="{{ route('user.tournaments.show', ['tournament' => $tournament->id]) }}" class="btn btn-primary">View Tournament</a>
                            @else
                                {{-- Display a message indicating that the tournament is full --}}
                                <span class="text-danger">Tournament is full</span>

                                <a href="{{ route('user.tournaments.show', ['tournament' => $tournament->id]) }}" class="btn btn-info ml-2">View Tournament</a>
                            @endif

                            <br>

                            <strong>Joined Teams:</strong>
                            @forelse ($tournament->teams as $team)
                                {{ $team->name }},
                            @empty
                                No teams joined yet.
                            @endforelse
                        </li>
                    @empty
                        <li class="list-group-item">No tournaments found.</li>
                    @endforelse
                </ul>

            </div>
        </div>
    </div>
@endsection
