<?php defined('WPINC') || exit; ?>
<style type="text/css">
    .form-wrap {
        margin: 0 5px;
    }

    .form-wrap input[type=text] {
        width: 120px;
    }

    .form-wrap select {
        vertical-align: baseline;
    }

    .payment-description ul {
        list-style: inherit;
        padding-left: 40px;
    }

    .invoice-tablets-blocks {
        /*font-family: OpenSans;*/
    }

    .invoice-title-block {
        font-size: 17px;
        font-weight: bold;
    }

    .invoice-table-block td,
    .invoice-table-block th {
        font-size: 13px;
        font-weight: normal;
        text-align: start;
        padding-right: 15px;

    }

    .invoice-table-block .th-bold {
        font-weight: bold;
    }

    .invoice-table-block table {
        width: 100%;
    }

    .invoice-table-block td:nth-of-type(1n){
        width: 8%;
        /*padding: 0 15px;*/
    }
    .invoice-table-block td input{
        width: 100px;
        margin-right: 15px;
    }
    .invoice-table-block td button{
        background: #2271b1;
        color: #ffffff;
        border: unset;
        border-radius: 3px;
        padding: 0 15px;
    }

    .invoice-table-block td form{
        display: flex;
        /*padding: 0 15px;*/
    }

    .am-diff-block,
    .dbc-diff-block,
    .sm-diff-block,
    .risks-diff-block{
        border: 1px solid #c3c4c7;
        box-shadow: 0 1px 1px rgba(0, 0, 0, 0.4);
        background: #fff;
        margin: 25px 0;
    }

    .invoice-title-block h4{
        margin: 15px 10px;
    }
    .invoice-table-block{
        margin: 15px 10px;
    }
    .risks-diff-title-block h4{
        width: max-content;
        display: inline-block;
    }
    .risks-diff-title-block span{
        font-weight: normal;
        font-size: 17px;
    }

