<?php

namespace App\Handlers\Technograd\Version1;

use App\Common\AbstractSoapHandler;
use App\Documents\Regions;
use App\Documents\Workers;

class MainSoapService extends AbstractSoapHandler
{
    public function getRegions()
    {
        $dm = $this->getDocumentManager();

        /**@var Regions $regions */
        $regions = $dm->getRepository(Regions::class)->findAll();

        return $regions;
    }

    public function getTechList()
    {
        //@formatter:off
        $response = [
            ['TECH_ID' => 241,  'TECH_NAME' => 'CTV'],
            ['TECH_ID' => 221,  'TECH_NAME' => 'DECT'],
            ['TECH_ID' => 104,  'TECH_NAME' => 'FTTx'],
            ['TECH_ID' => 281,  'TECH_NAME' => 'INDT'],
            ['TECH_ID' => 447,  'TECH_NAME' => 'MVNO'],
            ['TECH_ID' => 101,  'TECH_NAME' => 'PSTN'],
            ['TECH_ID' => 341,  'TECH_NAME' => 'Radio'],
            ['TECH_ID' => 103,  'TECH_NAME' => 'SHDSL'],
            ['TECH_ID' => 445,  'TECH_NAME' => 'UMTS'],
            ['TECH_ID' => 261,  'TECH_NAME' => 'WiFi'],
            ['TECH_ID' => 270,  'TECH_NAME' => 'WiMAX'],
            ['TECH_ID' => 102,  'TECH_NAME' => 'xDSL'],
            ['TECH_ID' => 105,  'TECH_NAME' => 'xPON'],
            ['TECH_ID' => 484,  'TECH_NAME' => 'Аналоговый домофон'],
            ['TECH_ID' => 271,  'TECH_NAME' => 'БШПД'],
            ['TECH_ID' => 405,  'TECH_NAME' => 'Комбинированная'],
            ['TECH_ID' => 446,  'TECH_NAME' => 'ОТТ'],
            ['TECH_ID' => 425,  'TECH_NAME' => 'Радиодоступ'],
            ['TECH_ID' => 463,  'TECH_NAME' => 'СКУД'],
            ['TECH_ID' => 483,  'TECH_NAME' => 'Цифровой домофон'],
        ];
        //@formatter:on

        return $response;
    }

    /**
     * @return array
     */
    public function getOrderTypeList()
    {
        //@formatter:off
        $response = [
            ['ORDER_TYPE_ID' => 121,    'ORDER_TYPE_NAME' => 'Инсталляция на площадке абонента'],
            ['ORDER_TYPE_ID' => 3,      'ORDER_TYPE_NAME' => 'Снятие'],
            ['ORDER_TYPE_ID' => 2,      'ORDER_TYPE_NAME' => 'Дополнительные работы'],
            ['ORDER_TYPE_ID' => 1526,   'ORDER_TYPE_NAME' => 'Устранение неисправности'],
            ['ORDER_TYPE_ID' => 1606,   'ORDER_TYPE_NAME' => 'Обследование'],
        ];
        //@formatter:on

        return $response;
    }

    /**
     * @return array
     */
    public function getServiceTypeList()
    {
        //@formatter:off
        $response = [
            ['SERVICE_TYPE_ID' => 'Line',               'SERVICE_TYPE_NAME' => 'Линия'],
            ['SERVICE_TYPE_ID' => 'CTV',                'SERVICE_TYPE_NAME' => 'Кабельное TV'],
            ['SERVICE_TYPE_ID' => 'Phone',              'SERVICE_TYPE_NAME' => 'Телефон'],
            ['SERVICE_TYPE_ID' => 'SIP',                'SERVICE_TYPE_NAME' => 'SIP'],
            ['SERVICE_TYPE_ID' => 'VPN',                'SERVICE_TYPE_NAME' => 'VPN'],
            ['SERVICE_TYPE_ID' => 'Internet',           'SERVICE_TYPE_NAME' => 'Интернет'],
            ['SERVICE_TYPE_ID' => 'add_subs_work',      'SERVICE_TYPE_NAME' => 'Прочие работы по настройке'],
            ['SERVICE_TYPE_ID' => 'IPTV',               'SERVICE_TYPE_NAME' => 'IPTV'],
            ['SERVICE_TYPE_ID' => 'Port',               'SERVICE_TYPE_NAME' => 'Порт СПД'],
            ['SERVICE_TYPE_ID' => 'customer_equipment', 'SERVICE_TYPE_NAME' => 'Оборудование'],
        ];
        //@formatter:on

        return $response;
    }

    /**
     * @return array
     */
    public function getOrderStatusList()
    {
        //@formatter:off
        $response = [
            ['ORDER_STATUS_ID' => '1',  'ORDER_STATUS_NAME' => 'Выполняется'],
            ['ORDER_STATUS_ID' => '4',  'ORDER_STATUS_NAME' => 'Выполнено'],
            ['ORDER_STATUS_ID' => '6',  'ORDER_STATUS_NAME' => 'Отменено'],
        ];
        //@formatter:on

        return $response;
    }

    /**
     * @param object $request
     *
     * @throws \SoapFault
     * @return array
     */
    public function checkWfmUser(object $request)
    {
        if (empty($request->Login)) {
            throw new \SoapFault('BF-01', 'Empty Login');
        }

        if (empty($request->Password)) {
            throw new \SoapFault('BF-01', 'Empty Password');
        }

        /**@var Workers $worker */
        $worker = $this->getDocumentManager()->getRepository(Workers::class)
            ->findOneBy(['login' => $request->Login, 'password' => $request->Password]);

        if (!$worker) {
            throw new \SoapFault('BF-01', 'Не верный логин или пароль');
        }

        return [
            'RegionId'    => $worker->getProfile()['RegionId'],
            'WfmWorkerId' => $worker->getWorkerId(),
            'MobilePhone' => $worker->getProfile()['ContactPhone'],
        ];
    }

    /**
     * @param object $request
     *
     * @throws \SoapFault
     * @return array
     */
    public function workerChangePhone(object $request)
    {
        if (empty($request->WORKER_ID)) {
            throw new \SoapFault('BF-01', 'Empty WORKER_ID');
        }

        if (empty($request->PHONE)) {
            throw new \SoapFault('BF-01', 'Empty PHONE');
        }

        return [];
    }

    /**
     * @param object $request
     *
     * @throws \SoapFault
     * @return array
     */
    public function getWorkerProfile(object $request): array
    {
        /**@var Workers $worker */
        $worker = $this->getDocumentManager()->getRepository(Workers::class)
            ->findOneBy(['worker_id' => (int)$request->WorkerId]);

        if (!$worker) {
            throw new \SoapFault('1', 'Данный WORKER_ID в системе не найден.');
        }


        return $worker->getProfile();
    }

    /**
     * @return array
     */
    public function getOrders()
    {
        $arOrders = $this->data['technograd']['orders'];

        //ToDo: реализовать логику фильтра по нарядам

        return $arOrders;
    }
}