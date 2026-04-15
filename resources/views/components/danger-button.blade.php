<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn-gradient-danger']) }}>
    {{ $slot }}
</button>