</style>
<div class="wrap invoice-tablets-blocks">

    <div style="align-items:center;justify-content:space-between;flex-wrap:wrap;margin-bottom:.55rem">
        <form style="display:flex;flex-wrap:wrap;align-items:end;flex:1">
            <h1 style="padding:9px 9px 0 0"><?php _e('Zorgportal &rsaquo; Invoices &rsaquo; Payments', 'zorgportal'); ?></h1>

            <?php foreach ($_GET as $arg => $value) : ?>
                <input type="hidden" name="<?php echo esc_attr($arg); ?>" value="<?php echo esc_attr($value); ?>"/>
            <?php endforeach; ?>

            <div class="form-wrap">
                <label for="dbc_code">DBC Code</label>
                <input id="dbc_code" type="text" name="dbc_code" value="<?php echo esc_attr($_GET['dbc_code'] ?? null); ?>" placeholder="<?php esc_attr_e('Search', 'zorgportal'); ?>"/>
                <!--select id="dbc_code" name="dbc_code" style="margin-left:2px">
                    <option value=""><?php esc_attr_e('DBC Code', 'zorgportal'); ?></option>
                    <?php foreach ($dbc_codes as $dbc_code) : ?>
                        <option <?php selected($dbc_code == ($_GET['dbc_code'] ?? '')); ?>><?php echo esc_attr($dbc_code); ?></option>
                    <?php endforeach; ?>
                </select-->
            </div>

            <div class="form-wrap">
                <label for="margin_difference_min">Margin difference</label>
                <input id="margin_difference_min" type="text" name="margin_difference_min" value="<?php echo esc_attr($_GET['margin_difference_min'] ?? null); ?>"
                       placeholder="<?php esc_attr_e('€ 3,50', 'zorgportal'); ?>"/>
                <select id="margin_difference_min_type" name="margin_difference_min_type">
                    <option value="euro">€</option>
                    <option value="percent">%</option>
                </select>
            </div>
            <div class="form-wrap" style="padding: 5px 0;">to</div>
            <div class="form-wrap">
                <input id="margin_difference_max" type="text" name="margin_difference_max" value="<?php echo esc_attr($_GET['margin_difference_max'] ?? null); ?>"
                       placeholder="<?php esc_attr_e('€ 3,50', 'zorgportal'); ?>"/>
                <select id="margin_difference_max_type" name="margin_difference_max_type">
                    <option value="euro">€</option>
                    <option value="percent">%</option>
                </select>
            </div>
            <div class="form-wrap">
                <label for="status">Status</label>
                <select id="status" name="status">
                    <option value=""><?php esc_attr_e('Status', 'zorgportal'); ?></option>
                    <?php foreach ([
                                       \Zorgportal\Invoices::PAYMENT_STATUS_PAID    => __('Paid', 'zorgportal'),
                                       \Zorgportal\Invoices::PAYMENT_STATUS_DUE     => __('Open', 'zorgportal'),
                                       \Zorgportal\Invoices::PAYMENT_STATUS_OVERDUE => __('Over-due', 'zorgportal'),
                                   ] as $status => $display) : ?>
                        <option value="<?php echo esc_attr($status); ?>" <?php selected($status == ($_GET['status'] ?? '')); ?>><?php echo esc_attr($display); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-wrap">
                <label for="invoice_number">Invoice Number</label>
                <input id="invoice_number" type="text" name="invoice_number" value="<?php echo esc_attr($_GET['invoice_number'] ?? null); ?>"
                       placeholder="<?php esc_attr_e('Search', 'zorgportal'); ?>"/>
            </div>

            <div class="form-wrap">
                <label for="search">Search</label>
                <input id="search" type="text" name="search" value="<?php echo esc_attr($_GET['search'] ?? null); ?>" placeholder="<?php esc_attr_e('Search', 'zorgportal'); ?>"/>
            </div>
            <div class="form-wrap">
                <input type="submit" class="button" value="<?php esc_attr_e('Filter', 'zorgportal'); ?>"/>
            </div>
        </form>

        <div class="payment-info">
            <h2>Payments info</h2>
            <div class="payment-description">
                <p>When ZorgPortal receives new Transactions from Exact Online, many more possibilities are enabled. From these transactions, we can do many thing.<br>
                    First is to check if the paid amounts are right and act on it.</p>
                <ul>
                    <li>Random amount differences; between -€ 30,00 and +€ 30,00; maybe the customer made a mistake.</li>
                    <li>Small differences; (maybe exact); between -€ 4,00 and + € 4,00</li>
                    <li>Different customers can pay same matching DBC/Insurer/Policy amounts, this increases the trust to change the amounts. Maybe the insurer updated it's policy.</li>
                    <li>Own Risk recognition; when the missing amount is exactly € 385,00 or € 885,00 - it could be a own-risk payment.</li>
                </ul>
                <p>Transactions also enables us to do Factoring; last-payment-date can show a report of invoices/customers to send template reminder emails, instruction emails, and
                    eventually collection agency emails.</p>
                <p>Second is that, when the final amount for a DBC/Insurer/Policy has been decided by the admin, Zorg-Portal can correct the invoices amounts in Exact so the systems are
                    in sync again. Also can create refund transactions, or a feature outside Exact; Payment Pages to send to customer.</p>
            </div>
        </div>

        <div class="am-diff-block">
            <div class="am-diff-title-block invoice-title-block">
                <h4><?php _e('Amount Difference', 'zorgportal') ?></h4>
            </div>
            <div class="am-diff-content-block invoice-table-block">
                <?php
                $invoicesFirst = \Zorgportal\Invoices::queryInvoicesForPaymentsPage('Amount Difference');
                ?>
                <h4 style="font-size: 17px; font-weight: bold;"><?php echo $invoicesFirst ? count($invoicesFirst) : '0';
                    _e(' items', 'zorgportal') ?></h4>
                <table>
                    <tr>
                        <th style="width: 4%;"><?php _e('Invoice id', 'zorgportal') ?></th>
                        <th><?php _e('Invoice Date', 'zorgportal') ?></th>
                        <th><?php _e('Customer Name', 'zorgportal') ?></th>
                        <th><?php _e('DBC Code', 'zorgportal') ?></th>
                        <th><?php _e('Insurer', 'zorgportal') ?></th>
                        <th><?php _e('Policy', 'zorgportal') ?></th>
                        <th><?php _e('Reimbursement', 'zorgportal') ?></th>
                        <th><?php _e('Actual Paid', 'zorgportal') ?></th>
                        <th class="th-bold"><?php _e('Difference', 'zorgportal') ?></th>
                        <th class="th-bold"><?php _e('Status', 'zorgportal') ?></th>
                        <th><?php _e('Paid date', 'zorgportal') ?></th>
                        <th><?php _e('Fetched date', 'zorgportal') ?></th>
                        <th><?php _e('New DBC Price', 'zorgportal') ?></th>
                        <th><?php _e('Action type', 'zorgportal') ?></th>
                    </tr>
                    <?php
                    foreach ($invoicesFirst ? $invoicesFirst : [] as $columnName => $value) {
                        $differentStatus = -$value->differents;
                        $different = abs($value->differents);
                        $invoiceData = date('d/m/Y',strtotime($value->DeclaratieDatum));
                        $paidData = date('d/m/Y',strtotime($value->SubtrajectStartdatum));
                        $fetchedData = date('d/m/Y',strtotime($value->SubtrajectEinddatum));
                        $status = $differentStatus > 0 ? __('Paid too much', 'zorgportal') : ($differentStatus < 0 ? __('Paid too less', 'zorgportal') : '');
                        $statusColor = $differentStatus > 0 ? 'green' : ($differentStatus < 0 ? 'red' : '');
                        ?>
                        <tr>
                            <td style="text-align: center ; color: #2271b1"><?php echo $value->id ?></td>
                            <td><?php echo $invoiceData ?></td>
                            <td style="color: #2271b1"><?php echo $value->DeclaratieDebiteurNaam ?></td>
                            <td style="color: #2271b1; font-weight: bold"><?php echo $value->SubtrajectDeclaratiecode ?></td>
                            <td><?php echo $value->ZorgverzekeraarNaam ?></td>
                            <td><?php echo $value->ZorgverzekeraarPakket ?></td>
                            <td><?php echo $value->ReimburseAmount ?></td>
                            <td style="color: red"><?php echo $value->DeclaratieBedrag ?></td>
                            <td style="color: <?php echo $statusColor ?>"><?php echo $different ?></td>
                            <td style="color: <?php echo $statusColor ?>"><?php echo $status ?></td>
                            <td><?php echo $paidData ?></td>
                            <td><?php echo $fetchedData ?></td>
                            <td>
                                <form>
                                    <input type="text" value="<?php echo $value->ReimburseAmount ?>">
                                    <button><?php _e('Save', 'zorgportal'); ?></button>
                                </form>
                            </td>
                            <td>
                                <form>
                                    <input type="text" value="<?php echo abs($different) ?>">
                                    <button ><?php echo $differentStatus > 0 ? __('Refound', 'zorgportal') : ($differentStatus < 0 ? __('Reminder', 'zorgportal') : ''); ?></button>
                                </form>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
            </div>

        </div>
        <div class="dbc-diff-block">
            <div class="dbc-diff-title-block invoice-title-block">
                <h4><?php _e('Same DBC Code recognition', 'zorgportal') ?></h4>
            </div>
            <div class="dbc-diff-content-block invoice-table-block">
                <?php
                $invoicesSecond = \Zorgportal\Invoices::queryInvoicesForPaymentsPage('Same DBC Code recognition');
                ?>
                <h4 style="font-size: 17px; font-weight: bold;"><?php echo $invoicesSecond ? count($invoicesSecond) : '0';
                    _e(' items', 'zorgportal') ?></h4>
                <table>
                    <tr>
                        <th style="width: 4%;"><?php _e('Invoice id', 'zorgportal') ?></th>
                        <th><?php _e('Invoice Date', 'zorgportal') ?></th>
                        <th><?php _e('Customer Name', 'zorgportal') ?></th>
                        <th><?php _e('DBC Code', 'zorgportal') ?></th>
                        <th><?php _e('Insurer', 'zorgportal') ?></th>
                        <th><?php _e('Policy', 'zorgportal') ?></th>
                        <th><?php _e('Reimbursement', 'zorgportal') ?></th>
                        <th><?php _e('Actual Paid', 'zorgportal') ?></th>
                        <th class="th-bold"><?php _e('Difference', 'zorgportal') ?></th>
                        <th class="th-bold"><?php _e('Status', 'zorgportal') ?></th>
                        <th><?php _e('Paid date', 'zorgportal') ?></th>
                        <th><?php _e('Fetched date', 'zorgportal') ?></th>
                        <th><?php _e('Action type', 'zorgportal') ?></th>
                    </tr>
                    <?php
                    foreach ($invoicesSecond ? $invoicesSecond : [] as $columnName => $value) {
                        $differentStatus = -$value->differents;
                        $different = abs($value->differents);
                        $invoiceData = date('d/m/Y',strtotime($value->DeclaratieDatum));
                        $paidData = date('d/m/Y',strtotime($value->SubtrajectStartdatum));
                        $fetchedData = date('d/m/Y',strtotime($value->SubtrajectEinddatum));
                        $status = $differentStatus > 0 ? __('Paid too much', 'zorgportal') : ($differentStatus < 0 ? __('Paid too less', 'zorgportal') : '');
                        $statusColor = $differentStatus > 0 ? 'green' : ($differentStatus < 0 ? 'red' : '');
                        ?>
                        <tr>
                            <td style="text-align: center; color: #2271b1"><?php echo $value->id ?></td>
                            <td><?php echo $invoiceData ?></td>
                            <td style="color: #2271b1"><?php echo $value->DeclaratieDebiteurNaam ?></td>
                            <td style="color: #2271b1; font-weight: bold"><?php echo $value->SubtrajectDeclaratiecode ?></td>
                            <td><?php echo $value->ZorgverzekeraarNaam ?></td>
                            <td><?php echo $value->ZorgverzekeraarPakket ?></td>
                            <td><?php echo $value->ReimburseAmount ?></td>
                            <td style="color: red"><?php echo $value->DeclaratieBedrag ?></td>
                            <td style="color: <?php echo $statusColor ?>"><?php echo $different ?></td>
                            <td style="color: <?php echo $statusColor ?>"><?php echo $status ?></td>
                            <td><?php echo $paidData ?></td>
                            <td><?php echo $fetchedData ?></td>
                            <td>
                                <form>
                                    <input type="text" value="<?php echo abs($different) ?>">
                                    <button><?php _e('Refound', 'zorgportal'); ?></button>
                                </form>
                            </td>

                        </tr>

                        <?php
                    }
                    ?>
                </table>
            </div>
        </div>
        <div class="sm-diff-block">
            <div class="sm-diff-title-block invoice-title-block">
                <h4><?php _e('Small amounts', 'zorgportal') ?></h4>
            </div>
            <div class="sm-diff-content-block invoice-table-block">
                <?php
                $invoicesThird = \Zorgportal\Invoices::queryInvoicesForPaymentsPage('Small amounts');
                ?>
                <h4 style="font-size: 17px; font-weight: bold;"><?php echo $invoicesThird ? count($invoicesThird) : '0';
                    _e(' items', 'zorgportal') ?></h4>
                <table>
                    <tr>
                        <th style="width: 4%;"><?php _e('Invoice id', 'zorgportal') ?></th>
                        <th><?php _e('Invoice Date', 'zorgportal') ?></th>
                        <th><?php _e('Customer Name', 'zorgportal') ?></th>
                        <th><?php _e('DBC Code', 'zorgportal') ?></th>
                        <th><?php _e('Insurer', 'zorgportal') ?></th>
                        <th><?php _e('Policy', 'zorgportal') ?></th>
                        <th><?php _e('Reimbursement', 'zorgportal') ?></th>
                        <th><?php _e('Actual Paid', 'zorgportal') ?></th>
                        <th class="th-bold"><?php _e('Difference', 'zorgportal') ?></th>
                        <th class="th-bold"><?php _e('Status', 'zorgportal') ?></th>
                        <th><?php _e('Paid date', 'zorgportal') ?></th>
                        <th><?php _e('Fetched date', 'zorgportal') ?></th>
                        <th><?php _e('New DBC Price', 'zorgportal') ?></th>
                        <th><?php _e('Action type', 'zorgportal') ?></th>
                    </tr>
                    <?php
                    foreach ($invoicesThird ? $invoicesThird : [] as $columnName => $value) {
                        $differentStatus = -$value->differents;
                        $different = abs($value->differents);
                        $invoiceData = date('d/m/Y',strtotime($value->DeclaratieDatum));
                        $paidData = date('d/m/Y',strtotime($value->SubtrajectStartdatum));
                        $fetchedData = date('d/m/Y',strtotime($value->SubtrajectEinddatum));
                        $status = $differentStatus > 0 ? __('Paid too much', 'zorgportal') : ($differentStatus < 0 ? __('Paid too less', 'zorgportal') : '');
                        $statusColor = $differentStatus > 0 ? 'green' : ($differentStatus < 0 ? 'red' : '');
                        ?>
                        <tr>
                            <td style="text-align: center;color: #2271b1"><?php echo $value->id ?></td>
                            <td><?php echo $invoiceData ?></td>
                            <td style="color: #2271b1"><?php echo $value->DeclaratieDebiteurNaam ?></td>
                            <td style="color: #2271b1; font-weight: bold"><?php echo $value->SubtrajectDeclaratiecode ?></td>
                            <td><?php echo $value->ZorgverzekeraarNaam ?></td>
                            <td><?php echo $value->ZorgverzekeraarPakket ?></td>
                            <td><?php echo $value->ReimburseAmount ?></td>
                            <td style="color: red"><?php echo $value->DeclaratieBedrag ?></td>
                            <td style="color: <?php echo $statusColor ?>"><?php echo $different ?></td>
                            <td style="color: <?php echo $statusColor ?>"><?php echo $status ?></td>
                            <td><?php echo $paidData ?></td>
                            <td><?php echo $fetchedData ?></td>
                            <td>
                                <form>
                                    <input type="text" value="<?php echo $value->ReimburseAmount ?>">
                                    <button><?php _e('Save', 'zorgportal'); ?></button>
                                </form>
                            </td>
                            <td>
                                <form>
                                    <input type="text" value="<?php echo abs($different) ?>">
                                    <button ><?php echo $differentStatus > 0 ? __('Refound', 'zorgportal') : ($differentStatus < 0 ? __('Reminder', 'zorgportal') : ''); ?></button>
                                </form>
                            </td>

                        </tr>

                        <?php
                    }

                    ?>
                </table>
            </div>

        </div>
        <div class="risks-diff-block">
            <div class="risks-diff-title-block invoice-title-block">
                <h4><?php _e('Own risks', 'zorgportal') ?></h4>
                <span><?php _e('When paid too less amounts are between € 385,00 - € 885,00 it could be because own risk', 'zorgportal'); ?></span>
            </div>
            <div class="risks-diff-content-block invoice-table-block">
                <?php
                $invoicesFourth = \Zorgportal\Invoices::queryInvoicesForPaymentsPage('Own Risks');
                ?>
                <h4 style="font-size: 17px; font-weight: bold;"><?php echo $invoicesFourth ? count($invoicesFourth) : '0';
                    _e(' items', 'zorgportal') ?></h4>
                <table>
                    <tr>
                        <th style="width: 4%;"><?php _e('Invoice id', 'zorgportal') ?></th>
                        <th><?php _e('Invoice Date', 'zorgportal') ?></th>
                        <th><?php _e('Customer Name', 'zorgportal') ?></th>
                        <th><?php _e('DBC Code', 'zorgportal') ?></th>
                        <th><?php _e('Insurer', 'zorgportal') ?></th>
                        <th><?php _e('Policy', 'zorgportal') ?></th>
                        <th><?php _e('Reimbursement', 'zorgportal') ?></th>
                        <th><?php _e('Actual Paid', 'zorgportal') ?></th>
                        <th class="th-bold"><?php _e('Difference', 'zorgportal') ?></th>
                        <th class="th-bold"><?php _e('Status', 'zorgportal') ?></th>
                        <th><?php _e('Paid date', 'zorgportal') ?></th>
                        <th><?php _e('Fetched date', 'zorgportal') ?></th>
                        <th><?php _e('Action type', 'zorgportal') ?></th>
                    </tr>
                    <?php
                    foreach ($invoicesFourth ? $invoicesFourth : [] as $columnName => $value) {
                        $differentStatus = -$value->differents;
                        $different = abs($value->differents);
                        $invoiceData = date('d/m/Y',strtotime($value->DeclaratieDatum));
                        $paidData = date('d/m/Y',strtotime($value->SubtrajectStartdatum));
                        $fetchedData = date('d/m/Y',strtotime($value->SubtrajectEinddatum));
                        $status = $differentStatus > 0 ? __('Paid too much', 'zorgportal') : ($differentStatus < 0 ? __('Paid too less', 'zorgportal') : '');
                        $statusColor = $differentStatus > 0 ? 'green' : ($differentStatus < 0 ? 'red' : '');
                        ?>
                        <tr>
                            <td style="text-align: center; color: #2271b1"><?php echo $value->id ?></td>
                            <td><?php echo $invoiceData ?></td>
                            <td style="color: #2271b1"><?php echo $value->DeclaratieDebiteurNaam ?></td>
                            <td style="color: #2271b1; font-weight: bold"><?php echo $value->SubtrajectDeclaratiecode ?></td>
                            <td><?php echo $value->ZorgverzekeraarNaam ?></td>
                            <td><?php echo $value->ZorgverzekeraarPakket ?></td>
                            <td><?php echo $value->ReimburseAmount ?></td>
                            <td style="color: red"><?php echo $value->DeclaratieBedrag ?></td>
                            <td style="color: <?php echo $statusColor ?>"><?php echo $different ?></td>
                            <td style="color: <?php echo $statusColor ?>"><?php echo $status ?></td>
                            <td><?php echo $paidData ?></td>
                            <td><?php echo $fetchedData ?></td>
                            <td>
                                <form>
                                    <input type="text" value="<?php echo abs($different) ?>">
                                    <button ><?php echo $differentStatus > 0 ? __('Refound', 'zorgportal') : ($differentStatus < 0 ? __('Reminder', 'zorgportal') : ''); ?></button>
                                </form>
                            </td>

                        </tr>

                        <?php
                    }

                    ?>
                </table>
            </div>

        </div>
    </div>

</div>
