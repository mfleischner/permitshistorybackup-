@extends('layouts.app')
@section('content')
    <main id="main">
        <section class="Anderson-Lane px-5">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-7">
                        <div class="Anderson-Lane-txt">
                            <h2>Bulk Address Upload</h2>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <span id="successStatusMsg" style="text-align: center;">
            @if (Session::has('success'))
                <div class="alert alert-success">
                    {{ Session::get('success') }}
                </div>
            @endif 

            @if (isset($status) && $status!= null)
                <div class="text-danger">
                    {{$status??''}}
                </div>
            @endif

            @if(Session::has('fail'))
            <div class="alert alert-danger">
                {{Session::get('fail')}}
            </div>
        @endif

            @if (Session::has('faill'))
                <div class="alert alert-danger">
                    {{ Session::get('faill') }}
                </div>
            @endif
        </span>

        <section class="table table-open-permits6 px-5">
            <form action="{{ url('/dashboard/permitupload') }}" method="POST" enctype='multipart/form-data'>
                @csrf
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Filename</label>
                                    <input name="upload_file" id="upload_file" required type="file">
                                    <span style="font-size: 12px;">Allowed formats: XLSX.  <a href="{{ url('/dashboard/permitSampleDownload/') }}" >sample file</a> </span>
                                    
                                    <span id="errorMSG1 text-danger"></span>
                            </div>
                        </div>                        
                    </div>        
                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-effect upload-btn">Update</button>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div> 
        </section>
    </main>

@endsection
