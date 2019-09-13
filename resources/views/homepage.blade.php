<html>
<head>
    <link rel="stylesheet" href="assets/app.css">
    <script src="assets/app.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="h1 text-center">Available package sizes</h1>
        </div>
        @foreach($packagesAvailable as $package)
            <div class="col-sm">
                <div class="card-group">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-center">{{$package}}</h5>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="col-12">
            <form action="get-packages" method="get">
                <div class="form-group">
                    <label for="exampleInputEmail1" class="font-weight-bold">Order size</label>
                    <input type="number" class="form-control form-control-lg" name="userInput" id="user-input"
                           aria-describedby="userInput"
                           @if(isset($value))
                           value="{{$value}}"
                           @endif
                           placeholder="Enter number of widgets">
                    <small id="userInputHelp" class="form-text text-muted">Number of widgets.</small>
                    @if(isset($_error))
                        <small id="userInputHelp" class="form-text alert-danger text-muted">{{$_error}}</small>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
        @if(isset($packagesRequired) && count($packagesRequired) > 0)
            <div class="col-12">
                <h1 class="h1 text-center">Packages required
                    @if(isset($value))
                        to fit {{$value}} widgets
                    @endif
                </h1>
            </div>
            @foreach($packagesRequired as $package)
                <div class="col-sm">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-center">{{$package->packSize}} X {{$package->count}}</h5>

                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
</body>
</html>
