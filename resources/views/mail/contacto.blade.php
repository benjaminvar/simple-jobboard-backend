@component('mail::message')
# Hola un usuario quiere contactarte
<table>
    <tr>
        <th style="text-align:left">Nombre</th>
        <td>{{$datos["nombre_completo"]}}</td>
    </tr>
    <tr>
        <th style="text-align:left">Email</th>
        <td>{{$datos["email"]}}</td>
    </tr>
    <tr>
        <th style="text-align:left">Teléfono</th>
        <td>{{$datos["telefono"]}}</td>
    </tr>
    <tr>
        <th style="text-align:left">Mensaje</th>
        <td>{{$datos["mensaje"]}}</td>
    </tr>
</table>
@endcomponent
