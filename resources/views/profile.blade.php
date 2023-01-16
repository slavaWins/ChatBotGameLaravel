@extends('layouts.containerscreen')

@section('content')


    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card  " style="margin-bottom:  56px;">

                    <div class="card-body">

                        <h5 class=" ">
                            Это ваш профиль, {{  $user['name']}} !
                        </h5>


                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                               {{ session('status') }}
                            </div>
                        @endif




                    </div>
                </div>

                <div class="card  " style="margin-bottom:  56px;">
                    <div class="card-header">{{ __('Основные данные') }}</div>


                    <div class="card-body">
                        Ваш логин

                        <form method="POST" action="{{ route('profile-update') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Логин</label>
                                <input type="text"
                                       value="{{ $user['name'] }}"
                                       class="form-control"
                                       name="name"
                                       id="name"  >

                                @error('inn')
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror


                                <div class="invalid-feedback">Example invalid feedback text</div>
                            </div>


                            <button type="submit" class="btn btn-primary   col-6">
                                {{ __('Save') }}
                            </button>

                        </form>

                    </div>
                </div>




                @for($i=1;$i<3;$i++)
                    <div class="card  " style="margin-bottom:  56px;">
                        <div class="card-body">
                            <h5 class="card-title placeholder-glow">
                                <span class="placeholder col-6"></span>
                            </h5>
                            <p class="card-text placeholder-glow">
                                <span class="placeholder col-7"></span>
                                <span class="placeholder col-4"></span>
                                <span class="placeholder col-4"></span>
                                <span class="placeholder col-6"></span>
                                <span class="placeholder col-8"></span>
                            </p>
                            <a href="#" tabindex="-1" class="btn btn-primary disabled placeholder col-6"></a>
                        </div>
                    </div>

                @endfor

            </div>
        </div>
    </div>
@endsection

