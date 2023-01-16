@php
    use SlavaWins\Formbuilder\Library\FElement;

   /*** @var $order \app\Models\Trash\Order */
@endphp


@extends('layouts.fullscreen')





@section('content')
    <div class="container-fluid px-2">
        <div class="row justify-content-left  ">


            @include('layouts.sidebar')


            <div class="col-md-8 col-lg-9">

                <div class="col-md-12">

                    <h3>Заказ {{$order->title}} </h3>
                    <small>#{{$order->id}}</small>


                </div>


                <div class="row">
                    <div class="col-md-8">


                        <div class="input-group ">
                            <div class="form-outline col-xs-12" style=" width: 100%;">
                                <input type="search" id="searchLineInput" class="form-control"/>
                                <label class="form-label" for="form1">Search</label>
                            </div>

                        </div>

                        <Br>


                        <style>

                            .tableMonitor tr {
                                cursor: pointer;
                            }

                            .tableMonitor td {

                                padding: 0px;
                            }

                        </style>


                        <table class="table align-middle mb-0 bg-white tableMonitor">
                            <thead class="bg-light">
                            <tr>
                                <th scope="col">Date</th>
                                <th scope="col">Host</th>
                                <th scope="col">Content</th>
                                <th scope="col">Handle</th>
                            </tr>
                            </thead>
                            <tbody id="TABLE_MONITOR">


                            </tbody>
                        </table>


                        @include('monitor.modalOpen')


                    </div>


                    <div class="col-md-4">

                        <button type="submit" class="btn btn-primary btn-blockX">Сохранить</button>

                        <Br>
                        <Br>

                        <div class=" card cardNalogItem " style=" ">
                            <div class="card-body">
                                @include("monitor.sidebar")
                            </div>
                        </div>


                        <BR>


                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection
