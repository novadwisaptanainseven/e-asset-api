<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <style>
    div {
      text-align: center;
    }
  </style>
</head>
<body>
  {{-- {!! QrCode::size(250)->generate('ItSolutionStuff.com'); !!} --}}
  {{-- <div>
    {!! QrCode::size(250)->generate('ItSolutionStuff.com'); !!}
  </div> --}}
  <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(250)->generate('Make me into an QrCode!')) !!} ">
</body>
</html>