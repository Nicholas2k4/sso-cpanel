<div class="mb-4">
    <div class="relative">
        <label for="{{ $name }}" class="text-[#4285F4] text-[12px] lg:text-sm font-medium absolute -top-3 left-2 bg-white px-1">
            {{ $label }}
        </label>
    </div>
    <input type="{{ $type }}" id="{{ $name }}" name="{{ $name }}"
        {{ $attributes->merge(['class' => 'w-full px-4 py-2 text-[#4285F4] h-[2.5rem] text-[9px] md:text-xs md:h-[3.5rem] placeholder-[#90C0E9] border border-[#90C0E9] rounded-md focus:ring-2 focus:ring-[#90C0E9] focus:outline-none focus:border-[#90C0E9]']) }} @required(true)>
</div>
