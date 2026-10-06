<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProcurementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    private function buyer(): User
    {
        return User::where('email', 'buyer@ajs.test')->firstOrFail();
    }

    private function admin(): User
    {
        return User::where('email', 'admin@ajs.test')->firstOrFail();
    }

    private function product(): Product
    {
        return Product::where('slug', 'cakalang-skipjack-tuna')->firstOrFail();
    }

    private function submit(float $quantity = 300): Order
    {
        $this->actingAs($this->buyer())->withSession(['cart' => [$this->product()->id => $quantity]])->post(route('buyer.orders.store'), ['notes' => 'Frozen supply required'])->assertSessionHasNoErrors();

        return Order::latest('id')->firstOrFail();
    }

    public function test_public_profile_and_catalog_render(): void
    {
        $this->withSession(['locale' => 'en'])->get('/')->assertOk()->assertSee('Who We Are')->assertSee('Business Traction')->assertSee('Supply');
        $this->get('/commodities')->assertOk()->assertSee('Cakalang / Skipjack Tuna');
        $this->get('/commodities/cakalang-skipjack-tuna')->assertOk()->assertSee('850.00')->assertSee('100.00');
        $this->get('/commodities/missing')->assertNotFound();
    }

    public function test_seeded_products_match_the_challenge_dummy_data(): void
    {
        $this->assertDatabaseHas('products', [
            'slug' => 'cakalang-skipjack-tuna', 'origin' => 'Muara Baru', 'grade' => 'A', 'form' => 'Frozen', 'available_quantity' => 850, 'moq' => 100,
        ]);
        $this->assertDatabaseHas('products', [
            'slug' => 'deho', 'origin' => 'Muara Baru', 'grade' => 'A', 'form' => 'Frozen', 'available_quantity' => 1200, 'moq' => 100,
        ]);
        $this->assertDatabaseHas('products', [
            'slug' => 'tuna-fillet', 'origin' => 'Partner Supply', 'grade' => 'Premium', 'form' => 'Frozen', 'available_quantity' => 350, 'moq' => 50,
        ]);
        $this->assertDatabaseHas('products', [
            'slug' => 'kerapu-grouper', 'origin' => 'Muara Baru', 'grade' => 'A', 'form' => 'Frozen', 'available_quantity' => 180, 'moq' => 25,
        ]);
    }

    public function test_demo_login_and_intended_product_destination(): void
    {
        $this->get('/buyer/products/cakalang-skipjack-tuna')->assertRedirect('/login');
        $this->post('/login', ['email' => 'buyer@ajs.test', 'password' => 'password'])->assertRedirect('/buyer/products/cakalang-skipjack-tuna');
        $this->assertAuthenticatedAs($this->buyer());
        $this->post('/logout')->assertRedirect('/');
        $this->assertGuest();
        $this->post('/login', ['email' => 'admin@ajs.test', 'password' => 'password'])->assertRedirect('/admin/dashboard');
    }

    public function test_failed_login_is_throttled(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $this->post('/login', ['email' => 'buyer@ajs.test', 'password' => 'wrong'])->assertSessionHasErrors('email');
        }
        $this->post('/login', ['email' => 'buyer@ajs.test', 'password' => 'password'])->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_complete_300_kg_demo_flow(): void
    {
        $product = $this->product();
        $this->post('/login', ['email' => 'buyer@ajs.test', 'password' => 'password'])->assertRedirect('/buyer/dashboard');
        $this->post(route('buyer.cart.store', $product), ['quantity' => 300])->assertRedirect(route('buyer.cart'));
        $this->get('/buyer/cart')->assertOk()->assertSee('300.00');
        $this->post('/buyer/orders', ['notes' => 'Please review 300 KG'])->assertSessionHasNoErrors();
        $order = Order::firstOrFail();
        $this->assertEquals('requested', $order->status);
        $this->assertEquals(300, $order->orderItems->first()->quantity);
        $this->assertEquals(850, $product->fresh()->available_quantity);
        $this->assertDatabaseCount('order_items', 1);
        $this->get(route('buyer.orders.show', $order))->assertOk()->assertSee('being reviewed');
        $this->post('/logout');
        $this->post('/login', ['email' => 'admin@ajs.test', 'password' => 'password']);
        $this->get('/admin/orders')->assertOk()->assertSee('Request #'.$order->id);
        $this->get(route('admin.orders.show', $order))->assertOk()->assertSee('300.00');
        $this->patch(route('admin.orders.update', $order), ['status' => 'confirmed'])->assertSessionHasNoErrors();
        $this->assertEquals('confirmed', $order->fresh()->status);
        $this->assertEquals(550, $product->fresh()->available_quantity);
        $this->patch(route('admin.products.update', $product), [
            'name' => $product->name,
            'description' => $product->description,
            'image' => $product->image,
            'grade' => $product->grade,
            'form' => $product->form,
            'origin' => $product->origin,
            'available_quantity' => 600,
            'moq' => $product->moq,
            'availability' => 'available',
        ])->assertRedirect(route('admin.products.index'));
        $this->assertEquals(600, $product->fresh()->available_quantity);
        $this->patch(route('admin.orders.update', $order), ['status' => 'confirmed'])->assertSessionHasErrors('supply');
        $this->assertEquals(600, $product->fresh()->available_quantity);
    }

    public function test_quantity_validation_and_cart_replacement(): void
    {
        $product = $this->product();
        $this->actingAs($this->buyer());
        foreach ([0, -1, 'abc', 100.001] as $quantity) {
            $this->post(route('buyer.cart.store', $product), compact('quantity'))->assertSessionHasErrors('quantity');
        }
        foreach ([99, 851] as $quantity) {
            $this->post(route('buyer.cart.store', $product), compact('quantity'))->assertSessionHasErrors('supply');
        }
        $this->post(route('buyer.cart.store', $product), ['quantity' => 300])->assertSessionHas('cart.'.$product->id, '300.00');
        $this->post(route('buyer.cart.store', $product), ['quantity' => 400])->assertSessionHas('cart.'.$product->id, '400.00');
        $this->delete(route('buyer.cart.destroy', $product))->assertSessionMissing('cart.'.$product->id);
        $product->update(['availability' => 'unavailable']);
        $this->post(route('buyer.cart.store', $product), ['quantity' => 300])->assertSessionHasErrors('supply');
    }

    public function test_empty_and_stale_carts_do_not_create_orders(): void
    {
        $this->actingAs($this->buyer())->post('/buyer/orders')->assertSessionHasErrors('supply');
        $product = $this->product();
        $this->withSession(['cart' => [$product->id => 300]]);
        $product->update(['available_quantity' => 200]);
        $this->post('/buyer/orders')->assertSessionHasErrors('supply')->assertSessionHas('cart');
        $this->assertDatabaseCount('orders', 0);
        $this->assertDatabaseCount('order_items', 0);
    }

    public function test_repeated_submission_does_not_duplicate_order(): void
    {
        $this->submit();
        $this->post('/buyer/orders')->assertSessionHasErrors('supply');
        $this->assertDatabaseCount('orders', 1);
    }

    public function test_rejection_preserves_stock_and_cannot_be_reversed(): void
    {
        $order = $this->submit();
        $this->actingAs($this->admin())->patch(route('admin.orders.update', $order), ['status' => 'rejected'])->assertSessionHasNoErrors();
        $this->assertEquals('rejected', $order->fresh()->status);
        $this->assertEquals(850, $this->product()->available_quantity);
        $this->patch(route('admin.orders.update', $order), ['status' => 'confirmed'])->assertSessionHasErrors('supply');
    }

    public function test_competing_requests_recheck_stock_at_confirmation(): void
    {
        $first = $this->submit(600);
        $second = $this->submit(600);
        $this->actingAs($this->admin())->patch(route('admin.orders.update', $first), ['status' => 'confirmed'])->assertSessionHasNoErrors();
        $this->patch(route('admin.orders.update', $second), ['status' => 'confirmed'])->assertSessionHasErrors('supply');
        $this->assertEquals('requested', $second->fresh()->status);
        $this->assertEquals(250, $this->product()->available_quantity);
    }

    public function test_confirmation_is_atomic_for_multiple_commodities(): void
    {
        $a = $this->product();
        $b = Product::where('slug', 'deho')->firstOrFail();
        $this->actingAs($this->buyer())->withSession(['cart' => [$a->id => 300, $b->id => 200]])->post('/buyer/orders')->assertSessionHasNoErrors();
        $order = Order::firstOrFail();
        $b->update(['available_quantity' => 100]);
        $this->actingAs($this->admin())->patch(route('admin.orders.update', $order), ['status' => 'confirmed'])->assertSessionHasErrors('supply');
        $this->assertEquals(850, $a->fresh()->available_quantity);
        $this->assertEquals('requested', $order->fresh()->status);
    }

    public function test_confirming_all_stock_marks_product_unavailable(): void
    {
        $order = $this->submit(850);
        $this->actingAs($this->admin())->patch(route('admin.orders.update', $order), ['status' => 'confirmed'])->assertSessionHasNoErrors();
        $this->assertEquals(0, $this->product()->available_quantity);
        $this->assertEquals('unavailable', $this->product()->availability);
    }

    public function test_authorization_and_order_ownership(): void
    {
        $this->get('/admin/dashboard')->assertRedirect('/login');
        $order = $this->submit();
        $this->get('/admin/dashboard')->assertForbidden();
        $this->patch(route('admin.products.update', $this->product()), ['available_quantity' => 100, 'availability' => 'available'])->assertForbidden();
        $this->patch(route('admin.orders.update', $order), ['status' => 'confirmed'])->assertForbidden();
        $other = User::factory()->create();
        $this->actingAs($other)->get(route('buyer.orders.show', $order))->assertForbidden();
        $this->actingAs($this->admin())->get('/buyer/cart')->assertForbidden();
    }

    public function test_stock_and_status_input_validation(): void
    {
        $order = $this->submit();
        $this->actingAs($this->admin())->patch(route('admin.products.update', $this->product()), [
            'name' => '',
            'description' => '',
            'grade' => '',
            'form' => '',
            'origin' => '',
            'available_quantity' => -1,
            'moq' => 0,
            'availability' => 'unknown',
        ])->assertSessionHasErrors(['name', 'description', 'grade', 'form', 'origin', 'available_quantity', 'moq', 'availability']);
        $this->patch(route('admin.orders.update', $order), ['status' => 'paid'])->assertSessionHasErrors('status');
    }

    public function test_admin_can_update_product_data_without_code_changes(): void
    {
        $product = $this->product();

        $this->actingAs($this->admin())
            ->patch(route('admin.products.update', $product), [
                'name' => 'Cakalang Premium',
                'description' => 'Updated through the admin product form.',
                'image' => 'assets/ajs/cakalang.jpg',
                'grade' => 'Premium',
                'form' => 'Frozen Whole',
                'origin' => 'Muara Baru, Jakarta',
                'available_quantity' => 700,
                'moq' => 150,
                'availability' => 'available',
            ])
            ->assertRedirect(route('admin.products.index'));

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Cakalang Premium',
            'grade' => 'Premium',
            'form' => 'Frozen Whole',
            'origin' => 'Muara Baru, Jakarta',
            'available_quantity' => 700,
            'moq' => 150,
            'availability' => 'available',
        ]);
    }

    public function test_admin_can_search_and_filter_the_stock_table(): void
    {
        $this->product()->update(['availability' => 'unavailable']);

        $this->actingAs($this->admin())
            ->get(route('admin.products.index', ['q' => 'Tuna']))
            ->assertOk()
            ->assertSee('Cakalang / Skipjack Tuna')
            ->assertSee('Tuna Fillet')
            ->assertDontSee('Kerapu / Grouper');

        $this->get(route('admin.products.index', ['availability' => 'unavailable']))
            ->assertOk()
            ->assertSee('Cakalang / Skipjack Tuna')
            ->assertDontSee('Tuna Fillet');
    }

    public function test_portal_pages_and_empty_states_render(): void
    {
        $this->actingAs($this->buyer());
        foreach (['/buyer/dashboard', '/buyer/catalog', '/buyer/stock', '/buyer/cart', '/buyer/orders'] as $path) {
            $this->get($path)->assertOk();
        }
        $this->actingAs($this->admin());
        foreach (['/admin/dashboard', '/admin/orders', '/admin/products', '/admin/products/create', '/admin/products/'.$this->product()->id.'/edit'] as $path) {
            $this->get($path)->assertOk();
        }
    }

    public function test_admin_can_create_and_delete_an_unordered_product(): void
    {
        $data = [
            'name' => 'Demo Mackerel',
            'description' => 'A test commodity created through the admin interface.',
            'image' => 'assets/ajs/deho.jpg',
            'grade' => 'A',
            'form' => 'Frozen',
            'origin' => 'Muara Baru',
            'available_quantity' => 250,
            'moq' => 25,
            'availability' => 'available',
        ];

        $this->actingAs($this->admin())
            ->post(route('admin.products.store'), $data)
            ->assertRedirect(route('admin.products.index'));

        $product = Product::where('slug', 'demo-mackerel')->firstOrFail();
        $this->assertDatabaseHas('products', ['id' => $product->id, 'name' => 'Demo Mackerel']);

        $this->delete(route('admin.products.destroy', $product))
            ->assertRedirect(route('admin.products.index'));
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    public function test_admin_cannot_delete_a_product_linked_to_an_order(): void
    {
        $order = $this->submit();

        $this->actingAs($this->admin())
            ->delete(route('admin.products.destroy', $this->product()))
            ->assertSessionHasErrors('product');

        $this->assertDatabaseHas('products', ['id' => $order->orderItems->first()->product_id]);
    }

    public function test_seeding_is_repeatable_without_resetting_stock(): void
    {
        $this->product()->update(['available_quantity' => 550]);
        $this->seed(DatabaseSeeder::class);
        $this->assertDatabaseCount('products',4);
        $this->assertDatabaseCount('users',2);
        $this->assertEquals(550,$this->product()->available_quantity);
    }

    public function test_dashboard_summarizes_cart_and_all_owned_request_statuses(): void
    {
        $buyer = $this->buyer();
        for ($i = 0; $i < 6; $i++) {
            $buyer->orders()->create(['status' => 'requested']);
        }
        $buyer->orders()->create(['status' => 'confirmed']);
        $buyer->orders()->create(['status' => 'rejected']);
        User::factory()->create()->orders()->create(['status' => 'requested']);
        $tuna = Product::where('slug', 'tuna-fillet')->firstOrFail();

        $this->actingAs($buyer)
            ->withSession(['cart' => [$this->product()->id => '300.00', $tuna->id => '50.00']])
            ->get('/buyer/dashboard')
            ->assertOk()
            ->assertViewHas('cartCount', 2)
            ->assertViewHas('cartQuantity', 350)
            ->assertViewHas('orderCounts', fn ($counts) =>
                (int) $counts->get('requested') === 6
                && (int) $counts->get('confirmed') === 1
                && (int) $counts->get('rejected') === 1)
            ->assertSee('350.00 KG requested')
            ->assertSee('Supply cart summary')
            ->assertSee('Request status summary');
    }

    public function test_visitor_can_switch_between_indonesian_and_english(): void
    {
        $this->withSession(['locale' => 'id'])
            ->get('/')
            ->assertOk()
            ->assertSee('Pasokan Komoditas Ikan Andal')
            ->assertSee('Jaringan Sourcing Kami')
            ->assertSee('Beranda');

        $this->post(route('locale.update'), ['locale' => 'en'])
            ->assertRedirect()
            ->assertSessionHas('locale', 'en');

        $this->withSession(['locale' => 'en'])
            ->get('/')
            ->assertOk()
            ->assertSee('Reliable Fish Commodity Supply')
            ->assertSee('Our Sourcing Network')
            ->assertSee('Home');
    }
}
