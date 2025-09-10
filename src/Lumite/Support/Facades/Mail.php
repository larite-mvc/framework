<?php

namespace Lumite\Support\Facades;

use Closure;
use Lumite\Support\Mailer;

/**
 * @method static Mailer subject($subject);
 * @method static Mailer send($view, $data, Closure $closure);
 * @method static Mailer to($to, string $to_name = '');
 * @method static Mailer from($from, string $from_name = '');
 * @method static Mailer attachment($attachment, string $attachment_name = '');
 *
 * @see \Lumite\Support\Routing\Router
 */
class Mail extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'mailer';
    }
}