<?php


namespace Plugin\BankTransfer;

class Boot
{
    public function init(): void
    {
        listen_hook_filter('service.payment.api.bank_transfer.data', function ($data) {
            $data['params'] = plugin_setting('bank_transfer');

            return $data;
        });
    }
}
