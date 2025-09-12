<?php
declare(strict_types=1);


use App\Providers\RouteServiceProvider;
use Lumite\Support\Auth;
use Lumite\Support\Collection\Collection;
use Lumite\Support\Container\App;
use Lumite\Support\Errors;
use Lumite\Support\Facades\Route;
use Lumite\Support\LoadView;
use Lumite\Support\ModelFactory;
use Lumite\Support\Path;
use Lumite\Support\Request;
use Lumite\Support\Response;
use Lumite\Support\NotFound;
use Lumite\Support\Redirect;
use Lumite\Support\Session;
use Lumite\Support\Form;
use Lumite\Support\Str;
use Lumite\Support\Facades\Validator;
use Symfony\Component\VarDumper\VarDumper;


if(!function_exists('dd')) {

    /**
     * @param ...$vars
     * @return void
     */
    function dd(...$vars)
    {
        foreach ($vars as $v) {
            VarDumper::dump($v);
        }

        exit(1);
    }

}

if(!function_exists('dump')) {
    /**
     * @param ...$vars
     * @return void
     */
    function dump(...$vars)
    {
        foreach ($vars as $v) {
            VarDumper::dump($v);
        }
    }

}

if(!function_exists('asset')) {

    /**
     * @param $path
     * @return string
     */
    function asset($path)
    {
        return Path::asset($path);
    }

}

if(!function_exists('url')) {

    /**
     * @param string|null $path
     * @return string
     */
    function url($path)
    {
        return Path::url($path);
    }
}

if(!function_exists('path')) {

    /**
     * @return string
     */
    function path(): string
    {
        return Path::path();
    }

}

if(!function_exists('full_path')) {
    function full_path()
    {
        return Path::fullPath();
    }
}

if(!function_exists('base_path')) {
    function base_path(): string
    {
        return Path::basePath();
    }
}

if(!function_exists('public_path')) {
    function public_path(?string $path = null): string
    {
        return Path::publicPath($path);
    }
}

if(!function_exists('view')) {

    /**
     * @param $view
     * @param array $data
     * @param bool $loadHtml
     * @return mixed|string
     */
    function view($view, $datas = [], bool $loadHtml = false): mixed
    {
        return LoadView::View($view, $datas, $loadHtml);
    }
}

if(!function_exists('redirect')) {

    /**
     * @param null $url
     * @return \Lumite\Support\Redirect
     */
    function redirect($url = null)
    {
        if (!is_null($url)) {
            $url = ltrim($url, '/');
            header('Location: ' . url('/') . $url);
            exit;
        }

        return new Redirect();
    }
}

if(!function_exists('response')) {

    /**
     * @param null $url
     * @return Response
     */
    function response(): Response
    {
        return new Response();
    }
}

if(!function_exists('getChildTableAndStatement')) {

    /**
     * @param $statement
     * @return array
     */
    function getChildTableAndStatement($statement)
    {
        $res = [];
        if (strpos($statement, "|") == true) {
            $array = explode('|', $statement);
            $child_table = $array[1] . ".";
            $statement = str_replace("|$array[1]|", '', $statement);
        } else {
            $child_table = '';
        }
        $res['statement'] = $statement;
        $res['child_table'] = $child_table;
        return $res;
    }
}

if(!function_exists('model')) {

    /**
     * @param $model
     * @return mixed
     */
    function model($model)
    {
        return ModelFactory::make($model);
    }
}

if(!function_exists('load')) {

    /**
     * @param $model
     * @return mixed
     */
    function load($model)
    {
        $base = __DIR__ . '/../';
        require_once($base . "app/models/" . $model . ".php");
        $model_array = explode('/', $model);
        $class = end($model_array);

        return new $class();
    }
}

if(!function_exists('toObject')) {

    /**
     * @param $array
     * @return mixed
     */
    function toObject($array){
        return json_decode(json_encode($array));
    }
}

if(!function_exists('toArray')) {

    /**
     * @param $object
     * @return mixed
     */
    function toArray($object){
        return json_decode(json_encode($object), true);
    }
}

if(!function_exists('include_html')) {

    /**
     * @param $path
     * @return void
     * @throws Exception
     */
    function include_html($path)
    {
        Path::includeHtml($path);
    }
}

if(!function_exists('withErrors')) {

    /**
     * @param $field
     * @return bool
     */
    function withErrors($field): bool
    {
        return Errors::withErrors($field);
    }
}

