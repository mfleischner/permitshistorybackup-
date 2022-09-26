@extends('layouts.app')

@section('content')	

    <main id="main">
        <section class="my-report px-5">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-7 col-md-6">
                        <div class="my-report-txt">
                            <h2>Notification</h2>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="table address-collaps px-5">
            <div class="container-fluid">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form action="" method="POST">
                            <input type="radio" id="on" name="alarm" value="on">
                            <label for="on">On</label><br>
                            <input type="radio" id="off" name="alarm" value="off">
                            <label for="off">Off</label><br>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>

@endsection