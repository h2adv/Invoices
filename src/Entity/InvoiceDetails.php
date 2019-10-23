<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InvoiceDetailsRepository")
 */
class InvoiceDetails
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Invoice", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $invoice_id;

    /**
     * @ORM\Column(type="text")
     */
    private $invoice_description;

    /**
     * @ORM\Column(type="integer")
     */
    private $invoice_quantity;

    /**
     * @ORM\Column(type="decimal", precision=12, scale=2)
     */
    private $invoice_amount;

    /**
     * @ORM\Column(type="decimal", precision=12, scale=2)
     */
    private $invoice_vat;

    /**
     * @ORM\Column(type="decimal", precision=12, scale=2)
     */
    private $invoice_total;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInvoiceId(): ?Invoice
    {
        return $this->invoice_id;
    }

    public function setInvoiceId(Invoice $invoice_id): self
    {
        $this->invoice_id = $invoice_id;

        return $this;
    }

    public function getInvoiceDescription(): ?string
    {
        return $this->invoice_description;
    }

    public function setInvoiceDescription(string $invoice_description): self
    {
        $this->invoice_description = $invoice_description;

        return $this;
    }

    public function getInvoiceQuantity(): ?int
    {
        return $this->invoice_quantity;
    }

    public function setInvoiceQuantity(int $invoice_quantity): self
    {
        $this->invoice_quantity = $invoice_quantity;

        return $this;
    }

    public function getInvoiceAmount(): ?string
    {
        return $this->invoice_amount;
    }

    public function setInvoiceAmount(string $invoice_amount): self
    {
        $this->invoice_amount = $invoice_amount;

        return $this;
    }

    public function getInvoiceVat(): ?string
    {
        return $this->invoice_vat;
    }

    public function setInvoiceVat(string $invoice_vat): self
    {
        $this->invoice_vat = $invoice_vat;

        return $this;
    }

    public function getInvoiceTotal(): ?string
    {
        return $this->invoice_total;
    }

    public function setInvoiceTotal(string $invoice_total): self
    {
        $this->invoice_total = $invoice_total;

        return $this;
    }
}
