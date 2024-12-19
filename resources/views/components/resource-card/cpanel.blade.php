<a
    href={{ route('accessResource', $resource->id) }}
    class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100"
>
    <svg
        xmlns="http://www.w3.org/2000/svg"
        width="24"
        height="24"
        viewBox="0 0 24 24"
        fill="none"
        stroke="currentColor"
        stroke-width="2"
        stroke-linecap="round"
        stroke-linejoin="round"
        class="lucide lucide-external-link float-end"
    >
        <path d="M15 3h6v6"/>
        <path d="M10 14 21 3"/>
        <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/>
    </svg>

    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">
        cPanel Account
    </h5>
    @php
        $serverHost = parse_url($resource->resource_data['whmUrl'], PHP_URL_HOST);
    @endphp
    <p class="font-normal text-gray-700">
        Server: {{ $serverHost }}
    </p>
    <p class="font-normal text-gray-700">
        Username: {{ $resource->resource_data['cpanelUser'] }}
    </p>
</a>