if(!function_exists('errors')) {
    /**
     * @param $key
     * @return mixed
     */
    function errors($key): mixed
    {
        return Errors::errors($key);
    }
}


if(!function_exists('has_error')) {
    function has_error($key): bool
    {
        return Errors::has_error($key);
    }
}

if(!function_exists('validation')) {

    /**
     * @param $field
     * @return bool
     */
    function validation($field): bool
    {
        return Validator::validation($field);
    }
}

if(!function_exists('encrypt')) {

    /**
     * @param $string
     * @return string
     */
    function encrypt($string){
        $base_encryption_array = salt();
        $string = (string)$string;
        $length = strlen($string);
        $hash = '';
        for ($i = 0; $i < $length; $i++) {
            if (isset($string[$i])) {
                $hash .= $base_encryption_array[$string[$i]];
            }
        }
        return $hash;
    }
}

if(!function_exists('decrypt')) {

    /**
     * @param $hash
     * @return string
     */
    function decrypt($hash){
        $base_encryption_array = salt();
        /* this makes keys as values and values as keys */
        $base_encryption_array = array_flip($base_encryption_array);

        $hash = (string)$hash;
        $length = strlen($hash);
        $string = '';

        for ($i = 0; $i < $length; $i = $i + 3) {
            if (isset($hash[$i]) && isset($hash[$i + 1]) && isset($hash[$i + 2]) && isset($base_encryption_array[$hash[$i] . $hash[$i + 1] . $hash[$i + 2]])) {
                $string .= $base_encryption_array[$hash[$i] . $hash[$i + 1] . $hash[$i + 2]];
            }
        }
        return $string;
    }
}

if(!function_exists('salt')) {

    /**
     * @return array
     */
    function salt()
    {
        return array(
            '0' => 'b76',
            '1' => 'd75',
            '2' => 'f74',
            '3' => 'h73',
            '4' => 'j72',
            '5' => 'l71',
            '6' => 'n70',
            '7' => 'p69',
            '8' => 'r68',
            '9' => 't67',
            'a' => 'v66',
            'b' => 'x65',
            'c' => 'z64',
            'd' => 'a63',
            'e' => 'd62',
            'f' => 'e61',
            'g' => 'h60',
            'h' => 'i59',
            'i' => 'j58',
            'j' => 'g57',
            'k' => 'f56',
            'l' => 'c55',
            'm' => 'b54',
            'n' => 'y53',
            'o' => 'w52',
            'p' => 'u51',
            'q' => 's50',
            'r' => 'q49',
            's' => 'o48',
            't' => 'm47',
            'u' => 'k46',
            'v' => 'i45',
            'w' => 'g44',
            'x' => 'e43',
            'y' => 'c42',
            'z' => 'a41',
            'A' => 'lt2',
            'B' => '1qw',
            'C' => '4op',
            'D' => '7bh',
            'E' => '4ld',
            'F' => '6nk',
            'G' => 'v7n',
            'H' => 'ds0',
            'I' => '3cg',
            'J' => '45u',
            'K' => 'y6z',
            'L' => 'xz5',
            'M' => 'fdT',
            'N' => 'po7',
            'O' => 'njr',
            'P' => '3g7',
            'Q' => 'az2',
            'R' => 'if5',
            'S' => 'r45',
            'T' => 'bn8',
            'U' => 'nu3',
            'V' => '12s',
            'W' => 'df1',
            'X' => '29m',
            'Y' => 'vxc',
            'Z' => 'h7c',
        );
    }
}

if(!function_exists('env')) {

    /**
     * @param $env_var
     * @param string $key
     * @return array|false|string
     */
    function env($key, $default = null)
    {
        $value = getenv($key);

        if ($value === false) {
            return value($default);
        }

        switch (strtolower($value)) {
            case 'true':
            case '(true)':
                return true;
            case 'false':
            case '(false)':
                return false;
            case 'empty':
            case '(empty)':
                return '';
            case 'null':
            case '(null)':
                return;
        }

        if (($valueLength = strlen($value)) > 1 && $value[0] === '"' && $value[$valueLength - 1] === '"') {
            return substr($value, 1, -1);
        }

        return $value;
    }

    function value($value)
    {
        return $value instanceof Closure ? $value() : $value;
    }
}

