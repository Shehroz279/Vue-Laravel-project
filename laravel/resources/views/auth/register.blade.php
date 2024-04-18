<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">


    <style>
        .form{
            display: flex;
            justify-content: center;
            align-items: center;
            height: 500px;
        }
        td{
            padding: 8px;
        }
    </style>
    <title>Custom Project</title>
  </head>
  <body>

    <form action="register" method="post">
    <table class="form">
        <!-- @if(session()->has('success'))
        <span class="alert alert-success">{{session()->get('success')}}</span>
        @endif
        @if(session()->has('success'))
        <span class="alert alert-danger">{{session()->get('error')}}</span>
        @endif -->
        @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
        <tr>
            <td class="text-center" colspan="2"><h3>Registration</h3></td>
        </tr>
        @csrf()
        <tr>
            <td>
                <label for="">Full Name</label>
            </td>
            <td>
                <input type="text" name="name"  value="{{old('name')}}" class="form-control col-auto" id="">
            </td>
        </tr>
        @if($errors->has('name'))
        <tr>
            <td>
                <label class="text-danger">{{ $errors->first('name') }}</label>
            </td>
        </tr>
  @endif
     
        <tr>
            <td>
                <label for="">Email</label>
            </td>
            <td>
                <input type="email" name="email" value="{{old('email')}}" class="form-control col-auto" id="">
            </td>

        </tr>
        @if($errors->has('email'))
        <tr>
            <td>
                <label class="text-danger">{{ $errors->first('email') }}</label>
            </td>
        </tr>
  @endif
        <tr>
        <td>
                <label for="">Password</label>
            </td>
            <td>
                <input type="password" name="password" value="{{old('password')}}" class="form-control col-auto" id="">
            </td>
        </tr>
        @if($errors->has('password'))
        <tr>
            <td>
                <label class="text-danger">{{ $errors->first('password') }}</label>
            </td>
        </tr>
  @endif
      
        <tr>
            <td><a href="login" class="text-primary">Already Registered?</a></td>
        </tr>
        <tr>
            <td colspan="2" class="text-center"><button type="submit" class="btn btn-primary">submit</button></td>
        </tr>
    </table>
    </form>
    
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>