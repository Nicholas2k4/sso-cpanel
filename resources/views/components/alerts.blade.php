@if (Session::has('success'))
    <script>
        Swal.fire({
            title: "Success!",
            text: "{{ Session::get('success') }}",
            icon: "success"
        });
    </script>
@endif
@if (Session::has('error'))
    <script>
        Swal.fire({
            title: "Oops!",
            text: "{{ Session::get('error') }}",
            icon: "error"
        });
    </script>
@endif
@if ($errors->any())
    <script>
        Swal.fire({
            title: "Oops!",
            text: "{{ $errors->first() }}",
            icon: "error"
        });
    </script>
@endif
