<div class="form-group">
    <label for="city">Город</label>   
    <select name="city" id="city" class="form-control" required>
        <option value="{{ old('city') ?? @$regionalCenter->city ?? '' }}">{{ old('city') ?? @$regionalCenter->city ?? '' }}</option>
        @foreach($cities AS $city)
            <option value="{{ $city }}">{{ $city }}</option>
        @endforeach
    </select>
    @error('city')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="form-group">
    <label for="region">Регион</label>    
    <select name="region" id="region" class="form-control" required>
        <option value="{{ old('region') ?? @$regionalCenter->region ?? '' }}">{{ old('region') ?? @$regionalCenter->region ?? '' }}</option>
        @foreach($regions AS $region)
            <option value="{{ $region }}">{{ $region }}</option>
        @endforeach
    </select>
    @error('region')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>