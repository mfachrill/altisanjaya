@props(['eyebrow'=>'Fish Commodity Trading & Supply','title','description'=>null])
<div class="mb-10">
<p class="section-kicker mb-4">{{ $eyebrow }}</p>
<h1 class="portal-title text-deep">{{ $title }}</h1>
<div class="section-rule">
</div>
@if($description)<p class="section-copy text-muted-foreground">{{ $description }}</p>
@endif</div>
