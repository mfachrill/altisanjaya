<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StockRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
            'availability' => ['nullable', 'in:available,unavailable'],
            'sort' => ['nullable', 'in:name,stock,newest'],
        ]);

        $products = Product::query()
            ->when($validated['q'] ?? null, function ($query, string $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('origin', 'like', "%{$search}%")
                        ->orWhere('grade', 'like', "%{$search}%");
                });
            })
            ->when($validated['availability'] ?? null, fn ($query, string $availability) => $query->where('availability', $availability))
            ->when(($validated['sort'] ?? 'newest') === 'name', fn ($query) => $query->orderBy('name'))
            ->when(($validated['sort'] ?? 'newest') === 'stock', fn ($query) => $query->orderBy('available_quantity'))
            ->when(($validated['sort'] ?? 'newest') === 'newest', fn ($query) => $query->latest('id'))
            ->paginate(25)
            ->withQueryString();

        return view('admin.products.index', [
            'products' => $products,
            'summary' => [
                'total' => Product::count(),
                'available' => Product::where('availability', 'available')->count(),
                'unavailable' => Product::where('availability', 'unavailable')->count(),
            ],
        ]);
    }

    public function create()
    {
        return view('admin.products.create', ['imageOptions' => $this->imageOptions()]);
    }

    public function store(StockRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['name']);

        if (Product::where('slug', $data['slug'])->exists()) {
            return back()->withErrors(['name' => 'A product with a matching URL name already exists.'])->withInput();
        }

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Product created and ready for Request Orders.');
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', ['product' => $product, 'imageOptions' => $this->imageOptions()]);
    }

    public function update(StockRequest $request, Product $product)
    {
        DB::transaction(function () use ($request, $product) {
            $locked = Product::whereKey($product->id)->lockForUpdate()->firstOrFail();
            $locked->update($request->validated());
        }, 3);

        return redirect()->route('admin.products.index')->with('success', 'Product and stock updated.');
    }

    public function destroy(Product $product)
    {
        if ($product->orderItems()->exists()) {
            return back()->withErrors(['product' => 'This product is linked to an order request and cannot be deleted. Mark it unavailable instead.']);
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted.');
    }

    private function imageOptions(): array
    {
        return [
            'assets/ajs/cakalang.jpg' => 'Cakalang / Skipjack Tuna',
            'assets/ajs/deho.jpg' => 'Deho',
            'assets/ajs/tuna.jpg' => 'Tuna Fillet',
            'assets/ajs/dori.jpg' => 'Dori Fillet',
            'assets/ajs/kerapu.jpg' => 'Kerapu / Grouper',
            'assets/ajs/kakatua.jpg' => 'Kakatua / Parrotfish',
        ];
    }
}
