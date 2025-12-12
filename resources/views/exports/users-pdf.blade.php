<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .filter-info {
            background: #f5f5f5;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .filter-info p {
            margin: 3px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th {
            background-color: #4f46e5;
            color: white;
            padding: 10px;
            text-align: left;
        }
        table td {
            padding: 8px 10px;
            border-bottom: 1px solid #ddd;
        }
        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        .badge {
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }
        .badge-admin {
            background-color: #fee2e2;
            color: #dc2626;
        }
        .badge-user {
            background-color: #dbeafe;
            color: #1d4ed8;
        }
        .total-info {
            margin-top: 20px;
            padding: 10px;
            background: #e8f4fd;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $title }}</h1>
        <p>Dibuat pada: {{ date('d F Y H:i:s') }}</p>
    </div>

    <div class="filter-info">
        <p><strong>Filter yang diterapkan:</strong></p>
        <p>Role: {{ $role == 'all' ? 'Semua' : ucfirst($role) }}</p>
        @if($startDate && $endDate)
        <p>Periode: {{ date('d F Y', strtotime($startDate)) }} - {{ date('d F Y', strtotime($endDate)) }}</p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Tanggal Bergabung</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $index => $user)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    <span class="badge badge-{{ $user->role }}">
                        {{ ucfirst($user->role) }}
                    </span>
                </td>
                <td>{{ $user->created_at->format('d F Y') }}</td>
                <td>Aktif</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total-info">
        <p><strong>Total Data: {{ $users->count() }} user</strong></p>
        <p>Admin: {{ $users->where('role', 'admin')->count() }} user</p>
        <p>User: {{ $users->where('role', 'user')->count() }} user</p>
    </div>

    <div class="footer">
        <p>Dokumen ini dibuat secara otomatis oleh Sistem Manajemen User</p>
    </div>
</body>
</html>