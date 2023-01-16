<div>
    <h1>Hello World! {{ $searchVal }}</h1>
    <div style="text-align: center">

        <button wire:click="increment">+</button>
        <h1>{{ $count }}</h1>
    </div>


    <input wire:model="search" type="text" placeholder="Search users..."/>
    <ul>
        <li>test</li>
        @foreach($users as $user)
            <li>{{ $user->name }}</li>
        @endforeach
    </ul>
</div>
