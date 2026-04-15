<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn-gradient-primary']) }}>
    {{ $slot }}
</button>
