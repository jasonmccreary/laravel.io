<div class="container mx-auto flex flex-wrap mb-2">
    <div class="w-full">
        @forelse ($user->latestThreads() as $thread)
            <div class="thread-card">
                <div class="flex justify-between">
                    <a href="{{ route('thread', $thread->slug()) }}">
                        <h4 class="text-xl font-bold text-gray-900">
                            {{ $thread->subject() }}
                        </h4>

                        <p class="text-gray-600">
                            {!! $thread->excerpt() !!}
                        </p>
                    </a>

                    <div>
                        <span class="text-base font-normal mr-2">
                            <x-heroicon-s-chat class="inline text-gray-500 h-5 w-5 mr-1"/>
                            {{ count($thread->replies()) }}
                        </span>

                        <span class="text-base font-normal">
                            <x-heroicon-s-thumb-up class="inline h-5 w-5 text-gray-500 mr-1"/>
                            {{ count($thread->likes()) }}
                        </span>
                    </div>
                </div>

                <div class="flex flex-col justify-between md:flex-row md:items-center text-sm pt-5">
                    <div class="flex flex-col md:flex-row md:items-center">
                        <div class="flex mb-4 md:mb-0">
                            @if (count($thread->replies()))
                                @include('forum.threads.info.avatar', ['user' => $thread->replies()->last()->author()])
                            @else
                                @include('forum.threads.info.avatar', ['user' => $thread->author()])
                            @endif

                            <div class="mr-6 text-gray-700">
                                @if (count($thread->replies()))
                                    @php($lastReply = $thread->replies()->last())
                                    <a href="{{ route('profile', $lastReply->author()->username()) }}"
                                       class="text-lio-700">
                                        {{ $lastReply->author()->isLoggedInUser() ? 'You' : $lastReply->author()->username() }}
                                    </a> replied {{ $lastReply->createdAt()->diffForHumans() }}
                                @else
                                    <a href="{{ route('profile', $thread->author()->username()) }}"
                                       class="text-lio-700">
                                        {{ $thread->author()->isLoggedInUser() ? 'You' : $thread->author()->username() }}
                                    </a> posted {{ $thread->createdAt()->diffForHumans() }}
                                @endif
                            </div>
                        </div>

                        @include('forum.threads.info.tags')
                    </div>

                    @if ($thread->isSolved())
                        <a class="label label-primary text-center mt-4 md:mt-0"
                           href="{{ route('thread', $thread->slug()) }}#{{ $thread->solutionReplyRelation->id }}">
                            <x-heroicon-s-check class="inline w-4 h-4" />
                            View solution
                        </a>
                    @endif
                </div>
            </div>
        @empty
            <p class="text-gray-600 text-base">
                {{ $user->name() }} has not posted any threads yet
            </p>
        @endforelse
    </div>
</div>
