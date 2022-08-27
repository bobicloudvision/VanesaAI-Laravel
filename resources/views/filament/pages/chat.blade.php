<x-filament::page>

    <div style="max-height: 500px; overflow-y: scroll">
    @foreach($conversationMessages as $message)
    <div style="margin-top:10px" class="p-4 w-full text-gray-900 bg-white rounded-lg shadow dark:bg-gray-800 dark:text-gray-300" role="alert">
        <div class="flex items-center">
            <div class="inline-block relative shrink-0">
                <img class="w-12 h-12 rounded-full" src="{{url('avatar.jpeg')}}" alt="">
                <span class="inline-flex absolute right-0 bottom-0 justify-center items-center w-6 h-6 bg-blue-600 rounded-full">
                <svg aria-hidden="true" class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 13V5a2 2 0 00-2-2H4a2 2 0 00-2 2v8a2 2 0 002 2h3l3 3 3-3h3a2 2 0 002-2zM5 7a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1zm1 3a1 1 0 100 2h3a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                <span class="sr-only">Message icon</span>
            </span>
            </div>
            <div class="ml-3 text-sm font-normal">
                <div class="text-sm font-semibold text-gray-900 dark:text-white">{{$message->user_id}}</div>
                <div class="text-sm font-normal">{{$message->message}}</div>
                <span class="text-xs font-medium text-blue-600 dark:text-blue-500">{{$message->created_at}}</span>
            </div>
        </div>
    </div>
    @endforeach
    </div>

    <x-filament::card class="col-span-12">

    <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Your message</label>
    <textarea wire:model="message" wire:keydown.enter="sendMessage()" id="message" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Your message..."></textarea>

    </x-filament::card>

</x-filament::page>
