<?php

final class CallsController extends BaseController {
    public static $view = 'calls';

    const PAGE_LIST = 'list';

	public function goHome($forceRefresh = false) {
        $this->currentAction = self::PAGE_LIST;

        if ($this->CurrentUser->admin)
            $data = Call::getAllCalls();
        else
            $data = Call::getUserCalls($this->CurrentUser->id);

        $PageContent = new PageContent(static::$view,
        							   'Ligações',
        							   $data,
        							   true,
        							   true);

        $this->setupMenu($PageContent);                                                                         
        self::loadPage($PageContent);
    }

    public function setupMenu(PageContent &$PageContent) {
        switch ($this->currentAction) {            
            case self::PAGE_LIST:
            default:
                $PageContent->menu[] = new Tab(true, 'Lista', self::PAGE_LIST, static::$view);
            break;
        }

        $this->setupNavigator($PageContent);
    }

    public function register($args) {
        $RegisterCall = new Call();
        $canRegister  = true;

        foreach($RegisterCall->getRequiredFields() as $property => $description) {
            if (empty($args[$property])) {
                new Alert("Campo '$description' é obrigatório", Alert::WARNING);
                $canRegister = false;
            }
            else {
                $RegisterCall->$property = $args[$property];
            }
        }

        if (!$canRegister || !$RegisterCall->register()) 
            new Alert(Alert::MSG_CALL_REGISTERED_FAIL, Alert::ERROR);
        else
            new Alert(Alert::MSG_CALL_REGISTERED, Alert::SUCCESS);

        return true;
    }

    public function finishCall($args) {
        if (empty($args['resolution'])) {
            new Alert('Por gentileza informe a resolução do atendimento para poder concluí-lo.', Alert::ERROR);
        }
        else {
            $Call = new Call($args['callId']);

            if ($Call->finish($args['resolution'])) new Alert(Alert::MSG_CALL_FINISHED, Alert::SUCCESS);
            else                                    new Alert(Alert::MSG_CALL_INVALID, Alert::ERROR);
        }

        return true;
    }
}