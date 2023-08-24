<?php


namespace Zorgportal\Admin\Screen;


use Zorgportal\Invoices as Core;

class InvoicesPayments extends Screen
{
    public function init()
    {

    }

    public function render()
    {
        $query = [
            'search' => $_GET['search'] ?? '',
        ];

        if ( $dbc_code = ($_GET['dbc_code'] ?? '') ) {
            $query['SubtrajectDeclaratiecode'] = $dbc_code;
        }

        if ( is_numeric($status = ($_GET['status'] ?? '')) && in_array((int) $status, Core::PAYMENT_STATUSES) ) {
            if ( (int) $status == Core::PAYMENT_STATUS_DUE ) {
                $query['EoStatus_eq_or_null'] = (int) $status;
            } else {
                $query['EoStatus'] = (int) $status;
            }
        }

        return $this->renderTemplate('invoices-payments.php', array_merge(Core::query($query), [
            'nonce' => wp_create_nonce('zorgportal'),
            'dbc_codes' => Core::getAllDbcCodes(),
        ]));
    }

    public function scripts()
    {
        $base = trailingslashit(plugin_dir_url( $this->appContext->getPluginFile() ));
        wp_enqueue_style( 'zportal-codes', "{$base}src/assets/codes.css", [], $this->appContext::SCRIPTS_VERSION );
        wp_enqueue_script( 'zportal-codes', "{$base}src/assets/codes.js", ['jquery'], $this->appContext::SCRIPTS_VERSION, 1 );
    }
}