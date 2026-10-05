<button
    {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex w-full justify-center items-center px-4 py-3 bg-[#feed02] border border-transparent rounded-lg font-bold text-[#0d0c43] uppercase tracking-wide hover:bg-[#0d0c43] hover:text-[#feed02] focus:bg-[#0d0c43] focus:text-[#feed02] active:bg-[#0d0c43] active:text-[#feed02] focus:outline-none focus:ring-2 focus:ring-[#0da3d8] focus:ring-offset-2 transition ease-in-out duration-200']) }}>
    {{ $slot }}
</button>
