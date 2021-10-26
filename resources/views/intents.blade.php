<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<body onload="">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
      integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<div class="container">
    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Title</th>
            <th scope="col">Status</th>
            <th scope="col">Answers count</th>
            <th scope="col">Created At</th>
            <th scope="col">Updated At</th>
        </tr>
        </thead>
        <tbody>
        @foreach($intents as $intent)
            <tr>
                <th scope="row">{{ $intent->id }}</th>
                <th scope="row">{{ $intent->title }}</th>
                <th scope="row"> @lang("intents." . $intent->status) </th>
                <th scope="row">{{ $intent->answers_count }}</th>
                <th scope="row">{{ $intent->created_at }}</th>
                <th scope="row">{{ $intent->updated_at }}</th>
            </tr>
        @endforeach
    </table>
</div>
</body>
<script>
    const axios = require('axios').default;
</script>
</html>
