<x-filament::page>

    <x-filament::card class="col-span-12">
        <x-filament::form wire:submit.prevent="startTrainingAction()">

            Train new robot intents with Python AI tensorflow model!
            <br />

            <x-filament::button type="submit">
               Start Training
            </x-filament::button>
            <br />
            
            {!! $log !!}

        </x-filament::form>
    </x-filament::card>

</x-filament::page>
