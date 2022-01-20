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
                ->attach('file', storage_path('/app/public/uploads/product/1/1634550207_Przechwytywanie222.JPG'))
                ->press('btn_save_product')
                ->assertPathIs('/products')
                ->assertSee('LISTA PRODUKTÓW');
        });
    }
    /*
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
                    ->type('name', $category[0]->name)
                    ->type('description', $category[0]->description)
                    ->press('btn_save_category')
                    ->assertPathIs('/categories')
                    ->assertSee('LISTA KATEGORII');
            });
        }
     */
}
