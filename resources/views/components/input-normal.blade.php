
@props(['id', 'name', 'type' => 'text', 'titulo', 'alert' => null])


<div class="form-group col-12 col-md-6 col-lg-6">
    <label for="{{ $id }}">{{ $titulo }}</label>
    <div class="form-input">
        <input type="{{ $type }}" 
               class="form-control @error($name) is-invalid @enderror"
               name="{{ $name }}" 
               id="{{ $id }}" 
               value="{{ old($name) }}">
        
        @if($alert)
            <small class="form-text text-muted">{{ $alert }}</small>
        @endif

        @error($name)
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
</div>
