<?php


namespace Application\Controllers;

use Application\RendererInterface;
use Application\Transactions\FeedbackTransaction;
use Application\Transactions\UsersTransactions;
use Psr\Http\Message\ServerRequestInterface;

class AdminFeedbackController extends AbstractController
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