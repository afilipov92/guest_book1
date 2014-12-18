<?php
interface IMessages{
    /**
     * сохраняет данные
     * @param array $msgData
     * @return mixed
     */
    public function saveMessage(array $msgData);

    /**
     * Возвращает данные для данной страницы
     * @param $pageNum
     * @param $pageSize
     * @return mixed
     */
    public function getItemsForPage($pageNum, $pageSize);

    /**
     * возвращает количество записей в базе данных иди файле
     * @return mixed
     */
    public function getAmountRecords();
}