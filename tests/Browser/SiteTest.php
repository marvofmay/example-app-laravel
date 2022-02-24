<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class SiteTest extends DuskTestCase
{
    use DatabaseMigrations;
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testMainSite()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee('STRONA GŁÓWNA');
        });
    }

    public function testCategoriesSite()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/categories')
                ->assertSee('LISTA KATEGORII');
        });
    }

    public function testProductsSite()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/products')
                ->assertSee('LISTA PRODUKTÓW');
        });
    }

    public function testClickLinkAddNewProductSite()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/products')
                ->click('.add-new-product')
                ->assertPathIs('/product/create')
                ->assertSee('FORMULARZ DODAWANIA PRODUKTU');
        });
    }

    public function testClickButtonAddNewProductSite()
    {
        $category = \App\Models\Category::factory()->create();

        $this->browse(function (Browser $browser) use ($category) {
            $browser->visit('/product/create')
                ->type('name', 'lorem')
                ->type('description', 'lorem descripton')
                ->select('category_id', $category->id)
                ->attach('file', storage_path('/app/public/uploads/tests/test-photo-product.jpg'))
                ->press('btn_save_product')
                ->assertPathIs('/products')
                ->assertSee('LISTA PRODUKTÓW');
        });
    }
    
    public function testClickLinkAddNewCategorySite()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/categories')
                ->click('.add-new-category')
                ->assertPathIs('/category/create')
                ->assertSee('FORMULARZ DODAWANIA KATEGORII');
        });
    }
       
    public function testClickButtonAddNewCategorySite()
    {
        $category = \App\Models\Category::factory()->create();

        $this->browse(function (Browser $browser) use ($category) {
            $browser->visit('/category/create')
                ->type('name', $category->name)
                ->type('description', $category->description)
                ->press('btn_save_category')
                ->assertPathIs('/categories')
                ->assertSee('LISTA KATEGORII');
        });
    }
    
    public function testClickButtonEditCategorySite()
    {
        $category = \App\Models\Category::factory()->create();

        $this->browse(function (Browser $browser) use ($category) {
            $browser->visit('/category/edit/' . $category->id)
                ->assertInputValue('name', $category->name)
                ->assertInputValue('description', $category->description)
                ->assertNotChecked('deleted')
                ->assertChecked('active')
                ->assertSee('FORMULARZ EDYTOWANIA KATEGORII');
        });
    }    
    
    public function testClickButtonEditProductSite()
    {
        $photo = \App\Models\Photo::factory()->create();

        $this->browse(function (Browser $browser) use ($photo) {
            $browser->visit('/product/edit/' . $photo->product->id)
                ->assertSee('FORMULARZ EDYTOWANIA PRODUKTU')
                ->assertInputValue('name', $photo->product->name)
                ->assertInputValue('description', $photo->product->description)
                ->assertSelected('category_id', $photo->product->category->id)
                ->assertNotChecked('deleted')
                ->assertChecked('active');
        });
    }    
    
    public function testClickButtonDeleteCategoriesSite()
    {
        $category = \App\Models\Category::factory()->create();

        $this->browse(function (Browser $browser) use ($category) {
            $browser->visit('/categories')
                ->assertSee('LISTA KATEGORII')
                ->assertDataAttribute('#btn-delete-category-' . $category->id, 'category-id', $category->id)
                ->click('#btn-delete-category-' . $category->id)
                ->whenAvailable('.modal', function ($modal) use ($category) {
                    $modal->assertSee($category->name);
                });
        });
    }   
    
    public function testClickButtonDeleteProductsSite()
    {
        $photo = \App\Models\Photo::factory()->create();

        $this->browse(function (Browser $browser) use ($photo) {
            $browser->visit('/products')
                ->assertSee('LISTA PRODUKTÓW')
                ->assertDataAttribute('#btn-delete-product-' . $photo->product->id, 'product-id', $photo->product->id)
                ->click('#btn-delete-product-' . $photo->product->id)
                ->whenAvailable('.modal', function ($modal) use ($photo) {
                    $modal->assertSee($photo->product->name);
                });
        });
    }      
    
}
