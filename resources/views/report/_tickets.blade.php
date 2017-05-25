<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<tr>
    <td align="center" width="50" colspan="2" style="border: 1px solid #000000;">
        <b>Отчет о выполнении заявок</b>
    </td>
</tr>
@forelse($grouped as $fio => $list)

    <tr>
        <td width="50" colspan="2" style="border: 1px solid #000000;"><b>{{ $fio }}</b></td>
    </tr>
    @foreach($list as $workType => $tickets)
        <tr>
            <td style="border: 1px solid #000000;">{{ $workType }}</td>
            <td style="border: 1px solid #000000;">{{ count($tickets) }}</td>
        </tr>
    @endforeach
@empty
    <tr>
        <td width="50" colspan="2" style="border: 1px solid #000000;">
            За данный период заявки не выполнялись
        </td>
    </tr>
@endforelse
</body>
</html>