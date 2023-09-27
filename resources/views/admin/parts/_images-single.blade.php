<div class="form-group">
    <label for="image">Изображение</label>
    <div class="custom-file">
        <input
                type="file"
                class="custom-file-input"                
                name="image"                
                id="image"
                accept="image/*"
                onchange="document.getElementById('img-preview').src = window.URL.createObjectURL(this.files[0]); document.getElementById('img-preview').classList.remove('d-none');"
        />
        <label for="image" class="custom-file-label">Выберите изображения</label>
    </div>
</div>
<div class="row mt-2 p-3">
    @if (isset($image))
        <img src="{{ asset($image?->getUrl()) }}" id="img-preview" class="img-fluid img-thumbnail" alt="img">
    @else
        <img src="" id="img-preview" class="img-fluid img-thumbnail d-none" alt="img">
    @endif    
</div>