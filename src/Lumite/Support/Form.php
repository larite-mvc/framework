<?php

namespace Lumite\Support;

use Lumite\Support\Traits\Csrf\CsrfToken;

class Form
{
    use CsrfToken;

    /**
     * @param $type
     * @return string
     */
    public static function method($type): string
    {
        return match (strtoupper($type)) {
            'DELETE' => 'DELETE',
            'PATCH'  => 'PATCH',
            'PUT'    => 'PUT',
            default  => 'PUT',
        };
    }
}
