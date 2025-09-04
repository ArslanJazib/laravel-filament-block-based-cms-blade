@php
    $raw = $data ?? ($content ?? ($block->content ?? []));

    $payload = [];
    if (is_array($raw)) {
        if (isset($raw[0]) && array_key_exists('type', $raw[0])) {
            foreach ($raw as $item) {
                if (($item['type'] ?? '') === 'student-signup') {
                    $payload = $item['data'] ?? [];
                    break;
                }
            }
        } elseif (isset($raw['type']) && $raw['type'] === 'student-signup') {
            $payload = $raw['data'] ?? [];
        } else {
            $payload = $raw;
        }
    }

    $steps = $payload['steps'] ?? [];

    // map field type codes to HTML input types
    $fieldTypeMap = [
        '0' => 'text',
        '1' => 'email',
        '2' => 'password',
    ];
@endphp

<section id="signup" class="signup">
    <div class="container">
        <h2>KANDOR Registration</h2>

        {{-- Progress bar --}}
        @if(count($steps))
            <ul class="progressbar">
                @foreach($steps as $i => $step)
                    <li class="{{ $i === 0 ? 'active' : '' }}">
                        {{ $step['title'] ?? 'Step ' . ($i+1) }}
                    </li>
                @endforeach
            </ul>
        @endif

        <form id="multiStepForm" method="POST" action="">
            @csrf

            @foreach($steps as $i => $step)
                @php
                    $title = $step['title'] ?? 'Step ' . ($i+1);
                    $fields = $step['fields'] ?? [];
                @endphp

                <div class="form-step {{ $i === 0 ? 'active' : '' }}">
                    @if(count($fields))
                        @foreach($fields as $field)
                            @php
                                $name = $field['name'] ?? 'field_' . uniqid();
                                $label = $field['label'] ?? ucfirst($name);
                                $typeCode = (string)($field['type'] ?? '0');
                                $inputType = $fieldTypeMap[$typeCode] ?? 'text';
                            @endphp
                            <div class="form-group">
                                <label for="{{ $name }}">{{ $label }}</label>
                                <input
                                    type="{{ $inputType }}"
                                    name="{{ $name }}"
                                    id="{{ $name }}"
                                    {{ $inputType !== 'text' ? 'required' : '' }}
                                >
                            </div>
                        @endforeach
                    @endif

                    {{-- Navigation buttons --}}
                    <div class="btns">
                        @if($i > 0)
                            <button type="button" class="btn mind-btn prev">Back</button>
                        @endif

                        @if($i < count($steps) - 1)
                            <button type="button" class="btn mind-btn next">Next</button>
                        @else
                            <button type="submit" class="btn">Submit</button>
                        @endif
                    </div>
                </div>
            @endforeach
        </form>
    </div>
</section>