if(!function_exists('from')) {
    /**
     * @param $email
     * @return array
     */
    function from($email){
        $data = [];
        $data['from'] = $email;
        return $data;
    }
}

if(!function_exists('to')) {

    /**
     * @param $email
     * @return array
     */
    function to($email){
        $data = [];
        $data['to'] = $email;
        return $data;
    }
}

if(!function_exists('subject')) {

    /**
     * @param $subject
     * @return array
     */
    function subject($subject){
        $data = [];
        $data['subject'] = $subject;
        return $data;
    }
}

if(!function_exists('body')) {
    /**
     * @param $body
     * @return array
     */
    function body($body){
        $data = [];
        $data['body'] = $body;
        return $data;
    }
}

if(!function_exists('user')) {
    function user(){
        return Auth::user();
    }
}

if(!function_exists('auth')) {
    function auth(){
        return new Auth();
    }
}

if(!function_exists('bcrypt')) {
    function bcrypt($password)
    {
        return Auth::Hash($password);
    }
}

if (!function_exists('session')) {
    function session($key = null)
    {
        if ($key !== null) {
            return Session::get($key);
        }

        return new Session();
    }
}


if(!function_exists('getTable')) {
    function getTable($get_class)
    {
        // Get only the class name if namespace is present
        if (str_contains($get_class, '\\')) {
            $parts = explode('\\', $get_class);
            $class = end($parts);
        } else {
            $class = $get_class;
        }

        // Convert CamelCase to snake_case
        $snake = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $class));

        return $snake;
    }
}

if(!function_exists('str_random')) {

    /**
     * @param int $length
     * @return string
     * @throws Exception
     */
    function str_random(int $length = 10): string
    {
        return Str::random($length);
    }
}

