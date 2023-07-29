@extends('web.base')

@section('title', 'Listings')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Listings') }}</div>

                <div class="card-body">
                    <form action="{{ route('web.search') }}" method="GET">
                        <div class="form-group">
                            <label for="search">{{ __("Search Listings") }}</label>
                            <input type="text" name="search" id="search" class="form-control" placeholder="{{ __('Enter your search query') }}">
                        </div>
                        <button type="submit" class="btn btn-primary">{{ __('Search') }}</button>
                    </form>

                    <hr>

                    <!-- Display listings here -->
                    <div class="listings">
                        <h4>Listing 1</h4>
                        <p>Description of listing 1.</p>

                        <h4>Listing 2</h4>
                        <p>Description of listing 2.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
