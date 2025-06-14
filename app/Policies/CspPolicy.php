<?php

namespace App\Policies;

use Spatie\Csp\Directive;
use Spatie\Csp\Policies\Basic;

class CspPolicy
{
    // public function configure()
    // {
    //     parent::configure();

    //     $this
    //         ->addDirective(Directive::BASE, "'self'")
    //         ->addDirective(Directive::CONNECT, ["'self'", "blob:"])
    //         ->addDirective(Directive::DEFAULT, ["'self'", "https://fonts.gstatic.com/"])
    //         ->addDirective(Directive::IMG, [
    //             'https://apiminio-staging.kalbe.co.id',
    //             'https://apiminio.kalbe.co.id',
    //             'https://apistorage.kalbe.site',
    //         ])
    //         ->addDirective(Directive::IMG, 'data:')
    //         ->addDirective(Directive::MEDIA, "'self'")
    //         ->addDirective(Directive::OBJECT, "'none'")
    //         ->addDirective(Directive::STYLE, ["'self'", "'nonce-" . csp_nonce() . "'"])
    //         ->addDirective(Directive::SCRIPT, ["'nonce-" . csp_nonce() . "'"])
    //         ->removeDirective(Directive::SCRIPT, "'self'")
    //         ->addDirective(Directive::FORM_ACTION, "'self'")
    //         ->addDirective(Directive::FRAME_ANCESTORS, "'none'");
    // }

    public function configure()
    {
        parent::configure();

        $this
            ->addDirective(Directive::BASE, "'self'")
            ->addDirective(Directive::CONNECT, ["'self'", "blob:"])
            ->addDirective(Directive::DEFAULT, ["'self'", "https://fonts.gstatic.com/"])
            ->addDirective(Directive::IMG, array_merge([
                "'self'",
                "https://apiminio-staging.kalbe.co.id",
                "https://apiminio.kalbe.co.id",
                "https://apistorage.kalbe.site",
                "data:",
            ]))
            ->addDirective(Directive::MEDIA, "'self'")
            ->addDirective(Directive::OBJECT, "'none'")
            ->addDirective(Directive::STYLE, ["'self'", "'nonce-" . csp_nonce() . "'"])
            ->addDirective(Directive::SCRIPT, ["'self'", "'nonce-" . csp_nonce() . "'"])
            ->addDirective(Directive::FORM_ACTION, "'self'")
            ->addDirective(Directive::FRAME_ANCESTORS, "'none'");

        // Jika tetap ingin menghapus 'self' dari SCRIPT, pastikan itu bukan satu-satunya sumber yang diizinkan
        // ->removeDirective(Directive::SCRIPT, "'self'");
    }
}
