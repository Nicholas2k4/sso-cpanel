<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resource List</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-md p-4">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-gray-800">Resource List</h2>
                <input type="text" placeholder="Search"
                    class="w-64 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-500">
            </div>

            <table class="w-full table-auto border-collapse">
                <thead class="bg-gray-200 text-gray-700 text-left">
                    <tr>
                        <th class="px-4 py-2 border">#</th>
                        <th class="px-4 py-2 border">Name</th>
                        <th class="px-4 py-2 border">Type</th>
                        <th class="px-4 py-2 border">Edit</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="px-4 py-2 border">1</td>
                        <td class="px-4 py-2 border">Example Name</td>
                        <td class="px-4 py-2 border">Example Type</td>
                        <td class="px-4 py-2 border">
                            <button
                                class="px-4 py-2 text-sm text-white bg-blue-500 rounded hover:bg-blue-600">Edit</button>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 border">2</td>
                        <td class="px-4 py-2 border">Another Name</td>
                        <td class="px-4 py-2 border">Another Type</td>
                        <td class="px-4 py-2 border">
                            <button
                                class="px-4 py-2 text-sm text-white bg-blue-500 rounded hover:bg-blue-600">Edit</button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="flex justify-center mt-4">
                <nav>
                    <ul class="inline-flex items-center -space-x-px">
                        <li>
                            <a href="#"
                                class="px-3 py-1 text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100">Previous</a>
                        </li>
                        <li>
                            <a href="#"
                                class="px-3 py-1 text-gray-500 bg-white border border-gray-300 hover:bg-gray-100">1</a>
                        </li>
                        <li>
                            <a href="#"
                                class="px-3 py-1 text-gray-500 bg-white border border-gray-300 hover:bg-gray-100">2</a>
                        </li>
                        <li>
                            <a href="#"
                                class="px-3 py-1 text-gray-500 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-100">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</body>

</html>
