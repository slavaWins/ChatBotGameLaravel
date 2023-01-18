<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light navbarMain">
    <!-- Container wrapper -->

    <div class="container-fluid p-0 ">
        <!-- Toggle button -->


        <button
            class="navbar-toggler"
            type="button"
            data-mdb-toggle="collapse"
            data-mdb-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >
            <i class="fas fa-bars"></i>
        </button>

        <!-- Collapsible wrapper -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Navbar brand -->


            <div class=" col-auto   px-0" style="    ">
                <a class="navbar-brand  " href="{{ route("home") }}" style="margin-top: -3px;">
                    <img
                        src="/img/Logo.png"
                        height="30"
                        alt="MDB Logo"
                        loading="lazy"
                    />
                </a>
            </div>

            <!-- Left links -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0  ">


                <li class="nav-item  ">
                    <a class="nav-link" href="{{ route("home") }}"> Главная
                    </a>
                </li>


                @auth

                    <li class="nav-item  ">
                        <a class="nav-link" href="{{ route("messagebox.index") }}"> Меседжер
                        </a>
                    </li>



                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin') }}"> Админка
                        </a>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('bot.cron') }}"> bot.cron
                        </a>
                    </li>

                @endauth

            </ul>
            <!-- Left links -->
        </div>

        <div class="d-flex align-items-center">

            @guest
                <ul class="navbar-nav me-auto mb-2 mb-lg-0  ">
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Вход</a>
                        </li>
                    @endif


                </ul>
            @endguest

            @auth

                <!-- Avatar -->
                <div class="dropdown">
                    <a
                        class="dropdown-toggle d-flex align-items-center hidden-arrow"
                        href="#"
                        id="navbarDropdownMenuAvatar"
                        role="button"
                        data-mdb-toggle="dropdown"
                        aria-expanded="false"
                        style="font-size: 12px; color: #333;"
                    >
                        <img
                            src="/img/ava0.jpg"
                            class="rounded-circle"
                            height="22"
                            loading="lazy"
                        />
                        &nbsp;&nbsp; {{ Auth::user()->name }}
                    </a>
                    <ul
                        class="dropdown-menu dropdown-menu-end"
                        aria-labelledby="navbarDropdownMenuAvatar"
                    >

                        <li>
                            <a class="dropdown-item" href="{{ route('profile') }}">Профиль</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>

            @endauth

        </div>
        <!-- Right elements -->
    </div>
    <!-- Container wrapper -->
</nav>
<!-- Navbar -->



@if(session()->has('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div>
@endif

<?php

if ($errors->all()){
foreach ($errors->all() as $V){
    ?>
<div class="card m-4 p-4 alert alert-danger">
    {{$V}}
</div>
    <?
}
}
?>
