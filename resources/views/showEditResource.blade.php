<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Resource</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Resource: {{ $resource['name'] }}</h1>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">ID:</label>
                <p class="text-gray-800">{{ $resource['id'] }}</p>
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Type:</label>
                <p class="text-gray-800">{{ $resource['type'] }}</p>
            </div>
        </div>
        <div class="mt-4">
            <select name="resourceTeam" id="resourceTeam" class="w-full border rounded-md p-2">
                @foreach ($resource['teams'] as $team)
                    <option value="{{ $team }}">{{ $team }}</option>
                @endforeach
            </select>
        </div>
        <h2 class="text-xl font-bold mt-8 mb-2">Associated Teams</h2>
        <div class="border rounded-md p-4">
            <ul class="list-disc pl-5">
                @foreach ($resource['teams'] as $team)
                    <li class="flex justify-between items-center text-gray-700">
                        {{ $team }}
                        <button class="text-red-500 hover:text-red-700 ml-4">delete</button>
                    </li>
                @endforeach
            </ul>
            <span class="text-blue-500 hover:text-blue-700 font-bold px-4 rounded cursor-pointer">+ add team</span>
        </div>
        <div class="mt-8">
            <h2 class="text-xl font-bold mt-8 mb-2">Audit Log</h2>
            <table class="table-auto w-full border border-gray-300 rounded-lg shadow-md">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="px-4 py-2 text-left font-bold text-gray-500">id</th>
                        <th class="px-4 py-2 text-left font-bold text-gray-500">type</th>
                        <th class="px-4 py-2 text-left font-bold text-gray-500">team</th>
                        <th class="px-4 py-2 text-left font-bold text-gray-500">actor</th>
                        <th class="px-4 py-2 text-left font-bold text-gray-500">obj-type</th>
                        <th class="px-4 py-2 text-left font-bold text-gray-500">obj-id</th>
                        <th class="px-4 py-2 text-left font-bold text-gray-500">action</th>
                        <th class="px-4 py-2 text-left font-bold text-gray-500">description</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($resource['audit_logs'] as $log)
                        <tr>
                            <td class="px-4 py-2">{{ $log['id'] }}</td>
                            <td class="px-4 py-2">{{ $log['type'] }}</td>
                            <td class="px-4 py-2">{{ $log['team'] }}</td>
                            <td class="px-4 py-2">{{ $log['actor'] }}</td>
                            <td class="px-4 py-2">{{ $log['obj_type'] }}</td>
                            <td class="px-4 py-2">{{ $log['obj_id'] }}</td>
                            <td class="px-4 py-2">{{ $log['action'] }}</td>
                            <td class="px-4 py-2">{{ $log['description'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
