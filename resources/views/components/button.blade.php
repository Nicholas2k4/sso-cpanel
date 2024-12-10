@props(['type' => 'submit'])

<button 
    type="{{ $type }}" 
    {{ $attributes->merge(['class' => "px-4 py-2 lg:h-[3.5rem] h-[2.5rem] text-xs lg:text-base rounded-md font-semibold text-white bg-[#4587F3] hover:bg-[#639AF4] focus:outline-none focus:ring-2 focus:ring-[#468CFF]"]) }}>
    {{ $slot }}
</button>
