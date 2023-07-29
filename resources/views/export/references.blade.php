
<table >
    <thead>
    <tr>
        <th><b>#</b> </th>
        <th style="width:35px"><b>ФИО</b></th>
        <th style="width:20px"><b>E-mail</b> </th>
        <th style="width:20px"><b>Телефон</b></th>
        <th style="width:20px"><b>Причина обращения</b></th>
        <th style="width:20px"><b>Текст обращения</b></th>
        <th style="width:20px"><b>ID подразделения</b></th>
        <th style="width:20px"><b>Статус</b></th>
        <th style="width:20px"><b>Запись создана</b></th>
        <th style="width:20px"><b>Запись обновлена</b></th>


    </tr>
    </thead>
    <tbody>

    @foreach ($references as $reference)

        <tr>
            <th>{{ $reference->id }}</th>
            <td>{{ $reference->FIO }}</td>
            <td>{{ $reference->email }}</td>
            <td>{{ $reference->telephone}}</td>
            <td>{{ $reference->prichinaObr }}</td>
            <td>{{ $reference->textObr}}</td>
            <td>{{ $reference->idPodr}}</td>
            <td>{{ $reference->status}}</td>
            <td>{{ $reference->created_at}}</td>
            <td>{{ $reference->updated_at}}</td>

        </tr>
    @endforeach
    </tbody>
</table>
