<?php

include_once 'IUnitOfWork.php';

class UnitOfWork implements IUnitOfWork {
    private $context;
    private $repositories = [];

    public function __construct() {
        $this->context = DConnection::getConnection();
    }

    public function getContext() {
        return $this->context;
    }

    public function getRepository($entity) {
        if (!isset($this->repositories[$entity])) {
            $this->repositories[$entity] = new $entity($this->context);
        }
        return $this->repositories[$entity];
    }

    public function saveChanges() {
        try {
            $this->context->beginTransaction();
            $this->context->commit();
        } catch (Exception $e) {
            $this->context->rollBack();
            throw $e;
        }
    }

    public function saveChangesAsync(){ 
        return $this->saveChanges();
    }

    public function dispose() {
        $this->context = null;
    }
}

$unitOfWork = new UnitOfWork();

$transactionRepo = $unitOfWork->getRepository('Transaction');
$paymentRepo = $unitOfWork->getRepository('Payment');
$userRepo = $unitOfWork->getRepository('User');
$invoiceRepo = $unitOfWork->getRepository('Invoice');
$paymentGatewayRepo = $unitOfWork->getRepository('PaymentGateway');

?>