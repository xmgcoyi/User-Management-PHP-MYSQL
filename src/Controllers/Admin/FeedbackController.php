<?php


namespace Application\Controllers\Admin;

use Application\Controllers\AbstractController;
use Application\Users\UsersTransactions;
use Application\FeedbackTransaction;
use Application\RendererInterface;
use Psr\Http\Message\ServerRequestInterface;

class FeedbackController extends AbstractController
{
    private $usersTransaction;
    private $feedbackTransaction;
    private $request;
    private $renderer;

    public function __construct(UsersTransactions $usersTransaction, FeedbackTransaction $feedbackTransaction, ServerRequestInterface $request, RendererInterface $renderer)
    {
        $this->usersTransaction = $usersTransaction;
        $this->feedbackTransaction = $feedbackTransaction;
        $this->request = $request;
        $this->renderer = $renderer;
    }

    public function feedback()
    {
        $this->authenticated();

        $msg = null;
        $get = $this->request->getQueryParams();

        if (isset($get['del'])) {
            $this->usersTransaction->deleteUserById();
            $msg = "Data Deleted successfully";
        }

        if (isset($get['unconfirm'])) {
            $this->usersTransaction->updateStatusUnConfirmed();

            $msg = "Changes Sucessfully";
        }

        if (isset($get['confirm'])) {
            $this->usersTransaction->updateStatusConfirmed();

            $msg = "Changes Sucessfully";
        }

        $this->feedbackTransaction->findAdmin();
        $results = $this->feedbackTransaction->getFeedback();
        $count = $this->feedbackTransaction->getTotal();
        $cnt = 1;

        return $this->renderer->render('admin/feedback', compact('msg', 'results', 'count', 'cnt'));
    }
}