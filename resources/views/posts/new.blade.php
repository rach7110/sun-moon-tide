<!DOCTYPE html>
    <body>
        <form method="POST" action="/api/post">
            @csrf
            <label for="title">Post Title</label>

            <input id="title" name="title"
                type="text"
                class="@error('title') is-invalid @enderror">

            @error('title')
            <p>Error</p>
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <input type="submit">
        </form>
    </body>
</html>