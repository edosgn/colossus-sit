<?php 

namespace AppBundle\services;
use Doctrine\ORM\EntityManager;


class SoapService
{
    protected $em;

    function __construct(EntityManager $em) {
        $this->em = $em;
    }

    public function getBill($billRequest)
    {
        if(isset($billRequest->BillRequest->InvoiceId)) {
            $factura = $this->em->getRepository('JHWEBFinancieroBundle:FroFactura')->findOneBy(
                array(
                    'numero' => $billRequest->BillRequest->InvoiceId,
                    'activo' => true
                )
            );

            if(!$factura) {
                $billResponse = ['BillResponse' => [
                        'Status' => '82',
                        'RequestId' => $billRequest->BillRequest->RequestId,
                        'Message' => 'Factura no existe',
                        'InvoiceId' => $billRequest->BillRequest->InvoiceId
                    ]
                ];
            } else {
                $fechaActual = new \Datetime();

                if($fechaActual > $factura->getFechaVencimiento()) {
                    $billResponse = ['BillResponse' => [
                            'Status' => '83',
                            'RequestId' => $billRequest->BillRequest->RequestId,
                            'Message' => 'Factura vencida',
                            'InvoiceId' => $billRequest->BillRequest->InvoiceId,
                        ]
                    ];
                } else {
                    if ($factura->getEstado() == 'PAGADA') {
                        $billResponse = ['BillResponse' => [
                                'Status' => '84',
                                'RequestId' => $billRequest->BillRequest->RequestId,
                                'Message' => 'Factura pagada',
                                'InvoiceId' => $billRequest->BillRequest->InvoiceId
                            ]
                        ];
                    } else{
                        $billResponse = ['BillResponse' => [
                                'Status' => '0',
                                'RequestId' => $billRequest->BillRequest->RequestId,
                                'Message' => 'Fue exitoso',
                                'InvoiceId' => $billRequest->BillRequest->InvoiceId,
                                'Invoices' => [
                                    'InvoiceId' => $factura->getNumero(),
                                    'TotalValue' => $factura->getValorNeto(),
                                    'ExpirationDate' => $factura->getFechaVencimiento()->format('c'),
                                    'EndPaymentDate' => $factura->getFechaVencimiento()->format('c'),
                                ]
                            ]
                        ];
                    }
                }

            }
        } else {
            $billResponse = ['BillResponse' => [
                    'Status' => '1',
                    'RequestId' => $billRequest->BillRequest->RequestId,
                    'Message' => 'Error inesperado',
                    'InvoiceId' => $billRequest->BillRequest->InvoiceId
                ]
            ];
        }

        return $billResponse;
    }

