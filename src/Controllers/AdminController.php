<?php


namespace Application\Controllers;


use Application\Models\Admin;
use Application\RendererInterface;
use Application\Repositories\AdminTransaction;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class AdminController extends AbstractController
{
    private $transaction;
    private $request;
    private $session;
    private $renderer;

    public function __construct(AdminTransaction $transaction, ServerRequestInterface $request, Session $session, RendererInterface $renderer)
    {
        $this->transaction = $transaction;
        $this->request = $request;
        $this->session = $session;
        $this->renderer = $renderer;
    }

    public function login()
    {
        $redirect = null;

        if ($this->request->getMethod() === 'POST') {
            $input = $this->request->getParsedBody();
            $adminModel = new Admin();
            $redirect = $adminModel->login($input['username'], $input['password']);
            $this->session->set('alogin', $input['username']);
        }

        // Render a template
        return $this->renderer->render('admin/index', compact('redirect'));
    }

    public function changePassword()
    {
        $this->authenticated();

        $msg = null;
        $error = null;

        if($this->request->getMethod() === 'POST') {
            $input = $this->request->getParsedBody();
            if ($this->transaction->submitChangePassword($this->session->set('alogin'), $input['password'], $input['newpassword'])) {
                $msg = "Your Password succesfully changed";
            } else {
                $error =  "Your current password is not valid.";
            }
        }

        return $this->renderer->render('admin/change-password', compact('msg', 'error'));
    }

    public function profile()
    {
        $this->authenticated();

        $msg = null;
        if ($this->request->getMethod() === 'POST') {
            $input = $this->request->getParsedBody();

            $this->transaction->submitUpdateAdminUpdateUsernameAndPassword($input['name'], $input['email']);
            $msg = "Information Updated Successfully";
        }

        $result = $this->transaction->getAll();
        $cnt = 1;

        return $this->renderer->render('admin/profile', compact('result', 'cnt', 'name', 'email', 'msg'));
    }
}