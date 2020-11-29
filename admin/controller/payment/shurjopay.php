<?php

/**
 * Created by PhpStorm.
 * User: nadim
 * Date: 5/9/16
 * Time: 10:43 AM
 */
class ControllerPaymentShurjopay extends Controller {
    private $error = array();

    public function index() {
        $this->language->load('payment/shurjopay');
        $this->document->setTitle('Shurjopay Payment Method Configuration');
        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
            $this->model_setting_setting->editSetting('shurjopay', $this->request->post);
            $this->session->data['success'] = 'Saved.';
            $this->response->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
        }

        $data['heading_title'] = $this->language->get('heading_title');
        $data['entry_text_config_one'] = $this->language->get('entry_text_config_one');
        $data['entry_username'] = $this->language->get('entry_username');
        $data['entry_password'] = $this->language->get('entry_password');
        $data['entry_uniq_transaction_key'] = $this->language->get('entry_uniq_transaction_key');
        $data['entry_userIP'] = $this->language->get('entry_userIP');
        $data['entry_paymentOption'] = $this->language->get('entry_paymentOption');
        $data['entry_userIP'] = $this->language->get('entry_userIP');
        $data['entry_returnUrl'] = $this->language->get('entry_returnUrl');
        $data['entry_status'] = $this->language->get('entry_status');
        $data['entry_text_config_two'] = $this->language->get('text_config_two');
        $data['button_save'] = $this->language->get('text_button_save');
        $data['button_cancel'] = $this->language->get('text_button_cancel');
        $data['entry_order_status'] = $this->language->get('entry_order_status');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');
        $data['entry_status'] = $this->language->get('entry_status');

        $data['action'] = $this->url->link('payment/shurjopay', 'token=' . $this->session->data['token'], 'SSL');
        $data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');

        if (isset($this->request->post['text_config_one'])) {
            $data['text_config_one'] = $this->request->post['text_config_one'];
        } else {
            $data['text_config_one'] = $this->config->get('text_config_one');
        }

        if (isset($this->request->post['text_config_two'])) {
            $data['text_config_two'] = $this->request->post['text_config_two'];
        } else {
            $data['text_config_two'] = $this->config->get('text_config_two');
        }

        if (isset($this->request->post['text_config_one'])) {
            $data['shurjopay_status'] = $this->request->post['shurjopay_status'];
        } else {
            $data['shurjopay_status'] = $this->config->get('shurjopay_status');
        }

        if (isset($this->request->post['shurjopay_uniq_transaction_key'])) {
            $data['shurjopay_uniq_transaction_key'] = $this->request->post['shurjopay_uniq_transaction_key'];
        } else {
            $data['shurjopay_uniq_transaction_key'] = $this->config->get('shurjopay_uniq_transaction_key');
        }

        if (isset($this->request->post['shurjopay_userIP'])) {
            $data['shurjopay_uniq_transaction_key'] = $this->request->post['shurjopay_uniq_transaction_key'];
        } else {
            $data['shurjopay_uniq_transaction_key'] = $this->config->get('shurjopay_uniq_transaction_key');
        }

        if (isset($this->request->post['shurjopay_paymentOption'])) {
            $data['shurjopay_paymentOption'] = $this->request->post['shurjopay_paymentOption'];
        } else {
            $data['shurjopay_paymentOption'] = $this->config->get('shurjopay_paymentOption');
        }
        if (isset($this->request->post['shurjopay_returnUrl'])) {
            $data['shurjopay_returnUrl'] = $this->request->post['shurjopay_returnUrl'];
        } else {
            $data['shurjopay_returnUrl'] = $this->config->get('shurjopay_returnUrl');
        }

        if (isset($this->request->post['shurjopay_username'])) {
            $data['shurjopay_username'] = $this->request->post['shurjopay_username'];
        } else {
            $data['shurjopay_username'] = $this->config->get('shurjopay_username');
        }

        if (isset($this->request->post['shurjopay_password'])) {
            $data['shurjopay_password'] = $this->request->post['shurjopay_password'];
        } else {
            $data['shurjopay_password'] = $this->config->get('shurjopay_password');
        }
        if (isset($this->request->post['shurjopay_userIP'])) {
            $data['shurjopay_userIP'] = $this->request->post['shurjopay_userIP'];
        } else {
            $data['shurjopay_userIP'] = $this->config->get('shurjopay_userIP');
        }


        if (isset($this->request->post['shurjopay_order_status_id'])) {
            $data['shurjopay_order_status_id'] = $this->request->post['shurjopay_order_status_id'];
        } else {
            $data['shurjopay_order_status_id'] = $this->config->get('shurjopay_order_status_id');
        }

        $this->load->model('localisation/order_status');
        $data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
        $this->template = 'payment/shurjopay.tpl';

        $this->children = array(
            'common/header',
            'common/footer'
        );
        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        //$this->response->setOutput($this->render());
        $this->response->setOutput($this->load->view('payment/shurjopay.tpl', $data));
    }
}