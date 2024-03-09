<!DOCTYPE html>
<html>
<head>
    <title>Print Data</title>
</head>
<body>
    <table border="1">
        <thead>
            <tr>
                <th>Name</th>
                <th>Mobile number</th>
                <th>Email</th>
                <th>Subscription</th>
                <th>Registration</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tableData as $cell)
                <tr>
                        <td>{{ $cell->name }}</td>
                        <td>{{ $cell->mobile_number }}</td>
                        <td>{{ $cell->email }}</td>
                        <td>
                            @if(isset($cell->subscription) == false)
                            <p>NA</p>
                            @elseif(isset($cell->subscription) && $cell->subscription > 0)
                            <p>Yes</p>
                            @else
                            <p>No</p>
                            @endif
                        </td>
                        <td>{{ $cell->updated_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
