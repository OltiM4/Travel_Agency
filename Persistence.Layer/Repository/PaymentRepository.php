<?php

class PaymentRepository implements IRepository
{
    private $context;

    public function __construct($context)
    {
        $this->context = $context;
    }

    public function getAllPayments()
    {
        return $this->context->query("SELECT * FROM payments");
    }

    public function getPaymentById($id)
    {
        return $this->context->query("SELECT * FROM payments WHERE id = ?", [$id]);
    }

    public function addPayment($payment)
    {
        return $this->context->execute("INSERT INTO payments (user_id, amount, payment_method, payment_date) VALUES (?, ?, ?, ?)", [$payment->user_id, $payment->amount, $payment->payment_method, $payment->payment_date]);
    }

    public function updatePayment($payment)
    {
        return $this->context->execute("UPDATE payments SET user_id = ?, amount = ?, payment_method = ?, payment_date = ? WHERE id = ?", [$payment->user_id, $payment->amount, $payment->payment_method, $payment->payment_date, $payment->id]);
    }

    public function deletePayment($id)
    {
        return $this->context->execute("DELETE FROM payments WHERE id = ?", [$id]);
    }
}