if(!function_exists('verifyCaptcha')) {

    /**
     * @Verify captcha with user input
     * @param $captcha
     * @return bool
     */
    function verifyCaptcha($captcha)
    {
        if (Session::has('captcha')) {

            $generatedCaptcha = Session::get('captcha');
            if (strtolower($generatedCaptcha) == strtolower($captcha)) {
                Session::forget('captcha');
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}


if (!function_exists('app')) {

    function app(?string $key = null, mixed $concrete = null): mixed
    {
        static $container;

        if (!$container) {
            $container = new App();
        }

        // Binding
        if ($key && $concrete !== null) {
            if ($concrete instanceof \Closure) {
                $container->bind($key, $concrete);
            } else {
                $container->singleton($key, $concrete);
            }
            return $concrete;
        }

        // Resolving
        if ($key) {
            return $container->make($key);
        }

        return $container;
    }
}

if(!function_exists('json')) {
    function json($data)
    {
        echo json_encode($data);
    }
}

if(!function_exists('csrf_token')) {

    /**
     * @return string
     * @throws Exception
     */
    function csrf_token()
    {
        return Form::token();
    }
}

if(!function_exists('method')) {

    /**
     * @param $type
     * @return string
     */
    function method($type): string
    {
        $method = Form::method($type);
        return '<input type="hidden" name="_method" value="'.$method.'">';
    }
}

if(!function_exists('csrf_field')) {

    /**
     * @return string
     * @throws Exception
     */
    function csrf_field()
    {
        $token = Form::token();
        return '<input type="hidden" name="csrf_token" value="'.$token.'">';
    }
}

if(!function_exists('abort')) {

    function abort($route)
    {
        $view = "errors/".$route;
        view($view);
        exit();
    }
}

if(!function_exists('home_url')) {

    function home_url()
    {
        return NotFound::get_home_url();
    }
}

if(!function_exists('getClientOriginalName')) {

    function getClientOriginalName($file)
    {
        return basename($file["name"]);
    }
}

if(!function_exists('getClientOriginalExtension')) {

    function getClientOriginalExtension($filename)
    {
        return strtolower(pathinfo($filename['name'],PATHINFO_EXTENSION));
    }
}

if(!function_exists('move')) {

    function move($file, $file_path, $allowed_types = ['jpg','jpeg','png','gif','pdf'], $max_size = 2097152) // 2MB
    {
        $ext = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
        $size = $file["size"] ?? 0;
        $filename = preg_replace('/[^a-zA-Z0-9-_\.]/','_', basename($file["name"]));
        $target = dirname($file_path) . DIRECTORY_SEPARATOR . $filename;
        if (!in_array($ext, $allowed_types)) {
            return false;
        }
        if ($size > $max_size) {
            return false;
        }
        if (move_uploaded_file($file["tmp_name"], $target)) {
            return $target;
        } else {
            return false;
        }
    }
}

if(!function_exists('delete_file')) {

    function delete_file($file_name)
    {
        if(file_exists($file_name)){
            unlink($file_name);
            return true;
        } else {
            return false;
        }
    }
}

if(!function_exists('secure_encrypt')) {
    /**
     * Securely encrypt a string using OpenSSL
     * @param string $data
     * @param string $key
     * @return string|false
     */
    function secure_encrypt($data, $key) {
        $ivlen = openssl_cipher_iv_length($cipher = "AES-128-CBC");
        $iv = openssl_random_pseudo_bytes($ivlen);
        $ciphertext = openssl_encrypt($data, $cipher, $key, 0, $iv);
        return base64_encode($iv . $ciphertext);
    }
}

if(!function_exists('secure_decrypt')) {
    /**
     * Securely decrypt a string using OpenSSL
     * @param string $data
     * @param string $key
     * @return string|false
     */
    function secure_decrypt($data, $key) {
        $c = base64_decode($data);
        $ivlen = openssl_cipher_iv_length($cipher = "AES-128-CBC");
        $iv = substr($c, 0, $ivlen);
        $ciphertext = substr($c, $ivlen);
        return openssl_decrypt($ciphertext, $cipher, $key, 0, $iv);
    }
}

if (!function_exists('config')) {
    /**
     * Get a config value using dot notation, e.g. config('database.db_username')
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function config($key, $default = null) {
        static $configs = [];

        $parts = explode('.', $key, 2);
        $file = $parts[0];
        $path = $parts[1] ?? null;

        $configPath = ROOT_PATH . "/config/{$file}.php"; // Use project root for config files
        
        // Load and cache config file
        if (!isset($configs[$file])) {
            if (file_exists($configPath)) {
                $configs[$file] = require $configPath;
            } else {
                $configs[$file] = [];
            }
        }

        // If only file requested
        if ($path === null) {
            return $configs[$file];
        }

        // Traverse nested config keys
        $value = $configs[$file];
        foreach (explode('.', $path) as $segment) {
            if (is_array($value) && array_key_exists($segment, $value)) {
                $value = $value[$segment];
            } else {
                return $default;
            }
        }

        return $value;
    }

    function makeView($view)
    {
        return str_replace('.', '/', $view);
    }

}

if (!function_exists('old')) {
    function old($key, $default = '') {
        if (Session::has('old')) {
            $old = Session::get('old');
            return isset($old[$key]) ? $old[$key] : $default;
        }
        return $default;
    }
}

if (!function_exists('e')) {
    /**
     * Escape HTML entities in a string.
     * @param string $value
     * @return string
     */
    function e($value)
    {
        if (is_null($value)) {
            return '';
        }

        // Convert scalars (int, float, bool) to string safely
        if (is_scalar($value)) {
            $value = (string) $value;
        }

        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }

}

if (!function_exists('raw')) {

    function raw($value): string
    {
        return html_entity_decode($value);
    }
}

if (!function_exists('home')) {
    /**
     * Escape HTML entities in a string.
     * @param string $value
     * @return string
     */
    function home(): string
    {
        return RouteServiceProvider::HOME;
    }
}

if (!function_exists('route')) {
    /**
     * Generate a URL for a named route
     * @param string $name
     * @param array $parameters
     * @return string
     */
    function route(string $name, array $parameters = []): string
    {
        return Route::getNamedRoute($name, $parameters);
    }
}

if (!function_exists('collect')) {
    /**
     * @param $items
     * @return Collection
     */
    function collect($items): Collection
    {
        return new Collection($items);
    }
}

if (!function_exists('singular')) {
    /**
     * @param string $word
     * @return string
     */
    function singular(string $word): string
    {
        return Str::plural($word);
    }
}

if (!function_exists('request')) {
    /**
     * Get the current Request instance or input item by key.
     *
     * @param string|null $key
     * @param mixed|null $default
     * @return mixed
     */
    function request(string $key = null, mixed $default = null): mixed
    {
        static $instance = null;

        if ($instance === null) {
            $instance = new Request();
        }

        if ($key === null) {
            return $instance;
        }

        return $instance->input($key) ?? $default;
    }

}
