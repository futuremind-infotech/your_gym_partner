<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AdminAuth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Simple check for logged-in session. Adjust as needed.
        $session = session();
        if (! $session->get('isLoggedIn')) {
            // If not logged in, redirect to home/login
            return redirect()->to('/');
        }

        // Optionally check role
        if ($session->get('role') && $session->get('role') !== 'admin') {
            // If user is not admin, redirect to dashboard
            return redirect()->to('/');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Intentionally left blank
        return null;
    }
}
?>





















}    }        // no-op    {    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)    }        return null;        // Optionally, check role here if your app stores roles        }            return redirect()->to('/');        if (! $session->get('isLoggedIn')) {        $session = session();        // Simple admin authentication: redirect to login if not logged in    {    public function before(RequestInterface $request, $arguments = null){class AdminAuth implements FilterInterfaceuse CodeIgniter\Filters\FilterInterface;use CodeIgniter\HTTP\ResponseInterface;use CodeIgniter\HTTP\RequestInterface;namespace App\Filters;
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AdminAuth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Simple check for logged-in session. Adjust as needed.
        $session = session();
        if (! $session->get('isLoggedIn')) {
            // If not logged in, redirect to home/login
            return redirect()->to('/');
        }

        // Optionally check role
        if ($session->get('role') && $session->get('role') !== 'admin') {
            // If user is not admin, redirect to dashboard
            return redirect()->to('/');
        }

        // allow request to continue
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // no-op
    }
}
