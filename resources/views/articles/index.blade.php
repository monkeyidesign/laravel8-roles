@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Articles') }}</div>

                    <div class="card-body">
                        <a class="btn btn-primary" href="{{ route('articles.create') }}">New Article</a>
                        <br /><br />
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Title</th>
{{--                                @if(@auth()->user()->is_admin)--}}
{{--                                    <th>User</th>--}}
{{--                                @endif--}}
                                @can('see-article-user')
                                    <th>User</th>
                                @endcan
                                <th>Created at</th>
                                <th>Published at</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($articles as $article)
                                <tr>
                                    <td>{{ $article->title }}</td>
{{--                                    @if(@auth()->user()->is_admin)--}}
{{--                                        <td>{{ $article->user->name }}</td>--}}
{{--                                    @endif--}}
                                    @can('see-article-user')
                                        <td>{{ $article->user->name }}</td>
                                    @endcan
                                    <td>{{ $article->created_at }}</td>
                                    <td>{{ $article->published_at }}</td>
                                    <td>
                                        <a href="{{ route('articles.edit', $article->id) }}" class="btn btn-sm btn-info">Edit</a>
                                        <form action="{{ route('articles.destroy', $article->id) }}" method="POST" style="display: inline">
                                            @csrf
                                            @method('DELETE')
                                            <input type="submit" class="btn btn-sm btn-danger" value="Delete" onclick="return confirm('Are you sure?')" />
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">No articles found.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