    public function sendPmtNotification($pmtNotificationRequest)
    {
        /* $pmtNotificationResponse = ['PmtNotificationResponse' => [
                'Status' => '0',
                'RequestId' => $pmtNotificationRequest->PmtNotificationRequest->RequestId,
                'Message' => 'Fue exitoso',
                'PartnerAuthCode' => $pmtNotificationRequest->PmtNotificationRequest->PaidInvoices->BankAuthCode
            ]
        ]; */

        if(isset($pmtNotificationRequest->PmtNotificationRequest->PaidInvoices->InvoiceId)) {
            $factura = $this->em->getRepository('JHWEBFinancieroBundle:FroFactura')->findOneBy(
                array(
                    'numero' => $pmtNotificationRequest->PmtNotificationRequest->PaidInvoices->InvoiceId,
                    'activo' => true
                )
            );

            if(!$factura) {
                $pmtNotificationResponse = ['PmtNotificationResponse' => [
                        'Status' => '82',
                        'RequestId' => $pmtNotificationRequest->PmtNotificationRequest->RequestId,
                        'Message' => 'Factura no existe',
                        'PartnerAuthCode' => $pmtNotificationRequest->PmtNotificationRequest->PaidInvoices->BankAuthCode
                        ]
                    ];
                } else {
                    $fechaActual = new \Datetime();
                    
                    if($fechaActual > $factura->getFechaVencimiento()) {
                        $factura->setEstado('VENCIDA');

                        $this->em->flush();

                        $pmtNotificationResponse = ['PmtNotificationResponse' => [
                            'Status' => '83',
                            'RequestId' => $pmtNotificationRequest->PmtNotificationRequest->RequestId,
                            'Message' => 'Factura vencida',
                            'PartnerAuthCode' => $pmtNotificationRequest->PmtNotificationRequest->PaidInvoices->BankAuthCode
                        ]
                    ];
                } else {
                    if ($factura->getEstado() == 'PAGADA') {
                        $pmtNotificationResponse = ['PmtNotificationResponse' => [
                                'Status' => '84',
                                'RequestId' => $pmtNotificationRequest->PmtNotificationRequest->RequestId,
                                'Message' => 'Factura pagada',
                                'PartnerAuthCode' => $pmtNotificationRequest->PmtNotificationRequest->PaidInvoices->BankAuthCode
                            ]
                        ];
                    } else{
                        $fechaString = $pmtNotificationRequest->PmtNotificationRequest->InqDate;
                        $fechaFactura = new \DateTime($fechaString);

                        $factura->setFechaPago($fechaFactura);
                        $factura->setHoraPago($fechaFactura);
                        
                        $factura->setEstado('PAGADA');

                        $this->em->flush();

                        $pmtNotificationResponse = ['PmtNotificationResponse' => [
                                'Status' => '0',
                                'RequestId' => $pmtNotificationRequest->PmtNotificationRequest->RequestId,
                                'Message' => 'Fue exitoso',
                                'PartnerAuthCode' => $pmtNotificationRequest->PmtNotificationRequest->PaidInvoices->BankAuthCode
                            ]
                        ];
                    }
                }

            }
        } else {
            $pmtNotificationResponse = ['PmtNotificationResponse' => [
                    'Status' => '1',
                    'RequestId' => $pmtNotificationRequest->PmtNotificationRequest->RequestId,
                    'Message' => 'Error inesperado',
                    'PartnerAuthCode' => $pmtNotificationRequest->PmtNotificationRequest->PaidInvoices->BankAuthCode
                ]
            ];
        }

        return $pmtNotificationResponse;
    }

    public function sendPmtRollback($pmtRollbackRequest)
    {
        if($pmtRollbackRequest->PmtRollbackRequest->PaidInvoices->InvoiceId) {
            $factura = $this->em->getRepository('JHWEBFinancieroBundle:FroFactura')->findOneBy(
                array(
                    'numero' => $pmtRollbackRequest->PmtRollbackRequest->PaidInvoices->InvoiceId,
                    'activo' => true
                )
            );

            if(!$factura) {
                $pmtRollbackResponse = ['PmtRollbackResponse' => [
                    'Status' => '1',
                    'RequestId' => $pmtRollbackRequest->PmtRollbackRequest->RequestId,
                    'Message' => 'Error al reversar',
                    'PartnerAuthCode' => $pmtRollbackRequest->PmtRollbackRequest->PaidInvoices->BankAuthCode
                ]];
            } else {
                if($factura->getEstado() == 'PAGADA') {
                    $factura->setEstado('PENDIENTE');

                    $this->em->flush();

                    $pmtRollbackResponse = ['PmtRollbackResponse' => [
                        'Status' => '0',
                        'RequestId' => $pmtRollbackRequest->PmtRollbackRequest->RequestId,
                        'Message' => 'Fue exitoso',
                        'PartnerAuthCode' => $pmtRollbackRequest->PmtRollbackRequest->PaidInvoices->BankAuthCode
                    ]];
                } else {
                   $pmtRollbackResponse = ['PmtRollbackResponse' => [
                        'Status' => '1',
                        'RequestId' => $pmtRollbackRequest->PmtRollbackRequest->RequestId,
                        'Message' => 'Error al reversar',
                        'PartnerAuthCode' => $pmtRollbackRequest->PmtRollbackRequest->PaidInvoices->BankAuthCode
                    ]]; 
                }
            }
        } else {
            $pmtRollbackResponse = ['PmtRollbackResponse' => [
                'Status' => '1',
                'RequestId' => $pmtRollbackRequest->PmtRollbackRequest->RequestId,
                'Message' => 'Error al reversar',
                'PartnerAuthCode' => $pmtRollbackRequest->PmtRollbackRequest->PaidInvoices->BankAuthCode
            ]]; 
        }
        return $pmtRollbackResponse;
    }
}