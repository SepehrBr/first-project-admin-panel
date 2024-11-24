@foreach ($comments as $comment)
    <div class="card {{ !$loop->first ? 'mt-3 mb-3' : ''}}">
        <div class="card-header d-flex justify-content-between">
            <div class="commenter">
                <span>{{ $comment->user->name }}</span>
                {{-- <span class="text-muted">میلادی: {{ \Carbon\Carbon::parse($comment->created_at)->format('y m d') }}</span> --}}
                {{-- <span class="text-muted">شمسی: {{ jdate($comment->created_at)->format('%B %d %Y') }}</span> --}}
                <span class="text-muted"> {{ jdate($comment->created_at)->ago() }}</span>
                {{-- more formats on https://github.com/morilog/jalali --}}
            </div>
            @auth
                <span class="btn btn-sm btn-primary" data-id="{{ $comment->id }}" id="replyTo">Reply To</span>
            @endauth
        </div>
        <div class="card-body">
            {{ $comment->comment }}

            @include('layouts.comments', ['comments' => $comment->child])
        </div>
    </div>
@endforeach
