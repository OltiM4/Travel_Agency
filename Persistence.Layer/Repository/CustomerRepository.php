<?php

class CustomerRepository implements IRepository
{
    private $context;

    public function __construct($context)
    {
        $this->context = $context;
    }

    public function getCustomerById($id)
    {
        return $this->context->query("SELECT * FROM customers WHERE id = ?", [$id]);
    }

    public function getAllCustomers()
    {
        return $this->context->query("SELECT * FROM customers");
    }

    public function addCustomer($customer)
    {
        return $this->context->execute("INSERT INTO customers (name, email, phone) VALUES (?, ?, ?)", [$customer->name, $customer->email, $customer->phone]);
    }

    public function updateCustomer($customer)
    {
        return $this->context->execute("UPDATE customers SET name = ?, email = ?, phone = ? WHERE id = ?", [$customer->name, $customer->email, $customer->phone, $customer->id]);
    }

    public function deleteCustomer($id)
    {
        return $this->context->execute("DELETE FROM customers WHERE id = ?", [$id]);
    }
}
