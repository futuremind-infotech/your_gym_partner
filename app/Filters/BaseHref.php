<?php
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class BaseHref implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // no-op
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        $body = $response->getBody();
        
        // Strip .php extensions and -req suffix from URLs
        $body = preg_replace('/(href|action|src)=(["\'])([^"\']*?)-req\.php(\?|["\'])/i', '$1=$2$3$4', $body);
        $body = preg_replace('/(href|action|src)=(["\'])([^"\']*?)\.php(\?|["\'])/i', '$1=$2$3$4', $body);
        $body = preg_replace('/(href|action|src)=(["\'])(?:\.\.\/)?actions\/([^"\']*?)(\?|["\'])/i', '$1=$2$3$4', $body);
        
        // Rewrite common relative asset paths like "../css/..." -> "css/..."
        $body = preg_replace_callback(
            '/(href|src)=("|\')\.\.\/(css|js|font-awesome|img|images|fonts)\/([^"\']+)("|\')/i',
            function ($m) {
                return $m[1] . '=' . $m[2] . $m[3] . '/' . $m[4] . $m[5];
            },
            $body
        );

        if (stripos($body, '<head') !== false && stripos($body, '<base ') === false) {
            $app = config('App');
            $base = rtrim($app->baseURL, '/') . '/';
            $insert = "\n    <base href=\"{$base}\">\n";
            $body = preg_replace('/<head(.*?)>/i', '<head$1>' . $insert, $body, 1);
            $response->setBody($body);
        }
    }
}
