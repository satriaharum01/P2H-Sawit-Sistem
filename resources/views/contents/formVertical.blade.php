@extends('layouts.app')

@section('title', $sectionTitle)

@section('content')

    <div class="row mx-0">
        <!-- Striped Rows -->
        <div class="card">

            <div class="card-header">
                <h5 class="card-title mt-2">{{ $formTitle }}</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ $formRoute }}">
                    @csrf

                    @foreach ($fields as $field => $key)
                        <div class="mb-3">
                            @error($field)
                                <div class="invalid-feedback float-end w-auto d-block">{{ $message }}</div>
                            @enderror
                            <label class="form-label">{{ $key['label'] }}</label>
                            {{-- TEXTAREA --}}
                            @if ($key['type'] === 'boolean')
                                <div class="form-check form-switch mt-2">
                                    {{-- Hidden input agar jika tidak dicentang, value '0' tetap terkirim ke server --}}
                                    <input type="hidden" name="{{ $field }}" value="0">

                                    <input type="checkbox" name="{{ $field }}" value="1"
                                        class="form-check-input" id="switch_{{ $field }}"
                                        {{ old($field, $key['value'] ?? '') == '1' ? 'checked' : '' }}>

                                    <label class="form-check-label" for="switch_{{ $field }}">
                                        {{ $key['label_switch'] ?? 'True' }}
                                    </label>
                                </div>
                            @elseif ($key['type'] === 'textarea')
                                <textarea name="{{ $field }}" class="form-control" placeholder="{{ $key['placeholder'] ?? '' }}"
                                    {{ !empty($key['required']) ? 'required' : '' }}>{{ old($field) }}</textarea>

                                {{-- SELECT --}}
                            @elseif($key['type'] === 'select')
                                <select name="{{ $field }}" class="form-control"
                                    {{ !empty($key['required']) ? 'required' : '' }}>
                                    <option value="">-- Select {{ $key['label'] }} --</option>

                                    @foreach ($key['options'] as $value => $label)
                                        <option value="{{ $value }}"
                                            {{ old($field, $key['value'] ?? '') == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>

                                {{-- DEFAULT INPUT --}}
                            @else
                                <input type="{{ $key['type'] }}" name="{{ $field }}" class="form-control"
                                    value="{{ !empty($key['value']) ? $key['value'] : old($field) }}"
                                    placeholder="{{ $key['placeholder'] ?? '' }}"
                                    {{ !empty($key['required']) ? 'required' : '' }} />
                            @endif
                        </div>
                    @endforeach

                    <button type="submit" class="btn btn-primary">Send</button>
                </form>
            </div>
        </div>
        <!--/ Striped Rows -->
    </div>

@endsection
