<?php

namespace BlackBits\LaravelSeoRewrite\Tests;

use BlackBits\LaravelSeoRewrite\Events\CreateSeoRewriteEvent;
use BlackBits\LaravelSeoRewrite\Events\DeleteSeoRewriteEvent;
use BlackBits\LaravelSeoRewrite\Models\SeoRewrite;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RewriteTest extends TestCase
{
    public function test_if_we_can_access_the_welcome_page()
    {
        $response = $this->get('/');

        $response->assertStatus(200)->assertSee('Homepage');
    }

    public function test_if_a_valid_source_redirects_to_the_correct_destination_with_the_correct_code()
    {
        $seoRewrite = factory(SeoRewrite::class)->create();

        $response = $this->get($seoRewrite->source);
        $response->assertRedirect($seoRewrite->destination)->assertStatus($seoRewrite->type);
    }

    public function test_if_we_can_access_a_standard_web_route_even_though_we_have_other_rewrites_setup()
    {
        factory(SeoRewrite::class, 10)->create();

        $response = $this->get(route('hello.world'));
        $response->assertSee('OK')->assertStatus(200);
    }

    public function test_if_a_seo_rewrite_can_be_created_by_dispatching_the_event()
    {
        factory(SeoRewrite::class, 10)->create();
        $seoRewrite = factory(SeoRewrite::class)->make();

        CreateSeoRewriteEvent::dispatch($seoRewrite->source, $seoRewrite->destination, $seoRewrite->type);

        $this->assertDatabaseHas('seo_rewrites', ['source' => $seoRewrite->source, 'destination' => $seoRewrite->destination, 'type' => $seoRewrite->type]);
        $this->assertEquals(11, SeoRewrite::count());
    }

    public function test_if_a_seo_rewrite_can_be_deleted_by_dispatching_the_event()
    {
        factory(SeoRewrite::class, 10)->create();
        $seoRewrite = factory(SeoRewrite::class)->create();

        DeleteSeoRewriteEvent::dispatch($seoRewrite->source);

        $this->assertDatabaseMissing('seo_rewrites', ['source' => $seoRewrite->source, 'destination' => $seoRewrite->destination, 'type' => $seoRewrite->type]);
        $this->assertEquals(10, SeoRewrite::count());
    }

    public function test_if_a_seo_rewrite_created_without_type_will_have_301_as_default()
    {
        $seoRewrite = factory(SeoRewrite::class)->make([
            'type' => 301,
        ]);

        CreateSeoRewriteEvent::dispatch($seoRewrite->source, $seoRewrite->destination);

        $this->assertDatabaseHas('seo_rewrites', ['source' => $seoRewrite->source, 'destination' => $seoRewrite->destination, 'type' => $seoRewrite->type]);
    }

    public function test_if_a_seo_rewrite_with_the_same_source_and_destination_cannot_be_created_twice()
    {
        $seoRewrite = factory(SeoRewrite::class)->make();

        try {
            CreateSeoRewriteEvent::dispatch($seoRewrite->source, $seoRewrite->destination);
            CreateSeoRewriteEvent::dispatch($seoRewrite->source, $seoRewrite->destination);
        } catch (QueryException $e) {
            $this->assertTrue(is_a($e, QueryException::class));
            $catched = true;
        }

        $this->assertTrue($catched);
    }

    public function test_if_a_seo_rewrite_with_the_same_source_and_differnet_destination_cannot_be_created_twice()
    {
        $seoRewrite1 = factory(SeoRewrite::class)->make([
            'source' => '/test-me'
        ]);

        $seoRewrite2 = factory(SeoRewrite::class)->make([
            'source' => '/test-me'
        ]);

        try {
            CreateSeoRewriteEvent::dispatch($seoRewrite1->source, $seoRewrite1->destination, $seoRewrite1->type);
            CreateSeoRewriteEvent::dispatch($seoRewrite2->source, $seoRewrite2->destination, $seoRewrite2->type);
        } catch (QueryException $e) {
            $this->assertTrue(is_a($e, QueryException::class));
            $catched = true;
        }

        $this->assertTrue($catched);
    }

    public function test_if_the_creation_by_event_of_a_loop_will_throw_the_specified_exception()
    {
        $seoRewrite1 = factory(SeoRewrite::class)->make([
            'source' => '/test-a',
            'destination' => '/test-b'
        ]);

        $seoRewrite2 = factory(SeoRewrite::class)->make([
            'source' => '/test-b',
            'destination' => '/test-c'
        ]);

        $seoRewrite3 = factory(SeoRewrite::class)->make([
            'source' => '/test-c',
            'destination' => '/test-a'
        ]);

        try {
            CreateSeoRewriteEvent::dispatch($seoRewrite1->source, $seoRewrite1->destination, $seoRewrite1->type);
            CreateSeoRewriteEvent::dispatch($seoRewrite2->source, $seoRewrite2->destination, $seoRewrite2->type);
            CreateSeoRewriteEvent::dispatch($seoRewrite3->source, $seoRewrite3->destination, $seoRewrite3->type);
        } catch (\Exception $e) {
            $this->assertEquals('SeoRewrite Loop Detected.', $e->getMessage());
            $catched = true;
        }

        $this->assertTrue($catched);

        $this->assertDatabaseMissing('seo_rewrites', ['source' => $seoRewrite3->source, 'destination' => $seoRewrite3->destination, 'type' => $seoRewrite3->type]);
    }

    public function test_if_the_creation_by_model_of_a_loop_will_throw_the_specified_exception()
    {
        $seoRewrite1 = factory(SeoRewrite::class)->make([
            'source' => '/test-a',
            'destination' => '/test-b'
        ]);

        $seoRewrite2 = factory(SeoRewrite::class)->make([
            'source' => '/test-b',
            'destination' => '/test-c'
        ]);

        $seoRewrite3 = factory(SeoRewrite::class)->make([
            'source' => '/test-c',
            'destination' => '/test-a'
        ]);

        try {
            $seoRewrite1->save();
            $seoRewrite2->save();
            $seoRewrite3->save();
        } catch (\Exception $e) {
            $this->assertEquals('SeoRewrite Loop Detected.', $e->getMessage());
            $catched = true;
        }

        $this->assertTrue($catched);

        $this->assertDatabaseMissing('seo_rewrites', ['source' => $seoRewrite3->source, 'destination' => $seoRewrite3->destination, 'type' => $seoRewrite3->type]);
    }

    public function test_if_an_update_by_model_to_a_loop_will_throw_the_specified_exception()
    {
        $seoRewrite1 = factory(SeoRewrite::class)->create([
            'source' => '/test-a',
            'destination' => '/test-b'
        ]);

        $seoRewrite2 = factory(SeoRewrite::class)->create([
            'source' => '/test-b',
            'destination' => '/test-c'
        ]);

        $seoRewrite3 = factory(SeoRewrite::class)->create([
            'source' => '/test-c',
            'destination' => '/test-d'
        ]);

        try {
            $seoRewrite3->update([
                'destination' => '/test-a'
            ]);
        } catch (\Exception $e) {
            $this->assertEquals('SeoRewrite Loop Detected.', $e->getMessage());
            $catched = true;
        }

        $this->assertTrue($catched);

        $this->assertDatabaseMissing('seo_rewrites', ['source' => $seoRewrite3->source, 'destination' => $seoRewrite3->destination, 'type' => $seoRewrite3->type]);
    }

    public function tearDown()
    {
        parent::tearDown();
    }
}
