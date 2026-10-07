<form method="POST" action="{{ $action }}" class="card space-y-7" @if($method === 'PATCH') data-confirm-action="save" @endif>
@csrf
@if($method !== 'POST') @method($method) @endif
<section>
<div class="mb-5 flex items-center gap-3"><span class="flex h-7 w-7 items-center justify-center rounded-full bg-primary text-xs font-extrabold text-primary-foreground">1</span><h2 class="font-extrabold text-deep">Product details</h2></div>
<div class="grid gap-6 md:grid-cols-2"><div class="md:col-span-2">
<label for="name" class="field-label">Product name</label>
<input class="field" id="name" name="name" type="text" maxlength="255" value="{{ old('name', $product?->name) }}" required>
</div>
<div>
<label for="description" class="field-label">Description</label>
<textarea class="field" id="description" name="description" rows="4" maxlength="2000" required>{{ old('description', $product?->description) }}</textarea>
</div>
<div>
<label for="image" class="field-label">Product image</label>
<select class="field" id="image" name="image" required>
<option value="" disabled @selected(!old('image', $product?->image))>Select an AJS image</option>
@foreach($imageOptions as $path => $label)<option value="{{ $path }}" @selected(old('image', $product?->image) === $path)>{{ $label }}</option>@endforeach
</select>
</div>
</div></section>
<section class="border-t border-border pt-7">
<div class="mb-5 flex items-center gap-3"><span class="flex h-7 w-7 items-center justify-center rounded-full bg-primary text-xs font-extrabold text-primary-foreground">2</span><h2 class="font-extrabold text-deep">Specification</h2></div>
<div class="grid gap-6 sm:grid-cols-2">
<div><label for="grade" class="field-label">Grade / specification</label><input class="field" id="grade" name="grade" type="text" maxlength="100" value="{{ old('grade', $product?->grade) }}" required></div>
<div><label for="form" class="field-label">Condition / form</label><input class="field" id="form" name="form" type="text" maxlength="100" value="{{ old('form', $product?->form) }}" required></div>
</div>
<div><label for="origin" class="field-label">Origin / location</label><input class="field" id="origin" name="origin" type="text" maxlength="255" value="{{ old('origin', $product?->origin) }}" required></div>
</section>
<section class="border-t border-border pt-7">
<div class="mb-5 flex items-center gap-3"><span class="flex h-7 w-7 items-center justify-center rounded-full bg-primary text-xs font-extrabold text-primary-foreground">3</span><h2 class="font-extrabold text-deep">Availability &amp; order rules</h2></div>
<div class="grid gap-6 sm:grid-cols-2">
<div><label for="available_quantity" class="field-label">Available quantity (KG)</label><input class="field" id="available_quantity" name="available_quantity" type="number" min="0" max="9999999999.99" step="0.01" value="{{ old('available_quantity', $product?->available_quantity) }}" required></div>
<div><label for="moq" class="field-label">Minimum order quantity (KG)</label><input class="field" id="moq" name="moq" type="number" min="0.01" max="9999999999.99" step="0.01" value="{{ old('moq', $product?->moq) }}" required></div>
</div>
<div>
<label for="availability" class="field-label">Availability</label>
<select class="field" id="availability" name="availability">
@foreach(['available', 'unavailable'] as $status)<option value="{{ $status }}" @selected(old('availability', $product?->availability ?? 'available') === $status)>{{ ucfirst($status) }}</option>@endforeach
</select>
</div>
<p class="text-sm text-muted-foreground">Buyers can only submit a Request Order when stock is available, meets the MOQ, and does not exceed the current available quantity.</p>
</section>
<div class="flex flex-wrap gap-3 border-t border-border pt-7"><button class="btn" type="submit">{{ $submitLabel }}</button><a class="btn-secondary" href="{{ route('admin.products.index') }}">Cancel</a></div>
</form>
