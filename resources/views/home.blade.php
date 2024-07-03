<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{asset('css_folder/home.css')}}">
</head>
<body>
    <div class="main-container">
        <div class="main-form">
            <form action="{{route('login')}}" method="POST">
                @csrf
                <label>LOG IN</label>
                <input type="text" name="admin_username" placeholder="Enter Username"><br>
                <input type="password" name="admin_password" placeholder=" Enter Password"><br>
                <input type="submit" name="submit_btn" value="Submit">
                @if(session()->has('error'))
                    <p style="color: red">{{ session('error') }}</p>
                @endif
            </form>
        </div>
    </div>
</body>
</html>
