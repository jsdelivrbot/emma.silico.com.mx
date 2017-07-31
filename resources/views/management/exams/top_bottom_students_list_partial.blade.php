<table class="table">
    <tr>
        <th>Jerarquía</th>
        <th>Nombre</th>
        <th>Apellido</th>
        <th>Puntuación</th>
    </tr>
    <tr>
        @foreach($gradedStudents as $student)
            <tr>
                <td>{{ $student->hierachy }}</td>
                <td>{{ $student->name }}</td>
                <td>{{ $student->last_name }}</td>
                <td>{{ $student->points }}</td>
            </tr>

        @endforeach
    </tr>
</ul>
</table>
